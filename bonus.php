<?php
$title = 'Ежедневный бонус';
require_once __DIR__ . "/system/up.php";
$user = new RegUser();
$user->_Reg();
$sql = new SafeMySQL();

try {
    try {
        if ($user->getBlock()) {
            throw new Exception(message: 'Вы заблокированы администрацией проекта!');
        }
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
    if($user->userBonus(value: 'time') < time() + 5) {
        $money = 100 * $user->userBonus(value: 'status_day');
        $exp = 10 * $user->userBonus(value: 'status_day');
        $day = $user->userBonus(value: 'status_day') + 1;
        if($day > 7) {
            $day = 1;
        }
        if(isset($_POST['bonus'])) {
            $user->addMoney(key: "baks", value: $money);
            if($user->userBonus(value: 'status_day') == 7) {
                $gold = 10;
                $user->addMoney(key: "gold", value: $gold);
            }
            $sql->query("update user_bonus set time = ?i, status_day = ?i, last_date = ?s where id_user = ?i limit ?i", (time()+(60*60*24)), $day, Times::setDate(), $user->user(key: 'id'), 1);
            Site::session_empty(type: 'ok', text: "Получена ежедневная награда!", location: 'menu');
        } else { ?>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        Сегодня ваш <?= $user->userBonus(value: 'status_day') ?> день!<br>
                        <form class="" action="" method="post">
                            <input type="submit" class="btn btn-block btn-danger" name="bonus" value="Получить бонус">
                        </form>
                    </div>
                </div>
            </div><?php
        }
    } else {
        $vvv = $user->userBonus(value: 'time') - time();
        $vvv = Times::timeHours(time: $vvv);
        throw new Exception(message: "До бонуса осталось {$vvv}");
    }
} catch (Exception $e) { ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center text-info">
                <p><?= $e->getMessage() ?></p>
                <p>Завтра <b class="text-warning"><?= $user->userBonus(value: 'status_day') ?>й</b> день бонуса! Не пропустите!</p>
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
                for ($i = 1; $i < 8; $i++) { ?>
                    <li>
                    <p class="green">
                        <?= 100 * $i ?> <i class="fa fa-usd" aria-hidden="true"></i>
                    </p><? /**
                    <p class="orange">
                        <?= 10 * $i ?> exp
                    </p><? */
                    if ($i == 7) { ?>
                        <p class="yellow">10 <i class="fa fa-money" aria-hidden="true"></i></p><?
                    } ?>
                    </li><?php
                } ?>
            </ol>
        </div>
    </div>
</div><?php
require_once __DIR__ . "/system/down.php";