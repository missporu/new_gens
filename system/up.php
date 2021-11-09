<?php
require_once('sys.php'); ?>
<div class="clearfix"></div><hr>
<div class="container">
    <div class="row">
        <div class="col-xs-2">
            <h1 class="text-info">
                <a href="/"><span class="glyphicon glyphicon-home"></span></a>
            </h1>
        </div>
        <div class="col-xs-8 text-center">
            <h1 class="text-danger"><?= $site->name ?></h1>
        </div>
        <div class="col-xs-2 text-right">
            <h1 class="text-info">
                <a href=""><span class="glyphicon glyphicon-refresh"></span></a>
            </h1>
        </div>
    </div>
</div>
<div class="clearfix"></div><hr><?php
/*
if ($user) {
    echo '<div class="container-fluid">';
    if ($set['start'] == 12) 
    echo '<div class="row">
        <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
            <a href="/menu.php">
                <h1 style="height:43px;"><span class="glyphicon glyphicon-home"> Домой</span></h1>
            </a>
        </div>
        <div class="col-sm-4 col-xs-4 col-md-6 col-lg-6">
                <img src="img/logo.png" alt="Домой" class="img-responsive center">
        </div>
        <div class="col-sm-4 col-xs-4 col-md-2 col-lg-2 text-right">
            <a href="">
                <h1 style="height:43px;"><span class="glyphicon glyphicon-refresh"> Обновить</span></h1>
            </a>
        </div>
    </div>';
echo '<div class="row">';

$level_p=$sql->getRow("SELECT * FROM lvl WHERE lvl =?i LIMIT ?i",($set[lvl]+1),1);
$level_m=$sql->getRow("SELECT * FROM lvl WHERE lvl =?i LIMIT ?i",($set[lvl]-1),1);
$opit_ravno=$sql->getRow("SELECT * FROM lvl WHERE opit>=?i LIMIT ?i",$set[exp],1);

if ($set['exp']>=$set['max_exp']) {
$sql->query("UPDATE user_set SET lvl=lvl+?i,exp=?i,max_exp=?i,hp=?i,mp=?i,udar=?i,skill=skill+?i WHERE id=?i LIMIT ?i",1,0,$level_p[opit],$set[max_hp],$set[max_mp],$set[max_udar],5,$user_id,1);

$sql->query("UPDATE user_superunit 
SET  ataka=ataka+ 
            (CASE 
 WHEN id_unit = '1' THEN '5'
 WHEN id_unit = '2' THEN '5'
 WHEN id_unit = '3' THEN '5'
 WHEN id_unit = '4' THEN '0'
 WHEN id_unit = '5' THEN '0'
 WHEN id_unit = '6' THEN '5'
 WHEN id_unit = '7' THEN '5'
 WHEN id_unit = '8' THEN '5'
 WHEN id_unit = '9' THEN '5'
 WHEN id_unit = '10' THEN '50'
            END)
    ,zaschita=zaschita+ 
           (CASE
 WHEN id_unit = '1' THEN '5'
 WHEN id_unit = '2' THEN '5'
 WHEN id_unit = '3' THEN '5'
 WHEN id_unit = '4' THEN '5'
 WHEN id_unit = '5' THEN '5'
 WHEN id_unit = '6' THEN '5'
 WHEN id_unit = '7' THEN '0'
 WHEN id_unit = '8' THEN '0'
 WHEN id_unit = '9' THEN '5'
 WHEN id_unit = '10' THEN '50'
               END)
WHERE id_unit IN ('1','2','3','4','5','6','7','8','9','10')
  AND id_user = ?i LIMIT ?i",$user_id,1);

$_SESSION['light'] = '<span class="quality-4">Вы получили новый уровень!</span></div><div class="mini-line"></div>';
}

$set=$sql->getRow("SELECT * FROM user_set WHERE id=?i",$user_id);

?>
<div class="progress"><?php $width = 100 / ($set['max_exp'] / ($set['exp'])); ?>
<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $width ?>%;">
<?= number_format($width, 2, '.', '')  ?> % (<?=$set['exp'] ?> exp)
</div>
</div><?php

if ($set['skill'] > 0) {
$skill_kol = '#ff3434';
$skill_set = '['.$set['skill'].'!]';
} else {
$skill_kol = '#3c3';
$skill_set = '';
}

    echo '<div class="col-sm-4 col-xs-4 col-md-4 col-lg-2 block center">
                <a href="/bank.php">
                    <img src="/images/icons/baks.png" alt="Бакс"/>
                    <span style="color: #9c9;"><small> ' . number_format_short($set['baks']) . '</small></span>
                </a>
            </div>
            <div class="col-sm-3 col-xs-3 col-md-3 col-lg-2 block center">
                <a href="/bank.php?case=donat">
                    <img src="/images/icons/gold.png" alt="Gold"/>
                    <span style="color: #ffd555;"><small> ' . number_format_short($set['gold']) . '</small></span>
                </a>
            </div>
            <div class="col-sm-3 col-xs-3 col-md-3 col-lg-1 block center">
                <a href="/pers.php?case=raspred">
                    <img src="/images/icons/lvl.png" alt="lvl"/>
                    <span style="color: ' . $skill_kol . ';"><small> ' . $set['lvl'] . ' ' . $skill_set . '</small></span>
                </a>
            </div>
            <div class="col-sm-2 col-xs-2 col-md-2 col-lg-1 block center"><small> ' . $icon_mail . ' </small>
                </a>
            </div>
            <div class="col-sm-4 col-xs-4 col-md-4 col-lg-2 block center">
                <a href="/hosp.php">
                    <img src="/images/icons/hp.png" alt="Бакс"/>
                    <span style="color: #c66;"><small> ' . number_format_short($set['hp']) . ' | '.number_format_short($set['max_hp']).' <br>('._TimeSec($hp_time).')</small></span>
                </a>
            </div>
            <div class="col-sm-4 col-xs-4 col-md-4 col-lg-2 block center">
                <a href="/mission.php">
                    <img src="/images/icons/mp.png" alt="Бакс"/>
                    <span style="color: #9cc;"><small> ' . number_format_short($set['mp']) . ' | '.number_format_short($set['max_mp']).' <br>('._TimeSec($mp_time).')</small></span>
                </a>
            </div>
            <div class="col-sm-4 col-xs-4 col-md-4 col-lg-2 block center">
                <a href="/voina.php?case=vrag">
                    <img src="/images/icons/ataka.png" alt="Бакс"/>
                    <span style="color: #ffffff;"><small> ' . $set['udar'] . ' <br>('._TimeSec($udar_time).')</small></span>
                </a>
            </div>
        </div>';
} else {

} */ ?>
<div class="clearfix"></div><?php
if (isset($_SESSION['err'])) { ?>
    <div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?= $_SESSION['err'] ?>
    </div><?php
    $_SESSION['err'] = NULL;
} ?>
<div class="clearfix"></div><?php
/*if (isset($_SESSION['err'])) {
    echo '<div class="error center"><img src="/images/icons/error.png"> ' . $_SESSION['err'] . '</div>';
    $_SESSION['err'] = NULL;
}
if (isset($_SESSION['ok'])) {
    echo '<div class="ok center"><img src="/images/icons/ok.png"> ' . $_SESSION['ok'] . '</div>';
    $_SESSION['ok'] = NULL;
}
if (isset($_SESSION['light'])) {
    echo '<div class="block_light center">' . $_SESSION['light'] . '</div>';
    $_SESSION['light'] = NULL;
}
if (isset($_SESSION['rabot'])) {
    echo '<div class="block_light center text-danger">' . $_SESSION['rabot'] . '</div>';
    $_SESSION['rabot'] = NULL;
}*/


//$ignor_list = explode("|",$set[ignor]);$ili="'99'";
//for($i=0; $i<(count($ignor_list)-1); $i++){$ili="$ili,'$ignor_list[$i]'";}
/*
$tren=$sql->getOne("SELECT id FROM production WHERE user_id =?i",$user_id);
if($tren==true){
$kmb = $sql->getAll("SELECT * FROM production  WHERE user_id =?i AND typ=?i",$user_id,1);
foreach ($kmb as $trn) {
if($trn[status]<3){
if(time()>=$trn[data] and $trn[data]!=0){
switch($trn[status]){
case 0:$nam='фундамент';break;
case 1:$nam='каркас';break;
case 2:$nam='завершение';break;
}
$text="Завершено строительство ($nam) шахты , на участке $trn[num]";
if($trn[status]==2){$gd=rand(200,555);}else{$gd=0;}
$sql->query("INSERT INTO production_logs SET user_id=?s,typ=?i,text=?s,data=?i",$user_id,1,$text,time());
$sql->query("UPDATE production SET status=status+?i,data=?i,gold=?i,timer=?i,gold_a=?i,hp_a=?i WHERE id=?i",
1,0,$gd,90,0,0,$trn[id]);
}}
if($trn[status]==3){
if(time()>=$trn[data] and $trn[data]!=0){
if($trn[hp_a]==30){$s=4;}else{$s=3;}
$text="Шахтёры окончили работу на участке $trn[num]. Добыто <img src='/images/icons/gold.png' alt=''/> $trn[dohod_g] и 
<img src='/images/icons/baks.png' alt=''/> ".number_format_short($trn[dohod_b])."";
$sql->query("INSERT INTO production_logs SET user_id=?s,typ=?i,text=?s,data=?i",$user_id,1,$text,time());
$sql->query("UPDATE user_set SET gold=gold+?i,baks=baks+?i WHERE id=?i",$trn[dohod_g],$trn[dohod_b],$set[id]);
$sql->query("UPDATE production SET data=?i,dohod_g=?i,dohod_b=?i,status=?i WHERE id=?i",0,0,0,$s,$trn[id]);
}}

}} */