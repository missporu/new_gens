<?php
$title = 'Онлайн';
require_once('system/up.php');
$user->_Reg();

try {
    if($user->getBlock()) {
        throw new Exception(message: 'Вы заблокированы администрацией проекта!');
    }
    $admin = new Admin(); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h3 class="text-center text-info"><?= $title ?></h3>
            </div>
            <div class="clearfix"></div><?php
            $online_int = $sql->getOne("select count(id) from users where online > ?i", time()-600);
            if($online_int > 0) {
                $online = $sql->getAll("select mesto, login, id from users where online > ?i order by id desc", time()-600);
                foreach ($online as $onl) {
                    $mesto = explode(separator: '.', string: $onl['mesto']);
                    if ($mesto[0] == 'admin') {$m = 'Админка';}
                    elseif ($mesto[0] == 'menu') {$m = 'Главная';}
                    elseif ($mesto[0] == 'online') {$m = 'Онлайн';}
                    elseif ($mesto[0] == 'pers') {$m = 'Профиль';}
                    else $m = '?'; ?>
                    <div class="col-xs-6">
                        <a href="view.php?user=<?= $onl['login'] ?>"><?= $onl['login'] ?></a>
                    </div>
                    <div class="col-xs-6">
                        <?= $m ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="separ"></div>
                    <div class="clearfix"></div><?
                }
            } else { ?>
                <p class="text-danger text-center">
                    Никого нет
                </p><?
            } ?>
        </div>
    </div><?php
} catch (Exception $e) {?>
    <div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <h3 class="red">
                <?= $e->getMessage() ?>
            </h3>
            <p class="green">
                До автоматической разблокировки осталось <?= Times::timeHours(time: $user->user(key: 'block_time') - time()) ?>
            </p>
        </div>
    </div>
    </div><?php
}
/*
<div class="row"><?php
if ($_GET['case'] == ''){
?><div class="col-md-6 col-xs-6 text-center">Все игроки </div><div class="col-md-6 col-xs-6 text-center"><a class="btn-primary btn-xs btn-block" href="?case=search">Поиск</a></div><?
}else{
?><div class="col-md-6 col-xs-6 text-center"><a class="btn-primary btn-xs active btn-block" href="?">Все игроки</a></div> <div class="col-md-6 col-xs-6">Поиск</div><?php
}
if ($set['block']==1) {
	header("Location: blok.php");
	exit();
}
if(!$ref[0]){
    echo'<div class="col-md-6 col-xs-6 text-center">Все игроки </div><div class="col-md-6 col-xs-6 text-center"><a class="btn-primary btn-xs btn-block" href="?case=search">Поиск</a></div>';
}
echo "<hr>";
switch ($_GET['case']) {
default:
$rec =$sql->getOne("SELECT count(id) from user_set WHERE `online`>?i ", time()-600);
$sum=10;
$page = $ref[2];
$get=":page";
$posts = $rec;
$total = (($posts - 1) / $sum) + 1;
$total =  intval($total);
$page = intval($page);
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $sum - $sum;
    /*if (isset($_GET['page'])){
		$page = $_GET['page'];
    }else 
    $page = 1;
	
	$kol = 10;  //количество записей для вывода
	$art = ($page * $kol) - $kol;
	// echo $art;
	
	// Определяем все количество записей в таблице
	$res = mysql_query("SELECT COUNT(*) FROM `user_set` WHERE `online`> '".(time()-600)."' ");
	$row = mysql_fetch_row($res);
	$total = $row[0]; // всего записей	
	// echo $total;
	
	// Количество страниц для пагинации
	$str_pag = ceil($total / $kol);
	// echo $str_pag; 
	// Запрос и вывод записей
	$result = mysql_query("SELECT * FROM `user_set` WHERE `online`> '".(time()-600)."' ORDER BY `chistaya` DESC LIMIT $start,$sum");
	$myrow = mysql_fetch_array($result); ?>
	<div class="col-md-12 text-center text-info"><hr>Вы на <?=$page?> Странице<hr></div><?php
    do{
        $smotr_reg = mysql_query("SELECT * FROM user_reg WHERE id = '".$myrow['id']."' ");
        $myreg = mysql_fetch_array($smotr_reg);
    	if ($myrow['prava'] == 5) {
                $color = '000';
                $dolg = '[GM]';
            } elseif ($myrow['prava'] == 2) {
                $color = '7FFFD4';
                $dolg = '[MD]';
            } elseif ($myrow['prava'] == 4) {
                $color = '7FFFD4';
                $dolg = '[ADM]';
            } elseif ($myrow['prava'] == 3) {
                $color = 'FF69B4';
                $dolg = '[SMD]';
            } elseif ($myrow['prava'] == 0) {
                $color = 'fff';
                $dolg = '';
            }?>
    	<div class="col-md-12">
			<div class="row">
				<div class="col-md-6 col-xs-6">
					<a href="view.php?smotr=<?= $myreg['id'] ?>" class="btn-block"><img src="images/flags/<?= $myrow['side'] ?>.png" alt="*"/> <?=$myreg['login']?></a>
				</div>
				<div class="col-md-2 col-xs-2 text-right text-danger">
					<?=$dolg?>
				</div>
				<div class="col-md-4 col-xs-4 text-right text-info">
					<?=$myrow['mesto']?>
				</div>
			</div><hr>
		</div><?php
    } while ($myrow = mysql_fetch_array($result)); ?>
    <div class="col-md-12 text-center">
		<? /*<ul class="pagination"><?php

			// формируем пагинацию
			for ($i = 1; $i <= $str_pag; $i++){
				echo ' <li><a href="?page='.$i.'">'.$i.' </a></li> ';
			} ?>
        </ul>
        put($page,$get,$total); ?>
	</div>
</div><?php
        break;

case 'search':
        if(isset($_POST['login'])){
	        $name = _TextFilter($_POST['login']);
	        $sql  = _NumRows("SELECT `login` FROM `user_reg` WHERE `login`='" . $name . "' LIMIT 1");
	        $sql2  = _FetchAssoc("SELECT `id` FROM `user_reg` WHERE `login`='" . $name . "' LIMIT 1");
	        if (empty($name)) {
	        $_SESSION['err'] = 'Вы не ввели никнейм для поиска!';
	        header('Location: online.php?case=search');
	        exit();
	        } elseif ($name == $user['login']) {
	        $_SESSION['err'] = 'Вы ввели свой никнейм!';
	        header('Location: online.php?case=search');
	        exit();
	        } elseif ($sql == 0) {
	        $_SESSION['err'] = 'Игрок не найден!';
	        header('Location: online.php?case=search');
	        exit();
	        } else {
	        $_SESSION['ok'] = 'Игрок '.$name.' найден!';
	        header('Location: view.php?smotr='.$sql2['id'].'');
	        exit();
	    	}
		}
        ?><div class="mini-line"></div><div class="block_zero">Введите никнейм:<form action="online.php?case=search" method="post"><input class="text" type="text" name="login" size="30"/><br/><span class="btn"><span class="end"><input class="label" type="submit" name="send" value="Найти"></span></span> </a></form></div><div class="mini-line"></div><ul class="hint"><li>Здесь можно найти нужного игрока по его никнейму.</li></div><?        
        break;
} */
require_once('system/down.php');