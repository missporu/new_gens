<?php
$title = 'Админка';
require_once('system/up.php');
_Reg();
if ($set['prava']<3) {
	$text_bb = 'Пытался залезть в удаленные чата в админку.';
	mysql_query("UPDATE `user_set` SET `block`='1' WHERE `id`='".$set['id']."' ");
	mysql_query("INSERT INTO `admin_logi`(`id`, `id_user`, `user`, `text`, `date`) VALUES (NULL,'".$set['id']."','".$set['user']."','".$text_bb."',NULL)");
	$_SESSION['err'] = 'Чувак, ты спалился. Смс уже ушло Админу. Можешь начинать обьснять зачем ты туда полез';
	header("Location: blok.php");
	exit();
}
$text_md = 'читал удаленный чат';
mysql_query("INSERT INTO `admin_logi`(`id`, `id_user`, `user`, `text`, `date`) VALUES (NULL,'".$set['id']."','".$set['user']."','".$text_md."',NULL)");
	
switch ($_GET['case']) {
    default:
        $rec =$sql->getOne("SELECT count(id) from chat WHERE status=?i",0);
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


            echo " Удаленных сообщений<br>";
            $result = mysql_query("SELECT * FROM `chat` WHERE `status`='0' ORDER BY `id` DESC LIMIT $start,$sum");
            $del = mysql_fetch_array($result);
            do {
                $moder = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $del['kto_del'] . "' ");
                $usr = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $del['id_user'] . "' "); ?>
                Кто удалил: <img src="images/flags/<?= $moder['side'] ?>.png" alt="Флаг"/><a href="view.php?smotr=<?= $moder['id'] ?>"> <?=$moder['user'] ?></a>  <?//=$del['date']?><br>
                Кто писал: <img src="images/flags/<?= $usr['side'] ?>.png" alt="Флаг"/><a href="view.php?smotr=<?= $usr['id'] ?>"> <?=$usr['user'] ?></a><br>
                Сообщение : <?= _Smile($del['text']) ?><br> <?=$del['date'] ?> в <?=$del['time'] ?><br><hr><?php
            } while ($del = mysql_fetch_array($result)); ?>
            <ul class="pagination"><?php

                /* формируем пагинацию
                for ($i = 1; $i <= $str_pag; $i++){
                    echo ' <li><a href="?page='.$i.'">'.$i.' </a></li> ';
                }*/
                put($page,$get,$total); ?>
            </ul><?php
        break;
    case '1':
    	$vivod22 = mysql_query("SELECT * FROM `admin_logi` ");
    	while ($vivod = mysql_fetch_array($vivod22)) {
    		echo '"'.$vivod['user'].'" '.$vivod['text'].' '.$vivod['date'].' <br>';
    	}
    	break;
}
require_once('system/down.php');