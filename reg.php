<?php
$title = 'Регистрация';
require_once('system/up.php');
$user->_noReg();

if (isset($_POST['reg'])) {

    $userDoubleIp = $sql->getRow("select login, pass, email, ip from users where ip = ?s limit ?i", $site->getIp(), 1);
    /**
     * Рефералам
     */
    if (isset($_POST['ref'])) {
        $ref = $filter->clearFullSpecialChars($_POST['ref']);
        if (empty($ref) || trim($ref) == "" || strlen(trim($ref)) < 3) {
            $ref = "";
        }
        if ($site->getIp() == $userDoubleIp['ip']) {
            $site->session_err("Себя приглашать нельзя");
        }
    }

    /**
     * Проверка имени
     */
    if (!empty($_POST['login'])) {
        if (strlen(trim($_POST['login'])) < 3 || trim($_POST['login']) == "") {
            $site->session_err("Поле 'Имя' должно быть от 3х символов");
        }
        $name = trim($filter->clearFullSpecialChars($_POST['login']));
        if (is_numeric($name)) {
            $site->session_err("В имени не могут быть только цифры");
        }
        $usr = $sql->getRow("select login from users where login = ?s limit ?i", $name, 1);
        if ($name == $usr['login']) {
            $site->session_err("Это имя занято");
        }
    } else {
        $name = null;
        $site->session_err("Не заполнено поле 'Логин'");
    }

    /**
     * Проверка паролей
     */
    if (!empty($_POST['pass']) || !empty($_POST['pass2'])) {
        if ($_POST['pass'] != $_POST['pass2']) {
            $site->session_err("Пароли не совпадают!");
        }
        if (strlen($_POST['pass']) < 7 || trim($_POST['pass']) == "" || strlen($_POST['pass2']) < 7 || trim($_POST['pass2']) == "") {
            $site->session_err("Поле 'Пароль' должно быть от 7 символов");
        }
        $pass2 = $filter->clearFullSpecialChars($_POST['pass2']);
        $pass = $filter->clearFullSpecialChars($_POST['pass']);
        $pass = password_hash($pass, PASSWORD_DEFAULT);
    } else {
        $pass = null;
        $site->session_err("Не заполнено поле 'Пароль'");
    }

    if ($name == $pass) {
        $site->session_err("Логин и пароль не должны совпадать");
    }

    /**
     * Проверка мыла на валидность
     */
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email_b = $filter->clearFullSpecialChars($_POST['email']);
        $usm = $sql->getRow("select email from users where email = ?s limit ?i", $email_b, 1);
        if ($email_b == $usm['email']) {
            $site->session_err("Эта почта уже используется");
        }
    } else {
        $email_b = null;
        $site->session_err("E-mail адрес указан неверно.");
    }

} else {
    $ref = "";
    if (isset($_GET['ref'])) {
        $ref = $filter->clearFullSpecialChars($_GET['ref']);
    } ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 form-login">
                <form class="form-horizontal" action="" method="post">
                    <div class="col-xs-12 text-center">
                        <span class="heading">РЕГИСТРАЦИЯ</span>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-1 text-right">
                            <label for="inputLogin" data-toggle="tooltip" data-placement="top" title="Введите ваш ник в игре"><i class="fa fa-user"></i></label>
                        </div>
                        <div class="col-xs-11">
                            <input data-toggle="tooltip" data-placement="top" title="Введите ваш ник в игре" type="login" class="form-control" id="inputLogin" name="login" placeholder="Логин">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-1 text-right">
                            <label for="inputPassword" data-toggle="tooltip" data-placement="top" title="Введите пароль"><i class="fa fa-lock"></i></label>
                        </div>
                        <div class="col-xs-11">
                            <input data-toggle="tooltip" data-placement="top" title="Введите пароль" type="password" class="form-control" id="inputPassword" name="pass" placeholder="Пароль">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-1 text-right">
                            <label for="inputPassword2" data-toggle="tooltip" data-placement="top" title="Повторите пароль"><i class="fa fa-lock"></i> <i class="fa fa-lock"></i></label>
                        </div>
                        <div class="col-xs-11">
                            <input data-toggle="tooltip" data-placement="top" title="Повторите пароль" type="password" class="form-control" id="inputPassword2" name="pass2" placeholder="Повторите пароль">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-1 text-right">
                            <label data-toggle="tooltip" data-placement="top" title="E-mail" for="inputEmail"><i class="fa fa-envelope-o" aria-hidden="true"></i></label>
                        </div>
                        <div class="col-xs-11">
                            <input data-toggle="tooltip" data-placement="top" title="E-mail" type="email" class="form-control" id="inputEmail" name="email" placeholder="E-mail">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-1 text-right">
                            <label data-toggle="tooltip" data-placement="top" title="Пригласил в игру" for="inputReferal"><i class="fa fa-handshake-o" aria-hidden="true"></i></label>
                        </div>
                        <div class="col-xs-11">
                            <input data-toggle="tooltip" data-placement="top" title="Пригласил в игру" type="email" class="form-control" id="inputReferal" name="ref" placeholder="<?= $ref ?>" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-1 text-right">
                            <label for="sex">Пол</label>
                        </div>
                        <div class="col-xs-11">
                            <select name="sex" id="sex" class="form-control">
                                <option class="form-control" value="m">Парень</option>
                                <option class="form-control" value="w">Девушка</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <button type="submit" class="btn btn-md btn-default" name="reg">Регистрация</button>
                        </div>
                    </div>
                </form>
                <div class="clearfix"></div>
                <div class="separ"></div>
                <div class="col-xs-12 text-center">
                    <small class="text-info">
                        Нажимая кнопку <b class="text-info">"Регистрация"</b> вы автоматически принимаете <b><a class="text-info" href="good.php">правила</a></b> нашего сайта.
                    </small>
                </div>
                <div class="clearfix"></div>
                <div class="separ"></div>
            </div>
        </div>
    </div><?php
}
require_once('system/down.php'); /*


if (isset($_POST['send'])) {
    $name         = _TextFilter($_POST['login']);
    $pass         = _TextFilter($_POST['pass']);
    $repass       = _TextFilter($_POST['repass']);
    $sex          = _TextFilter($_POST['sex']);
    $email        = _TextFilter($_POST['email']);
    $verify_login = mysql_query("SELECT COUNT(`id`) FROM `user_reg` WHERE `login`='" . $name . "'");
    $verify_email = mysql_query("SELECT COUNT(`id`) FROM `user_reg` WHERE `email`='" . $email . "'");
    if (empty($name)) {
        $_SESSION['err'] = 'Введите логин';
        header('Location: reg.php');
        exit();
    } elseif (!preg_match('|^[a-z\s0-9\-]+$|i', $name)) {
        $_SESSION['err'] = 'Кириллица и символы в логине запрещены';
        header('Location: reg.php');
        exit();
    } elseif (mb_strlen($name) < 3) {
        $_SESSION['err'] = 'Логин короче 3 символов';
        header('Location: reg.php');
        exit();
    } elseif (mb_strlen($name) > 15) {
        $_SESSION['err'] = 'Логин длинее 15 символов';
        header('Location: reg.php');
        exit();
    } elseif (mysql_result($verify_login, 0) > 0) {
        $_SESSION['err'] = 'Такой логин уже занят';
        header('Location: reg.php');
        exit();
    } elseif (empty($pass)) {
        $_SESSION['err'] = 'Введите пароль';
        header('Location: reg.php');
        exit();
    } elseif (mb_strlen($pass) < 3) {
        $_SESSION['err'] = 'Пароль короче 3 символов';
        header('Location: reg.php');
        exit();
    } elseif (mb_strlen($pass) > 20) {
        $_SESSION['err'] = 'Пароль длинее 20 символов';
        header('Location: reg.php');
        exit();
    } elseif (!preg_match('|^[a-z0-9\-]+$|i', $pass)) {
        $_SESSION['err'] = 'Кириллица и символы в пароле запрещены';
        header('Location: reg.php');
        exit();
    } elseif ($name == $pass) {
        $_SESSION['err'] = 'Логин и пароль не должны совпадать';
        header('Location: reg.php');
        exit();
    } elseif (empty($repass)) {
        $_SESSION['err'] = 'Введите пароль ещё раз';
        header('Location: reg.php');
        exit();
    } elseif ($pass != $repass) {
        $_SESSION['err'] = 'Пароли не совпадают';
        header('Location: reg.php');
        exit();
    } elseif (empty($email)) {
        $_SESSION['err'] = 'Введите почтовый ящик';
        header('Location: reg.php');
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['err'] = 'Не правильно введён почтовый ящик';
        header('Location: reg.php');
        exit();
    } elseif (mysql_result($verify_email, 0) > 0) {
        $_SESSION['err'] = 'Такой почтовый ящик уже исспользуется';
        header('Location: reg.php');
        exit();
    } else {
        mysql_query("INSERT INTO `user_reg` SET `login`='" . $name . "', `pass`='" . md5($pass) . "', `email`='" . $email . "', `ip`='" . $ip . "', `browser`='" . $browser . "', `referer`='" . $referer . "', `refer`='" . $refer . "', `data_reg`='" . $dater . "', `time_reg`='" . $timer . "', `site`='" . $site . "'");
        if($refer>0){
        mysql_query("INSERT INTO `user_set` SET `sex`='" . $sex . "', `gold`='20'");
        }else{
        mysql_query("INSERT INTO `user_set` SET `sex`='" . $sex . "'");
        }
        mysql_query("UPDATE `user_set` SET `prava`='5' WHERE `id`='1' AND `prava`!='5'");
        setcookie('login', $name, time() + 86400 * 365, '/');
        setcookie('pass', md5($pass), time() + 86400 * 365, '/');
        header('Location: start.php');
        exit();
    }
}

<div class="hello center"><h1 class="yellow"><?=$title?>
</h1></div>
<div class="cont center"><form action="" method="post">Логин:<br/>
<input class="text" type="text" name="login" value=""/>
<br/>Пароль:<br/><input class="text" type="password" name="pass"/>
<br/>Повторите пароль:<br/><input class="text" type="password" name="repass"/>
<br/>Почта:<br/><input class="text" type="text" name="email"/>
<br/>Пол:<br><select name="sex"><option value="m">Парень</option><option value="w">Девушка</option></select><br/>
<br/>
<button class="form_btn" type="submit" name="send" /> Зарегистрировать<span class="form_btn_text"> </span></button></span></span></form><br/></div>
<br><br><div class="small grey center"><a href="rules.php"><font color=#AAA>Правила игры </a>  | misspo &copy; 2016 - <?=date("Y");?></div></div></div>	
</span></span></a></div></div></div><?
require_once('system/down.php');
?>
