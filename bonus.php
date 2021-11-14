<?php
$title = 'Ежедневный бонус';
require_once ('system/up.php');
$user->_Reg();
try {
    if($user->userBonus('time') < time()+5) {
        $money = 100 * $user->userBonus('status_day');
        $exp = 10 * $user->userBonus('status_day');
        $day = $user->userBonus('status_day') + 1;
        if($day > 7) {
            $day = 1;
        }
        if(isset($_POST['bonus'])) {
            $user->addMoney("baks", $money);
            $user->addMoney("exp", $exp);
            if($user->userBonus('status_day') == 7) {
                $gold = 10;
                $user->addMoney("gold", $gold);
            }
            $sql->query("update user_bonus set time = ?i, status_day = ?i, last_date = ?s where id_user = ?i limit ?i", (time()+(60*60*24)), $day, $site->getDate(), $user->user('id'), 1);
            $site->session_inf("Получена ежедневная награда!");
        } else { ?>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        Сегодня ваш <?= $user->userBonus('status_day') ?> день!<br>
                        <form class="" action="" method="post">
                            <input type="submit" class="btn btn-default" name="bonus" value="Получить бонус">
                        </form>
                    </div>
                </div>
            </div><?php
        }
    } else {
        $vvv = $user->userBonus('time') - time();
        $vvv = $times->timeHours($vvv);
        throw new Exception("До бонуса осталось {$vvv}<br>Завтра {$user->userBonus('status_day')} день бонуса! Не пропустите! ");
    }
} catch (Exception $e) { ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center text-info">
                <p><?= $e->getMessage() ?></p>
            </div>
        </div>
    </div><?php
} ?>
    <div class="container">
    <div class="row">
        <div class="clearfix"></div>
        <div class="separ"></div>
        <div class="col-xs-12">
            <ol>Расчет бонусов по дням<?
                for ($i = 1; $i < 8; $i++) {
                    if($i == 7) {
                        $golds = '<p>10 <img src="/images/icons/gold.png" alt="Золото"></p>';
                    } ?>
                    <li>
                    <p>
                        <?= 100 * $i ?> <img src="/images/icons/baks.png" alt="Бакс">
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
require_once('system/down.php');