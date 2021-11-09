<?php
class Times {

    public function timeHours($time = 0)
    {
        $h = floor($time / 60 / 60);
        $i = floor($time / 60) - $h * 60;
        $s = $time - $h * 60 * 60 - $i * 60;
        $h = (strlen($h) == 1 ? '0' . $h : $h);
        $i = (strlen($i) == 1 ? '0' . $i : $i);
        $s = (strlen($s) == 1 ? '0' . $s : $s);
        $out = "{$h}:{$i}:{$s}";
        return $out;
    }
}
$times = new Times();