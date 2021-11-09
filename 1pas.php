<?php 
$url_do_papki = "http://gmisspo.ru/"; //Ваша ссылка до папки со скриптом. Не забудьте поставить слеш ("/") в конце! 
$login="12345"; //Логин 
$pass=md5("12345"); //Пароль 
$auth="1"; //Вкл/выкл авторизацию 
$dir_true_false = is_dir('upload/'); 
if ($dir_true_false=='') 
{ 
  mkdir("upload/", 0777); 
  header("Location: ".$_SERVER['PHP_SELF']); 
}; 
if(isset($_GET['img'])&&!empty($_GET['img'])) 
 { 
 $images = array(); 
 $images[bg]='R0lGODdhKAAoAKEDAAAkCAArCgA4Df///ywAAAAAKAAoAAAC2oxvEsoBDl9rqNq0snocznyF3xZ5GhiKJ9lJa3qNZSfD8duan43Iubvj9XCzl0I1ESiXSoDACWVKjTIpMxq1Kl9ULfap3Y6q4a8zzB17wVkttWs1h2vqOBuMHsOl8vypKAcgODh4BwX442D4REi4mAj42FhohhhpNin4WHRpmBlo+SOZuZnTifVZOpMYmFppWse36Je0dzXrthN7+0WrQbbWm/u3u9Q3XFvchGuVtlLGPKWn/DjHdfORWCN04FO0LeSdA84tXkJuY05zzW0E6N6urvPX7q7NjlAAADs='; 
 @ob_clean(); 
 header("Content-type: image/gif"); 
 echo base64_decode($images[$_GET['img']]); 
 exit(); 
}; 
if(isset($_GET['style'])) 
 { 
echo ' 
input { 
Font-Family: fantasy; 
Font-size: 10px; 
color: white; Border-color: white; 
Border-style: solid; 
Border-width: 1px; 
BackGround-color: transparent; 
} 
#button { 
BackGround-color: black; 
} 
a { 
text-decoration: none; 
} 
a:link { 
 border-bottom: 1px dotted white; 
 color: #ffffff; 
} 
a:visited { 
 border-bottom: 1px dotted white; 
 color: #ffffff; 
} 
a:active { 
 border-bottom: 1px dotted #ffe5b4; 
 color: #ffe5b4; 
}'; 
exit(); 
}; 
if (isset($_GET['in'])) 
{ 
$nlogin=$_POST['login']; 
$npass=md5($_POST['pass']); 
if ($nlogin == $login and $npass == $pass) 
{ 
setcookie('login',"$nlogin",time()+10000000000); 
setcookie('pass',"$npass",time()+10000000000); 
header("Location:" .$_SERVER['PHP_SELF']); 
} 
else {header("Location:" .$_SERVER['PHP_SELF']);} 
} 
if($_COOKIE["login"] != "$login" or $_COOKIE["pass"] != "$pass"){ 

if($auth == "0"){setcookie("login", "$login", time()+10000); setcookie("pass", "$pass", time()+10000); echo "<script> document.location.replace('$SCRIPT_NAME'); </script>";} 
echo " 
<head> 
<link rel='stylesheet' type='text/css' href='?style' /> 
<meta http-equiv='content-type' content='text/html; charset=utf-8' /> 
<title>Вход</title> 
<link type=text/css rel=StyleSheet href=?style> 
</head> 
<body background=?img=bg> 
<br><br><br><br> 
<center> 
<font color=white size=10 face=fantasy> 
<form method=post action=?in> 
<table style=text-align: left; width: 100px; border=0 cellpadding=2 cellspacing=2> 
  <tbody> 
    <tr> 
      <td><font size='4' face='fantasy' color='white'>Логин:</font></td> 
      <td><input name=login></td> 
    </tr> 
    <tr> 
      <td><font size='4' face='fantasy' color='white'>Пароль:</font></td> 
      <td><input name=pass type=password></td> 
    </tr> 
    <tr> 
      <td></td> 
      <td><input type=submit id=button value=Вход></td> 
    </tr> 
   </table> 
  </tbody> 
</form> 
</font> 
</center> 
</body>"; 
exit(); 
} 
else 
{ 

if(isset($_GET['upload'])) { 
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'; 
echo '<link rel="stylesheet" type="text/css" href="?style" />'; 
echo '<body background="?img=bg">'; 
echo '<font size="4" face="fantasy" color="white">'; 
$uploaddir = "/home/a9526880/public_html/mini-host/upload"; 
     $arr = array('a','b','c','d','e','f', 
                 'g','h','i','j','k','l', 
                 'm','n','o','p','r','s', 
                 't','u','v','x','y','z', 
                 'A','B','C','D','E','F', 
                 'G','H','I','J','K','L', 
                 'M','N','O','P','R','S', 
                 'T','U','V','X','Y','Z', 
                 '1','2','3','4','5','6', 
                 '7','8','9','0','-','_'); 
    $rand = ""; 
    for($i = 0; $i < 30; $i++) 
    { 
      $index = rand(0, count($arr) - 1); 
      $rand .= $arr[$index]; 
    } 
$img_format; 
if ($_FILES['userfile']['type'] == 'image/jpeg') { 
    $img_format= '.jpg'; 
}; 
if ($_FILES['userfile']['type'] == 'image/png') { 
    $img_format= '.png'; 
}; 
if ($_FILES['userfile']['type'] == 'image/gif') { 
    $img_format= '.gif'; 
}; 
$rand_and_format= $rand.$img_format; 
if (($_FILES['userfile']['type'] == 'image/jpeg')|($_FILES['userfile']['type'] == 'image/png')|($_FILES['userfile']['type'] == 'image/gif')) { 
if (move_uploaded_file($_FILES['userfile']['tmp_name'], 'upload/' . $rand_and_format)) { 
 echo "Картинка успешно загружена! :)<br/>"; 
 echo '<title>'.$_FILES['userfile']['name'].'</title>'; 
 echo " 
<table style=text-align: left; width: 100px; border=0 cellpadding=2 cellspacing=2> 
 <tbody> 
 <tr><td><h3><font size='4' face='fantasy' color='white'>Информация о изображении: </font></h3></td><td></td></tr> 
 <tr><td><b><font size='4' face='fantasy' color='white'>Оригинальное имя:</td><td><font size='4' face='fantasy' color='white'>".$_FILES['userfile']['name']."</font></b></td></font></tr> 
 <tr><td><b><font size='4' face='fantasy' color='white'>Mime-тип:</td><td><font size='4' face='fantasy' color='white'>".$_FILES['userfile']['type']."</font></b></td></font></tr> 
 <tr><td><b><font size='4' face='fantasy' color='white'>Вес картинки в байтах:</td><td><font size='4' face='fantasy' color='white'>".$_FILES['userfile']['size']."</font></b></td></font></tr> 
 <tr><td><b><font size='4' face='fantasy' color='white'>Ссылка на картинку:</td><td><font size='4' face='fantasy' color='white'><input type=text size=120 value='".$url_do_papki."upload/".$rand_and_format."'></font></b></td></font></tr> 
 <tr><td><b><font size='4' face='fantasy' color='white'>Ссылка на картинку BB-code:</td><td><font size='4' face='fantasy' color='white'><input type=text size=120 value='[img]".$url_do_papki."upload/".$rand_and_format."[/img]'></font></b></td></font></tr> 
 <tr><td><b><font size='4' face='fantasy' color='white'>Ссылка на картинку HTML:</td><td><font size='4' face='fantasy' color='white'><input type=text size=120 value='<img src=".$url_do_papki."upload/".$rand_and_format.">'></font></b></td></font></tr> 
 </tbody> 
</table> 
"; 
 echo '<br/><br/>'; 
} else { 
 echo '<center><font color=white size="8">Ошибка! :(<br/>А загружали ли вы файл вообще? ;)</font><br/><a href="'.$_SERVER['PHP_SELF'].'"><input type=button id=button value=Назад></a></center>'; 
 echo '<title>Ошибка :(</title>'; 
} 
 echo '<a href='.$_SERVER['PHP_SELF'].'><input type=button id=button value=Назад></a><br><br>'; 


 echo '<style type="text/css"> 
    #invdiv { 
      display: none; 
    } 
  </style> 
  <script type="text/javascript"> 
    vis = false; 
    function inputclk() { 
      var inp = document.getElementById ("inputid"); 
      var div = document.getElementById ("invdiv"); 
      if (vis) { 
        div.style.display = "none"; 
        inp.value = "Hidden"; 
        vis = false; 
      } else { 
        div.style.display = "block"; 
        inp.value = "Visible"; 
        vis = true; 
      } 
    } 
  </script>'; 


 echo ' 
<br/> 
<center><input type="button" id="button" value="Показать картинку" readonly="readonly" onclick="inputclk()" /><br /> 
<div id="invdiv"> 
 <br/> 
 <img src="upload/'.$rand_and_format.'" border=1> 
</div></center> 
'; 
 echo '<br/>'; 
 echo "</font>"; 
 echo "</body>"; 
} else { 
    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'; 
    echo '<link rel="stylesheet" type="text/css" href="?style" />'; 
    echo '<body background="?img=bg">'; 
    echo '<font size="6" face="fantasy" color="white">'; 
    echo '<center><font size="6" face="fantasy" color="white">Это не картинка...</font></cenetr>'; 
    echo '<center><a href="'.$_SERVER['PHP_SELF'].'"><input type=button id=button value=Назад></a></center>'; 
    echo '</font>'; 
    echo '</body>'; 
} 
} else { 
if(isset($_GET['exit'])) 
 { 
 echo " 
<meta http-equiv='content-type' content='text/html; charset=utf-8' /> 
<title>Выход</title> 
<font color='white' size=2 face=fantasy> 
<body background='?img=bg'> 
<link type=text/css rel=StyleSheet href=?style><center><br><br><br><br>Вы уверены?<br><br><a href=".$_SERVER['PHP_SELF']."?delc_y><input type=button id=button value=Да></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=".$_SERVER['PHP_SELF']."><input id=button type=button value=Нет></a></center> 
</font>"; 
exit(); 
} else { 
echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />'; 
echo '<title>Site :)</title>'; 
echo '<link rel="stylesheet" type="text/css" href="?style" />'; 
echo '<body background="?img=bg">'; 
echo '<font color="white" size=2 face=fantasy>'; 
echo '<center>'; 
if ($auth==1) 
{ 
  echo '<a href=?exit>Выход</a>'; 
} 
echo '<br/><br/>Поддерживаются форматы PNG, JPG, GIF<br/><br/>'; 
echo '<form enctype="multipart/form-data" action="?upload" method="post">'; 
echo '<input type="hidden" name="MAX_FILE_SIZE" value="10485760">'; 
echo 'Загрузить картинку (не более 10 мб): <input name="userfile" type="file">'; 
echo '<input type="submit" id=button value="Загрузить"><br/><br/><font size=1>Made By Nikitosavich</font>'; 
echo '</form>'; 
echo '</cenetr>'; 
echo '</font>'; 
echo '</body>'; 
} 
} 
} 
if(isset($_GET['delc_y'])) 
 { 
 setcookie('login'); 
 setcookie('pass'); 
 header("Location: ".$_SERVER['PHP_SELF']); 
} 
?> 