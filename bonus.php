<?php
$title = 'Ежедневный бонус';
require_once ('system/up.php');
$user->_Reg();

if($user->userBonus('time') < time()) {
    echo "1";
    echo $user->userBonus('id_user').$user->userBonus('status_day')."<br>";
    echo $user->user('login');
    //$site->session_err('Вы уже получали свой бонус', 'index.php');
} else {
    echo "2";
}
/*
if(date("d")-$data['day']==1 AND $data['month']==date("F") AND $data['year']==date("Y")){
mysql_query('UPDATE `user_bonus` SET `status_day`=`status_day`+"1", `status_bonus`="1",`day`="'.date("d").'", `month`="'.date("F").'", `year`="'.date("Y").'" WHERE `id_user`="'.$user_id.'" LIMIT 1');
}else{
mysql_query('UPDATE `user_bonus` SET `status_day`="1", `status_bonus`="1",`day`="'.date("d").'", `month`="'.date("F").'", `year`="'.date("Y").'" WHERE `id_user`="'.$user_id.'" LIMIT 1');
}

$bonus=_FetchAssoc('SELECT * FROM `user_bonus` WHERE `id_user`="'.$user_id.'" LIMIT 1');

$bonus_baks=$set['lvl']*10000*$bonus['status_day'];

$bonus_gold=mt_rand(10,100);

?><div class="main"><div class="block_zero center"><h1 class="yellow">День <?=$bonus['status_day']?>-й</h1></div><div class="mini-line"></div><div class="block_zero center"><?

if($bonus['status_day']<5){
?>Получен ежедневный бонус:<br/><br/><img src="/images/icons/gold.png" alt="Золото"/>1 золота<br/><br/><img src="/images/icons/baks.png" alt="Бакс"/><?=$bonus_baks?> баксов</div><div class="dot-line"></div><div class="block_zero center"><?
mysql_query('UPDATE `user_set` SET `gold`=`gold`+"1", `baks`=`baks`+"'.$bonus_baks.'" WHERE `id`="'.$user_id.'" LIMIT 1');
}else{
?>Получен ежедневный бонус:<br/><br/><img src="/images/icons/gold.png" alt="Золото"/><?=$bonus_gold?><br/><br/><img src="/images/icons/baks.png" alt="Бакс"/><?=$bonus_baks?></div><div class="dot-line"></div><div class="block_zero center"><?
mysql_query('UPDATE `user_set` SET `gold`=`gold`+"'.$bonus_gold.'", `baks`=`baks`+"'.$bonus_baks.'" WHERE `id`="'.$user_id.'" LIMIT 1');
mysql_query('UPDATE `user_bonus` SET `status_day`="0", `status_bonus`="1" WHERE `id_user`="'.$user_id.'" LIMIT 1');
}
?>Заходи каждый день и получай <img src="/images/icons/gold.png" alt="Золото"/>1 и <img src="/images/icons/baks.png" alt="Бакс"/><br/>А если заходить в игру 5 дней подряд, то получишь от <img src="/images/icons/gold.png" alt="Золото"/>10 до <img src="/images/icons/gold.png" alt="Золото"/>100 и <img src="/images/icons/baks.png" alt="Бакс"/></div><div class="mini-line"></div><div class="block_zero center"><a class="btn btn-outline-primary btn-block" href="bonus.php"><span class="end"><span class="label"><span class="dgreen">Забрать и продолжить</span></span></span></a></div></div><? */
require_once('system/down.php');