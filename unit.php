<?php
$title = 'Техника';
require_once('system/up.php');
_Reg();
if ($set['block']==1) {
	header("Location: blok.php");
	exit();
}
switch ($_GET['case']) {
    default:
?><div class="main"><?
        if ($set['logo'] == 'on') {
?><img src="images/logotips/unit.jpg" width="100%" alt="Техника"/><div class="mini-line"></div><?
        }
?><div class="menuList"><li><a href="unit.php?case=pokupka&tip=1"><img src="images/icons/arrow.png" alt="*"/>Наземная</a></li><li><a href="unit.php?case=pokupka&tip=2"><img src="images/icons/arrow.png" alt="*"/>Морская</a></li><li><a href="unit.php?case=pokupka&tip=3"><img src="images/icons/arrow.png" alt="*"/>Воздушная</a></li><li><a href="unit.php?case=superunit"><img src="images/icons/arrow.png" alt="*"/>Разработки</a></li></div><div class="mini-line"></div><ul class="hint"><li>Цена продажи техники уменьшается от цены покупки на 10%.</li><li>Техника используется в битвах с другими игроками, а также при выполнении заданий.</li><li>Возле каждой единицы техники в меню покупки указаны ее название, параметры атаки, защиты, количество уже имеющейся у Вас техники такого вида, а также цена содержания данной единицы техники и ее стоимость.</li><li>С достижением новых уровней открывается новая техника, доступная к приобретению.</li><li>Приобретая технику, стоит учитывать не только ее цену, но и цену ее содержания. Каждый час на содержание армии с Вашего счета снимается соответствующая сумма.</li></ul></div></div></div><?
        break;
    case 'pokupka':
        $tip = _NumFilter($_GET['tip']);
        $tip_gold = $tip+3;
        $page = isset($_GET['page'])?_NumFilter($_GET['page']):NULL;
        if ($tip < 1 OR $tip > 6) {
            $_SESSION['err'] = 'Нет техники такого типа';
            header('Location: unit.php');
            exit();
        }
        if (isset($_POST['send'])) {
            $kol = _NumFilter($_POST['kol']);            
            if ($kol == 0) {
                $_SESSION['err'] = 'Не введено колличество';
                if  ($tip<4){
                header('Location: unit.php?case=pokupka&tip=' . $tip . '&page=' . $page . '');
                } else {
                header('Location: unit.php?case=pokupka&tip=' . ($tip-3) . '&page=' . $page . '');
                }
                exit();
            }
            $id_unit = _NumFilter($_GET['unit']);





            for ($i = 1; $i <= $kol; $i++) {
            if($set['soderzhanie']>$set['dohod']){
    $_SESSION['err'] = 'Содержание больше дохода,<br/>покупка техники приостановлена!';
            header('Location: unit.php');
            exit();
    }
                $data_pokupka = _FetchAssoc("SELECT * FROM `user_unit` WHERE `id_user`='" . $user_id . "' AND `id_unit`='" . $id_unit . "' LIMIT 1");
                $user         = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $user_id . "' LIMIT 1");
                if ($set['side'] == 'c') {
                $unit_cena=$data_pokupka['cena']*0.8;
                }else{
                $unit_cena=$data_pokupka['cena'];               
                }
                if  ($data_pokupka['tip']<4){
                if  ($user['baks'] < $unit_cena) {
                    $_SESSION['err'] = 'Не хватает баксов,<br/>приобретено ' . ($i - 1) . ' ед.';
                    header('Location: unit.php?case=pokupka&tip=' . $tip . '&page=' . $page . '');
                    exit();
                }
                } else {
                if  ($user['gold'] < $unit_cena) {
                    $_SESSION['err'] = 'Не хватает золота,<br/>приобретено ' . ($i - 1) . ' ед.';
                    header('Location: unit.php?case=pokupka&tip=' . ($tip-3) . '&page=' . $page . '');
                    exit();
                }
                }
                mysql_query("UPDATE `user_unit` SET `kol`=`kol`+'1' WHERE `id_user`='" . $user_id . "' AND `id_unit`='" . $id_unit . "' LIMIT 1");
                mysql_query("INSERT INTO `voina_unit` (id_user,id_unit,tip,ataka,zaschita) VALUES('".$user_id."','".$id_unit."','".$data_pokupka['tip']."','".$data_pokupka['ataka']."','".$data_pokupka['zaschita']."')");
                if  ($data_pokupka['tip']<4){
                mysql_query("UPDATE `user_set` SET `baks`=`baks`-'" . _NumFilter($unit_cena) . "' WHERE `id`='" . $user_id . "' LIMIT 1");
                } else {
                mysql_query("UPDATE `user_set` SET `gold`=`gold`-'" . _NumFilter($unit_cena) . "' WHERE `id`='" . $user_id . "' LIMIT 1");
                }
                
                $trof_set=_FetchAssoc("SELECT * FROM `user_trofei` WHERE `id_user`='".$user_id."' AND `id_trof`='4' LIMIT 1");
                
                if($trof_set['status']==1 AND $trof_set['time_up']==0){
$trof_unit_pokupka=$data_pokupka['soderzhanie']-($data_pokupka['soderzhanie']/100*$trof_set['bonus_1']);
$trof_unit_chistaya=$data_pokupka['soderzhanie']-($data_pokupka['soderzhanie']/100*$trof_set['bonus_1']);
}else{
$trof_unit_pokupka=$data_pokupka['soderzhanie'];
$trof_unit_chistaya=$data_pokupka['soderzhanie'];
}
                
                mysql_query("UPDATE `user_set` SET `soderzhanie`=`soderzhanie`+'" . $trof_unit_pokupka . "', `chistaya`=`chistaya`-'" . $trof_unit_chistaya . "' WHERE `id`='" . $user_id . "' LIMIT 1");
            }



            $_SESSION['ok'] = 'Покупка успешно завершена,<br/>приобретено ' . ($i - 1) . ' ед.';
            if  ($data_pokupka['tip']<4){
            header('Location: unit.php?case=pokupka&tip=' . $tip . '&page=' . $page . '');
            } else {
            header('Location: unit.php?case=pokupka&tip=' . ($tip-3) . '&page=' . $page . '');
            }
            exit();
        }




        if (isset($_POST['prod'])) {
            $kol = _NumFilter($_POST['kol']);
            if ($kol == 0) {
                $_SESSION['err'] = 'Не введено колличество';
                header('Location: unit.php?case=pokupka&tip=' . $tip . '&page=' . $page . '');
                exit();
            }
            $id_unit = _NumFilter($_GET['unit']);
            for ($i = 1; $i <= $kol; $i++) {
                $data_prodazha = _FetchAssoc("SELECT * FROM `user_unit` WHERE `id_user`='" . $user_id . "' AND `id_unit`='" . $id_unit . "' LIMIT 1");
                $user          = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $user_id . "' LIMIT 1");
                if ($data_prodazha['kol'] == 0) {
                    $_SESSION['err'] = 'Не хватает техники,<br/>продано ' . ($i - 1) . ' ед.';
                    header('Location: unit.php?case=pokupka&tip=' . $data_prodazha['tip'] . '&page=' . $page . '');
                    exit();
                }
                mysql_query("UPDATE `user_unit` SET `kol`=`kol`-'1' WHERE `id_user`='" . $user_id . "' AND `id_unit`='" . $id_unit . "' LIMIT 1");
                mysql_query("DELETE FROM `voina_unit` WHERE `id_user`='" . $user_id . "' AND `id_unit`='" . $id_unit . "' LIMIT 1");
                
                $trof_set=_FetchAssoc("SELECT * FROM `user_trofei` WHERE `id_user`='".$user_id."' AND `id_trof`='4' LIMIT 1");
                
                if($trof_set['status']==1 AND $trof_set['time_up']==0){
$trof_unit_prodazha=$data_prodazha['soderzhanie']-($data_prodazha['soderzhanie']/100*$trof_set['bonus_1']);
$trof_unit_chistaya=$data_prodazha['soderzhanie']-($data_prodazha['soderzhanie']/100*$trof_set['bonus_1']);
}else{
$trof_unit_prodazha=$data_prodazha['soderzhanie'];
$trof_unit_chistaya=$data_prodazha['soderzhanie'];
}
                
                
                mysql_query("UPDATE `user_set` SET `baks`=`baks`+'" . _NumFilter($data_prodazha['cena'] - ($data_prodazha['cena'] / 10)) . "', `soderzhanie`=`soderzhanie`-'" . $trof_unit_prodazha . "', `chistaya`=`chistaya`+'" . $trof_unit_chistaya . "' WHERE `id`='" . $user_id . "' LIMIT 1");
            }
            $_SESSION['ok'] = 'Продажа успешно завершена,<br/>продано ' . ($i - 1) . ' ед.';
            header('Location: unit.php?case=pokupka&tip=' . $data_prodazha['tip'] . '&page=' . $page . '');
            exit();
        }



?><div class="menuList"><li><a href="unit.php?case=pokupka&tip=1"><img src="images/icons/arrow.png" alt="*"/>Наземная</a></li><li><a href="unit.php?case=pokupka&tip=2"><img src="images/icons/arrow.png" alt="*"/>Морская</a></li><li><a href="unit.php?case=pokupka&tip=3"><img src="images/icons/arrow.png" alt="*"/>Воздушная</a></li><li><a href="unit.php?case=superunit"><img src="images/icons/arrow.png" alt="*"/>Разработки</a></li></div>
<div class="main"><div class="block_zero"><span style="color: #999;"><small><?
        if ($tip == 1) {
?>Наземная техника имеет сбалансированные параметры атаки и защиты.<?
        } elseif ($tip == 2) {
?>Морская техника имеет большие параметры защиты.<?
        } else {
?>Авиационная техника имеет большие параметры атаки.<?
        }
?></span></div><div class="dot-line"></div><div class="block_zero"><span style="color: #999;">Доход:<span style="float: right;"> <?= $set['dohod'] ?></span><br/>Содержание:<span style="float: right;"> <?= $set['soderzhanie'] ?></span><br/>Чистая прибыль:<span style="float: right;"> <?= $set['chistaya'] ?></small></span></span></div><?
    if (empty($_GET['page']) || $_GET['page'] == 0 || $_GET['page'] < 0) {
            $_GET['page'] = 0;
        }
        $next = $_GET['page'] + 1;
        $back = $_GET['page'] - 1;
        $num  = $_GET['page'] * 5;
        if ($_GET['page'] == 0) {
            $i = 1;
        } else {
            $i = ($_GET['page'] * 5) + 1;
        }
        $viso   = _NumRows("SELECT * FROM `user_unit` WHERE `id_user` = '" . $user_id . "' AND `tip`='" . $tip . "'");
        $puslap = floor($viso / 5);
        $data_unit = mysql_query("SELECT * FROM `user_unit` WHERE `id_user` = '" . $user_id . "' AND `tip` IN('" . $tip . "', '" . $tip_gold . "') ORDER BY `id_unit` DESC LIMIT $num, 5");
        while ($user_unit = mysql_fetch_assoc($data_unit)) {
        if($user_unit['tip']==($tip+3)){
        $unit_color='f96';
        $scr='gold';
        }else{
        $unit_color='999';
        $scr='baks';
        }
?><div class="mini-line"></div><div class="block_zero"><span style="color: #<?=$unit_color?>;"><?= $user_unit['name'] ?> - <?= $user_unit['kol'] ?></span></div><div class="dot-line"></div><table width="100%"><tr><td width="25%"><img class="float-left" src="images/units/<?= $user_unit['id_unit'] ?>.png" width="115px" height="80px" style="margin-left:0px;margin-right:0px;border:1px solid #<?=$unit_color?>;" alt="Техника"></td><td><span style="color: #<?=$unit_color?>;">Атака/Защита<span style="float: right;"><?= $user_unit['ataka'] ?>/<?= $user_unit['zaschita'] ?></span><br />Содержание:<span style="float: right;"><?= $user_unit['soderzhanie'] ?></span><br />Цена:<span style="float: right;"><img src="images/icons/<?=$scr?>.png" alt="*" /><?= $user_unit['cena'] ?></span><br /><form action="unit.php?case=pokupka&unit=<?= $user_unit['id_unit'] ?>&tip=<?= $user_unit['tip'] ?>&page=<?=$_GET['page']?>" method="POST">Количество:</span><?
        if($user_unit['tip']>3){ 
        ?><span style="float: right;"><?
        }
        ?><input class="text" type="text" value="1" size="3" maxlength="3" name="kol"><?
        if($user_unit['tip']>3){ 
        ?></span><?
        }
        ?><br/><span class="btn"><span class="end"><input class="label" name="send" type="submit" value="Купить"/></span></span><?
        if($user_unit['tip']<4){
        ?><span class="btn"><span class="end"><input class="label" name="prod" type="submit" value="Продать"/></span></span><?
        }
        ?></form></td></tr></table><?
        }        
        $user_unit = _FetchAssoc("SELECT * FROM `user_unit` WHERE `id_user` = '" . $user_id . "' AND `tip` IN('" . $tip . "', '" . $tip_gold . "') ORDER BY `id_unit` DESC LIMIT 1");
        
        $next_unit = _FetchAssoc("SELECT * FROM `unit` WHERE `tip` IN('" . $tip . "', '" . $tip_gold . "') AND `id` = '" . _NumFilter($user_unit['id_unit'] + 1) . "' LIMIT 1");
        if ($next_unit){
?><div class="mini-line"></div><div class="block_zero center"><div class="block_dashed center"><?= $next_unit['name'] ?><br/><img src="images/units/0.png" alt="*"/><br/><b><span style="color: #ff3434;">Будет доступно на <?= $next_unit['lvl'] ?> уровне</span></b></div></div><?
        }
         echo '<div class="mini-line"></div><div class="block_zero center">';
        if ($_GET['page'] > 0) {
            echo '<small><b><a href="unit.php?case=pokupka&tip=' . $tip . '&page=' . $back . '"><< Назад </a></small></b>';
        }
        if (empty($_GET['page']) || $_GET['page'] == 0 || $_GET['page'] < $puslap) {
            echo '<small><b><a href="unit.php?case=pokupka&tip=' . $tip . '&page=' . htmlspecialchars($next) . '"> Вперёд >></a></small></b>';
        }
?></div></div></div><?
        break;
        case 'superunit':
        echo'<div class="main"><div class="block_zero center"><h1 class="yellow">Секретные разработки</h1></div><div class="mini-line"></div><div class="block_zero"><span style="color: #c66;">В бой они берутся ВСЕГДА, вне зависимости от размера альянса.</span></div>';
        $data_superunit = mysql_query("SELECT * FROM `user_superunit` WHERE `id_user` = '" . $user_id . "' ORDER BY `id_unit` ASC LIMIT 9");
        while ($user_superunit = mysql_fetch_assoc($data_superunit)) {
        if($user_superunit['kol']==0){
        $lock='lock';
        $ataka='?';
        $zaschita='?';
        }else{
        $lock=FALSE;
        $ataka=$user_superunit['ataka'];
        $zaschita=$user_superunit['zaschita'];
        }
        ?><div class="mini-line"></div><table width="100%"><tr><td width="45%"><img class="float-left" src="images/superunits/<?= $user_superunit['id_unit'].''.$lock ?>.png" style="margin-left:5px;margin-right:0px;border:1px solid #999;" alt="Разработка"></td><td><b><span style="color: #9c9;"><?= $user_superunit['name'] ?></span></b><br/><span style="color: #999;">Атака<span style="float: right;"><?= $ataka ?></span><br/>Защита<span style="float: right;"><?= $zaschita ?></span><br/>В наличии: <?= $user_superunit['kol'] ?></span></td></tr></table><?
        }
        echo'<div class="mini-line"></div><ul class="hint"><li>Собирайте секретные разработки, покупая контрабанду на "Чёрном рынке".</li><li>Заполучите все 9, чтобы собрать сверхсекретную.</li><li>Сила разработок автоматически увеличивается с ростом Вашего уровня.</li></ul><div class="mini-line"></div><div class="block_zero center"><h1 class="yellow">Сверхсекретная разработка</h1></div><div class="mini-line"></div>';
        $user_sverhsuperunit = _FetchAssoc("SELECT * FROM `user_superunit` WHERE `id_user` = '" . $user_id . "' AND `id_unit` = '10' LIMIT 1");
        if($user_sverhsuperunit['kol']==0){
        $lock='lock';
        $ataka='?';
        $zaschita='?';
        }else{
        $lock=FALSE;
        $ataka=$user_sverhsuperunit['ataka'];
        $zaschita=$user_sverhsuperunit['zaschita'];
        }
        ?><table width="100%"><tr><td width="45%"><img class="float-left" src="images/superunits/<?= $user_sverhsuperunit['id_unit'].''.$lock ?>.png" style="margin-left:5px;margin-right:0px;border:1px solid #999;" alt="Разработка"></td><td><b><span style="color: #9c9;"><?= $user_sverhsuperunit['name'] ?></span></b><br/><span style="color: #999;">Атака<span style="float: right;"><?= $ataka ?></span><br/>Защита<span style="float: right;"><?= $zaschita ?></span><br/>В наличии: <?= $user_sverhsuperunit['kol'] ?></span></td></tr></table><?
        if($s1['kol']>$s10['kol'] AND $s2['kol']>$s10['kol'] AND $s3['kol']>$s10['kol'] AND $s4['kol']>$s10['kol'] AND $s5['kol']>$s10['kol'] AND $s6['kol']>$s10['kol'] AND $s7['kol']>$s10['kol'] AND $s8['kol']>$s10['kol'] AND $s9['kol']>$s10['kol']){
        ?><div class="block_zero center"><a class="btn" href="unit.php?case=sborka"><span class="end"><span class="label">Собрать</span></span></span></a></div><?
        }
        echo'<div class="mini-line"></div><ul class="hint"><li>Собрав сверхсекретную разработку, Вы не потеряете разработки, которые требуются для её сборки.</li></ul></div>';
        break;
        case 'sborka':
        if($s1['kol']>$s10['kol'] AND $s2['kol']>$s10['kol'] AND $s3['kol']>$s10['kol'] AND $s4['kol']>$s10['kol'] AND $s5['kol']>$s10['kol'] AND $s6['kol']>$s10['kol'] AND $s7['kol']>$s10['kol'] AND $s8['kol']>$s10['kol'] AND $s9['kol']>$s10['kol']){
        mysql_query("UPDATE `user_superunit` SET `kol`=`kol`+'1' WHERE `id_unit`='10' AND `id_user` = '" . $user_id . "' LIMIT 1");
        $_SESSION['ok'] = 'Вы собрали сверхсекретную разработку!';
        header('Location: unit.php?case=superunit');
        exit();
        }else{
        $_SESSION['err'] = 'Не хватает секретных разработок для сборки!';
        header('Location: unit.php?case=superunit');
        exit();
        }
        break;
        }
require_once('system/down.php');