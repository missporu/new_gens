<?php
$title = "Вход";
require_once('./system/up.php');
$user->_noReg();

echo'<div class="cont">';

    if (isset($_POST['send'])) {
        $name = $filter->clearFullSpecialChars(trim($_POST['login']));
        $pass = md5($filter->clearFullSpecialChars($_POST['pass']));
        $sqli = $sql->getRow("select login, pass from users where login = ?s and pass = ?s limit ?i", $name, $pass, 1);

        if (empty($name) || trim($name) == "" || strlen(trim($name)) < 3) {
            $site->session_err("Не заполнено поле логин");
        }
        if (empty($pass) || trim($pass) == "" || strlen(trim($pass)) < 5) {
            $site->session_err("Не заполнено поле пароль");
        }
        if (!$sqli) {
            $site->session_err("Неверные данные");
        }
        setcookie('login', $name, time() + 86400 * 365, '/');
        setcookie('pass', $pass, time() + 86400 * 365, '/');
        $site->_location('bonus.php');
    } ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 form-login">
                <form class="form-horizontal" action="" method="post">
                    <div class="col-xs-12 text-center">
                        <span class="heading">АВТОРИЗАЦИЯ</span>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-1">
                            <label for="inputEmail"><i class="fa fa-user"></i></label>
                        </div>
                        <div class="col-xs-11">
                            <input type="login" class="form-control" id="inputEmail" name="login" placeholder="Логин">
                        </div>
                    </div>
                    <div class="form-group help">
                        <div class="col-xs-1">
                            <label for="inputPassword"><i class="fa fa-lock"></i></label>
                        </div>
                        <div class="col-xs-11">
                            <input type="password" class="form-control" id="inputPassword" name="pass" placeholder="Пароль">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <a href="rec.php"><font color=#0f0>Забыли пароль?</font></a>
                        </div>
                        <div class="col-xs-6">
                            <div class="col-xs-2">
                                <div class="main-checkbox">
                                    <input type="checkbox" value="none" id="checkbox1" name="check"/>
                                    <label for="checkbox1"></label>
                                </div>
                            </div>
                            <div class="col-xs-10">
                                <span class="text">Запомнить</span>
                            </div>
                        </div>
                        <div class="col-xs-offset-9 col-xs-3">
                            <button type="submit" class="btn btn-default" name="send">ВХОД</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><?
    if (isset($_SESSION['rec'])) {
        echo '' . $_SESSION['rec'] . '';
        $_SESSION['rec'] = NULL;
    } ?>
</div>
<div class="clearfix"></div><?
require_once('system/down.php');