<?php
$_GET['case']=isset($_GET['case'])?trim(htmlspecialchars($_GET['case'])):NULL;
if($_GET['case']=='ruletka'){
$titles=' | Русская рулетка';
}elseif($_GET['case']=='armrestling'){
$titles=' | Армрестлинг';
}elseif($_GET['case']=='dopros'){
$titles=' | Допрос шпиона';
}elseif($_GET['case']=='veteran'){
$titles=' | Загадка ветерана';
}elseif($_GET['case']=='stengazeta'){
$titles=' | Стенгазета';
}else{
$titles=FALSE;
}
$title = 'Клуб офицеров'.$titles.'';
require_once('system/up.php');
_Reg();
if ($set['block']==1) {
	header("Location: blok.php");
	exit();
}
?><div class="main"><?
switch($_GET['case']){
default:
if($set['logo'] == 'on'){
?><img src="images/logotips/ofclub.jpg" width="100%" alt="Клуб офицеров"/><div class="mini-line"></div><?
}
?><div class="menuList">
<li><a href=""><img src="images/icons/arrow.png" alt="*" />Русская рулетка (в разработке)</a></li>
<li><a href="ofclub.php?case=armrestling"><img src="images/icons/arrow.png" alt="*" />Армрестлинг (в разработке)</a></li>
<li><a href="ofclub.php?case=dopros"><img src="images/icons/arrow.png" alt="*" />Допрос шпиона</a></li>
<li><a href="ofclub.php?case=veteran"><img src="images/icons/arrow.png" alt="*" />Загадка ветерана</a></li>
<li><a href=""><img src="images/icons/arrow.png" alt="*" />Стенгазета (в разработке)</a></li>
</div><div class="mini-line"></div><ul class="hint"><li>В этом разделе представлены мини-игры, которые помогут Вам скоротать время и заработать дополнительные средства.</li></ul><?
break;

case 'dopros':
if($set_ofclub_dopros['start']==1){
$_SESSION['err'] = 'Вы не окончили допрос!';
header('Location: ofclub.php?case=dopros_go');
exit();
}
if(isset($_GET['go'])){
header('Location: ofclub.php?case=dopros_start');
exit();
}
if($set['logo'] == 'on'){
?><img src="images/logotips/dopros.jpg" width="100%" alt="Допрос шпиона"/><div class="mini-line"></div><?
}
$summa=$set['lvl']*100000;
?><div class="menuList">
<li><a href="ofclub.php"><img src="images/icons/arrow.png" alt="*" />Клуб офицеров</a></li>
</div><div class="mini-line"></div><div class="block_zero center"><a class="btn" href="ofclub.php?case=dopros&go"><span class="end"><span class="label"><span class="dgreen">Играть за <img src="images/icons/baks.png" alt="*" /><?=number_format($summa)?></span></span></span></a></div><div class="mini-line"></div><ul class="hint"><li>Цель игры – напугать шпиона (набрать 100 очков), не сильно испачкав пол.</li><li>Если шпион выдаст тайную информацию, Вы получите денежное вознаграждение.</li><li>Каждая зона на теле шпиона дает различное количество очков, но и вероятность попадания в разные зоны отличается.</li><li>Если Вы раните шпиона, то проиграете.</li><li>Помните, что у Вас в наличии только 5 ножей, а размер выигрыша зависит от количества ножей, которые у Вас останутся в конце.</li></ul><?
break;
case 'dopros_start':
$summa=_NumFilter($set['lvl']*100000);
if($summa>$set['baks']){
$_SESSION['err'] = 'Не хватает баксов!';
header('Location: ofclub.php?case=dopros');
exit();
}
mysql_query('UPDATE `ofclub_dopros` SET `start`="1" WHERE `id_user` = "'.$user_id.'"');
mysql_query('UPDATE `user_set` SET `baks`=`baks`-"'.$summa.'" WHERE `id` = "'.$user_id.'"');
header('Location: ofclub.php?case=dopros_go');
exit();
break;
case 'dopros_go':
if($set_ofclub_dopros['start']==0){
$_SESSION['err'] = 'Вы не сделали ставку!';
header('Location: ofclub.php?case=dopros');
exit();
}
if(isset($_GET['bal'])){
$result=mt_rand(1,3);
if($_GET['bal']==30 OR $_GET['bal']==40 OR $_GET['bal']==70 OR $_GET['bal']==100){
if($result==1){
mysql_query('UPDATE `ofclub_dopros` SET `start`="0", `kol`="5", `bal`="0" WHERE `id_user` = "'.$user_id.'"');
$_SESSION['err'] = 'Вы убили шпиона и провалили допрос!';
header('Location: ofclub.php?case=dopros');
exit();
}
if($result==2){
mysql_query('UPDATE `ofclub_dopros` SET `kol`=`kol`-"1" WHERE `id_user` = "'.$user_id.'"');
$_SESSION['err'] = 'Вы промахнулись!';
header('Location: ofclub.php?case=dopros_go');
exit();
}
if($result==3){
mysql_query('UPDATE `ofclub_dopros` SET `kol`=`kol`-"1", `bal`=`bal`+"'._NumFilter($_GET['bal']).'" WHERE `id_user` = "'.$user_id.'"');
$set_ofclub_dopros=_FetchAssoc('SELECT * FROM `ofclub_dopros` WHERE `id_user` = "'.$user_id.'"');
if($set_ofclub_dopros['bal']<100){
if($set_ofclub_dopros['kol']<1){
mysql_query('UPDATE `ofclub_dopros` SET `start`="0", `kol`="5", `bal`="0" WHERE `id_user` = "'.$user_id.'"');
$_SESSION['err'] = 'У Вас закончились ножи!';
header('Location: ofclub.php?case=dopros');
exit();
}
$_SESSION['ok'] = 'Вы напугали шпиона!';
header('Location: ofclub.php?case=dopros_go');
exit();
}else{
mysql_query('UPDATE `ofclub_dopros` SET `start`="0", `kol`="5", `bal`="0" WHERE `id_user` = "'.$user_id.'"');
$summa=_NumFilter($set['lvl']*10000+($set['lvl']*100000*$set_ofclub_dopros['kol']));
mysql_query('UPDATE `user_set` SET `baks`=`baks`+"'.$summa.'" WHERE `id` = "'.$user_id.'"');
$_SESSION['ok'] = 'Вы допросили шпиона!<br/>Ваша награда: <img src="images/icons/baks.png" alt="*"/>'.number_format($summa).'';
header('Location: ofclub.php?case=dopros');
exit();
}
}
}else{
$_SESSION['err'] = 'Нет такой суммы очков!';
header('Location: ofclub.php?case=dopros_go');
exit();
}
}

$set_ofclub_dopros=_FetchAssoc('SELECT * FROM `ofclub_dopros` WHERE `id_user` = "'.$user_id.'"');
?><div class="block_zero center"><br/>Набрано очков: <?=$set_ofclub_dopros['bal']?><br/><br/>Ножей в наличии: <?=$set_ofclub_dopros['kol']?><br/>

<style type="text/css">

.spy{
    width: 232px;
    height: 249px;
    margin: auto;
    background: url("images/dopros/spy.png");
    position: relative;
}

.spy.half{ height: 125px;}

.spy a{
    position: absolute;
    text-align: center;
    opacity: 0.7;
    background: url("images/dopros/1.png");
}

.spy a:hover{ background: url("images/dopros/0.png");}

.spy a b{ position: absolute;}

.spy .head, .spy .head:hover{
    background-position: -86px -15px;
    width: 60px;
    height: 60px;
    left: 86px;
    top: 15px;
}

.head > b{ top: 5px; left: 15px;}

.spy .left_hand, .spy .left_hand:hover{
    background-position: -27px -30px;
    width: 60px;
    height: 60px;
    left: 27px;
    top: 30px;
}

.left_hand > b{ top: 25px; left: 20px;}

.spy .right_hand, .spy .right_hand:hover{
    background-position: -150px -30px;
    width: 60px;
    height: 60px;
    right: 20px;
    top: 30px;
}

.right_hand > b{ top: 25px; right: 23px;}

.spy .groin, .spy .groin:hover{
    background-position: -85px -100px;
    width: 60px;
    height: 60px;
    left: 86px;
    top: 100px;
}

.groin > b{ top: 25px; left: 20px;}

.spy .left_foot, .spy .left_foot:hover{
    background-position: -40px -175px;
    width: 60px;
    height: 60px;
    left: 40px;
    top: 177px;
}

.left_foot > b{ top: 20px; left: 20px;}

.spy .right_foot, .spy .right_foot:hover{
    background-position: 100px 78px;
    width: 60px;
    height: 60px;
    right: 40px;
    top: 173px;
   }
   
.right_foot > b{ top: 25px; left: 25px;}
</style>

<div class="spy">
<img src="images/dopros/1.png" alt="Шпион"/>
<a class="head" href="ofclub.php?case=dopros_go&bal=100"><b>100</b></a>
<a class="right_hand" href="ofclub.php?case=dopros_go&bal=40"><b>40</b></a>
<a class="left_hand" href="ofclub.php?case=dopros_go&bal=40"><b>40</b></a>
<a class="groin" href="ofclub.php?case=dopros_go&bal=70"><b>70</b></a>
<a class="right_foot" href="ofclub.php?case=dopros_go&bal=30"><b>30</b></a>
<a class="left_foot" href="ofclub.php?case=dopros_go&bal=30"><b>30</b></a>
</div>
<?
break;

case 'veteran':
$set_ofclub_veteran=_FetchAssoc('SELECT * FROM `ofclub_veteran`');
if (isset($_POST['go'])) {
    $chislo   = $_POST['chislo'];
    if($set['ofclub_veteran_time_up']!=0){
    $_SESSION['err'] = 'Время ожидания не истекло!';
        header("Location: ofclub.php?case=veteran");
        exit();
    }
    if (empty($chislo)) {
        $_SESSION['err'] = 'Введите число';
        header("Location: ofclub.php?case=veteran");
        exit();
        } elseif (!preg_match('|^[\d]+$|i', $chislo)) {
        $_SESSION['err'] = 'Вводите только цифры';
        header('Location: ofclub.php?case=veteran');
        exit();
        } elseif (mb_strlen($chislo) < 9) {
        $_SESSION['err'] = 'Введенное число меньше 9 цифр!';
        header("Location: ofclub.php?case=veteran");
        exit();
        } elseif (mb_strlen($chislo) > 9) {
        $_SESSION['err'] = 'Введенное число больше 9 цифр!';
        header("Location: ofclub.php?case=veteran");
        exit();
        } elseif ($chislo < 100000000 OR $chislo > 999999999) {
        $_SESSION['err'] = 'Введенно некорректное число!';
        header("Location: ofclub.php?case=veteran");
        exit();
        } elseif ($set_ofclub_veteran['chislo']==$chislo){
        mysql_query("UPDATE `user_set` SET `gold`=`gold`+'25', `ofclub_veteran_time_up`='".(time()+30)."', `ofclub_veteran_chislo`='" . $chislo . "' WHERE `id`='".$user_id."'");
        mysql_query("UPDATE `user_set` SET `ofclub_veteran_chislo`=''");
        mysql_query("UPDATE `user_set` SET `ofclub_veteran_chislo`='100000000' WHERE `id`='1'");
        mysql_query("UPDATE `user_set` SET `ofclub_veteran_chislo`='999999999' WHERE `id`='3'");
        $new_chislo=mt_rand(100000000,999999999);
        mysql_query("UPDATE `ofclub_veteran` SET `id_viner`='".$user_id."', `chislo`='".$new_chislo."', `old_chislo`='".$set_ofclub_veteran['chislo']."' WHERE `id`='1'");
        $_SESSION['ok'] = 'Вы отгадали число!<br/>Ваша награда: <img src="images/icons/gold.png" alt="*"/>25';
        header("Location: ofclub.php?case=veteran");
        exit();
    } else {
$chislo_1=_FetchAssoc('SELECT `ofclub_veteran_chislo` FROM `user_set` WHERE `ofclub_veteran_chislo`<"'.$set_ofclub_veteran['chislo'].'" ORDER BY `ofclub_veteran_chislo` DESC LIMIT 1');
$chislo_2=_FetchAssoc('SELECT `ofclub_veteran_chislo` FROM `user_set` WHERE `ofclub_veteran_chislo`>"'.$set_ofclub_veteran['chislo'].'" ORDER BY `ofclub_veteran_chislo` ASC LIMIT 1');    

if($chislo>$chislo_1['ofclub_veteran_chislo'] AND $chislo<$chislo_2['ofclub_veteran_chislo']){
mysql_query("UPDATE `user_set` SET `ofclub_veteran_chislo`='" . $chislo . "' WHERE `id`='".$user_id."'");
}
mysql_query("UPDATE `user_set` SET `ofclub_veteran_time_up`='".(time()+30)."' WHERE `id`='".$user_id."'");
        $_SESSION['ok'] = 'Вы почти угадали!';
        header("Location: ofclub.php?case=veteran");
        exit();
    }
}
$set_login_ofclub_veteran=_FetchAssoc('SELECT * FROM `user_reg` WHERE `id` = "'.$set_ofclub_veteran['id_viner'].'"');
if($set['logo'] == 'on'){
?><img src="images/logotips/veteran.jpg" width="100%" alt="Загадка ветерана"/><div class="mini-line"></div><?
}
?><div class="menuList">
<li><a href="ofclub.php"><img src="images/icons/arrow.png" alt="*" />Клуб офицеров</a></li>
</div><div class="mini-line"></div><div class="block_zero center">Награда: <img src="images/icons/gold.png" alt="*" />25<div class="separ"></div><center><span class="small grey"><?
?>Победитель прошлой игры: <a href="view.php?smotr=<?= $set_login_ofclub_veteran['id'] ?>"><?=$set_login_ofclub_veteran['login']?></a><br/>Загаданное число прошлой игры: <?=number_format($set_ofclub_veteran['old_chislo'])?></span></div><div class="dot-line"></div><div class="block_zero center">
<?
$chislo_1=_FetchAssoc('SELECT `ofclub_veteran_chislo` FROM `user_set` WHERE `ofclub_veteran_chislo`<"'.$set_ofclub_veteran['chislo'].'" ORDER BY `ofclub_veteran_chislo` DESC LIMIT 1');

$chislo_2=_FetchAssoc('SELECT `ofclub_veteran_chislo` FROM `user_set` WHERE `ofclub_veteran_chislo`>"'.$set_ofclub_veteran['chislo'].'" ORDER BY `ofclub_veteran_chislo` ASC LIMIT 1');

if(($set_ofclub_veteran['chislo']-$chislo_1['ofclub_veteran_chislo'])>($chislo_2['ofclub_veteran_chislo']-$set_ofclub_veteran['chislo'])){
$user_chislo=_FetchAssoc('SELECT * FROM `user_set` WHERE `ofclub_veteran_chislo`="'.$chislo_2['ofclub_veteran_chislo'].'" LIMIT 1');
}else{
$user_chislo=_FetchAssoc('SELECT * FROM `user_set` WHERE  `ofclub_veteran_chislo`="'.$chislo_1['ofclub_veteran_chislo'].'" LIMIT 1');
}

$set_login_ofclub_veteran=_FetchAssoc('SELECT * FROM `user_reg` WHERE `id` = "'.$user_chislo['id'].'"');
if($user_chislo){
?>Ближайшее число: <?=number_format($user_chislo['ofclub_veteran_chislo'])?><br/>Ввёл <a href="view.php?smotr=<?= $set_login_ofclub_veteran['id']?>"><?=$set_login_ofclub_veteran['login']?></a><?
}else{
?>Никто ещё не начал угадывать число!<?
}
?></div><div class="dot-line"></div><div class="block_zero center"><?
if($set['ofclub_veteran_time_up']<time() AND $set['ofclub_veteran_time_up']!=0){
mysql_query("UPDATE `user_set` SET `ofclub_veteran_time_up`='0' WHERE `id`='".$user_id."'");
header('Location: ofclub.php?case= veteran');
exit();
}
if($set['ofclub_veteran_time_up']==0){
?><form action="ofclub.php?case=veteran" method="post">Введите число <span class="small grey">(9 цифр без запятых)</span><br/><input class="text" type="text" maxlength="9" name="chislo"/> <span class="btn"><span class="end"><input class="label" name="go" type="submit" value="Отправить"/></span></span></form><?
}else{
$time = _NumFilter($set['ofclub_veteran_time_up'] - time());
?>До следующей попытки: <?= _Time($time) ?><?
}
?></div><div class="mini-line"></div><ul class="hint"><li>Цель игры – угадать число, которое загадал дедуля.</li><li>Внизу Вы видите последнее, самое близкое к загаданному число.</li><li>Вы можете вводить свои варианты не чаще чем раз в 30 секунд.</li><li>Победитель получит кучу золота.</li><li>Удачи!</li></ul><?
break;

case 'armrestling':

$id_arm=isset($_GET['id'])?_NumFilter($_GET['id']):NULL;

$set_ofclub_arm1=_FetchAssoc('SELECT * FROM `ofclub_armrestling` WHERE `id_user_1` = "'.$user_id.'" AND `start_1` = "1" AND `id` = "'.$id_arm.'" LIMIT 1');
if($set_ofclub_arm1){
$_SESSION['err'] = 'Вы ещё не закончили прошлую игру!';
header('Location: ofclub.php?case=armrestling_rezult&id='.$id_arm.'');
exit();
}
$set_ofclub_arm2=_FetchAssoc('SELECT * FROM `ofclub_armrestling` WHERE `id_user_2` = "'.$user_id.'" AND `start_2` = "1" AND `id` = "'.$id_arm.'" LIMIT 1');

if(!$set_ofclub_arm1){
if($set_ofclub_arm2){
$_SESSION['err'] = 'Вы ещё не закончили прошлую игру!';
header('Location: ofclub.php?case=armrestling_rezult&id='.$id_arm.'');
exit();
}
}

if($set['logo'] == 'on'){
?><img src="images/logotips/armrestling.jpg" width="100%" alt="Армрестлинг"/><div class="mini-line"></div><?
}
$summa=$set['lvl']*100;
?><div class="menuList">
<li><a href="ofclub.php"><img src="images/icons/arrow.png" alt="*" />Клуб офицеров</a></li>
</div><div class="mini-line"></div><div class="block_zero center"><a class="btn" href="ofclub.php?case=armrestling_start"><span class="end"><span class="label"><span class="dgreen">Играть за <img src="images/icons/baks.png" alt="*" /><?=number_format($summa)?></span></span></span></a></div><div class="mini-line"></div><ul class="hint"><li>Игра проходит по принципу "Камень-Ножницы-Бумага".</li><li>Цель игры - уложить противника, совершив серию правильных приемов, предугадав его движения.</li><li>Каждый прием эффективен против одного из трех: "Крюк" эффективен против "Натиска", "Натиск" против "Рывка", а "Рывок" против "Крюка".</li><li>Если игроки совершают тот же прием, ситуация на столе не меняется.</li></ul><?
break;

case 'armrestling_start':
$summa=_NumFilter($set['lvl']*100);
if($summa>$set['baks']){
$_SESSION['err'] = 'Не хватает баксов!';
header('Location: ofclub.php?case=armrestling');
exit();
}
$set_ofclub_arm=_FetchAssoc('SELECT * FROM `ofclub_armrestling` WHERE `start_2`<"2" ORDER BY `id` ASC LIMIT 1');
if($set_ofclub_arm){
if($set_ofclub_arm['id_user_1']==$user_id AND $set_ofclub_arm['start_1']==1){
header('Location: ofclub.php?case=armrestling&id='.$set_ofclub_arm['id'].'');
exit();
}
if($set_ofclub_arm['id_user_2']==$user_id AND $set_ofclub_arm['start_2']==1){
header('Location: ofclub.php?case=armrestling&id='.$set_ofclub_arm['id'].'');
exit();
}
if($set_ofclub_arm['start_2']==0){
mysql_query('UPDATE `ofclub_armrestling` SET `id_user_2`="'.$user_id.'", `start_2`="1" WHERE `id`= "'.$set_ofclub_arm['id'].'"');
$set_ofclub_ar=_FetchAssoc('SELECT * FROM `ofclub_armrestling` WHERE `id_user_2` = "'.$user_id.'" AND `start_1`="1" AND `start_2`="1" LIMIT 1');
}
}else{
mysql_query('INSERT INTO `ofclub_armrestling` SET `id_user_1` = "'.$user_id.'", `start_time_up`="'.(time()+60).'", `start_1`="1"');
$set_ofclub_ar=_FetchAssoc('SELECT * FROM `ofclub_armrestling` WHERE `id_user_1` = "'.$user_id.'" AND `start_1`="1" LIMIT 1');
$_SESSION['ok'] = 'Вы бросили вызов!';
}
mysql_query('UPDATE `user_set` SET `baks`=`baks`-"'.$summa.'" WHERE `id` = "'.$user_id.'"');
header('Location: ofclub.php?case=armrestling_rezult&id='.$set_ofclub_ar['id'].'');
exit();
break;

case 'armrestling_rezult':

$id_arm=isset($_GET['id'])?_NumFilter($_GET['id']):NULL;

$set_ofclub_arm1=_FetchAssoc('SELECT * FROM `ofclub_armrestling` WHERE `id` = "'.$id_arm.'" AND `id_user_1`="'.$user_id.'" AND `start_1`="1" LIMIT 1');

$set_ofclub_arm2=_FetchAssoc('SELECT * FROM `ofclub_armrestling` WHERE `id` ="'.$id_arm.'" AND `id_user_2`="'.$user_id.'" AND `start_2`="1" LIMIT 1');

if(!$set_ofclub_arm1 AND !$set_ofclub_arm2){
$_SESSION['err'] = 'Вы не сделали ставку!';
header('Location: ofclub.php?case=armrestling&id='.$id_arm.'');
exit();
}

$set_login_ofclub_arm1=_FetchAssoc('SELECT `login` FROM `user_reg` WHERE `id` = "'.$set_ofclub_arm1['id_user_2'].'" LIMIT 1');

$set_login_ofclub_arm2=_FetchAssoc('SELECT `login` FROM `user_reg` WHERE `id` = "'.$set_ofclub_arm2['id_user_1'].'" LIMIT 1');

if($set_ofclub_arm1 AND $set_ofclub_arm1['start_time_up']<time() AND $set_ofclub_arm1['start_2']==0){
mysql_query('DELETE FROM `ofclub_armrestling` WHERE `id` = "'.$id_arm.'"');
$summa=_NumFilter($set['lvl']*100);
mysql_query('UPDATE `user_set` SET `baks`=`baks`+"'.$summa.'" WHERE `id` = "'.$user_id.'"');
$_SESSION['err'] = 'Никто не принял Ваш вызов!';
$_SESSION['ok'] = 'Ваша ставка <img src="images/icons/baks.png" alt="*"/>'.$summa.' возвращена!';
header('Location: ofclub.php?case=armrestling');
exit();
}

if($set_ofclub_arm1 AND $set_ofclub_arm1['start_2']==1 AND $set_ofclub_arm1['rezult_1']==0 AND $set_ofclub_arm1['rezult_2']==3){
mysql_query('UPDATE `ofclub_armrestling` SET `rezult_1`="3" WHERE `id` = "'.$id_arm.'"');
$_SESSION['ok'] = 'Игрок '.$set_login_ofclub_arm1['login'].' принял Ваш вызов!';
header('Location: ofclub.php?case=armrestling_rezult&id='.$id_arm.'');
exit();
}

if($set_ofclub_arm2 AND $set_ofclub_arm2['start_2']==1 AND $set_ofclub_arm2['rezult_2']==0){
mysql_query('UPDATE `ofclub_armrestling` SET `rezult_2`="3", `user_1_time_up`="'.(time()+60).'" WHERE `id` = "'.$id_arm.'"');
$_SESSION['ok'] = 'Вы приняли вызов игрока '.$set_login_ofclub_arm2['login'].'!';
header('Location: ofclub.php?case=armrestling_rezult&id='.$id_arm.'');
exit();
}


if($set_ofclub_arm1 AND $set_ofclub_arm1['rezult_1'] == 0){
?><img src="images/logotips/armrestling.jpg" width="100%" alt="Ожидание"/><div class="mini-line"></div><?
}
if($set_ofclub_arm2 AND $set_ofclub_arm2['rezult_2'] == 0){
?><img src="images/logotips/armrestling.jpg" width="100%" alt="Ожидание"/><div class="mini-line"></div><?
}

if($set_ofclub_arm1 AND $set_ofclub_arm1['rezult_1'] == 3){
?><img src="images/armrestling/<?=$set_ofclub_arm1['rezult_1']?>.jpg" width="100%" alt="Ничья-Старт"/><div class="mini-line"></div><?
}
if($set_ofclub_arm2 AND $set_ofclub_arm2['rezult_2'] == 3){
?><img src="images/armrestling/<?=$set_ofclub_arm2['rezult_2']?>.jpg" width="100%" alt="Ничья-Старт"/><div class="mini-line"></div><?
}


?><div class="block_zero center"><?

if($set_ofclub_arm1 AND $set_ofclub_arm1['start_2']==0){
$time=$set_ofclub_arm1['start_time_up']-time();
?>Ожидание противника: <?= _Time($time) ?>

</div><div class="mini-line"></div><ul class="hint"><li>Ожидание противника длиться 1 минуту.</li><li>Если за время ожидания никто не принял Ваш вызов, то Вам будет возвращена Ваша ставка.</li><li>Удачи!</li></ul><?

}else{

if($set_ofclub_arm1 AND $set_ofclub_arm1['user_1_time_up']!=0){

if($set_ofclub_arm1['user_1_time_up']<time() AND $set_ofclub_arm1['start_1']!=2){
mysql_query('UPDATE `ofclub_armrestling` SET `start_1`="2" WHERE `id` = "'.$id_arm.'"');
$_SESSION['err'] = 'Время Вашего хода истекло, Вы проиграли!';
header('Location: ofclub.php?case=armrestling&id='.$id_arm.'');
exit();
}

if($set_ofclub_arm1['user_1_time_up']<time() AND $set_ofclub_arm1['start_1']==2){
$_SESSION['err'] = 'Время Вашего хода истекло, Вы проиграли!';
header('Location: ofclub.php?case=armrestling&id='.$id_arm.'');
exit();
}



$time=$set_ofclub_arm1['user_1_time_up']-time();
?>До завершения Вашего хода: <?= _Time($time) ?>
</div><div class="mini-line"></div><div class="block_zero center">
<a class="btn" href=""><span class="end"><span class="label"><span class="dred">Натиск</span></span></span></a>
<a class="btn" href=""><span class="end"><span class="label"><span class="dgreen">Крюк</span></span></span></a>
<a class="btn" href=""><span class="end"><span class="label"><span class="Admin">Рывок</span></span></span></a><?

}else{



}

}





if($set_ofclub_arm2 AND $set_ofclub_arm2['user_2_time_up']==0){

if($set_ofclub_arm2['user_1_time_up']<time() AND $set_ofclub_arm1['start_1']!=2){
mysql_query('UPDATE `ofclub_armrestling` SET `start_2`="2" WHERE `id` = "'.$id_arm.'"');
$summa=_NumFilter($set['lvl']*100);
mysql_query('UPDATE `user_set` SET `baks`=`baks`+"'.($summa*2).'" WHERE `id` = "'.$user_id.'"');
$_SESSION['ok'] = 'Противник не сделал хода, Вы победили!';
header('Location: ofclub.php?case=armrestling&id='.$id_arm.'');
exit();
}

if($set_ofclub_arm2['user_1_time_up']<time() AND $set_ofclub_arm1['start_1']==2){
$summa=_NumFilter($set['lvl']*100);
mysql_query('UPDATE `user_set` SET `baks`=`baks`+"'.($summa*2).'" WHERE `id` = "'.$user_id.'"');
$_SESSION['ok'] = 'Противник не сделал хода, Вы победили!';
header('Location: ofclub.php?case=armrestling&id='.$id_arm.'');
exit();
}




$time=$set_ofclub_arm2['user_1_time_up']-time();
?>Ваш ход через: <?= _Time($time) ?><?






}else{







}








break;








}
?></div></div><?
require_once('system/down.php');
?>
