<?php
if (isset($_GET['a']) && $_GET['a'] == 'nick') {
    $title = "Смена имени";
} elseif (isset($_GET['a']) && $_GET['a'] == 'avatar') {
    $title = "Смена аватарки";
} else {
    $title = 'Настройки';
}
require_once 'system/up.php';
$user = new RegUser();
$user->_Reg();
$site = new Site();
$sql = new SafeMySQL();

$site->setSwitch('a');
switch ($site->switch) {
    default: ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <p>
                        <? Site::linkToSiteAdd('btn btn-block btn-light', '', 'set?a=nick', 'Сменить имя'); ?>
                    </p>
                    <? Site::PrintMiniLine() ?>
                    <p>
                        <? Site::linkToSiteAdd('btn btn-block btn-light', '', 'set?a=flag', 'Сменить флаг'); ?>
                    </p>
                    <? Site::PrintMiniLine() ?>
                    <p>
                        <? Site::linkToSiteAdd('btn btn-block btn-light', '', 'set?a=avatar', 'Сменить аватарку'); ?>
                    </p>
                    <? Site::PrintMiniLine() ?>
                </div>
            </div>
        </div><?php
        break;

    case 'flag':
        echo "Смена флага";
        break;

    case 'nick':
        if (isset($_POST['enter'])) {
            $login = Filter::clearFullSpecialChars($_POST['login']);
            if (!is_string($login) && trim($login) == "" && strlen(string: trim(string: $login)) < 3) {
                Site::session_empty('error', 'Error!');
            }
        } else { ?>
            <div class="container">
                <div class="row">
                    <h3 class="text-center text-info"><?= $page->title ?></h3>
                    <? Site::PrintMiniLine(); ?>
                    <div class="col-xs-12"><?
                        if ($user->getBan()) { ?>
                            <form action="?a=nick" method="post">
                            <input class="col-xs-12" type="text" name="login" maxlength="16" value="<?= $user->user('login') ?>" required><?
                            Site::PrintMiniLine(); ?>
                            <input class="btn btn-block btn-success" type="submit" name="enter" value="Сменить имя">
                            </form><?
                        } ?>
                    </div>
                </div>
            </div><?php
            Site::lineHrInContainer();
        }
        break;

    case 'avatar':
        break;
}
require_once 'system/down.php';