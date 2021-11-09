<?
$title = 'Почта';
define('H', $_SERVER['DOCUMENT_ROOT'].'/');
require H."system/up.php";
_Reg();
if ($set['ban']==1) {
$_SESSION['err']='Вы забанены на общение.';
header("Location: /menu.php");
exit();
}
if ($set['block']==1) {
header("Location: /blok.php");
exit();
}
if($ref[0]){echo'<div class="menuList">
<li><a href="?"><img src="images/icons/arrow.png" alt="*"/>Другие сообщения</a></li></div>';}
if(!$ref[0]){
$sql->query("UPDATE mail SET status=?i WHERE komu=?i",1,$user_id);
$rec =$sql->getOne("SELECT count(id) from mail WHERE komu=?i and typ=?i and kto NOT IN ($ili)",$user_id,1);
if($rec==true){
if($rec>0){
echo'<div class="menuList">
<li><a href="?dell"><img src="images/icons/arrow.png" alt="*"/>Удалить все сообщения</a></li></div>';
}
echo'<form action="?del:'.$ref[1].'" method="post">';
?>Выбрать все
<input type='checkbox' name='sel_all' onChange='for (i in this.form.elements) this.form.elements[i].checked = this.checked'>
<br/><?}
$sum=10;
$page = $ref[1];
$get="";
$posts = $rec;
$total = (($posts - 1) / $sum) + 1;
$total =  intval($total);
$page = intval($page);
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $sum - $sum;
if($posts>0){$r = $sql->getAll("SELECT * FROM mail WHERE  komu=?i and typ=?i  and kto NOT IN ($ili) ORDER BY id DESC LIMIT ?i,?i",$user_id,1,$start,$sum);
foreach ($r as $m) {
$kto=$sql->getOne("SELECT login FROM user_reg WHERE id=?i LIMIT ?i",$m[kto],1);


echo"<input type='checkbox' name='topol[]' value='$m[id]' id='qwe'/>[$m[date]-$m[time]]<p class='text-danger'>$kto</p>[$m[text]]<br/><hr>";

echo"<a href='?mess:$m[kto]'>Переписка</a><br/>";

}
echo'<input type="submit" name="formSubmit" value="Удалить выбранные" />
</form> ';


}else{echo"Писем нет<br/>";}
put($page,$get,$total);

}
if($ref[0]=='del'){
$kant=$_POST['topol'];
if(empty($kant)){
go("?:$ref[1]");
}else{
$n=count($kant);
for($i=0;$i<$n;$i++)
{
$sql->query("UPDATE mail SET typ=?i WHERE id=?i and komu=?i",0,$kant[$i],$user_id);
}
go("?:$ref[1]");
}}
if($ref[0]=='dell'){
if(!$ref[1]){
echo"Действительно хотите удалить всю почту?<br/>
<a href='?dell:ok'>Да,хочу всё удалить</a><br/>";
}else{
$sql->query("UPDATE mail SET typ=?i WHERE komu=?i",0,$user_id);
go("?");
}}
if($ref[0]=='d_mess'){
if(($sql->getOne("SELECT count(id) FROM mail WHERE kto=?i and komu=?i",$ref[1],$user_id))==true){
if(!$ref[2]){
echo"Действительно хотите удалить всю переписку?<br/>
<a href='?d_mess:$ref[1]:ok'>Да,хочу всё удалить</a><br/>";
}else{
$sql->query("UPDATE mail SET typ=?i WHERE komu=?i and kto=?i",0,$user_id,$ref[1]);
go("?");
}}}
if($ref[0]=='ignor'){
$data_id=_NumFilter($ref[1]);
$login=$sql->getOne("SELECT login FROM user_reg WHERE id=?i LIMIT ?i",$data_id,1);
if($login==true){
$ig=$sql->getOne("SELECT id FROM user_set WHERE ignor LIKE CONCAT('%','$data_id', '%') and user=?s",$user[login]);
if($ig==true){
echo"Игрок уже в игноре<br/>";
}else{
if(!$ref[2]){
echo"Добавить игрока $login в игнор?<br/>процесс необратим<br/>
<a href='?ignor:$ref[1]:ok'>Да,добавить в игнор</a><br/>";
}else{
$lli="$set[ignor]$data_id|";
$sql->query("UPDATE user_set SET ignor=?s WHERE id=?i",$lli,$user_id);
go("?");
}}
}else{go("?mess:$data_id");}
}
if($ref[0]=='mess'){
$data_id=_NumFilter($ref[1]);
echo'<div class="menuList">
<li><a href="?d_mess:'.$data_id.'"><img src="images/icons/arrow.png" alt="*"/>Удалить переписку</a></li>
<li><a href="?ignor:'.$data_id.'"><img src="images/icons/arrow.png" alt="*"/>Добавить в игнор</a></li>
</div>';
if (!$_POST) {
$login=$sql->getOne("SELECT login FROM user_reg WHERE id=?i LIMIT ?i",$data_id,1);
echo'<div class="mini-line"></div><div class="block_zero center"><form action="?mess:'.$data_id.'" method="post"><input class="text large" type="text" name="login" value="'.$login.'" /><br/>Текст сообщения:<br/><textarea class="text large" type="text" name="text" rows="5" cols="50" placeholder=""/></textarea><br/><span class="btn"><span class="end"><input class="label" type="submit" name="send" value="Отправить"></span></span> </a></form></div>';

$rec =$sql->getOne("SELECT count(id) from mail WHERE komu=?i and kto=?i or (komu=?i and kto=?i) and typ=?i",$user_id,$data_id,$data_id,$user_id,1);
$sum=10;
$page = $ref[2];
$get="mess:$ref[1]";
$posts = $rec;
$total = (($posts - 1) / $sum) + 1;
$total =  intval($total);
$page = intval($page);
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $sum - $sum;
if($posts>0){$r = $sql->getAll("SELECT * FROM mail WHERE  komu=?i and kto=?i  or (komu=?i and kto=?i) and typ=?i ORDER BY id DESC LIMIT ?i,?i",$user_id,$data_id,$data_id,$user_id,1,$start,$sum);
foreach ($r as $m) {
$kto=$sql->getOne("SELECT login FROM user_reg WHERE id=?i LIMIT ?i",$m[kto],1);
if(($kto)==$set[user]){$kto="Вы";}

echo"[$m[date]-$m[time]]<p class='text-danger'>[$kto]</p>[$m[text]]<br/><hr>";

}


}else{echo"Писем нет<br/>";}
put($page,$get,$total);
}else{
$data_id=_NumFilter($ref[1]);
$name = _TextFilter($_POST['login']);
$text = _TextFilter($_POST['text']);  
if(($sql->getOne("SELECT id FROM user_reg WHERE id=?i and login=?s",$data_id,$name))==true){
if (strlen($text) < 1 OR strlen($text) > 1500) {
$_SESSION['err'] = 'Длина сообщения 1-1500 символов.';
go("?mess:$data_id");
exit();
}else{
$sql->query("INSERT INTO mail SET komu=?i, kto=?i, text=?s, date=?s, time=?s",$data_id,$user_id,$text,$dater,$timer);
go("?mess:$data_id");
}}else{
$_SESSION['err'] = 'Вы пытались отправить сообщение другому игроку';
go("?");
}
}
}

require H."system/down.php";
?>