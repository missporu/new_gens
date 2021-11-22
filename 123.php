<?
/*
https://cloud.mail.ru/public/Lu1v/fGw6tQPhf<br>
function ddd(array $class = []) {
    foreach ($class as $item) {
        echo "{$item[0]}, ";
    }
}
ddd(array('a','v'));
*/



class Test1 {

    public function ars(): void
    {
        echo "!";
    }
}

class Test2 extends Test1 {
    /**
     * @var mixed
     */
    public $tt;

    /**
     * @return mixed
     */
    public function getTt(): mixed
    {
        return $this->tt;
    }

    /**
     * @param mixed $tt
     */
    public function setTt(mixed $tt): void
    {
        $this->tt = $tt;
    }
}
$f = new Test2();