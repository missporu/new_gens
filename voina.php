<?php
$title='Война';
require_once('system/up.php');
_Reg();
if ($set['block']==1) {
    header("Location: blok.php");
    exit();
}
switch($_GET['case']) {
default:
if ($set['id_vrag']==0) {
    $_SESSION['err'] = 'Не выбран противник';
    header('Location: voina.php?case=vrag');
    exit();
}
$svoy=$sql->getRow("SELECT * FROM alliance_user WHERE kto =?i",$user_id);
$vrag_set=$sql->getRow("SELECT * FROM user_reg WHERE id =?i LIMIT ?i",$set[id_vrag],1);
$logi=$sql->getRow("SELECT * FROM user_voina WHERE id_user =?i AND id_vrag=?i ORDER BY id DESC LIMIT ?i",$user_id,$vrag_set[id],1);
$vrag=$sql->getRow("SELECT * FROM user_set WHERE id =?i LIMIT ?i",$set[id_vrag],1);
if($login=='vasyan'){


}
if (round(100 / ($vrag['max_hp'] / ($vrag['hp']))) > 100) {
    $proc = 100;
} else {
    $proc = round(100 / ($vrag['max_hp'] / ($vrag['hp'])));
} ?>
<div class="main">
    <div class="block_zero center"><?=$user['login']?>
        <img src="images/flags/<?=$set['side']?>.png" alt="Флаг" />
        <img src="images/icons/vs.png" alt="vs" />
        <img src="images/flags/<?=$vrag['side']?>.png" alt="Флаг" />
        <?=$vrag_set['login']?>
    </div>
    <div class="dot-line"></div>
    <div class="block_zero center">
        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?=$proc ?>%; height: 100%; background-color: #f00; color: #000;">
                        <?=$vrag['hp'] ?> hp
        </div>
    </div>
    <div class="mini-line"></div>
    <?php
if (empty($logi['rezult'])) {
    header("Location: voina.php?case=vrag");
    exit();
}
if ($logi['rezult']=='nikto') {
    if ($set['logo']=='on') { ?>
    <img src="images/logotips/nikto.jpg" width="100%" alt="Ничья" />
    <div class="mini-line"></div><?php
    } ?>
    <div class="block_zero center">
        <h3 class="Admin" style="font-weight:bold;">Ничья !!!</h3>
    </div>
    <div class="dot-line"></div><?php
}
if ($logi['rezult']=='win') {
    if ($set['logo']=='on') { ?>
    <img src="images/logotips/win.jpg" width="100%" alt="Победа" />
    <div class="mini-line"></div><?php
    } ?>
    <div class="block_zero center">
        <h3 class="dgreen" style="font-weight:bold;">Победа !!!</h3>
    </div>
    <div class="dot-line"></div><?php
}
if($logi['rezult']=='lose'){
if ($set['logo']=='on'){
?><img src="images/logotips/lose.png" width="100%" alt="Поражение" />
    <div class="mini-line"></div>
    <?
}
?>
    <div class="block_zero center">
        <h3 class="dred" style="font-weight:bold;">Поражение !!!</h3>
    </div>
    <div class="dot-line"></div>
    <?
}
if($logi['rezult']=='razbt'){
if ($set['logo']=='on'){
?><img src="images/logotips/razbit.jpg" width="100%" alt="Поражение" />
    <div class="mini-line"></div>
    <?
}
?>
    <div class="block_zero center">
        <h3 class="dgreen" style="font-weight:bold;">Вы разбили армию противника !!!</h3>
    </div>
    <div class="dot-line"></div>
    <?
}
if($logi['rezult']=='razb'){
if ($set['logo']=='on'){
?><img src="images/logotips/razbit.jpg" width="100%" alt="Поражение" />
    <div class="mini-line"></div>
    <?
}
?>
    <div class="block_zero center">
        <h3 class="dred" style="font-weight:bold;">Армия противника уже разбита !!!</h3>
    </div>
    <div class="dot-line"></div>
    <?
}
if($logi['rezult']=='ubit'){
if ($set['logo']=='on'){
?><img src="images/logotips/fataliti.jpg" width="100%" alt="Поражение" />
    <div class="mini-line"></div>
    <?
}
?>
    <div class="block_zero center">
        <h3 class="dred" style="font-weight:bold;">Фаталити !!!</h3>
    </div>
    <div class="dot-line"></div>
    <?
}
if($logi['rezult']=='pomil'){
if ($set['logo']=='on'){
?><img src="images/logotips/pomiloval.jpg" width="100%" alt="Поражение" />
    <div class="mini-line"></div>
    <?
}
?>
    <div class="block_zero center">
        <h3 class="dgreen" style="font-weight:bold;">Помилование !!!</h3>
    </div>
    <div class="dot-line"></div>
    <?
}
if($logi['rezult']=='dubl'){
if ($set['logo']=='on'){
?><img src="images/logotips/fataliti.jpg" width="100%" alt="Фаталити" />
    <div class="mini-line"></div>
    <?
}
}
if($logi['rezult']=='uho'){
if ($set['logo']=='on'){
?><img src="images/logotips/uho.jpg" width="100%" alt="Ухо" />
    <div class="mini-line"></div>
    <?
}
}
if($logi['rezult']=='uho1' OR $logi['rezult']=='uho2' OR $logi['rezult']=='uhi'){
if ($set['logo']=='on'){
?><img src="images/logotips/fataliti.jpg" width="100%" alt="Нельзя" />
    <div class="mini-line"></div>
    <?
}
}
if($logi['rezult']=='lovk'){
if ($set['logo']=='on'){
?><img src="images/logotips/lovk.jpg" width="100%" alt="Ловкость" />
    <div class="mini-line"></div>
    <?
}
}
if ($logi['rezult']=='ubit'){ ?>
    <div class="block_zero center">
        <a class="btn" href="voina.php?case=fataliti">
            <span class="end">
                <span class="label">
                    <span class="dred">Отрезать ухо</span>
                </span>
            </span>
        </a>
        <a class="btn" href="voina.php?case=pomiloval">
            <span class="end"><span class="label"><span class="dgreen">Помиловать</span></span></span>
        </a></span><?php
} elseif ($logi['rezult']=='uho') {
?><div class="block_zero center"><span style="color: #9c9;">Вы убили <a
                    href="view.php?smotr=<?=$set['id_vrag']?>"><?=$vrag_set['login']?></a> и отрезали <?=$vrag_kto?>
                ухо.</span></div>
        <div class="dot-line"></div>
        <div class="block_zero center"><a class="btn" href="voina.php?case=vrag"><span class="end"><span
                        class="label"><span class="grey">На войну</span></span></span></a>
            <?
$sql->query("UPDATE user_set SET id_vrag=?i WHERE id=?i LIMIT ?i",0,$user_id,1);
}elseif($logi['rezult']=='uho1'){
?>
            <div class="block_zero center"><span style="color: #c66;">Отрезать ухо одному и тому же<br />противнику
                    можно 1 раз в час!</span><br />
                <?
$time = $fataliti_vrag['fataliti1'] - time();
?><span style="color: #999;">Осталось: <?=_Time($time)?></span></div>
            <div class="dot-line"></div>
            <div class="block_zero center"><a class="btn" href="voina.php?case=vrag"><span class="end"><span
                            class="label"><span class="grey">На войну</span></span></span></a> <a class="btn"
                    href="voina.php?case=pomiloval"><span class="end"><span class="label"><span
                                class="dgreen">Помиловать</span></span></span></a></span>
                <?
}elseif($logi['rezult']=='uho2'){
?>
                <div class="block_zero center"><span style="color: #c66;">Отрезать ухо одному и тому же<br />противнику
                        можно 1 раз в час!</span><br />
                    <?
$time = $fataliti_vrag['fataliti2'] - time();
?><span style="color: #999;">Осталось: <?=_Time($time)?></span></div>
                <div class="dot-line"></div>
                <div class="block_zero center"><a class="btn" href="voina.php?case=vrag"><span class="end"><span
                                class="label"><span class="grey">На войну</span></span></span></a> <a class="btn"
                        href="voina.php?case=pomiloval"><span class="end"><span class="label"><span
                                    class="dgreen">Помиловать</span></span></span></a></span>
                    <?
}elseif($logi['rezult']=='uhi'){
?>
                    <div class="block_zero center"><span style="color: #c66;">У бедняги <a
                                href="view.php?smotr=<?=$set['id_vrag']?>"><?=$vrag_set['login']?></a> и так нет обеих
                            ушей!</span></div>
                    <div class="dot-line"></div>
                    <div class="block_zero center"><a class="btn" href="voina.php?case=vrag"><span class="end"><span
                                    class="label"><span class="grey">На войну</span></span></span></a>
                        <?
}elseif($logi['rezult']=='lovk'){
?>
                        <div class="block_zero center"><span style="color: #c66;">Ловкость <a
                                    href="view.php?smotr=<?=$set['id_vrag']?>"><?=$vrag_set['login']?></a> позволила
                                <?=$vrag_kto?></br>сбежать с поля боя!</span></div>
                        <div class="dot-line"></div>
                        <div class="block_zero center"><a class="btn" href="voina.php?case=vrag"><span class="end"><span
                                        class="label"><span class="grey">На войну</span></span></span></a>
                            <?
$sql->query("UPDATE user_set SET id_vrag=?i WHERE id=?i LIMIT ?i",0,$user_id,1);
}elseif($logi['rezult']=='pomil'){
$bonus = $set['lvl']*1000;
?>
                            <div class="block_zero center"><span style="color: #9c9;">Вы помиловали <a
                                        href="view.php?smotr=<?=$set['id_vrag']?>"><?=$vrag_set['login']?></a>, сохранив
                                    <?=$vrag_kto?> жизнь,<br />но забрали <?=$vrag_kto1?> жетон!<br />Награда от
                                    Красного Креста</span> <img src="images/icons/baks.png" alt="vs" /><?=$bonus?> <span
                                    style="color: #999;">.</span></div>
                            <div class="dot-line"></div>
                            <div class="block_zero center"><a class="btn" href="voina.php?case=vrag"><span
                                        class="end"><span class="label"><span class="grey">На
                                                войну</span></span></span></a>
                                <?
$sql->query("UPDATE user_set SET id_vrag=?i WHERE id=?i LIMIT ?i",0,$user_id,1);
}elseif($logi['rezult']=='dubl' AND $set['pomiloval']!=0){
$time = $set['pomiloval']-time();
?>
                                <div class="block_zero center"><span style="color: #c66;">Нельзя так часто миловать
                                        противников!</span><br /><span style="color: #999;">Осталось
                                        <?=_Time($time)?></span></div>
                                <div class="dot-line"></div>
                                <div class="block_zero center"><a class="btn" href="voina.php?case=vrag"><span
                                            class="end"><span class="label"><span class="grey">На
                                                    войну</span></span></span></a> <a class="btn"
                                        href="voina.php?case=fataliti"><span class="end"><span class="label"><span
                                                    class="dred">Отрезать ухо</span></span></span></a>
                                    <?
}elseif($logi['rezult']=='dubl' AND $set['pomiloval']==0){
header("Location: voina.php?case=vrag");
exit();
}else{
?>
                                    <div class="block_zero center"><a class="btn" href="voina.php?case=vrag"><span
                                                class="end"><span class="label"><span class="grey">На
                                                        войну</span></span></span></a> <a class="btn"
                                            href="voina.php?case=ataka&vrag=<?=$vrag['id']?>"><span class="end"><span
                                                    class="label"><span
                                                        class="dred">Атаковать</span></span></span></a></span>
                                        <?
}

if($logi['nanes']==0){$uvorot_vrag='<span style="color: #3c3;">Уворот!</span>';}else{$uvorot_vrag=FALSE;}
if($logi['poluchil']==0){$uvorot_user='<span style="color: #3c3;">Уворот!</span>';}else{$uvorot_user=FALSE;}
if($logi['poluchil']==20 || $logi['poluchil']==30 || $logi['poluchil']==40 || $logi['poluchil']==60 || $logi['poluchil']==80 || $logi['poluchil']==100 || $logi['poluchil']==120 || $logi['poluchil']==140 || $logi['poluchil']==200){$krit_vrag='<span style="color: #ff3434;">Крит!</span>';}else{$krit_vrag=FALSE;}
if($logi['nanes']==20 || $logi['nanes']==30 || $logi['nanes']==40 || $logi['nanes']==60 || $logi['nanes']==80 || $logi['nanes']==100 || $logi['nanes']==120 || $logi['nanes']==140 || $logi['nanes']==200){$krit_user='<span style="color: #ff3434;">Крит!</span>';}else{$krit_user=FALSE;}


if($logi['rezult']!='pomil' AND $logi['rezult']!='dubl' AND $logi['rezult']!='razb' AND $logi['rezult']!='uho' AND $logi['rezult']!='uho1' AND $logi['rezult']!='uho2' AND $logi['rezult']!='uhi' AND $logi['rezult']!='lovk'){
?>
                                    </div>
                                    <div class="dot-line"></div>
                                    <div class="block_zero"><img src="images/icons/ataka.png" alt="ataka" /> Нанесено:
                                        <span style="color: #9c9;"><?=$logi['nanes']?></span> урона
                                        <?=$krit_user?><?=$uvorot_vrag?><br /><img src="images/icons/ataka.png"
                                            alt="ataka" /> Получено: <span
                                            style="color: #c66;"><?=$logi['poluchil']?></span> урона
                                        <?=$krit_vrag?><?=$uvorot_user?><br /><img src="images/icons/baks.png"
                                            alt="baks" /> Награблено: <span
                                            style="color: #9c9;"><?=number_format_short($logi['baks'])?></span> баксов<br /><img
                                            src="images/icons/lvl.png" alt="lvl" /> Заработано: <span
                                            style="color: #9c9;"><?=$logi['exp']?></span> опыта
                                        <?
} ?>


                                    </div>
                                    <div class="dot-line"></div>
                                    <div class="block_zero"><span style="color: #9c9;">Использовано:</span></div><?php

$vuk=_NumFilter(($user_alliance+1)*5);
?><table>
<tr>
<?
$uni =$sql->getAll("SELECT * from user_unit WHERE id_user=?i and kol>?i ORDER BY ataka",$user_id,0);
$i=0;
            foreach ($uni as $m) {
            ++$i;
            if($m[kol]>$vuk){$m[kol]=$vuk;}
            ?>
            <td><img src="images/units/<?=$m['id_unit']?>.png" width="65px" height="45px" style="border:1px solid #999;" alt="Техника"><br />
            <center><small><?=$m[kol]?> </small></center>
            </td>
            <?
            if($i % 4 == 0) {
            echo"</tr><tr>";
            }}
?>
</table>
</div>
</div>

<?php




break;

case 'vrag':

if(isset($_GET['vrag'])){
$vrag=_NumFilter($_GET['vrag']);
$sql->query("UPDATE user_set SET id_vrag=?i WHERE id=?i LIMIT ?i",0,$user_id,1);
if($set['udar']==0){
$_SESSION['err']='Закончились бои';
header("Location: voina.php?case=vrag");
exit();
}
if($set['hp']<25){
$_SESSION['err']='Закончилось здоровье,<br/>отдохните или сходите в <a href="hosp.php">Госпиталь</a>';
header("Location: voina.php?case=vrag");
exit();
}
header("Location: voina.php?case=ataka&vrag=".$vrag."");
exit();
}
$sql->query("UPDATE user_set SET id_vrag=?i WHERE id=?i LIMIT ?i",0,$user_id,1);
?>
                            <div class="main">
                                <?
if ($set['logo']=='on'){
?><img src="images/logotips/voina.jpg" width="100%" alt="Война" />
                                <div class="mini-line"></div>
                                <?
}
?>
                                <div class="menuList">
                                    <li><a href="sanction.php?case=vrag"><img src="images/icons/arrow.png"
                                                alt="Санкции" />Санкции</a></li>
                                </div>
                                <div class="mini-line"></div>
                                <?
$data_voina = $sql->query("SELECT * FROM user_set WHERE id!=?i AND lvl>=?i AND lvl<=?i ORDER BY RAND() LIMIT ?i",$user_id,($set[lvl]-3),($set[lvl]+3),5);
while($user_voina = $sql->fetch($data_voina)){


$vrag_set=$sql->getRow("SELECT * FROM user_reg WHERE id=?i LIMIT ?i",$user_voina[id],1);
$vrag_alliance=$sql->getOne("SELECT count(id) FROM alliance_user WHERE kto=?i OR s_kem=?i",$vrag_set[id],$vrag_set[id]);// Колличество альянса ?>
<div class="block_zero"><img src="images/flags/<?=$user_voina['side']?>.png"
alt="Флаг" /><a href="view.php?smotr=<?=$vrag_set['id']?>">
<?=$vrag_set['login']?></a><span style="float: right;"><a class="btn btn-primary btn-xs active"
href="voina.php?case=vrag&vrag=<?=$vrag_set['id']?>">Атаковать</a></span><br /><small><span
style="color: #fffabd;">Ур.</span> <?=$user_voina['lvl']?>, <span
style="color: #fffabd;">Ал.</span> <?=($vrag_alliance+1)?>, <span
style="color: #fffabd;">Рейтинг</span> <?=$user_voina['raiting']?>, <?=$user_voina['hp']?>/<?=$user_voina['max_hp']?> <span
style="color: #fffabd;"> hp</span><?php

$smotr=$sql->getRow("SELECT * FROM user_reg WHERE id=?i LIMIT ?i",$vrag_set[id],1);
$smotr_set=$sql->getRow("SELECT * FROM user_set WHERE id=?i LIMIT ?i",$smotr[id],1);
$fataliti_vrag=$sql->getRow("SELECT * FROM user_fataliti WHERE id_user=?i LIMIT ?i",$smotr[id],1);
$priglas=$sql->getOne("SELECT count(id) FROM alliance_priglas WHERE id_user=?i AND kogo=?i",$user_id,$smotr[id]);
$vstupil=$sql->getOne("SELECT count(id) FROM alliance_user WHERE kto=?i AND s_kem=?i",$user_id,$smotr[id]);
$vstupil2=$sql->getOne("SELECT count(id) FROM alliance_user WHERE kto=?i AND s_kem=?i",$smotr[id],$user_id);
$smotr_alliance=$sql->getOne("SELECT count(id) FROM alliance_user WHERE kto=?i OR s_kem=?i",$smotr[id],$smotr[id]);
if ($vstupil == 1 OR $vstupil2 == 1) {
echo " <font color=red>Альянс</font>";
}
?>
</small></div>
<div class="dot-line"></div><?



} ?>

                                <div class="block_zero center">
                                    <a class="btn btn-primary btn-xs active" href="voina.php?case=vrag">Другие противники</a></div>
                                <div class="mini-line"></div>
                                <?
//НАВИГАЦИЯ
if(empty($_GET['page'])||$_GET['page']==0||$_GET['page']<0){
$_GET[ 'page' ] = 0;
}
$next=_NumFilter($_GET['page']+1);
$back=$_GET['page']-1;
$num=$_GET['page']*5;
if($_GET['page']==0){
$i = 1;
}else{
$i=($_GET['page']*5)+1;
}
$viso=$sql->getOne( "SELECT count(id) FROM user_voina WHERE id_vrag=?i",$user_id);
$puslap=floor($viso/5);
//НАВИГАЦИЯ

$logi=$sql->query("SELECT * FROM user_voina WHERE id_vrag=?i  ORDER BY id DESC LIMIT ?i,?i",$user_id,$num,5);
while($logi_vrag = $sql->fetch($logi)){
$logi_voina=$sql->getRow("SELECT * FROM user_reg WHERE id=?i  LIMIT ?i",$logi_vrag[id_user],1);

if($logi_vrag['rezult']=='nikto'){$rezult='<span style="color: #9cc;">Ничья!</span>';}
elseif($logi_vrag['rezult']=='win'){$rezult='<span style="color: #ff3434;">Поражение!</span>';}
elseif($logi_vrag['rezult']=='lose'){$rezult='<span style="color: #3c3;">Победа!</span>';}
elseif($logi_vrag['rezult']=='razb'){$rezult='<span style="color: #ff3434;">Ваша армия уже разбита!</span>';}
elseif($logi_vrag['rezult']=='razbt'){$rezult='<span style="color: #ff3434;">Вашу армию разбили!</span>';}
elseif($logi_vrag['rezult']=='dubl'){$rezult='<span style="color: #ff3434;">Пытался совершить фаталити!</span>';}
elseif($logi_vrag['rezult']=='ubit'){$rezult='<span style="color: #ff3434;">Пытался совершить фаталити!</span>';}
elseif($logi_vrag['rezult']=='pomil'){$rezult='<span style="color: #3c3;">Вас помиловали!</span>';}
elseif($logi_vrag['rezult']=='uho'){$rezult='<span style="color: #ff3434;">Вам отрезали ухо!</span>';}
elseif($logi_vrag['rezult']=='lovk'){$rezult='<span style="color: #3c3;">Вы сбежали с поля боя!</span>';}
elseif($logi_vrag['rezult']=='uho1' OR $logi_vrag['rezult']=='uho2' OR $logi_vrag['rezult']=='uhi'){$rezult='<span style="color: #ff3434;">Пытался совершить фаталити!</span>';}
elseif($logi_vrag['rezult']=='spopa'){$rezult='<span style="color: #ff3434;">Добавил Вас в санкции!</span>';}
elseif($logi_vrag['rezult']=='swin'){$rezult='<span style="color: #ff3434;">Поражение в санкциях!</span>';}
elseif($logi_vrag['rezult']=='snikt'){$rezult='<span style="color: #9cc;">Ничья в санкциях!</span>';}
elseif($logi_vrag['rezult']=='slose'){$rezult='<span style="color: #3c3;">Победа в санкциях!</span>';}
elseif($logi_vrag['rezult']=='srazb'){$rezult='<span style="color: #ff3434;">Вас убили в санкциях!</span>';}
elseif($logi_vrag['rezult']=='suzhe'){$rezult='<span style="color: #ff3434;">атака в санкциях!</span>';}
else{
$rezult=FALSE;
}

echo '
    <div class="block_zero small">
    <b><span style="color: #9c9;">'.$logi_vrag['data'].' в '.$logi_vrag['time'].'</span></b>
    <br/>Вас атаковал <a href="view.php?smotr='.$logi_voina['id'].'">'.$logi_voina['login'].'</a> - '.$rezult.'<br/>
    <span style="color: #3c3;">Нанесено: '.$logi_vrag['poluchil'].' урона</span><br/>
    <span style="color: #ff3434;">Получено: '.$logi_vrag['nanes'].' урона</span><br/>
    <span style="color: #ff3434;">Потеряно: '.$logi_vrag['baks'].' баксов</span></div><div class="dot-line"></div>';
$i++;
}


//НАВИГАЦИЯ
echo'<div class="block_zero center">';
if($_GET['page']>0){
echo '<small><b><a href="voina.php?case=vrag&page='.$back.'"><< Вперёд </a></small></b>';
}
if(empty($_GET['page'])||$_GET['page']==0||$_GET['page']<$puslap){
echo '<small><b><a href="voina.php?case=vrag&page='.$next.'"> Назад >></a></small></b>';
}
echo'</div></div>';
//НАВИГАЦИЯ
break;

case 'ataka':
$vrag=isset($_GET['vrag'])?_NumFilter($_GET['vrag']):NULL;
if($set['id_vrag']==0){
$sql->query("UPDATE user_set SET id_vrag=?i WHERE id=?i LIMIT ?i",$vrag,$user_id,1);
header('Location: voina.php?case=ataka');
exit();
}
$vrag_set=$sql->getRow("SELECT * FROM user_set WHERE id=?i LIMIT ?i",$set[id_vrag],1);

if($set['lvl']>($vrag_set['lvl']+10)){
$_SESSION['err']='Уровень противника меньше, чем на 10!';
header("Location: voina.php?case=vrag");
exit();
}

if($user_id==$vrag_set['id']){
$_SESSION['err']='Нельзя атаковать самого себя!';
header("Location: voina.php?case=vrag");
exit();
}

if($set['lvl']<($vrag_set['lvl']-10)){
$_SESSION['err']='Уровень противника больше, чем на 10!';
header("Location: voina.php?case=vrag");
exit();
}

if($set['udar']==0){
$_SESSION['err']='Закончились бои';
header("Location: voina.php");
exit();
}

if($set['hp']<25){
$_SESSION['err']='Закончилось здоровье,<br/>отдохните или сходите в <a href="hosp.php">Госпиталь</a>';
header("Location: voina.php");
exit();
}



// Победа
if($ITOG_A>$VRAG_ITOG_Z AND $vrag_set['hp']>=30){
    if ( $vrag_set['ip'] == '127.0.0.1' ) {
        $VRAG_ITOG_Z = rand(100,2000);
        if ($vrag_set['lvl'] > 30) {
            $VRAG_ITOG_Z = rand(500,4000);
        } elseif ($vrag_set['lvl'] > 55) {
            $VRAG_ITOG_Z = rand(1000,9000);
        }
    }
$hp_user=($VRAG_ITOG_Z/$ITOG_A)*10;
$hp_vrag=($ITOG_A-$VRAG_ITOG_Z)*0.01;
if ($hp_vrag > 100 && $hp_vrag < 500) {
    $hp_vrag = rand(21, 30);
} elseif ($hp_vrag > 500 && $hp_vrag < 1000) {
    $hp_vrag = rand(31, 40);
} elseif ($hp_vrag > 1000 && $hp_vrag < 5000) {
    $hp_vrag = rand(41, 60);
} elseif ($hp_vrag > 5000 && $hp_vrag < 10000) {
    $hp_vrag = rand(61, 80);
} elseif ($hp_vrag > 10000 && $hp_vrag < 15000) {
    $hp_vrag = rand(81, 100);
} elseif ($hp_vrag > 15000 && $hp_vrag < 20000) {
    $hp_vrag = rand(101, 120);
} elseif ($hp_vrag > 20000 && $hp_vrag < 25000) {
    $hp_vrag = rand(121, 140);
} elseif ($hp_vrag > 25000) {
    $hp_vrag = rand(150, 200);
} else $hp_vrag = rand(10, 20);


// if ($user_id == 1) $hp_vrag = rand(199,200);

$trof_exp=$sql->getRow("SELECT * FROM user_trofei WHERE id_user=?i AND id_trof=?i LIMIT ?i",$user_id,5,1);
if($trof_exp['status']==1 AND $trof_exp['time_up']==0){
if ($set['side']=='u'){
$bon_exp = ($set['lvl']+1);
$exp_trof=round(($set['lvl']+1)*1.2)/100*$trof_exp['bonus_1'];

$expa=round(($hp_vrag+1)*1.2)+$exp_trof;
}else{
$exp_trof=($set['lvl']+1)/100*$trof_exp['bonus_1'];
$expa=($hp_vrag+1)+$exp_trof;
}
}else{
if ($set['side']=='u'){
$expa=round(($hp_vrag+1)*1.2);
}else{
$expa=($hp_vrag+1);
}
}
if ($set['premium']==1) {
    $expa = $expa * 2;
}

$user_lab_exp=$sql->getRow("SELECT * FROM user_laboratory WHERE id_user=?i AND id_lab=?i LIMIT ?i",$user_id,4,1);

if($user_lab_exp['status']==1){
$expa=$expa*1.3;
}

$user_lab_expno=$sql->getRow("SELECT * FROM user_laboratory WHERE id_user=?i AND id_lab=?i LIMIT ?i",$user_id,3,1);

if($user_lab_expno['status']==1){
$expa=0;
}

if ( $vrag_set['baks']>=0 ) {
    $baks=($vrag_set['baks']*1)/100;
    if ( $vrag_set['ip'] == '127.0.0.1' ) {
        $baks = $set['lvl']*10000;
    }
    if ($set['premium'] == 1) {
        $baks = $baks * 2;
    }
} else {
    $baks=0;
}

if($user['refer']>0){
$rn=round($baks/10);
$sql->query("UPDATE user_set SET baks=baks+?i WHERE id=?i",$rn,$user[refer]);
}else{
$rn=0;
}
$sql->query("UPDATE user_set SET hp=hp-?i,hp_up=?i,baks=baks+?i,exp=exp+?i,udar=udar-?i,udar_up=?i,unit_hp=unit_hp+?i,refer_baks=refer_baks+?i,wins=wins+?i,raiting_wins=raiting_wins+?i WHERE id=?i LIMIT ?i",$hp_user,time(),$baks,$expa,1,time(),$hp_user,$rn,1,1,$user_id,1);

$sql->query("UPDATE user_set SET hp=hp-?i,hp_up=?i,baks=baks+?i,loses=loses+?i,raiting_loses=raiting_loses+?i WHERE id=?i LIMIT ?i",$hp_vrag,time(),$baks,1,1,$vrag_set[id],1);

$vrag_set=$sql->getRow("SELECT * FROM user_set WHERE id=?i LIMIT ?i",$vrag_set[id],1);

if($vrag_set['hp']>=25){// Победа
$sql->query("INSERT INTO user_voina (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$vrag_set['id']."','".$dater."','".$timer."','".$hp_vrag."','".$hp_user."','".$baks."','".$expa."','win')");
header("Location: voina.php");
exit();
}elseif($vrag_set['hp']<=10){// Фаталити

$sql->query("INSERT INTO user_voina (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$vrag_set['id']."','".$dater."','".$timer."','".$hp_vrag."','".$hp_user."','".$baks."','".$expa."','ubit')");
header("Location: voina.php");
exit();
}else{// Разбил армию
$sql->query("INSERT INTO user_voina (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$vrag_set['id']."','".$dater."','".$timer."','".$hp_vrag."','".$hp_user."','".$baks."','".$expa."','razbt')");
header("Location: voina.php");
exit();
}
}
// Ничья
elseif($ITOG_A==$VRAG_ITOG_Z  AND $vrag_set['hp']>=30){
$hp_user=0;
$hp_vrag=0;
$expa=0;
$baks=0;
$sql->query("UPDATE user_set SET udar=udar-?i WHERE id=?i LIMIT ?i",1,$user_id,1);
$vrag_set=$sql->getRow("SELECT * FROM user_set WHERE id=?i LIMIT ?i",$vrag_set[id],1);
if($vrag_set['hp']>=30){// Ничья
$sql->query("INSERT INTO user_voina (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$vrag_set['id']."','".$dater."','".$timer."','".$hp_vrag."','".$hp_user."','".$baks."','".$expa."','nikto')");
header("Location: voina.php");
exit();
}
}

// Поражение
elseif($ITOG_A<$VRAG_ITOG_Z  AND $vrag_set['hp']>=30){
$hp_user=($VRAG_ITOG_Z-$ITOG_A)*0.01;
$hp_vrag=($ITOG_A/$VRAG_ITOG_Z)*10;


if($hp_user > 100 && $hp_user < 500) {
    $hp_user = rand(15,30);
} elseif ($hp_user > 500 && $hp_user < 1000) {
    $hp_user = rand(20,40);
} elseif ($hp_user > 1000 && $hp_user < 5000) {
    $hp_user = rand(30,60);
} elseif ($hp_user > 5000 && $hp_user < 10000) {
    $hp_user = rand(50,80);
} elseif ($hp_user > 10000 && $hp_user < 15000) {
    $hp_user = rand(70,100);
} elseif ($hp_user > 15000 && $hp_user < 20000) {
    $hp_user = rand(90,120);
} elseif ($hp_user > 20000 && $hp_user < 25000) {
    $hp_user = rand(110,140);
} elseif ($hp_user > 25000) {
    $hp_user = rand(130,160);
} else $hp_user = rand(10,20);


$expa=0;
$baks=0; 
$sql->query("UPDATE user_set SET hp=hp-?i,udar=udar-?i,unit_hp=unit_hp+?i,loses=loses+?i,raiting_loses=raiting_loses+?i WHERE id=?i LIMIT ?i",$hp_user,1,$hp_user,1,1,$user_id,1);

$sql->query("UPDATE user_set SET hp=hp-?i,hp_up=?i,wins=wins+?i,raiting_wins=raiting_wins+?i WHERE id=?i LIMIT ?i",$hp_vrag,time(),1,1,$vrag_set[id],1);

$vrag_set=$sql->getRow("SELECT * FROM user_set WHERE id=?i LIMIT ?i",$vrag_set[id],1);
if($vrag_set['hp']>=30){// Поражение
$sql->query("INSERT INTO user_voina (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$vrag_set['id']."','".$dater."','".$timer."','".$hp_vrag."','".$hp_user."','".$baks."','".$expa."','lose')");
header("Location: voina.php");
exit();
}else{// Разбил армию
$sql->query("INSERT INTO user_voina (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$vrag_set['id']."','".$dater."','".$timer."','".$hp_vrag."','".$hp_user."','".$baks."','".$expa."','razbt')");
header("Location: voina.php");
exit();
}


}else{// Армия уже разбита
$sql->query("INSERT INTO user_voina (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$vrag_set['id']."','".$dater."','".$timer."','','','','','razb')");
header("Location: voina.php");
exit();
}
break;

case 'pomiloval':
if($set['id_vrag']==0){
$_SESSION['err'] = 'Не выбран противник';
header('Location: voina.php?case=vrag');
exit();
}
$vrag_set=$sql->getRow("SELECT * FROM user_set WHERE id = ?i LIMIT ?i",$set[id_vrag],1);
if($set['pomiloval']==0){
$bonus=$set['lvl']*1000;
if($user['refer']>0){
$rn=round($bonus/10);
$sql->query("UPDATE user_set SET baks=baks+?i WHERE id=?i",$rn,$user[refer]);
}else{
$rn=0;
}
$sql->query("UPDATE user_set SET baks = baks + ?i, zheton = zheton + ?i, pomiloval = ?i, refer_baks=refer_baks+?i WHERE id = ?i",$bonus,1,(time()+3600),$rn,$user_id);
$hp_user=0;$hp_vrag=0;$expa=0;$baks=0;
$sql->query("INSERT INTO user_voina (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$vrag_set['id']."','".$dater."','".$timer."','".$hp_vrag."','".$hp_user."','".$baks."','".$expa."','pomil')");
header("Location: voina.php");
exit();
}else{
$hp_user=0;$hp_vrag=0;$expa=0;$baks=0;
$sql->query("INSERT INTO user_voina (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$vrag_set['id']."','".$dater."','".$timer."','".$hp_vrag."','".$hp_user."','".$baks."','".$expa."','dubl')");
header('Location: voina.php');
exit();
}
break;

case 'fataliti';
if($set['id_vrag']==0){
    $_SESSION['err'] = 'Не выбран противник';
    header('Location: voina.php?case=vrag');
    exit();
}
if ($fataliti_user['uho1_up']>0 && $fataliti_user['uho2_up']>0) {
    $_SESSION['err'] = 'Вы истекаете кровью и не можете резать других';
    header('Location: voina.php?case=vrag');
    exit();
}
if($KRIT > $VRAG_UVOROT) {
if($fataliti_vrag['uho1_kto']!=0 AND $fataliti_vrag['uho2_kto']!=0){
$sql->query("INSERT INTO user_voina (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$set['id_vrag']."','".$dater."','".$timer."','','','','','uhi')");
header('Location: voina.php');
exit();
}
elseif($fataliti_vrag['uho1_kto']==0 AND $fataliti_vrag['fataliti1']==0){
$sql->query("UPDATE user_fataliti SET uho1_kto = ?i, uho1_up = ?i, fataliti1 = ?i WHERE id_user = ?i",$user_id,(time()+86400),(time()+3600),$set[id_vrag]);
$sql->query("UPDATE user_set SET hp=?i,hp_up=?i,dies=dies+?i WHERE id =?i",0,time(),1,$set[id_vrag]);
$sql->query("UPDATE user_set SET uho=uho+?i,kills=kills+?i WHERE id =?i",1,1,$user_id);
$sql->query("INSERT INTO user_voina (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$set['id_vrag']."','".$dater."','".$timer."','','','','','uho')");
header('Location: voina.php');
exit();
}elseif($fataliti_vrag['uho1_kto'] == $user_id AND $fataliti_vrag['fataliti1'] != 0) {
$sql->query("INSERT INTO user_voina (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$set['id_vrag']."','".$dater."','".$timer."','','','','','uho1')");
header('Location: voina.php');
exit();
}
elseif($fataliti_vrag['uho2_kto'] == '0' AND $fataliti_vrag['fataliti2'] == '0') {
$sql->query("UPDATE user_fataliti SET uho2_kto = ?i, uho2_up = ?i, fataliti2 = ?i WHERE id_user = ?i",$user_id,(time()+86400),(time()+3600),$set[id_vrag]);
$sql->query("UPDATE user_set SET hp=?i,hp_up=?i,dies=dies+?i WHERE id =?i",0,time(),1,$set[id_vrag]);
$sql->query("UPDATE user_set SET uho=uho+?i,kills=kills+?i WHERE id =?i",1,1,$user_id);
$sql->query("INSERT INTO user_voina (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$set['id_vrag']."','".$dater."','".$timer."','','','','','uho')");
header('Location: voina.php');
exit();
}elseif($fataliti_vrag['uho2_kto'] == $user_id AND $fataliti_vrag['fataliti2'] != '0') {
$sql->query("INSERT INTO user_voina (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$set['id_vrag']."','".$dater."','".$timer."','','','','','uho2')");
header('Location: voina.php');
exit();
}
} else {
$sql->query("INSERT INTO user_voina (id_user,id_vrag,data,time,nanes,poluchil,baks,exp,rezult) VALUES('".$user_id."','".$set['id_vrag']."','".$dater."','".$timer."','','','','','lovk')");
header('Location: voina.php');
exit();
}
break;


}
require_once('system/down.php');
?>