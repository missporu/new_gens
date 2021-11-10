<?php
class User {
    public function __construct() {}

    /**
     * @return bool
     */
    public function getBlock() {
        return true;
    }

    /**
     * @param $value
     * @return int
     */
    public function user($value): int
    {
        $set = array(
            $value => 1699999999,
        );
        return $set[$value];
    }
}

class Times {
    /**
     * @param $i
     * @return string
     */
    public function timeHours($i) {
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
}

$user = new User();
$times = new Times();

/**
 * Шаблон на страницы
 */
try {
    if($user->getBlock()) {
        throw new Exception('Вы заблокированы администрацией проекта!');
    }
} catch (Exception $e) { ?>
    <div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <h3 class="red">
                <?= $e->getMessage() ?>
            </h3>
            <p class="green">
                До автоматической разблокировки осталось <?= $times->timeHours($user->user('block_time') - time()) ?>
            </p>
        </div>
    </div>
    </div><?php
}