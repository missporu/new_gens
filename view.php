<?php
$title='Просмотр';
require_once 'system/up.php';
$user = new RegUser();
$sql = new SafeMySQL();
$site = new Site();

$user->_Reg();

try {
    if($user->getBlock()) {
        throw new Exception(message: 'Вы заблокированы администрацией проекта!');
    }

    if (isset($_GET['user'])) {
        $smott = isset($_GET['user']) ? Filter::clearFullSpecialChars(string: $_GET['user']) : null;
        if ($smott != false || $smott != null) {
            $smotri = $sql->getOne("select count(id) from users where login = ?s limit ?i", $smott, 1);
            if ($smotri == 1) {
                $smotr = $sql->getRow("select * from users where login = ?s limit ?i", $smott, 1);
            } else {
                Site::session_empty(type: 'error', text: 'Ошибка! Такого пользователя нет!', location: 'menu');
            }
        } else {}
    }

    $site->setSwitch(get: 'a');
    switch ($site->switch) {
        default: ?>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <p><?= $smotr['login'] ?></p>
                    </div>
                </div>
            </div><?php
            break;
    }
} catch (Exception $e) { ?>
    <div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <h3 class="red">
                <?= $e->getMessage() ?>
            </h3>
            <p class="green">До автоматической разблокировки осталось <?= Times::timeHours(time: $user->user(key: 'block_time') - time()) ?></p>
        </div>
    </div>
    </div><?php
}
/*
if ($set['block']==1) {
    header("Location: blok.php");
    exit();
}
$smott=isset($_GET['smotr'])?_NumFilter($_GET['smotr']):NULL;
$smotr=$sql->getRow("SELECT * FROM user_reg WHERE id=?i LIMIT ?i",$smott,1);
$smotr_set=$sql->getRow("SELECT * FROM user_set WHERE id=?i LIMIT ?i",$smotr[id],1);
$fataliti_vrag=$sql->getRow("SELECT * FROM user_fataliti WHERE id_user=?i LIMIT ?i",$smotr[id],1);
$priglas=_NumRows("SELECT * FROM alliance_priglas WHERE id_user='".$user_id."' AND kogo='".$smotr['id']."'");
$vstupil=_NumRows("SELECT * FROM alliance_user WHERE kto='".$user_id."' AND s_kem='".$smotr['id']."'");
$vstupil2=_NumRows("SELECT * FROM alliance_user WHERE kto='".$smotr['id']."' AND s_kem='".$user_id."'");
$smotr_alliance=_NumRows("SELECT * FROM alliance_user WHERE kto='".$smotr['id']."' OR s_kem='".$smotr['id']."'");
if($smotr_set['sex']=='w') {
    $pol='Девушка';
} elseif($smotr_set['sex']=='m') {
    $pol='Парень';
} else {
    $pol='Не известно';
}

if($smotr_set['side'] == 'r') {
    $strana_smotr='Россия';
} 
elseif ($smotr_set['side'] == 'g') {
    $strana_smotr='Германия';
} 
elseif ($smotr_set['side'] == 'a') {
    $strana_smotr='США';
} 
elseif ($smotr_set['side'] == 'u') {
    $strana_smotr='Украина';
} 
elseif ($smotr_set['side'] == 'b') {
    $strana_smotr='Белоруссия';
} 
elseif ($smotr_set['side'] == 'c') {
    $strana_smotr='Китай';
} 
elseif ($smotr_set['side'] == 'k') {
    $strana_smotr='Казахстан';
} 
else {
    $strana_smotr='Не известно';
}

$left=_FetchAssoc("SELECT * FROM user_reg WHERE id='".$fataliti_vrag['uho1_kto']."' LIMIT 1");
$right=_FetchAssoc("SELECT * FROM user_reg WHERE id='".$fataliti_vrag['uho2_kto']."' LIMIT 1");

if($fataliti_vrag['uho1_kto'] != 0 AND $fataliti_vrag['uho2_kto'] != 0) {
$uho='_2';
} elseif($fataliti_vrag['uho1_kto'] != 0) {
$uho='_1';
} elseif($fataliti_vrag['uho2_kto'] != 0) {
$uho='_1';
} else {
$uho=FALSE;
}

$smotr_naem=_FetchAssoc('SELECT * FROM user_naemniki WHERE id_user="'.$smotr['id'].'" AND id_naemnik="4" LIMIT 1');

$user_naem_lara=_FetchAssoc('SELECT * FROM user_naemniki WHERE id_user="'.$user_id.'" AND id_naemnik="5" LIMIT 1');

$smotr_naem_lara=_FetchAssoc('SELECT * FROM user_naemniki WHERE id_user="'.$smotr['id'].'" AND id_naemnik="5" LIMIT 1');

switch($_GET['case']){
default:

echo'<div class="main">';
/* Админам
if($set['prava']>3){
    echo'<a href="admin.php?case=3_1&id='.$smotr['id'].'">Проверить на мультоводство</a> | ';
    echo'<a href="admin.php?case=mail&id='.$smotr['id'].'">Посмотреть исходящюю почту игрока</a> | ';
    if ($smotr_set['prava']>=1 && $set['prava']>=4) {
        echo'<a href="?case=zipp&smotr='.$smotr['id'].'">Выдать з/п</a> | ';
    }
    echo'<a href="admin.php?case=mailer&id='.$smotr['id'].'">Посмотреть входящюю почту игрока</a> | ';
}
/* Ст.Модерам и выше
if ($set['prava']>2) {
    echo'<a href="?case=block&smotr='.$smotr['id'].'">Заблокировать</a> | 
    <a href="?case=razblock&smotr='.$smotr['id'].'">Разблокировать</a> | 
    <a href="admin.php?case=1_1&id='.$smotr['id'].'">Редактировать</a> | 
    <a href="?case=podarok&smotr='.$smotr['id'].'">Выдать индивидуальный подарок сервера</a> | ';
    echo'<a href="?case=logi&smotr='.$smotr['id'].'">Посмотреть лог последних 50 покупок</a> | ';


}
/* Модерам и выше
if ($set['prava']>1) {
    echo'<a href="?case=ban&smotr='.$smotr['id'].'">Забанить</a> | ';
    if ($smotr_set['skill_full']==0 || $set['prava']>3) {
        echo'<a href="?case=redu&smotr='.$smotr['id'].'">Редактор сброса уровней / навыков</a> | ';
    }
}
/* Админам
if($set['prava']>=4){
echo'<a href="?case=status&smotr='.$smotr['id'].'">Изменить статус</a> | ';
}

if ($set['prava']>1 AND $set['prava']<4) {
    echo'<a href="moder.php?case=3_1&id='.$smotr['id'].'">Посмотреть мультов игрока</a> | ';
}

echo'<div class="block_zero">';
if ($smotr_set['prava'] == 1) {
    $dolg = '<span style="color: #fffabd;">Должность</span> : <span style="color: #ff0;">Советник игры</span>';
} elseif ($smotr_set['prava'] == 2) {
    $dolg = '<span style="color: #fffabd;">Должность</span> : <span style="color: #ff0;">Модератор игры</span>';
} elseif ($smotr_set['prava'] == 3) {
    $dolg = '<span style="color: #fffabd;">Должность</span> : <span style="color: #ff0;">Старший модератор</span>';
} elseif ($smotr_set['prava'] == 4) {
    $dolg = '<span style="color: #fffabd;">Должность</span> : <span style="color: #ff0;">Администратор (Тех.поддержка) игры</span>';
} elseif ($smotr_set['prava'] == 5) {
    $dolg = '<span style="color: #fffabd;">Должность</span> : <span style="color: #ff0;">Разработчик</span>';
} else {
    $dolg = '';
}
echo'<img src="images/flags/'.$smotr_set['side'].'.png"  alt="Флаг" /> '.$smotr['login'].' <small><span style="color: #fffabd;"> Ур.</span> '.$smotr_set['lvl'].', <span style="color: #fffabd;"></span><span style="color: #fffabd;">Ал.</span> '.($smotr_alliance+1).', <span style="color: #fffabd;"> Рейтинг</span> '.$smotr_set['raiting'].'</small> '.$dolg.' . ';
if ($smotr_set['online'] > (time()-600)) {
    echo "Online";
} else {
    if ($smotr_set['sex']=='w') {
        $sexxx = 'a';
    } else {$sexxx = '';}
    echo "Последний раз замечен".$sexxx." ".$smotr_set['last_date_visit']." в ".$smotr_set['last_time_visit']."";
}
echo'<div class="mini-line"></div>';

echo "<span style=\"color: #fffabd;\">Статус:</span> <span style=\"color: #0f0;\">"._Smile($smotr_set['status'])."</span>";
echo'<div class="mini-line"></div>';
if ($smotr_set['ban']==1) {
    $timeban = ($smotr_set['ban_time']-time());
    echo "Забанен на "._Time($timeban)."";
    if ($set['prava']>=2) { ?>
        <a href="?case=razban&smotr=<?=$smotr_set['id'] ?>"> Разбанить</a><?
    }
}
if ($smotr_set['block']==1) {
    $timeblock1 = ($smotr_set['block_time']-time());
    echo "<span style='color:red;'>Персонаж заблокирован за нарушение Правил игры на "._DayTime($timeblock1)." </span>";
}

echo'<div class="mini-line"></div>';

if($smotr_naem['status']!=1 OR ($smotr_naem['status']==1 AND $user_naem_lara['status']==1 AND $smotr_naem_lara['status']!=1) OR $set['prava']>=4){

echo'<table width="100%"><tr><td width="25%">';

echo'<img class="float-left img-responsive" src="images/avatars/'.$smotr_set['avatar'].''.$uho.'.jpg" style="margin-left:10px;margin-right:15px;border:2px solid grey;" alt="Аватар">';

echo'</td><td>';

echo'Страна:<span style="float: right;">'.$strana_smotr.'</span><br />';

echo'Звание:<span style="float: right;">'.$smotr_set['zvanie'].'</span><br />';

echo'Пол:<span style="float: right;">'.$pol.'</span><br />';

echo'Побед:<span style="float: right;">'.$smotr_set['wins'].'</span><br />';

echo'Поражений:<span style="float: right;">'.$smotr_set['loses'].'</span><br />';

echo'Убийств:<span style="float: right;">'.$smotr_set['kills'].'</span><br />';

echo'Смертей:<span style="float: right;">'.$smotr_set['dies'].'</span><br />';

echo'Ушей:<span style="float: right;">'.$smotr_set['uho'].'</span><br />';

echo'Жетонов:<span style="float: right;">'.$smotr_set['zheton'].'</span><br />';

echo'</td></tr></table>';

echo'<div class="mini-line"></div>';
if ($set['prava']>1) {
    mysql_query("UPDATE user_set SET id_vrag='".$smotr_set['id']."' WHERE id='".$set['id']."' LIMIT 1 ");
    echo'<div class="block_zero">Боевая эффективность:<br />';
    echo'Атака: '.number_format_short($VRAG_ITOG_A).'<br>';
    echo'Защита: '.number_format_short($VRAG_ITOG_Z).'<br>';
} ?>
<ul class="list-group"><?php
    if($fataliti_vrag['uho1_kto'] != 0) { ?>
        <li class="list-group-item">
            <span class="badge"><?php echo '<a href="view.php?smotr='.$left['id'].'">'.$left['login'].'</a>'; ?></span>
            Левое ухо у:
        </li><?php
    }
    if($fataliti_vrag['uho2_kto'] != 0) { ?>
        <li class="list-group-item">
            <span class="badge"><?php echo '<a href="view.php?smotr='.$right['id'].'">'.$right['login'].'</a>'; ?></span>
            Правое ухо у:
        </li><?php
    } ?>
</ul><?php
}else{

?><table width="100%"><tr><td width="40%"><img src="images/naemniki/4.jpg" style="border:1px solid #999;" alt="Наёмник"></td><td valign="top"><small>Личность непонятной наружности преграждает Вам путь. Здравствуйте! А Вам кого? Хм, нет здесь такого. Какие танки? Не было их. Оружие?! Отродясь не видел. А Вы, извините, зачем интересуетесь? А Вы, кстати, кто?!!</small></td></tr></table><div class="mini-line"></div><?

}//наёмники

echo'<div class="block_zero center">';

if($smotr['id']==$user_id){
header("Location: pers.php");
exit();
}elseif($vstupil == 1 OR $vstupil2 == 1) {
echo'<a class="text-warning" href=""><span class="end"><span class="label"><span class="dgreen">Отправить подкрепление</span></span></span></a></div><div class="menuList">';
} elseif($priglas == 0) {
if($smotr_set['lvl']<($set['lvl']+11) AND $smotr_set['lvl']>($set['lvl']-11)){
echo'<a class="text-warning" href="voina.php?case=ataka&vrag='.$smotr['id'].'"><span class="end"><span class="label"><span class="dred">Атаковать</span></span></span></a>';
}
echo' <a class="text-warning" href="view.php?case=priglas&smotr='.$smotr['id'].'"><span class="end"><span class="label"><span class="dgreen">Пригласить в альянс</span></span></span></a>';
if($smotr_set['lvl']<($set['lvl']+11) AND $smotr_set['lvl']>($set['lvl']-11)){
echo'</div><div class="mini-line"></div><div class="menuList"><li><a href="view.php?case=sanction&log='.$smotr['id'].'"><img src="images/icons/ataka.png" alt="*"/>Добавить в санкции</a></li></div>';
}
} else {
echo'<small><span class="green">Отправлено приглашение в альянс</span></small></div><div class="menuList">';
}
if($smotr_set['lvl']<($set['lvl']+11) AND $smotr_set['lvl']>($set['lvl']-11)){
echo'<div class="mini-line"></div><div class="menuList"><li><a href="mail.php?case=post&log='.$smotr['id'].'"><img src="images/icons/mail.png" alt="*"/>Написать</a></li>';
}else{
echo'</div><div class="mini-line"></div><div class="menuList"><li><a href="mail.php?case=post&log='.$smotr['id'].'"><img src="images/icons/mail.png" alt="*"/>Написать</a></li>';
}

echo'</div>';

if($smotr_naem['status']!=1 OR ($smotr_naem['status']==1 AND $user_naem_lara['status']==1 AND $smotr_naem_lara['status']!=1) || $set['prava']>4){

?><div class="mini-line"></div><div class="block_zero"><span style="color: #9c9;">Наземная техника</span></div><?

$data=mysql_query("SELECT * FROM user_unit WHERE tip IN('1','4') AND id_user='".$smotr['id']."' ORDER BY id ASC");
?><table><tr><?
$cols = 0;
$maxcols = 4;
while($my_unit=mysql_fetch_assoc($data)){
if($my_unit['kol']>0){
if($my_unit['tip']==4){
$unit_color='f96';
}else{
$unit_color='999';
}
++$cols;
?><td><img src="images/units/<?= $my_unit['id_unit'] ?>.png" width="65px" height="45px" style="border:1px solid #<?=$unit_color?>;" alt="Техника"><br/><center><small><?= $my_unit['kol'] ?></small></center></td><?
}
if ($cols == $maxcols) {
?></tr><tr><?
$cols = 0;
}
} 
?></table><?

?><div class="dot-line"></div><div class="block_zero"><span style="color: #9c9;">Морская техника</span></div><?

$data=mysql_query("SELECT * FROM user_unit WHERE tip IN('2','5') AND id_user='".$smotr['id']."' ORDER BY id ASC");
?><table><tr><?
$cols = 0;
$maxcols = 4;
while($my_unit=mysql_fetch_assoc($data)){
if($my_unit['tip']==5){
$unit_color='f96';
}else{
$unit_color='999';
}
if($my_unit['kol']>0){
++$cols;
?><td><img src="images/units/<?= $my_unit['id_unit'] ?>.png" width="65px" height="45px" style="border:1px solid #<?=$unit_color?>;" alt="Техника"><br/><center><small><?= $my_unit['kol'] ?></small></center></td><?
}
if ($cols == $maxcols) {
?></tr><tr><?
$cols = 0;
}
} 
?></table><?

?><div class="dot-line"></div><div class="block_zero"><span style="color: #9c9;">Воздушная техника</span></div><?

$data=mysql_query("SELECT * FROM user_unit WHERE tip IN('3','6') AND id_user='".$smotr['id']."' ORDER BY id ASC");
?><table><tr><?
$cols = 0;
$maxcols = 4;
while($my_unit=mysql_fetch_assoc($data)){
if($my_unit['tip']==6){
$unit_color='f96';
}else{
$unit_color='999';
}
if($my_unit['kol']>0){
++$cols;
?><td><img src="images/units/<?= $my_unit['id_unit'] ?>.png" width="65px" height="45px" style="border:1px solid #<?=$unit_color?>;" alt="Техника"><br/><center><small><?= $my_unit['kol'] ?></small></center></td><?
}
if ($cols == $maxcols) {
?></tr><tr><?
$cols = 0;
}
} 
?></table><?

?><div class="dot-line"></div><div class="block_zero"><span style="color: #9c9;">Секретные разработки</span></div><?

$data=mysql_query("SELECT * FROM user_superunit WHERE id_user='".$smotr['id']."' ORDER BY id ASC");
?><table><tr><?
$cols = 0;
$maxcols = 4;
while($my_unit=mysql_fetch_assoc($data)){
if($my_unit['kol']>0){
++$cols;
?><td><img src="images/superunits/<?= $my_unit['id_unit'] ?>.png" width="65px" height="45px" style="border:1px solid #999;" alt="Техника"><br/><center><small><?= $my_unit['kol'] ?></small></center></td><?
}
if ($cols == $maxcols) {
?></tr><tr><?
$cols = 0;
}
} 
?></table><?

?><div class="dot-line"></div><div class="block_zero"><span style="color: #9c9;">Доходные постройки</span></div><?

$data=mysql_query("SELECT * FROM user_build WHERE tip='1' AND id_user='".$smotr['id']."' ORDER BY id ASC");
?><table><tr><?
$cols = 0;
$maxcols = 4;
while($my_build=mysql_fetch_assoc($data)){
if($my_build['kol']>0){
++$cols;
?><td><img src="images/buildings/<?= $my_build['id_build'] ?>.png" width="65px" height="45px" style="border:1px solid #999;" alt="Техника"><br/><center><small><?= $my_build['kol'] ?></small></center></td><?
}
if ($cols == $maxcols) {
?></tr><tr><?
$cols = 0;
}
} 
?></table><?

?><div class="dot-line"></div><div class="block_zero"><span style="color: #9c9;">Защитные постройки</span></div><?

$data=mysql_query("SELECT * FROM user_build WHERE tip='2' AND id_user='".$smotr['id']."' ORDER BY id ASC");
?><table><tr><?
$cols = 0;
$maxcols = 4;
while($my_build=mysql_fetch_assoc($data)){
if($my_build['kol']>0){
++$cols;
?><td><img src="images/buildings/<?= $my_build['id_build'] ?>.png" width="65px" height="45px" style="border:1px solid #999;" alt="Техника"><br/><center><small><?= $my_build['kol'] ?></small></center></td><?
}
if ($cols == $maxcols) {
?></tr><tr><?
$cols = 0;
}
} 
?></table><?

?><div class="dot-line"></div><div class="block_zero"><span style="color: #9c9;">Энергетические постройки</span></div><?

$data=mysql_query("SELECT * FROM user_build WHERE tip='3' AND id_user='".$smotr['id']."' ORDER BY id ASC");
?><table><tr><?
$cols = 0;
$maxcols = 4;
while($my_build=mysql_fetch_assoc($data)){
if($my_build['kol']>0){
++$cols;
?><td><img src="images/buildings/<?= $my_build['id_build'] ?>.png" width="65px" height="45px" style="border:1px solid #999;" alt="Техника"><br/><center><small><?= $my_build['kol'] ?></small></center></td><?
}
if ($cols == $maxcols) {
?></tr><tr><?
$cols = 0;
}
} 
?></table><?

}

?></div></div><?


break;
case 'priglas':
$data=_FetchAssoc("SELECT * FROM alliance_priglas WHERE id_user='".$user_id."' AND kogo='".$smotr['id']."'");
if($data){
$_SESSION['err']='Уже было отправлено приглашение';
header('Location: view.php?smotr='.$smotr['id'].'');
exit();
}
if($set['diplomat'] == 0) {
$_SESSION['err']='Нет свободных дипломатов';
header('Location: view.php?smotr='.$smotr['id'].'');
exit();
}
mysql_query("INSERT INTO alliance_priglas (id_user,kogo,priglas_up) VALUES ('".$user_id."','".$smotr['id']."','"._NumFilter(time()+10800)."')");
mysql_query("INSERT INTO alliance_diplom (id_user,diplom_up) VALUES ('".$user_id."','"._NumFilter(time()+3600)."')");
mysql_query('UPDATE user_set SET diplomat=diplomat - "1" WHERE id="'.$user_id.'"');
$_SESSION['ok']='Отправлено приглашение в альянс';
header('Location: view.php?smotr='.$smotr['id'].'');
exit();
break;

case 'sanction':
$sanction_id=isset($_GET['log'])?_NumFilter($_GET['log']):NULL;
if(!$sanction_id){
$_SESSION['err']='Не выбран игрок для добавления в санкции!';
header('Location: menu.php');
exit();
}
$set_sanction=_FetchAssoc("SELECT lvl FROM user_set WHERE id='".$sanction_id."' LIMIT 1");
if($set['lvl']<($set_sanction['lvl']-10)){
$_SESSION['err']='Уровень противника больше, чем на 10!';
header('Location: menu.php');
exit();
}
if($set['lvl']>($set_sanction['lvl']+10)){
$_SESSION['err']='Уровень противника меньше, чем на 10!';
header('Location: menu.php');
exit();
}
if($sanction_id==$user_id){
$_SESSION['err']='Вы пытаетесь добавить в санкции<br/>самого себя!';
header('Location: menu.php');
exit();
}
$login_sanction=_FetchAssoc("SELECT login FROM user_reg WHERE id='".$sanction_id."' LIMIT 1");

$data_sanction=_FetchAssoc("SELECT * FROM sanction WHERE kto='".$user_id."' AND kogo='".$sanction_id."' LIMIT 1");
if(!$data_sanction){
mysql_query("INSERT INTO sanction (kto,kogo,data) VALUES ('".$user_id."','".$sanction_id."','".$dater."')");
header('Location: view.php?case=sanction&log='.$sanction_id.'');
}

if(isset($_POST['send'])){
$sanction_id=isset($_GET['log'])?_NumFilter($_GET['log']):NULL;
$data_sanction=_FetchAssoc("SELECT * FROM sanction WHERE kto='".$user_id."' AND kogo='".$sanction_id."' LIMIT 1");
if(!$sanction_id){
$_SESSION['err']='Не выбран игрок для добавления в санкции!';
header('Location: menu.php');
exit();
}
if($sanction_id==$user_id){
$_SESSION['err']='Вы пытаетесь добавить в санкции<br/>самого себя!';
header('Location: menu.php');
exit();
}
$sanction_summa=isset($_POST['summa'])?_NumFilter($_POST['summa']):NULL;
if(($data_sanction['stavka']*$set['lvl'])>$sanction_summa){
$_SESSION['err']='Вы ввели ссумму, которая<br/> меньше минимального вознаграждения!';
header('Location: view.php?case=sanction&log='.$sanction_id.'');
exit();
}
if($set['baks']<$sanction_summa){
$_SESSION['err']='Не хватает баксов!';
header('Location: view.php?case=sanction&log='.$sanction_id.'');
exit();
}
$login_sanction=_FetchAssoc("SELECT login FROM user_reg WHERE id='".$sanction_id."' LIMIT 1");
$sex_sanction=_FetchAssoc("SELECT sex FROM user_set WHERE id='".$sanction_id."' LIMIT 1");
mysql_query("UPDATE sanction SET data='".$dater."', time_up='".(time()+3600)."', nagrada=nagrada+'".$sanction_summa."', stavka='".($data_sanction['stavka']*2)."' WHERE kto='".$user_id."' AND kogo='".$sanction_id."' LIMIT 1");
mysql_query("UPDATE user_set SET sanction_status='1' WHERE id='".$sanction_id."' LIMIT 1");
mysql_query("UPDATE user_set SET baks=baks-'".$sanction_summa."' WHERE id='".$user_id."' LIMIT 1");
mysql_query("INSERT INTO user_voina (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES ('".$user_id."','".$sanction_id."','".$dater."','".$timer."','','','','','spopa')");
if($sex_sanction['sex']=='m'){
$kto='ним';
}else{
$kto='ней';
}
$_SESSION['ok']='Вы добавили '.$login_sanction['login'].' в санкции.<br/>Скоро с '.$kto.' поквитаются!';
header('Location: view.php?smotr='.$sanction_id.'');
}

?><div class="main"><div class="menuList"><li><a href="voina.php?case=vrag"><img src="images/icons/ataka.png" alt="*"/>Война</a></li></div><div class="mini-line"></div><div class="block_zero center"><h1 class="yellow">Добавление в санкции</h1></div><div class="mini-line"></div><div class="block_zero center"><?

if($data_sanction AND $data_sanction['time_up']!=0){
$time = $data_sanction['time_up'] - time();
?>Добавлять одного и того же игрока в санкции можно не чаще, чем раз в час.<br/>Осталось: <?=_Time($time)?></div></div><?
}else{
?>Вы собираетесь добавить <?=$login_sanction['login']?> в санкции. Минимальное вознаграждение <img src="images/icons/baks.png" alt="*"/> <?=number_format($data_sanction['stavka']*$set['lvl'])?></div><div class="dot-line"></div><div class="block_zero center">Введите сумму вознаграждения:<form action="view.php?case=sanction&log=<?=$sanction_id?>" method="post"><input class="text" type="text" name="summa" size="30" value="<?=($data_sanction['stavka']*$set['lvl']*100000)?>"/><br/><span class="btn"><span class="end"><input class="label" type="submit" name="send" value="Огласить санкцию"></span></span> </a></form></div><div class="mini-line"></div><ul class="hint"><li>Здесь можно добавить в санкции игрока, заплатив за его голову вознаграждение.</li></ul></div><?
}
break;


case 'status': 
if ($set['prava'] >=4) {?>
<style>
    textarea {
        color: #000;
    }
</style><?
if ($_GET[mod]==save){
if(!$_POST[text]){$stt="FALSE";}else{$stt=$_POST['text'];}
$ressave = $sql->query ("UPDATE user_set SET status=?s WHERE id=?i LIMIT ?i",$stt,$smotr_set[id],1);
         
$text = htmlspecialchars(addslashes($stt));

if (strlen($text)>255) { echo"<font color=#ff4040>Длиное сообщение!</font>";}else{

$sql->query ("UPDATE user_set SET status=?s WHERE id=?i LIMIT ?i",$text,$smotr_set[id],1);}
         
                if ($ressave == 'true')
                    {
                    echo '<font color=#f4d06e><p>Статус сохранён!</p></font>'; // удачно
                    echo "<div class=news><font color=#ff4040>Некоторые изменения вступят в силу после обновления страници.</font></div>";
                    }
                    else
                    {
                    echo "<font color=#ff4040><p> Неудача ! </p></font>";  // неудачно =)
                    }



} 
    echo'<form action="?case=status&mod=save&smotr='.$smotr[id].'" method="post">';
        echo 'Статус (255макс):
            <br/><textarea name="text" rows="3" maxlength="255">'.$smotr_set['status'].'</textarea><hr/>';


echo '<input class="button" type="submit" value="Сохранить" /></form>';
}
    break;




case 'razban':
    if ($set['prava'] < 2) {
        $text = ''.$set['user'].' Пытался разбанить персонажа '.$smotr_set['user'].' .';
        mysql_query("INSERT INTO chat SET id_user = '3', text = '" . $text . "', time = '" . $timer . "', date = '" . $dater . "', tip = '10'");
        mysql_query("INSERT INTO chat2 SET id_user = '3', text = '" . $text . "', time = '" . $timer . "', date = '" . $dater . "', tip = '10'");
        $_SESSION['err'] = 'Не имеете прав на это действие!';
        header("Location: menu.php");
        exit();    
    }
    $text_raz = " Разбанил персонажа ".$smotr_set['user']."";
    mysql_query("INSERT INTO admin_logi SET id_user = '".$set['id']."', user = '".$set['user']."', text = '" . $text_raz . "' ");
    mysql_query("UPDATE user_set SET ban='0' WHERE id = '".$smotr_set['id']."' LIMIT 1");
    $_SESSION['ok'] = 'Персонаж '.$smotr_set['user'].' успешно разбанен';
    header("Location: ?smotr=".$smotr_set['id']."");
    exit();
    break;

case 'ban':
    if ($set['prava'] < 2) {
        $text = ''.$set['user'].' Пытался зaбанить персонажа '.$smotr_set['user'].' .';
        mysql_query("INSERT INTO chat SET id_user = '3', text = '" . $text . "', time = '" . $timer . "', date = '" . $dater . "', tip = '10'");
        mysql_query("INSERT INTO chat2 SET id_user = '3', text = '" . $text . "', time = '" . $timer . "', date = '" . $dater . "', tip = '10'");
        $_SESSION['err'] = 'Не имеете прав на это действие!';
        header("Location: menu.php");
        exit();    
    }


    if (isset($_POST['lovi_ban_nax'])) {
    $prichin_ban = _TextFilter($_POST['prichina_ban_za']);
    $getto = $_POST['timeban']*60;
    $timeban = ($getto+time());
    mysql_query("INSERT INTO block SET id= NULL, kto = '" . $smotr_set['id'] . "', kem = '" . $set['id'] . "', time = '" . $timer . "', data = '" . $dater . "', tip = '1', text = '" . $prichin_ban . "', vremya = '" . $getto . "' ");
    mysql_query("UPDATE user_set SET ban='1', ban_time='".$timeban."' WHERE id = '".$smotr_set['id']."' LIMIT 1");
    
    $_SESSION['ok'] = 'Персонаж '.$smotr_set['user'].' успешно забанен на '.$_POST['timeban'].' минут';
    header("Location: ?smotr=".$smotr_set['id']."");
    exit();
    } else { ?>
        <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
            Введите время в минутах (по умолчанию 10 минут) <br>
            <input type="text" name="timeban" value="10" /><br>
            Введите причину <br>
            <input type="text" name="prichina_ban_za" value="" /><br><br>
            <input type="submit" name="lovi_ban_nax" value="Забанить">
        </form><br><hr>
        История нарушений <span style="color: #0f0;"><?=$smotr_set['user'] ?></span> : <hr> <?php
        $storis999ban = mysql_query("SELECT * FROM block WHERE kto = '".$smotr_set['id']."' AND tip='1' ");
        while ($storis_ban = mysql_fetch_array($storis999ban)) {
            $sopos9999 = _FetchAssoc("SELECT * FROM user_set WHERE id='".$storis_ban['kem']."' LIMIT 1");
            $vremya_ban = $storis_ban['vremya']; ?>
            <?=$storis_ban['data'] ?> в <?=$storis_ban['time'] ?> <br>
            Причина: "<?=$storis_ban['text'] ?>" на <?=_Time($vremya_ban) ?>  <br>
            Бан дал - <?=$sopos9999['user'] ?> <br><hr> <?php
        } 

    } // end of form

    break;

case 'razblock':
    if ($set['prava'] < 2) {
        $text = ''.$set['user'].' Пытался разблочить персонажа '.$smotr_set['user'].' .';
        mysql_query("INSERT INTO chat SET id_user = '3', text = '" . $text . "', time = '" . $timer . "', date = '" . $dater . "', tip = '10'");
        mysql_query("INSERT INTO chat2 SET id_user = '3', text = '" . $text . "', time = '" . $timer . "', date = '" . $dater . "', tip = '10'");
        $_SESSION['err'] = 'Не имеете прав на это действие!';
        header("Location: menu.php");
        exit();    
    }
    $text_raz = " Разблокировал персонажа ".$smotr_set['user']."";
    mysql_query("INSERT INTO admin_logi SET id_user = '".$set['id']."', user = '".$set['user']."', text = '" . $text_raz . "' ");
    mysql_query("UPDATE user_set SET block='0' WHERE id = '".$smotr_set['id']."' LIMIT 1");
    $_SESSION['ok'] = 'Персонаж '.$smotr_set['user'].' успешно разблокирован';
    header("Location: ?smotr=".$smotr_set['id']."");
    exit();
    break;

case 'block':
    if ($set['prava'] < 3) {
        $text = ''.$set['user'].' Пытался зaблочить персонажа '.$smotr_set['user'].' .';
        mysql_query("INSERT INTO chat SET id_user = '3', text = '" . $text . "', time = '" . $timer . "', date = '" . $dater . "', tip = '10'");
        mysql_query("INSERT INTO chat2 SET id_user = '3', text = '" . $text . "', time = '" . $timer . "', date = '" . $dater . "', tip = '10'");
        $_SESSION['err'] = 'Не имеете прав на это действие!';
        header("Location: menu.php");
        exit();    
    }


    if (isset($_POST['submitted'])) {
    $prichin_block = _TextFilter($_POST['prichina_block_za']);
    $gett = $_POST['timeblock']*60*60*24;
    $timeblock = ($gett+time());
    mysql_query("INSERT INTO block SET id= NULL, kto = '" . $smotr_set['id'] . "', kem = '" . $set['id'] . "', time = '" . $timer . "', data = '" . $dater . "', tip = '2', text = '" . $prichin_block . "', vremya = '" . $gett . "' ");
    mysql_query("UPDATE user_set SET block='1', block_time='".$timeblock."' WHERE id = '".$smotr_set['id']."' LIMIT 1");
    
    $_SESSION['ok'] = 'Персонаж '.$smotr_set['user'].' успешно заблокирован на '.$_POST['timeblock'].' дней';
    header("Location: ?smotr=".$smotr_set['id']."");
    exit();
    } else { ?>
        <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
            Введите время в днях (по умолчанию 10 дней) <br>
            <input type="text" name="timeblock" value="10" /><br>
            Введите причину <br>
            <input type="text" name="prichina_block_za" value="" /><br><br>
            <input type="submit" name="submitted" value="Заблокировать">
        </form><br><hr>
        История нарушений <span style="color: #0f0;"><?=$smotr_set['user'] ?></span> : <hr> <?php
        $storis999block = mysql_query("SELECT * FROM block WHERE kto = '".$smotr_set['id']."' AND tip='2' ");
        while ($storis_block = mysql_fetch_array($storis999block)) {
            $sopos999 = _FetchAssoc("SELECT * FROM user_set WHERE id='".$storis_block['kem']."' LIMIT 1");
            $vremya_block = $storis_block['vremya']/24/60/60; ?>
            <?=$storis_block['data'] ?> в <?=$storis_block['time'] ?> <br>
            Причина: "<?=$storis_block['text'] ?>" на <?=$vremya_block ?> дн. <br>
            Блок дал - <?=$sopos999['user'] ?> <br><hr> <?php
        } 

    } // end of form
break;

case 'zipp':
$smotr=isset($_GET['smotr'])?_NumFilter($_GET['smotr']):NULL;
$smotr=_FetchAssoc("SELECT * FROM user_reg WHERE id='".$smotr."' LIMIT 1");
$smotr_set=_FetchAssoc("SELECT * FROM user_set WHERE id='".$smotr['id']."' LIMIT 1");

    if ($set['prava'] < 4) {
        $text = ''.$set['user'].' Пытался выдать зп персонажу '.$smotr_set['user'].' .';
        mysql_query("INSERT INTO chat SET id_user = '3', text = '" . $text . "', time = '" . $timer . "', date = '" . $dater . "', tip = '10'");
        mysql_query("INSERT INTO chat2 SET id_user = '3', text = '" . $text . "', time = '" . $timer . "', date = '" . $dater . "', tip = '10'");
        $_SESSION['err'] = 'Не имеете прав на это действие!';
        header("Location: menu.php");
        exit();
    }
    if (isset($_POST['vid_ok'])) {
        if ($smotr_set['prava']==1) {
            $sum_zp = 50;
        } elseif ($smotr_set['prava']==2) {
            $sum_zp = 150;
        } elseif ($smotr_set['prava']==3) {
            $sum_zp = 200;
        } elseif ($smotr_set['prava']==4) {
            $sum_zp = 250;
        } elseif ($smotr_set['prava']==5) {
            $sum_zp = 300;
        } else {
            $sum_zp = 0;
        }
        $plus_zipp = $smotr_set['gold']+$sum_zp;
        $zipp_text = 'Выдал зп персонажу '.$smotr_set['user'].' в кол-ве '.$sum_zp.' золота';
        mysql_query("UPDATE user_set SET gold='".$plus_zipp."' WHERE id='".$smotr_set['id']."' LIMIT 1");
        mysql_query("INSERT INTO admin_logi SET id_user='".$set['id']."', user='".$set['user']."', text='".$zipp_text."' ");
        $_SESSION['ok'] = 'Персонажу '.$smotr_set['user'].' успешно начислена з/п в кол-ве '.$sum_zp.' золота';
        header("Location: ?smotr=".$smotr['id']."");
        exit();
    } else { ?>
        Персонаж <?=$smotr_set['user'] ?>
        <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
            <input type="submit" name="vid_ok" value="Выдать з/п">
        </form><br><hr><?php
    }
break;
case 'podarok':
$smotr=isset($_GET['smotr'])?_NumFilter($_GET['smotr']):NULL;
$smotr=_FetchAssoc("SELECT * FROM user_reg WHERE id='".$smotr."' LIMIT 1");
$smotr_set=_FetchAssoc("SELECT * FROM user_set WHERE id='".$smotr['id']."' LIMIT 1");

    if ($set['prava'] < 3) {
        $text = ''.$set['user'].' Пытался выдать подарок персонажу '.$smotr_set['user'].' .';
        mysql_query("INSERT INTO chat SET id_user = '3', text = '" . $text . "', time = '" . $timer . "', date = '" . $dater . "', tip = '10'");
        mysql_query("INSERT INTO chat2 SET id_user = '3', text = '" . $text . "', time = '" . $timer . "', date = '" . $dater . "', tip = '10'");
        $_SESSION['err'] = 'Не имеете прав на это действие!';
        header("Location: menu.php");
        exit();
    }
    if (isset($_POST['vid_pod'])) {
        $zipp_text = 'Выдал подарок персонажу '.$smotr_set['user'].' ';
        mysql_query("UPDATE user_set SET podarok='0' WHERE id='".$smotr_set['id']."' LIMIT 1");
        mysql_query("INSERT INTO admin_logi SET id_user='".$set['id']."', user='".$set['user']."', text='".$zipp_text."' ");
        $_SESSION['ok'] = 'Персонажу '.$smotr_set['user'].' успешно начислен подарок сервера';
        header("Location: ?smotr=".$smotr['id']."");
        exit();
    } else { ?>
        Персонаж <?=$smotr_set['user'] ?>
        <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
            <input type="submit" name="vid_pod" value="Выдать подарок сервера">
        </form><br><hr><?php
    }
break;

case 'logi':
    if ($set['prava'] < 3) {
        $_SESSION['err'] = 'Не имеете прав на данное действие';
        header('Location: menu.php');
        exit();
    }
    $smotr=isset($_GET['smotr'])?_NumFilter($_GET['smotr']):NULL;
    $smotr=_FetchAssoc("SELECT * FROM user_reg WHERE id='".$smotr."' LIMIT 1");
    $smotr_set=_FetchAssoc("SELECT * FROM user_set WHERE id='".$smotr['id']."' LIMIT 1");
    $smotr_logi = mysql_query("SELECT * FROM logi WHERE id_user='".$smotr['id']."' ORDER BY id DESC LIMIT 50");
    while ($logi = mysql_fetch_array($smotr_logi)) {
        echo ' <hr>'.$logi['text'].'<br>'.$logi['time'].'<br><hr>';
    }
    break;

    case 'redu':
    if ($set['prava'] < 2) {
        $_SESSION['err'] = 'Не имеете прав на данное действие';
        header('Location: menu.php');
        exit();
    }
    $smotr=isset($_GET['smotr'])?_NumFilter($_GET['smotr']):NULL;
    $smotr=_FetchAssoc("SELECT * FROM user_reg WHERE id='".$smotr."' LIMIT 1");
    $smotr_set=_FetchAssoc("SELECT * FROM user_set WHERE id='".$smotr['id']."' LIMIT 1");
    $smotr_logi = mysql_query("SELECT * FROM logi WHERE id_user='".$smotr['id']."' ORDER BY id DESC LIMIT 50");
    echo "Друзья товарищи! Сначало ВЫДАТЬ уровень, затем СБРОСИТЬ навыки!!! Не наоборот! Уровень пишите тот, что нужен, скрипт сам все сделает за вас)<br>";
    echo $smotr_set['user'];
        $opit_ravno2 = _FetchAssoc("SELECT * FROM lvl WHERE opit>='".$smotr_set['exp']."' LIMIT 1");
        $skill_obn = ($opit_ravno2['lvl']*5);
        $skill_new_operation1 = _FetchAssoc("SELECT * FROM user_operation WHERE id_user='".$smotr_set['id']."' AND id_operation='1' LIMIT 1");
        $sk1 = ($skill_new_operation1['point']*2);
        $skill_new_operation2 = _FetchAssoc("SELECT * FROM user_operation WHERE id_user='".$smotr_set['id']."' AND id_operation='2' LIMIT 1");
        $sk2 = ($skill_new_operation2['point']*2);
        $skill_new_operation3 = _FetchAssoc("SELECT * FROM user_operation WHERE id_user='".$smotr_set['id']."' AND id_operation='3' LIMIT 1");
        $sk3 = ($skill_new_operation3['point']*2);
        $skill_new_operation4 = _FetchAssoc("SELECT * FROM user_operation WHERE id_user='".$smotr_set['id']."' AND id_operation='4' LIMIT 1");
        $sk4 = ($skill_new_operation4['point']*2);
        $skill_new_operation5 = _FetchAssoc("SELECT * FROM user_operation WHERE id_user='".$smotr_set['id']."' AND id_operation='5' LIMIT 1");
        $sk5 = ($skill_new_operation5['point']*2);
        $skill_new_operation6 = _FetchAssoc("SELECT * FROM user_operation WHERE id_user='".$smotr_set['id']."' AND id_operation='6' LIMIT 1");
        $sk6 = ($skill_new_operation6['point']*2);
        $skill_new_operation7 = _FetchAssoc("SELECT * FROM user_operation WHERE id_user='".$smotr_set['id']."' AND id_operation='7' LIMIT 1");
        $sk7 = ($skill_new_operation7['point']*2);
        $skill_new_operation8 = _FetchAssoc("SELECT * FROM user_operation WHERE id_user='".$smotr_set['id']."' AND id_operation='8' LIMIT 1");
        $sk8 = ($skill_new_operation8['point']*2);
        $skill_new_operation9 = _FetchAssoc("SELECT * FROM user_operation WHERE id_user='".$smotr_set['id']."' AND id_operation='9' LIMIT 1");
        $sk9 = ($skill_new_operation9['point']*2);
        $skill_new_operation10 = _FetchAssoc("SELECT * FROM user_operation WHERE id_user='".$smotr_set['id']."' AND id_operation='10' LIMIT 1");
        $sk10 = ($skill_new_operation10['point']*2);
        $skill_new = $sk1+$sk2+$sk3+$sk4+$sk5+$sk6+$sk7+$sk8+$sk9+$sk10+$skill_obn;
        mysql_query("UPDATE user_set SET skill_full='".$skill_new."' WHERE id='".$smotr_set['id']."' LIMIT 1");
        $smotr_set = _FetchAssoc("SELECT * FROM user_set WHERE id='" . $smotr['id'] . "'");
        if (isset($_POST['navik_ravno'])) {
            
            $skill_plus = $smotr_set['skill_full']+$smotr_set['skill_kuplen'];
            mysql_query("UPDATE user_set SET skill='".$skill_plus."', udar='0', max_hp='100', max_mp='100', max_udar='5', krit='0', uvorot='0', podarok='0'  WHERE id='".$smotr_set['id']."' LIMIT 1");
            $_SESSION['ok'] = 'Навыки успешно сброшены';
            header("Location: ?smotr=".$smotr['id']."");
            exit();
        } else { ?>
            <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
                <input type="submit" name="navik_ravno" value="Сбросить навыки">
            </form><?php 
        } // end of form

        if (isset($_POST['lvl_ravno'])) {
            $lvl_get = $_POST['text'];
            $lvl_plus = $_POST['text']+1;
            $opit_ravno = _FetchAssoc("SELECT * FROM lvl WHERE lvl='".$lvl_get."' LIMIT 1");
            $opit_posled = $opit_ravno['opit']+1;
            $lvl_posled = _FetchAssoc("SELECT * FROM lvl WHERE lvl='".$lvl_plus."' LIMIT 1");
            $skill_plus = $set['skill_full']+$set['skill_kuplen'];
            mysql_query("UPDATE user_set SET lvl='".$_POST['text']."', skill='".$skill_plus."', exp='".$opit_posled."', max_exp='".$lvl_posled['opit']."' WHERE id='".$smotr_set['id']."' LIMIT 1");
            $_SESSION['ok'] = 'Выдан '.$lvl_get.' уровень';
            header("Location: ?case=redu&smotr=".$smotr['id']."");
            exit();
        } else { ?>
            <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
                <input type="number" name="text" >
                <input type="submit" name="lvl_ravno" value="Выдать уровень">
            </form><?php 
        } // end of form
        
            echo "Навыки ".$smotr_set['user'].": ".$smotr_set['skill']." Свободных, ".$smotr_set['skill_full']." Всего навыков, ".$smotr_set['skill_kuplen']." Куплено навыков <br>";
            echo "".$smotr_set['hp']." / ".$smotr_set['max_hp']." HP, ".$smotr_set['mp']." / ".$smotr_set['max_mp']." MP, ".$smotr_set['udar']." / ".$smotr_set['max_udar']." BP, ".$smotr_set['krit']." Krit, ".$smotr_set['uvorot']." uvorot ";
        break;
} */
require_once('system/down.php');