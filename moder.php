<?php
$title = 'Модерка';
require_once 'system/up.php';
$user = new RegUser();
$user->_Reg();
$sql = new SafeMySQL();
$admin = new Admin();
$site = new Site();


try {
    if($user->getBlock() and $admin->setAdmin(admin: 1983)->returnAdmin() == false) {
        throw new Exception(message: 'Вы заблокированы администрацией проекта!');
    }
    if($user->user(key: 'prava') < 1983 || $user->user(key: 'prava') > 1983) {
        if ($user->user(key: 'prava') < 3) {
            if($user->user(key: 'narushenie_admin') >= 1) {
                $narushenie = Filter::clearInt(string: $user->user(key: 'narushenie'));
                if ($narushenie == 0) $narushenie = 1;
                $timeBlock = 1 * $narushenie;
                $user->addAitomaticBlock(timeDay: $narushenie);
                Site::session_empty(type: 'error', text: "У вас кончились бесплатные попытки входа в админку! Ваш аккаунт автоматически заблокирован! Любые жалобы будут рассмотрены в обычном порядке", location: 'menu.php');
            } else $user->addNarushenieAdmin(userID: $user->user(key: 'id'));
            Site::session_empty(type: 'error', text: "Нет доступа! На третьей попытке входа без доступа произойдет автоматическая блокировка до выяснения. Уведомление о попытке входа ушло на почту админу. Приятной игры", location: 'menu.php');
        }
    }

    $site->setSwitch(get: 'a');
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



/*
_Reg();
if($set['prava']<2){
$_SESSION['err'] = 'Нет доступа';
header('Location: menu.php');
exit();
}
?><div class="main"><?php
switch($_GET['case']){
default:
if ($set['prava']>=3) { ?>
<div class="menuList">
    <li>
        <a href="chat_del.php"><img src="images/icons/arrow.png" alt="*"/>Посмотреть удаленные сообщения</a>
    </li><?
}
break;
case '3_1':
if($set['prava']<2){
$_SESSION['err'] = 'Нет доступа';
header('Location: menu.php');
exit();
}
$id=isset($_GET['id'])?_NumFilter($_GET['id']):NULL;
$data  = _FetchAssoc("SELECT * FROM `user_reg` WHERE `id`='" . $id . "' LIMIT 1");
$data_set  = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $id . "' LIMIT 1");
?><div class="block_zero">Возможные мульты игрока: <a href="view.php?smotr=<?=$data['id']?>"><?=$data['login']?></a></div><div class="mini-line"></div><?
$dubl_ip_browser=mysql_query("SELECT * FROM `user_reg` WHERE `browser`='".$data['browser']."'  AND `id`!='".$id."' ORDER BY `id` ASC");
while($mult=mysql_fetch_assoc($dubl_ip_browser)){
$mult_set  = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='".$mult['id']."' LIMIT 1");
?><div class="block_zero">Игрок: <a href="view.php?smotr=<?=$mult['id']?>"><?=$mult['login']?></a><span style="float: right;"><small><?=$mult['ip']?> / <?=$mult_set['ip_new']?></small></span></div><div class="dot-line"></div><?
}
break;
}
?></div></div><? */
require_once 'system/down.php';