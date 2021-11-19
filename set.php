<?php
$title = 'Настройки';
require_once('system/up.php');
$user->_Reg();

switch ($switch) {
    default: ?>
        <a href="set.php?a=nick">Сменить имя</a> |
        <a href="set.php?a=flag">Сменить флаг </a><?php
        break;

    case 'flag':
        echo "Смена флага";
        break;

    case 'nick':
        echo "Смена имени";
        break;
}

/*
if($set['logo'] == 'on'){
echo'<img src="images/logotips/set.jpg" width="100%" alt="logo"/>';
echo'<div class="mini-line"></div>';
}
if ($set['block']==1) {
	header("Location: blok.php");
	exit();
}
switch($_GET['case']){
default:
echo'<div class="main"><div class="menuList">';
echo'<li><a href="set.php?case=logotip"><img src="images/icons/arrow.png" alt="*"/>Большие картинки</a></li>';
echo'<li><a href="set.php?case=fon"><img src="images/icons/fon.png" alt="*"/>Фон игры</a></li>';
echo'<li><a href="set.php?case=status"><img src="images/icons/arrow.png" alt="*"/>Изменить статус</a></li>';
echo'<li><a href="set.php?case=nick"><img src="images/icons/arrow.png" alt="*"/>Изменить ник</a></li>';
echo'<li><a href="set.php?case=flag"><img src="images/icons/arrow.png" alt="*"/>Изменить флаг страны</a></li>';
echo'</div></div>';
break;
case 'logotip':
if(empty($_POST['logotip'])){
echo "<form action='set.php?case=logotip' method='POST'>";
echo'<div class="main"><div class="block_zero center">Показ больших картинок:';
echo'</div><div class="dot-line"></div><div class="block_zero center">';
if($set['logo'] == 'off'){
echo'<input type="radio" name="logotip" value="on" CHECKED> Включить<br/><br/><span class="btn"><span class="end"><input class="label" type="submit" value="Выполнить"></span></span></form></div></div>';
}else{
echo'<input type="radio" name="logotip" value="off" CHECKED> Отключить<br/><br/><span class="btn"><span class="end"><input class="label" type="submit" value="Выполнить"></span></span></form></div></div>';
}
}else{
$pan = _TextFilter($_POST['logotip']);
mysql_query("UPDATE `user_set` SET
`logo` =  '".$pan."' WHERE `id` = '".$user_id."' LIMIT 1");
$_SESSION['ok']="Настройки успешно изменены!";
header('Location: set.php?case=logotip');
exit();
}
echo'</div><div class="dot-line"></div><div class="main"><div class="block_zero"><a href="set.php"><span style="color: #999;"><< Назад</span></a></div></div>';
break;
case 'fon':
if(empty($_POST['fon'])){
echo "<form action='set.php?case=fon' method='POST'>";
echo'<div class="main"><div class="block_zero center">Фон игры: '.$cvet.'';
echo'</div><div class="dot-line"></div><div class="block_zero">';
echo'<input type="radio" name="fon" value="standart" CHECKED/> Стандартный<br/><br/><input type="radio" name="fon" value="blue"/> Синий<br/><br/><input type="radio" name="fon" value="green"/> Зелёный<br/><br/><input type="radio" name="fon" value="red"/> Красный<br/><br/><center><span class="btn"><span class="end"><input class="label" type="submit" value="Изменить"></span></span></form></div></div></center>';
}else{
$pan = _TextFilter($_POST['fon']);
mysql_query("UPDATE `user_set` SET `fon` =  '".$pan."' WHERE `id` = '".$user_id."' LIMIT 1");
$_SESSION['ok']="Настройки успешно изменены!";
header('Location: set.php?case=fon');
exit();
}
echo'</div><div class="dot-line"></div><div class="main"><div class="block_zero"><a href="set.php"><span style="color: #999;"><< Назад</span></a></div></div>';
break;
case 'status': ?>
<style>
	textarea {
		color: #000;
	}
</style><?
if ($_GET[mod]==save){

$ressave = mysql_query ("UPDATE `user_set` SET `status`='".$_POST[text]."' WHERE `id`='$user_id' LIMIT 1");
		 
$text = htmlspecialchars(addslashes($_POST['text']));

if (strlen($text)>255) { echo"<font color=#ff4040>Длиное сообщение!</font>";}else{

mysql_query ("UPDATE `user_set` SET
        status='".$text."' WHERE `id`='".$user_id."' LIMIT 1");}
		 
				if ($ressave == 'true')
					{
					echo '<font color=#f4d06e><p>Статус сохранён!</p></font>'; // удачно
					echo "<div class=news><font color=#ff4040>Некоторые изменения вступят в силу после обновления страници.</font></div>";
					}
					else
					{
					echo "<font color=#ff4040><p> Неудача ! </p></font>";  // неудачно =)
					}



} ?>
	<form action="?case=status&mod=save" method="post"><?
		echo 'Статус (255макс):
			<br/><textarea name="text" rows="3" maxlength="255">'.$set['status'].'</textarea><hr/>';


echo '<input class="button" type="submit" value="Сохранить" /></form>';

    break;

    case 'nick':
    if ($set['smena_nick'] > 0) {
        $new_cena_nick = $set['smena_nick']*50;
    } else {
        $new_cena_nick = 0;
    }
    $minus_cena = ($set['gold']-$new_cena_nick);
        if (isset($_POST['save_nick'])) {
            if ($minus_cena > $set['gold']) {
                $_SESSION['err'] = 'Недостаточно золота, вы можете пополнить счет';
                header('Location: bank.php?case=worldkassa');
                exit();
            }
            if (strlen($_POST['name'])<4) {
                $_SESSION['err'] = 'Имя должно быть больше 3х символов';
                header('Location: ?case=nick');
                exit();
            }
                $new_nick = $_POST['name'];
                mysql_query("UPDATE `user_set` SET `user`='".$_POST['name']."', `gold`='".$minus_cena."', `smena_nick`=`smena_nick`+1  WHERE `id`='".$set['id']."' LIMIT 1");
                mysql_query("UPDATE `user_reg` SET `login`='".$_POST['name']."' WHERE `id`='".$set['id']."' LIMIT 1");
                $_SESSION['ok'] = 'Поздравляем! Вы успешно изменили свое имя на '.$new_nick.' !';
                header('Location: ?case=nick_ex');
                exit();
        } else { ?>
            После смены ника необходимо будет перезайти в игру с уже новым именем. <br>
            Смена имени стоит <small style="color: #f00"><?= $new_cena_nick ?></small> золота. <br>
            <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
                Введите желаемое имя <br>
                <input type="text" name="name"><br>
                <input type="submit" name="save_nick" value="Сменить имя">
            </form><?php
        }
        break;

            case 'flag':
            if ($set['smena_flag'] > 0) {
                $new_cena_flag = $set['smena_flag']*100;
            } else {
                $new_cena_flag = 0;
            }
            $minus_cena = ($set['gold']-$new_cena_flag);
                if (isset($_POST['save_flag'])) {
                    if ($minus_cena > $set['gold']) {
                        $_SESSION['err'] = 'Недостаточно золота, вы можете пополнить счет';
                        header('Location: bank.php?case=worldkassa');
                        exit();
                    }
                    switch ($_POST['flag']) {
                        case 'r':
                            $new_flag = 'r';
                            break;
                        case 'g':
                            $new_flag = 'g';
                            break;
                        case 'a':
                            $new_flag = 'a';
                            break;
                        case 'u':
                            $new_flag = 'u';
                            break;
                        case 'b':
                            $new_flag = 'b';
                            break;
                        case 'c':
                            $new_flag = 'c';
                            break;
                        case 'k':
                            $new_flag = 'k';
                            break;
                        default:
$new_flag = 'r';
                            break;
                    }
                    mysql_query("UPDATE `user_set` SET `side`='".$new_flag."', `gold`='".$minus_cena."', `smena_flag`=`smena_flag`+1 WHERE `id`='".$set['id']."' LIMIT 1");
                    $_SESSION['ok'] = 'Вы успешно сменили флаг своей страны';
                    header('Location: pers.php');
                } else { ?>
                    Смена флага страны стоит <small style="color: #f00"><?= $new_cena_flag ?></small> золота. <br>
                    <form action="<?php echo $SCRIPT_NAME ?>" method="POST">
                        <p><input type="radio" name="flag" value="r">Россия (Вы – владыка морей. Бонус к силе военно-морского флота.
                        )</p>
                        <p><input type="radio" name="flag" value="g">Германия (Дисциплина – Ваше второе имя. Бонус к силе наземных войск.
                        )</p>
                        <p><input type="radio" name="flag" value="a">США (Небо - ваша стихия. Бонус к силе авиации.)</p>
                        <p><input type="radio" name="flag" value="u">Украина (Вы учитесь на ошибках, зарабатывая опыт быстрее всех.)</p>
                        <p><input type="radio" name="flag" value="b">Белоруссия (Благодаря мудрому руководству уровень жизни повышается.)</p>
                        <p><input type="radio" name="flag" value="c">Китай (Вы – промышленный гигант. Стоимость техники снижена.)</p>
                        <p><input type="radio" name="flag" value="k">Казахстан (Резко-континентальный климат дает Вам бонус к защите.)</p>
                        <input type="submit" name="save_flag" value="Сменить флаг">
                    </form><?php
                }
                break;
} */
require_once('system/down.php');