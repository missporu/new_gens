<?php
$title = 'Главная';
require_once ('system/up.php');
$user->_Reg();

try {
    if($user->getBlock()) {
        throw new Exception(message: 'Вы заблокированы администрацией проекта!');
    }

    switch ($site->switch) {
        default: ?>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <? Site::PrintMiniLine() ?>
                        <h5 class="text-info text-center">
                            Сражения
                        </h5>
                        <? Site::PrintMiniLine() ?>
                        <div class="col-xs-12">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a class="btn btn-block btn-dark" href="arena.php">
                                        <span>Арена</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <? Site::PrintMiniLine() ?>
                        <h5 class="text-info text-center">
                            Торговля
                        </h5>
                        <? Site::PrintMiniLine() ?>
                        <div class="col-xs-12">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a class="btn btn-block btn-dark" href="marketplace.php">
                                        <span>Рынок ресурсов</span>
                                    </a>
                                </li>
                                <? Site::PrintMiniLine() ?>
                                <li class="list-group-item">
                                    <a class="btn btn-block btn-dark" href="blackmarket.php">
                                        <span>Черный рынок</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <? Site::PrintMiniLine() ?>
                        <h5 class="text-info text-center">
                            Персонаж
                        </h5>
                        <? Site::PrintMiniLine() ?>
                        <div class="col-xs-12">
                            <ul class="list-group"><?
                                if($user->userBonus(value: 'time') < time() + 5) { ?>
                                    <li class="list-group-item">
                                        <a class="btn btn-block btn-danger" href="bonus.php">
                                            <span>Ежедневный бонус!</span>
                                        </a>
                                    </li><?php
                                    Site::PrintMiniLine();
                                } ?>
                                <li class="list-group-item">
                                    <a class="btn btn-block btn-dark" href="pers.php">
                                        <span>Профиль</span>
                                    </a>
                                </li>
                                <? Site::PrintMiniLine() ?>
                                <li class="list-group-item">
                                    <a class="btn btn-block btn-dark" href="bank.php">
                                        <span>Банк</span>
                                    </a>
                                </li>
                                <? Site::PrintMiniLine() ?>
                                <li class="list-group-item">
                                    <a class="btn btn-block btn-dark" href="clan.php">
                                        <span>Клан</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <? Site::PrintMiniLine() ?>
                        <h5 class="text-info text-center">
                            Общение
                        </h5>
                        <? Site::PrintMiniLine() ?>
                        <div class="col-xs-12">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a class="btn btn-block btn-dark" href="chat.php">
                                        <span>Чат</span>
                                    </a>
                                </li>
                                <? Site::PrintMiniLine() ?>
                                <li class="list-group-item">
                                    <a class="btn btn-block btn-dark" href="mail.php">
                                        <span>Почта</span>
                                    </a>
                                </li>
                                <? Site::PrintMiniLine() ?>
                                <li class="list-group-item">
                                    <a class="btn btn-block btn-dark" href="forum.php">
                                        <span>Форум</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <? Site::PrintMiniLine() ?>
                        <h5 class="text-info text-center">
                            Разное
                        </h5>
                        <? Site::PrintMiniLine() ?>
                        <div class="col-xs-12">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a class="btn btn-block btn-dark" href="help.php">
                                        <span>Поддержка</span>
                                    </a>
                                </li>
                                <? Site::PrintMiniLine() ?>
                                <li class="list-group-item">
                                    <a class="btn btn-block btn-dark" href="news.php">
                                        <span>Новости</span>
                                    </a>
                                </li>
                            </ul>
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
                    До автоматической разблокировки осталось <?= Times::timeHours(time: $user->user(key: 'block_time') - time()) ?>
                </p>
            </div>
        </div>
    </div><?php
}
require_once ('system/down.php');