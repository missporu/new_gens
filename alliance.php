<?php
$title = 'Альянс';
require_once('system/up.php');
_Reg();
if ($set['block']==1) {
	header("Location: blok.php");
	exit();
}
if ($_GET['case'] == '') {
?><div class="main"><div class="block_zero center"><span style="color: #9cc;">Каждый член альянса позволяет Вам<br/>брать в бой 5 единиц техники</span></div><div class="mini-line"></div><?
}
if ($_GET['case'] == 'priglas'){
?><div class="main"><div class="block_zero center"><span style="color: #9cc;">Запросы удаляются по истечении<br/>3-х часов после их отправки</span></div><div class="mini-line"></div><?
}
if ($set['logo'] == 'on') {
?><div class="main"><img src="images/logotips/alliance.jpg" width="100%" alt="logo"/><div class="mini-line"></div><?
}
if ($_GET['case'] == 'priglas') {
    $loka  = 'Приглашения в альянс';
    $loka2 = 'Дипломаты';
} elseif ($_GET['case'] == 'refer') {
    $loka = 'Реферальная программа';
} elseif ($_GET['case'] == 'kredit') {
    $loka = 'Кредит';
} else {
    $loka = 'Мои союзники - ' . number_format($user_alliance) . '';
}
?><div class="block_zero center"><h1 class="yellow"><?= $loka ?></h1></div><div class="mini-line"></div><div class="menuList"><?
if ($_GET['case'] != '') {
?><li><a href="alliance.php"><img src="images/icons/arrow.png" alt="*"/>Мои союзники</a></li><?
}
if ($_GET['case'] != 'priglas') {
?><li><a href="alliance.php?case=priglas"><img src="images/icons/arrow.png" alt="*"/>Приглашения в альянс<?= $plus_prigl ?></a></li><?
}
if ($_GET['case'] != 'refer') {
?><li><a href="alliance.php?case=refer"><img src="images/icons/arrow.png" alt="*"/>Реферальная программа</a></li><?
}
switch ($_GET['case']) {
    default:
    if (empty($_GET['page']) || $_GET['page'] == 0 || $_GET['page'] < 0) {
            $_GET['page'] = 0;
        }
        $next = _NumFilter($_GET['page'] + 1);
        $back = $_GET['page'] - 1;
        $num  = $_GET['page'] * 10;
        if ($_GET['page'] == 0) {
            $i = 1;
        } else {
            $i = ($_GET['page'] * 10) + 1;
        }
        $viso   = _NumRows("SELECT `id` FROM `alliance_user` WHERE `kto` = '" . $user_id . "' OR `s_kem` = '" . $user_id . "'");
        $puslap = floor($viso / 10);
        $data_alliance = mysql_query("SELECT * FROM `alliance_user` WHERE `kto` = '" . $user_id . "' OR `s_kem` = '" . $user_id . "' ORDER BY `id` DESC LIMIT $num, 10");
        while ($alliancer = mysql_fetch_assoc($data_alliance)) {
            if ($alliancer['kto'] == $user_id) {
                $allian = _FetchAssoc("SELECT * FROM `user_reg` WHERE `id` = '" . $alliancer['s_kem'] . "' LIMIT 1");
                $allian_set = _FetchAssoc("SELECT * FROM `user_set` WHERE `id` = '" . $allian['id'] . "' LIMIT 1");
            }
            if ($alliancer['s_kem'] == $user_id) {
                $allian = _FetchAssoc("SELECT * FROM `user_reg` WHERE `id` = '" . $alliancer['kto'] . "' LIMIT 1");
                $allian_set = _FetchAssoc("SELECT * FROM `user_set` WHERE `id` = '" . $allian['id'] . "' LIMIT 1");
            }
            $priglas_alliance=_NumRows("SELECT * FROM `alliance_user` WHERE `kto`='".$allian['id']."' OR `s_kem`='".$allian['id']."'");
?></div><div class="mini-line"></div><div class="block_zero"><img src="images/flags/<?= $allian_set['side'] ?>.png" alt="*"/><a href="view.php?smotr=<?= $allian['id'] ?>"> <?= $allian['login'] ?></a><span style="float: right;"><a class="btn" href="?case=udalil&log=<?= $allian['id'] ?>"><span class="end"><span class="label"><span class="dred">Удалить</span></span></span></a></span><br/><small><span style="color: #fffabd;">Ур: <?= $allian_set['lvl'] ?>, Ал: <?= ($priglas_alliance + 1) ?>, Рейтинг: <?= $allian_set['raiting'] ?></span></small><?
         }
         echo'</div><div class="mini-line"></div>';
         echo '<div class="block_zero center">';
        if ($_GET['page'] > 0) {
            echo '<small><b><a href="alliance.php?page=' . $back . '"><< Назад </a></small></b>';
        }
        if (empty($_GET['page']) || $_GET['page'] == 0 || $_GET['page'] < $puslap) {
            echo '<small><b><a href="alliance.php?page=' . $next . '"> Вперёд >></a></small></b>';
        }
        ?></div></div></div><?
        break;
    case 'priglas':
        $data_priglas = mysql_query("SELECT * FROM `alliance_priglas` WHERE `kogo` = '" . $user_id . "' ORDER BY `id_user` DESC LIMIT 10");
        $num_priglas=mysql_num_rows($data_priglas);
         if($num_priglas!=0){
        while ($prig = mysql_fetch_assoc($data_priglas)) {
            $priglas    = _FetchAssoc("SELECT * FROM `user_reg` WHERE `id` = '" . $prig['id_user'] . "' LIMIT 1");
            $allian_set = _FetchAssoc("SELECT * FROM `user_set` WHERE `id` = '" . $priglas['id'] . "' LIMIT 1");
            $priglas_alliance=_NumRows("SELECT * FROM `alliance_user` WHERE `kto`='".$priglas['id']."' OR `s_kem`='".$priglas['id']."'");
?></div><div class="mini-line"></div><div class="block_zero"><img src="images/flags/<?= $allian_set['side'] ?>.png" alt="*"/> <?= $priglas['login'] ?><br/>Ур: <?= $allian_set['lvl'] ?>, Ал: <?= ($priglas_alliance + 1) ?>, Рейтинг: <?= $allian_set['raiting'] ?><br/><?
            $time = _NumFilter($prig['priglas_up'] - time());
?><small>Запрос удалится через:<span style="float: right;"><?= _Time($time) ?></span></small><center><a class="btn" href="alliance.php?case=yes&log=<?= $priglas['id'] ?>"><span class="end"><span class="label"><span class="dgreen">Принять</span></span></span></a><a class="btn" href="alliance.php?case=no&log=<?= $priglas['id'] ?>"><span class="end"><span class="label"><span class="dred">Удалить</span></span></span></a></center><?
}
}else{
?></div><div class="mini-line"></div><div class="block_zero center"><span style="color: #999;">Нет приглашений</span><?
}
?></div><div class="mini-line"></div><div class="block_zero center"><h1 class="yellow"><?= $loka2 ?></h1></div><div class="mini-line"></div><div class="block_zero center"><a class="btn" href="alliance.php?case=diplom"><span class="end"><span class="label">Нанять дипломата за <img src="images/icons/gold.png" alt="*"/> <?= $set['diplomat_cena'] ?></span></span></a></div><div class="dot-line"></div><div class="block_zero"><span style="color: #999;">Доступно дипломатов:<span style="float: right;"><?= $set['diplomat'] ?>/<?= $set['diplomat_max'] ?></span></span><br/><?
        $diploms = mysql_query("SELECT * FROM `alliance_diplom` WHERE `id_user` = '" . $user_id . "' ORDER BY `id` ASC LIMIT 1");
        while ($diplom = mysql_fetch_assoc($diploms)) {
            $time = _NumFilter($diplom['diplom_up'] - time());
?><small>Ещё один восстановится через:<span style="float: right;"><?= _Time($time) ?></span></small><?
        }
        ?></div><div class="mini-line"></div><ul class="hint"><li>Чем больше дипломатов у Вас есть, тем больше одновременных запросов Вы можете сделать, либо принять.</li><li>Наем каждого последующего дипломата стоит вдвое дороже предыдущего.</li><li>При помощи дипломатов Вы можете отсылать другим игрокам запросы на вступление в альянс.</li><li>Каждый дипломат может отправить запрос, либо принять чужой запрос.</li></ul></div></div><?
        break;
    case 'yes':
        if ($set['diplomat'] == 0) {
            $_SESSION['err'] = 'Нет свободных дипломатов';
            header('Location: alliance.php?log=' . $target['id'] . '');
            exit();
        }
        if (isset($_GET['log'])) {
            $prig    = _NumFilter($_GET['log']);
            $priglas = _FetchAssoc("SELECT * FROM `user_reg` WHERE `id` = '" . $prig . "' LIMIT 1");
        }
        $data  = _NumRows("SELECT * FROM `alliance_user` WHERE `kto` = '" . $priglas['id'] . "' AND `s_kem` = '" . $user_id . "'");
        $data2  = _NumRows("SELECT * FROM `alliance_user` WHERE `s_kem` = '" . $priglas['id'] . "' AND `kto` = '" . $user_id . "'");
        if ($data == 0 AND $data2 == 0) {
            mysql_query("INSERT INTO `alliance_user` (kto,s_kem) VALUES('" . $user_id . "','" . $priglas['id'] . "')");
            mysql_query("INSERT INTO `alliance_diplom` (id_user,diplom_up) VALUES('" . $user_id . "','" . _NumFilter(time() + 3600) . "')");
            mysql_query('DELETE FROM `alliance_priglas` WHERE  `kogo` = "' . $user_id . '" AND `id_user` = "' . $priglas['id'] . '"');
            mysql_query('UPDATE `user_set` SET `diplomat` = `diplomat` - "1" WHERE `id` = "' . $user_id . '"');
            $_SESSION['ok'] = 'Вы вступили в альянс с ' . $priglas['login'] . '';
            header('Location: alliance.php?log=' . $target['id'] . '');
            exit();
        } else {
            $_SESSION['err'] = 'Вы уже в альянсе с ' . $priglas['login'] . '';
            header('Location: alliance.php?log=' . $target['id'] . '');
            exit();
        }
        break;
    case 'no':
        if (isset($_GET['log'])) {
            $prig    = _NumFilter($_GET['log']);
            $priglas = _FetchAssoc("SELECT * FROM `user_reg` WHERE `id` = '" . $prig . "' LIMIT 1");
        }
        mysql_query('DELETE FROM `alliance_priglas` WHERE  `kogo` = "' . $user_id . '" AND `id_user` = "' . $priglas['id'] . '"');
        $_SESSION['err'] = 'Вы удалили приглашение ' . $priglas['login'] . '';
        header('Location: alliance.php?case=priglas&log=' . $target['id'] . '');
        exit();
        break;
    case 'diplom':
        if ($set['gold'] < $set['diplomat_cena']) {
            $_SESSION['err'] = 'Не хватает золота';
            header('Location: alliance.php?case=priglas&log=' . $target['id'] . '');
            exit();
        }
        mysql_query('UPDATE `user_set` SET `gold` = `gold` - "' . $set['diplomat_cena'] . '", `diplomat` = `diplomat` + "1", `diplomat_max` = `diplomat_max` + "1", `diplomat_cena` = "' . _NumFilter($set['diplomat_cena'] * 2) . '" WHERE `id` = "' . $user_id . '"');
        $_SESSION['ok'] = 'Вы наняли дипломата';
        header('Location: alliance.php?case=priglas&log=' . $target['id'] . '');
        exit();
        break;
    case 'udalil':
        $prig    = _NumFilter($_GET['log']);
        $priglas = _FetchAssoc("SELECT * FROM `user_reg` WHERE `id` = '" . $prig . "' LIMIT 1");
        mysql_query('DELETE FROM `alliance_user` WHERE  `s_kem` = "' . $user_id . '" AND `kto` = "' . $priglas['id'] . '"');
        mysql_query('DELETE FROM `alliance_user` WHERE  `kto` = "' . $user_id . '" AND `s_kem` = "' . $priglas['id'] . '"');
        mysql_query('UPDATE `user_set` SET `alliance` = `alliance` - "1" WHERE `id` = "' . $user_id . '"');
        mysql_query('UPDATE `user_set` SET `alliance` = `alliance` - "1" WHERE `id` = "' . $priglas['id'] . '"');
        $_SESSION['err'] = '' . $priglas['login'] . ' удалён из альянса';
        header('Location: alliance.php?log=' . $target['id'] . '');
        exit();
        break;
        
        case 'refer':
        $all_ref=_NumRows("SELECT * FROM `user_reg` WHERE `refer` = '" . $user_id . "'");
        ?>
        <div class="block_zero center">
        Игрок, приведенный Вами в игру, при регистрации получает
        <img src="/images/icons/gold.png" alt="Золото"/>
        20 премиальных. А Вы, в свою очередь, получаете 10% от заработанных им баксов и 50% от покупаемого им золота.
        </div>
        <div class="mini-line"></div>
        <div class="block_zero center">Как пригласить реферала?</div>
        <div class="dot-line"></div><div class="block_zero center">
        Передать ему ссылку:<br/>http://gmisspo.ru/reg.php?ref=<?=$user_id?><br/>
        либо опубликовать данную сылку в соцсетях: Twitter , Вконтакте, Facebook, Одноклассники и т.д.
        </div><div class="mini-line"></div><div class="block_zero center">Ваших рефералов: <?=$all_ref?></div>
        <div class="mini-line"></div>
    <?
        $data_ref=mysql_query("SELECT * FROM `user_reg` WHERE `refer` = '" . $user_id . "' ORDER BY `id` ASC");
        $i=1;
        while($my_ref=mysql_fetch_assoc($data_ref)){
        $dohod_ref=_FetchAssoc("SELECT * FROM `user_set` WHERE `id` = '" . $my_ref['id'] . "'");
        ?><div class="block_zero"><?=$i?>. <?=$my_ref['login']?>, золота: <img src="/images/icons/gold.png" alt="Золото"/><?=$dohod_ref['refer_gold']?>, баксов: <img src="/images/icons/baks.png" alt="Баксы"/><?=$dohod_ref['refer_baks']?></div><div class="dot-line"></div><?
        $i++;
        }
        ?></div></div><?
        break;
}
require_once('system/down.php');
?>
