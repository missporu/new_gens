<?php
if($user->getUser()) {
    $site->lineHrInContainer(); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <a class="btn btn-primary btn-block" href="menu.php?a=exit">
                    <img src="images/icons/exit.png" alt="Выход"/> Выход
                </a>
            </div>
            <div class="col-xs-6 text-right">
                <a class="btn btn-primary btn-block" href="set.php">Настройки <img src="images/icons/settings.png" alt="Настройки"/></a>
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-12"></div>
            <div class="clearfix"></div>
        </div>
    </div><?php
    $site->lineHrInContainer();
}
require_once "foot.php";