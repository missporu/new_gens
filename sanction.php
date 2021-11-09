<?php
$title='Санкции';
require_once('system/up.php');
_Reg();

switch($_GET['case']){

default:

if($set['id_vrag']==0){
$_SESSION['err'] = 'Не выбран противник';
header('Location: sanction.php?case=vrag');
exit();
}
$vrag_set=_FetchAssoc("SELECT * FROM `user_reg` WHERE `id`='".$set['id_vrag']."' LIMIT 1");
$logi=_FetchAssoc("SELECT * FROM `user_voina` WHERE `id_user`='".$user_id."' AND `id_vrag`='".$vrag_set['id']."' ORDER BY `id` DESC LIMIT 1");
?><div class="main"><div class="block_zero center"><?=$user['login']?> <img src="images/flags/<?=$set['side']?>.png" alt="Флаг"/> <img src="images/icons/vs.png" alt="vs"/> <img src="images/flags/<?=$vrag['side']?>.png" alt="Флаг"/> <?=$vrag_set['login']?></div><div class="dot-line"></div><div class="block_zero center"><img src="hpvrag.php" alt="Индикатор" /></div><div class="mini-line"></div><?
if(empty($logi['rezult'])){
header("Location: sanction.php?case=vrag");
exit();
}
if($logi['rezult']=='snikt'){
if ($set['logo']=='on'){
?><img src="images/logotips/nikto.jpg" width="100%" alt="Ничья"/><div class="mini-line"></div><?
}
?><div class="block_zero center"><h3 class="Admin" style="font-weight:bold;">Ничья !!!</h3></div><div class="dot-line"></div><?
}
if($logi['rezult']=='swin'){
if ($set['logo']=='on'){
?><img src="images/logotips/win.jpg" width="100%" alt="Победа"/><div class="mini-line"></div><?
}
?><div class="block_zero center"><h3 class="dgreen" style="font-weight:bold;">Победа !!!</h3></div><div class="dot-line"></div><?
}
if($logi['rezult']=='slose'){
if ($set['logo']=='on'){
?><img src="images/logotips/lose.png" width="100%" alt="Поражение"/><div class="mini-line"></div><?
}
?><div class="block_zero center"><h3 class="dred" style="font-weight:bold;">Поражение !!!</h3></div><div class="dot-line"></div><?
}
if($logi['rezult']=='srazb'){
if ($set['logo']=='on'){
?><img src="images/logotips/pomiloval.jpg" width="100%" alt="Выполнил санкцию"/><div class="mini-line"></div><?
}
$data_nagrada=_FetchAssoc("SELECT SUM(`nagrada`) AS `sum_nag` FROM `sanction` WHERE `kto`!='".$user_id."' AND `kogo`='".$set['id_vrag']."' GROUP BY `kogo`");
?><div class="block_zero center"><h3 class="dgreen" style="font-weight:bold;">Вы выполнили санкцию!!!<br/>Вознаграждение <img src="images/icons/baks.png" alt="baks"/> <?=$data_nagrada['sum_nag']?></h3></div><div class="dot-line"></div><?
$data_dubl=_FetchAssoc("SELECT * FROM `sanction` WHERE `kto`='".$user_id."' AND `kogo`='".$set['id_vrag']."' LIMIT 1");
if($data_dubl){
mysql_query("UPDATE `sanction` SET `nagrada`='0' WHERE `kto`!='".$user_id."' AND `kogo`='".$set['id_vrag']."'");
}else{
mysql_query("UPDATE `sanction` SET `nagrada`='0' WHERE `kogo`='".$set['id_vrag']."'");
mysql_query("UPDATE `user_set` SET `sanction_status`='0' WHERE `id`='".$set['id_vrag']."' LIMIT 1");
}
mysql_query("UPDATE `user_set` SET `id_vrag`='0' WHERE `id`='".$user_id."' LIMIT 1");
?><div class="block_zero center"><a class="btn" href="voina.php?case=vrag"><span class="end"><span class="label"><span class="grey">На войну</span></span></span></a><a class="btn" href="sanction.php?case=vrag"><span class="end"><span class="label"><span class="dred">В санкции</span></span></span></a></span></div></div><?
require_once('system/down.php');
break;
}
if($logi['rezult']=='suzhe'){
if ($set['logo']=='on'){
?><img src="images/logotips/razbit.jpg" width="100%" alt="Поражение"/><div class="mini-line"></div><?
}
$vrag=_FetchAssoc("SELECT * FROM `user_set` WHERE `id`='".$set['id_vrag']."' LIMIT 1");
if ($vrag['sanction_status']!=0){
?><div class="block_zero center"><h3 class="dred" style="font-weight:bold;">Армия противника уже разбита !!!</h3></div><div class="dot-line"></div><?
}else{
?><div class="block_zero center"><h3 class="dred" style="font-weight:bold;">Санкция уже выполнена<br/>другим игроком !!!</h3></div><div class="dot-line"></div><div class="block_zero center"><a class="btn" href="sanction.php?case=vrag"><span class="end"><span class="label"><span class="grey">В санкции</span></span></span></span></span></span></a></div></div><?
require_once('system/down.php');
break;
}
}

?><div class="block_zero center"><a class="btn" href="sanction.php?case=vrag"><span class="end"><span class="label"><span class="grey">В санкции</span></span></span></a><a class="btn" href="sanction.php?case=ataka&vrag=<?=$vrag['id']?>"><span class="end"><span class="label"><span class="dred">Атаковать</span></span></span></a></span><?

if($logi['nanes']==0){$uvorot_vrag='<span style="color: #3c3;">Уворот!</span>';}else{$uvorot_vrag=FALSE;}
if($logi['poluchil']==0){$uvorot_user='<span style="color: #3c3;">Уворот!</span>';}else{$uvorot_user=FALSE;}
if($logi['poluchil']==20){$krit_vrag='<span style="color: #ff3434;">Крит!</span>';}else{$krit_vrag=FALSE;}
if($logi['nanes']==20){$krit_user='<span style="color: #ff3434;">Крит!</span>';}else{$krit_user=FALSE;}

if($logi['rezult']!='razb' AND $logi['rezult']!='suzhe'){
?></div><div class="dot-line"></div><div class="block_zero"><img src="images/icons/ataka.png" alt="ataka"/> Нанесено: <span style="color: #9c9;"><?=$logi['nanes']?></span> урона <?=$krit_user?><?=$uvorot_vrag?><br/><img src="images/icons/ataka.png" alt="ataka"/> Получено: <span style="color: #c66;"><?=$logi['poluchil']?></span> урона <?=$krit_vrag?><?=$uvorot_user?><br/><img src="images/icons/baks.png" alt="baks"/> Награблено: <span style="color: #9c9;"><?=$logi['baks']?></span> баксов<br/><img src="images/icons/lvl.png" alt="lvl"/> Заработано: <span style="color: #9c9;"><?=$logi['exp']?></span> опыта<?
}
?></div></div><?
break;

break;

case 'vrag':
if(isset($_GET['vrag'])){
$vrag=_NumFilter($_GET['vrag']);
mysql_query("UPDATE `user_set` SET `id_vrag`='0' WHERE `id`='".$user_id."' LIMIT 1");
if($set['udar']==0){
$_SESSION['err']='Закончились бои';
header("Location: sanction.php?case=vrag");
exit();
}
if($set['hp']<25){
$_SESSION['err']='Закончилось здоровье,<br/>отдохните или сходите в <a href="hosp.php">Госпиталь</a>';
header("Location: sanction.php?case=vrag");
exit();
}
header("Location: sanction.php?case=ataka&vrag=".$vrag."");
exit();
}
mysql_query("UPDATE `user_set` SET `id_vrag`='0' WHERE `id`='".$user_id."' LIMIT 1");
?><div class="main"><?
if ($set['logo']=='on'){
?><img src="images/logotips/sanction.jpg" width="100%" alt="Санкции"/><div class="mini-line"></div><?
}
?><div class="menuList"><li><a href="voina.php?case=vrag"><img src="images/icons/ataka.png" alt="Санкции"/>Война</a></li></div><div class="mini-line"></div><?
$data_sanc = mysql_query("SELECT * FROM `user_set` WHERE `sanction_status`='1' AND `id`!='".$user_id."' ORDER BY RAND() LIMIT 5");
while($sanc_id=mysql_fetch_assoc($data_sanc)){
$us_sanc = _FetchAssoc("SELECT * FROM `sanction` WHERE `kto`!='".$user_id."' AND `kogo`='".$sanc_id['id']."' LIMIT 1");
if($us_sanc){
$user_sanction = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='".$us_sanc['kogo']."' LIMIT 1");
$vrag_set=_FetchAssoc("SELECT * FROM `user_reg` WHERE `id`='".$user_sanction['id']."' LIMIT 1");
$vrag_alliance=_NumRows("SELECT * FROM `alliance_user` WHERE `kto`='".$vrag_set['id']."' OR `s_kem`='".$vrag_set['id']."'");
$data_nagrada=_FetchAssoc("SELECT SUM(`nagrada`) AS `sum_nag` FROM `sanction` WHERE `kto`!='".$user_id."' AND `kogo`='".$user_sanction['id']."' GROUP BY `kogo`");
?><div class="block_zero"><img src="images/flags/<?=$user_sanction['side']?>.png" alt="Флаг"/><a href="view.php?smotr=<?=$vrag_set['id']?>"> <?=$vrag_set['login']?></a><span style="float: right;"><a class="btn" href="sanction.php?case=vrag&vrag=<?=$vrag_set['id']?>"><span class="end"><span class="label"><span class="dred">Атаковать</span></span></span></a></span><br /><small><span style="color: #fffabd;">Ур.</span> <?=$user_sanction['lvl']?>, <span style="color: #fffabd;">Ал.</span> <?=($vrag_alliance+1)?>, <span style="color: #fffabd;">Рейтинг</span> <?=$user_sanction['raiting']?><br/>Награда: <img src="images/icons/baks.png" alt="*"/><?=$data_nagrada['sum_nag']?></small></div><div class="dot-line"></div><?
}
}
?><div class="block_zero center"><a class="btn" href="sanction.php?case=vrag"><span class="end"><span class="label">Другие противники</span></span></a></div><div class="mini-line"></div><ul class="hint"><li>Здесь обиженные выставляют цену за голову обидчика. Твоя задача - мстить и зарабатывать.</li></ul></div><?
break;

case 'ataka':
$vrag=isset($_GET['vrag'])?_NumFilter($_GET['vrag']):NULL;
if($set['id_vrag']==0){
mysql_query("UPDATE `user_set` SET `id_vrag`='".$vrag."' WHERE `id`='".$user_id."' LIMIT 1");
header('Location: sanction.php?case=ataka');
exit();
}
$vrag_set=_FetchAssoc("SELECT * FROM `user_set` WHERE `id`='".$set['id_vrag']."' LIMIT 1");

if($user_id==$vrag_set['id']){
$_SESSION['err']='Нельзя атаковать самого себя!';
header("Location: voina.php?case=vrag");
exit();
}


if($set['udar']==0){
$_SESSION['err']='Закончились бои';
header("Location: sanction.php");
exit();
}

if($set['hp']<25){
$_SESSION['err']='Закончилось здоровье,<br/>отдохните или сходите в <a href="hosp.php">Госпиталь</a>';
header("Location: sanction.php");
exit();
}





// Победа
if($ITOG_A>$VRAG_ITOG_Z AND $vrag_set['hp']>=25){

$hp_user=($VRAG_ITOG_Z/$ITOG_A);
$hp_vrag=($ITOG_A-$VRAG_ITOG_Z)*0.1;

$trof_exp=_FetchAssoc("SELECT * FROM `user_trofei` WHERE `id_user`='".$user_id."' AND `id_trof`='5' LIMIT 1");
if($trof_exp['status']==1 AND $trof_exp['time_up']==0){
if ($set['side']=='u'){
$exp_trof=round(($set['lvl']+1)*1.2)/100*$trof_exp['bonus_1'];
$expa=round(($set['lvl']+1)*1.2)+$exp_trof;
}else{
$exp_trof=($set['lvl']+1)/100*$trof_exp['bonus_1'];
$expa=($set['lvl']+1)+$exp_trof;
}
}else{
if ($set['side']=='u'){
$expa=round(($set['lvl']+1)*1.2);
}else{
$expa=($set['lvl']+1);
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

if($vrag_set['baks']>=(($set['lvl']+1)*5)){
$baks=($set['lvl']+1)*5;
}else{
$baks=0;
}

if($user['refer']>0){
mysql_query("UPDATE `user_set` SET `baks`=`baks`+'".round($baks/10)."' WHERE `id`='".$user['refer']."'");
mysql_query("UPDATE `user_set` SET `hp`=`hp`-'".$hp_user."', `hp_up`='".time()."', `baks`=`baks`+'".$baks."', `exp`=`exp`+'".$expa."', `udar`=`udar`-'1', `udar_up`='".time()."', `refer_baks`=`refer_baks`+'".round($baks/10)."' WHERE `id`='".$user_id."' LIMIT 1");
}else{
mysql_query("UPDATE `user_set` SET `hp`=`hp`-'".$hp_user."', `hp_up`='".time()."', `baks`=`baks`+'".$baks."', `exp`=`exp`+'".$expa."', `udar`=`udar`-'1', `udar_up`='".time()."' WHERE `id`='".$user_id."' LIMIT 1");
}


mysql_query("UPDATE `user_set` SET `wins`=`wins`+'1', `raiting_wins`=`raiting_wins`+'1' WHERE `id`='".$user_id."' LIMIT 1");
mysql_query("UPDATE `user_set` SET `hp`=`hp`-'".$hp_vrag."', `hp_up`='".time()."', `baks`=`baks`-'".$baks."' WHERE `id`='".$vrag_set['id']."' LIMIT 1");
mysql_query("UPDATE `user_set` SET `loses`=`loses`+'1', `raiting_loses`=`raiting_loses`+'1' WHERE `id`='".$vrag_set['id']."' LIMIT 1");
$vrag_set=_FetchAssoc("SELECT * FROM `user_set` WHERE `id`='".$vrag_set['id']."' LIMIT 1");

if($vrag_set['hp']>=25){// Победа
mysql_query("INSERT INTO `user_voina` (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$vrag_set['id']."','".$dater."','".$timer."','".$hp_vrag."','".$hp_user."','".$baks."','".$expa."','swin')");
header("Location: sanction.php");
exit();
}else{// Разбил армию
mysql_query("INSERT INTO `user_voina` (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$vrag_set['id']."','".$dater."','".$timer."','".$hp_vrag."','".$hp_user."','".$baks."','".$expa."','srazb')");

$data_nagrada=_FetchAssoc("SELECT SUM(`nagrada`) AS `sum_nag` FROM `sanction` WHERE `kto`!='".$user_id."' AND `kogo`='".$vrag_set['id']."' GROUP BY `kogo`");

mysql_query("UPDATE `user_set` SET `hp`=`hp`+'0', `dies`=`dies`+'1' WHERE `id`='".$vrag_set['id']."' LIMIT 1");

mysql_query("UPDATE `user_set` SET `baks`=`baks`+'".$data_nagrada['sum_nag']."', `kills`=`kills`+'1', `sanctions`=`sanctions`+'1' WHERE `id`='".$user_id."' LIMIT 1");

header("Location: sanction.php");
exit();
}
}
// Ничья
elseif($ITOG_A==$VRAG_ITOG_Z  AND $vrag_set['hp']>=25){
$hp_user=0;
$hp_vrag=0;
$expa=0;
$baks=0;
mysql_query("UPDATE `user_set` SET `udar`=`udar`-'1', `udar_up`='".time()."' WHERE `id`='".$user_id."' LIMIT 1");
$vrag_set=_FetchAssoc("SELECT * FROM `user_set` WHERE `id`='".$vrag_set['id']."' LIMIT 1");
if($vrag_set['hp']>=25){// Ничья
mysql_query("INSERT INTO `user_voina` (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$vrag_set['id']."','".$dater."','".$timer."','".$hp_vrag."','".$hp_user."','".$baks."','".$expa."','snikt')");
header("Location: sanction.php");
exit();
}
}

// Поражение
elseif($ITOG_A<$VRAG_ITOG_Z  AND $vrag_set['hp']>=25){
$hp_user=($VRAG_ITOG_Z-$ITOG_A)*(10/100);
$hp_vrag=($ITOG_A/$VRAG_ITOG_Z)*10;
$expa=0;
$baks=0;
mysql_query("UPDATE `user_set` SET `hp`=`hp`-'".$hp_user."', `hp_up`='".time()."', `udar`=`udar`-'1', `udar_up`='".time()."' WHERE `id`='".$user_id."' LIMIT 1");
mysql_query("UPDATE `user_set` SET `loses`=`loses`+'1', `raiting_loses`=`raiting_loses`+'1' WHERE `id`='".$user_id."' LIMIT 1");
mysql_query("UPDATE `user_set` SET `hp`=`hp`-'".$hp_vrag."', `hp_up`='".time()."' WHERE `id`='".$vrag_set['id']."' LIMIT 1");
mysql_query("UPDATE `user_set` SET `wins`=`wins`+'1', `raiting_wins`=`raiting_wins`+'1' WHERE `id`='".$vrag_set['id']."' LIMIT 1");
$vrag_set=_FetchAssoc("SELECT * FROM `user_set` WHERE `id`='".$vrag_set['id']."' LIMIT 1");
if($vrag_set['hp']>=25){// Поражение
mysql_query("INSERT INTO `user_voina` (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$vrag_set['id']."','".$dater."','".$timer."','".$hp_vrag."','".$hp_user."','".$baks."','".$expa."','slose')");
header("Location: sanction.php");
exit();
}else{// Разбил армию
mysql_query("INSERT INTO `user_voina` (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$vrag_set['id']."','".$dater."','".$timer."','".$hp_vrag."','".$hp_user."','".$baks."','".$expa."','srazb')");

$data_nagrada=_FetchAssoc("SELECT SUM(`nagrada`) AS `sum_nag` FROM `sanction` WHERE `kto`!='".$user_id."' AND `kogo`='".$vrag_set['id']."' GROUP BY `kogo`");

mysql_query("UPDATE `user_set` SET `hp`=`hp`+'0', `dies`=`dies`+'1' WHERE `id`='".$vrag_set['id']."' LIMIT 1");

mysql_query("UPDATE `user_set` SET `baks`=`baks`+'".$data_nagrada['sum_nag']."', `kills`=`kills`+'1', `sanctions`=`sanctions`+'1' WHERE `id`='".$user_id."' LIMIT 1");

header("Location: sanction.php");
exit();
}


}else{// Армия уже разбита
mysql_query("INSERT INTO `user_voina` (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$vrag_set['id']."','".$dater."','".$timer."','','','','','suzhe')");
header("Location: sanction.php");
exit();
}
break;

}

require_once('system/down.php');
?>
