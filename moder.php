<?php
$title = 'Модерка';
require_once('system/up.php');
_Reg();
if($set['prava']<2){
$_SESSION['err'] = 'Нет доступа';
header('Location: menu.php');
exit();
}
?><div class="main"><?php
switch($_GET['case']){

default:
if ($set['prava']>=3) { ?>
<div class="menuList">
    <li>
        <a href="chat_del.php"><img src="images/icons/arrow.png" alt="*"/>Посмотреть удаленные сообщения</a>
    </li><?
}
break;

case '3_1':
if($set['prava']<2){
$_SESSION['err'] = 'Нет доступа';
header('Location: menu.php');
exit();
}
$id=isset($_GET['id'])?_NumFilter($_GET['id']):NULL;
$data  = _FetchAssoc("SELECT * FROM `user_reg` WHERE `id`='" . $id . "' LIMIT 1");
$data_set  = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $id . "' LIMIT 1");

?><div class="block_zero">Возможные мульты игрока: <a href="view.php?smotr=<?=$data['id']?>"><?=$data['login']?></a></div><div class="mini-line"></div><?

$dubl_ip_browser=mysql_query("SELECT * FROM `user_reg` WHERE `browser`='".$data['browser']."'  AND `id`!='".$id."' ORDER BY `id` ASC");

while($mult=mysql_fetch_assoc($dubl_ip_browser)){
$mult_set  = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='".$mult['id']."' LIMIT 1");
?><div class="block_zero">Игрок: <a href="view.php?smotr=<?=$mult['id']?>"><?=$mult['login']?></a><span style="float: right;"><small><?=$mult['ip']?> / <?=$mult_set['ip_new']?></small></span></div><div class="dot-line"></div><?
}
break;






}
?></div></div><?
require_once('system/down.php');
?>