<?php
$title = 'Общение';
require_once('system/up.php');
_Reg();
if ($set['block']==1) {
    header("Location: blok.php");
    exit();
}
/*if ($set[prava]>=5) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
} */ 
if ($set['id'] == 0) {
exit('чат на ремонте');
} ?>
<style>
 textarea.form-control {
 resize: vertical;
 overflow-y: hidden;
 padding: 10px 10px;
 margin: 10px 10px;
 border: 10px solid;
 }
.img-sm {
 width: 46px;
 height: 46px;
}
.panel {
 box-shadow: 0 2px 0 rgba(0,0,0,0.075);
 border-radius: 0;
 border: 0;
 margin-bottom: 15px;
}
.panel .panel-footer, .panel>:last-child {
 border-bottom-left-radius: 0;
 border-bottom-right-radius: 0;
}
.panel .panel-heading, .panel>:first-child {
 border-top-left-radius: 0;
 border-top-right-radius: 0;
}
.panel-body {
 padding: 25px 20px;
}
.media-block .media-left {
 display: block;
 float: left
}
.media-block .media-right {
 float: right
}
.media-block .media-body {
 display: block;
 overflow: hidden;
 width: auto
}
.middle .media-left,
.middle .media-right,
.middle .media-body {
 vertical-align: middle
}
.thumbnail {
 border-radius: 0;
 border-color: #e9e9e9
}
.tag.tag-sm, .btn-group-sm>.tag {
 padding: 5px 10px;
}
.tag:not(.label) {
 background-color: #fff;
 padding: 6px 12px;
 border-radius: 2px;
 border: 1px solid #cdd6e1;
 font-size: 12px;
 line-height: 1.42857;
 vertical-align: middle;
 -webkit-transition: all .15s;
 transition: all .15s;
}
.text-muted, a.text-muted:hover, a.text-muted:focus {
 color: #acacac;
}
.text-sm {
 font-size: 0.9em;
}
.text-5x, .text-4x, .text-5x, .text-2x, .text-lg, .text-sm, .text-xs {
 line-height: 1.25;
}
.btn-trans {
 background-color: transparent;
 border-color: transparent;
 color: #929292;
}
.btn-icon {
 padding-left: 9px;
 padding-right: 9px;
}
.btn-sm, .btn-group-sm>.btn, .btn-icon.btn-sm {
 padding: 5px 10px !important;
}
.mar-top {
 margin-top: 15px;
}
</style>

<div class="row"><?php
$timeban = ($set['ban_time']-time());
$ban_prichina = mysql_query("SELECT * FROM `block` WHERE `kto`='".$set['id']."' AND `tip`='1' ORDER BY `id` DESC LIMIT 1");
$ban = mysql_fetch_array($ban_prichina);
if ($_GET['case'] != 'room') { ?>
	<div class="col-md-6 col-sm-6 col-xs-6"><a class="btn btn-outline-primary btn-block" href="rooms.php?case=room"><img src="images/icons/arrow.png" alt="*" />Выбор чата</a></div>
	<div class="col-md-6 col-sm-6 col-xs-6 text-right"><a class="btn btn-outline-primary btn-block" href="rooms.php?case=smile"><img src="images/icons/arrow.png" alt="*" />Смайлы</a></div></div><?php
}
switch ($_GET['case']) {
    default:
        if (isset($_GET['tip'])) {
        if($_GET['tip']<1 OR $_GET['tip']>10){
        $_SESSION['err'] = 'Нет такого чата!';
            header('Location: menu.php');
            exit();
        }
        if ($_GET['tip']==10) {
            if ($set['prava']<2) {
                $_SESSION['err'] = 'Нет такого чата!';
                header('Location: menu.php');
                exit();
            }
        }
            $tip = _NumFilter($_GET['tip']);
            if ($tip == 1) $chat = "Общая комната";
            elseif ($tip == 2) $chat = "Поиск альянса";
            elseif ($tip == 3) $chat = "Поиск легиона";
            elseif ($tip == 4) $chat = "Учебка";
            elseif ($tip == 5) $chat = "Поломки в игре";
            elseif ($tip == 6) $chat = "Игровая комната";
            else $chat = "комната мд";
        } ?>
        <div class="row">
            <center>
                <br><h1><?= $chat ?></h1><br>
            </center>
        	<div class="col-md-12"><?php
        	if ($set['ban']==1) {
        		echo "Вы забанены. Осталось "._Time($timeban)." <br>
        		Причина: ".$ban['text']." <hr>";
        	} else {
        		if (isset($_GET['komu'])) {
	                $id_komu = _NumFilter($_GET['komu']);
	                $komu    = _FetchAssoc("SELECT * FROM `user_reg` WHERE `id` = '" . $id_komu . "' LIMIT 1"); ?>
	                <form action="rooms.php?case=post&tip=<?= $tip ?>" method="POST">
	                    <span class="form-group">
	                    <textarea class="form-control auto-size" rows="6" name="text"><?= $komu['login'] ?>, </textarea>
	                    </span>
	                    <input class="btn btn-primary btn-block" type="submit" value="Отправить">
	                </form><?php
	            } else { ?>
	                <form action="rooms.php?case=post&tip=<?= $tip ?>" method="POST">
	                    <span class="form-group">
	                    <textarea class="form-control auto-size" rows="6" name="text"></textarea>
	                    </span>
                        <input type="checkbox" name="privat" value="ap">Отправить приватно<Br> 
	                    <input class="btn btn-outline-primary btn-block" type="submit" value="Отправить">
	                </form><hr><?
	            }
        	} ?>

	            <!-- Вывод под кнопку чего-нибудь -->
	            <div class="row text-center"></div><hr>
	            <div class="row"><?php

                $rec =$sql->getOne("SELECT count(id) from chat WHERE tip=?i AND status=?i AND status=?i",$tip,1,5);
                $sum=10;
                $page = $ref[2];
                $get="tip=".$tip.":page";
                $posts = $rec;
                $total = (($posts - 1) / $sum) + 1;
                $total =  intval($total);
                $page = intval($page);
                if(empty($page) or $page < 0) $page = 1;
                if($page > $total) $page = $total;
                $start = $page * $sum - $sum;

		        $data   = mysql_query("SELECT * FROM `chat` WHERE `tip`='" . $tip . "' AND `status`='1' AND `status`='5' ORDER BY `id` DESC LIMIT $start,$sum");
		        while ($rooms = mysql_fetch_assoc($data)) {
		        	$rooms_user     = _FetchAssoc("SELECT * FROM `user_reg` WHERE `id`='" . $rooms['id_user'] . "' LIMIT 1");
		            $set_rooms_user = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $rooms_user['id'] . "' LIMIT 1");
		            if ($set_rooms_user['prava'] == 5) {
		                $color = '40ff00';
		                $shadow = '1px 1px 3px #bb40bd';
		                $dolg = 'GM';
		            } elseif ($set_rooms_user['prava'] == 2) {
		                $color = '52d9d0';
		                $shadow = '';
		                $dolg = 'MD';
		            } elseif ($set_rooms_user['prava'] == 3) {
		                $color = 'FF69B4';
		                $shadow = '';
		                $dolg = 'SMD';
		            } elseif ($set_rooms_user['prava'] == 4) {
		                $color = '0c0';
		                $shadow = '1px 1px 4px #09f';
		                $dolg = 'ADM';
		            } elseif ($set_rooms_user['prava'] == 0) {
		                $color = 'fff';
		                $shadow = '';
		                $dolg = '';
		            } elseif ($set_rooms_user['prava'] == 100) {
		                $color = 'f00';
		                $shadow = '';
		                $dolg = '';
		            } ?>
		            <div class="media-block"><?php
                    if ($set['prava']>1) { ?>
                        <div class="col-xs-9 col-sm-9 col-md-9"><?php
                    } else { ?>
                        <div class="col-xs-12 col-sm-12 col-md-12"><?php
                    }
                    if ($rooms[status]==1) { ?>
		            		<a class="media-left" href="#">
		                        <img src="images/sex/<?= $set_rooms_user['sex'] ?>.png" alt="Пол"><br>
		                        <img src="images/flags/<?= $set_rooms_user['side'] ?>.png" alt="Флаг"/>
		                    </a>
		                    <div class="media-body">
		                        <div class="mar-btm">
		                            <a href="view.php?smotr=<?= $rooms_user['id'] ?>" class="btn-link text-semibold media-heading box-inline"><span style="color: #<?= $color ?>; text-shadow: <?=$shadow?>;"><?= $rooms_user['login'] ?></a>
		                            <p class="text-muted text-sm"><i class="fa fa-mobile fa-lg"></i> - <?= $rooms['date'] ?> в <?= $rooms['time'] ?></p>
		                        </div><?php
		                        if ($rooms_user['login'] = $user['login']) {
		                            $nick = '<span style="color: #9c9;">' . $rooms_user['login'] . '</span>';
		                        }
		                        $rooms['text'] = str_replace($rooms_user['login'], $nick, $rooms['text']); ?>
		                        
		                        <a class="" href="rooms.php?tip=<?= $tip ?>&komu=<?= $rooms_user['id'] ?>"><span style="color: #<?= $color ?>; text-shadow: <?= $shadow ?>;"><?= _Smile($rooms['text']) ?></span></a>&nbsp;&nbsp;&nbsp;
		                        <?php if ($set['prava'] >= 2) {
		                        	echo "<a class='' href='rooms.php?tip=".$tip."&ban=user&id_user=".$rooms_user['id']."&id_text=".$rooms['id']."'>[!]</a>";
		                        } ?>
		            		</div> <?php
                    } elseif ($rooms[status]==5) {

                    } ?>
		            	</div>
		            	<?php if ($set['prava']>1) {
                            echo '<div class="col-xs-3 col-sm-3 col-md-3">';
			                echo "<a class='media-right' href='?tip=".$tip."&del=text&id_text=".$rooms['id']."'>[x]</i></a><br>";
                            //echo "<a class='media-right' href='view.php?case=ban&smotr=".$rooms_user['id']."'>[ban]</a><br>";
                            echo "<a class='media-right' href='?tip=".$tip."&ban=text&id_text=".$rooms['id']."'>[бан]</i></a>";
                        } ?>
                        </div>
                </div>
                <div class="clearfix"></div><hr><?php
            if(isset($_GET['del']) AND $_GET['del']=='text'){
                $id_text=_NumFilter($_GET['id_text']);
                mysql_query("UPDATE `chat` SET `status`='0', `kto_del`='".$set['id']."'  WHERE `tip` = '".$tip."' AND `id`='".$id_text."' LIMIT 1");
                $_SESSION['ok'] = 'Сообщение удалено!';
                header("Location: ?tip=".$tip."");
                exit();
            }
            if(isset($_GET['ban']) AND $_GET['ban']=='text'){
                $id_text=_NumFilter($_GET['id_text']);
                mysql_query("UPDATE `chat` SET `status`='3', `kto_del`='".$set['id']."'  WHERE `tip` = '".$tip."' AND `id`='".$id_text."' LIMIT 1");
                $_SESSION['ok'] = 'Сообщение удалено!';
                header("Location: view.php?case=ban&smotr=".$rooms_user['id']."");
                exit();
            }
            if(isset($_GET['ban']) AND $_GET['ban']=='user'){
                $id_text=_NumFilter($_GET['id_text']);
                mysql_query("UPDATE `chat` SET `status`='2', `kto_del`='".$set['id']."'  WHERE `tip` = '".$tip."' AND `id`='".$id_text."' LIMIT 1");
                $_SESSION['ok'] = 'Игроку выдано предупреждение!';
                header("Location: rooms.php?tip=".$tip."");
                exit();
            }
        }
           echo '<div class="block_zero center">';
        put($page,$get,$total);
        echo '</div>';
        $sk_chat_vs = mysql_query("SELECT * FROM `user_set` WHERE `mesto` = 'Общение' AND `online`> '".(time()-600)."' ");
        $res1 = mysql_query("SELECT COUNT(*) FROM `user_set` WHERE `mesto` = 'Общение' AND `online`> '".(time()-600)."' ");
        $row1 = mysql_fetch_row($res1);
        $total = $row1[0]; // всего записей  ?>
        Сейчас в чатах: <?=$total?> Чел. </div><?php

        while ($sk = mysql_fetch_array($sk_chat_vs)) {
            if ($sk['prava'] == 5) {
                $color = '40ff00';
                $shadow = '1px 1px 3px #bb40bd;';
                $dolg = 'GM';
            } elseif ($sk['prava'] == 2) {
                $color = '52d9d0';
                $shadow = '';
                $dolg = 'MD';
            } elseif ($sk['prava'] == 3) {
                $color = 'FF69B4';
                $shadow = '';
                $dolg = 'SMD';

            } elseif ($sk['prava'] == 4) {
                $color = '0c0';
                $shadow = '1px 1px 4px #09f';
                $dolg = 'ADM';
            } elseif ($sk['prava'] == 0) {
                $color = 'fff';
                $shadow = '';
                $dolg = '';
            }  elseif ($sk['prava'] == 100) {
                $color = 'f00';
                $shadow = '';
                $dolg = '';
            } ?>
            <img src="images/flags/<?= $sk['side'] ?>.png" alt="Флаг"/> <a href="view.php?smotr=<?= $sk['id'] ?>"><span style="color: #<?= $color ?>; text-shadow: <?=$shadow?>;"><?=$sk['user'] ?> <?=$dolg?></span></a> | <?php
        }

        break;
            case 'post':
            if (isset($_GET['tip'])) {
                $tip = _NumFilter($_GET['tip']);
            }
            /*$rand_podarok = rand(0,1);

            if ($set['premium']==1) {
                $rand_podarok = rand(2,4);
            }
            
            if ($rand_podarok == 1) {
                $kolvo = 'яйцо';
            } elseif ($rand_podarok > 1) {
                $kolvo = 'яйца';
            } else {}
            $podarok = $set['pasha']+$rand_podarok;
        
        if ($tip == 6) {
                $rand_podarok = 0;
            }*/
        if (isset($_POST['text'])) {
            $text = _TextFilter($_POST['text']);
            if (strlen($text) < 1 OR strlen($text) > 1000) {
                $_SESSION['err'] = 'Длина сообщения 1-1000 символов.';
                header('Location: rooms.php?tip=' . $tip . '');
                exit();
            }
            if ($_POST['privat']==ap) {
                $status = 5;
            } else {
                $status = 1;
            }
            mysql_query("INSERT INTO `chat` SET `id_user` = '" . $user_id . "', `text` = '" . $text . "', `time` = '" . $timer . "', `date` = '" . $dater . "', `tip` = '" . $tip . "', `status`='".$status."'");
            //mysql_query("INSERT INTO `chat2` SET `id_user` = '" . $user_id . "', `text` = '" . $text . "', `time` = '" . $timer . "', `date` = '" . $dater . "', `tip` = '" . $tip . "'");
            
            /*if ($rand_podarok > 0) {
                mysql_query("UPDATE `user_set` SET `pasha` = '".$podarok."' WHERE `id` = '" . $user_id . "' LIMIT 1");
                $_SESSION['ok'] = 'Сообщение успешно отправлено! Вам выпало '.$rand_podarok.' Пасхальное '.$kolvo.'!';
            } else {*/
                $_SESSION['ok'] = 'Сообщение успешно отправлено!';
            /*}*/
            
            header('Location: rooms.php?tip=' . $tip . '');
            exit();
        } else {
            $_SESSION['err'] = 'Введите текст сообщения';
            header('Location: rooms.php?tip=' . $tip . '');
            exit();
        }
        break;
    case 'room': ?>
    <div class="block_zero center"><a class="btn-block" href="rooms.php?tip=1">Общая</span></a></div><div class="block_zero"><small><span style="color: #c66;">Запрещено: сообщения о наборе в альянс, для этого есть комната "Альянсы".</span><br/><span style="color: #9c9;">Разрешено: непринужденно общаться о том, о сём.</span></small></div>
    <div class="mini-line"></div> <div class="block_zero center"><a class="btn-block" href="rooms.php?tip=2">Альянсы</a></div><div class="block_zero"><small><span style="color: #c66;">Запрещено: сообщения не касающиеся заявки/приема в альянс.</span><br/><span style="color: #9c9;">Разрешено: любые сообщения касающиеся заявки/приема в альянс.</span></small></div><div class="mini-line"></div> 
    <div class="block_zero center"><a class="btn-block" href="rooms.php?tip=3">Легионы</span></a></div><div class="block_zero"><small><span style="color: #c66;">Запрещено: сообщения о наборе в альянс.</span><br/><span style="color: #9c9;">Разрешено: общение, реклама и заявки касающиеся легионов.</span></small></div><div class="mini-line"></div> 
    <div class="block_zero center"><a class="btn-block" href="rooms.php?tip=4">Учебка</a></div><div class="block_zero"><small><span style="color: #c66;">Запрещено: сообщения про заявки/прием в альянс.</span><br/><span style="color: #9c9;">Разрешено: делиться опытом, с уважением относиться к старшим, с пониманием относиться к младшим.</span></small></div>
    <div class="mini-line"></div><div class="block_zero center"><a class="btn-block" href="rooms.php?tip=5">Поломки</a></div><div class="block_zero"><small><span style="color: #c66;">Запрещено: Все что не касается недоработок игры</span><br/><span style="color: #9c9;">Разрешено: полное и точное описание проблемы, все четко и по делу</span></small></div></div>
    <!--div class="mini-line"></div><div class="block_zero center"><a class="btn-block" href="rooms.php?tip=6">Игровая комната</a></div><div class="block_zero"><small><span style="color: #c66;">Запрещено: Флудить</span><br/><span style="color: #9c9;">Разрешено: играть ;)</span></small></div></div--><?php
    if ($set['prava']>=2) {
        echo '<hr><div class="block_zero center"><a class="btn-block" href="rooms.php?tip=10">МД-чат</a>';
    }
        break;

    case 'smile': ?>
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <img src="images/smiles/1.gif" alt="*"/> - :)  <br><hr>
            <img src="images/smiles/2.gif" alt="*"/> - :( <br><hr>
            <img src="images/smiles/3.gif" alt="*"/> - :p , .ор. <br><hr>
            <img src="images/smiles/4.gif" alt="*"/> - :d , :целую , .целую. , :* <br><hr>
            <img src="images/smiles/5.gif" alt="*"/> - :ban , .ban. , :бан , .бан. <br><hr>
            <img src="images/smiles/6.gif" alt="*"/> - :gi , :гы , .гы. , .gi.  <br><hr>
            <img src="images/smiles/7.gif" alt="*"/> - :zub , .zub. , :зубы , .зубы.  <br><hr>
            <img src="images/smiles/8.gif" alt="*"/> - :fak , .fak. , :фак , .фак.  <br><hr>
            <img src="images/smiles/9.gif" alt="*"/> - :vkr , .vkr. , :вкраску , .вкраску.  <br><hr>
            <img src="images/smiles/10.gif" alt="*"/> - :sin , .sin. , :синяк , .синяк.  <br><hr>
            <img src="images/smiles/53.gif" alt="*"/> - :cvetok , .cvetok. , .цветок. , :цветок <br><hr>
            <img src="images/smiles/mini_yazyk.gif" alt="*"/> - :язык , .язык.  <br><hr>
            <img src="images/smiles/mini_az.gif" alt="*"/> - :pivo , .pivo. , :пиво , .пиво.  <br><hr>
            <img src="images/smiles/mini_cry.gif" alt="*"/> - :plak , .plak. , :плак , .плак.  <br><hr>
            <img src="images/smiles/mini_flood.gif" alt="*"/> - :flud , .flud. , :флуд , .флуд. <br><hr>
        </div>
    </div>
<?php break;
}
require_once('system/down.php');
?>
