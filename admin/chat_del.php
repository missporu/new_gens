<?php
$title = 'Админка';
require_once('../system/up.php');
_Reg();
switch ($_GET['case']) {
	default:
		if (isset($_GET['page'])){
	        $page = $_GET['page'];
	    }else $page = 1;
	    
	    $kol = 10;  //количество записей для вывода
	    $art = ($page * $kol) - $kol;
	    // echo $art;
	    
	    // Определяем все количество записей в таблице
	    $res = mysql_query("SELECT COUNT(*) FROM `chat_del` WHERE `tip` < '11' ");
	    $row = mysql_fetch_row($res);
	    $total = $row[0]; // всего записей  
	    echo $total;
	    
	    // Количество страниц для пагинации
	    $str_pag = ceil($total / $kol);
	    // echo $str_pag; 
	    // Запрос и вывод записей
	        if ($set['prava']<5) {
	            $_SESSION['err'] = 'Нет доступа';
	            header('Location: menu.php');
	            exit();
	        }
	        echo "Удаленные сообщения<br>";
	        while ($del = mysql_fetch_array($res)) {
	            $moder = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $del['id_usermd'] . "' ");
	            $usr = _FetchAssoc("SELECT * FROM `user_set` WHERE `id`='" . $del['id_user'] . "' ");
	            $deltext = mysql_query("SELECT * FROM `chat2` WHERE `id`='" . $del['text'] . "' ");
	            $del_text = mysql_fetch_array($deltext); ?>
	            Кто удалил: <img src="images/flags/<?= $moder['side'] ?>.png" alt="Флаг"/><a href="view.php?smotr=<?= $moder['id'] ?>"> <?=$moder['user'] ?></a><br>
	            Кто писал: <img src="images/flags/<?= $usr['side'] ?>.png" alt="Флаг"/><a href="view.php?smotr=<?= $usr['id'] ?>"> <?=$usr['user'] ?></a><br>
	            Сообщение : <?= _Smile($del_text['text']) ?> <br><hr><?php
	        } ?>
	        <ul class="pagination"><?php

	            // формируем пагинацию
	            for ($i = 1; $i <= $str_pag; $i++){
	                echo ' <li><a href="?page='.$i.'">'.$i.' </a></li> ';
	            } ?>
	        </ul><?php
		break;
}
require_once('system/down.php');