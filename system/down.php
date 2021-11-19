<?php
if ($user->getUser()) {
    if ($user->mdAmdFunction('1') == true) {
        $admin5 = new Admin(5);
        $admin1983 = new Admin(1983);
        if ($admin1983->returnAdmin() or $admin5->returnAdmin()) {
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
    $site->lineHrInContainer(); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <a class="btn btn-primary btn-block" href="menu.php?a=exit">
                    <img src="images/icons/exit.png" alt="Выход"/> Выход
                </a>
            </div>
            <div class="col-xs-6 text-right">
                <a class="btn btn-primary btn-block" href="set.php">Настройки <img src="images/icons/settings.png"
                                                                                   alt="Настройки"/></a>
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-12"></div>
            <div class="clearfix"></div>
        </div>
    </div><?php
    $site->lineHrInContainer();
}
require_once "foot.php";