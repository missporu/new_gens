<?php
$title = 'Админ-панель';
require_once('system/up.php');
$user->_Reg();

$admin1983 = new Admin('1983');
$admin5 = new Admin('5');

try {
    if($user->getBlock() and $admin1983->returnAdmin() == false) {
        throw new Exception('Вы заблокированы администрацией проекта!');
    }
    if($user->user('prava') < 1983 || $user->user('prava') > 1983) {
        if ($user->user('prava') <> 5) {
            if($user->user('narushenie_admin') > 1) {
                $narushenie = $filter->clearInt($user->user('narushenie'));
                if($narushenie == 0) {
                    $narushenie = 1;
                }
                $timeBlock = 1 * $narushenie;
                $user->addAitomaticBlock($narushenie);
                $site->session_inf("У вас кончились бесплатные попытки входа в админку! Ваш аккаунт автоматически заблокирован! Любые жалобы будут рассмотрены в обычном порядке", 'menu.php');
            } else {
                $user->addNarushenieAdmin($user->user('id'));
            }
            $site->session_inf("Нет доступа! На третьей попытке входа без доступа произойдет автоматическая блокировка до выяснения. Уведомление о попытке входа ушло на почту админу. Приятной игры", 'menu.php');
        }
    }

    switch ($switch) {
        default: ?>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a class="btn btn-block btn-dark" href="?a=spisokUser"><span>Все пользователи</span></a>
                            </li>
                            <li class="list-group-item">
                                <a class="btn btn-block btn-dark" href="?a=spisokUser">Все пользователи</a>
                            </li>
                            <li class="list-group-item">
                                <a class="miss-block btn-dark" href="?a=spisokUser"><span>Все пользователи</span></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <?php
            break;

        case 'redUser':
            if (!$admin1983->returnAdmin()) {
                $site->session_err("Без доступа");
            }
            $userID = $filter->clearInt($_GET['id']);
            $redUser = $sql->getRow("select * from users where id = ?i limit ?i", $userID, 1);

            if (isset($_GET['enter'])) {
                $login = $filter->clearString($_POST['login']);
            } else {
                $ol = $sql->getAll("SELECT COLUMN_NAME, COLUMN_COMMENT, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ?s;", 'users'); ?>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <form class="form-horizontal" action="" method="post"><?
                                foreach ($ol as $aaa) {
                                    $nameColumn = $aaa['COLUMN_NAME']; ?>
                                    <div class="form-group col-xs-6">
                                        <?= $aaa['COLUMN_COMMENT'] ?> | <?= $aaa['COLUMN_TYPE'] ?>
                                    </div>
                                    <div class="form-group col-xs-6">
                                        <input name="<?= $nameColumn ?>" class="form-control" type="text" value="<?= $redUser[$nameColumn] ?>">
                                    </div>
                                    <div class="clearfix"></div><?
                                } ?>
                            </form>
                        </div>
                    </div>
                </div><?php
            }
            break;

        case 'spisokUser':
            $allUser = $sql->getAll("select * from users order by id desc"); ?>
            <div class="container">
                <div class="row">
                    <h3 class="text-center text-info">Список пользователей</h3><?
                    $site->PrintMiniLine();
                    foreach ($allUser as $all) {
                        if ($admin1983->returnAdmin()) { ?>
                            <div class="col-xs-9"><?
                        }
                        if ($admin5->returnAdmin()) { ?>
                            <div class="col-xs-12"><?
                        } ?>
                        <small class="orange"><?= $all['id'] ?>)</small>
                        <small class="orange"><?= $all['login'] ?> :</small><?
                        if ($admin1983->returnAdmin()) {
                            echo " <small class='text-danger'>[{$all['slovo']}]</small> ";
                        } ?>
                        | <small class="text-warning"><?= $all['email'] ?></small>
                        | <small class="text-info"><?= $all['lvl'] ?> lvl</small>
                        | <small class="green"><?= $all['baks'] ?> $</small>
                        | <small class="yellow"><?= $all['gold'] ?> G</small>
                        |
                        </div><?
                        if ($admin1983->returnAdmin()) { ?>
                            <div class="col-xs-3">
                                <a class="btn btn-block btn-dark" href="?a=redUser&id=<?= $all['id'] ?>">Ред</a>
                            </div><?
                        }
                        $site->PrintMiniLine();
                    } ?>
                </div>
            </div><?php
            break;
    }
} catch (Throwable $e) { ?>
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
/*
if($set['prava']<3){
$time_block = time()*60*60*24*25;
mysql_query("UPDATE `user_set` SET `block`='1', `block_time`='".$time_block."' WHERE `id`='".$set['id']."' LIMIT 1");
$_SESSION['err'] = 'Нет доступа';
header('Location: menu.php');
exit();
} ?><div class="main"><?php
switch($_GET['case']) {

default: ?>
<div class="menuList">
    <li>
        <a href="admin.php?case=1"><img src="images/icons/arrow.png" alt="*"/>Редактирование игрока</a>
    </li>
    <li>
        <a href="admin.php?case=2"><img src="images/icons/arrow.png" alt="*"/>Добавить новость</a>
    </li>
    <li>
        <a href="chat_del.php"><img src="images/icons/arrow.png" alt="*"/>Посмотреть удаленные сообщения</a>
    </li>
    <li>
        <a href="admin.php?case=add_podarok"><img src="images/icons/arrow.png" alt="*"/>Включить всем подарки</a>
    </li>
<a href="admin.php?case=action_gold"><img src="images/icons/arrow.png" alt="*"/>Сделать акцию</a>
    </li>
    <li>
        <a href="admin.php?case=delete_chats"><img src="images/icons/arrow.png" alt="*"/>Очистить чаты</a>
    </li>
    <li>
        <a href="admin.php?case=block_pers"><img src="images/icons/arrow.png" alt="*"/>Заблокированные персонажи</a>
    </li>
<?php
break;

case '1':
if($set['prava']<3){
$_SESSION['err'] = 'Нет доступа';
header('Location: menu.php');
exit();
}
if(isset($_POST['login'])) {
$name = _TextFilter($_POST['login']);
$data  = _FetchAssoc("SELECT `id` FROM `user_reg` WHERE `login`='" . $name . "' LIMIT 1");
if (!$data) {
        $_SESSION['err'] = 'Игрок не найден';
        header('Location: admin.php?case=1');
        exit();
    } else {
    $_SESSION['ok'] = 'Игрок найден';
        header('Location: admin.php?case=1_1&id='.$data['id'].'');
        exit();
    }
}else{ ?>
    <div class="block_zero center">
        <form action="admin.php?case=1" method="post">Введите никнейм:<br/>
            <input class="text" type="text" name="login"/><br/><br/><span class="btn"><span class="end"><input class="label" type="submit" value="Найти"></span></span> </a>
        </form><?php
}
break;

case '1_1':
if($set['prava']<3){
$_SESSION['err'] = 'Нет доступа';
header('Location: menu.php');
exit();
}
$id=isset($_GET['id'])?_NumFilter($_GET['id']):NULL;
$data  = _FetchAssoc("SELECT * FROM `user_reg` WHERE `id`='" . $id . "' LIMIT 1");
$data_set  = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $id . "' LIMIT 1"); ?>

<div class="block_zero center">Игрок: <a href="view.php?smotr=<?=$data['id']?>"><?=$data['login']?></a></div>
<div class="dot-line"></div>
<div class="block_zero">
    <?=$data_set['ip']?> IP <br>
    <?=$data_set['ip_new']?> IP NEW <br>
    <?=$data_set['browser']?> СОФТ И ЖЕЛЕЗО <br><hr>
    <p style="color:gold;"><?=$data_set['gold']?> Золота </p><?php
	if (isset($_POST['vid_gold'])) {
		if ($set['prava'] < 4) {
			$_SESSION['err'] = 'Не для Вас! ';
            header('Location: admin.php?case=1_1&id='.$data['id'].'');
            exit();
		}
        $gold_get = $_POST['text'];
		mysql_query("UPDATE `user_set` SET `gold`='".$gold_get."' WHERE `id`='".$id."' LIMIT 1");
		$text_md = 'Изменил у персонажа '.$data['login']. ' с '.$data_set['gold'].' на '.$gold_get.' Золотo';
		mysql_query("INSERT INTO `admin_logi`(`id`, `id_user`, `user`, `text`, `date`) VALUES (NULL,'".$set['id']."','".$set['user']."','".$text_md."',NULL)");
        $_SESSION['ok'] = 'Выдано '.$gold_get.' золота';
        header('Location: admin.php?case=1_1&id='.$data['id'].'');
        exit();
    } else { ?>
        <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
            <input type="number" name="text" >
            <input type="submit" name="vid_gold" value="Изменить кол-во золота">
        </form><?php 
	} ?><br>
    <p style="color:green;"><?=$data_set['baks']?> Денег </p><?php
	if (isset($_POST['vid_money'])) {
		if ($set['prava'] < 4) {
			$_SESSION['err'] = 'Не для Вас! ';
            header('Location: admin.php?case=1_1&id='.$data['id'].'');
            exit();
		}
        $gold_money = $_POST['text'];
		mysql_query("UPDATE `user_set` SET `baks`='".$gold_money."' WHERE `id`='".$id."' LIMIT 1");
		$text_md = 'Изменил у персонажа '.$data['login']. ' с '.$data_set['baks'].' на '.$gold_money.' Баксов';
		mysql_query("INSERT INTO `admin_logi`(`id`, `id_user`, `user`, `text`, `date`) VALUES (NULL,'".$set['id']."','".$set['user']."','".$text_md."',NULL)");
        $_SESSION['ok'] = 'Выдано '.$gold_money.' баксов';
        header('Location: admin.php?case=1_1&id='.$data['id'].'');
        exit();
    } else { ?>
        <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
            <input type="number" name="text" >
            <input type="submit" name="vid_money" value="Изменить кол-во баксов">
        </form><?php 
    } ?><br>
    <?=$data_set['donat_bonus']?> Куплено золота за все время <br>
    <?=$data_set['dohod']?> Доход в час и <?=$data_set['chistaya']?> Чистой прибыли <br> 
    <?=$data_set['diplomat']?> Дипломатов из <?=$data_set['diplomat_max']?> возможных <br>
    <?=$data_set['exp']?> Опыта <br><hr>
    <?=$data_set['hp']?> HP / <?=$data_set['max_hp']?> MAX HP <br>
    <?=$data_set['mp']?> MP / <?=$data_set['max_mp']?> MAX MP <br><hr>
    Выдача прав:<br>
    0 - СНЯТЬ С ДОЛЖНОСТИ (права игрока) <br>
    1 - Консультант<br>
    2 - MD <br>
    3 - SMD <br>
    4 - ADM <br>
    <?php
    if ($data_set['prava']<=5) {
        $prava_get = $_POST['pr'];
        if (isset($_POST['prava_plus_md'])) {
            if ($prava_get > $set['prava']) {
                $_SESSION['err'] = 'Не можете назначать выше себя по рангу! ';
                header('Location: admin.php?case=1_1&id='.$data['id'].'');
                exit();
            }
            mysql_query("UPDATE `user_set` SET `prava`='".$prava_get."' WHERE `id`='".$id."' LIMIT 1");
            $_SESSION['ok'] = 'Успешно ';
            header('Location: admin.php?case=1_1&id='.$data['id'].'');
            exit();
        } else { ?>
            <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
                <input type="number" name="pr" >
                <input type="submit" name="prava_plus_md" value="Дать должность">
            </form><?php 
        } // end of form
    }
    
    if (isset($_POST['lvl_ravno'])) {
        $lvl_get = $_POST['text'];
        $opit_ravno = _FetchAssoc("SELECT * FROM `lvl` WHERE `lvl`='".$lvl_get."' LIMIT 1");
        $opit_posled = $opit_ravno['opit']+1;
        mysql_query("UPDATE `user_set` SET `exp`='".$opit_posled."', `lvl`='1' WHERE `id`='".$id."' LIMIT 1");
        $_SESSION['ok'] = 'Выдан '.$lvl_get.' уровень';
        header('Location: admin.php?case=1_1&id='.$data['id'].'');
        exit();
    } else { ?>
        <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
            <input type="number" name="text" >
            <input type="submit" name="lvl_ravno" value="Выдать уровень">
        </form><?php 
	}
	
	

break;

case 'admin_redaktor':
if($set['prava']<3){
$_SESSION['err'] = 'Нет доступа';
header('Location: menu.php');
exit();
}
$id=isset($_GET['id'])?_NumFilter($_GET['id']):NULL;
$data  = _FetchAssoc("SELECT * FROM `user_reg` WHERE `id`='" . $id . "' LIMIT 1");
$data_set  = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $id . "' LIMIT 1"); ?>

<div class="block_zero center">Игрок: <a href="view.php?smotr=<?=$data['id']?>"><?=$data['login']?></a></div>
<div class="dot-line"></div>
<div class="block_zero">
    <?=$data_set['ip']?> IP <br>
    <?=$data_set['ip_new']?> IP NEW <br>
    <?=$data_set['browser']?> СОФТ И ЖЕЛЕЗО <br><hr>
    <?=$data_set['gold']?> Золота <br>
    <?=$data_set['baks']?> Денег <br>
    <?=$data_set['donat_bonus']?> Куплено золота за все время <br>
    <?=$data_set['dohod']?> Доход в час и <?=$data_set['chistaya']?> Чистой прибыли <br> 
    <?=$data_set['diplomat']?> Дипломатов из <?=$data_set['diplomat_max']?> возможных <br>
    <?=$data_set['exp']?> Опыта <br><hr>
    <?=$data_set['hp']?> HP / <?=$data_set['max_hp']?> MAX HP <br>
    <?=$data_set['mp']?> MP / <?=$data_set['max_mp']?> MAX MP <br><hr><?php
    if ($data_set['prava']<2) {
        if (isset($_POST['prava_plus_md'])) {
            mysql_query("UPDATE `user_set` SET `prava`='2' WHERE `id`='".$id."' LIMIT 1");
            $_SESSION['ok'] = 'Успешно назначен в мд';
            header('Location: admin.php?case=1_1&id='.$data['id'].'');
            exit();
        } else { ?>
            <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
                <input type="submit" name="prava_plus_md" value="Назначить мд">
            </form><?php 
        } // end of form
    }
    break;

case '2':
if($set['prava']<4){
$_SESSION['err'] = 'Нет доступа';
header('Location: menu.php');
exit();
}
if(isset($_POST['news'])){
$tema = _TextFilter($_POST['tema']);
$text = _TextFilter($_POST['text']);
if (!$tema) {
        $_SESSION['err'] = 'Введите тему новости';
        header('Location: admin.php?case=2');
        exit();
        }elseif (!$text) {
        $_SESSION['err'] = 'Введите текст новости';
        header('Location: admin.php?case=2');
        exit();
    } else {
    $d=date("d F Y");
$d=str_replace("January","января",$d);
$d=str_replace("February","февраля",$d);
$d=str_replace("March","марта",$d);
$d=str_replace("April","апреля",$d);
$d=str_replace("May","мая",$d);
$d=str_replace("June","июня",$d);
$d=str_replace("July","июля",$d);
$d=str_replace("August","августа",$d);
$d=str_replace("September","сентября",$d);
$d=str_replace("October","октября",$d);
$d=str_replace("November","ноября",$d);
$d=str_replace("December","декабря",$d);
$date_news=_TextFilter($d);
$time_news=_TextFilter(date("H:i:s"));
    mysql_query("INSERT INTO `news` SET `data`='".$date_news."', `time`='".$time_news."', `avtor`='".$user_id."', `tema`='".$tema."', `text`='".$text."', `status`='1'");
    mysql_query("UPDATE `user_set` SET `news`='1'");
    $_SESSION['ok'] = 'Новость добавлена';
        header('Location: admin.php');
        exit();
    }
}else{
?><div class="block_zero center"><form action="admin.php?case=2" method="post">Тема новости:<br/><input class="text large" type="text" name="tema"/><br/>Текст новости:<br/><textarea class="text large" type="text" name="text" rows="10" cols="50" placeholder="Введите текст новости"/></textarea><br/><span class="btn"><span class="end"><input class="label" type="submit" name="news" value="Опубликовать"></span></span> </a></form><?
}
break;

/*case '3':

break;

case '3_1':
if($set['prava']<4){
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





case 'mail':
    if ($set['prava']<4) {
        header('Location: menu.php');
        exit();
    }
    $id=isset($_GET['id'])?_NumFilter($_GET['id']):NULL;
    $data = mysql_query("SELECT * FROM `mail` WHERE `kto` = '" . $id . "' ORDER BY `mail`.`id` DESC LIMIT 25");
    echo 'Сообщения, отправленные игроком<br><hr>';
    if ($_GET['id']==1) {
        $_SESSION['err'] = 'Почта админа недоступна';
        header("Location: menu.php");
        exit();
    }
    while ($data1 = mysql_fetch_array($data)) {
        $rooms_user = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $data1['komu'] . "' ");
        echo 'Кому: ';
        echo $rooms_user['user'];
        echo ' '. $data1['date'] . ' числа, в ' . $data1['time'] . ' ';
        if ($data1['status']==1) {
            echo ' Прочитано';
        } else {
            echo ' Не прочитано';
        }
        echo '<br>';
        echo $data1['text'];
        echo "<br><hr>";
    }
    break;

    case 'mailer':
    if ($set['prava']<4) {
        $_SESSION['err'] = 'Нет доступа';
        header('Location: menu.php');
        exit();
    }
    $id=isset($_GET['id'])?_NumFilter($_GET['id']):NULL;
    $data = mysql_query("SELECT * FROM `mail` WHERE `komu` = '" . $id . "' ORDER BY `mail`.`id` DESC LIMIT 25");
    echo 'Сообщения, полученные игроком<br><hr>';
    if ($_GET['id']==1) {
        $_SESSION['err'] = 'Почта админа недоступна';
        header("Location: menu.php");
        exit();
    }
    while ($data1 = mysql_fetch_array($data)) {
        $rooms_user = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $data1['kto'] . "' ");
        echo 'От кого: ';
        echo $rooms_user['user'];
        echo ' '. $data1['date'] . ' числа, в ' . $data1['time'] . ' ';
        if ($data1['status']==1) {
            echo ' Прочитано';
        } else {
            echo ' Не прочитано';
        }
        echo '<br>';
        echo $data1['text'];
        echo "<br><hr>";
    }
        break;


case 'add_podarok':
if ($set['prava']<5) {
        $_SESSION['err'] = 'Нет доступа';
        header('Location: menu.php');
        exit();
    }

if (isset($_POST['podarok_dat'])) {
            mysql_query("UPDATE `user_set` SET `podarok`='0' ");
            $_SESSION['ok'] = 'Подарки сервера включены';
            header('Location: ?');
            exit();
        } else { ?>
            <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
                <input type="submit" name="podarok_dat" value="Включить подарки сервера">
            </form><?php 
        } // end of form

break;

case 'action_gold':
if ($set['prava']<5) {
        $_SESSION['err'] = 'Нет доступа';
        header('Location: menu.php');
        exit();
    }
    $action = _FetchAssoc("SELECT * FROM `setting_game` WHERE `id` = '1' LIMIT 1");
if ($action['action_gold'] == 0) {
    if (isset($_POST['action'])) {
        $action_sum = $_POST['action_skolko'];
        $time_plus = $_POST['time_gold']*60*60;
        $action_time = time()+$time_plus;
                    mysql_query("UPDATE `setting_game` SET `action_gold`='1', `skolko_gold`='".$action_sum."', `data_gold`='".$action_time."' LIMIT 1");
                    $_SESSION['ok'] = 'Акция x'.$action_sum.' включена';
                    header('Location: ?');
                    exit();
                } else { ?>
                    <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
                        <input type="number" name="action_skolko">Сколько акция (х2, х3...)<br>
                        <input type="number" name="time_gold">На сколько часов <br>
                        <input type="submit" name="action" value="Включить акцию"><br>
                    </form><?php 
                } // end of form
} else {
        if (isset($_POST['action_off'])) {
                mysql_query("UPDATE `setting_game` SET `action_gold`='0', `skolko_gold`='0' LIMIT 1");
                $_SESSION['ok'] = 'Акция выключена';
                header('Location: ?');
                exit();
            } else { ?>
                <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
                    <input type="submit" name="action_off" value="Выключить акцию">
                </form><?php 
            } // end of form
}
break;

case 'delete_chats':
    if (isset($_POST['delete_chats'])) {
        mysql_query("TRUNCATE `chat2`");
        mysql_query("TRUNCATE `chat`");
        mysql_query("TRUNCATE `chat_del`");
        $_SESSION['ok'] = 'Чаты очищены';
        header('Location: ?');
        exit();
    } else { ?>
        <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
            <input type="submit" name="delete_chats" value="Очистить чаты">
        </form><?php 
    }
    break;

    case 'block_pers':
$data_set  = mysql_query("SELECT * FROM `user_set` WHERE `block`='1' ORDER BY `id` ASC ");
$data  = mysql_query("SELECT * FROM `user_reg` WHERE `id`='" . $data_set['id'] . "' "); 
$data_setler = mysql_fetch_array($data_set); ?>
        <div class="row text-center">
            <h1>Список заблокированных: </h1><br>
        </div><?php
        do { ?>
            <a href="view.php?smotr=<?=$data_setler['id']?>"><?=$data_setler['user']?></a><hr><?php
        } while ($data_setler = mysql_fetch_array($data_set) );
        break;
}
echo '</div>'; */
require_once('system/down.php');