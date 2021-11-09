<?
$title = 'Техника';
define('H', $_SERVER['DOCUMENT_ROOT'].'/');
require H."system/up.php";
_Reg();
if ($set['block']==1) {
header("Location: /blok.php");
exit();
}
if($ref[0]){
echo'<div class="menuList">
<li><a href="?"><img src="//gmisspo.ru/images/icons/arrow.png" alt="*"/>Техника</a></li></div><div class="mini-line">
</div>';
}
if(!$ref[0]){
?><div class="main"><?
if ($set['logo'] == 'on') {
?><img src="images/logotips/unit.jpg" width="100%" alt="Техника"/><div class="mini-line"></div><?
}
?><div class="menuList"><li><a href="?purch:1"><img src="images/icons/arrow.png" alt="*"/>Наземная</a></li><li><a href="?purch:2"><img src="images/icons/arrow.png" alt="*"/>Морская</a></li><li><a href="?purch:3"><img src="images/icons/arrow.png" alt="*"/>Воздушная</a></li><li><a href="?super"><img src="images/icons/arrow.png" alt="*"/>Разработки</a></li></div><div class="mini-line"></div><ul class="hint"><li>Цена продажи техники уменьшается от цены покупки на 10%.</li><li>Техника используется в битвах с другими игроками, а также при выполнении заданий.</li><li>Возле каждой единицы техники в меню покупки указаны ее название, параметры атаки, защиты, количество уже имеющейся у Вас техники такого вида, а также цена содержания данной единицы техники и ее стоимость.</li><li>С достижением новых уровней открывается новая техника, доступная к приобретению.</li><li>Приобретая технику, стоит учитывать не только ее цену, но и цену ее содержания. Каждый час на содержание армии с Вашего счета снимается соответствующая сумма.</li></ul></div></div></div><?
}
if($ref[0]=='purch'){
$tip=zif($ref[1]);
        if ($tip < 1 OR $tip > 6) {
            $_SESSION['err'] = 'Нет техники такого типа';
            header('Location: unit');
            exit();
        }
$tip_gold = $tip+3;
if(!$_POST){
?><div class="main"><div class="block_zero"><span style="color: #999;"><small><?
        if ($tip == 1) {
?>Наземная техника имеет сбалансированные параметры атаки и защиты.<?
        } elseif ($tip == 2) {
?>Морская техника имеет большие параметры защиты.<?
        } else {
?>Авиационная техника имеет большие параметры атаки.<?
        }
?></span></div><div class="dot-line"></div><div class="block_zero"><span style="color: #999;">Доход:<span style="float: right;"> <?= $set['dohod'] ?></span><br/>Содержание:<span style="float: right;"> <?= $set['soderzhanie'] ?></span><br/>Чистая прибыль:<span style="float: right;"> <?= $set['chistaya'] ?></small></span></span></div><?
    $rec =$sql->getOne("SELECT count(id) from user_unit WHERE id_user=?i and tip=?i",$user_id,$tip);
    $sum=5;
    $page = $ref[2];
    $get="purch:$ref[1]";
    $posts = $rec;
    $total = (($posts - 1) / $sum) + 1;
    $total =  intval($total);
    $page = intval($page);
    if(empty($page) or $page < 0) $page = 1;
    if($page > $total) $page = $total;
    $start = $page * $sum - $sum;
   $r = $sql->getAll("SELECT * FROM user_unit WHERE  id_user=?i and tip IN(?i,?i) ORDER BY id DESC LIMIT ?i,?i",$user_id,$tip,$tip_gold,$start,$sum);
    foreach ($r as $user_unit) {
        if($user_unit['tip']==($tip+3)){
        $unit_color='f96';
        $scr='gold';
$rr=$set['gold'];
        }else{
        $unit_color='999';
        $scr='baks';
$rr=$set['baks'];
        }

?><div class="mini-line"></div><div class="block_zero"><span style="color: #<?=$unit_color?>;"><?= $user_unit['name'] ?> - <?= $user_unit['kol'] ?></span></div><div class="dot-line"></div><table width="100%"><tr><td width="25%"><img class="float-left" src="images/units/<?= $user_unit['id_unit'] ?>.png" width="115px" height="80px" style="margin-left:0px;margin-right:0px;border:1px solid #<?=$unit_color?>;" alt="Техника"></td><td><span style="color: #<?=$unit_color?>;">Атака/Защита<span style="float: right;"><?= $user_unit['ataka'] ?>/<?= $user_unit['zaschita'] ?></span><br />Содержание:<span style="float: right;"><?= $user_unit['soderzhanie'] ?></span><br />Цена:<span style="float: right;"><img src="images/icons/<?=$scr?>.png" alt="*" /><?= $user_unit['cena'] ?></span><br /><form action="unit?purch:<?= $user_unit['tip'] ?>:<?= $user_unit['id_unit'] ?>:<?= $page ?>" method="POST">Количество:</span><?
        if($user_unit['tip']>3){ 
        ?><span style="float: right;"><?
        }
        ?><input class="text" type="text" value="1" size="3" maxlength="3" name="kol"><?
        if($user_unit['tip']>3){ 
        ?></span><?
        }
        ?><br/><span class="btn"><span class="end"><input class="label" name="send" type="submit" value="Купить"/></span></span><?
        if($user_unit['tip']<4){
        ?><span class="btn"><span class="end"><input class="label" name="prod" type="submit" value="Продать"/></span></span><?
        }
        ?></form></td></tr></table><?

    }
put($page,$get,$total);
}else{
                        if (isset($_POST['send'])) {
                        $id_unit = zif($ref[2]);
                        if($tip<4){
                        $scr='baks';
                        $rr=$set['baks'];
                        }else{
                        $scr='gold';
                        $rr=$set['gold'];
                        }
                        $kol = zif($_POST['kol']);            
                        if ($kol == 0) {
                        $_SESSION['err'] = 'Не введено колличество';
                        if  ($tip<4){
                        header('Location: unit?purch:' . $tip . ':' . $ref[3] . '');
                        } else {
                        header('Location: unit?purch:' . ($tip-3) . ':' . $ref[3] . '');
                        }
                        exit();
                        }
                        $uni=$sql->getRow("SELECT * FROM unit WHERE id=?i and tip=?i",$id_unit,$tip);
                        $trof_set=$sql->getRow("SELECT * FROM user_trofei WHERE id_user=?i AND id_trof=?i LIMIT ?i",$user_id,4,1);

                        if($trof_set['status']==1 AND $trof_set['time_up']==0){
                        $sdr=$uni['soderzhanie']/100*$trof_set['bonus_1'];
                        }else{
                        $sdr=$uni['soderzhanie'];
                        }
                        if ($set['side'] == 'c') {
                        $unit_cena=$uni['cena']*0.8;
                        }else{
                        $unit_cena=$uni['cena'];               
                        }
                        $sd=0;
                        for ($i = 1; $i <= $kol; $i++) {
                        $sd=$sd+$sdr;
                        if(($set['soderzhanie']+$sd)>$set['dohod'])break;
                        }
                        if($i<$kol){$error= 'Содержание больше дохода,<br/>покупка техники приостановлена!<br/>';}
                        $kupleno=$i-1;
                        $soderzh=($i-1)*$sdr;
                        $bk=0;
                        for ($i = 1; $i <= $kupleno; $i++) {
                        $bk=$bk+$unit_cena;
                        if($bk>$rr)break;
                        }
                        if($i<$kupleno){
                        if($scr=='baks'){
                        $error.= 'Не хватает баксов,<br/>приобретено ' . ($i - 1) . ' ед.';
                        }else{
                        $error.= 'Не хватает золота,<br/>приобретено ' . ($i - 1) . ' ед.';
                        }
                        }
                        $kupleno=$i-1;
                        $baks=($i-1)*$unit_cena;
                        $_SESSION['err']=$error;
if($kupleno>0){
                        $_SESSION['ok'] = 'Покупка успешно завершена,<br/>приобретено ' . $kupleno . ' ед.';
}

                        $sql->query("UPDATE user_unit SET kol=kol+?i WHERE id_user=?i AND id_unit=?i LIMIT ?i",$kupleno,$user_id,$id_unit,1);
for ($i = 1; $i <= $kupleno; $i++) {
$sql->query("INSERT INTO voina_unit (id_user,id_unit,tip,ataka,zaschita) VALUES('".$user_id."','".$id_unit."','".$tip."','".$uni['ataka']."','".$uni['zaschita']."')");
}
                        $sql->query("UPDATE user_set SET $scr=$scr-?i WHERE id=?i LIMIT ?i",$baks,$user_id,1);
                        $sql->query("UPDATE user_set SET soderzhanie=soderzhanie+?i, chistaya=chistaya-?i WHERE id=?i LIMIT ?i",$soderzh,$soderzh,$user_id,1);

                        if  ($tip<4){
                        header('Location: unit?purch:' . $tip . ':' . $ref[3] . '');
                        } else {
                        header('Location: unit?purch:' . ($tip-3) . ':' . $ref[3] . '');
                        }
                        }




                        if (isset($_POST['prod'])) {
$id_unit = zif($ref[2]);
                        $kol = zif($_POST['kol']);
                        if ($kol == 0) {
                        $_SESSION['err'] = 'Не введено колличество';
                        if  ($tip<4){
                        header('Location: unit?purch:' . $tip . ':' . $ref[3] . '');
                        } else {
                        header('Location: unit?purch:' . ($tip-3) . ':' . $ref[3] . '');
                        }
                        exit();
                        }
$prodazha = $sql->getRow("SELECT * FROM user_unit WHERE id_user=?i AND id_unit=?i LIMIT ?i",$user_id,$id_unit,1);
if ($kol>$prodazha[kol]) {
$prod=$prodazha[kol];
$_SESSION['err'] = 'Не хватает техники,<br/>продано ' . $prodazha[kol] . ' ед.';
}else{
$prod=$kol;
}
$baks=round($prod*($prodazha[cena]-($prodazha[cena]/10)));
$trof_set=$sql->getRow("SELECT * FROM user_trofei WHERE id_user=?i AND id_trof=?i LIMIT ?i",$user_id,4,1);

if($trof_set['status']==1 AND $trof_set['time_up']==0){
$sdr=$prodazha['soderzhanie']/100*$trof_set['bonus_1'];
}else{
$sdr=$prodazha['soderzhanie'];
}
$soderzh=$prod*$sdr;
$sql->query("UPDATE user_unit SET kol=kol-?i WHERE id_user=?i AND id_unit=?i LIMIT ?i",$prod,$user_id,$id_unit,1);
for ($i = 1; $i <= $prod; $i++) {
$sql->query("DELETE FROM voina_unit WHERE id_user=?i AND id_unit=?i LIMIT ?i",$user_id,$id_unit,1);
}
$sql->query("UPDATE user_set SET baks=baks+?i, soderzhanie=soderzhanie-?i, chistaya=chistaya+?i WHERE id=?i LIMIT ?i",$baks,$soderzh,$soderzh,$user_id,1);
if($prod>0 and $kol<=$prodazha[kol]){
$_SESSION['ok'] = 'Продажа успешно завершена,<br/>продано ' . $prod . ' ед.';
}
            header('Location: unit?purch:' . $tip . ':' . $ref[3] . '');
            exit();
                        }

}
}

if($ref[0]=='super'){


}
require H."system/down.php";
?>