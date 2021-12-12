<?php

$title = 'Курс молодого бойца';
require_once 'system/up.php';

$user = new RegUser();
$site = new Site();
$sql = new SafeMySQL();

$user->_Reg();

$site->setSwitch(get: 'a');
if (isset($site->switch)) {
    if (is_null($site->switch)) {
        $site->switch = 0;
    }
}
$start_text = $sql->getRow("select * from start where step = ?i", $site->switch);

if ($site->switch > $user->user(key: 'start')) {
    Site::session_empty(type: 'error', text: 'Вы не закончили обучение!', location: "?a={$user->user(key: 'start')}");
}
if ($user->user(key: 'start') > $site->switch) {
    Site::session_empty(type: 'error', text: 'Вы уже прошли то обучение, продолжайте!', location: "?a={$user->user(key: 'start')}");
}

switch ($site->switch) {
    default:
        Site::_location(location: '?a=0');

    case '0':
        if (isset($_GET['log']) and $_GET['log'] == 'ataka') {
            $sql->query("update users set
                    exp = exp + ?i, 
                    baks = baks + ?i, 
                    hp = hp - ?i, 
                    start = ?i where 
                    id = ?i",
                5, 100, 10, 1, $user->user(key: 'id'));
            Site::_location(location: '?a=1');
        } ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-6 text-center">
                    <? Site::returnImage(class: 'img-responsive text-center', src: 'start/start.jpg', alt: 'Обучение'); ?>
                </div>
                <div class="col-xs-6">
                    <b class="text-danger">Майор:</b> <i class="text-warning"><?= $start_text['text'] ?></i>
                </div>
                <div class="clearfix"></div>
                <? Site::PrintMiniLine() ?>
                <div class="col-xs-12 text-center">
                    <h1 class="yellow">Война</h1>
                </div>
                <? Site::PrintMiniLine() ?>
                <div class="col-xs-12">
                    <div class="col-xs-6">
                        <span class="green">
                            <? Site::returnImage(class: "", src: "flags/a.png", alt: "Флаг", text: 'Генерал Ричардс'); ?>
                        </span>
                        <span class="text-info">
                             (1 lvl)
                        </span>
                    </div>
                    <div class="col-xs-6 text-right">
                        <? Site::linkToSiteAdd(class: 'btn btn-block btn-danger', link: '?a=0&log=ataka', text: 'Атаковать'); ?>
                    </div>
                </div>
                <? Site::PrintMiniLine() ?>
            </div>
        </div><?php
        break;

    case '1':
        if (isset($_GET['log']) and $_GET['log'] == 'ataka') {
            $sql->query("update users set 
                    exp = exp + ?i, 
                    baks = baks + ?i, 
                    hp = hp - ?i, 
                    start = ?i where 
                    id = ?i",
                5, 100, 10, 2, $user->user(key: 'id'));
            Site::_location(location: '?a=2');
        } ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-xs-6">
                        <? Site::returnImage(class: 'img-responsive text-center', src: 'start/1.jpg', alt: 'Обучение'); ?>
                    </div>
                    <div class="col-xs-6">
                        <b class="text-danger">Майор:</b> <i class="text-warning"><?= $start_text['text'] ?></i>
                    </div>
                    <div class="clearfix"></div>
                    <? Site::PrintMiniLine() ?>
                    <div class="col-xs-12 text-center">
                        <h1 class="yellow">Война</h1>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-12">
                            <h5 class="green text-center">Победа!</h5>
                            <p class="green">Нанесено: 20 урона</p>
                            <p class="text-danger">Получено: 10 урона</p>
                            <p class="green">Награблено: 100 $</p>
                            <p class="green">Заработано: 5 опыта</p>
                        </div>
                    </div>
                    <? Site::PrintMiniLine() ?>
                    <div class="col-xs-12">
                        <div class="col-xs-6">
                        <span class="green">
                            <? Site::returnImage(class: "", src: "flags/a.png", alt: "Флаг", text: 'Генерал Ричардс'); ?>
                        </span>
                            <span class="text-info">
                             (1 lvl)
                        </span>
                        </div>
                        <div class="col-xs-6 text-right">
                            <? Site::linkToSiteAdd(class: 'btn btn-block btn-danger', link: '?a=1&log=ataka', text: 'Атаковать'); ?>
                        </div>
                    </div>
                    <? Site::PrintMiniLine() ?>
                </div>
            </div>
        </div><?php
        break;

    case '2':
        if (isset($_GET['log']) and $_GET['log'] == 'do') {
            $sql->query("update users set start = ?i where id = ?i", 3, $user->user(key: 'id'));
            Site::_location(location: '?a=3');
        } ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-6 text-center">
                    <? Site::returnImage(class: 'img-responsive text-center', src: 'start/2.jpg', alt: 'Обучение'); ?>
                </div>
                <div class="col-xs-6">
                    <b class="text-danger">Майор:</b> <i class="text-warning"><?= $start_text['text'] ?></i>
                </div>
                <div class="clearfix"></div>
                <? Site::PrintMiniLine() ?>
                <div class="col-xs-12 text-center">
                    <h1 class="yellow">Война</h1>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-12">
                        <h5 class="green text-center">Победа!</h5>
                        <p class="green">Нанесено: 20 урона</p>
                        <p class="text-danger">Получено: 10 урона</p>
                        <p class="green">Награблено: 100 $</p>
                        <p class="green">Заработано: 5 опыта</p>
                    </div>
                </div>
                <? Site::PrintMiniLine() ?>
                <div class="col-xs-12">
                    <div class="col-xs-6">
                        <span class="green">
                            <? Site::returnImage(class: "", src: "flags/a.png", alt: "Флаг", text: 'Генерал Ричардс'); ?>
                        </span>
                        <span class="text-info">
                             (1 lvl)
                        </span>
                    </div>
                    <div class="col-xs-6 text-right">
                        <? Site::linkToSiteAdd(class: 'btn btn-block btn-warning', link: '?a=2&log=do', text: 'Техника'); ?>
                    </div>
                </div>
                <? Site::PrintMiniLine() ?>
            </div>
        </div><?php
        break;

    case '3':
        $unit_start = $sql->getRow("select * from unit where lvl = ?i limit ?i", 2, 1);

        if (isset($_GET['log']) and $_GET['log'] == 'take') {
            $sql->query("update users set baks = baks - ?i, start = ?i where id = ?i", $unit_start['cena'], 4, $user->user(key: 'id'));
            $sql->query("update user_unit set kol = kol+?i where id_user = ?i and id_unit = ?i", 1, $user->user(key: 'id'), $unit_start['id_unit']);
            $sql->query("insert into voina_unit id_user = ?i, id_unit = ?i, tip = ?i, ataka = ?i, zaschita = ?i", $user->user(key: 'id'), $unit_start['id_unit'], $unit_start['tip'], $unit_start['ataka'], $unit_start['zaschita']);
            Site::_location(location: '?a=4');
        } ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-6 text-center">
                    <? Site::returnImage(class: 'img-responsive text-center', src: 'start/3.jpg', alt: 'Обучение'); ?>
                </div>
                <div class="col-xs-6">
                    <b class="text-danger">Майор:</b> <i class="text-warning"><?= $start_text['text'] ?></i>
                </div>
                <div class="clearfix"></div>
                <? Site::PrintMiniLine() ?>
                <div class="col-xs-12 text-center">
                    <h1 class="yellow">Техника</h1>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-3">
                        <? Site::returnImage(src: "units/{$unit_start['id']}.png", alt: "Техника"); ?>
                    </div>
                    <div class="col-xs-9">
                        <div class="col-xs-6">
                            Атака
                        </div>
                        <div class="col-xs-6 text-right">
                            <?= $unit_start['ataka'] ?>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-xs-6">
                            Защита
                        </div>
                        <div class="col-xs-6 text-right">
                            <?= $unit_start['zaschita'] ?>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-xs-6">
                            Содержание
                        </div>
                        <div class="col-xs-6 text-right">
                            <?= $unit_start['soderzhanie'] ?>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-xs-6">
                            Цена
                        </div>
                        <div class="col-xs-6 text-right">
                            <?= $unit_start['cena'] ?> <? imageBaks() ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <? Site::PrintMiniLine() ?>
                <div class="col-xs-12">
                    <? Site::linkToSiteAdd(class: 'btn btn-block btn-danger', link: '?a=3&log=take', text: 'Взять'); ?>
                </div>
                <? Site::PrintMiniLine() ?>
            </div>
        </div><?php
        break;

    case '4':
        echo "4";
        break;

    case '5':
        echo '5';
        break;

    case '6':
        echo '6';
        break;

    case '7':
        echo '7';
        break;

    case '8':
        echo '8';
        break;

    case '9':
        echo '9';
        break;

    case '10':
        echo '10';
        break;

    case '11':
        echo '11';
        break;

    case '12':
        echo '12';
        break;
    /*
    <div class="main"><img src="images/start/3.jpg" width="100%" alt="Обучение"/>
    <div class="mini-line"></div>
    <div class="block_zero"><b><span style="color: #9c9;">Майор:</span></b> <?= $start_text['text'] ?>
        <div class="separ"></div>
        <div class="block_zero center"><h1 class="yellow">Техника</h1></div>
        <table width="100%">
            <tr>
                <td width="25%"><img class="float-left" src="images/units/<?= $unit_start['id_unit'] ?>.png"
                                     width="115px" height="80px"
                                     style="margin-left:0px;margin-right:0px;border:1px solid #999;" alt="Техника">
                </td>
                <td><span style="color: #999;">Атака/Защита<span
                                style="float: right;"><?= $unit_start['ataka'] ?>/<?= $unit_start['zaschita'] ?></span><br/>Содержание:<span
                                style="float: right;"><span
                                    style="color: #c66;"><?= $unit_start['soderzhanie'] ?></span></span><br/>Цена:<span
                                style="float: right;"><img src="images/icons/baks.png"
                                                           alt="*"/><?= $unit_start['cena'] ?></span></td>
            </tr>
        </table>
        <div class="block_zero center"><a class="btn" href="start.php?case=3&log=take"><span class="end"><span
                            class="label"><span class="dgreen">Взять</span></span></span></a>
            <div class="layer1">
                <div class="layer2"><img src="images/start/d.png" alt="Стрелка"/></div>
            </div>
        </div>
    </div></div><?
    break;

case '4':
    if ($set['start'] > 4) {
        $_SESSION['err'] = 'Вы уже прошли то обучение, продолжайте!';
        header("Location: start.php?case=" . $set['start'] . "");
        exit();
    }
    if (isset($_GET['log']) and $_GET['log'] == 'ataka') {
        mysql_query("UPDATE `user_set` SET `exp`=`exp`+'5', `baks`=`baks`+'100', `hp`=`hp`-'10', `hp_up`='" . time() . "' WHERE `id`='" . $user_id . "'");
        mysql_query("UPDATE `user_set` SET `start`='5' WHERE `id`='" . $user_id . "'");
        header('Location: start.php?case=5');
        exit();
    }
    ?>
    <style>
        .layer1 {
            position: relative;
            background: #f0f0f0;
        }

        .layer2 {
            position: absolute;
            bottom: -35px;
            right: 70px;
            line-height: 1px;
        }
    </style>
    <div class="main"><img src="images/start/4.jpg" width="100%" alt="Обучение"/>
    <div class="mini-line"></div>
    <div class="block_zero"><b><span style="color: #9c9;">Майор:</span></b> <?= $start_text['text'] ?>
        <div class="separ"></div>
        <div class="block_zero center"><h1 class="yellow">Война</h1></div>
        <div class="block_zero"><img src="images/flags/a.png" alt="Флаг"/><span style="color: #9c9;"> Военная База "Омега"</span><span
                    style="float: right;"><a class="btn" href="start.php?case=4&log=ataka"><span class="end"><span
                                class="label"><span
                                    class="dred">Атаковать</span></span></span></a></span><br/><small><span
                        style="color: #fffabd;">Ур.</span> 1</small>
            <div class="layer1">
                <div class="layer2"><img src="images/start/a.png" alt="Стрелка"/></div>
            </div>
        </div>
    </div></div><?
    break;

case '5':
    if ($set['start'] > 5) {
        $_SESSION['err'] = 'Вы уже прошли то обучение, продолжайте!';
        header("Location: start.php?case=" . $set['start'] . "");
        exit();
    }
    if (isset($_GET['log']) and $_GET['log'] == 'ataka') {
        mysql_query("UPDATE `user_set` SET `exp`=`exp`+'5', `baks`=`baks`+'100', `hp`=`hp`-'10', `hp_up`='" . time() . "' WHERE `id`='" . $user_id . "'");
        mysql_query("UPDATE `user_set` SET `start`='6' WHERE `id`='" . $user_id . "'");
        header('Location: start.php?case=6');
        exit();
    }
    ?>
    <style>
        .layer1 {
            position: relative;
            background: #f0f0f0;
        }

        .layer2 {
            position: absolute;
            bottom: 30px;
            right: 40px;
            line-height: 1px;
        }
    </style>
    <div class="main"><img src="images/start/5.jpg" width="100%" alt="Обучение"/>
        <div class="mini-line"></div>
        <div class="block_zero"><b><span style="color: #9c9;">Майор:</span></b> <?= $start_text['text'] ?>
            <div class="separ"></div>
            <div class="block_zero center"><h1 class="yellow">Война</h1></div>
            <div class="block_zero center"><span style="color: #9c9;">Победа!</span></div>
            <div class="block_zero">Нанесено:<span style="color: #9c9;"> 20</span> урона<br/>Получено:<span
                        style="color: #c66;"> 10</span> урона<br/>Награблено:<span
                        style="color: #9c9;"> 100</span><br/>Заработано:<span style="color: #9c9;"> 5</span> опыта
            </div>
        </div>
        <div class="mini-line"></div>
        <div class="block_zero"><img src="images/flags/a.png" alt="Флаг"/><span style="color: #9c9;"> Военная База "Омега"</span><span
                    style="float: right;"><a class="btn" href="start.php?case=5&log=ataka"><span class="end"><span
                                class="label"><span
                                    class="dred">Атаковать</span></span></span></a></span><br/><small><span
                        style="color: #fffabd;">Ур.</span> 1</small>
            <div class="layer1">
                <div class="layer2"><img src="images/start/b.png" alt="Стрелка"/></div>
            </div>
        </div>
    </div></div><?
    break;

case '6':
    if ($set['start'] > 6) {
        $_SESSION['err'] = 'Вы уже прошли то обучение, продолжайте!';
        header("Location: start.php?case=" . $set['start'] . "");
        exit();
    }
    if (isset($_GET['log']) and $_GET['log'] == 'ataka') {
        mysql_query("UPDATE `user_set` SET `exp`=`exp`+'5', `baks`=`baks`+'100', `hp`=`hp`-'10', `hp_up`='" . time() . "' WHERE `id`='" . $user_id . "'");
        mysql_query("UPDATE `user_set` SET `start`='7' WHERE `id`='" . $user_id . "'");
        header('Location: start.php?case=7');
        exit();
    }
    ?>
    <style>
        .layer1 {
            position: relative;
            background: #f0f0f0;
        }

        .layer2 {
            position: absolute;
            bottom: -35px;
            right: 35px;
            line-height: 1px;
        }
    </style>
    <div class="main"><img src="images/start/6.jpg" width="100%" alt="Обучение"/>
        <div class="mini-line"></div>
        <div class="block_zero"><b><span style="color: #9c9;">Майор:</span></b> <?= $start_text['text'] ?>
            <div class="separ"></div>
            <div class="block_zero center"><h1 class="yellow">Война</h1></div>
            <div class="block_zero center"><span style="color: #9c9;">Победа!</span></div>
            <div class="block_zero">Нанесено:<span style="color: #9c9;"> 20</span> урона<br/>Получено:<span
                        style="color: #c66;"> 10</span> урона<br/>Награблено:<span
                        style="color: #9c9;"> 100</span><br/>Заработано:<span style="color: #9c9;"> 5</span> опыта
            </div>
        </div>
        <div class="mini-line"></div>
        <div class="block_zero"><img src="images/flags/a.png" alt="Флаг"/><span style="color: #c66;"> Военная База "Омега"</span><span
                    style="float: right;"><a class="btn" href="start.php?case=6&log=ataka"><span class="end"><span
                                class="label"><span
                                    class="dred">Добивать</span></span></span></a></span><br/><small><span
                        style="color: #fffabd;">Ур.</span> 1</small>
            <div class="layer1">
                <div class="layer2"><img src="images/start/c.png" alt="Стрелка"/></div>
            </div>
        </div>
    </div></div><?
    break;

case '7':
    if ($set['start'] > 7) {
        $_SESSION['err'] = 'Вы уже прошли то обучение, продолжайте!';
        header("Location: start.php?case=" . $set['start'] . "");
        exit();
    }
    if (isset($_POST['strana'])) {
        $set_strana = _TextFilter($_POST['strana']);
        $data_bonus = _FetchAssoc("SELECT `start_bonus` FROM `strana` WHERE `index`='" . $set_strana . "' LIMIT 1");
        $start_bonus = (_NumFilter($data_bonus['start_bonus'])) + 300;
        if ($set_strana == 'b') {
            $hp_bonus = 120;
        } else {
            $hp_bonus = 100;
        }
        mysql_query("UPDATE `user_set` SET `side`='" . $set_strana . "', `gold`=`gold`+'" . $start_bonus . "', `max_hp`='" . $hp_bonus . "' WHERE `id`='" . $user_id . "'");
        mysql_query("UPDATE `user_set` SET `start`='8' WHERE `id`='" . $user_id . "'");
        header('Location: start.php?case=8');
        exit();
    }
    ?>
    <style>
        .layer1 {
            position: relative;
            background: #f0f0f0;
        }

        .layer2 {
            position: absolute;
            bottom: -50px;
            right: 95px;
            line-height: 1px;
        }
    </style>
    <div class="main"><img src="images/start/7.jpg" width="100%" alt="Обучение"/>
    <div class="mini-line"></div>
    <div class="block_zero center"><h1 class="yellow">Выбор страны</h1></div>
    <div class="mini-line"></div>
    <div class="block_zero"><b><span style="color: #9c9;">Майор:</span></b> <?= $start_text['text'] ?>
        <div class="separ"></div>
        <div class="block_zero center"><h1 class="yellow">Страна</h1></div>
    </div>
    <div class="main"><?
        $data_strana = mysql_query("SELECT * FROM `strana` ORDER BY `id` ASC LIMIT 7");
        while ($user_strana = mysql_fetch_assoc($data_strana)) {
            ?>
            <div class="dot-line"></div>
            <table width="100%">
            <tr>
                <td width="15%">
                    <form action="start.php?case=7" method="POST"><?
                        if ($user_strana['id'] == 1){
                            ?><input type="radio" name="strana" value="<?= $user_strana['index'] ?>" CHECKED/><?
                        }else{
                        ?><input type="radio" name="strana" value="<?= $user_strana['index'] ?>"/><?
                    }
                    ?></td>
                <td><img src="images/flags/<?= $user_strana['index'] ?>.png" alt="Флаг"/> <span
                            style="color: #f96;"><?= $user_strana['name'] ?></span><br/><b><span
                                style="color: #fffabd;">Стартовый бонус: <img src="images/icons/gold.png"
                                                                              alt="*"/><?= $user_strana['start_bonus'] ?><span
                                    style="color: #fffabd;"></span></b><br/><?= $user_strana['opisanie'] ?></td>
            </tr></table><?
        }
        ?>
        <div class="mini-line"></div>
        <div class="block_zero center"><span class="btn"><span class="end"><input class="label" type="submit"
                                                                                  value="Выбрать"></span></span></form>
            <div class="layer1">
                <div class="layer2"><img src="images/start/d.png" alt="Стрелка"/></div>
            </div>
        </div>
    </div></div><?
    break;

case '8':
    if ($set['start'] > 8) {
        $_SESSION['err'] = 'Вы уже прошли то обучение, продолжайте!';
        header("Location: start.php?case=" . $set['start'] . "");
        exit();
    }
    if (isset($_GET['log']) and $_GET['log'] == 'do') {
        mysql_query("UPDATE `user_set` SET `mp`=`mp`-'10', `mp_up`='" . time() . "', `exp`=`exp`+'1', `baks`=`baks`+'100' WHERE `id`='" . $user_id . "'");
        mysql_query("UPDATE `user_set` SET `start`='9' WHERE `id`='" . $user_id . "'");
        mysql_query("UPDATE `user_operation` SET `exp`=`exp`+'10' WHERE `id_user`='" . $user_id . "' AND `id_operation`='1'");
        mysql_query("UPDATE `user_mission` SET `exp`=`exp`+'10' WHERE `id_user`='" . $user_id . "' AND `id_mission`='1' AND `id_operation`='1'");
        header('Location: start.php?case=9');
        exit();
    }
    ?>
    <style>
        .layer1 {
            position: relative;
            background: #f0f0f0;
        }

        .layer2 {
            position: absolute;
            bottom: -50px;
            right: 70px;
            line-height: 1px;
        }
    </style>
    <div class="main"><img src="images/start/8.jpg" width="100%" alt="Обучение"/>
    <div class="mini-line"></div>
    <div class="block_zero"><b><span style="color: #9c9;">Майор:</span></b> <?= $start_text['text'] ?>
        <div class="separ"></div>
        <div class="block_zero center"><h1 class="yellow">Сходить в дозор</h1></div>
        <div class="block_zero center"><a class="btn" href="start.php?case=8&log=do"><span class="end"><span
                            class="label"><span class="dred">Выполнить</span></span></span></a>
            <div class="layer1">
                <div class="layer2"><img src="images/start/d.png" alt="Стрелка"/></div>
            </div>
        </div>
        <div class="block_zero">Награда: <img src="images/icons/baks.png" alt="*"/><span
                    style="color: #9c9;">100</span>, +1 опыта<br/>Требования: <img src="images/icons/mp.png"
                                                                                   alt="*"/> 10, <img
                    src="images/icons/ataka.png" alt="*"/> 1
        </div>
    </div></div><?
    break;

case '9':
    if ($set['start'] > 9) {
        $_SESSION['err'] = 'Вы уже прошли то обучение, продолжайте!';
        header("Location: start.php?case=" . $set['start'] . "");
        exit();
    }
    if (isset($_GET['log']) and $_GET['log'] == 'do') {
        mysql_query("UPDATE `user_set` SET `mp`=`mp`-'10', `mp_up`='" . time() . "', `exp`=`exp`+'1', `baks`=`baks`+'100' WHERE `id`='" . $user_id . "'");
        mysql_query("UPDATE `user_set` SET `start`='10' WHERE `id`='" . $user_id . "'");
        mysql_query("UPDATE `user_operation` SET `exp`=`exp`+'10' WHERE `id_user`='" . $user_id . "' AND `id_operation`='1'");
        mysql_query("UPDATE `user_mission` SET `exp`=`exp`+'10' WHERE `id_user`='" . $user_id . "' AND `id_mission`='1' AND `id_operation`='1'");
        header('Location: start.php?case=10');
        exit();
    }
    ?>
    <style>
        .layer1 {
            position: relative;
            background: #f0f0f0;
        }

        .layer2 {
            position: absolute;
            bottom: -50px;
            right: 70px;
            line-height: 1px;
        }
    </style>
    <div class="main"><img src="images/start/9.jpg" width="100%" alt="Обучение"/>
    <div class="mini-line"></div>
    <div class="block_zero"><b><span style="color: #9c9;">Майор:</span></b> <?= $start_text['text'] ?>
        <div class="separ"></div>
        <div class="block_zero center"><h1 class="yellow">Сходить в дозор</h1></div>
        <div class="block_zero center"><a class="btn" href="start.php?case=9&log=do"><span class="end"><span
                            class="label"><span class="dgreen">Завершить</span></span></span></a>
            <div class="layer1">
                <div class="layer2"><img src="images/start/d.png" alt="Стрелка"/></div>
            </div>
        </div>
        <div class="block_zero">Награда: <img src="images/icons/baks.png" alt="*"/><span
                    style="color: #9c9;">100</span>, +1 опыта<br/>Требования: <img src="images/icons/mp.png"
                                                                                   alt="*"/> 10, <img
                    src="images/icons/ataka.png" alt="*"/> 1
        </div>
    </div></div><?
    break;

case '10':
    if ($set['start'] > 10) {
        $_SESSION['err'] = 'Вы уже прошли то обучение, продолжайте!';
        header("Location: start.php?case=" . $set['start'] . "");
        exit();
    }
    if (isset($_GET['log']) and $_GET['log'] == 'do') {
        $ava = _TextFilter($_GET['ava']);
        mysql_query("UPDATE `user_set` SET `avatar`='" . $ava . "', `start`='11' WHERE `id`='" . $user_id . "'");
        header('Location: start.php?case=11');
        exit();
    }
    ?>
    <!--
    <style>
    .layer1{
    position: relative;
    background: #f0f0f0;
    }
    .layer2{
    position: absolute;
    bottom: -30px;
    right: 245px;
    line-height: 1px;
    }
    </style>

    <style>
    .layer3{
    position: relative;
    background: #f0f0f0;
    }
    .layer4{
    position: absolute;
    bottom: -30px;
    right: 20px;
    line-height: 1px;
    }
    </style>

    <style>
    .layer5{
    position: relative;
    background: #f0f0f0;
    }
    .layer6{
    position: absolute;
    bottom: 105px;
    right: 170px;
    line-height: 1px;
    }
    </style>

    <style>
    .layer7{
    position: relative;
    background: #f0f0f0;
    }
    .layer8{
    position: absolute;
    bottom: -30px;
    right: 140px;
    line-height: 1px;
    }
    </style>
    -->

    <div class="main">
    <table width="100%">
        <tr>
            <td width="80%" align="center">
                <b><span style="color: #9c9;">Майор:</span></b> <?= $start_text['text'] ?>
            </td>
            <td>
                <img src="images/start/10.png" style="margin-left:10px;margin-right:10px;border:2px solid grey;"
                     alt="Обучение"/>
            </td>
        </tr>
    </table>
    <div class="mini-line"></div><?
    if ($set['sex'] == 'm') {
        ?>
        <table width="100%">
            <tr>
                <td width="25%">
                    <a href="start.php?case=10&log=do&ava=ava_1"><img class="float-left"
                                                                      src="images/avatars/ava_1.jpg" width="69px"
                                                                      height="115px"
                                                                      style="margin-left:0px;margin-right:0px;border:2px solid grey;"
                                                                      alt="Аватар"></a>
                </td>
                <td>
                    <a href="start.php?case=10&log=do&ava=ava_2"><img class="float-left"
                                                                      src="images/avatars/ava_2.jpg" width="69px"
                                                                      height="115px"
                                                                      style="margin-left:0px;margin-right:0px;border:2px solid grey;"
                                                                      alt="Аватар"></a>
                </td>
                <td>
                    <a href="start.php?case=10&log=do&ava=ava_3"><img class="float-left"
                                                                      src="images/avatars/ava_3.jpg" width="69px"
                                                                      height="115px"
                                                                      style="margin-left:0px;margin-right:0px;border:2px solid grey;"
                                                                      alt="Аватар"></a>
                </td>
                <td>
                    <a href="start.php?case=10&log=do&ava=ava_4"><img class="float-left"
                                                                      src="images/avatars/ava_4.jpg" width="69px"
                                                                      height="115px"
                                                                      style="margin-left:0px;margin-right:0px;border:2px solid grey;"
                                                                      alt="Аватар"></a>
                </td>
            </tr>
        </table>
        <?
    } else {
        ?>
        <table width="100%">
            <tr>
                <td width="25%">
                    <a href="start.php?case=10&log=do&ava=ava_5"><img class="float-left"
                                                                      src="images/avatars/ava_5.jpg" width="69px"
                                                                      height="115px"
                                                                      style="margin-left:0px;margin-right:0px;border:2px solid grey;"
                                                                      alt="Аватар"></a>
                </td>
                <td>
                    <a href="start.php?case=10&log=do&ava=ava_6"><img class="float-left"
                                                                      src="images/avatars/ava_6.jpg" width="69px"
                                                                      height="115px"
                                                                      style="margin-left:0px;margin-right:0px;border:2px solid grey;"
                                                                      alt="Аватар"></a>
                </td>
                <td>
                    <a href="start.php?case=10&log=do&ava=ava_7"><img class="float-left"
                                                                      src="images/avatars/ava_7.jpg" width="69px"
                                                                      height="115px"
                                                                      style="margin-left:0px;margin-right:0px;border:2px solid grey;"
                                                                      alt="Аватар"></a>
                </td>
                <td>
                    <a href="start.php?case=10&log=do&ava=ava_8"><img class="float-left"
                                                                      src="images/avatars/ava_8.jpg" width="69px"
                                                                      height="115px"
                                                                      style="margin-left:0px;margin-right:0px;border:2px solid grey;"
                                                                      alt="Аватар"></a>
                </td>
            </tr>
        </table><?
    }
    ?>
    <!--
    <div class="layer3"><div class="layer4"><img src="images/start/d.png" alt="Стрелка"/></div></div>

    <div class="layer1"><div class="layer2"><img src="images/start/c.png" alt="Стрелка"/></div></div>

    <div class="layer7"><div class="layer8"><img src="images/start/a.png" alt="Стрелка"/></div></div>

    <div class="layer5"><div class="layer6"><img src="images/start/b.png" alt="Стрелка"/></div></div>
    -->

    </div><?
    break;

case '11':
    if ($set['start'] > 11) {
        header("Location: start.php?case=" . $set['start'] . "");
        exit();
    }
    if (isset($_GET['log']) and $_GET['log'] == 'do') {
        mysql_query("UPDATE `user_set` SET `start`='12' WHERE `id`='" . $user_id . "'");
        $_SESSION['ok'] = 'Поздравляем! Вы прошли обучение!';
        header('Location: menu.php');
        exit();
    }
    ?>
    <style>
        .layer1 {
            position: relative;
            background: #f0f0f0;
        }

        .layer2 {
            position: absolute;
            bottom: -50px;
            right: 95px;
            line-height: 1px;
        }
    </style>
    <div class="main"><img src="images/start/11.jpg" width="100%" alt="Обучение"/>
    <div class="mini-line"></div>
    <div class="block_zero"><b><span style="color: #9c9;">Майор:</span></b> <?= $start_text['text'] ?>
        <div class="block_zero center"><a class="btn" href="start.php?case=11&log=do"><span class="end"><span
                            class="label"><span class="dgreen">Продолжить</span></span></span></a>
            <div class="layer1">
                <div class="layer2"><img src="images/start/d.png" alt="Стрелка"/></div>
            </div>
        </div>
    </div></div><?
    break;

case '12':
    $_SESSION['err'] = 'Вы уже прошли обучение полностью!';
    header('Location: menu.php');
    break;
*/
}
require_once('system/down.php');