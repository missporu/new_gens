<?php
class User {

    /**
     * @var mixed
     */
    protected $v;

    /**
     * @var mixed
     */
    public $user;

    public function __construct() {
        $this->user = $this->getUser();
    }

    /**
     * @return bool
     */
    public function getBlock() {
        return true;
    }

    /**
     * @param int $v
     */
    private function setUser($v) {
        $this->v = $v;
    }

    /**
     * @return mixed
     */
    public function getUser() {
        return $this->v;
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