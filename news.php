<?php
$title = 'Новости';
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
    $sql->query("update users set news = ?i where id = ?i limit ?i", 0, $user->user(key: 'id'), 1);
    $site->setSwitch(get: 'a'); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="text-center"><?= $page->getTitle() ?></h2>
            </div><?php
            Site::PrintMiniLine();
    switch ($site->switch) {
        default:
            $count = $sql->getOne("select count(id) from news where status = ?i", 1);
            if ($count > 0) {
                $site->pagin1($count);
                $news = $sql->getAll("select * from news where status = ?i order by id desc limit ?i, ?i", 1, $site->fromPagin, 10);
                foreach ($news as $n) {
                    $news_id = "?a=news&id={$n['id']}"; ?>
                    <div class="col-xs-12"><?php
                        Site::linkToSiteSwitch(class: 'btn btn-block btn-success',link: $news_id,text: $n['tema']);
                        Site::PrintMiniLine(); ?>
                    </div><?php
                }
                Site::navig3(page: $site->page, get: 'page', pages: $site->pages);
            } else { ?>
                <div class="col-xs-12">
                    <p class="text-center text-info">
                        Новостей нет
                    </p>
                </div><?php
            }
            break;

        case 'news':
            $id = Filter::clearInt($_GET['id']);
            $news = $sql->getRow("select * from news where id = ?i and status = ?i", $id, 1);
            if ($news) { ?>
                <div class="col-xs-12">
                    <?= $news['text'] ?>
                </div>
                <div class="col-xs-6 col-xs-offset-6"><?
                    if ($news['avtor'] == 3) $avtor = 'Модератор';
                    if ($news['avtor'] == 4) $avtor = 'Старший Модератор';
                    if ($news['avtor'] == 5) $avtor = 'Администратор';
                    if ($news['avtor'] == 1983) $avtor = 'Разработчик'; ?>
                    <p class="yellow">Автор новости: <strong><?= $avtor ?></strong></p>
                </div><?php
                Site::PrintMiniLine(); ?>
                <div class="col-xs-12"><?php
                    if (isset($_POST['enter'])) {
                        $komments = Filter::clearFullSpecialChars($_POST['komm']);
                        $sql->query("insert into news_komments set id_news = ?i, id_user = ?i, name_user = ?s, text = ?s, status = ?i, time_komm = ?s, date_komm = ?s", $id, $user->user(key: 'id'), $user->user(key: 'login'), $komments, 1, Times::setTime(), Times::setDate());
                        $location = "?a=news&id={$_GET['id']}";
                        Site::session_empty(type: 'ok', text: 'Комментарий добавлен!', location: $location);
                    } else { ?>
                        <div class="col-xs-12 text-center text-info">
                            <h3>
                                Комментарии:
                            </h3>
                        </div>
                        <? Site::PrintMiniLine() ?>
                        <form action="?a=news&id=<?= $id ?>" method="post">
                            <textarea class="col-xs-12" name="komm" required></textarea>
                            <? Site::PrintMiniLine(); ?>
                            <input class="btn btn-block btn-success" name="enter" type="submit" value="Комментировать">
                        </form><?php
                        Site::PrintMiniLine();
                        $count = $sql->getOne("select count(id) from news_komments where id_news = ?i and status = ?i", $id, 1);
                        if ($count > 0) {
                            $site->pagin1($count);
                            $news = $sql->getAll("select * from news_komments where id_news = ?i and status = ?i order by id desc limit ?i, ?i", $id, 1, $site->fromPagin, 10);
                            foreach ($news as $ne) { ?>
                                <div class="col-xs-4">
                                    <?= Site::linkToSiteAdd(link: "view?user={$ne['name_user']}", text: $ne['name_user']); ?><br>
                                    <?= $ne['time_komm'] ?><br>
                                    <?= $ne['date_komm'] ?>
                                </div>
                                <div class="col-xs-8">
                                    <?= $ne['text'] ?>
                                </div><?php
                                Site::PrintMiniLine();
                            }
                            Site::navig3(page: $site->page, get: 'page', pages: $site->pages);
                        } else { ?>
                            <div class="col-xs-12">
                                <p class="text-center text-danger">Комментариев нет</p>
                            </div><?php
                        }
                    } ?>
                </div><?php
            } else {
                Site::session_empty(type: 'error', text: 'Error 1');
            }
            break;
    } ?>
        </div>
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

require_once __DIR__ . '/system/down.php';