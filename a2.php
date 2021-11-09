<?php
$_GET['case']=isset($_GET['case'])?htmlspecialchars($_GET['case']):NULL;
if($_GET['case']=='naemniki') {
	$titles=' | Наёмники';
} elseif($_GET['case']=='laboratory') {
	$titles=' | Лаборатория';
} elseif($_GET['case']==3) {
	$titles=' | Ресурсы';
} elseif($_GET['case']==4) {
	$titles=' | Имущество';
} elseif($_GET['case']==5) {
	$titles=' | Банк';
} else {
	$titles=FALSE;
}
$title='Чёрный рынок'.$titles.'';
require_once('system/up.php');
_Reg();

if ($set['block']==1) {
	header("Location: blok.php");
	exit();
} ?>
<div class="main">
<?php
switch($_GET['case']) {
	default:
	if ($set['logo'] == 'on') {
?>
		<img src="images/logotips/blackmarket.jpg" width="100%" alt="Чёрный рынок"/>
		<div class="mini-line"></div>
<?php
	}
?>
	<div class="menuList">
		<li>
			<a href="voentorg.php"><img src="images/icons/arrow.png" alt="*"/>Военторг</a>
		</li>
		<li>
			<a href="blackmarket.php?case=naemniki"><img src="images/icons/arrow.png" alt="*"/>Наемники</a>
		</li>
		<li>
			<a href="blackmarket.php?case=laboratory"><img src="images/icons/arrow.png" alt="*"/>Лаборатория</a>
		</li>
<?php
	break;

	case 'naemniki':
?>
	<div class="menuList">
		<li>
			<a href="blackmarket.php">
				<img src="images/icons/arrow.png" alt="*"/>Чёрный рынок
			</a>
		</li>
	</div>
	<div class="mini-line"></div>
<?php
	if(isset($_GET['log'])) {
		$sum=_NumFilter($_GET['log']);
		$naem=_NumFilter($_GET['naem']);
		if($sum>$set['gold']) {
			$_SESSION['err'] = 'Недостаточно золота!';
			header('Location: blackmarket.php?case=naemniki');
			exit();
		}
		$logi_text_naem = 'Куплен наемник '.$naem.' за '.$sum.' золота ';
		if($_GET['log']==10) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_naemniki` SET `time_up`='" . (time()+86400) . "', `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_naemnik`='" . $naem . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы наняли наёмника на 1 день!';
			header('Location: blackmarket.php?case=naemniki');
			exit();
		} elseif($_GET['log']==20) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_naemniki` SET `time_up`='" . (time()+259200) . "', `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_naemnik`='" . $naem . "' IMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы наняли наёмника на 3 дня!';
			header('Location: blackmarket.php?case=naemniki');
			exit();
		} elseif($_GET['log']==50) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_naemniki` SET `time_up`='" . (time()+604800) . "', `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_naemnik`='" . $naem . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы наняли наёмника на неделю!';
			header('Location: blackmarket.php?case=naemniki');
			exit();
		} else {
			$_SESSION['err'] = 'Ошибка найма наёмника!';
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','Ошибка покупки','1',NULL)");
			header('Location: blackmarket.php?case=naemniki');
			exit();
		}
	}
?>
	<div class="block_zero center">
		<span style="color: #9cc;">Хватит нанимать по объявлениям в газете.<br/>Найми профессионалов.</span>
	</div>
<?php
	$data=mysql_query("SELECT * FROM `naemniki` ORDER BY `id` ASC LIMIT 5");
	while($naemniki=mysql_fetch_assoc($data)) {
		$user_naemniki=_FetchAssoc('SELECT * FROM `user_naemniki` WHERE `id_user`="'.$user_id.'" AND `id_naemnik`="'.$naemniki['id'].'" LIMIT 1');
?>
<div class="mini-line"></div>
<table width="100%">
	<tr>
		<td width="40%">
			<img src="images/naemniki/<?=$naemniki['id'] ?>.jpg" style="border:1px solid #999;" alt="Наёмник">
		</td>
		<td valign="top">
			<b><span style="color: #9c9;"><?= $naemniki['name']; ?></span></b><br/>
			<small><?= $naemniki['opisanie'] ?></small>
		</td>
	</tr>
</table>
<div class="block_zero center">
	<span style="color: #f96;"><small><?=$naemniki['chto_daet']; ?><br/></small></span>
<?php
	$time =$user_naemniki['time_up'] - time();
		if($user_naemniki['status']==1) {
?>
</div>
<div class="dot-line"></div>
<div class="block_zero">Будет действовать:<span style="float: right;"><?= _DayTime($time) ?></span></div>
<?php
		} else {
?>
</div>
<div class="dot-line"></div>
<div class="block_zero center">
	<a class="btn" href="blackmarket.php?case=naemniki&log=10&naem=<?=$naemniki['id']; ?>">
		<span class="end">
			<span class="label">
				Нанять на день за <img src="images/icons/gold.png" alt="*" />10
			</span>
		</span>
	</a>
</div>
<div class="dot-line"></div>
<div class="block_zero center">
	<a class="btn" href="blackmarket.php?case=naemniki&log=20&naem=<?=$naemniki['id']; ?>">
		<span class="end">
			<span class="label">
				Нанять на 3 дня за <img src="images/icons/gold.png" alt="*" />20
			</span>
		</span>
	</a>
</div>
<div class="dot-line"></div>
<div class="block_zero center">
	<a class="btn" href="blackmarket.php?case=naemniki&log=50&naem=<?=$naemniki['id']; ?>">
		<span class="end">
			<span class="label">
				Нанять на неделю за <img src="images/icons/gold.png" alt="*" />50
			</span>
		</span>
	</a></center>
</div>
<?php
		}
	}
	break;

	case 'laboratory':
	if ($set['logo'] == 'on') {
?>
		<img src="images/logotips/laboratory.jpg" width="100%" alt="Лаборатория"/>
		<div class="mini-line"></div>
<?php
	}
?>
<div class="menuList">
	<li>
		<a href="blackmarket.php">
			<img src="images/icons/arrow.png" alt="*"/>Чёрный рынок
		</a>
	</li>
</div>
<div class="mini-line"></div><?php

$logi_text_naem = 'Куплен препарат ' . $lab . ' за ' . $sum . ' золота';
$prepar1 = _FetchAssoc("SELECT * FROM `laboratory` WHERE `id` = '1' LIMIT 1");
$prepar2 = _FetchAssoc("SELECT * FROM `laboratory` WHERE `id` = '2' LIMIT 1");
$prepar3 = _FetchAssoc("SELECT * FROM `laboratory` WHERE `id` = '3' LIMIT 1");
$prepar4 = _FetchAssoc("SELECT * FROM `laboratory` WHERE `id` = '4' LIMIT 1");
$prepar5 = _FetchAssoc("SELECT * FROM `laboratory` WHERE `id` = '5' LIMIT 1");
$prepar6 = _FetchAssoc("SELECT * FROM `laboratory` WHERE `id` = '6' LIMIT 1");
echo '',$prepar1['name'].'';

if (isset($_GET['log'])) {
    $sum = $_GET['log'];
    $lab = $_GET['lab'];
    if ($sum > $set['gold']) {
        $_SESSION['err'] = 'Недостаточно золота';
        header('Location: ?case=laboratory');
        exit();
    }
}



	if(isset($_GET['log'])) {
		$sum=_NumFilter($_GET['log']);
		$lab=_NumFilter($_GET['lab']);
		if($sum>$set['gold']) {
			$_SESSION['err'] = 'Недостаточно золота!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		}
		$logi_text_naem = 'Куплен препарат '.$lab.' за '.$sum.' золота ';
		if($_GET['log']==20 || $_GET['log']==25) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`='" . (time()+86400) . "', `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы купили препарат на 1 день!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		} elseif($_GET['log']==30) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`='" . (time()+3600) . "', `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы купили препарат на 1 час!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		} elseif($_GET['log']==80) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`='" . (time()+10800) . "', `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы купили препарат на 3 часа!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		} elseif($_GET['log']==150) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`='" . (time()+32400) . "', `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы купили препарат на 9 часов!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		}elseif($_GET['log']==40 || $_GET['log']==60) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`='" . (time()+259200) . "', `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы купили препарат на 3 дня!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		} elseif($_GET['log']==100 || $_GET['log']==130) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`='" . (time()+604800) . "', `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы купили препарат на неделю!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		} else {
			$_SESSION['err'] = 'Ошибка покупки препарата!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		}
	}
?>
<div class="block_zero center">
	<span style="color: #9cc;">"Три недели в пути" – это не миф,<br/>это действие допинга.</span>
</div>
<?php
	$data=mysql_query("SELECT * FROM `laboratory` ORDER BY `id` ASC LIMIT 6");
	while($laboratory=mysql_fetch_assoc($data)) {
		$user_laboratory=_FetchAssoc('SELECT * FROM `user_laboratory` WHERE `id_user`="'.$user_id.'" AND `id_lab`="'.$laboratory['id'].'" LIMIT 1');
?>
<div class="mini-line"></div>
<table width="100%">
	<tr>
		<td width="40%">
        <img src="images/laboratory/<?=$laboratory['id']; ?>.png" style="border:1px solid #999;" alt="Препарат">
		</td>
		<td valign="top">
			<b><span style="color: #9c9;"><?= $laboratory['name'] ?></span></b><br/>
			<small><?= $laboratory['opisanie'] ?></small>
		</td>
	</tr>
</table>
<?php
		$time =$user_laboratory['time_up'] - time();
		if($user_laboratory['status']==1) {
?>
<div class="dot-line"></div>
<div class="block_zero">Будет действовать:<span style="float: right;"><?= _DayTime($time) ?></span></div>
<?php
		} else {
			$dd20 = 'день';
			$dd40 = '3 дня';
			$dd100 = 'неделю';
			$d20 = '20';
			$d40 = '40';
			$d100 = '100';
			if ($laboratory['id'] == 5 || $laboratory['id'] == 6) {
				$dd20 = 'час';
				$dd40 = '3 часа';
				$dd100 = '9 часов';
				$d20 = '30';
				$d40 = '80';
				$d100 = '150';
			}
			if ($laboratory['id'] == 3) {
			 	$d20 = '25';
				$d40 = '60';
				$d100 = '130';
			 } ?>
<div class="dot-line"></div>
<div class="block_zero center">
	<a class="btn" href="blackmarket.php?case=laboratory&log=<?=$d20 ?>&lab=<?= $laboratory['id'] ?>">
		<span class="end">
			<span class="label">Купить на <?=$dd20 ?> за <img src="images/icons/gold.png" alt="*" /><?=$d20 ?></span>
		</span>
	</a>
</div>
<div class="dot-line"></div>
<div class="block_zero center">
	<a class="btn" href="blackmarket.php?case=laboratory&log=<?=$d40 ?>&lab=<?= $laboratory['id'] ?>">
		<span class="end">
			<span class="label">Купить на <?=$dd40 ?> за <img src="images/icons/gold.png" alt="*" /><?=$d40 ?></span>
		</span>
	</a>
</div>
<div class="dot-line"></div>
<div class="block_zero center">
	<a class="btn" href="blackmarket.php?case=laboratory&log=<?=$d100 ?>&lab=<?= $laboratory['id'] ?>">
		<span class="end">
			<span class="label">Купить на <?=$dd100 ?> за <img src="images/icons/gold.png" alt="*" /><?=$d100 ?></span>
		</span>
	</a>
</div><?
		}
	}
	break;
}
echo'</div></div>';
require_once('system/down.php');
?>
