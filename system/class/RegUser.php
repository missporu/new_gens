<?php

class RegUser {

    /**
     * @var bool
     */
    public $user = false;

    /**
     * @var mixed
     */
    protected $login;

    /**
     * @var mixed
     */
    private $pass;

    /**
     * RegUser constructor.
     */

    public function __construct() {
        $this->login = (new Filter())->clearFullSpecialChars($_COOKIE['login']);
        $this->pass = (new Filter())->clearFullSpecialChars($_COOKIE['IDsess']);
        if($this->getUser() == true) {
            (new SafeMySQL())->query("update users set online = ?i where id = ?i limit ?i", time(), $this->userID(), 1);
        }
    }

    /**
     * @return mixed|null
     */
    protected function userID() {
        if (!empty($this->login) AND !empty($this->pass)) {
            $users = (new SafeMySQL())->getOne("select count(id) from users where login = ?s and pass = ?s limit ?i", $this->login, $this->pass, 1);
            if ($users == 1) {
                $this->user_id = (new SafeMySQL())->getRow("select id from users where login = ?s and pass = ?s limit ?i", $this->login, $this->pass, 1);
                return $this->user_id['id'];
            } else {
                return null;
            }
        }
    }

    /**
     * @return bool
     */
    public function getUser() {
        if(is_numeric($this->userID()) || $this->userID() <> null) {
            return true;
        } else return false;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function user($key) {
        if ($this->getUser() == true) {
            $this->user = (new SafeMySQL())->getRow("select $key from users where id = ?i limit ?i", $this->userID(), 1);
            return $this->user[$key];
        }
    }

    /**
     * @return false|mixed
     */
    public function setUserBonus() {
        $bon = (new SafeMySQL())->getOne("select count(id) from user_bonus where id_user = ?i limit ?i", $this->user('id'), 1);
        return $bon;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function userBonus($value) {
        if ($this->setUserBonus() == 1) {
            $data = (new SafeMySQL())->getRow("select * from user_bonus where id_user = ?i limit ?i", $this->userID(), 1);
            return $data[$value];
        } else {
            (new SafeMySQL())->query("insert into user_bonus set time = ?i, id_user = ?i, status_day = ?i, last_date = ?s", time(), $this->user('id'), 1, (new Site())->getDate());
            (new Site())->_location('?');
        }
    }

    public function _Reg() {
        if($this->getUser() == false){
            (new Site())->session_err("Вы не авторизованы!", "index.php");
        }
    }

    public function _noReg() {
        if($this->getUser() == true) {
            (new Site())->_location("menu.php");
        }
    }

    public function addAitomaticBlock($timeDay) {
        (new SafeMySQL())->query("update users set block = ?i, block_time = ?i where id = ?i limit ?i", 1, (time()+(60*60*24*$timeDay)), $this->userID(), 1);
    }

    public function getBlock() {
        if($this->user('block') == 1 && $this->user('block_time') > time()) {
            return true;
        } else {
            return false;
        }
    }

    public function setBan() {
        try {
            if($this->user('ban') == 1 && $this->user('ban_time') > time()) {
                throw new Exception('Вы забанены администрацией проекта!');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param $key
     * @param $value
     */
    public function addMoney($key, $value) {
        try {
            $addMoney = $this->user($key) + $value;
            $addMoney = round( (new Filter())->clearInt( $addMoney ) );
            if ($addMoney > 999999999) {
                throw new Exception("Вы превысили лимит (999999999)");
            }
            (new SafeMySQL())->query("update users set $key = ?i where login = ?s limit ?i", $addMoney, $this->user('login'), 1);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param $userID
     */
    public function add_narushenie($userID) {
        (new SafeMySQL())->query("update users set narushenie = narushenie + ?i where id = ?i", 1, $userID);
    }

    public function addNarushenieAdmin($userID) {
        (new SafeMySQL())->query("update users set narushenie_admin = narushenie_admin + ?i where id = ?i", 1, $userID);
    }

    /**
     * @param $text
     * @param $type
     * @param $admin
     */
    public function UserErrorEnterFromModer($text, $type, $admin) {
        if ($this->user('dostup') <= $admin) {
            (new Site())->errorLog($this->user('name'), $text, $type);
            $this->add_narushenie($this->user('id'));
            (new Site())->session_err("Запрет входа. Админ получил письмо. Бан выехал", "menu.php");
        }
    }

    /**
     * Выход
     */
    public function exitReg() {
        (new SafeMySQL())->query("update users set online = ?i where id = ?i limit ?i", 0, $this->userID(), 1);
        setcookie("login", '', time()-3600);
        setcookie("IDsess", '', time()-3600);
        session_destroy();
        (new Site())->_location("index.php");
    }

    /**
     * @param $value
     * @return bool
     */
    public function mdAmdFunction($value) {
        if($this->user('prava') > $value) {
            return true;
        }
    }
}