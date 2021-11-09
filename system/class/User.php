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

    }

    /**
     * @param $user_id
     * @param $value
     * @return mixed
     */
    public function userBonus($value) {
        $data = (new SafeMySQL())->getRow("select * from user_bonus where id_user = ?i limit ?i", $this->userID(), 1);
        return $data[$value];
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

    public function exitReg() {
        setcookie("login", '', time()-3600);
        setcookie("pass", '', time()-3600);
        session_destroy();
        (new Site())->_location("index.php");
    }
}
$user = new User();