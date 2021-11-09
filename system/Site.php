<?php
class Site {
    public $name = "Наследие войн";
    public $title;

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
            <div style="text-align: center;">
                <p style="color: red">
                    <?= $e->getMessage(); ?>
                </p>
            </div><?php
            exit();
        }
        $this->title = $title;
    }

    public function fileName() {
        $fileName = $_SERVER['PHP_SELF'];
        $fileName = explode('/', $fileName);
        return $fileName[1];
    }

    protected function setDomen() {
        return $domen = $_SERVER['HTTP_HOST'];
    }

    public function getDomen()
    {
        return $this->setDomen();
    }

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

    public function getBrowser() {
        return $browser = (new Filter())->clearString($_SERVER['HTTP_USER_AGENT']);
    }

    public function getHttpReferer() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = (new Filter())->clearFullSpecialChars($_SERVER['HTTP_REFERER']);
        } else {
            $referer = (new Filter())->clearFullSpecialChars('//'.$_SERVER['HTTP_HOST']);
        }
        return $referer;
    }

    public function error_sess ($kto, $text, $tip) {
        global $sql;
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $gde = $_SERVER['SCRIPT_NAME'];
        $sql->query("insert into log set kto = ?s, text = ?s, gde = ?s, tip = ?s, r_time = ?s, r_date = ?s, soft = ?s, ip = ?s", $kto, $text, $gde, $tip, self::getTime(), self::getDate(), $agent, self::getIp());
    }


    public function session_err($text = "", $s = "?") {
        if (!empty($text)) {
            $_SESSION['err'] = $text;
        }
        $this->_location($s);
    }

    public function _location ($s) {
        header("Location: ".$s."");
        exit;
    }

    public function getTime() {
        return (new Filter())->clearFullSpecialChars(date("H:i:s"));
    }

    public function getDate() {
        return (new Filter())->clearFullSpecialChars(date("d.m.Y"));
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
}
$site = new Site();