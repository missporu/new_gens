<?php

/*
 * Copyright (c) 2022.
 * Autor: misspo
 * Site: misspo.ru
 * Phone: +7 (919) 48-10-550
 * E-mail: misspo.ru@gmail.com
 */

$title = 'Постройки';
require_once __DIR__ . "/system/up.php";
$user = new RegUser();
$user->_Reg();

$sql = new SafeMySQL();
$site = new Site();
$page = new Page();
$page->setTitle($title);

try {
    if($user->getBlock()) {
        throw new Exception(message: 'Вы заблокированы администрацией проекта!');
    }
    $site->setSwitch(get: 'a'); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="text-center"><?= $page->getTitle() ?></h2>
            </div><?php
            Site::PrintMiniLine();

            switch ($site->switch) {
                /**
                 * Главная
                 */
                default:

                    $my_build = $sql->getOne("select count(id) from build_user where id_user = ?i", $user->user(key: 'id'));
                    $stroy = $sql->getOne("select count(time_stroy) from build_user where id_user = ?i and time_stroy > ?i", $user->user(key: 'id'), time());
                    $bitton_text = "Улучшить";
                    $class = "btn btn-block btn-danger";
                    if ($stroy > 0) {
                        $bitton_text = "Идет стройка...";
                        $class = "btn btn-block btn-danger disabled";
                    }
                    if ($my_build > 0) {
                        $my_build = $sql->getAll("select * from build_user where id_user = ?i", $user->user('id'));
                        foreach ($my_build as $b) { ?>
                            <div class="col-xs-4 text-center">
                                <strong class="red"><?= $b['name'] ?></strong><br><?
                                if ($b['bonus'] > 0) { ?>
                                    bonus: <?= $b['bonus'] ?><br><?php
                                }
                                if ($b['time_stroy'] > time()) { ?>
                                    <strong class="red">Строится <?= $b['lvl'] ?> ур.</strong><br><?php
                                    echo "(" . Times::timeHours(time: $b['time_stroy'] - time()) . ")";
                                } else { ?>
                                    <strong class="red">Ур.: <?= $b['lvl'] ?></strong><br><?php
                                } ?>
                            </div>
                            <div class="col-xs-4">
                                <strong class="silver">Серебро: <?= $b['serebro'] ?></strong><br>
                                <strong class="neft">Нефть: <?= $b['neft'] ?></strong><br>
                                <strong class="gaz">Газ: <?= $b['gaz'] ?></strong><br>
                                <strong class="yellow">Энергия: <?= $b['energy'] ?></strong><br>
                            </div>
                            <div class="col-xs-4 text-center"><?php
                            Site::linkToSiteSwitch(class: $class, link: "?a=up&id={$b['id']}", text: $bitton_text); ?>
                            </div><?php
                            Site::PrintMiniLine();
                        }
                        Site::linkToSiteSwitch(class: 'btn btn-block btn-dark', link: '?a=stroy', text: 'Построить');
                    } else {
                        Site::linkToSiteSwitch(class: 'btn btn-block btn-dark', link: '?a=stroy', text: 'Построить');
                    }
                    break;


                /**
                 * Улучшения
                 */
                case 'up':

                    break;

                case 'stroy': ?>
                    <div class="col-xs-12"><?php
                        $ee = $sql->query("select * from build where tip = ?i", 1);

                        $stroy = $sql->getOne("select count(time_stroy) from build_user where id_user = ?i and time_stroy > ?i", $user->user(key: 'id'), time());
                        $bitton_text = "Построить";
                        $class = "btn btn-block btn-danger";
                        if ($stroy > 0) {
                            $bitton_text = "Идет стройка...";
                            $class = "btn btn-block btn-danger disabled";
                        }

                        while ($w = $sql->fetch($ee)) {
                            $ss = $sql->getRow("select * from build_user where id_user = ?i and id_build = ?i", $user->user(key: 'id'), $w['id']);
                            if (!is_array($ss)) { ?>
                                <div class="col-xs-4 text-center">
                                    <strong class="red"><?= $w['name'] ?></strong><br><?
                                    if ($w['bonus'] > 0) { ?>
                                        Бонус: <?= $w['bonus'] ?><br><?php
                                    } ?>
                                </div>
                                <div class="col-xs-4">
                                    <strong class="silver">Серебро: <?= $w['serebro'] ?></strong><br>
                                    <strong class="neft">Нефть: <?= $w['neft'] ?></strong><br>
                                    <strong class="gaz">Газ: <?= $w['gaz'] ?></strong><br>
                                    <strong class="yellow">Энергия: <?= $w['energy'] ?></strong><br>
                                </div>
                                <div class="col-xs-4 text-center">
                                <? Site::linkToSiteSwitch(class: $class, link: "?a=build&id={$w['id']}", text: $bitton_text); ?>
                                </div><?php
                                Site::PrintMiniLine();
                            }
                        } ?>
                    </div><?php
                    break;


                /**
                 * Стройка
                 */
                case 'build':
                    $id = Filter::clearInt($_GET['id']);
                    $build = $sql->getRow("select * from build where id = ?i limit ?i", $id, 1);

                    if ($build) {
                        $my_build = $sql->getRow("select * from build_user where id_build = ?i and id_user = ?i limit ?i", $build['id'], $user->user('id'), 1);
                        if ($my_build) {
                            Site::session_empty(text: 'Это здание уже построено!');
                        }
                        $sql->query("insert into build_user set id_build = ?i, id_user = ?i, name = ?s, tip = ?i, lvl = ?i, time_up = ?i, bonus = ?i, serebro = ?i, neft = ?i, gaz = ?i, energy = ?i, ku = ?i, time_stroy = ?i", $build['id'], $user->user('id'), $build['name'], $build['tip'], 1, $build['time_up'], $build['bonus'], $build['serebro'], $build['neft'], $build['gaz'], $build['energy'], $build['ku'], time()+$build['time_up']);
                        Site::session_empty('ok', 'Вы начали стройку!', '?');
                    } else {
                        Site::session_empty('error', 'Нет такого здания!', '?');
                    }
                    break;
            } ?>
        </>
    </div><?php
} catch (Exception $e) { ?>
    <div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <h3 class="red">
                <?= $e->getMessage() ?>
            </h3>
            <p class="green">
                До автоматической разблокировки осталось <?= Times::timeHours(time: $user->user(key: 'block_time') - time()) ?>
            </p>
        </div>
    </div>
    </div><?php
}
require_once __DIR__ . "/system/down.php";
/**
<?php
$title = 'Постройки';
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
?><img src="images/logotips/build.jpg" width="100%" alt="Постройки"/><div class="mini-line"></div><?
        }
?><div class="menuList"><li><a href="build.php?case=pokupka&tip=1"><img src="images/icons/arrow.png" alt="*"/>Доходные</a></li><li><a href="build.php?case=pokupka&tip=2"><img src="images/icons/arrow.png" alt="*"/>Защитные</a></li><li><a href="build.php?case=pokupka&tip=3"><img src="images/icons/arrow.png" alt="*"/>Энергитические</a></li></div><div class="mini-line"></div><ul class="hint"><li>Стоимость каждой следующей постройки одного вида после покупки увеличивается от изначальной ее стоимости на 10%.</li><li>С достижением новых уровней открывается новая постройка, доступная к строительству.</li><li>Постройки невозможно уничтожить или удалить.</li><li>В игре нет возможности строить более одной энергетической постройки одного вида.</li></ul></div></div></div><?
        break;
 *
 *
    case 'pokupka':
        $tip = _NumFilter($_GET['tip']);
        if ($tip < 1 OR $tip > 3) {
            $_SESSION['err'] = 'Нет построек такого типа';
            header('Location: build.php');
            exit();
        }
        if (isset($_POST['send'])) {
            $kol      = _NumFilter($_POST['kol']);
            if($kol == 0) {
                $_SESSION['err'] = 'Не введено колличество';
              header('Location: build.php?case=pokupka&tip='.$tip.'');
              exit();
                }
            $id_build = _NumFilter($_GET['build']);
            for ($i = 1; $i <= $kol; $i++) {
                $data_pokupka = _FetchAssoc("SELECT * FROM `user_build` WHERE `id_user`='" . $user_id . "' AND `id_build`='" . $id_build . "' LIMIT 1");
                $user         = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $user_id . "' LIMIT 1");
                if ($user['baks'] < $data_pokupka['cena']) {
                    mysql_query("UPDATE `user_set` SET `build_up`='" . time() . "' WHERE `id`='" . $user_id . "' AND `build_up`='1' LIMIT 1");
                    $_SESSION['err'] = 'Не хватает баксов,<br/>построено ' . ($i - 1) . ' ед.';
                    header('Location: build.php?case=pokupka&tip=' . $data_pokupka['tip'] . '');
                    exit();
                }
                if ($data_pokupka['tip'] == 1 OR $data_pokupka['tip'] == 2 OR ($data_pokupka['tip'] == 3 AND $data_pokupka['kol'] != 1)) {
                mysql_query("UPDATE `user_build` SET `kol`=`kol`+'1' WHERE `id_user`='" . $user_id . "' AND `id_build`='" . $id_build . "' LIMIT 1");
                mysql_query("UPDATE `user_set` SET `baks`=`baks`-'" . $data_pokupka['cena'] . "' WHERE `id`='" . $user_id . "' LIMIT 1");
                }
                if($data_pokupka['tip'] != 3) {
                    if ($data_pokupka['lvl'] == 0) {
                        $data_pokupka['lvl'] = 1;
                    }
                    $gen123 = mysql_query("SELECT * FROM `build` WHERE `id` = '".$id_build."' ");
                    $cennik = mysql_fetch_array($gen123);
                $cena = ($cennik['cena']) * ($data_pokupka['kol']) * 1.1;
                mysql_query("UPDATE `user_build` SET `cena`='" . $cena . "' WHERE `id_user`='" . $user_id . "' AND `id_build`='" . $id_build . "' LIMIT 1");
                }
                if ($data_pokupka['tip'] == 1) {
                    mysql_query("UPDATE `user_set` SET `dohod`=`dohod`+'" . $data_pokupka['bonus'] . "', `chistaya`=`chistaya`+'" . $data_pokupka['bonus'] . "' WHERE `id`='" . $user_id . "' LIMIT 1");
                } elseif ($data_pokupka['tip'] == 2) {
                    mysql_query("UPDATE `user_set` SET `build_zaschita`=`build_zaschita`+'" . $data_pokupka['bonus'] . "' WHERE `id`='" . $user_id . "' LIMIT 1");
                } elseif ($data_pokupka['tip'] == 3 AND $data_pokupka['kol'] != 1) {
                    mysql_query("UPDATE `user_set` SET `build_energy`=`build_energy`+'" . $data_pokupka['bonus'] . "' WHERE `id`='" . $user_id . "' LIMIT 1");
                } elseif ($data_pokupka['tip'] == 3 AND $data_pokupka['kol'] == 1) {
                    $_SESSION['err'] = 'Нельзя строить больше<br/>одной энергетической постройки';
                    header('Location: build.php?case=pokupka&tip=' . $data_pokupka['tip'] . '');
                    exit();
                } else {
                    $_SESSION['err'] = 'Нет построек такого типа';
                    header('Location: build.php');
                    exit();
                }
            }
            if ($data_pokupka['tip'] == 1) {
                mysql_query("UPDATE `user_set` SET `build_up`='" . time() . "' WHERE `id`='" . $user_id . "' AND `build_up`='1' LIMIT 1");
            }
            $_SESSION['ok'] = 'Постройка успешно завершена,<br/>построено ' . ($i - 1) . ' ед.';
            header('Location: build.php?case=pokupka&tip=' . $data_pokupka['tip'] . '');
            exit();
        } ?>
        <div class="main"><div class="block_zero"><span style="color: #999;"><small><?php
        if ($tip == 1) { ?>
            Стройте больше этих построек, чтобы повысить Вашу прибыль и покрывать расходы на технику.
            </div>
            <div class="dot-line"></div>
            <div class="block_zero">
                <span style="color: #999;">
                    Доход: <span style="float: right;"> <?= number_format_short($set['dohod']) ?></span><br/>
                    Содержание: <span style="float: right;"> <?= $set['soderzhanie'] ?></span><br/>
                    Чистая прибыль: <span style="float: right;"> <?= number_format_short($set['chistaya']) ?></span><br/><?php
                    $time = ($set['build_up'] + 3600) - time(); ?>
                    <span style="color: #999;">
                        Выплата через:<span style="float: right;"><?= _Time($time) ?>
                    </span>
                </span>
            </span><?php
        } elseif ($tip == 2) {
?>Стройте больше этих построек, чтобы повысить Вашу защиту на Войне.</div><div class="dot-line"></div><div class="block_zero"><span style="color: #999;">Защита построек:<span style="float: right;">+ <?= $PZ ?></span></span><?
        } else {
?>Стройте больше этих построек, чтобы ускорить восстановление энергии.</div><div class="dot-line"></div><div class="block_zero"><span style="color: #999;">Энергия:<span style="float: right;">+ <?= $set['build_energy'] ?></span></span><?
        }
?></small></span></div><?
        $data_build = mysql_query("SELECT * FROM `user_build` WHERE `id_user` = '" . $user_id . "' AND `tip`='" . $tip . "' ORDER BY `id_build`");
        while ($user_build = mysql_fetch_assoc($data_build)) {
?><div class="mini-line"></div><div class="block_zero"><span style="color: #999;"><?= $user_build['name'] ?> - <?= $user_build['kol'] ?></span></div><div class="dot-line"></div><table width="100%"><tr><td width="25%"><img class="float-left" src="images/buildings/<?= $user_build['id_build'] ?>.png" width="130px" height="70px" style="margin-left:0px;margin-right:0px;border:1px solid grey;" alt="Постройка"></td><td><span style="color: #999;">Цена:<span style="float: right;"><?= number_format_short($user_build['cena']) ?></span><br/><?
            if ($tip == 1) {
?>Доход:<span style="float: right;"><?= number_format_short($user_build['bonus']) ?></span><br/><?
            } elseif ($tip == 2) {
?>Защита:<span style="float: right;">+ <?= number_format_short($user_build['bonus']) ?></span><br/><?
            } else {
?>Энергия:<span style="float: right;">+ <?= number_format_short($user_build['bonus']) ?></span><br/><?
            }
            if ($tip == 3 AND $user_build['kol'] == 1) {
?>Можно строить: 1<?
            } else {
?><form action="build.php?case=pokupka&build=<?= $user_build['id_build'] ?>&tip=<?= $user_build['tip'] ?>" method="POST">Количество:<span style="float: right;"><input class="text" type="text" value="1" size="3" maxlength="3" name="kol"></span><span class="btn"><span class="end"><input class="label" name="send" type="submit" value="Построить"/></span></span></form><?
            }
            ?></span></td></tr></table><?
        }
        $user_build = _FetchAssoc("SELECT * FROM `user_build` WHERE `tip`='" . $tip . "' AND `id_user` = '" . $user_id . "' ORDER BY `id_build` DESC LIMIT 1");
        $next_build = _FetchAssoc("SELECT * FROM `build` WHERE `tip`='" . $tip . "' AND `id` = '" ._NumFilter($user_build['id_build'] + 1) . "' LIMIT 1");
        if($next_build) {
?><div class="mini-line"></div><div class="block_zero center"><div class="block_dashed center"><?=$next_build['name']?><br/><img src="images/buildings/0.png" alt="*"/><br/><b><span style="color: #ff3434;">Будет доступно на <?=$next_build['lvl']?> уровне</span></b><?
            }
?></div></div></div><?     
        break;
}
require_once('system/down.php');
*/