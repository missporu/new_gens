<?php
$title = 'Покупка золота';
require_once('config.php');
require_once('../system/sys.php');
_Reg();
if (isset($_GET['gold']) && is_numeric($_GET['gold'])) {
	if (isset($cena_gold[$_GET['gold']])) {
		$summa=$cena_gold[$_GET['gold']];
	}
}
if (isset($summa)) {
$data=file_get_contents('http://worldkassa.ru/user/oplata.php?id_shop='.$id_shop.'&summa='.$summa.'&hash='.$hash);
	if (is_numeric($data)) {
		mysql_query("INSERT INTO `worldkassa` (`id_user`, `id_bill`, `time`, `summa`) VALUES('".$user_id."', '".$data."', '".time()."', '".$summa."')");
		header("Location: http://worldkassa.ru/user/oplata.php?uniq=".$data);
		exit();
	} else {
		echo $data;
	}
}
?>
