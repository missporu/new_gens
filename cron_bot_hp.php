<?php
require_once('system/sys.php');
$bot = mysql_query("SELECT * FROM `user_set` WHERE `ip`='127.0.0.1' ORDER BY `hp` DESC ");
$hp = mysql_fetch_assoc($bot);
$hpy=$hp['max_hp'];
$online=time()+360;
$text = 'Пришли свежие боты! Скорее в бой!';
$text2 = 'Напоминаю, что в этом чате максимум допустимо 1 сообщение на страницу. Давайте уважать друг друга и не будем флудить .зубы. Приятной игры.';
mysql_query("UPDATE `user_set` SET `hp`='".$hpy."', `baks`='300000000' WHERE `user_set`.`ip`='127.0.0.1'");
//mysql_query("INSERT INTO `chat` SET `id_user` = '3', `text` = '" . $text . "', `time` = '" . $timer . "', `date` = '" . $dater . "', `tip` = '1' ");
//mysql_query("INSERT INTO `chat2` SET `id_user` = '3', `text` = '" . $text . "', `time` = '" . $timer . "', `date` = '" . $dater . "', `tip` = '1' ");
//mysql_query("INSERT INTO `chat` SET `id_user` = '3', `text` = '" . $text2 . "', `time` = '" . $timer . "', `date` = '" . $dater . "', `tip` = '2' ");
//mysql_query("INSERT INTO `chat2` SET `id_user` = '3', `text` = '" . $text2 . "', `time` = '" . $timer . "', `date` = '" . $dater . "', `tip` = '2' ");
mysql_query("UPDATE `user_set` SET `online`='".$online."', `mesto`='Общение' WHERE `id`='3' ");