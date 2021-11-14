<?php
$title='Главная';
require_once ('system/up.php');
$user->_Reg();
$admin1983 = new Admin('1983');
$admin5 = new Admin('5');
try {
    if($user->getBlock()) {
        throw new Exception('Вы заблокированы администрацией проекта!');
    }
    switch ($_GET['a']) {
        default: ?>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <? $site->PrintMiniLine() ?>
                        <h5 class="text-info text-center">
                            Сражения
                        </h5>
                        <? $site->PrintMiniLine() ?>
                        <div class="col-xs-12">
                            <a class="miss-block" href="voina.php">
                                <span>Война</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>


                    <? /*
                    <div class="col-xs-6">
                        <a class="button btn-success btn-block" href="voina.php?case=vrag">
                            <h3>Война</h3>
                        </a>
                    </div>
                    <div class="col-xs-6">
                        <a class="button btn-success btn-block" href="#">
                            <h3>В разработке</h3>
                        </a>
                    </div>

                    <? $site->PrintMiniLine() ?>
                    <div class="col-xs-6">
                        <a class="button btn-success btn-block" href="mission.php">
                            <h3>Миссии</h3>
                        </a>
                    </div>
                    <div class="col-xs-6">
                        <a class="button btn-success btn-block" href="production.php">
                            <h3>Производство</h3>
                        </a>
                    </div>

                    <? $site->PrintMiniLine() ?>
                    <div class="col-xs-6">
                        <a class="button btn-default btn-block" href="unit.php">
                            <h3>Техника</h3>
                        </a>
                    </div>
                    <div class="col-xs-6">
                        <a class="button btn-default btn-block" href="build.php">
                            <h3>Постройки</h3>
                        </a>
                    </div>

                    <? $site->PrintMiniLine() ?>
                    <div class="col-xs-6">
                        <a class="button btn-default btn-block" href="blackmarket.php">
                            <h3>Черный рынок</h3>
                        </a>
                    </div>
                    <div class="col-xs-6">
                        <a class="button btn-default btn-block" href="ofclub.php">
                            <h3>Клуб офицеров</h3>
                        </a>
                    </div>
                </div>
            </div>
            <?php $site->lineHrInContainer() ?>
            <div class="container text-center">
                <div class="row">
                    <div class="col-xs-6">
                        <a class="button btn-default btn-block" href="pers.php">
                            <h3>Профиль</h3>
                        </a>
                    </div>
                    <div class="col-xs-6">
                        <a class="button btn-default btn-block" href="raiting.php">
                            <h3>Рейтинг</h3>
                        </a>
                    </div>

                    <? $site->PrintMiniLine() ?>
                    <div class="col-xs-6">
                        <a class="button btn-default btn-block" href="alliance.php">
                            <h3>Альянс</h3>
                        </a>
                    </div>
                    <div class="col-xs-6">
                        <a class="button btn-default btn-block" href="rooms.php?case=room">
                            <h3>Чат</h3>
                        </a>
                    </div>

                    <? $site->PrintMiniLine() ?>
                    <div class="col-xs-6">
                        <a class="button btn-default btn-block" href="bank.php">
                            <h3>Банк</h3>
                        </a>
                    </div>
                    <div class="col-xs-6">
                        <a class="button btn-default btn-block" href="mail.php">
                            <h3>Почта</h3>
                        </a>
                    </div>

                    <? $site->PrintMiniLine() ?>
                    <div class="col-xs-6">
                        <a class="button btn-default btn-block" href="hosp.php">
                            <h3>Госпиталь</h3>
                        </a>
                    </div>
                    <div class="col-xs-6">
                        <a class="button btn-default btn-block" href="news.php">
                            <h3>Новости</h3>
                        </a>
                    </div>
                </div>
            </div><?php */
            break;

        case 'exit':
            $user->exitReg();
            break;
    }
} catch (Exception $e) { ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h3 class="red">
                    <?= $e->getMessage() ?>
                </h3>
                <p class="green">
                    До автоматической разблокировки осталось <?= $times->timeHours($user->user('block_time') - time()) ?>
                </p>
            </div>
        </div>
    </div><?php
}
if($user->mdAmdFunction('1') == true) {
    if($admin1983->returnAdmin() or $admin5->returnAdmin()) {
        $site->lineHrInContainer(); ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <a class="btn btn-block btn-success" href="admin.php">
                        Админ - панель
                    </a>
                </div>
            </div>
        </div><?php
        $site->lineHrInContainer();
    }
}
require_once ('system/down.php');