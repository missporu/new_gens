<?php
require_once 'head.php';
Site::lineHrInContainer(); ?>
<div class="container">
    <div class="row">
        <div class="col-xs-2">
            <h1 class="text-info">
                <a href="/"><span class="glyphicon glyphicon-home"></span></a>
            </h1>
        </div>
        <div class="col-xs-8 text-center">
            <h1 class="text-danger"><?= $site->name ?></h1>
        </div>
        <div class="col-xs-2 text-right">
            <h1 class="text-info">
                <a href=""><span class="glyphicon glyphicon-refresh"></span></a>
            </h1>
        </div>
    </div>
</div><?php
Site::lineHrInContainer();
if ($user->getUser()) { ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <ul class="list-inline">
                    <li class="text-info">
                        <?= $user->getRaiting($user->user('id')) ?> <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    </li>
                    <li>
                        <a class="green" href="pers"><?= $user->user(key: 'baks') ?> <i class="fa fa-usd" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a class="silver" href="pers"><?= $user->user(key: 'silver') ?> <i class="fa fa-codepen" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a class="neft" href="pers"><?= $user->user(key: 'neft') ?> <i class="" aria-hidden="true">&#128738;</i></a>
                    </li>
                    <li>
                        <a class="gaz" href="pers"><?= $user->user(key: 'gaz') ?> <i class="fa fa-fire" aria-hidden="true"></i></a>
                    </li>
                    <li><?php
                        if ($user->user(key: 'energy') <= 0) {
                            $fa = "fa-battery-empty";
                        } elseif ($user->user(key: 'energy') <= 500) {
                            $fa = "fa-battery-quarter";
                        } elseif ($user->user(key: 'energy') <= 5000) {
                            $fa = "fa-battery-half";
                        } elseif ($user->user(key: 'energy') <= 15000) {
                            $fa = "fa-battery-quarters";
                        } else $fa = "fa-battery-full"; ?>
                        <a class="yellow" href="pers"><?= $user->user(key: 'energy') ?> <i class="fa <?= $fa ?>" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a class="yellow" href="bank"><?= $user->user(key: 'gold') ?> <i class="fa fa-money" aria-hidden="true"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div><?php
    Site::lineHrInContainer();
}
if (isset($_SESSION['info'])) { ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $_SESSION['info'] ?>
                </div>
            </div>
        </div>
    </div><?php
    $_SESSION['info'] = NULL;
}

if (isset($_SESSION['error'])) { ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $_SESSION['error'] ?>
                </div>
            </div>
        </div>
    </div><?php
    $_SESSION['error'] = NULL;
}

if (isset($_SESSION['ok'])) { ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $_SESSION['ok'] ?>
                </div>
            </div>
        </div>
    </div><?php
    $_SESSION['ok'] = NULL;
}
if ($user->getUser()) {
    $sql->query("update users set mesto = ?s where id = ?i limit ?i", $page->title, $user->user(key: 'id'), 1);
}