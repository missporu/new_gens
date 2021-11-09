<?php
///$title='Главная';
require_once ('system/up.php');
_Reg();

if($set['sex']=='m'){
$sex_pers='m';
}else{
$sex_pers='w';
}
?>
<div class="row cont">
    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3">
    	<a class="button btn-default btn-block" href="voina.php?case=vrag"> Война </a>
    </div>
    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3">
    	<a href="#" class="button btn-default btn-block"> В разработке </a>
    </div>
    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3">
    	<a class="button btn-default btn-block" href="mission.php">Миссии</a>
    </div>
    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3">
    	<a class="button btn-default btn-block" href="production.php">Производство</a>
    </div>
    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3">
    	<a class="button btn-default btn-block" href="unit.php">Техника</a>
    </div>
    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3">
    	<a class="button btn-default btn-block" href="build.php">Постройки</a>
    </div>
    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3">
    	<a class="button btn-default btn-block" href="blackmarket.php">Черный рынок</a>
    </div>
    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3">
    	<a class="button btn-default btn-block" href="ofclub.php">Клуб офицеров</a>
    </div>
</div>
<hr><hr>
<div class="row cont">
    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3 heading">
    <a href="pers.php">
        <img src='/img/profil.png' class="img-responsive" alt=''/>
    </a>
    </div>
    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3 heading">
    <a href="raiting.php">
        <img src='/img/zals.png' class="img-responsive" alt=''/>
    </a>
    </div>
    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3 heading">
    <a href="alliance.php">
        <?=$plus_priglas?>
    </a>
    </div>
    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3 heading">
    <a href="rooms.php?case=room">
        <img src='/img/chat.png' class="img-responsive" alt=''/>
    </a>
    </div>
    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3 heading">
    <a href="bank.php">
        <img src='/img/bank.png' class="img-responsive" alt=''/>
    </a>
    </div>
    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3 heading">
    <a href="mail.php">
        <?=$plus_mail?>
    </a>
    </div>
    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3 heading">
    <a href="hosp.php"> 
        <img src='/img/hosp.png' class="img-responsive" alt=''/>
    </a>
    </div>
    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3 heading">
    <a href="news.php">
        <?=$plus_news?>
    </a>
    </div>
</div>
<?php if ($set['pasha']>0) {
?>
	<div class="mini-line"></div><div class="block_zero center"><a href="pashalka.php"><div class="head"><span style="color: #9bc;">Обмен пасхальных яиц!</span></div></a></div><?
}
if ($set['podarok']==0) {
?>
	<div class="mini-line"></div><div class="block_zero center"><a href="podarok.php"><div class="head"><span style="color: #9bc;">Подарки сервера!</span></div></a></div><?
}
if($set['prava']>=4){
?><div class="mini-line"></div><div class="block_zero center"><a href="admin.php"><div class="head"><span style="color: #9bc;">Админ - панель</span></div></a></div><?
}
if($set['prava']>1){
?><div class="mini-line"></div><div class="block_zero center"><a href="moder.php"><div class="head"><span style="color: #9bc;">Модерка </span></div></a></div><?
}
require_once ('system/down.php');
?>