<?php
$title = 'Админка';
require_once ('system/up.php');
_Reg();
if ($set['prava']<4) {
	$text_bb = 'Пытался залезть в выдачу зп.';
	mysql_query("UPDATE `user_set` SET `block`='1' WHERE `id`='".$set['id']."' ");
	mysql_query("INSERT INTO `admin_logi`(`id`, `id_user`, `user`, `text`, `date`) VALUES (NULL,'".$set['id']."','".$set['user']."','".$text_bb."',NULL)");
	$_SESSION['err'] = 'Чувак, ты спалился. Смс уже ушло Админу. Можешь начинать обьснять зачем ты туда полез';
	header("Location: blok.php");
	exit();
}
switch ($_GET['case']) {
	default: ?>
	<a href="?case=1">Выдать зп всем сразу (Админы, СТ.МД, МД и 1й допуск)</a><?php
		break;
	case '1':
	$vibor_adm1=mysql_query("SELECT * FROM `user_set` WHERE `prava`='4' ");
	$vibor_stmd1=mysql_query("SELECT * FROM `user_set` WHERE `prava`='3' ");
	$vibor_md1=mysql_query("SELECT * FROM `user_set` WHERE `prava`='2' ");
	$vibor_11=mysql_query("SELECT * FROM `user_set` WHERE `prava`='1' ");
	$vibor_adm=mysql_fetch_array($vibor_adm1);
	$vibor_stmd=mysql_fetch_array($vibor_stmd1);
	$vibor_md=mysql_fetch_array($vibor_md1);
	$vibor_1=mysql_fetch_array($vibor_11);
	$zp_adm = $vibor_adm['dold']+250;
	$zp_stmd = $vibor_stmd['gold']+200;
	$zp_md = $vibor_md['gold']+150;
	$zp_1 = $vibor_1['gold']+50;
	$text_zp = 'Выдал зп всей администрации за неделю';
		if (!isset($_GET['case=1'])) {
			mysql_query("UPDATE `user_set` SET `gold`='".$zp_adm."' WHERE `prava`='4' ");
			mysql_query("UPDATE `user_set` SET `gold`='".$zp_stmd."' WHERE `prava`='3' ");
			mysql_query("UPDATE `user_set` SET `gold`='".$zp_md."' WHERE `prava`='2' ");
			mysql_query("UPDATE `user_set` SET `gold`='".$zp_1."' WHERE `prava`='1' ");
			mysql_query("INSERT INTO `admin_logi`(`id`, `id_user`, `user`, `text`, `date`) VALUES (NULL,'".$set['id']."','".$set['user']."','".$text_zp."',NULL)");
			$_SESSION['ok'] = 'Недельная зарплата успешно выдана';
			header("Location: ?");
			exit();
		} else {
			echo "Что то пошло не так";
		}
		break;
}
require_once ('system/down.php');