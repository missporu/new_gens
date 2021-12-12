<?php
$title = 'Почта';
require_once 'system/up.php';
$user = new RegUser();
$user->_Reg();
$sql = new SafeMySQL();
$site = new Site();
$admin = new Admin();

try {
    if ($user->getBlock() and $admin->setAdmin(admin: 1983)->returnAdmin() == false) {
        throw new Exception(message: 'Вы заблокированы администрацией проекта!');
    }
    $site->setSwitch(get: 'a');

    switch ($site->switch) {
        default:

            break;
    }

} catch (Exception $e) { ?>
    <div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <h3 class="red">
                <?= $e->getMessage() ?>
            </h3><?
            if ($user->getBlock()) { ?>
                <p class="green">
                До автоматической разблокировки осталось <?= Times::timeHours(time: $user->user(key: 'block_time') - time()) ?>
                </p><?
            } ?>
        </div>
    </div>
    </div><?php
}


/*
if ($set['ban']==1) {
	$_SESSION['err']='Вы забанены на общение.';
	header("Location: menu.php");
	exit();
}
if ($set['block']==1) {
	$_SESSION['err']='Вы заблокированы';
	header("Location: blok.php");
	exit();
}
?><div class="main"><?
if($set['logo'] == 'on'){
?><img src="images/logotips/mail.jpg" width="100%" alt="Почта"/><div class="mini-line"></div><?
}
?><div class="menuList"><?
if($_GET['case'] != ''){
?><li><a href="mail.php"><img src="images/icons/arrow.png" alt="*"/>Сообщения</a></li><?
}
if($_GET['case'] != 'kontakt'){
?><li><a href="mail.php?case=kontakt"><img src="images/icons/arrow.png" alt="*"/>Контакты</a></li><?
}
if($_GET['case'] != 'post'){
?><li><a href="mail.php?case=post"><img src="images/icons/arrow.png" alt="*"/>Написать</a></li><?
}
if($_GET['case'] != 'ignor'){
?><li><a href="mail.php?case=ignor"><img src="images/icons/arrow.png" alt="*"/>Игнор</a></li><?
}
switch($_GET['case']){
default:
echo'</div>';

$rec =$sql->getOne("SELECT count(id) from mail WHERE komu=?i",$user_id);
$sum=10;
$page = $ref[2];
$get=":page";
$posts = $rec;
$total = (($posts - 1) / $sum) + 1;
$total =  intval($total);
$page = intval($page);
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $sum - $sum;

$data_post=mysql_query("SELECT * FROM `mail` WHERE `kto`='" . $user_id . "' OR `komu`='" . $user_id . "' ORDER BY `id` DESC LIMIT $start, $sum");
while($vybor_post=mysql_fetch_assoc($data_post)){
if($vybor_post['komu']==$user_id){
$user_post=_FetchAssoc("SELECT * FROM `user_reg` WHERE `id`='" . $vybor_post['kto'] . "' LIMIT 1");
$set_user_post=_FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $user_post['id'] . "' LIMIT 1");
}else{
$user_post=_FetchAssoc("SELECT * FROM `user_reg` WHERE `id`='" . $vybor_post['komu'] . "' LIMIT 1");
$set_user_post=_FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $user_post['id'] . "' LIMIT 1");
}
if($vybor_post['komu']==$user_id AND $vybor_post['status']==0){
$plus_mail_dialog = '<span style="float: right;"><span style="color: #c66;"><small>(не прочитано)</small></span></span>';
} else {
$plus_mail_dialog = FALSE;
}
echo'<div class="mini-line"></div><a href="mail.php?case=post&log='.$user_post['id'].'"><div class="block_zero"><img src="images/flags/'.$set_user_post['side'].'.png"  alt="Флаг"/> '.$user_post['login'].''.$plus_mail_dialog.'</div></a>';
$i++;
}
echo '</div><div class="mini-line"></div><div class="main"><div class="block_zero center">';
put($page,$get,$total);
echo'</div></div></div>';
break;

case 'kontakt':
if (isset($_POST['send'])) {
            $name = _TextFilter($_POST['login']);
            $kontakt=_FetchAssoc("SELECT `id` FROM `user_reg` WHERE `login`='" . $name . "'");
            $verify_gamer = mysql_query("SELECT COUNT(`id`) FROM `user_reg` WHERE `login`='" . $name . "'");
            $verify_login = mysql_query("SELECT COUNT(`id`) FROM `mail_kontakt` WHERE `id_user`='" . $user_id . "' AND `id_kontakt`='" . _NumFilter($kontakt['id']) . "'");
            if (strlen($name) < 3 OR strlen($name) > 30) {
                $_SESSION['err'] = 'Длина никнейма 3-30 символов.';
                header('Location: mail.php?case=kontakt');
                exit();
            }
            if($name==$user['login']){
            $_SESSION['err'] = 'Вы пытаетесь добавить самого себя!';
                header('Location: mail.php?case=kontakt');
                exit();
            }
            if (mysql_result($verify_gamer, 0) > 0) {
            if (mysql_result($verify_login, 0) > 0) {
        $_SESSION['err'] = 'Такой игрок уже в контактах!';
        header('Location: mail.php?case=kontakt');
        exit();
        }else{
            mysql_query("INSERT INTO `mail_kontakt` SET `id_kontakt`='" . _NumFilter($kontakt['id']). "', `id_user`='".$user_id."'");
        $_SESSION['ok'] = 'Игрок '.$name.'<br/>добавлен в контакты!';
        header('Location: mail.php?case=kontakt');
        exit();
        }
        }else{
        $_SESSION['err'] = 'Такой игрок не зарегистрирован!';
        header('Location: mail.php?case=kontakt');
        exit();
        }
}
echo'</div><div class="mini-line"></div><div class="block_zero center">Введите никнейм:<form action="mail.php?case=kontakt" method="post"><input class="text large" type="text" name="login"/><br/><span class="btn"><span class="end"><input class="label" type="submit" name="send" value="Добавить"></span></span> </a></form>';
if (empty($_GET['page']) || $_GET['page'] == 0 || $_GET['page'] < 0) {
            $_GET['page'] = 0;
        }
        $next = _NumFilter($_GET['page'] + 1);
        $back = $_GET['page'] - 1;
        $num  = $_GET['page'] * 10;
        if ($_GET['page'] == 0) {
            $i = 1;
        } else {
            $i = ($_GET['page'] * 10) + 1;
        }
        $viso   = _NumRows("SELECT * FROM `mail_kontakt` WHERE `id_user`='" . $user_id . "'");
        $puslap = floor($viso / 10);
$data_kontakt=mysql_query("SELECT * FROM `mail_kontakt` WHERE `id_user`='" . $user_id . "' ORDER BY `id` ASC LIMIT $num, 10");
while($vybor_kontakt=mysql_fetch_assoc($data_kontakt)){
$user_kontakt=_FetchAssoc("SELECT * FROM `user_reg` WHERE `id`='" . $vybor_kontakt['id_kontakt'] . "' LIMIT 1");
$set_user_kontakt=_FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $user_kontakt['id'] . "' LIMIT 1");
echo'</div><div class="mini-line"></div><div class="block_zero"><img src="images/flags/'.$set_user_kontakt['side'].'.png"  alt="Флаг"/> <a href="view.php?smotr='.$user_kontakt['id'].'">'.$user_kontakt['login'].'</a>';
if(isset($_GET['del']) AND $_GET['del']=='kontakt'){
           $id_kontakt=_NumFilter($_GET['id_kontakt']);
           mysql_query("DELETE FROM `mail_kontakt` WHERE `id_kontakt` = '".$id_kontakt."' AND `id_user` = '".$user_id."'");
           $_SESSION['ok'] = 'Контакт удалён!';
           header("Location: mail.php?case=kontakt");
           exit();
           }
           echo'<span style="float: right;"><a class="btn" href="mail.php?case=kontakt&del=kontakt&id_kontakt='.$user_kontakt['id'].'"><span class="end"><span class="label"><span class="dred">Удалить</span></span></span></a></span>';
$i++;
}
echo '</div><div class="mini-line"></div><div class="block_zero center">';
        if ($_GET['page'] > 0) {
            echo '<small><b><a href="mail.php?case=kontakt&page=' . $back . '"><< Вперёд </a></small></b>';
        }
        if (empty($_GET['page']) || $_GET['page'] == 0 || $_GET['page'] < $puslap) {
            echo '<small><b><a href="mail.php?case=kontakt&page=' . $next . '"> Назад >></a></small></b>';
        }
echo'</div></div>';
break;

case 'post':
if (isset($_POST['send'])) {
    $data_id=_NumFilter($_GET['log']);
    $name = _TextFilter($_POST['login']);
    $text = _TextFilter($_POST['text']);            
    $kontakt=_FetchAssoc("SELECT `id` FROM `user_reg` WHERE `login`='" . $name . "' LIMIT 1");
    $verify_gamer = mysql_query("SELECT COUNT(`id`) FROM `user_reg` WHERE `login`='" . $name . "'");
    	if ($set['block']==1 && $kontakt['id'] != 1) {
    	$_SESSION['err']='В блоке можно писать только админу';
    	header("Location: blok.php");
    	exit();
    	}
        if (strlen($name) == strlen($kontakt['user'])) {
            $_SESSION['err'] = 'Длина никнейма 3-15 символов!';
            header('Location: mail.php?case=post');
            exit();
        }
        if (strlen($text) < 1 OR strlen($text) > 1500) {
            $_SESSION['err'] = 'Длина сообщения 1-1500 символов.';
            header('Location: mail.php?case=post&log='.$data_id.'');
            exit();
        }
        $veryfy_ignor = _NumRows("SELECT * FROM `mail_ignor` WHERE `id_ignor`='" . $user_id . "' AND `id_user`='" . $kontakt['id'] . "'");
        if($veryfy_ignor) {
        $_SESSION['err'] = 'Вы в игноре у этого игрока!';
            header('Location: mail.php?case=post&log='.$data_id.'');
            exit();
        }
        if($name==$user['login']) {
        $_SESSION['err'] = 'Вы пытаетесь написать самому себе!';
            header('Location: mail.php?case=post');
            exit();
        }
        if (mysql_result($verify_gamer, 0) > 0) {
        mysql_query("INSERT INTO `mail` SET `komu`='" . _NumFilter($kontakt['id']). "', `kto`='".$user_id."', `text`='".$text."', `date`='".$dater."', `time`='".$timer."'");
        $data_dialog=_NumRows("SELECT * FROM `mail_dialog` WHERE `id_user`='" . $user_id . "' AND `id_dialog`='" . _NumFilter($kontakt['id']). "' OR `id_dialog`='" . $user_id . "' AND `id_user`='" . _NumFilter($kontakt['id']). "' LIMIT 1");
        if(!$data_dialog){
        mysql_query("INSERT INTO `mail_dialog` SET `id_user`='".$user_id."', `id_dialog`='" . _NumFilter($kontakt['id']). "'");
        }
        $data_plus_dialog=_FetchAssoc("SELECT * FROM `mail_dialog` WHERE `id_user`='" . $user_id . "' AND `id_dialog`='" . _NumFilter($kontakt['id']). "' OR `id_dialog`='" . $user_id . "' AND `id_user`='" . _NumFilter($kontakt['id']). "' LIMIT 1");
        if($data_plus_dialog['id_dialog']==$user_id){
        mysql_query("UPDATE `mail_dialog` SET `status2`='0' WHERE `id_user`='"._NumFilter($kontakt['id'])."' AND `id_dialog`='".$user_id."'");
        }else{
        mysql_query("UPDATE `mail_dialog` SET `status`='0' WHERE `id_user`='".$user_id."' AND `id_dialog`='"._NumFilter($kontakt['id'])."'");
        mysql_query("UPDATE `mail_dialog` SET `status2`='1' WHERE `id_dialog`='"._NumFilter($kontakt['id'])."' AND `id_user`='".$user_id."'");
        $_SESSION['ok'] = 'Сообщение отправлено!';
        header('Location: mail.php?case=post&log='.$data_id.'');
        exit();
        }
    } else {
    $_SESSION['err'] = 'Такой игрок не зарегистрирован!';
    header('Location: mail.php?case=post');
    exit();
    }
}
if(isset($_GET['log'])){
$data_id=_NumFilter($_GET['log']);
$login=_FetchAssoc("SELECT `login` FROM `user_reg` WHERE `id`='" . $data_id . "' LIMIT 1");
echo'</div><div class="mini-line"></div><div class="block_zero center"><form action="mail.php?case=post&log='.$data_id.'" method="post">Введите никнейм:<input class="text large" type="text" name="login" value="'.$login['login'].'"/><br/>Текст сообщения:<br/><textarea class="text large" type="text" name="text" rows="5" cols="50" placeholder=""/></textarea><br/><span class="btn"><span class="end"><input class="label" type="submit" name="send" value="Отправить"></span></span> </a></form>';
if (empty($_GET['page']) || $_GET['page'] == 0 || $_GET['page'] < 0) {
            $_GET['page'] = 0;
        }
        $next = _NumFilter($_GET['page'] + 1);
        $back = $_GET['page'] - 1;
        $num  = $_GET['page'] * 10;
        if ($_GET['page'] == 0) {
            $i = 1;
        } else {
            $i = ($_GET['page'] * 10) + 1;
        }
        $viso   = _NumRows("SELECT * FROM `mail` WHERE `kto`='" . $user_id . "' AND `komu`='" . $data_id . "' OR `kto`='" . $data_id . "' AND `komu`='" . $user_id . "'");
        $puslap = floor($viso / 10);
$data_msg=mysql_query("SELECT * FROM `mail` WHERE `kto`='" . $user_id . "' AND `komu`='" . $data_id . "' OR `kto`='" . $data_id . "' AND `komu`='" . $user_id . "' ORDER BY `id` DESC LIMIT $num, 10");
while($user_msg=mysql_fetch_assoc($data_msg)){
if($user_msg['kto']==$user_id){
$user_message['login']=$user['login'];
$set_user_message['side']=$set['side'];
$set_user_message['lvl']=$set['lvl'];
}else{
$user_message=_FetchAssoc("SELECT * FROM `user_reg` WHERE `id`='" . $user_msg['kto'] . "' LIMIT 1");
$set_user_message=_FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $user_message['id'] . "' LIMIT 1");
}
echo'</div><div class="mini-line"></div><div class="block_zero"><img src="images/flags/'.$set_user_message['side'].'.png"  alt="Флаг"/> Ур. '.$set_user_message['lvl'].' <a href="view.php?smotr='.$user_msg['kto'].'">'.$user_message['login'].'</a><span style="float: right;"><small><span style="color: #9c9;">'.$user_msg['date'].' в '.$user_msg['time'].'</span></small></span><br/>'.$user_msg['text'].'<br/>';
if($user_msg['kto']==$user_id AND $user_msg['status']==0){
echo'<small><span style="color: #c66;">(Не прочитано)</span></small>';
}
mysql_query("UPDATE `mail` SET `status`='1' WHERE `komu`='" . $user_id . "' AND `kto`='" . $user_msg['kto'] . "'");
mysql_query("UPDATE `mail_dialog` SET `status`='1' WHERE `id_dialog`='" . $user_id . "' AND `id_user`='" . $user_msg['kto'] . "'");
mysql_query("UPDATE `mail_dialog` SET `status2`='1' WHERE `id_user`='" . $user_id . "' AND `id_dialog`='" . $user_msg['kto'] . "'");
$i++;
}
echo '</div><div class="mini-line"></div><div class="block_zero center">';
        if ($_GET['page'] > 0) {
            echo '<small><b><a href="mail.php?case=post&log='.$data_id.'&page=' . $back . '"><< Вперёд </a></small></b>';
        }
        if (empty($_GET['page']) || $_GET['page'] == 0 || $_GET['page'] < $puslap) {
            echo '<small><b><a href="mail.php?case=post&log='.$data_id.'&page=' . $next . '"> Назад >></a></small></b>';
        }
}else{
echo'</div><div class="mini-line"></div><div class="block_zero center">Введите никнейм:<form action="mail.php?case=post" method="post"><input class="text large" type="text" name="login"/>Текст сообщения:<br/><textarea class="text large" type="text" name="text" rows="5" cols="50" placeholder=""/></textarea><br/><span class="btn"><span class="end"><input class="label" type="submit" name="send" value="Отправить"></span></span> </a></form>';
}
echo'</div></div>';
break;

case 'ignor':
if (isset($_POST['send'])) {
            $name = _TextFilter($_POST['login']);
            $ignor=_FetchAssoc("SELECT `id` FROM `user_reg` WHERE `login`='" . $name . "'");
            $verify_gamer = mysql_query("SELECT COUNT(`id`) FROM `user_reg` WHERE `login`='" . $name . "'");
            $verify_login = mysql_query("SELECT COUNT(`id`) FROM `mail_ignor` WHERE `id_user`='" . $user_id . "' AND `id_ignor`='" . _NumFilter($ignor['id']) . "'");
            if (strlen($name) < 3 OR strlen($name) > 15) {
                $_SESSION['err'] = 'Длина никнейма 3-15 символов.';
                header('Location: mail.php?case=ignor');
                exit();
            }
            if($name==$user['login']){
            $_SESSION['err'] = 'Вы пытаетесь добавить самого себя!';
                header('Location: mail.php?case=ignor');
                exit();
            }
            if (mysql_result($verify_gamer, 0) > 0) {
            if (mysql_result($verify_login, 0) > 0) {
        $_SESSION['err'] = 'Такой игрок уже в игноре!';
        header('Location: mail.php?case=ignor');
        exit();
        }else{
            mysql_query("INSERT INTO `mail_ignor` SET `id_ignor`='" . _NumFilter($ignor['id']). "', `id_user`='".$user_id."'");
        $_SESSION['ok'] = 'Игрок '.$name.'<br/>добавлен в игнор!';
        header('Location: mail.php?case=ignor');
        exit();
        }
        }else{
        $_SESSION['err'] = 'Такой игрок не зарегистрирован!';
        header('Location: mail.php?case=ignor');
        exit();
        }
}
echo'</div><div class="mini-line"></div><div class="block_zero center">Введите никнейм:<form action="mail.php?case=ignor" method="post"><input class="text large" type="text" name="login"/><br/><span class="btn"><span class="end"><input class="label" type="submit" name="send" value="Добавить"></span></span> </a></form>';
if (empty($_GET['page']) || $_GET['page'] == 0 || $_GET['page'] < 0) {
            $_GET['page'] = 0;
        }
        $next = _NumFilter($_GET['page'] + 1);
        $back = $_GET['page'] - 1;
        $num  = $_GET['page'] * 10;
        if ($_GET['page'] == 0) {
            $i = 1;
        } else {
            $i = ($_GET['page'] * 10) + 1;
        }
        $viso   = _NumRows("SELECT * FROM `mail_ignor` WHERE `id_user`='" . $user_id . "'");
        $puslap = floor($viso / 10);
$data_ignor=mysql_query("SELECT * FROM `mail_ignor` WHERE `id_user`='" . $user_id . "' ORDER BY `id` ASC LIMIT $num, 10");
while($vybor_ignor=mysql_fetch_assoc($data_ignor)){
$user_ignor=_FetchAssoc("SELECT * FROM `user_reg` WHERE `id`='" . $vybor_ignor['id_ignor'] . "' LIMIT 1");
$set_user_ignor=_FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $user_ignor['id'] . "' LIMIT 1");
echo'</div><div class="mini-line"></div><div class="block_zero"><img src="images/flags/'.$set_user_ignor['side'].'.png"  alt="Флаг"/> <a href="view.php?smotr='.$user_ignor['id'].'">'.$user_ignor['login'].'</a>';
if(isset($_GET['del']) AND $_GET['del']=='ignor'){
           $id_ignor=_NumFilter($_GET['id_ignor']);
           mysql_query("DELETE FROM `mail_ignor` WHERE `id_ignor` = '".$id_ignor."' AND `id_user` = '".$user_id."'");
           $_SESSION['ok'] = 'Игнор удалён!';
           header("Location: mail.php?case=ignor");
           exit();
           }
           echo'<span style="float: right;"><a class="btn" href="mail.php?case=ignor&del=ignor&id_ignor='.$user_ignor['id'].'"><span class="end"><span class="label"><span class="dred">Удалить</span></span></span></a></span>';
$i++;
}
echo '</div><div class="mini-line"></div><div class="block_zero center">';
        if ($_GET['page'] > 0) {
            echo '<small><b><a href="mail.php?case=ignor&page=' . $back . '"><< Вперёд </a></small></b>';
        }
        if (empty($_GET['page']) || $_GET['page'] == 0 || $_GET['page'] < $puslap) {
            echo '<small><b><a href="mail.php?case=ignor&page=' . $next . '"> Назад >></a></small></b>';
        }
echo'</div></div>';
break;

} */
require_once 'system/down.php';