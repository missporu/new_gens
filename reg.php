<?php
$title = 'Регистрация';
require_once('system/up.php');
$user->_noReg();

if (isset($_POST['reg'])) {

    $gold = 10;
    $baks = 100;
    $userDoubleIp = $sql->getRow("select login, pass, email, ip from users where ip = ?s limit ?i", $site->getIp(), 1);
    /**
     * Рефералам
     */
    $referal = 0;
    if (isset($_POST['ref']) && !empty($_POST['ref'])) {
        $ref = $filter->clearFullSpecialChars($_POST['ref']);
        if (trim($ref) == "" || strlen(trim($ref)) < 3) {
            $ref = "";
        }
        if ($site->getIp() == $userDoubleIp['ip']) {
            $site->session_inf("Себя приглашать нельзя");
        }
        $referal = $sql->getRow("select id from users where login = ?s limit ?i", $ref, 1);
        $gold = 30;
        $baks = 300;
    }

    /**
     * Проверка имени
     */
    if (!empty($_POST['login'])) {
        if (strlen(trim($_POST['login'])) < 3 || trim($_POST['login']) == "") {
            $site->session_inf("Поле 'Имя' должно быть от 3х символов");
        }
        $name = trim($filter->clearFullSpecialChars($_POST['login']));
        if (is_numeric($name)) {
            $site->session_inf("В имени не могут быть только цифры");
        }
        $usr = $sql->getRow("select login from users where login = ?s limit ?i", $name, 1);
        if ($name == $usr['login']) {
            $site->session_inf("Это имя занято");
        }
    } else {
        $name = null;
        $site->session_inf("Не заполнено поле 'Логин'");
    }

    /**
     * Проверка паролей
     */
    if (!empty($_POST['pass']) || !empty($_POST['pass2'])) {
        if ($_POST['pass'] != $_POST['pass2']) {
            $site->session_inf("Пароли не совпадают!");
        }
        if (strlen($_POST['pass']) < 7 || trim($_POST['pass']) == "" || strlen($_POST['pass2']) < 7 || trim($_POST['pass2']) == "") {
            $site->session_inf("Поле 'Пароль' должно быть от 7 символов");
        }
        $pass2 = $filter->clearFullSpecialChars($_POST['pass2']);
        $pass = $filter->clearFullSpecialChars($_POST['pass']);
        $pass = password_hash($pass, PASSWORD_DEFAULT);
    } else {
        $pass = null;
        $site->session_inf("Не заполнено поле 'Пароль'");
    }

    if ($name == $pass) {
        $site->session_inf("Логин и пароль не должны совпадать");
    }

    /**
     * Проверка мыла на валидность
     */
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email_b = $filter->clearFullSpecialChars($_POST['email']);
        $usm = $sql->getRow("select email from users where email = ?s limit ?i", $email_b, 1);
        if ($email_b == $usm['email']) {
            $site->session_inf("Эта почта уже используется");
        }
    } else {
        $email_b = null;
        $site->session_inf("E-mail адрес указан неверно.");
    }
    $sex = $_POST['sex'];
    $sql->query("insert into users set login = ?s, pass = ?s, email = ?s, ip = ?s, browser = ?s, referal = ?i, refer = ?s, data_reg = ?s, time_reg = ?s, sex = ?s, prava = ?i, last_date_visit = ?s, last_time_visit = ?s, mesto = ?s, start = ?i, online = ?i, hp_up = ?i, mp_up = ?i, udar_up = ?i, skill = ?i, exp = ?i, lvl = ?i, gold = ?i, baks = ?i, baks_hran = ?i, raiting = ?i, diplomat = ?i, diplomat_max = ?i, diplomat_cena = ?i, zheton = ?i, uho = ?i, wins = ?i, loses = ?i, kills = ?i, dies = ?i, build_up = ?i, dohod = ?i, soderzhanie = ?i, chistaya = ?i, build_energy =?i, krit = ?i, uvorot = ?i, id_vrag = ?i, raiting_loses = ?i, raiting_wins = ?i, pomiloval = ?i, sanctions = ?i, sanction_status = ?i, donat_bonus = ?i, ofclub_veteran_time_up = ?i, ofclub_veteran_chislo = ?i, news = ?i, unit_hp = ?i, refer_gold = ?i, refer_baks = ?i, slovo = ?s", $name, $pass, $email_b, $site->getIp(), $site->getBrowser(), $referal['id'], $site->getHttpReferer(), $site->getDate(), $site->getTime(), $sex, 1, $site->getDate(), $site->getTime(), $site->fileName(), 0, time(), time(), time(), time(), 3, 0, 1, $gold, $baks, 0, 0, 2, 4, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, $_POST['pass2']);
    setcookie('login', $name, time() + 86400 * 365, '/');
    setcookie('IDsess', $pass, time() + 86400 * 365, '/');
    $site->session_inf("Регистрация прошла успешно! Приятной игры!", "bonus.php");
} else { ?>
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
require_once('system/down.php');