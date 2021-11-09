<?php
class User {
    public $user = [];

    protected function setUser() {
        if (isset($_COOKIE['login']) AND isset($_COOKIE['pass'])) {
            $login = (new Filter())->clearFullSpecialChars($_COOKIE['login']);
            $pass = (new Filter())->clearFullSpecialChars($_COOKIE['pass']);
            $user = (new SafeMySQL())->getOne("select count(id) from users where login = ?s and pass = ?s limit ?i", $login, $pass, 1);
            if ($user == 1) return true;
            else return false;
        }
    }

    public function getUser() {
        if ($this->setUser() == true) {
            $user = (new SafeMySQL())->getRow("select * from users where login = ?s and pass = ?s limit ?i", $login, $pass, 1);
            return $this->user = $user;
        }
    }

    public function _noReg() {
        if($this->setUser() == true) {
            (new Site())->session_err("Добро пожаловать в игру!", "menu.php");
        }
    }

    public function _Reg() {
        if($this->setUser() == false){
            (new Site())->session_err("Вы не авторизованы!", "index.php");
        }
    }

    public function exitReg() {
        setcookie("login", '', time()-3600);
        setcookie("pass", '', time()-3600);
        session_destroy();
        (new Site())->_location("index.php");
    }
}
$user = new User();