<?php
if ($user->getUser())
{
    if ($user->mdAmdFunction(value: '1') == true)
    {
        $admin = new Admin();
        if ($admin->setAdmin(admin: 1983)->returnAdmin() or
                $admin->setAdmin(admin: 5)->returnAdmin())
        {
            Site::lineHrInContainer(); ?>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <? Site::linkToSiteAdd('btn btn-block btn-success', '', 'admin', 'Админ - панель'); ?>
                    </div>
                </div>
            </div><?php
            Site::lineHrInContainer();
        }
        if ($admin->setAdmin(admin: 4)->returnAdmin() or
                $admin->setAdmin(admin: 3)->returnAdmin())
        {
            Site::lineHrInContainer(); ?>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <a class="btn btn-block btn-success" href="moder">
                            Модер - панель
                        </a>
                    </div>
                </div>
            </div><?php
            Site::lineHrInContainer();
        }
    }
    Site::lineHrInContainer(); ?>
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
    Site::lineHrInContainer();
}
require_once "foot.php";