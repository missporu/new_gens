<?php
require_once '../../system/system.php';
echo only_reg();
#-Отправка сообщения-#
switch($act){
case 'send':
if(isset($_POST['msg']) and isset($_GET['id'])){
$msg = check($_POST['msg']); //Сообщение
$id = check($_GET['id']); //Идентификатор
#-Проверяем данные-#
#-Сообщение-#
if(preg_match('/[\^\<\>\&\`\$]/',$_POST['msg'])) $error = 'Некорректное сообщение!';
if(mb_strlen($msg) < 1) $error = 'Напишите сообщение!';
if(mb_strlen($msg) > 5000) $error = 'Слишком длинное сообщение!';
if($user['id'] == $id) $error = 'Ошибка!';
if($user['ban'] != 0) $error = 'Наложена молчанка!';
if($user['level'] < 30) $error = 'Почта с 30 уровня!';

#-Выборка и проверка пользователя из БД-#
$sel_users = $pdo->prepare("SELECT * FROM `users` WHERE `id` = :id");
$sel_users->execute(array(':id' => $id)); 
if($sel_users-> rowCount() != 0){
$all = $sel_users->fetch(PDO::FETCH_LAZY); 

#-Проверка можем ли писать сообщения-#
if($all['ev_mail'] == 1){
$sel_friends = $pdo->prepare("SELECT * FROM `friends` WHERE (`friend_1` = :user_id AND `friend_2` = :all_id) OR (`friend_1` = :all_id AND `friend_2` = :user_id)");
$sel_friends->execute(array(':user_id' => $user['id'], ':all_id' => $all['id']));
if($sel_friends-> rowCount() == 0) $error = 'Только друзья!';
}

if($all['ev_mail'] == 2) $error = 'Писать сообщения запрещено!';

#-Проверяем в черном списке или нет-#	
$sel_ignor = $pdo->prepare("SELECT * FROM `ignor` WHERE `kto` = :all_id AND `kogo` = :user_id");
$sel_ignor->execute(array(':all_id' => $all['id'], ':user_id' => $user['id']));
if($sel_ignor-> rowCount() == 0){
	
#-Если нет ошибок-#
if(!isset($error)){
$ins_mail = $pdo->prepare("INSERT INTO `mail` SET `msg` = :msg, `send_id` = :send_id, `recip_id` = :recip_id, `time` = :time");	
$ins_mail->execute(array(':msg' => $msg, ':send_id' => $user['id'], ':recip_id' => $all['id'], ':time' => time()));
#-Есть ли переписка или нет-#
$sel_mail_k = $pdo->prepare("SELECT * FROM `mail_kont` WHERE `user_id` = :user_id AND `kont_id` = :all_id");
$sel_mail_k->execute(array(':all_id' => $all['id'], ':user_id' => $user['id']));
if($sel_mail_k-> rowCount() == 0){
$ins_mail_k1 = $pdo->prepare("INSERT INTO `mail_kont` SET `new` = :new, `user_id` = :user_id, `kont_id` = :kont_id, `time` = :time");	
$ins_mail_k1->execute(array(':new' => 0, ':user_id' => $user['id'], ':kont_id' => $all['id'], ':time' => time()));
}else{
$upd_mail_m = $pdo->prepare("UPDATE `mail_kont` SET `time` = :time WHERE `user_id` = :user_id AND `kont_id` = :kont_id");	
$upd_mail_m->execute(array(':time' => time(), ':kont_id' => $all['id'], ':user_id' => $user['id']));
}

$sel_mail_k2 = $pdo->prepare("SELECT * FROM `mail_kont` WHERE `user_id` = :all_id AND `kont_id` = :user_id");
$sel_mail_k2->execute(array(':all_id' => $all['id'], ':user_id' => $user['id']));
if($sel_mail_k2-> rowCount() == 0){
$ins_mail_k2 = $pdo->prepare("INSERT INTO `mail_kont` SET `new` = :new, `user_id` = :kont_id, `kont_id` = :user_id, `time` = :time");	
$ins_mail_k2->execute(array(':new' => 1, ':kont_id' => $all['id'], ':user_id' => $user['id'], ':time' => time()));	
}else{
$upd_mail_k = $pdo->prepare("UPDATE `mail_kont` SET `new` = :new, `time` = :time WHERE `user_id` = :kont_id AND `kont_id` = :user_id");	
$upd_mail_k->execute(array(':time' => time(), ':new' => 1, ':kont_id' => $all['id'], ':user_id' => $user['id']));
}
header("Location: /mail_write/$all[id]");
exit();
}else{
header("Location: /mail_write/$all[id]");
$_SESSION['err'] = $error;
exit();
}
}else{
header("Location: /mail_write/$all[id]");
$_SESSION['err'] = 'Вы в черном списке!';
exit();
}
}else{
header("Location: /mail");
$_SESSION['err'] = 'Игрок не найден!';
exit();
}
}else{
header("Location: /mail_write/$all[id]");
$_SESSION['err'] = 'Данные не переданы!';
exit();
}
}

#-Черный список-#
switch($act){
case 'ignor':
if(isset($_GET['id'])){
$id = check($_GET['id']); //Идентификатор
if(isset($_GET['redicet'])){ 
$redicet = check($_GET['redicet']);
}else{
$redicet = "/mail_write/$id";	
}
#-Идентификатор-#
if(!preg_match('/^[0-9]+$/u',$_GET['id'])) $error = 'Ошибка идентификатора!';
if($user['id'] == $id) $error = 'Ошибка!';
#-Выборка и проверка пользователя из БД-#
$sel_users = $pdo->prepare("SELECT * FROM `users` WHERE `id` = :id");
$sel_users->execute(array(':id' => $id)); 
if($sel_users-> rowCount() != 0){
$all = $sel_users->fetch(PDO::FETCH_LAZY); 	
#-Если нет ошибок-#
if(!isset($error)){
#-Проверяем есть ли в черном списке-#
$sel_ignor = $pdo->prepare("SELECT * FROM `ignor` WHERE `kto` = :user_id AND `kogo` = :all_id");
$sel_ignor->execute(array(':user_id' => $user['id'], ':all_id' => $all['id'])); 
if($sel_ignor-> rowCount() == 0){	
#-Добавление-#
$ins_ignor = $pdo->prepare("INSERT INTO `ignor` SET `kto` = :user_id, `kogo` = :all_id, `time` = :time");	
$ins_ignor->execute(array(':user_id' => $user['id'], ':all_id' => $all['id'], ':time' => time()));
}else{
#-Удаление-#
$del_ignor = $pdo->prepare("DELETE FROM `ignor` WHERE `kto` = :user_id AND `kogo` = :all_id");	
$del_ignor->execute(array(':user_id' => $user['id'], ':all_id' => $all['id']));	
}
header("Location: $redicet");
exit();
}else{
header("Location: $redicet");
$_SESSION['err'] = $error;
exit();
}
}else{
header("Location: /mail");
$_SESSION['err'] = 'Игрок не найден!';
exit();
}
}else{
header("Location: $redicet");
$_SESSION['err'] = 'Данные не переданы!';
exit();
}
}

#-Очистка сообщений-#
switch($act){
case 'clear':
if(isset($_GET['id'])){
$id = check($_GET['id']); //Идентификатор
if(!preg_match('/^[0-9]+$/u',$_GET['id'])) $error = 'Ошибка идентификатора!';
if($user['id'] == $id) $error = 'Ошибка!';
#-Если нет ошибок-#
if(!isset($error)){
#-Выборка данных собеседника-#
$sel_users = $pdo->prepare("SELECT `id` FROM `users` WHERE `id` = :id");
$sel_users->execute(array(':id' => $id)); 
$all = $sel_users->fetch(PDO::FETCH_LAZY);

#-Есть ли беседа с этим игроком-#
$sel_mail_k = $pdo->prepare("SELECT * FROM `mail_kont` WHERE `user_id` = :user_id AND `kont_id` = :all_id OR `user_id` = :all_id AND `kont_id` = :user_id");
$sel_mail_k->execute(array(':all_id' => $all['id'], ':user_id' => $user['id']));
if($sel_mail_k-> rowCount() != 0){
#-Очищаем историю сообщений-#
$del_mail_k = $pdo->prepare("DELETE FROM `mail_kont` WHERE `user_id` = :user_id AND `kont_id` = :kont_id");	
$del_mail_k->execute(array(':user_id' => $user['id'], ':kont_id' => $all['id']));	
}

#-Выборка сообщений с этим собеседником-#
$sel_mail = $pdo->prepare("SELECT * FROM `mail` WHERE `send_id` = :user_id AND `recip_id` = :all_id OR `send_id` = :all_id AND `recip_id` = :user_id");
$sel_mail->execute(array(':user_id' => $user['id'], ':all_id' => $all['id']));
if($sel_mail->rowCount() != 0){

#-Очищаем сообщения-#
if($mail['clear_1'] == 0){
$upd_mail = $pdo->prepare("UPDATE `mail` SET `clear_1` = :user_id WHERE `send_id` = :user_id AND `recip_id` = :all_id OR `send_id` = :all_id AND `recip_id` = :user_id");
$upd_mail->execute(array(':user_id' => $user['id'], ':all_id' => $all['id']));
}else{
if($mail['clear_1'] == $user['id']){
$upd_mail = $pdo->prepare("UPDATE `mail` SET `clear_1` = :user_id WHERE `send_id` = :user_id AND `recip_id` = :all_id OR `send_id` = :all_id AND `recip_id` = :user_id");
$upd_mail->execute(array(':user_id' => $user['id'], ':all_id' => $all['id']));
}else{
$upd_mail = $pdo->prepare("UPDATE `mail` SET `clear_2` = :user_id WHERE `send_id` = :user_id AND `recip_id` = :all_id OR `send_id` = :all_id AND `recip_id` = :user_id");
$upd_mail->execute(array(':user_id' => $user['id'], ':all_id' => $all['id']));
}
}
}
header("Location: /mail_write/$all[id]");
exit();
}else{
header("Location: /mail_write/$all[id]");
$_SESSION['err'] = $error;
exit();
}
}else{
header('Location: /mail');
$_SESSION['err'] = 'Данные не переданы!';
exit();
}
}

#-Очистка всей почты-#
switch($act){
case 'clear_all':
#-Делаем выборку переписок с нашим игроком-#
$sel_mail_k = $pdo->prepare("SELECT * FROM `mail_kont` WHERE `user_id` = :user_id");
$sel_mail_k->execute(array(':user_id' => $user['id']));
if($sel_mail_k-> rowCount() != 0){
#-Удаляем переписки-#
$del_mail_k = $pdo->prepare("DELETE FROM `mail_kont` WHERE `user_id` = :user_id");
$del_mail_k->execute(array(':user_id' => $user['id']));
#-Выборка всех сообщений игрока-#
$sel_mail = $pdo->prepare("SELECT * FROM `mail` WHERE `send_id` = :user_id OR `recip_id` = :user_id");
$sel_mail->execute(array(':user_id' => $user['id']));
while($mail = $sel_mail->fetch(PDO::FETCH_LAZY)){
if($mail['clear_1'] == 0){
$upd_mail = $pdo->prepare("UPDATE `mail` SET `clear_1` = :user_id WHERE `id` = :mail_id");
$upd_mail->execute(array(':user_id' => $user['id'], ':mail_id' => $mail['id']));	
}else{
if($mail['clear_1'] == $user['id']){
$upd_mail = $pdo->prepare("UPDATE `mail` SET `clear_1` = :user_id WHERE `id` = :mail_id");
$upd_mail->execute(array(':user_id' => $user['id'], ':mail_id' => $mail['id']));	
}else{
$upd_mail = $pdo->prepare("UPDATE `mail` SET `clear_2` = :user_id WHERE `id` = :mail_id");
$upd_mail->execute(array(':user_id' => $user['id'], ':mail_id' => $mail['id']));	
}
}	
}
header('Location: /mail');
exit();
}else{
header('Location: /mail');
exit();
}
}
?>