<?
$title = 'Продукция';
define('H', $_SERVER['DOCUMENT_ROOT'] . '/');
require H . "system/up.php";
_Reg();
if ($set['block'] == 1) {
    header("Location: /blok.php");
    exit();
}
if ($ref[0]) {
    echo '<div class="menuList">
    <li><a href="?"><img src="//gmisspo.ru/images/icons/arrow.png" alt="*"/>Продукция</a></li></div><div class="mini-line">
    </div>';
}
if ($ref[0] == 'mine' and $ref[1]) {
    echo '<div class="menuList">
    <li><a href="?mine"><img src="//gmisspo.ru/images/icons/arrow.png" alt="*"/>Шахты</a></li></div><div class="mini-line">
    </div>';
}
if (!$ref[0]) {
    echo '<div class="menuList">
        <li><a href="?mine"><img src="//gmisspo.ru/images/icons/arrow.png" alt="*"/>Шахты</a></li>
        <li><a href="prod.php"><img src="//gmisspo.ru/images/icons/arrow.png" alt="*"/>Старые шахты (продажа)</a></li>
        </div><div class="mini-line">
    </div>';
}
if ($ref[0] == 'mine') {
    if ($set[lvl] < 55) {
        echo "<div class='col-md-12 text-center'>
        <div class='main'>
            <div class='block_zero center'>
                <span style='color: #9cc;'>
                    Доступно с 55 уровня.
            </div>
            <div class='clearfix'></div>
            <div><hr></div>";
    } else {
        $wah = $sql->getAll("SELECT * FROM production WHERE user_id = ?i AND typ = ?i ORDER BY id ASC", $user_id, 1);
        $wah_count = count($wah);
        $wah_up = $wah_count + 1;
        if ($wah_count == true) {
            $gld = 250;
            for ($i = 1; $i <= $wah_count; $i++) {
                $gld = $gld + $gld;
            }
        } else {
            $gld = 0;
        }
        if ($gld == 0) {
            $sum = "бесплатно";
        } else {
            $sum = "за <img src='/images/icons/gold.png' alt='Gold'/> " . number_format_short($gld) . "";
        }

        $bax = $set['lvl'] * 50000;
        $sum2 = "за <img src='//gmisspo.ru//images/icons/baks.png' alt='Baks'/> " . number_format_short($bax) . "";
        if (!$ref[1]) {
            echo '<div class="menuList">
    <li><a href="?mine:log"><img src="//gmisspo.ru/images/icons/arrow.png" alt="*"/>Журнал шахтёра</a></li></div><div class="mini-line">
    </div>';
            $i = 0;
            foreach ($wah as $w) {
                $i++;
                echo "<div class='col-md-12 text-center'><hr>

        <div class='main row'>
        <div class='block_zero center'><span style='color: #9cc;''>
        Участок $i
        </span></div><div class='mini-line'></div>";
                if ($w[status] == 0) {
                    if ($w[data] == 0) {
                        echo "<div class='col-xs-4'><img src='//gmisspo.ru/images/shah1.jpg' alt='' class='img-responsive'></div><div class='col-xs-8'>
                Нужно заложить фундамент";
                        echo "<div class='block_zero center'>
                <a class='btn btn-primary btn-xs active' href='?mine:build:$w[id]'>Начать строительство $sum2</a></div></div>
                <div class='mini-line'></div>";
                    } else {
                        echo "<img src='//gmisspo.ru/images/shah2.jpg' alt='' class='img-responsive'>
                Идёт строительство шахты (фундамент)<br/>Осталось : " . _Time($w[data] - time()) . "";

                    }
                }
                if ($w[status] == 1) {
                    if ($w[data] == 0) {
                        echo "<div class='col-xs-4'><img src='//gmisspo.ru/images/shah2.jpg' alt='' class='img-responsive'></div><div class='col-xs-8'>
                Нужно установить каркас";
                        echo "<div class='block_zero center'>
                <a class='btn btn-primary btn-xs active' href='?mine:build:$w[id]'>Начать строительство $sum2</a></div></div>
                <div class='mini-line'></div>";
                    } else {
                        echo "<div class='col-xs-4'><img src='//gmisspo.ru/images/shah2.jpg' alt='' class='img-responsive'></div><div class='col-xs-8'>
                Идёт строительство шахты (каркас)<br/>Осталось : " . _Time($w[data] - time()) . "</div>";
                    }
                }
                if ($w[status] == 2) {
                    if ($w[data] == 0) {
                        echo "<div class='col-xs-4'><img src='//gmisspo.ru/images/shah2.jpg' alt='' class='img-responsive'></div><div class='col-xs-8'>
                Нужно завершить строительство";
                        echo "<div class='block_zero center'>
                <a class='btn btn-primary btn-xs active' href='?mine:build:$w[id]'>Начать строительство $sum2</a></div></div>
                <div class='mini-line'></div>";
                    } else {
                        echo "<div class='col-xs-4'><img src='//gmisspo.ru/images/shah2.jpg' alt='' class='img-responsive'></div><div class='col-xs-8'>
                Идёт строительство шахты (завершение)<br/>Осталось : " . _Time($w[data] - time()) . "</div>";
                    }
                }
                if ($w[status] == 3) {
                    echo "<div class='col-xs-4'><img src='//gmisspo.ru/images/shah3.jpg' alt='' class='img-responsive'></div><div class='col-xs-8'>
                    Золото : (" . ($w[gold] - $w[gold_a]) . "/$w[gold])<br/>Прочность : (" . ($w[hp] - $w[hp_a]) . "/$w[hp])<br/>";
                    if ($w[timer] > 0) {
                        echo "Для работы доступно : $w[timer] минут.";
                    } else {
                        echo "Сегодня вы больше не можете разрабатывать шахту";
                    }
                    if ($w[data] == 0) {
                        if ($w[timer] > 0) {
                            echo "<FORM ACTION='?mine:work:$w[id]' METHOD='POST'>
                            <select name='timer'>
                            <option value='1'>10 минут</option>
                            <option value='2'>20 минут</option>
                            <option value='3'>30 минут</option>
                            <option value='4'>40 минут</option>
                            <option value='5'>60 минут</option>
                            <option value='6'>90 минут</option>
                            </select><input type='submit' value='Спуститься в шахту'>
                            </FORM>";
                        }
                    } else {
                        echo "<br/>Идёт разработка шахты<br/>Осталось : " . _Time($w[data] - time()) . "";
                    }
                    echo "</div>";
                }
                if ($w[status] == 4) {
                    if ($w[data] == 0) {
                        echo "<div class='col-xs-4'><img src='//gmisspo.ru/images/shah5.jpg' alt='' class='img-responsive'></div><div class='col-xs-8'>
                    Ваша шахта исчерпала свой ресурс.<br/>Нужно заложить фундамент для новой";
                        echo "<div class='block_zero center'>
                    <a class='btn btn-primary btn-xs active' href='?mine:build:$w[id]'>Начать строительство $sum2</a></div></div>
                    <div class='mini-line'></div>";
                    }
                }
                if ($w[status] == 5) {


                }
                echo "</div><div class='clearfix'></div></div><hr>";
            }
            echo "<div class='col-md-12 text-center'><hr>

    <div class='main'><div class='block_zero center'><span style='color: #9cc;'>
    Участок $wah_up
    </span></div><div class='mini-line'></div>

    <img src='//gmisspo.ru/images/shah1.jpg' alt='' class='img-responsive'>

    Участок продаётся.Чем больше участков ,<br/>тем больше золота можно добывать одновременно!

    <div class='block_zero center'>
    <a class='btn btn-primary btn-xs active' href='?mine:buy'>Купить участок $sum</a></div>
    <div class='mini-line'></div>

    </div><div class='clearfix'></div><div><hr>";

        }
        if ($ref[1] == 'buy') {
            if ($set['gold'] >= $gld) {
                if ($ref[2] != 'ok') {
                    echo "<div class='col-md-12 text-center'><hr>

        <div class='main'><div class='block_zero center'><span style='color: #9cc;'>
        Участок $wah_up
        </span></div><div class='mini-line'></div></div>

        Действительно хотите купить участок?
        <br/>
        <div class='block_zero center'>
        <a class='btn btn-primary btn-xs active' href='?mine:buy:ok'>Да,купить $sum</a></div>
        <div class='mini-line'></div>

        </div><div class='clearfix'></div><hr>";
                } else {
                    $sql->query("INSERT INTO production SET user_id=?s,typ=?i,num=?i", $user_id, 1, $wah_up);
                    $sql->query("UPDATE user_set SET gold=gold-?i WHERE id=?i", $gld, $set[id]);
                    header('Location: ?mine');
                }
            } else {
                echo "У вас недостаточно <img src='/images/icons/gold.png' alt='Gold'/>";
            }
        }
        if ($ref[1] == 'build') {
            if ($set['baks'] >= $bax) {
                $aki = $sql->getRow("SELECT * FROM production WHERE id=?i AND user_id=?i AND typ=?i", $ref[2], $user_id, 1);
                if (!$aki or $aki[data] != 0) {
                    header('Location: ?mine');
                } else {
                    if ($ref[3] != 'ok') {
                        echo "<div class='col-md-12 text-center'><hr>
        <div class='main'><div class='block_zero center'><span style='color: #9cc;'>
        Участок $aki[num]
        </span></div><div class='mini-line'></div></div>
        Действительно хотите начать строительство?
        <br/>
        <div class='block_zero center'>
        <a class='btn btn-primary btn-xs active' href='?mine:build:$ref[2]:ok'>Да,начать $sum2</a></div>
        <div class='mini-line'></div>

        </div><div class='clearfix'></div><hr>";
                    } else {
                        switch ($aki[status]) {
                            case 0:
                                $nam = 'фундамент';
                                break;
                            case 1:
                                $nam = 'каркас';
                                break;
                            case 2:
                                $nam = 'завершение';
                                break;
                            case 4:
                                $nam = 'фундамент';
                                break;
                        }
                        if ($aki[status] == 4) {
                            $stt = 0;
                        } else {
                            $stt = $aki[status];
                        }
                        $text = "Начато строительство ($nam) шахты , на участке $aki[num]";
                        $sql->query("INSERT INTO production_logs SET user_id=?s,typ=?i,text=?s,data=?i", $user_id, 1, $text, time());
                        $sql->query("UPDATE production SET data=data+?i,status=?i WHERE id=?i AND user_id=?i AND typ=?i", (time() + 86400), $stt, $ref[2], $user_id, 1);
                        $sql->query("UPDATE user_set SET baks=baks-?i WHERE id=?i", $bax, $set[id]);
                        header('Location: ?mine');
                    }
                }
            } else {
                echo "У вас недостаточно <img src='//gmisspo.ru//images/icons/baks.png' alt='Baks'/>";
            }
        }
        if ($ref[1] == 'log') {
            $rec = $sql->getOne("SELECT count(id) from production_logs WHERE user_id=?i and typ=?i", $user_id, 1);
            $sum = 10;
            $page = $ref[2];
            $get = "mine:log";
            $posts = $rec;
            $total = (($posts - 1) / $sum) + 1;
            $total = intval($total);
            $page = intval($page);
            if (empty($page) or $page < 0) $page = 1;
            if ($page > $total) $page = $total;
            $start = $page * $sum - $sum;
            $r = $sql->getAll("SELECT * FROM production_logs WHERE  user_id=?i and typ=?i ORDER BY id DESC LIMIT ?i,?i", $user_id, 1, $start, $sum);
            foreach ($r as $m) {

                echo "[" . _Time(time() - $m['data']) . "] $m[text]<hr>";

            }
            put($page, $get, $total);
        }
        if ($ref[1] == 'work') {
            $aki = $sql->getRow("SELECT * FROM production WHERE id=?i AND user_id=?i AND typ=?i", $ref[2], $user_id, 1);
            if (!$aki or $aki[data] != 0 or $aki[status] != 3 or $aki[hp] == 0) {
                header('Location: ?mine');
            } else {
                $tmr = $_POST['timer'];
                if ($tmr < 1 or $tmr > 6 or !$tmr) {
                    $tmr = 1;
                }
                switch ($tmr) {
                    case 1:
                        $tm = 600;
                        $tm2 = 10;
                        break;
                    case 2:
                        $tm = 1200;
                        $tm2 = 20;
                        break;
                    case 3:
                        $tm = 1800;
                        $tm2 = 30;
                        break;
                    case 4:
                        $tm = 2400;
                        $tm2 = 40;
                        break;
                    case 5:
                        $tm = 3600;
                        $tm2 = 60;
                        break;
                    case 6:
                        $tm = 5400;
                        $tm2 = 90;
                        break;
                }
                if ($aki[timer] >= $tm2) {
                    $gl = round((($aki[gold] / 30) / 90) * $tm2);

                    if ($aki[hp_a] >= 29) {
                        $gl = ($aki[gold] - $aki[gold_a]);
                    }


                    $bx = 4500;
                    for ($i = 1; $i <= $set['lvl']; $i++) {
                        $bx = $bx * 1.2;
                    }

                    $bx = round((($bx / 30) / 90) * $tm2);

                    $text = "Шахтёры начали разработку Участка $aki[num] , время разработки $tm2 минут.";
                    $sql->query("INSERT INTO production_logs SET user_id=?s,typ=?i,text=?s,data=?i", $user_id, 1, $text, time());
                    $sql->query("UPDATE production SET data=data+?i,hp_a=hp_a+?i,gold_a=gold_a+?i,timer=timer-?i,dohod_g=?i,dohod_b=?i WHERE id=?i AND user_id=?i AND typ=?i",
                        (time() + $tm), 1, $gl, $tm2, $gl, $bx, $ref[2], $user_id, 1);
                    header('Location: ?mine');
                } else {
                    echo "<div class='col-md-12 text-center'><hr>
        <div class='main'><div class='block_zero center'><span style='color: #9cc;'>
        Участок $aki[num]
        </span></div><div class='mini-line'></div>
        Доступно для работ только $aki[timer] минут
        </div><div class='clearfix'></div></div><hr>";
                }
            }
        }
    }
}
if ($ref[0] == 'rockets') {


}
if ($ref[0] == 'factory') {


}
require H . "system/down.php";
?>