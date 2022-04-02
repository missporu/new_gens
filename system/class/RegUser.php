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

    public function __construct() {
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

            $this->onlineUpdate();

            $this->buildFarmBaks();
            $this->buildFarmSilver();
            $this->buildFarmNeft();
            $this->buildFarmGaz();
        }
    }

    protected function userID() {
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
    public function getUser(): bool {
        if (is_numeric(value: $this->userID()) || $this->userID() <> null) {
            return true;
        } else return false;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function user($key): mixed {
        if ($this->getUser() == true) {
            $this->user = (new SafeMySQL())->getRow("select $key from users where id = ?i limit ?i", $this->userID(), 1);
            return $this->user[$key];
        }
    }

    protected function onlineUpdate() {
        (new SafeMySQL())->query("update users set online = ?i where id = ?i limit ?i", time(), $this->userID(), 1);
    }

    protected function buildFarmBaks() {
        if (time() > $this->user('build_up_baks')) {
            $build_up = $this->user('build_up_baks');
            if ($build_up == 0) $build_up = time() - 1;
            $dohod_up = Filter::clearInt(time() - $build_up);
            if ($dohod_up >= 1) {
                $dohod_baks = $this->user('baks_up') * $dohod_up;
                if ($dohod_baks >= 1) {
                    (new SafeMySQL())->query("update users set baks = baks+?i, build_up_baks = ?i where id = ?i", $dohod_baks, time(), $this->userID());
                }
            }
        }
    }

    protected function buildFarmSilver() {
        if (time() > $this->user('build_up_silver')) {
            $build_up = $this->user('build_up_silver');
            if ($build_up == 0) $build_up = time() - 1;
            $dohod_up = Filter::clearInt(time() - $build_up);
            if ($dohod_up >= 1) {
                $dohod_silver = $this->user('silver_up') * $dohod_up;
                if ($dohod_silver >= 1) {
                    (new SafeMySQL())->query("update users set silver = silver+?i, build_up_silver = ?i where id = ?i", $dohod_silver, time(), $this->user('id'));
                }
            }
        }
    }

    protected function buildFarmNeft() {
        if (time() > $this->user('build_up_neft')) {
            $build_up = $this->user('build_up_neft');
            if ($build_up == 0) $build_up = time() - 1;
            $dohod_up = Filter::clearInt(time() - $build_up);
            if ($dohod_up >= 1) {
                $dohod_neft = $this->user('neft_up') * $dohod_up;
                if ($dohod_neft >= 1) {
                    (new SafeMySQL())->query("update users set neft = neft+?i, build_up_neft = ?i where id = ?i", $dohod_neft, time(), $this->userID());
                }
            }
        }
    }


    protected function buildFarmGaz() {
        if (time() > $this->user('build_up_gaz')) {
            $build_up = $this->user('build_up_gaz');
            if ($build_up == 0) $build_up = time() - 1;
            $dohod_up = Filter::clearInt(time() - $build_up);
            if ($dohod_up >= 1) {
                $dohod_gaz = $this->user('gaz_up') * $dohod_up;
                if ($dohod_gaz >= 1) {
                    (new SafeMySQL())->query("update users set gaz = gaz+?i, build_up_gaz = ?i where id = ?i", $dohod_gaz, time(), $this->userID());
                }
            }
        }
    }

    /**
     * $smotr_user = (new SafeMySQL())->getRow("select $value from users where $name = ?$prepare limit ?i", $key, 1);<br>
     * select * from users where login = ?s , Admin<br>
     * @param $name (where)
     * @param $prepare (s)
     * @param $key ($name = ...)
     * @param $value (select -> return)
     * @return mixed
     */
    public function smotr_user($name, $prepare, $key, $value) {
        $smotr_user = (new SafeMySQL())->getRow("select $value from users where $name = ?$prepare limit ?i", $key, 1);
        return $smotr_user[$value];
    }

    /**
     * @return int
     */
    public function setUserBonus(): int {
        $bon = (new SafeMySQL())->getOne("select count(id) from user_bonus where id_user = ?i limit ?i", $this->user(key: 'id'), 1);
        return Filter::clearInt(string: $bon);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function userBonus($value): mixed {
        if ($this->setUserBonus() == 1) {
            $data = (new SafeMySQL())->getRow("select * from user_bonus where id_user = ?i limit ?i", $this->userID(), 1);
            return $data[$value];
        } else {
            (new SafeMySQL())->query("insert into user_bonus set time = ?i, id_user = ?i, status_day = ?i, last_date = ?s", time(), $this->user(key: 'id'), 1, Times::setDate());
            Site::_location(location: '?');
        }
    }

    public function _Reg() {
        if ($this->getUser() == false) {
            Site::session_empty(type: 'error', text: "Вы не авторизованы!", location: "index");
        }
    }

    public function _noReg() {
        if ($this->getUser() == true) {
            Site::_location(location: "menu");
        }
    }

    /**
     * @param $timeDay
     */
    public function addAitomaticBlock($timeDay) {
        (new SafeMySQL())->query("update users set block = ?i, block_time = ?i where id = ?i limit ?i", 1, (time() + (60 * 60 * 24 * $timeDay)), $this->userID(), 1);
    }

    /**
     * @return bool
     */
    public function getBlock(): bool {
        if ($this->user(key: 'block_time') > time()) {
            return true;
        } else {
            return false;
        }
    }


    public function setBan() {
        if ($this->user(key: 'ban_time') < time()) {
            return true;
        } else return false;
    }

    public function getBan() {
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
    public function addMoney($key, $value) {
        try {
            $addMoney = $this->user(key: $key) + $value;
            $addMoney = round(num: Filter::clearInt(string: $addMoney));
            if ($addMoney > 9999999999) {
                $addMoney = 9999999999;
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
        if ($this->user(key: 'dostup') <= $admin) {
            (new Site())->errorLog($this->user(key: 'name'), $text, $type);
            $this->add_narushenie($this->user(key: 'id'));
            Site::session_empty(type: 'error', text: "Запрет входа. Админ получил письмо. Бан выехал", location: "menu");
        }
    }

    /**
     * <====  Выход  ====>
     */
    public function exitReg() {
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
    public function mdAmdFunction($value): bool {
        if ($this->user(key: 'prava') > $value) {
            return true;
        } else return false;
    }

    public static function allOnline() {
        return (new SafeMySQL())->getOne("select count(id) from users where online > ?i", time() - 600);
    }

    public $sumRaiting;
    public function setRaiting($id) {
        $ria = (new SafeMySQL())->getCol("select sum(raiting) from user_unit where id_user = ?i", $id);
        $this->sumRaiting = $ria[0];
        if ($this->sumRaiting == null)
            $this->sumRaiting = 0;
        return $this->sumRaiting;
    }

    public function getRaiting($id) {
        return $this->setRaiting($id);
    }

    public static function money() {
        return self::user(key: 'baks');
    }
}