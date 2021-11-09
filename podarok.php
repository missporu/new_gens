<?php
require_once('system/up.php');
_Reg();

$stage1 = mysql_fetch_assoc(mysql_query("SELECT * FROM `user_set` WHERE `id` = '$user[id]' ORDER BY `podarok` DESC "));
$stage = ($stage1['podarok']);
$dates=date("d.m.Y"); 
echo'<center><img src="images/donat/5.png"></center>';
	switch ($_GET['mod']) {
		default:
			if($dates < "01.01.2019" && $date > "14.01.2019") {
				echo"<p><b> Подарок можно забрать с <font color='violette'>01.01.19</font> до <font color='violette'>14.01.19</font> (включительно)</b></p><hr/>"; 
				echo"<a href=\"menu.php?\">На главную</a><br/>"; 
				require_once('system/down.php');
				exit;
			}
			echo "Забери свой подарок!";
			if($stage==0) { 
				echo"<br><center><b>Вы можете забрать подарок только один раз!</b><br><font color=lime>Приятной игры</font></span></b><br /><form action='podarok.php?take' method='post'><br/> <center><span class='btn'><span class='end'><input class='label' type='submit' name='take' value='Забрать'/></form></center>";
				if (isset($_GET['take'])) {
					header("Location: ?mod=podarok");
				}
			} 
			if($stage==1) { 
				echo "<center><b><font color=red>Вы уже получили свой подарок</font>! <br/><font color=lightskyblue>Ждите следующего <img src=\"images/smiles/4.gif\" alt=\":)\"></font></b></centet><br><br><a href=\"menu.php?\"><b>На главную</b></a><br/>";
			}
		break;

		case 'podarok':
			if ($stage<1) {
				mysql_query("UPDATE `user_set` SET `gold` = `gold` + '1500000', `podarok`='1' WHERE `id` = ".$user['id']." ");
				echo "<div class='block_light'><hr><center><b><font color=aqua> Uffff!!!</font><br/>";
				echo "В ларце вы нашли 1500000 золота!";
				echo "<font color=lime>Приятной игры!</font><hr></center></div>";
			} else {
				header("Location: ?");
			}
		break;
	}
	require_once('system/down.php');
