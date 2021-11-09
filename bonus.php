<?php
$title = 'Ежедневный бонус';
require_once ('system/up.php');
$user->_Reg();

try {
    if($user->userBonus('time') < time()+5) {
        $money = 100 * $user->userBonus('status_day');
        $gold = 0;
        if ($user->userBonus('status_day') == 7) {
            $gold = 10;
        }
        $exp = 10 * $user->userBonus('status_day');
        $day = $user->userBonus('status_day') + 1;
        if($day > 7) {
            $day = 1;
        }
        if(isset($_POST['bonus'])) {

        } else { ?>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        Сегодня ваш <?= $user->userBonus('status_day') ?> день!<br>
                        <form class="" action="" method="post">
                            <input type="submit" class="btn btn-default" name="bonus" value="Получить бонус">
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <div class="separ"></div>
                    <div class="col-xs-12">
                        <ol>Расчет бонусов по дням<?
                            for ($i = 1; $i < 8; $i++) {
                                if($i == 7) {
                                    $golds = "<p>10 Gold</p>";
                                } ?>
                                <li>
                                    <p>
                                        <?= 100 * $i ?> $
                                    </p>
                                    <p>
                                        <?= 10 * $i ?> exp
                                    </p>
                                    <?= $golds ?>
                                </li><?
                            } ?>
                        </ol>
                    </div>
                </div>
            </div><?php
        }
    } else {
        $vvv = $user->userBonus('time') - time();
        $vvv = $times->timeHours($vvv);
        throw new Exception("До бонуса осталось {$vvv} ");
    }
} catch (Exception $e) { ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center text-info">
                <p><?= $e->getMessage() ?></p>
            </div>
        </div>
    </div><?php
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