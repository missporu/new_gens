<?php
	require_once ('system/up.php');
	_Reg();
$hp_ind = _FetchAssoc("SELECT * FROM `user_set` WHERE `id` = '".$set['id_vrag']."' LIMIT 1");	
$max = $hp_ind['max_hp'];
$now = $hp_ind['hp'];
$health = 130 / ($max / $now);
$img="images/indicator/hpvrag.gif";
$pic = ImageCreateFromgif($img);
header('Content-Type: image/gif');
$black = imagecolorallocate($pic, 999, 999, 999);
$white = imagecolorallocate($pic, 557, 667, 998);
imagefilledpolygon($pic, array(255,0, 0,22, $health,22, $health,0), 4, $black);
imagestring($pic, 1, 3, 2, 'HP:  '.number_format($now).'/'.number_format($max).'', $white);
imagepolygon($pic, array(0,0, 0,11, 129,11, 129,0), 4, $white);
ob_end_clean();
imagegif($pic);
?>
