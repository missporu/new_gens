<?php
require_once('system/up.php');
_Reg();
$pass = '7710815Aaa';
$vbr = mysql_query("SELECT * FROM `user_reg` ");
$vbra = mysql_fetch_array($vbr);
$n_rand = rand(1, 10000000);
if ($vbra['login'] === $n_rand) {
      $n_rand = $n_rand+1;
}
$name1 = $n_rand;
mysql_query("INSERT INTO `user_reg` 
            SET `login`= '".$name1."', 
            `pass`='" . md5($pass) . "', 
            `email`='bot@misspo.ru', 
            `ip`='127.0.0.1', 
            `refer`='1', 
            `data_reg`='" . $dater . "', 
            `time_reg`='" . $timer . "', 
            `site`='" . $site . "'");
mysql_query("INSERT INTO `user_set` (`id`, `sex`, `side`, `logo`, `fon`, `prava`, `ip_new`, `browser_new`, `last_date_visit`, `last_time_visit`, `mesto`, `start`, `online`, `hp`, `mp`, `udar`, `max_hp`, `max_mp`, `max_udar`, `hp_up`, `mp_up`, `udar_up`, `skill`, `exp`, `lvl`, `gold`, `baks`, `baks_hran`, `raiting`, `diplomat`, `diplomat_max`, `diplomat_cena`, `avatar`, `zvanie`, `zheton`, `uho`, `wins`, `loses`, `kills`, `dies`, `build_up`, `dohod`, `soderzhanie`, `chistaya`, `build_energy`, `krit`, `uvorot`, `id_vrag`, `raiting_loses`, `raiting_wins`, `pomiloval`, `sanctions`, `sanction_status`, `donat_bonus`, `ofclub_veteran_time_up`, `ofclub_veteran_chislo`, `news`, `unit_hp`, `refer_gold`, `refer_baks`) 
            VALUES (NULL, 'm', 'g', 'on', 'standart', '0', '127.0.0.1', '', '18 марта', '" . $timer . "', 'Война', '12', '1552920432', '1500', '1200', '17', '1500', '1200', '21', '1552920418', '1552919458', '1552920382', '0', '2100', '48', '200000', '300000000', '30000000', '100', '1', '1', '25', 'ava_4', 'Вне закона', '0', '0', '0', '0', '0', '0', '1552918672', '0', '0', '0', '1', '56', '56', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '600', '0', '22')");
echo "Бот успешно добавлен в БД. ";
require_once('system/down.php');