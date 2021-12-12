<?php
$title = "Вход";
require_once './system/up.php';
$user = new RegUser();
$sql = new SafeMySQL();
$site = new Site();

$user->_noReg();

echo'<div class="cont">';
    if (isset($_POST['send'])) {
        $name = Filter::clearFullSpecialChars(string: trim(string: $_POST['login']));
        $pass = Filter::clearFullSpecialChars(string: $_POST['pass']);

        if (empty($name) || trim(string: $name) == "" || strlen(string: trim(string: $name)) < 3) {
            Site::session_empty(type: 'error', text: "Не заполнено поле логин");
        }

        if (empty($pass) || trim(string: $pass) == "" || strlen(string: trim(string: $pass)) < 5) {
            Site::session_empty(type: 'error', text: "Не заполнено поле пароль");
        }

        $usr = $sql->getRow("select pass, ip, login from users where login = ?s limit ?i", $name, 1);
        $hash = $usr['pass'];
        $pass_get = password_verify(password: $pass, hash: $hash);
        $ip = Site::getIp();

        if ($pass_get == TRUE and $name = $usr['login']) {
            setcookie(name: 'login', value: $name, expires_or_options: time() + 86400 * 365, path: '/');
            setcookie(name: 'IDsess', value: $hash, expires_or_options: time() + 86400 * 365, path: '/');
            Site::session_empty(type: 'info', text: "Добро пожаловать!<br>Текущий ip {$ip}, последний вход был с {$usr['ip']}", location: "menu.php");
        } else {
            $site->adminLog(kto: $_POST['login'], text: "пытался зайти на сайт {$pass}", type: 'admin1983');
            Site::session_empty(type: 'error', text: "Неверные данные");
        }
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
                            <? Site::linkToSiteAdd('', '', 'rec.php', 'Забыли пароль?') ?>
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
    </div>
</div>
<div class="clearfix"></div><?
require_once 'system/down.php';