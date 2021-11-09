<?php
class User {
    public $user = false;
    protected $login;
    private $pass;

    public function __construct() {
        $this->login = (new Filter())->clearFullSpecialChars($_COOKIE['login']);
        $this->pass = (new Filter())->clearFullSpecialChars($_COOKIE['IDsess']);
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
        if(is_numeric($this->userID())) {
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

    public function setUserBonus() {
        $bon = (new SafeMySQL())->getOne("select count(id) from user_bonus where id_user = ?i limit ?i", $this->user('id'), 1);
        return $bon;
    }

    /**
     * @param $user_id
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

    public function _noReg() {
        if($this->getUser() == true) {
            (new Site())->_location("menu.php");
        }
    }

    public function _Reg() {
        if($this->getUser() == false){
            (new Site())->session_err("Вы не авторизованы!", "index.php");
        }
    }

    public function add_narushenie($user) {
        (new SafeMySQL())->query("update users set narushenie = narushenie + ?i where login = ?s", 1, $user);
    }

    public function addMoney($value) {
        try {
            $addMoney = $this::user('money') + $value;
            $addMoney = round( (new Filter())->clearInt( $addMoney ) );
            if ($addMoney > 999999999) {
                throw new Exception("Вы превысили лимит (999999999)");
            }
            (new SafeMySQL())->query("update users set money = ?i where login = ?s limit ?i", $addMoney, $this::user('login'), 1);
        } catch (Exception $e) {
            echo $e->getMessage();
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