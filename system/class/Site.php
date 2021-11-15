<?php

class Site {
    /**
     * @var string
     */
    public string $name = "Наследие войн";
    /**
     * @var string
     */
    public string $title;

    public function __construct() {
        $siteStatus = (new SafeMySQL())->getRow("select * from setting_game where id = ?i", 1);
        try {
            if ($_SERVER['SCRIPT_NAME'] != '/index.php') {
                if ($siteStatus['site_status'] == 'off') {
                    throw new Exception("Сайт закрыт!");
                }
            }
            if ($_SERVER['SCRIPT_NAME'] == '/reg.php') {
                if ($siteStatus['registration'] == 'off') {
                    throw new Exception("Регистрация закрыта");
                }
            }
        } catch (Exception $e) { ?>
            <div class="text-center">
                <p style="color: red">
                    <?= $e->getMessage(); ?>
                </p>
            </div><?php
            exit();
        }
        $title = "";
        $this->title = $title;
    }

    public function lineHrInContainer() { ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <hr>
                </div>
            </div>
        </div><?php
    }

    public function PrintMiniLine() { ?>
        <div class="clearfix"></div>
        <div class="separ"></div>
        <div class="clearfix"></div><?php
    }

    public function fileName() {
        $fileName = $_SERVER['PHP_SELF'];
        $fileName = explode('/', $fileName);
        return $fileName[1];
    }

    /**
     * @return mixed
     */
    public function getDomen()
    {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * @return mixed
     */
    public function getUserAgent() {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * @return mixed
     */
    public function getScriptURI() {
        return $_SERVER['SCRIPT_URI'];
    }

    /**
     * @return mixed
     */
    public function getServerAddrIP() {
        return $_SERVER['SERVER_ADDR'];
    }

    /**
     * @return string
     */
    public function getServerAdmin() {
        $_SERVER['SERVER_ADMIN'] = "misspo.ru@gmail.com";
        return $_SERVER['SERVER_ADMIN'];
    }

    /**
     * @return string
     */
    public function getIp() {
        $keys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'REMOTE_ADDR'
        ];
        foreach ($keys as $key) {
            if (!empty($_SERVER[$key])) {
                $ip = trim(end(explode(',', $_SERVER[$key])));
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function getBrowser() {
        return $browser = (new Filter())->clearString($_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * @return mixed
     */
    public function getHttpReferer() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = (new Filter())->clearFullSpecialChars($_SERVER['HTTP_REFERER']);
        } else {
            $referer = (new Filter())->clearFullSpecialChars('//'.$_SERVER['HTTP_HOST']);
        }
        return $referer;
    }

    public function errorLog($kto, $text, $type) {
        (new SafeMySQL())->query("insert into logi set kto = ?s, text = ?s, gde = ?s, tip = ?s, r_time = ?s, r_date = ?s, soft = ?s, ip = ?s", $kto, $text, $this->fileName(), $type, $this->getTime(), $this->getDate(), $this->getUserAgent(), $this->getIp());
    }

    public function adminLog($kto, $text, $type) {
        (new SafeMySQL())->query("insert into admin_log set kto = ?s, text = ?s, gde = ?s, tip = ?s, r_time = ?s, r_date = ?s, soft = ?s, ip = ?s", $kto, $text, $this->fileName(), $type, $this->getTime(), $this->getDate(), $this->getUserAgent(), $this->getIp());
    }

    /**
     * @param string $text
     * @param string $location
     */
    public function session_inf($text = "", $location = "?") {
        if (!empty($text)) {
            $_SESSION['info'] = $text;
        }
        $this->_location($location);
    }

    /**
     * @param string $text
     * @param string $location
     */
    public function session_err($text = "", $location = "?") {
        if (!empty($text)) {
            $_SESSION['error'] = $text;
        }
        $this->_location($location);
    }

    /**
     * @param string $text
     * @param string $location
     */
    public function session_ok($text = "", $location = "?") {
        if (!empty($text)) {
            $_SESSION['ok'] = $text;
        }
        $this->_location($location);
    }

    /**
     * @param $location
     */
    public function _location ($location) {
        header("Location: ".$location."");
        exit;
    }

    /**
     * @return mixed
     */
    public function getTime() {
        return Times::setTime();
    }

    public static function getDate() {
        return Times::setDate();
    }

    public function getDateRus() {
        $d = date("d F");
        $d = str_replace("January","января",$d);
        $d = str_replace("February","февраля",$d);
        $d = str_replace("March","марта",$d);
        $d = str_replace("April","апреля",$d);
        $d = str_replace("May","мая",$d);
        $d = str_replace("June","июня",$d);
        $d = str_replace("July","июля",$d);
        $d = str_replace("August","августа",$d);
        $d = str_replace("September","сентября",$d);
        $d = str_replace("October","октября",$d);
        $d = str_replace("November","ноября",$d);
        $d = str_replace("December","декабря",$d);
        $dater = (new Filter())->clearString($d);
        return $dater;
    }

    public function lastDay() {
        $tomorrow  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
        $lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
    }
}