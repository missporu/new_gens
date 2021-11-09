<?php
$title = 'Новости';
require_once('system/up.php');
_Reg();
?><div class="main"><?
if ($set['logo'] == 'on') {
?><img src="images/logotips/news.jpg" width="100%" alt="Новости"/><div class="mini-line"></div><?
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
        $viso   = _NumRows("SELECT * FROM `news`");
        $puslap = floor($viso / 10);
        $past_news = _FetchAssoc("SELECT * FROM `news` ORDER BY `id` DESC LIMIT 1");
        $all_news  = mysql_query("SELECT * FROM `news` ORDER BY `id` DESC LIMIT $num, 10");
?><div class="menuList"><?
        while ($news = mysql_fetch_assoc($all_news)) {
            if ($set['news'] == 1 AND $past_news['id'] == $news['id']) {
?><li><b><a href="news.php?case=read&id=<?= $news['id'] ?>"><img src="images/icons/arrow.png" alt="*" /><?= $news['tema'] ?><span style="float: right;"><small><?= $news['data'] ?></small></span></a></b></li><?
            } else {
?><li><a href="news.php?case=read&id=<?= $news['id'] ?>"><img src="images/icons/arrow.png" alt="*" /><span style="color: #999;"><?= $news['tema'] ?><span style="float: right;"><small><?= $news['data'] ?></small></span></span></a></li><?
            }
        }
         echo'</div><div class="mini-line"></div>';
         echo '<div class="block_zero center">';
        if ($_GET['page'] > 0) {
            echo '<small><b><a href="news.php?page=' . $back . '"><< Назад </a></small></b>';
        }
        if (empty($_GET['page']) || $_GET['page'] == 0 || $_GET['page'] < $puslap) {
            echo '<small><b><a href="news.php?page=' . $next . '"> Вперёд >></a></small></b>';
        }
        break;
    case 'read':
        $id         = isset($_GET['id']) ? _NumFilter($_GET['id']) : NULL;
        $read_news  = _FetchAssoc("SELECT * FROM `news` WHERE `id`='" . $id . "' LIMIT 1");
        $avtor_news = _FetchAssoc("SELECT * FROM `user_reg` WHERE `id`='" . $read_news['avtor'] . "' LIMIT 1");
        mysql_query("UPDATE `user_set` SET `news`='0' WHERE `id`='" . $user_id . "'");        
        $text = nl2br($read_news['text']);
?><div class="menuList"><li><a href="news.php"><img src="images/icons/arrow.png" alt="*" />Новости</a></li></div><div class="mini-line"></div><div class="block_zero"><b><span style="color: #ffd555;"><?= $read_news['tema'] ?><span style="float: right;"><small><?= $read_news['data'] ?></small></span></span></b></div><div class="dot-line"><div class="block_zero"><small><span style="color: #999;">Автор:</span> <a href="view.php?smotr=<?= $avtor_news['id'] ?>"><?= $avtor_news['login'] ?></a><span style="float: right;"><span style="color: #999;">Добавлено в:</span> <span style="color: #9c9;"><?= $read_news['time'] ?></small></span></span></div><div class="mini-line"></div><div class="block_zero"><span style="color: #9cc;"><?= $text ?></span><?
        break;
}
?></div></div></div></div><?
require_once('system/down.php');
?>
