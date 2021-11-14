<?php

/**
 * Class User
 * Class Times
 * Просто чтобы на странице сработал шаблон
 * Все классы написаны за 5 минут и не явдяются продакшном
 * autor: misspo
 * phone: +79194810550
 * e-mail: misspo.ru@gmail.com
 *
 */
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

/**
 * Модаль на BS-3
 *
 */ ?>

<a class="btn btn-primary" data-toggle="modal" href="#modal-id">Trigger modal</a>
<div class="modal fade" id="modal-id">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                Modal body ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close
                </button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal --><?php

/**
 * Алерт BS-3
*/ ?>

<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Title!</strong> Alert body ...
</div>
</div>
