<?
$title = 'Война';
define('H', $_SERVER['DOCUMENT_ROOT'].'/');
require H."system/up.php";
_Reg();
if ($set['block']==1) {
header("Location: /blok.php");
exit();
}
if(!$ref[0]){
?>
<div class="main">
<div class="menuList">
<li><a href="sanction.php?case=vrag"><img src="images/icons/arrow.png"
alt="Санкции" />Санкции</a></li>
</div>
<div class="mini-line"></div>
<?
$data_voina = $sql->query("SELECT * FROM user_set WHERE id!=?i AND lvl>=?i AND lvl<=?i ORDER BY RAND() LIMIT ?i",$user_id,($set[lvl]-3),($set[lvl]+3),5);
while($user_voina = $sql->fetch($data_voina)){

$vrag_set=$sql->getRow("SELECT * FROM user_reg WHERE id=?i LIMIT ?i",$user_voina[id],1);
$vrag_alliance=$sql->getOne("SELECT count(id) FROM alliance_user WHERE kto=?i OR s_kem=?i",$vrag_set[id],$vrag_set[id]);// Колличество альянса ?>
<div class="block_zero"><img src="images/flags/<?=$user_voina['side']?>.png"
alt="Флаг" /><a href="view.php?smotr=<?=$vrag_set['id']?>">
<?=$vrag_set['login']?></a><span style="float: right;"><a class="btn btn-primary btn-xs active"
href="voina?ataka:<?=$vrag_set['id']?>">Атаковать</a></span><br /><small><span
style="color: #fffabd;">Ур.</span> <?=$user_voina['lvl']?>, <span
style="color: #fffabd;">Ал.</span> <?=($vrag_alliance+1)?>, <span
style="color: #fffabd;">Рейтинг</span> <?=$user_voina['raiting']?>, <?=$user_voina['hp']?>/<?=$user_voina['max_hp']?> <span
style="color: #fffabd;"> hp</span>
</small></div>
<div class="dot-line"></div><?php
}
?>

<div class="block_zero center">
<a class="btn btn-primary btn-xs active" href="">Другие противники</a></div>
<div class="mini-line"></div>
<?
}




require H."system/down.php";
?>