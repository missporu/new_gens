<?php

class RegUser
{
    /**
     * @var string|null
     */
    protected ?string $login = null;

    /**
     * @var string|null
     */
    private ?string $pass;
    public int $user_alliance;
    private $user_id;
    private false|null|array $user;

    public function __construct()
    {
        if (isset($_COOKIE['login']) && isset($_COOKIE['IDsess'])) {
            if (!empty(trim(string: $_COOKIE['login'])) && !empty(trim(string: $_COOKIE['IDsess']))) {
                $this->login = trim(string: Filter::clearFullSpecialChars(string: $_COOKIE['login']));
                $this->pass = trim(string: Filter::clearFullSpecialChars(string: $_COOKIE['IDsess']));
            }
        } else {
            $this->login = null;
            $this->pass = null;
        }
        if ($this->userID()) {
            $this->getUser();
        }
        if ($this->getUser() == true) {
            $this->user_alliance = Filter::clearInt(string: (new SafeMySQL())->getOne("select count(id) from alliance_user where kto = ?i OR s_kem = ?i", $this->userID(), $this->userID()));

            (new SafeMySQL())->query("update users set online = ?i where id = ?i limit ?i", time(), $this->userID(), 1);
        }
    }

    protected function userID()
    {
        if (isset($this->login) and isset($this->pass)) {
            $users = (new SafeMySQL())->getOne("select count(id) from users where login = ?s and pass = ?s limit ?i", $this->login, $this->pass, 1);
            if ($users == 1) {
                $this->user_id = (new SafeMySQL())->getRow("select id from users where login = ?s and pass = ?s limit ?i", $this->login, $this->pass, 1);
                return Filter::clearInt(string: $this->user_id['id']);
            } else {
                return null;
            }
        }
    }

    /**
     * @return bool
     */
    public function getUser(): bool
    {
        if (is_numeric(value: $this->userID()) || $this->userID() <> null) {
            return true;
        } else return false;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function user($key): mixed
    {
        if ($this->getUser() == true) {
            $this->user = (new SafeMySQL())->getRow("select $key from users where id = ?i limit ?i", $this->userID(), 1);
            return $this->user[$key];
        }
    }

    /**
     * @return int
     */
    public function setUserBonus(): int
    {
        $bon = (new SafeMySQL())->getOne("select count(id) from user_bonus where id_user = ?i limit ?i", $this->user(key: 'id'), 1);
        return Filter::clearInt(string: $bon);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function userBonus($value): mixed
    {
        if ($this->setUserBonus() == 1) {
            $data = (new SafeMySQL())->getRow("select * from user_bonus where id_user = ?i limit ?i", $this->userID(), 1);
            return $data[$value];
        } else {
            (new SafeMySQL())->query("insert into user_bonus set time = ?i, id_user = ?i, status_day = ?i, last_date = ?s", time(), $this->user(key: 'id'), 1, Times::setDate());
            Site::_location(location: '?');
        }
    }

    public function _Reg()
    {
        if ($this->getUser() == false) {
            Site::session_empty(type: 'error', text: "Вы не авторизованы!", location: "index");
        }
    }

    public function _noReg()
    {
        if ($this->getUser() == true) {
            Site::_location(location: "menu");
        }
    }

    /**
     * @param $timeDay
     */
    public function addAitomaticBlock($timeDay)
    {
        (new SafeMySQL())->query("update users set block = ?i, block_time = ?i where id = ?i limit ?i", 1, (time() + (60 * 60 * 24 * $timeDay)), $this->userID(), 1);
    }

    /**
     * @return bool
     */
    public function getBlock(): bool
    {
        if ($this->user(key: 'block_time') > time()) {
            return true;
        } else {
            return false;
        }
    }


    public function setBan()
    {
        if ($this->user(key: 'ban_time') < time()) {
            return true;
        } else return false;
    }

    public function getBan()
    {
        if ($this->setBan() == false) {
            echo "Вы забанены администрацией проекта! Осталось " . Times::timeHours($this->user('ban_time') - time());
            return false;
        }
        return true;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addMoney($key, $value)
    {
        try {
            $addMoney = $this->user(key: $key) + $value;
            $addMoney = round(num: Filter::clearInt(string: $addMoney));
            if ($addMoney > 999999999) {
                throw new Exception(message: "Вы превысили лимит (999999999)");
            }
            (new SafeMySQL())->query("update users set $key = ?i where login = ?s limit ?i", $addMoney, $this->user(key: 'login'), 1);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param $userID
     */
    public function add_narushenie($userID)
    {
        (new SafeMySQL())->query("update users set narushenie = narushenie + ?i where id = ?i", 1, $userID);
    }

    public function addNarushenieAdmin($userID)
    {
        (new SafeMySQL())->query("update users set narushenie_admin = narushenie_admin + ?i where id = ?i", 1, $userID);
    }

    /**
     * @param $text
     * @param $type
     * @param $admin
     */
    public function UserErrorEnterFromModer($text, $type, $admin)
    {
        if ($this->user(key: 'dostup') <= $admin) {
            (new Site())->errorLog($this->user(key: 'name'), $text, $type);
            $this->add_narushenie($this->user(key: 'id'));
            Site::session_empty(type: 'error', text: "Запрет входа. Админ получил письмо. Бан выехал", location: "menu");
        }
    }

    /**
     * <====  Выход  ====>
     */
    public function exitReg()
    {
        (new SafeMySQL())->query("update users set online = ?i where id = ?i limit ?i", 0, $this->userID(), 1);
        setcookie(name: "login", value: '', expires_or_options: time() - 3600);
        setcookie(name: "IDsess", value: '', expires_or_options: time() - 3600);
        session_destroy();
        Site::_location(location: "index");
    }

    /**
     * @param $value
     * @return bool
     */
    public function mdAmdFunction($value): bool
    {
        if ($this->user(key: 'prava') > $value) {
            return true;
        } else return false;
    }

    public static function allOnline() {
        return (new SafeMySQL())->getOne("select count(id) from users where online > ?i", time() - 600);
    }
}