<?php

use JetBrains\PhpStorm\NoReturn;

class Site {
    /**
     * @var string
     */
    public string $name = "Наследие войн";
    /**
     * @var string
     */
    public string $title = "";

    public $switch = null;

    public function __construct() {
        $siteStatus = (new SafeMySQL())->getRow("select * from setting_game where id = ?i", 1);
        try {
            if ($_SERVER['SCRIPT_NAME'] != '/index.php') {
                if ($siteStatus['site_status'] == 'off') {
                    throw new Exception(message: "Сайт закрыт!");
                }
            }
            if ($_SERVER['SCRIPT_NAME'] == '/reg.php') {
                if ($siteStatus['registration'] == 'off') {
                    throw new Exception(message: "Регистрация закрыта");
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

    public static function lineHrInContainer() { ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <hr>
                </div>
            </div>
        </div><?php
    }

    public static function PrintMiniLine() { ?>
        <div class="clearfix"></div>
        <div class="separ"></div>
        <div class="clearfix"></div><?php
    }

    public static function fileName() {
        $fileName = $_SERVER['PHP_SELF'];
        $fileName = explode(separator: '/', string: $fileName);
        return $fileName[1];
    }

    /**
     * @return mixed
     */
    public static function getDomen(): mixed {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * @return mixed
     */
    public static function getUserAgent(): mixed {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * @return mixed
     */
    public static function getScriptURI(): mixed {
        return $_SERVER['SCRIPT_URI'];
    }

    /**
     * @return mixed
     */
    public static function getServerAddrIP(): mixed {
        return $_SERVER['SERVER_ADDR'];
    }

    /**
     * @return string
     */
    public static function getServerAdmin(): string {
        $_SERVER['SERVER_ADMIN'] = "misspo.ru@gmail.com";
        return $_SERVER['SERVER_ADMIN'];
    }

    /**
     * @return string
     */
    public static function getIp(): string {
        $keys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'REMOTE_ADDR'
        ];
        foreach ($keys as $key) {
            if (!empty($_SERVER[$key])) {
                $array = explode(separator: ',', string: $_SERVER[$key]);
                $ip = trim(string: end(array: $array));
                if (filter_var(value: $ip, filter: FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public static function getBrowser(): mixed {
        return Filter::clearString($_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * @return mixed
     */
    public static function getHttpReferer(): mixed {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = Filter::clearFullSpecialChars(string: $_SERVER['HTTP_REFERER']);
        } else {
            $referer = Filter::clearFullSpecialChars(string: '//'.$_SERVER['HTTP_HOST']);
        }
        return $referer;
    }

    public function errorLog($kto, $text, $type) {
        (new SafeMySQL())->query("insert into logi set kto = ?s, text = ?s, gde = ?s, tip = ?s, r_time = ?s, r_date = ?s, soft = ?s, ip = ?s", $kto, $text, Site::fileName(), $type, Times::setTime(), Times::setDate(), Site::getUserAgent(), Site::getIp());
    }

    public function adminLog($kto, $text, $type) {
        (new SafeMySQL())->query("insert into admin_log set kto = ?s, text = ?s, gde = ?s, tip = ?s, r_time = ?s, r_date = ?s, soft = ?s, ip = ?s", $kto, $text, Site::fileName(), $type, Times::setTime(), Times::setDate(), Site::getUserAgent(), Site::getIp());
    }

    /**
     * @param string $type
     * @param string $text
     * @param string $location
     */
    public static function session_empty(string $type = "inf", string $text = "", string $location = "?") {
        if (!empty($text)) {
            $_SESSION[$type] = nl2br(string: $text);
        }
        Site::_location(location: $location);
    }

    /**
     * @param $location
     */
    #[NoReturn]
    public static function _location ($location) {
        header(header: "Location: " . Filter::clearFullSpecialChars(string: $location) . "");
        exit;
    }

    /**
     * @return mixed
     */
    public static function getDateRus(): mixed {
        $d = date(format: "d F");
        $d = str_replace(search: "January", replace: "января", subject: $d);
        $d = str_replace(search: "February", replace: "февраля", subject: $d);
        $d = str_replace(search: "March", replace: "марта", subject: $d);
        $d = str_replace(search: "April", replace: "апреля", subject: $d);
        $d = str_replace(search: "May", replace: "мая", subject: $d);
        $d = str_replace(search: "June", replace: "июня", subject: $d);
        $d = str_replace(search: "July", replace: "июля", subject: $d);
        $d = str_replace(search: "August", replace: "августа", subject: $d);
        $d = str_replace(search: "September", replace: "сентября", subject: $d);
        $d = str_replace(search: "October", replace: "октября", subject: $d);
        $d = str_replace(search: "November", replace: "ноября", subject: $d);
        $d = str_replace(search: "December", replace: "декабря", subject: $d);
        return Filter::clearString(string: $d);
    }

    public function lastDay() {
        $tomorrow  = mktime(hour: 0, minute: 0, second: 0, month: date(format: "m")  , day: date(format: "d")-1, year: date(format: "Y"));
        $lastmonth = mktime(hour: 0, minute: 0, second: 0, month: date(format: "m")-1, day: date(format: "d"), year: date(format: "Y"));
    }

    /**
     * @param array $class
     * @param string $dataToggle
     * @param string $link
     * @param string $text
     */
    public function linkToSiteAdd(array $class, string $dataToggle, string $link, string $text): void {
        foreach ($class as $item) {
            $item .= $item . " ";
        } ?>
        <a href="<?= $link ?>" class="<?= $item ?>" data-toggle="<?= $dataToggle ?>>"><?= $text ?></a><?php
    }

    public function getSwitch() {
        return $this->switch;
    }

    public function setSwitch($a) {
        $this->switch = isset($_GET[$a]) ? Filter::clearFullSpecialChars($_GET[$a]) : null;
    }

    /**
     * @param $class
     * @param $src
     * @param $alt
     */
    public static function returnImage($class, $src, $alt) { ?>
        <img class="img-responsive <?= $class ?>" src="images/<?= $src ?>" alt="<?= $alt ?>"><?php
    }

}