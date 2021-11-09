<?php
$title='Миссии';
require_once('system/up.php');
_Reg();
if ($set['block']==1) {
	header("Location: blok.php");
	exit();
}
?><div class="main"><?
if($set['logo'] == 'on'){
if($_GET['case'] == 'mission' AND isset($_GET['id_operation'])){
$id_operation=_NumFilter($_GET['id_operation']);
?><img src="images/missions/<?=$id_operation?>.jpg" width="100%" alt="Миссии"/><div class="mini-line"></div><?
}else{
?><img src="images/logotips/mission.jpg" width="100%" alt="Миссии"/><div class="mini-line"></div><?
}
}
?><div class="menuList"><?
if($_GET['case'] != ''){
?><li><a href="mission.php"><img src="images/icons/arrow.png" alt="*"/>Спецоперации</a></li><?
}
if($_GET['case'] != 'shtab'){
?><li><a href="mission.php?case=shtab"><img src="images/icons/arrow.png" alt="*"/>Задания штаба</a></li><?
}
echo'</div>';
switch($_GET['case']){
default:
$data_operation=mysql_query("SELECT * FROM `user_operation` WHERE `id_user`='".$user_id."' ORDER BY `id_operation` ASC LIMIT 8");
while($user_operation=mysql_fetch_assoc($data_operation)){
?><div class="mini-line"></div><a href="mission.php?case=mission&id_operation=<?=$user_operation['id_operation']?>"><div class="block_zero center"><b><span style="color: #9c9;"><?=$user_operation['name']?></span> <span style="color: #f96;">(Ранг - <?=$user_operation['rang']?>)</span></b><?
$exp=($user_operation['exp']/$user_operation['max_exp'])*100;
?><div class="stat_bar" style="margin:2px 0px 2px"><div class="progress blue" style="width:<?=$exp?>%"></div></div></div></a><?
}
$user_operation_set = _FetchAssoc("SELECT * FROM `user_operation` WHERE `id_user` = '" . $user_id . "' ORDER BY `id_operation` DESC LIMIT 1");
        $next_operation = _FetchAssoc("SELECT * FROM `operation` WHERE `id` = '" . _NumFilter($user_operation_set['id_operation'] + 1) . "' LIMIT 1");
        if ($next_operation){
?><div class="mini-line"></div><div class="block_zero center"><div class="block_dashed center"><?= $next_operation['name'] ?><br/><img src="images/units/0.png" alt="*"/><br/><b><span style="color: #ff3434;">Будет доступно на <?= $next_operation['lvl'] ?> уровне</span></b><?
        }
?></div></div></div></div><?
break;

case 'mission':
if(isset($_GET['log']) AND $_GET['log']=='do'){
$id_oper=_NumFilter($_GET['id_oper']);
$id_miss=_NumFilter($_GET['id_miss']);
$mission_priz=_FetchAssoc("SELECT * FROM `user_mission` WHERE `id_mission`='".$id_miss."' AND `id_operation`='".$id_oper."' AND `id_user`='".$user_id."' LIMIT 1");
$mission_user_unit=_FetchAssoc("SELECT * FROM `user_unit` WHERE `id_unit`='".$mission_priz['id_unit']."' AND `id_user`='".$user_id."' LIMIT 1");
if($mission_priz['exp']>=$mission_priz['max_exp']){
$_SESSION['err'] = 'Эта миссия выполнена полностью!';
header("Location: mission.php?case=mission&id_operation=".$mission_priz['id_operation']."");
exit();
}


if($mission_priz['kol_unit']>$mission_user_unit['kol'] OR $mission_priz['exp_mission']>$set['mp'] OR $mission_priz['alliance']>($user_alliance+1)){
$_SESSION['err'] = 'Не выполнены требования миссии!<br/>Мало <a href="alliance.php">Альянса</a>, <a href="pers.php?case=raspred">Энергии</a> или <a href="unit.php">Техники</a>';
header("Location: mission.php?case=mission&id_operation=".$mission_priz['id_operation']."");
exit();
}


mysql_query("UPDATE `user_operation` SET `exp`=`exp`+'".$mission_priz['exp_mission']."' WHERE `id_user`='".$user_id."' AND `id_operation`='".$mission_priz['id_operation']."'");
mysql_query("UPDATE `user_mission` SET `exp`=`exp`+'".$mission_priz['exp_mission']."' WHERE `id_user`='".$user_id."' AND `id_mission`='".$mission_priz['id_mission']."' AND `id_operation`='".$mission_priz['id_operation']."'");

$trof_mp=_FetchAssoc("SELECT * FROM `user_trofei` WHERE `id_user` = '".$user_id."' AND `id_trof` = '3'");
$rand_mp=mt_rand(1,100);
if($trof_mp['status']==1 && $rand_mp<=$trof_mp['bonus_2']){
$sum_mp=FALSE;
$trof='<br/>Благодаря трофею "Полевая кухня"<br/><img src="images/trofei/3.png" style="margin-left:0px;margin-right:0px;border:1px solid #999;" alt="Трофей"><br/>Вы не потратили энергию!';
}else{
$sum_mp=$mission_priz['exp_mission'];
$trof=FALSE;
}

$trof_exp=_FetchAssoc("SELECT * FROM `user_trofei` WHERE `id_user`='".$user_id."' AND `id_trof`='5' LIMIT 1");
if($trof_exp['status']==1 AND $trof_exp['time_up']==0){
if ($set['side']=='u'){
$exp_trof=round($mission_priz['exp_priz']*1.2)/100*$trof_exp['bonus_1'];
$expa=round($mission_priz['exp_priz']*1.2)+$exp_trof;
}else{
$exp_trof=$mission_priz['exp_priz']/100*$trof_exp['bonus_1'];
$expa=$mission_priz['exp_priz']+$exp_trof;
}
}else{
if ($set['side']=='u'){
$expa=round($mission_priz['exp_priz']*1.2);
}else{
$expa=$mission_priz['exp_priz'];
}
}

$user_lab_exp=_FetchAssoc('SELECT * FROM `user_laboratory` WHERE `id_user`="'.$user_id.'" AND `id_lab`="4" LIMIT 1');

if($user_lab_exp['status']==1){
$expa=$expa*1.3;
}

$user_lab_expno=_FetchAssoc('SELECT * FROM `user_laboratory` WHERE `id_user`="'.$user_id.'" AND `id_lab`="3" LIMIT 1');

if($user_lab_expno['status']==1){
$expa=0;
}

mysql_query("UPDATE `user_set` SET `mp`=`mp`-'".$sum_mp."', `mp_up`='".time()."', `exp`=`exp`+'".$expa."', `baks`=`baks`+'".$mission_priz['baks_priz']."', `refer_baks`=`refer_baks`+'".round($mission_priz['baks_priz']/10)."' WHERE `id`='".$user_id."'");

mysql_query("UPDATE `user_set` SET `baks`=`baks`+'".round($mission_priz['baks_priz']/10)."' WHERE `id`='".$user['refer']."'");

$_SESSION['ok'] = 'Миссия выполнена!<br/>Получено <img src="/images/icons/baks.png" alt="Бакс"/>'.$mission_priz['baks_priz'].' и <img src="/images/icons/lvl.png" alt="*"/>'.round($expa,0).'.'.$trof.'';
header("Location: mission.php?case=mission&id_operation=".$mission_priz['id_operation']."");
exit();
}

if(isset($_GET['id_operation'])){
$id_operation=_NumFilter($_GET['id_operation']);
if($id_operation<1 OR $id_operation>10){
$_SESSION['err'] = 'Нет такой спецоперации!';
header("Location: mission.php");
exit();
}
}

$op_end=_FetchAssoc("SELECT * FROM `operation` WHERE `id`='".$id_operation."' LIMIT 1");

$op_end_user=_FetchAssoc("SELECT * FROM `user_operation` WHERE `id_operation`='".$op_end['id']."' AND `id_user`='".$user_id."' LIMIT 1");

if(!$op_end_user){
$_SESSION['err'] = 'Эта спецоперация ещё не доступна!';
header("Location: mission.php");
exit();
}

if($op_end_user['rang']<6){

if($op_end_user['exp']>=$op_end_user['max_exp']){

mysql_query("UPDATE `user_set` SET `skill`=`skill`+'".$op_end_user['point']."', `baks`=`baks`+'".($set['lvl']*1000)."', `gold`=`gold`+'25', `refer_baks`=`refer_baks`+'".round($set['lvl']*100)."' WHERE `id`='".$user_id."'");

mysql_query("UPDATE `user_set` SET `baks`=`baks`+'".round($set['lvl']*100)."' WHERE `id`='".$user['refer']."'");

mysql_query("UPDATE `user_operation` SET `exp`='0', `max_exp`=`max_exp`*'2', `point`=`point`+'1', `rang`=`rang`+'1' WHERE `id_user`='".$user_id."' AND `id_operation`='".$op_end_user['id_operation']."'");

mysql_query("UPDATE `user_mission` SET `exp`='0', `max_exp`=`max_exp`*'2' WHERE `id_user`='".$user_id."' AND `id_operation`='".$op_end_user['id_operation']."'");

if($op_end_user['rang']<2 AND $op_end['id_trof']<10){
mysql_query("UPDATE `user_trofei` SET `status`='1' WHERE `id_trof`='".$op_end['id_trof']."' AND `id_user`='".$user_id."' LIMIT 1");
$trof_set=_FetchAssoc("SELECT * FROM `user_trofei` WHERE `id_user`='".$user_id."' AND `id_trof`='".$op_end['id_trof']."' LIMIT 1");
$trof_name=_FetchAssoc("SELECT * FROM `trofei` WHERE `id`='".$trof_set['id_trof']."' LIMIT 1");
$trof='<br/>Награда:<br/>Очков навыков - '.$op_end_user['point'].', <img src="images/icons/gold.png" alt="*">25 и <img src="images/icons/baks.png" alt="*">'.($set['lvl']*1000).'<br/>Получен трофей "'.$trof_name['name'].'"<br/><img src="images/trofei/'.$trof_name['id'].'.png" style="margin-left:0px;margin-right:0px;border:1px solid #999;" alt="Трофей"><br/>'.$trof_name['opisanie_1'].'';

if($trof_name['id']==6){
mysql_query("UPDATE `user_set` SET `hp`=`hp`*'1.02', `max_hp`=`max_hp`*'1.02' WHERE `id`='".$user_id."' LIMIT 1");
}

if($trof_name['id']==4){
mysql_query("UPDATE `user_set` SET `soderzhanie`=`soderzhanie`-'".($set['soderzhanie']/100*$trof_set['bonus_1'])."', `chistaya`=`chistaya`+'".($set['soderzhanie']/100*$trof_set['bonus_1'])."' WHERE `id`='".$user_id."' LIMIT 1");
}

}else{
$trof='<br/>Награда:<br/>Очков навыков: '.$op_end_user['point'].', <img src="images/icons/gold.png" alt="*">25 и <img src="images/icons/baks.png" alt="*">'.($set['lvl']*1000).'';
}

$_SESSION['ok'] = 'Спецоперация завершена, Ранг повышен!'.$trof.'';
header("Location: mission.php");
exit();
}

} else {
$_SESSION['err'] = 'Спецоперация уже завершена полностью!';
header("Location: mission.php");
exit();
}

$data_mission=mysql_query("SELECT * FROM `user_mission` WHERE `id_user`='".$user_id."' AND `id_operation`='".$id_operation."' ORDER BY `id_mission` ASC LIMIT 10");
while($user_mission=mysql_fetch_assoc($data_mission)){
?><div class="mini-line"></div><div class="block_zero center"><b><span style="color: #9cc;"><?=$user_mission['name']?></span></b></div><div class="dot-line"></div><div class="block_zero"><small>Награда: <img src="images/icons/baks.png"  alt="*"/><?=$user_mission['baks_priz']?>, +<?=$user_mission['exp_priz']?> опыта<?
if($user_mission['exp']<$user_mission['max_exp']){
?><span style="float: right;"><a class="btn" href="mission.php?case=mission&log=do&id_oper=<?=$user_mission['id_operation']?>&id_miss=<?=$user_mission['id_mission']?>"><span class="end"><span class="label"><span class="green">Выполнить</span></span></span></a></span><?
}
?><br/>Требования: <img src="images/icons/aliance.png"  alt="*"/><?=$user_mission['alliance']?>,<img src="images/icons/mp.png"  alt="*"/><?=$user_mission['exp_mission']?>,<img src="images/units/<?= $user_mission['id_unit'] ?>.png" width="50px" height="30px" style="margin-left:0px;margin-right:0px;border:1px solid #999;" alt="Техника"><?=$user_mission['kol_unit']?></small><?
$exp=($user_mission['exp']/$user_mission['max_exp'])*100;
?><div class="stat_bar" style="margin:2px 0px 2px"><div class="progress yellow" style="width:<?=$exp?>%"></div></div></div><?
}
$user_mission_set = _FetchAssoc("SELECT * FROM `user_mission` WHERE `id_user` = '" . $user_id . "' AND `id_operation`='".$id_operation."' ORDER BY `id_mission` DESC LIMIT 1");
        $next_mission = _FetchAssoc("SELECT * FROM `mission` WHERE `id` = '" . _NumFilter($user_mission_set['id_mission'] + 1) . "' AND `id_operation`='".$user_mission_set['id_operation']."' LIMIT 1");
        if ($next_mission){
?><div class="mini-line"></div><div class="block_zero center"><div class="block_dashed center"><?= $next_mission['name'] ?><br/><img src="images/units/0.png" alt="*"/><br/><b><span style="color: #ff3434;">Будет доступно на <?= $next_mission['lvl'] ?> уровне</span></b><?
        }
?></div></div></div></div><?
break;

case 'shtab':
?></div></div><?
break;


}
require_once('system/down.php');
?>
