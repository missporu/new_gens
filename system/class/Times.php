<?php

/*
 * Copyright (c) 2022.
 * Autor: misspo
 * Site: misspo.ru
 * Phone: +7 (919) 48-10-550
 * E-mail: misspo.ru@gmail.com
 */

use JetBrains\PhpStorm\Pure;

class Times
{
    /**
     * @param int $time
     * @return string
     */
    #[Pure] public static function timeHours(int $time = 0): string
    {
        $h = floor(num: $time / 60 / 60);
        $i = floor(num: $time / 60) - $h * 60;
        $s = $time - $h * 60 * 60 - $i * 60;
        $h = (strlen(string: $h) == 1 ? '0' . $h : $h);
        $i = (strlen(string: $i) == 1 ? '0' . $i : $i);
        $s = (strlen(string: $s) == 1 ? '0' . $s : $s);
        $times = "{$h}:{$i}:{$s}";
        return Filter::clearFullSpecialChars(string: $times);
    }

    /**
     * @param int $i
     * @return string
     */
    public static function timeInDate(int $i): string
    {
        $d = floor(num: $i / 86400);
        $h = floor(num: ($i / 3600) - $d * 24);
        $m = floor(num: ($i - $h * 3600 - $d * 86400) / 60);
        $s = $i - ($m * 60 + $h * 3600 + $d * 86400);
        $h = ($h > 0 ? ($h < 10 ? '0' : '') . $h : '00');
        $m = ($m > 0 ? ($m < 10 ? '0' : '') . $m : '00');
        $s = ($s > 0 ? ($s < 10 ? '0' : '') . $s : '00');
        if ($d > 0) {
            $result = "$d д $h:$m:$s";
        } elseif ($h > 0) {
            $result = "$h:$m:$s";
        } elseif ($m > 0) {
            $result = "$m:$s";
        } elseif ($s > 0) {
            $result = "$s сек";
        }
        return Filter::clearFullSpecialChars(string: $result);
    }

    #[Pure] public static function setDate(): mixed
    {
        return Filter::clearFullSpecialChars(string: date(format: "d.m.Y"));
    }

    #[Pure] public static function setTime(): mixed
    {
        return Filter::clearFullSpecialChars(string: date(format: "H:i:s"));
    }
}