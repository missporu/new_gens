<?php
$title = 'Госпиталь';
require_once('system/up.php');
_Reg();
if (isset($_GET['log'])) {
    if ($_GET['log'] == 'hp') {
        if ($set['hp'] == $set['max_hp']) {
            $_SESSION['err'] = 'У Вас и так полный уровень здоровья';
            header('Location: hosp.php');
            exit();
        }
        $summa = (($set['lvl']+1) * 75)/100*($set['max_hp']-$set['hp']);
        if ($set['baks_hran'] < $summa) {
            $_SESSION['err'] = 'Не хватает баксов в <a href="bank.php">Хранилище</a>';
            header('Location: hosp.php');
            exit();
        }        
        $trof_hp=_FetchAssoc("SELECT * FROM `user_trofei` WHERE `id_user`='".$user_id."' AND `id_trof`='6' LIMIT 1");
        $trof_name=_FetchAssoc("SELECT `name` FROM `trofei` WHERE `id`='6' LIMIT 1");        
        if($trof_hp['status']==1 AND $trof_hp['time_up']==0){        
        $shans=mt_rand(1,100);
        if($shans<=$trof_hp['bonus_2']){        
        $trof='<br/>Благодаря трофею "'.$trof_name['name'].'"<br/><img src="images/trofei/6.png" style="margin-left:0px;margin-right:0px;border:1px solid #999;" alt="Трофей"><br/>Вы излечились бесплатно!';
        $summa=NULL;
        }else{
        $trof='<br/>Потрачено из <a href="bank.php">Хранилища</a> <img src="images/icons/baks.png" alt="*">'.number_format($summa).'';
        }        
        }        
        mysql_query('UPDATE `user_set` SET `hp` = "' . $set['max_hp'] . '" WHERE `id` = "' . $user_id . '"');       
        mysql_query('UPDATE `user_set` SET `baks_hran` = `baks_hran` - "' . $summa . '" WHERE `id` = "' . $user_id . '"');       
        $_SESSION['ok'] = 'Здоровье восстановлено. '.$trof.'';
        header('Location: hosp.php');
        exit();
    } elseif ($_GET['log'] == 'uhi') {
        if ($fataliti_user['uho1_kto'] == 0 AND $fataliti_user['uho2_kto'] == 0) {
            $_SESSION['err'] = 'Ваши уши и так целы';
            header('Location: hosp.php');
            exit();
        }
        if ($set['gold'] < 20) {
            $_SESSION['err'] = 'Не хватает золота';
            header('Location: hosp.php');
            exit();
        }
        mysql_query('UPDATE `user_set` SET `gold` = `gold` - "20" WHERE `id` = "' . $user_id . '"');
        mysql_query('UPDATE `user_fataliti` SET `uho1_kto` = "0", `uho2_kto` = "0", `uho1_up` = "0", `uho2_up` = "0" WHERE `id_user` = "' . $user_id . '"');
        $_SESSION['ok'] = 'Уши пришиты';
        header('Location: hosp.php');
        exit();
    } elseif ($_GET['log'] == 'uho1') {
        if ($fataliti_user['uho1_kto'] == 0) {
            $_SESSION['err'] = 'Ваше ухо и так цело';
            header('Location: hosp.php');
            exit();
        }
        if ($set['gold'] < 10) {
            $_SESSION['err'] = 'Не хватает золота';
            header('Location: hosp.php');
            exit();
        }
        mysql_query('UPDATE `user_set` SET `gold` = `gold` - "10" WHERE `id` = "' . $user_id . '"');
        mysql_query('UPDATE `user_fataliti` SET `uho1_kto` = "0", `uho1_up` = "0" WHERE `id_user` = "' . $user_id . '"');
        $_SESSION['ok'] = 'Ухо пришито';
        header('Location: hosp.php');
        exit();
    } elseif ($_GET['log'] == 'uho2') {
        if ($fataliti_user['uho2_kto'] == 0) {
            $_SESSION['err'] = 'Ваше ухо и так цело';
            header('Location: hosp.php');
            exit();
        }
        if ($set['gold'] < 10) {
            $_SESSION['err'] = 'Не хватает золота';
            header('Location: hosp.php');
            exit();
        }
        mysql_query('UPDATE `user_set` SET `gold` = `gold` - "10" WHERE `id` = "' . $user_id . '"');
        mysql_query('UPDATE `user_fataliti` SET `uho2_kto` = "0", `uho2_up` = "0" WHERE `id_user` = "' . $user_id . '"');
        $_SESSION['ok'] = 'Ухо пришито';
        header('Location: hosp.php');
        exit();
    }
}
?><div class="main"><div class="main"><div class="block_zero center"><span style="color: #9cc;">Цена лечения зависит от Вашего уровня</span></div><div class="mini-line"></div><?
if ($set['logo'] == 'on') {
?><img src="images/logotips/hospital.jpg" width="100%" alt="Госпиталь"/><div class="mini-line"></div><?
}
?><div class="block_zero center">Деньги в хранилище: <img src="images/icons/baks.png" alt="*" /> <?= number_format($set['baks_hran']) ?></div><div class="dot-line"></div><div class="block_zero center"><?
if ($set['hp'] < $set['max_hp']) {
    $summa = number_format((($set['lvl']+1) * 75)/100*($set['max_hp']-$set['hp']));
?><a class="btn" href="hosp.php?log=hp"><span class="end"><span class="label">Восстановить здоровье за <img src="images/icons/baks.png" alt="*" /> <?=$summa?></span></span></a><?
} else {
?>У Вас полный уровень здоровья<?
}
if ($fataliti_user['uho1_kto'] != 0 OR $fataliti_user['uho2_kto'] != 0) {
?></div><div class="mini-line"></div><div class="block_zero center"><?
}
if ($fataliti_user['uho1_kto'] != 0 AND $fataliti_user['uho2_kto'] != 0) {
    $summa = 20;
?><a class="btn" href="hosp.php?log=uhi"><span class="end"><span class="label">Пришить уши за <img src="images/icons/gold.png" alt="*" /> <?= $summa ?></span></span></a><?
} elseif ($fataliti_user['uho1_kto'] != 0) {
    $summa = 10;
?><a class="btn" href="hosp.php?log=uho1"><span class="end"><span class="label">Пришить ухо за <img src="images/icons/gold.png" alt="*" /> <?=$summa?></span></span></a><?
} elseif ($fataliti_user['uho2_kto'] != 0) {
    $summa = 10;
?><a class="btn" href="hosp.php?log=uho2"><span class="end"><span class="label">Пришить ухо за <img src="images/icons/gold.png" alt="*" /> <?= $summa ?></span></span></a><?
} else {
}
?></div><div class="mini-line"></div><ul class="hint"><li>После боя главное – убрать с поля боя раненых и похоронить их.</li><li>В санчасти за небольшую плату местный санитар при помощи зеленки и йода лечит все – от мелких царапин до плоскостопия.</li></ul></div></div></div><?
require_once('system/down.php');
?>
