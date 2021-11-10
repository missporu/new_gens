<?php
class User {

    public function __construct() {

    }

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
            $value => 99999999999,
        );
        return $set[$value];
    }
}

class Times {
    /**
     * @param $time
     * @return mixed
     */
    public function timeHours($time) {
        return $time . " sec";
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