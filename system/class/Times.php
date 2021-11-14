<?php
class Times {
    /**
     * @param int $time
     * @return string
     */
    public static function timeHours($time = 0) {
        $h = floor($time / 60 / 60);
        $i = floor($time / 60) - $h * 60;
        $s = $time - $h * 60 * 60 - $i * 60;
        $h = (strlen($h) == 1 ? '0' . $h : $h);
        $i = (strlen($i) == 1 ? '0' . $i : $i);
        $s = (strlen($s) == 1 ? '0' . $s : $s);
        $out = "{$h}:{$i}:{$s}";
        return $out;
    }

    /**
     * @param $i
     * @return string
     */
    public static function timeInDate($i) {
        $d  = floor($i / 86400);
        $h  = floor(($i / 3600) - $d * 24);
        $m  = floor(($i - $h * 3600 - $d * 86400) / 60);
        $s  = $i - ($m * 60 + $h * 3600 + $d * 86400);
        $h = ($h > 0 ? ($h < 10 ? '0':'').$h:'00');
        $m = ($m > 0 ? ($m < 10 ? '0':'').$m:'00');
        $s = ($s > 0 ? ($s < 10 ? '0':'').$s:'00');
        if ($d > 0) {
            $result = "$d д $h:$m:$s";
        } elseif ($h > 0) {
            $result = "$h:$m:$s";
        } elseif($m > 0) {
            $result = "$m:$s";
        } elseif($s > 0) {
            $result = "$s сек";
        }
        return $result;
    }

    public static function setDate() {
        return (new Filter())->clearFullSpecialChars(date("d.m.Y"));
    }

    public static function setTime() {
        return (new Filter())->clearFullSpecialChars(date("H:i:s"));
    }
}