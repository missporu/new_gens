<?php
$_GET['case']=isset($_GET['case'])?htmlspecialchars($_GET['case']):NULL;
if($_GET['case']=='raketa'){
$titles=' | Ракеты';
}else{
$titles=' | Шахта';
}
$title='Производство'.$titles.'';
require_once('system/up.php');
_Reg();

?><div class="row"><?
if($set['logo'] == 'on'){
?><img src="images/logotips/production.jpg"  alt="Банк" class="img-responsive center-block" /><hr><?
}
?><div class="menuList"><?
if($_GET['case'] != '' && $set['lvl']>50){
?><li><a href="production.php"><img src="images/icons/arrow.png" alt="*" />Шахта</a></li><?
}
if($_GET['case'] != 'raketa' && $set['lvl']>111){
?><li><a href="production.php?case=raketa"><img src="images/icons/arrow.png" alt="*" />Ракеты</a></li><?
}
switch($_GET['case']){
default:
echo '<div class="row">';
echo '<h1><center>При разборе золото компенсируется равнозначно потраченной на этот уровень сумме</center></h1>';

$regentime_rud = time()+(60*60*24);
$time_stroy = time()+(60*60*$set['rudnik_lvl']);
$reg_time = time()+(60*60);
$regen_time = $set['dohodrud'] - time();
$cena_up_gold = ($set['rudnik_lvl']-1)*50;
$cena_srazu_up = $cena_up_gold / 5;
$dostroika_time = $set['rudnik_time']-time();
$dohodn = $set['rudnik_lvl']*2;
$cena_up = $set['gold']+$cena_up_gold;

if ($cena_up_gold == 0) $cena_up_gold = 50;
if ($set['rudnik_lvl'] == 0) {
    if (isset($_POST['pokupka1'])) {
        mysql_query("UPDATE `user_set` SET `rudnik_lvl`='1', `rudnik_time`='".$regentime_rud."' WHERE `id`='".$set['id']."' LIMIT 1");
        $_SESSION['ok'] = 'Вы начали строить шахту!';
        header('Location: ?');
        exit();
    } else { ?>
        <div class="col-xs-4 col-sm-4 col-md-4 text-center">
            <img src="images/shahta.jpg" alt="" class="img-responsive">
            <?= $rudnik1['name'] ?>
        </div>
        <!-- /.col-xs-4 col-sm-4 col-md-4 text-center -->
        <div class="col-xs-8 col-sm-8 col-md-8 text-center">
            <h2>Новый участок</h2><br>
            Будет приносить 2 золота в час<br>
            <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
                <!-- <input type="submit" name="pokupka1" value="Построить бесплатно"> -->
            </form>
        </div><div class="clearfix"></div><hr>
        <!-- /.col-xs-8 col-sm-8 col-md-8 text-center --><?php
    }
}

if ($set['rudnik_lvl'] >= 1) { 
    if ($set['rudnik_time'] > 0) { ?>
        <div class="col-xs-4 col-sm-4 col-md-4 text-center">
            <img src="images/shahta1.jpg" alt="" class="img-responsive">
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8">
            <h2>Идет стройка...</h2>
                Уровень шахты : <?= $set['rudnik_lvl'] ?> | Доход: <?= $dohodn ?> в час<br>
                До конца стройки : <?= _Time($dostroika_time) ?> <br><?php
                $cena_minus_srazu = $set['gold']-$cena_srazu_up; ?>
                Стоимость <?= $set['rudnik_lvl']+1 ?> уровня : <?= $cena_up_gold ?> золота <?php
                if (isset($_POST['zaver_srazu'])) {
                    if ($set['gold'] < $cena_up_gold || $cena_up <=0 || $set['gold'] < 0 ) {
                        $_SESSION['err'] = 'Недостаточно золота, вы можете пополнить счёт тут';
                        header('Location: bank.php?case=worldkassa');
                        exit();
                    }
                    mysql_query("UPDATE `user_set` SET `gold`='".$cena_minus_srazu."', `rudnik_time` = '0' WHERE `id`='".$set['id']."' LIMIT 1");
                    $_SESSION['ok'] = 'Вы успешно ускорили стройку';
                    header('Location: ?');
                    exit();
                } else { ?>
                    <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
                        <input type="submit" name="zaver_srazu" value="Завершить сразу за <?= $cena_srazu_up ?> золота">
                    </form><?php
                } ?>
        </div><hr><div class="clearfix"></div><hr><?php
    } else { ?>
    <div class="col-xs-4 col-sm-4 col-md-4 text-center">
        <img src="images/shahta.jpg" alt="" class="img-responsive"><br><?php
        if ( $set['dohodrud'] < time() ) {
            if (isset($_POST['dohod_ss'])) {
                $dohod_user = $set['gold']+$dohodn;
                mysql_query("UPDATE `user_set` SET `gold`='".$dohod_user."', `dohodrud`='".$reg_time."', `skoko_spusk`=`skoko_spusk`+1 WHERE `id`='".$set['id']."' LIMIT 1");
                $_SESSION['ok'] = 'Вы успешно забрали доход с шахты';
                header('Location: ?');
                exit();
            } else {
                if ($set['skoko_spusk']>=3) {
                    echo 'Вы полностью выработали шахту, приходите завтра';
                } else { /*
                    <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
                        <input type="submit" name="dohod_ss" value="Забрать доход">
                    </form> */
                }
            }
        } else {
            echo 'Доход через ' . _Time($regen_time) . '' ;
        } ?>
    </div>
    <div class="col-xs-8 col-sm-8 col-md-8">
        <div class="row">
            <div class="col-md-4">
                <h2>Участок 1</h2>
                Уровень шахты : <?= $set['rudnik_lvl'] ?> <br>
                Доход: <?= $dohodn ?> золота в час<br>
            Стоимость <?= $set['rudnik_lvl']+1 ?> уровня : <?= $cena_up_gold ?><br><?php
            if (isset($_POST['lvl_up_gold'])) {
                
                $lvl_rud_next = $set['rudnik_lvl']-1;
                /*if ($set['gold'] < $cena_up_gold || $cena_up <=0 || $set['gold'] < 0 ) {
                    $_SESSION['err'] = 'Недостаточно золота, вы можете пополнить счёт тут';
                    header('Location: bank.php?case=worldkassa');
                    exit();
                }*/
                mysql_query("UPDATE `user_set` SET `gold`='".$cena_up."', `rudnik_lvl`='".$lvl_rud_next."' WHERE `id`='".$set['id']."' LIMIT 1");
                $_SESSION['ok'] = 'Вы разобрали 1 лвл шахты';
                header('Location: ?');
                exit();
            } else { 
if ($set['rudnik_lvl']>=1) { ?>
                <form method="POST" action="<?php echo $SCRIPT_NAME ?>">
                    <input type="submit" name="lvl_up_gold" value="Разобрать лвл">
                </form><?php
} else {echo 'Шахта полностью сломана';}
            } ?>
            </div>
        </div>
    </div><hr><div class="clearfix"></div><hr><?php
    }
    if ($set['rudnik_time'] < time() ) {
        mysql_query("UPDATE `user_set` SET `rudnik_time` = '0' WHERE `id`='".$set['id']."' LIMIT 1");
    }
}

break;


case 'raketa':

break;
} ?>
</div></div><?php
require_once('system/down.php');