<?php
$title = 'Арена';
require_once "system/up.php";
$user = new RegUser();
$user->_Reg();

$site = new Site();
$page = new Page();
$page->setTitle($title);

try {
    if($user->getBlock()) {
        throw new Exception(message: 'Вы заблокированы администрацией проекта!');
    }
    $site->setSwitch(get: 'a'); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="text-center"><?= $page->getTitle() ?></h2>
            </div><?php
    switch ($site->switch) {
        default:
            Site::PrintMiniLine();
            Site::linkToSiteSwitch(link: '?a=123', text: '123');
            break;

        case '123':
            break;
    } ?>
        </div>
    </div><?php
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
require_once "system/down.php";