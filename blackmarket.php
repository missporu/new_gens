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
<div class="mini-line"></div>

<?php
	if(isset($_GET['log'])) {
		$sum=_NumFilter($_GET['log']);
		$lab=_NumFilter($_GET['lab']);
		if($sum>$set['gold']) {
			$_SESSION['err'] = 'Недостаточно золота!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		}
		$logi_text_naem = 'Куплен препарат '.$lab.' за '.$sum.' золота ';
		if($_GET['log']==10 || $_GET['log']==12) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`='" . (time()+86400) . "', `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы купили препарат на 1 день!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		} elseif($_GET['log']==15) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`='" . (time()+3600) . "', `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы купили препарат на 1 час!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		} elseif($_GET['log']==40) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`='" . (time()+10800) . "', `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы купили препарат на 3 часа!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		} elseif($_GET['log']==75) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`='" . (time()+32400) . "', `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы купили препарат на 9 часов!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		}elseif($_GET['log']==20 || $_GET['log']==30) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`='" . (time()+259200) . "', `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы купили препарат на 3 дня!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		} elseif($_GET['log']==50 || $_GET['log']==65) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`='" . (time()+604800) . "', `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы купили препарат на неделю!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		} elseif($_GET['log']==9 || $_GET['log']==11) { // Dozakup
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`=`time_up`+86400, `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы докупили препарат на 1 день!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		} elseif($_GET['log']==14) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`=`time_up`+3600, `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы докупили препарат на 1 час!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		} elseif($_GET['log']==39) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`=`time_up`+10800, `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы докупили препарат на 3 часа!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		} elseif($_GET['log']==74) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`=`time_up`+32400, `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы докупили препарат на 9 часов!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		}elseif($_GET['log']==19 || $_GET['log']==29) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`=`time_up`+259200, `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы докупили препарат на 3 дня!';
			header('Location: blackmarket.php?case=laboratory');
			exit();
		} elseif($_GET['log']==49 || $_GET['log']==64) {
			mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . $sum . "' WHERE `id`='" . $user_id . "' LIMIT 1");
			mysql_query("UPDATE `user_laboratory` SET `time_up`=`time_up`+604800, `status`='1' WHERE `id_user`='" . $user_id . "' AND `id_lab`='" . $lab . "' LIMIT 1");
			mysql_query("INSERT INTO `logi`(`id`, `id_user`, `text`, `tip`, `time`) VALUES (NULL,'".$set['id']."','".$logi_text_naem."','1',NULL)");
			$_SESSION['ok'] = 'Вы докупили препарат на неделю!';
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
</table><?php
			$dd20 = 'день';
			$dd40 = '3 дня';
			$dd100 = 'неделю';
			$d20 = '10';
			$d40 = '20';
			$d100 = '50';
			$dk20 = '9';
			$dk40 = '19';
			$dk100 = '49';
			if ($laboratory['id'] == 5 || $laboratory['id'] == 6) {
				$dd20 = 'час';
				$dd40 = '3 часа';
				$dd100 = '9 часов';
				$d20 = '15';
				$d40 = '40';
				$d100 = '75';
				$dk20 = '14';
				$dk40 = '39';
				$dk100 = '74';
			}
			if ($laboratory['id'] == 3) {
			 	$d20 = '12';
				$d40 = '30';
				$d100 = '65';
				$dk20 = '11';
				$dk40 = '29';
				$dk100 = '64';
			}
		$time =$user_laboratory['time_up'] - time();
		if($user_laboratory['status']==1) {
?>
<div class="dot-line"></div>
<div class="block_zero">Будет действовать:<span style="float: right;"><?= _DayTime($time) ?></span></div>
<div class="dot-line"></div>
<div class="block_zero center">
	<a class="btn" href="blackmarket.php?case=laboratory&log=<?=$dk20 ?>&lab=<?= $laboratory['id'] ?>">
		<span class="end">
			<span class="label">Докупить на <?=$dd20 ?> за <img src="images/icons/gold.png" alt="*" /><?=$dk20 ?></span>
		</span>
	</a>
</div>
<div class="dot-line"></div>
<div class="block_zero center">
	<a class="btn" href="blackmarket.php?case=laboratory&log=<?=$dk40 ?>&lab=<?= $laboratory['id'] ?>">
		<span class="end">
			<span class="label">Докупить на <?=$dd40 ?> за <img src="images/icons/gold.png" alt="*" /><?=$dk40 ?></span>
		</span>
	</a>
</div>
<div class="dot-line"></div>
<div class="block_zero center">
	<a class="btn" href="blackmarket.php?case=laboratory&log=<?=$dk100 ?>&lab=<?= $laboratory['id'] ?>">
		<span class="end">
			<span class="label">Докупить на <?=$dd100 ?> за <img src="images/icons/gold.png" alt="*" /><?=$dk100 ?></span>
		</span>
	</a>
</div><?php
		} else { ?>
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
