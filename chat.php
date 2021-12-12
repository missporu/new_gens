<?php
$title = 'Чат';
require_once 'system/up.php';

$user = new RegUser();
$site = new Site();
$sql = new SafeMySQL();
$admin = new Admin();

$user->_Reg();

try {
    if($user->getBlock() and $admin->setAdmin(admin: 1983)->returnAdmin() == false) {
        throw new Exception(message: 'Вы заблокированы администрацией проекта!');
    }

    $site->setSwitch(get: 'a');

    switch ($site->switch) {

        default:
            if (isset($_POST['enter'])) {
                $text = Filter::clearFullSpecialChars($_POST['text']);
                if (strlen(string: trim(string: $text)) < 1 || trim(string: $text) == "") {
                    Site::session_empty(type: 'error', text: "Заполните поле текст", location: "chat");
                }
                $sql->query("insert into chat set id_user = ?i, user = ?s, komu = ?s, privat = ?i, text = ?s, time = ?s, date = ?s, tip = ?i", $user->user(key: 'id'), $user->user(key: 'login'), "", 0, $text, Times::setTime(), Times::setDate(), 1);
                Site::session_empty(type: 'ok', text: 'Отправлено', location: 'chat');
            } else { ?>
                <div class="container">
                <div class="row">
                    <div class="col-xs-12"><?
                        if ($user->getBan()) { ?>
                            <form action="?" method="post">
                                <textarea class="col-xs-12" style="background-color: #fff !important; background-image: none; min-height: 17vh;" type="text" name="text" minlength = "1" placeholder="" required ></textarea><?
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
                        $count = $sql->getOne("select count(id) from chat where status = ?i and privat = ?i and tip = ?i", 1, 0, 1);
                        $site->pagin1($count);
                        $chat = $sql->getAll("select * from chat where status = ?i and privat = ?i and tip = ?i order by id desc limit ?i, ?i", 1, 0, 1, $site->fromPagin, 10);
                        foreach ($chat as $ci) { ?>
                            <div class="col-xs-3">
                                <?= $ci['date'] ?>  <?= $ci['time'] ?>
                            </div>
                            <div class="col-xs-9">
                            <a href="view.php?user=<?= $ci['user'] ?>"><strong class="text-danger"><?= $ci['user'] ?> :</strong></a> <?= $ci['text'] ?><?
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

        case 'otvet':
            echo 'otvet';
            break;

        case 'delete':
            if ($user->user(key: 'prava') < 3) {
                Site::session_empty(type: 'error', text: 'Ошибка!', location: 'chat');
            }
            $idDelete = Filter::clearInt($_GET['id']);
            if (!is_numeric($idDelete)) {
                Site::session_empty('error', 'Ошибка!', 'chat');
            }
            $chatDelete = $sql->getRow("select * from chat where id = ?i limit ?i", $idDelete, 1);
            if ($chatDelete['tip'] != 1) {
                Site::session_empty('error', 'Это сообщение уже удалено', 'chat');
            }
            $sql->query("update chat set tip = ?i where id = ?i", $user->user('prava'), $idDelete);
            Site::session_empty('ok', 'Удалено!', 'chat');
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