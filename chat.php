<?php
$title = 'Чат';
require_once 'system/up.php';

$user = new RegUser();
$user->_Reg();

$site = new Site();
$sql = new SafeMySQL();
$admin = new Admin();

try {
    if($user->getBlock() and $admin->setAdmin(admin: 1983)->returnAdmin() == false) {
        throw new Exception(message: 'Вы заблокированы администрацией проекта!');
    }

    $site->setSwitch(get: 'a');
    switch ($site->switch) {
        default:
            if (isset($_POST['enter'])) {
                $text = $_POST['text'];
                if (strlen(string: trim(string: $text)) < 1 || trim(string: $text) == "") {
                    Site::session_empty(type: 'error', text: "Заполните поле текст", location: "chat");
                }
                if ($user->user(key: 'prava') > 1) {
                    $dostup = $_POST['user'];
                    if ($dostup == "user") {
                        $dostup = Filter::clearFullSpecialChars($user->user(key: 'login'));
                        $prava = 0;
                    }
                    if ($dostup == "admin") {
                        $dostup = Filter::clearFullSpecialChars($admin->AdminPrint($user->user(key: 'prava')));
                        $prava = 1;
                    }
                } else {
                    $dostup = Filter::clearFullSpecialChars($user->user(key: 'login'));
                    $prava = 0;
                }
                $sql->query("insert into chat set id_user = ?i, user = ?s, komu = ?s, privat = ?i, text = ?s, time = ?s, date = ?s, tip = ?i, admin = ?i", $user->user(key: 'id'), $dostup, "", 0, $text, Times::setTime(), Times::setDate(), 1, $prava);
                Site::session_empty(type: 'ok', text: 'Отправлено', location: 'chat');
            } else { ?>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12"><?php
                            if ($user->getBan()) { ?>
                                <form action="?" method="post">
                                    <textarea class="col-xs-12" style="background-color: #fff !important; background-image: none; min-height: 17vh;" type="text" name="text" minlength = "1" placeholder="" required ></textarea><?
                                    Site::PrintMiniLine();
                                    if ($user->user(key: 'prava') > 1) { ?>
                                        <p class="text-center text-info">Написать как:</p>
                                        <select name="user" class="col-xs-12" >
                                            <option value="user"><?= $user->user(key: 'login') ?></option>
                                            <option value="admin"><?= $admin->AdminPrint($user->user(key: 'prava')) ?></option>
                                        </select>
                                        <? Site::PrintMiniLine();
                                    } ?>
                                    <input class="btn btn-block btn-success" type="submit" name="enter" value="Отправить">
                                </form><?php
                            } ?>
                        </div>
                    </div>
                </div><?php
                Site::lineHrInContainer(); ?>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12"><?php
                            $count = $sql->getOne("select count(id) from chat where status = ?i and privat = ?i and tip = ?i", 1, 0, 1);
                            if ($count > 0) {
                                $site->pagin1($count);
                                $chat = $sql->getAll("select * from chat where status = ?i and privat = ?i and tip = ?i order by id desc limit ?i, ?i", 1, 0, 1, $site->fromPagin, 10);
                                foreach ($chat as $ci) { ?>
                                    <div class="col-xs-3">
                                        <?= $ci['date'] ?>  <?= $ci['time'] ?>
                                    </div>
                                    <div class="col-xs-9">
                                        <a href="#<?= Filter::clearInt($ci['id']) ?>" data-toggle="modal"><strong class="text-danger"><?= $ci['user'] ?> :</strong></a><?= nl2br(Filter::output($ci['text'])) ?><?php
                                        if ($admin->setAdmin(admin: 1983)->returnAdmin()) { ?>
                                            <a href="?a=delete&id=<?= $ci['id'] ?>"><strong class="text-info">[del]</strong></a><?php
                                        } ?>
                                    </div><?php
                                    Site::PrintMiniLine(); ?>

                                    <div class="modal fade" id="<?= Filter::clearFullSpecialChars($ci['id']) ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><?php
                                                    if ($ci['admin'] == 1) { ?>
                                                        <h4 class="modal-title text-center">
                                                            Информация скрыта
                                                        </h4><?php
                                                    } else { ?>
                                                    <h4 class="modal-title text-center"><?= $ci['user'] ?></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                                        <span><?= $user->getRaiting($ci['id_user']) ?></span>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-xs-12"><?php
                                                        Site::linkToSiteAdd(class: 'btn btn-block btn-minidark', link: "view?user={$ci['user']}", text: 'Перейти'); ?><?
                                                    } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><?php
                                } ?>
                        </div>
                    </div>
                </div><?php
                                Site::navig3(page: $site->page, get: 'page', pages: $site->pages);
                            } else { ?>
                            <p class="text-center">
                                Сообщений нет
                            </p>
                        </div>
                    </div>
                </div><?php
                            }
            }
            break;

        case 'otvet':
            $komu = Filter::clearFullSpecialChars($_GET['user']);
            if (isset($_POST['enter'])) {
                $text = Filter::clearFullSpecialChars($_POST['text']);
                if (strlen(string: trim(string: $text)) < 1 || trim(string: $text) == "") {
                    Site::session_empty(type: 'error', text: "Заполните поле текст", location: "chat");
                }
                $sql->query("insert into chat set id_user = ?i, user = ?s, komu = ?s, privat = ?i, text = ?s, time = ?s, date = ?s, tip = ?i", $user->user(key: 'id'), $user->user(key: 'login'), $komu, 0, $text, Times::setTime(), Times::setDate(), 1);
                Site::session_empty(type: "ok", text: "Отправлено", location: "chat");
            } else { ?>
                <div class="container">
                <div class="row">
                    <div class="col-xs-12"><?
                        if ($user->getBan()) { ?>
                            <form action="?a=otvet&user=<?= $komu ?>" method="post">
                            <textarea class="col-xs-12" style="background-color: #fff !important; background-image: none; min-height: 17vh;" type="text" name="text" minlength = "1" placeholder="" required ><?= $komu ?>, </textarea><?
                            Site::PrintMiniLine(); ?>
                            <input class="btn btn-block btn-success" type="submit" name="enter" value="Отправить">
                            </form><?
                        } ?>
                    </div>
                </div>
                </div><?php
                Site::lineHrInContainer();
            }
            break;

        case 'delete':
            if ($user->user(key: 'prava') < 3) {
                Site::session_empty(type: 'error', text: 'Ошибка!', location: 'chat');
            }
            $idDelete = Filter::clearInt($_GET['id']);
            if (!is_numeric($idDelete)) {
                Site::session_empty(type: 'error', text: 'Ошибка!', location: 'chat');
            }
            $chatDelete = $sql->getRow("select * from chat where id = ?i limit ?i", $idDelete, 1);
            if ($chatDelete['tip'] != 1) {
                Site::session_empty(text: 'Это сообщение уже удалено', location: 'chat');
            }
            $sql->query("update chat set tip = ?i where id = ?i", $user->user(key: 'prava'), $idDelete);
            Site::session_empty(type: 'ok', text: 'Удалено!', location: 'chat');
            break;

        case 'privat':
            $komu = Filter::clearFullSpecialChars($_GET['user']);
            if (isset($_POST['enter'])) {
                $text = Filter::clearFullSpecialChars($_POST['text']);
                if (strlen(string: trim(string: $text)) < 1 || trim(string: $text) == "") {
                    Site::session_empty(type: 'error', text: "Заполните поле текст", location: "chat");
                }
                $sql->query("insert into chat set id_user = ?i, user = ?s, komu = ?s, privat = ?i, text = ?s, time = ?s, date = ?s, tip = ?i", $user->user(key: 'id'), $user->user(key: 'login'), $komu, 1, $text, Times::setTime(), Times::setDate(), 1);
                Site::session_empty(type: "ok", text: "Отправлено", location: "chat");
            } else { ?>
                <div class="container">
                <div class="row">
                    <div class="col-xs-12"><?
                        if ($user->getBan()) { ?>
                        <form action="?a=otvet&user=<?= $komu ?>" method="post">
                            <textarea class="col-xs-12" style="background-color: #fff !important; background-image: none; min-height: 17vh;" type="text" name="text" minlength = "1" placeholder="" required ><?= $komu ?>, </textarea><?
                            Site::PrintMiniLine(); ?>
                            <input class="btn btn-block btn-success" type="submit" name="enter" value="Отправить">
                            </form><?
                        } ?>
                    </div>
                </div>
                </div><?php
                Site::lineHrInContainer(); ?>
                <div class="container">
                <div class="row">
                    <div class="col-xs-12"><?
                        $count = $sql->getOne("select count(id) from chat where id_user = ?i and status = ?i and privat = ?i and tip = ?i", $user->user('id'), 1, 1, 1);
                        $site->pagin1($count);
                        $chat = $sql->getAll("select * from chat where id_user = ?i and status = ?i and privat = ?i and tip = ?i order by id desc limit ?i, ?i", $user->user(key: 'id'), 1, 1, 1, $site->fromPagin, 10);
                        foreach ($chat as $ci) { ?>
                            <div class="col-xs-3">
                                <?= $ci['date'] ?>  <?= $ci['time'] ?>
                            </div>
                            <div class="col-xs-9">
                            <a href="view.php?user=<?= $ci['user'] ?>"><strong class="text-danger"><?= $ci['user'] ?> :</strong></a> <?= nl2br(Filter::output($ci['text'])) ?><?
                            if ($admin->setAdmin(admin: 1983)->returnAdmin()) { ?>
                            <a href="?a=delete&id=<?= $ci['id'] ?>"><strong class="text-info">[del]</strong></a><?
                            } ?>
                            </div><?
                            Site::PrintMiniLine();
                        } ?>
                    </div>
                </div>
                </div><?php
                Site::navig3(page: $site->page, get: 'page', pages: $site->pages);
            }
            break;
    }
} catch (Throwable $e) { ?>
    <div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <h3 class="red">
                <?= $e->getMessage() ?>
            </h3><?
            if ($user->getBlock()) { ?>
                <p class="green">
                    До автоматической разблокировки осталось <?= Times::timeHours(time: $user->user(key: 'block_time') - time()) ?>
                </p><?
            } ?>
        </div>
    </div>
    </div><?php
}
require_once 'system/down.php';