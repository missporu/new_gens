<?php
$title = 'Профиль';
require_once __DIR__."/system/up.php";

$user = new RegUser();
$user->_Reg();

$sql = new SafeMySQL();
$site = new Site(); ?>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <nav class="navbar navbar-black" role="navigation">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse navbar-ex1-collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="?a=navik">Навыки</a></li>
                            <li><a href="?a=sklad">Имущество</a></li>
                            <li><a href="?a=trofei">Трофеи</a></li><?
                            if (!empty($_GET)) { ?>
                                <li><a href="?">Профиль</a></li><?
                            } ?>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Донат<b
                                            class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Купить золото</a></li>
                                    <li><a href="#">VIP аккаунт</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </nav>
            </div>
        </div>
    </div>

<? Site::lineHrInContainer() ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12"><?php
                $site->setSwitch(get: 'a');
                switch ($site->switch) {
                    default: ?>
                        <div class="col-xs-4">
                            <img src="images/flags/<?= $user->user(key: 'side') ?>.png" alt="Флаг"/>
                            <?= $user->user(key: 'login') ?>
                        </div>
                        <div class="col-xs-4 text-center">
                            <b class="text-info"><i class="fa fa-bar-chart" aria-hidden="true"></i> <?= $user->getRaiting($user->user('id')) ?></b> | <b class="text-warning"><i class="fa fa-users" aria-hidden="true"></i> <?= number_format(num: $user->user_alliance + 1) ?></b>
                        </div>
                        <div class="col-xs-4 text-right">
                            <b class="text-danger"><i class="fa fa-bullhorn" aria-hidden="true"></i> <?= $user->user(key: 'status') ?></b>
                        </div>
                        <? Site::PrintMiniLine(); ?>
                        <div class="col-xs-4"><?
                            if ($user->user('avatar') == 0) {
                                Site::returnImage(src: 'usersAvatars/noFoto.jpg', alt: 'ava');
                            } else {
                                Site::returnImage(src: 'usersAvatars/'.$user->user('avatar'), alt: 'ava');
                            } ?>
                        </div>
                        <div class="col-xs-8">
                            <p class="green">
                                <i class="fa fa-usd" aria-hidden="true"></i> Баксов:
                                <span class="pull-right"><?= $user->user('baks') ?></span>
                            </p>
                            <p class="silver">
                                <i class="fa fa-codepen" aria-hidden="true"></i> Серебра:
                                <span class="pull-right"><?= $user->user('silver') ?></span>
                            </p>
                            <p class="neft">
                                <i class="" aria-hidden="true">&#128738;</i> Нефти:
                                <span class="pull-right"><?= $user->user('neft') ?></span>
                            </p>
                            <p class="gaz">
                                <i class="fa fa-fire" aria-hidden="true"></i> Газа:
                                <span class="pull-right"><?= $user->user('gaz') ?></span>
                            </p>
                            <p class="yellow">
                                <i class="fa fa-battery-half" aria-hidden="true"></i> Энергии:
                                <span class="pull-right"><?= $user->user('energy') ?></span>
                            </p>
                            <p class="yellow">
                                <i class="fa fa-money" aria-hidden="true"></i> Денег: <i class="text-info"><? Site::linkToSiteAdd(class: 'red', link: 'bank', text: '[Пополнить]'); ?></i>
                                <span class="pull-right"><?= $user->user('gold') ?></span>
                            </p>
                            <p>
                                <i class="fa fa-bar-chart" aria-hidden="true"></i> Рейтинг:
                                <span class="pull-right"><?= $user->getRaiting($user->user('id')) ?></span>
                            </p>
                            <p>
                                <i class="fa fa-users" aria-hidden="true"></i> Альянс:
                                <span class="pull-right"><?= number_format(num: $user->user_alliance + 1) ?></span>
                            </p>
                            <p>
                                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Побед:
                                <span class="pull-right"><?= $user->user('wins') ?></span>
                            </p>
                            <p>
                                <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> Поражений:
                                <span class="pull-right"><?= $user->user('loses') ?></span>
                            </p>
                        </div><?php
                        break;

                    /* ТРОФЕИ */
                    case 'trofei':
                        echo "Трофеи в разработке.";
                        break;

                    /* СКЛАД */
                    case 'sklad':
                        echo "Склад в разработке";
                        break;

                    /* НАВЫКИ */
                    case 'navik':
                        echo "Навыки в разработке";
                        break;
                } ?>
            </div>
        </div>
    </div><?php
/*
switch ($_GET['case']) {
default:

<span style="color: #fffabd;"> Рейтинг</span> <?=$set['raiting']?></small></div><div class="mini-line"></div>
<hr>Ваш игровой статус: <?=$set['status'] ?> <a href="set.php?case=status">Смена статуса</a><br><?php

$left = _FetchAssoc("SELECT * FROM `user_reg` WHERE `id` = '".$fataliti_user['uho1_kto']."' LIMIT 1");
$right = _FetchAssoc("SELECT * FROM `user_reg` WHERE `id` = '".$fataliti_user['uho2_kto']."' LIMIT 1");
if($fataliti_user['uho1_kto'] != 0 AND $fataliti_user['uho2_kto'] != 0) {
$uho = '_2';
} elseif($fataliti_user['uho1_kto'] != 0) {
$uho = '_1';
} elseif($fataliti_user['uho2_kto'] != 0) {
$uho = '_1';
} else {
$uho = FALSE;
}
echo'<table width="100%"><tr><td width="25%">';

echo'<img class="float-left img-responsive" src="images/avatars/'.$set['avatar'].''.$uho.'.jpg" style="margin-left:10px;margin-right:15px;border:2px solid grey;" alt="Аватар">';

echo'</td><td>';

echo'Страна:<span style="float: right;">'.$strana.'</span><br />';

echo'Звание:<span style="float: right;">'.$set['zvanie'].'</span><br />';

echo'Пол:<span style="float: right;">'.$pol.'</span><br />';

echo'Побед:<span style="float: right;">'.$set['wins'].'</span><br />';

echo'Поражений:<span style="float: right;">'.$set['loses'].'</span><br />';

echo'Убийств:<span style="float: right;">'.$set['kills'].'</span><br />';

echo'Смертей:<span style="float: right;">'.$set['dies'].'</span><br />';

echo'Ушей:<span style="float: right;">'.$set['uho'].'</span><br />';

echo'Жетонов:<span style="float: right;">'.$set['zheton'].'</span><br />';

echo'</td></tr></table>';

echo'<div class="mini-line"></div>';

echo'<small>';

if($fataliti_user['uho1_kto'] != 0) {
echo'<div class="block_zero">Левое ухо у: '.$left['login'].'';
$time = $fataliti_user['uho1_up'] - time();
echo'<br />Отрастёт через: '._Time($time).' <a href="hosp.php">пришить</a>';
}

if($fataliti_user['uho2_kto'] != 0) {
echo'</div><div class="dot-line"></div><div class="block_zero">Правое ухо у: '.$right['login'].'';
$time = $fataliti_user['uho2_up'] - time();
echo'<br />Отрастёт через: '._Time($time).' <a href="hosp.php">пришить</a>';
}

echo'</small>';

if($fataliti_user['uho1_kto'] != 0 OR $fataliti_user['uho2_kto'] != 0) {
echo'</div><div class="mini-line"></div>';
}

echo'<div class="block_zero">Боевая эффективность:<br />';

echo'Атака: '.number_format_short($ITOG_A).'<span style="float: right;">Крит: '.$KRIT.'</span><br />';

echo'Защита: '.number_format_short($ITOG_Z).'<span style="float: right;">Уворот: '.$UVOROT.'</span><br />';

echo'<a href="pers.php?case=info">Подробно</a>';

echo'</div><div class="mini-line"></div><div class="block_zero">';

echo'Денежный поток (в час):<br />';

echo'Доход<span style="float: right;">'.$set['dohod'].'</span><br />';

echo'Содержание<span style="float: right;">'.$set['soderzhanie'].'</span><br />';

echo'Чистая прибыль<span style="float: right;">'.$set['chistaya'].'</span><br />';
/*
echo'</div><div class="mini-line"></div><div class="block_zero">';

echo'Фаталити:<br />';

echo'Жетоны<span style="float: right;">'.$user['zheton'].'</span><br />';

echo'Отрезанные уши<span style="float: right;">'.$user['uho'].'</span><br />';

echo'Фаталити доступно<span style="float: right;">'.$user['fataliti_dost'].'/5</span><br />';

echo "Дата регистрации: ".$set['data_reg']."";

echo'</div></div>';

break;

case 'unitbuild':

?><div class="mini-line"></div><div class="block_zero"><img src="images/flags/<?=$set['side']?>.png"  alt="Флаг"/> <?=$user['login']?><br /><small><span style="color: #fffabd;">Ур.</span> <?=$set['lvl']?>, <span style="color: #fffabd;">Ал.</span> <?=number_format($user_alliance+1)?>, <span style="color: #fffabd;"> Рейтинг</span> <?=$set['raiting']?></small></div>

<div class="dot-line"></div><div class="block_zero"><span style="color: #9c9;">Наземная техника</span></div><?

$data=mysql_query("SELECT * FROM `user_unit` WHERE `tip` IN('1','4') AND `id_user`='".$user_id."' ORDER BY `id` ASC");
?><table><tr><?
$cols = 0;
$maxcols = 4;
while($my_unit=mysql_fetch_assoc($data)){
if($my_unit['tip']==4){
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

?><div class="dot-line"></div><div class="block_zero"><span style="color: #9c9;">Морская техника</span></div><?

$data=mysql_query("SELECT * FROM `user_unit` WHERE `tip` IN('2','5') AND `id_user`='".$user_id."' ORDER BY `id` ASC");
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

$data=mysql_query("SELECT * FROM `user_unit` WHERE `tip` IN('3','6') AND `id_user`='".$user_id."' ORDER BY `id` ASC");
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

$data=mysql_query("SELECT * FROM `user_superunit` WHERE `id_user`='".$user_id."' ORDER BY `id` ASC");
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

$data=mysql_query("SELECT * FROM `user_build` WHERE`tip`='1' AND `id_user`='".$user_id."' ORDER BY `id` ASC");
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

$data=mysql_query("SELECT * FROM `user_build` WHERE `tip`='2' AND `id_user`='".$user_id."' ORDER BY `id` ASC");
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

$data=mysql_query("SELECT * FROM `user_build` WHERE `tip`='3' AND `id_user`='".$user_id."' ORDER BY `id` ASC");
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

?></div></div><?

break;

case 'raspred': ?>

<div class="row">
    <div class="text-center text-info">
        <hr>Не использовано <?= $set['skill'] ?> очков навыков<hr>
    </div>
    <div class="col-sm-4 col-xs-4 col-md-4">
        <img src="images/icons/mp.png" alt="*"> <b>Энергия:</b> <?= $set['max_mp'] ?> <br><small class="text-success">Расходуется при выполнении спецопераций</small>
    </div>
    <div class="col-sm-8 col-xs-8 col-md-8 text-right"><?php
        if (isset($_POST['kupen_mp']) && $_POST['skoko_mp'] > 0) {
                $summa_mp = $_POST['skoko_mp'];
                $vsego_skill = $set['skill']-$summa_mp;
                $vsego_mp = $set['max_mp']+($summa_mp*10);
                if ($set['skill']<1 || $set['skill']<$summa_mp) {
                    $_SESSION['err'] = 'Недостаточно очков навыков';
                    header('Location: ?case=raspred');
                    exit();
                }
                mysql_query("UPDATE `user_set` SET `max_mp` = '" . $vsego_mp . "', `skill` = '" . $vsego_skill . "' WHERE `id` = '" . $user_id . "' ");
                $_SESSION['ok'] = 'Навык успешно повышен';
                header('Location: ?case=raspred');
                exit();
            } else { ?>
                <form method="POST" action="?case=raspred">
                    <b>Сколько потратить очков?</b> <small class="text-info">1 очко = 10 энергии</small><br>
                    <input type="number" name="skoko_mp"> 
                    <input type="submit" name="kupen_mp" value="Купить">
                </form><?php 
            } // end of form ?><br/>
    </div><hr>
<div class="clearfix"></div><hr>

    <div class="col-sm-4 col-xs-4 col-md-4">
        <img src="images/icons/hp.png" alt="*"> <b>Здоровье:</b> <?= $set['max_hp'] ?><br><small class="text-success">Для участия в боях необходимо минимум 25 здоровья</small>
    </div>
    <div class="col-sm-8 col-xs-8 col-md-8 text-right"><?php
        if (isset($_POST['kupen_hp']) && $_POST['skoko_hp'] > 0) {
            $summa_hp = $_POST['skoko_hp'];
            $vsego_skill = $set['skill']-$summa_hp;
            $vsego_hp = $set['max_hp']+$summa_hp;
            if ($set['skill']<1 || $set['skill']<$summa_hp) {
                $_SESSION['err'] = 'Недостаточно очков навыков';
                header('Location: ?case=raspred');
                exit();
            }
                if ($set['side']=='b') {
                    $hp_side=12*$_POST['skoko_hp'];
                } else {
                    $hp_side=10*$_POST['skoko_hp'];
                }        
                $trof_hp=_FetchAssoc("SELECT * FROM `user_trofei` WHERE `id_user` = '".$user_id."' AND `id_trof` = '6'");
                    
                if ($trof_hp['status']==1 AND $trof_hp['time_up']==0) {
                    $h_p=$hp_side+(($set['hp']*100)/(100+$trof_hp['bonus_1']));
                    $hp=$h_p+$h_p/100*($trof_hp['bonus_1']);
                    $max_h_p=$hp_side+(($set['max_hp']*100)/(100+$trof_hp['bonus_1']));
                    $max_hp=$max_h_p+$max_h_p/100*($trof_hp['bonus_1']);
                } else {
                    $hp=$set['hp']+$hp_side;
                    $max_hp=$set['max_hp']+$hp_side;
                }        
                mysql_query("UPDATE `user_set` SET `max_hp`='".$max_hp."', `skill` = '" . $vsego_skill . "' WHERE `id`='".$user_id."' LIMIT 1");
                $_SESSION['ok'] = 'Навык успешно повышен';
                header('Location: ?case=raspred');
                exit();
            } else { ?>
                <form method="POST" action="?case=raspred">
                    <b>Сколько потратить очков?</b> <small class="text-info">1 очко = 10 здоровья</small><br>
                    <input type="number" name="skoko_hp"> 
                    <input type="submit" name="kupen_hp" value="Купить">
                </form><?php 
            } // end of form ?><br/>
    </div><hr>
    <div class="clearfix"></div><hr>

    <div class="col-sm-4 col-xs-4 col-md-4">
        <img src="images/icons/ataka.png" alt="*"> <b>Боеприпасы:</b> <?= $set['max_udar'] ?><br><small class="text-success">Количество нападений, которые совершаются на противников</small>
    </div>
    <div class="col-sm-8 col-xs-8 col-md-8 text-right"><?php
        if (isset($_POST['kupen_bp']) && $_POST['skoko_bp'] > 0) {
            $summa_bp = $_POST['skoko_bp'];
            $vsego_skill = $set['skill']-($summa_bp*2);
            $vsego_bp = $set['max_udar']+$summa_bp;
            if ($set['skill']<2 || $set['skill']<($summa_bp*2)) {
                $_SESSION['err'] = 'Недостаточно очков навыков';
                header('Location: ?case=raspred');
                exit();
            }
            mysql_query("UPDATE `user_set` SET `max_udar` = '" . $vsego_bp . "', `skill` = '" . $vsego_skill . "' WHERE `id` = '" . $user_id . "'");
            $_SESSION['ok'] = 'Навык успешно повышен';
            header('Location: ?case=raspred');
            exit();
            } else { ?>
                <form method="POST" action="?case=raspred">
                    <b>Сколько потратить очков?</b> <small class="text-info">2 очка = 1 боеприпас</small><br>
                    <input type="number" name="skoko_bp"> 
                    <input type="submit" name="kupen_bp" value="Купить">
                </form><?php 
            } // end of form ?><br/>
    </div><hr>
    <div class="clearfix"></div><hr>

    <div class="col-sm-4 col-xs-4 col-md-4">
        <img src="images/icons/krit.png" alt="*"> <b>Жестокость:</b> <?= $set['krit'] ?><br><small class="text-success">Чем выше, тем больше шанс совершить фаталити</small>
    </div>
    <div class="col-sm-8 col-xs-8 col-md-8 text-right"><?php
        if (isset($_POST['kupen_krit']) && $_POST['skoko_krit'] > 0) {
            $summa_krit = $_POST['skoko_krit'];
            $vsego_skill = $set['skill']-($summa_krit*2);
            $vsego_krit = $set['krit']+$summa_krit;
            if ($set['skill']<2 || $set['skill']<($summa_krit*2)) {
                $_SESSION['err'] = 'Недостаточно очков навыков';
                header('Location: ?case=raspred');
                exit();
            }
            mysql_query("UPDATE `user_set` SET `krit` = '" . $vsego_krit . "', `skill` = '" . $vsego_skill . "' WHERE `id` = '" . $user_id . "'");
            $_SESSION['ok'] = 'Навык успешно повышен';
            header('Location: ?case=raspred');
            exit();
            } else { ?>
                <form method="POST" action="?case=raspred">
                    <b>Сколько потратить очков?</b> <small class="text-info">2 очка = 1 жестокость</small><br>
                    <input type="number" name="skoko_krit"> 
                    <input type="submit" name="kupen_krit" value="Купить">
                </form><?php 
            } // end of form ?><br/>
    </div><hr>
    <div class="clearfix"></div><hr>

    <div class="col-sm-4 col-xs-4 col-md-4">
        <img src="images/icons/uvorot.png" alt="*"> <b>Ловкость:</b> <?= $set['uvorot'] ?><br><small class="text-success">Чем выше, тем больше шанс защититься от фаталити</small>
    </div>
    <div class="col-sm-8 col-xs-8 col-md-8 text-right"><?php
        if (isset($_POST['kupen_uvor']) && $_POST['skoko_uvor'] > 0) {
            $summa_uvor = $_POST['skoko_uvor'];
            $vsego_skill = $set['skill']-($summa_uvor*2);
            $vsego_uvor = $set['uvorot']+$summa_uvor;
            if ($set['skill']<2 || $set['skill']<($summa_uvor*2)) {
                $_SESSION['err'] = 'Недостаточно очков навыков';
                header('Location: ?case=raspred');
                exit();
            }
            mysql_query("UPDATE `user_set` SET `uvorot` = '" . $vsego_uvor . "', `skill` = '" . $vsego_skill . "' WHERE `id` = '" . $user_id . "'");
            $_SESSION['ok'] = 'Навык успешно повышен';
            header('Location: ?case=raspred');
            exit();
            } else { ?>
                <form method="POST" action="?case=raspred">
                    <b>Сколько потратить очков?</b> <small class="text-info">2 очка = 1 уворот</small><br>
                    <input type="number" name="skoko_uvor"> 
                    <input type="submit" name="kupen_uvor" value="Купить">
                </form><?php 
            } // end of form ?><br/>
    </div><hr>
</div>

</div><?php
        break;        
    case 'enka':
        if ($set['skill'] < 1) {
            $_SESSION['err'] = 'Недостаточно очков навыков';
            header('Location: ?case=raspred');
            exit();
        }
        mysql_query('UPDATE `user_set` SET `mp` = `mp` + "10", `max_mp` = `max_mp` + "10", `skill` = `skill` - "1" WHERE `id` = "' . $user_id . '"');
        $_SESSION['ok'] = 'Навык успешно повышен';
        header('Location: ?case=raspred');
        exit();
        break;        
    case 'zdor':
        if ($set['skill'] < 1) {
            $_SESSION['err'] = 'Недостаточно очков навыков';
            header('Location: ?case=raspred');
            exit();
        }        
        if($set['side']=='b'){
        $hp_side=12;
        }else{
        $hp_side=10;
        }        
        $trof_hp=_FetchAssoc("SELECT * FROM `user_trofei` WHERE `id_user` = '".$user_id."' AND `id_trof` = '6'");
        
        if($trof_hp['status']==1 AND $trof_hp['time_up']==0){
        $h_p=$hp_side+(($set['hp']*100)/(100+$trof_hp['bonus_1']));
    $hp=$h_p+$h_p/100*($trof_hp['bonus_1']);
        $max_h_p=$hp_side+(($set['max_hp']*100)/(100+$trof_hp['bonus_1']));
      $max_hp=$max_h_p+$max_h_p/100*($trof_hp['bonus_1']);
}else{
$hp=$set['hp']+$hp_side;
$max_hp=$set['max_hp']+$hp_side;
}        
        mysql_query("UPDATE `user_set` SET `hp`='".$hp."', `max_hp`='".$max_hp."', `skill` = `skill` - '1' WHERE `id`='".$user_id."' LIMIT 1");
        $_SESSION['ok'] = 'Навык успешно повышен';
        header('Location: ?case=raspred');
        exit();
        break;        
    case 'udar':
        if ($set['skill'] < 2) {
            $_SESSION['err'] = 'Недостаточно очков навыков';
            header('Location: ?case=raspred');
            exit();
        }
        mysql_query('UPDATE `user_set` SET `udar` = `udar` + "1", `max_udar` = `max_udar` + "1", `skill` = `skill` - "2" WHERE `id` = "' . $user_id . '"');
        $_SESSION['ok'] = 'Навык успешно повышен';
        header('Location: ?case=raspred');
        exit();
        break;        
    case 'krit':
        if ($set['skill'] < 2) {
            $_SESSION['err'] = 'Недостаточно очков навыков';
            header('Location: pers.php?case=raspred');
            exit();
        }
        mysql_query('UPDATE `user_set` SET `skill` = `skill` - "2", `krit` = `krit` + "1" WHERE `id` = "' . $user_id . '"');
        $_SESSION['ok'] = 'Навык успешно повышен';
        header('Location: pers.php?case=raspred');
        exit();
        break;        
    case 'uvorot':
        if ($set['skill'] < 2) {
            $_SESSION['err'] = 'Недостаточно очков навыков';
            header('Location: pers.php?case=raspred');
            exit();
        }
        mysql_query('UPDATE `user_set` SET `skill` = `skill` - "2", `uvorot` = `uvorot` + "1" WHERE `id` = "' . $user_id . '"');
        $_SESSION['ok'] = 'Навык успешно повышен';
        header('Location: pers.php?case=raspred');
        exit();
        break;

case 'info':

?><div class="mini-line"></div><?
echo'<div class="block_zero center"><h1 class="yellow">Боевая эффективность</h1></div><div class="mini-line"></div><div class="block_zero center">Атака:</div><div class="dot-line"></div><div class="block_zero"><span style="color: #9c9;">


Атака техники<span style="float: right;">'.($A1+$A2).'</span><br />
Атака разработок<span style="float: right;">'.$SA.'</span><br />
Бонус от наемников<span style="float: right;">'.round(($A4+$A5+$A6),0).'</span><br />
Бонус от трофеев<span style="float: right;">'.$a_trof_bonus.'</span><br />
Бонус от страны<span style="float: right;">'.round($A3,0).'</span><br />
Подкрепления<span style="float: right;"></span><br />
Бонус от флага<span style="float: right;"></span><br />
Достижения<span style="float: right;"></span><br />
Праздничный бонус<span style="float: right;"></span><br />
Поддержки, падлянки<span style="float: right;"></span><br />
Жестокость<span style="float: right;">'.$KRIT.'</span><br />
</span>
<b>Суммарная атака<span style="float: right;">'.round($ITOG_A,0).'</b></span><br />

</div><div class="mini-line"></div><div class="block_zero center">Защита:</div><div class="dot-line"></div><div class="block_zero"><span style="color: #9c9;">

Защита техники<span style="float: right;">'.($Z1+$Z2).'</span><br />
Защита разработок<span style="float: right;">'.$SZ.'</span><br />
Защита построек<span style="float: right;">'.$PZ1.'</span><br />
Бонус от наемников<span style="float: right;">'.round(($Z4+$Z5+$Z6),0).'</span><br />
Бонус от трофеев<span style="float: right;">'.$z_trof_bonus.'</span><br />
Бонус от страны<span style="float: right;">'.round(($Z3+$PZ2),0).'</span><br />
Подкрепления<span style="float: right;"></span><br />
Бонус от флага<span style="float: right;"></span><br />
Достижения<span style="float: right;"></span><br />
Праздничный бонус<span style="float: right;"></span><br />
Поддержки, падлянки<span style="float: right;"></span><br />
Ловкость<span style="float: right;">'.$UVOROT.'</span><br />
</span>
<b>Суммарная защита<span style="float: right;">'.round($ITOG_Z,0).'</b></span><br />

</div></div>';
break;

case 'trof':
if(isset($_GET['log'])){
$id_trof=isset($_GET['id_trof'])?_NumFilter($_GET['id_trof']):NULL;
$trof_set=_FetchAssoc("SELECT * FROM `user_trofei` WHERE `id_trof`='".$id_trof."' AND `id_user`='".$user_id."' LIMIT 1");
$shag_set=_FetchAssoc("SELECT `name`, `shag_1`, `shag_2` FROM `trofei` WHERE `id`='".$trof_set['id_trof']."' LIMIT 1");
if($trof_set['lvl']>9){
$_SESSION['err'] = 'Трофей "'.$shag_set['name'].'" уже прокачан до максимального уровня!';
header('Location: pers.php?case=trof');
exit();
}
if($trof_set['id_trof']<1 OR $trof_set['id_trof']>18){
$_SESSION['err'] = 'Нет такого трофея!';
header('Location: pers.php?case=trof');
exit();
}
if($_GET['log']=='gold'){
if($trof_set['cena_gold']>$set['gold']){
$_SESSION['err'] = 'Недостаточно золота!';
header('Location: pers.php?case=trof');
exit();
}
mysql_query("UPDATE `user_trofei` SET `lvl`='".($trof_set['lvl']+1)."', `cena_baks`='".($trof_set['cena_baks']*2)."', `cena_gold`='".($trof_set['cena_gold']*2)."', `time_up`='0', `day`='".($trof_set['day']+2)."', `bonus_1`='".($trof_set['bonus_1']+$shag_set['shag_1'])."', `bonus_2`='".($trof_set['bonus_2']+$shag_set['shag_2'])."', `next_1`='".($trof_set['next_1']+$shag_set['shag_1'])."', `next_2`='".($trof_set['next_2']+$shag_set['shag_2'])."' WHERE `id_trof`='".$id_trof."' AND `id_user`='".$user_id."' LIMIT 1");
mysql_query("UPDATE `user_set` SET `gold`=`gold`-'".$trof_set['cena_gold']."' WHERE `id`='".$user_id."' LIMIT 1");

if($trof_set['id_trof']==6){
if($trof_set['time_up']==0){
$h_p=($set['hp']*100)/(100+$trof_set['bonus_1']);
$hp=$h_p+$h_p/100*($trof_set['bonus_1']+$shag_set['shag_1']);
$max_h_p=($set['max_hp']*100)/(100+$trof_set['bonus_1']);
$max_hp=$max_h_p+$max_h_p/100*($trof_set['bonus_1']+$shag_set['shag_1']);
mysql_query("UPDATE `user_set` SET `hp`='".$hp."', `max_hp`='".$max_hp."' WHERE `id`='".$user_id."' LIMIT 1");
}else{
$hp=$set['hp']/100*($trof_set['bonus_1']+$shag_set['shag_1']);
$max_hp=$set['max_hp']/100*($trof_set['bonus_1']+$shag_set['shag_1']);
mysql_query("UPDATE `user_set` SET `hp`=`hp`+'".$hp."', `max_hp`=`max_hp`+'".$max_hp."' WHERE `id`='".$user_id."' LIMIT 1");
}
}

if($trof_set['id_trof']==4){
if($trof_set['time_up']==0){
$soderzhan=($set['soderzhanie']*100)/(100-$trof_set['bonus_1']);
$soderzhanie=$soderzhan-$soderzhan/100*($trof_set['bonus_1']+$shag_set['shag_1']);
$chistaya=$set['dohod']-$soderzhanie;
mysql_query("UPDATE `user_set` SET `soderzhanie`='".$soderzhanie."', `chistaya`='".$chistaya."' WHERE `id`='".$user_id."' LIMIT 1");
}else{
$soderzhanie=$set['soderzhanie']/100*($trof_set['bonus_1']+$shag_set['shag_1']);
$chistaya=$set['chistaya']+$soderzhanie;
mysql_query("UPDATE `user_set` SET `soderzhanie`=`soderzhanie`-'".$soderzhanie."', `chistaya`='".$chistaya."' WHERE `id`='".$user_id."' LIMIT 1");
}
}

$_SESSION['ok'] = 'Трофей "'.$shag_set['name'].'" прокачан до '.($trof_set['lvl']+1).' уровня!';
header('Location: pers.php?case=trof');
exit();
}
if($_GET['log']=='baks'){
$time_stop=_FetchAssoc("SELECT * FROM `user_trofei` WHERE `id_user` = '".$user_id."' AND `time_up`!='0' LIMIT 1");
if($time_stop){
$_SESSION['err'] = 'За баксы можно прокачивать только один трофей!';
header('Location: pers.php?case=trof');
exit();
}
if($trof_set['cena_baks']>$set['baks']){
$_SESSION['err'] = 'Недостаточно баксов!';
header('Location: pers.php?case=trof');
exit();
}
mysql_query("UPDATE `user_trofei` SET `time_up`='".(time()+($trof_set['day']*86400))."' WHERE `id_trof`='".$id_trof."' AND `id_user`='".$user_id."' LIMIT 1");
mysql_query("UPDATE `user_set` SET `baks`=`baks`-'".$trof_set['cena_baks']."' WHERE `id`='".$user_id."' LIMIT 1");

if($trof_set['id_trof']==6){
$trof_hp=($set['hp']*100)/(100+$trof_set['bonus_1']);
$trof_max_hp=($set['max_hp']*100)/(100+$trof_set['bonus_1']);
mysql_query("UPDATE `user_set` SET `hp`='".$trof_hp."', `max_hp`='".$trof_max_hp."' WHERE `id`='".$user_id."' LIMIT 1");
}

if($trof_set['id_trof']==4){
$trof_soderzhanie=($set['soderzhanie']*100)/(100-$trof_set['bonus_1']);
$trof_chistaya=$set['dohod']-$trof_soderzhanie;
mysql_query("UPDATE `user_set` SET `soderzhanie`='".$trof_soderzhanie."', `chistaya`='".$trof_chistaya."' WHERE `id`='".$user_id."' LIMIT 1");
}

$_SESSION['ok'] = 'Вы начали прокачку трофея "'.$shag_set['name'].'" до '.($trof_set['lvl']+1).' уровня!';
header('Location: pers.php?case=trof');
exit();
}
}
$data_trofei=mysql_query("SELECT * FROM `user_trofei` WHERE `id_user`='".$user_id."' ORDER BY `id_trof` ASC LIMIT 8");
while($data_trof=mysql_fetch_assoc($data_trofei)){
$user_trof=_FetchAssoc("SELECT * FROM `trofei` WHERE `id`='".$data_trof['id_trof']."' LIMIT 1");
if($data_trof['status']==0){
        $lock='_locked';
        $ur=FALSE;
        $color='#999';
        $colo='#ff3434';
        $col='#999';        
        $opisanie=$user_trof['opisanie_1'];
        $opisanie2=FALSE;
        $uslovie=$user_trof['uslovie_1'];
        $uslovie2=FALSE;
        }else{
        $lock=FALSE;
        $ur='('.$data_trof['lvl'].' ур.)';
        $color='#fffabd';
        $colo='#f96';
        $col='#9c9';        
        $opisanie=''.$user_trof['opisanie_2'].' '.$data_trof['bonus_1'].'%';
        $uslovie=''.$user_trof['uslovie_2'].' '.$data_trof['next_1'].'%';        
        if($user_trof['opisanie_3']){
        $opisanie2=' '.$user_trof['opisanie_3'].' '.$data_trof['bonus_2'].'%';
        }else{
        $opisanie2=FALSE;
        }        
        if($user_trof['uslovie_3']){
        $uslovie2=' '.$user_trof['uslovie_3'].' '.$data_trof['next_2'].'% '.$user_trof['uslovie_4'].'';
        }else{
        $uslovie2=FALSE;
        }        
        }
?><div class="mini-line"></div><table width="100%"><tr><td width="40%"><img class="float-left" src="images/trofei/<?= $data_trof['id_trof'].''.$lock?>.png" style="margin-left:0px;margin-right:0px;border:1px solid #999;" alt="Трофей"></td><td valign="top"><b><span style="color: <?=$col?>;"><small><?=$user_trof['name'].' '.$ur?></span></b><br/><span style="color: <?=$color?>;"><?=$opisanie?><?=$opisanie2?></small></span></td></tr></table><div class="dot-line"></div><div class="block_zero center"><span style="color: <?=$colo?>;"><?

if($data_trof['lvl']<10){

?><small><?=$uslovie?><?=$uslovie2?></small></span><?
if($data_trof['status']!=0){

?></div><div class="dot-line"></div><div class="block_zero center"><a class="btn" href="pers.php?case=trof&log=gold&id_trof=<?= $user_trof['id'] ?>"><span class="end"><span class="label">Прокачать моментально за <img src="images/icons/gold.png" alt="*" /> <?= number_format($data_trof['cena_gold'])?></span></span></a><?

if($data_trof['time_up']==0){
?></div><div class="dot-line"></div><div class="block_zero center"><a class="btn" href="pers.php?case=trof&log=baks&id_trof=<?= $user_trof['id'] ?>"><span class="end"><span class="label">Прокачивать <?= $data_trof['day'].' ' . _Users($data_trof['day'], 'день', 'дня', 'дней')?> за <img src="images/icons/baks.png" alt="*" /> <?= number_format($data_trof['cena_baks'])?></span></span></a><?
}else{
$time_up=$data_trof['time_up']-time();
?></div><div class="dot-line"></div><div class="block_zero center"><small>Прокачается через: <?=_DayTime($time_up)?></small><?
}
}
}else{
?><b><span style="color: <?=$colo?>;">Трофей максимально прокачан</span></b><?
}
?></div><?
}
?><div class="mini-line"></div><ul class="hint"><li>При прокачке трофея за игровые деньги он не используется все время, нужное для прокачки.</li><li>Можно прокачивать только один трофей одновременно.</li><li>Цена прокачки трофея зависит от его уровня.</li></ul></div></div><?
break;

case 'pokupka_navik':
        if (isset($_POST['kupit'])) {
            $donat_navik = $set['gold']-(250*$_POST['skoko_navik']);
            if ($donat_navik < 249) {
                $_SESSION['err'] = 'Недостаточно золота!';
                header('Location: bank.php?case=worldkassa');
                exit();
            }
            $plusnavik = $set['skill']+$_POST['skoko_navik'];
            $plus_kuplen = $set['skill_kuplen']+$_POST['skoko_navik'];

            mysql_query("UPDATE `user_set` SET `gold`='" . $donat_navik . "', `skill`='" . $plusnavik . "', `skill_kuplen`='" . $plus_kuplen . "' WHERE `id`='" . $set['id'] . "' LIMIT 1");
            $_SESSION['ok'] = 'Навыки успешно куплены в кол-ве '.$_POST['skoko_navik'].' ';
            header('Location: ?case=raspred');
            exit();
        } else { ?>
            <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
                Сколько очков навыков покупаем? 1 навык = 250 золота. Очки навыков покупаются <b>навсегда!</b><br>
                <input type="number" name="skoko_navik"> 
                <input type="submit" name="kupit" value="Купить навыки">
            </form><?php 
        } // end of form

        $opit_ravno = _FetchAssoc("SELECT * FROM `lvl` WHERE `opit`>='".$set['exp']."' LIMIT 1");
        $skill_obn = ($opit_ravno['lvl']*5);
        $skill_new_operation1 = _FetchAssoc("SELECT * FROM `user_operation` WHERE `id_user`='".$set['id']."' AND `id_operation`='1' LIMIT 1");
        $sk1 = ($skill_new_operation1['point']*2);
        $skill_new_operation2 = _FetchAssoc("SELECT * FROM `user_operation` WHERE `id_user`='".$set['id']."' AND `id_operation`='2' LIMIT 1");
        $sk2 = ($skill_new_operation2['point']*2);
        $skill_new_operation3 = _FetchAssoc("SELECT * FROM `user_operation` WHERE `id_user`='".$set['id']."' AND `id_operation`='3' LIMIT 1");
        $sk3 = ($skill_new_operation3['point']*2);
        $skill_new_operation4 = _FetchAssoc("SELECT * FROM `user_operation` WHERE `id_user`='".$set['id']."' AND `id_operation`='4' LIMIT 1");
        $sk4 = ($skill_new_operation4['point']*2);
        $skill_new_operation5 = _FetchAssoc("SELECT * FROM `user_operation` WHERE `id_user`='".$set['id']."' AND `id_operation`='5' LIMIT 1");
        $sk5 = ($skill_new_operation5['point']*2);
        $skill_new_operation6 = _FetchAssoc("SELECT * FROM `user_operation` WHERE `id_user`='".$set['id']."' AND `id_operation`='6' LIMIT 1");
        $sk6 = ($skill_new_operation6['point']*2);
        $skill_new_operation7 = _FetchAssoc("SELECT * FROM `user_operation` WHERE `id_user`='".$set['id']."' AND `id_operation`='7' LIMIT 1");
        $sk7 = ($skill_new_operation7['point']*2);
        $skill_new_operation8 = _FetchAssoc("SELECT * FROM `user_operation` WHERE `id_user`='".$set['id']."' AND `id_operation`='8' LIMIT 1");
        $sk8 = ($skill_new_operation8['point']*2);
        $skill_new_operation9 = _FetchAssoc("SELECT * FROM `user_operation` WHERE `id_user`='".$set['id']."' AND `id_operation`='9' LIMIT 1");
        $sk9 = ($skill_new_operation9['point']*2);
        $skill_new_operation10 = _FetchAssoc("SELECT * FROM `user_operation` WHERE `id_user`='".$set['id']."' AND `id_operation`='10' LIMIT 1");
        $sk10 = ($skill_new_operation10['point']*2);
        $skill_new = $sk1+$sk2+$sk3+$sk4+$sk5+$sk6+$sk7+$sk8+$sk9+$sk10+$skill_obn;
        mysql_query("UPDATE `user_set` SET `skill_full`='".$skill_new."' WHERE `id`='".$set['id']."' LIMIT 1");
        $set = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $set['id'] . "'");
        if (isset($_POST['navik_ravno'])) {
            $gold_sbros = $set['gold']-50;
            $skill_plus = $set['skill_full']+$set['skill_kuplen'];
            mysql_query("UPDATE `user_set` SET `skill`='".$skill_plus."', `udar`='0', `max_hp`='100', `max_mp`='100', `max_udar`='5', `krit`='0', `uvorot`='0', `gold`='" . $gold_sbros . "'  WHERE `id`='".$set['id']."' LIMIT 1");
            $_SESSION['ok'] = 'Навыки успешно сброшены';
            header("Location: pers.php");
            exit();
        } else { ?>
            <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
                Каждый сброс навыков стоит <b>50 золота!</b><br>
                <input type="submit" name="navik_ravno" value="Сбросить навыки">
            </form><?php 
        } // end of form
    break;
} */
require_once __DIR__.'/system/down.php';