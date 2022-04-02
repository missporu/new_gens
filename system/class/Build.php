<?php
/*
 * Copyright (c) 2022.
 * Autor: misspo
 * Site: misspo.ru
 * Phone: +7 (919) 48-10-550
 * E-mail: misspo.ru@gmail.com
 */

class Build {
    public function __construct() {}

    public function userBuildUp() {
        (new SafeMySQL())->query("update build_user set lvl = ?i where time_stroy < ?i", 1, time());
    }

    public static function echoKey($name) {
        if (!is_null($name)) {
            return $name;
        }
    }

    public static function returnKey($name) {
        if ($name != null) {
            $name = $name / 60 / 60;
            $name = number_format($name, 5, '.', ',');
            $echo = "({$name} в сек)";
            return $echo;
        }
    }
}