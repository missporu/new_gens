<?php
$title='Восстановление пароля';
require_once('system/up.php');
_NoReg();
if(isset($_POST['send'])){
	$name=_TextFilter($_POST['login']);
		$email=_TextFilter($_POST['email']);
$verify_login=mysql_query("SELECT COUNT(`id`) FROM `user_reg` WHERE `login`='".$name."'");
$verify_email=mysql_query("SELECT COUNT(`id`) FROM `user_reg` WHERE `email`='".$email."'");
if(empty($name)) {
$_SESSION['err']='Введите логин';
header('Location: rec.php');
exit();
}elseif(mb_strlen($name)<3){
$_SESSION['err']='Логин короче 3 символов';
header('Location: rec.php');
exit();
}elseif(mb_strlen($name)>15){
$_SESSION['err']='Логин длинее 15 символов';
header('Location: rec.php');
exit();
}elseif(mysql_result($verify_login, 0)==0){
$_SESSION['err']='Такой логин не найден';
header('Location: rec.php');
exit();
}elseif(empty($email)){
$_SESSION['err']='Введите почтовый ящик';
header('Location: rec.php');
exit();
}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
$_SESSION['err']='Не правильно введён почтовый ящик';
header('Location: rec.php');
exit();
}elseif(mysql_result($verify_email, 0)==0){
$_SESSION['err']='Такой почтовый ящик не найден';
header('Location: rec.php');
exit();
}else{
	$new_pass=_GenCode(20);
$message="Вы запросили восстановление пароля на сайте ".$site." для учетной записи: ".$name." \n\nВаш новый пароль: ".$new_pass."\n\nС уважением, администрация сайта ".$site.".";
mail($email, "Восстановление пароля", $message, "From: ".$support."\r\n"."Reply-To: ".$support."\r\n"."X-Mailer: PHP/" . phpversion());
	$pass = md5(_TextFilter($new_pass));
mysql_query("UPDATE `user_reg` SET `pass`='".$pass."' WHERE `login`='".$name."' AND `email`='".$email."'");
$_SESSION['ok']='Новый пароль отправлен вам на почту';
header('Location: login.php');
exit();
}
}
if (isset($_SESSION['err'])){
echo '<div class="error center"><img src="images/icons/error.png"> '.$_SESSION['err'].'</div>';
$_SESSION['err']=NULL;
}
?>
<center><div class="hello"><span style="color:#739871;">Восстановление забытого пароля</center></div>




<div class="cont center">

<span style="color:#BCBCBC;">Введите свой Логин, почту, которую Вы указали в профиле.</a>




<form action="?" method="POST"> <placeholder="Логин"  <br />
<input class="text" name="login" placeholder="Логин"/>
<input class="text" name="email" placeholder="Почта"/>
<br/>
<button class="form_btn" type="submit" name="send" /> Выслать код восстановления <span class="form_btn_text"> </span></button></span></span></form><br/>

</div><div class="block_zero center">






<br><br><div class="small grey"><a href="rules.php"><font color=#AAA>Правила игры </a>  | © 2645.ru Rusalc 2015.</div></div></div>	








