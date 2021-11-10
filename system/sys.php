<?php
require_once "setting.php";
require_once "head.php";

/*
require_once "class/Filter.php";
require_once('class/SafeMySQL.php');
require_once "class/Site.php";
require_once "class/Times.php";
require_once "class/User.php";
require_once "class/Admin.php";
require_once('head.php');

s

$support='support@'.$site.''; // Почта сайта

function _GenCode($length) {
    $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code="";
    $clen=strlen($chars)-1;
    while (strlen($code)<$length){
        $code.=$chars[mt_rand(0,$clen)];
    }
    return $code;
} // Функция генерации пароля при восстановлении

$reg=$sql->getOne("SELECT count(id) FROM user_reg"); // Колличество юзеров

function _Users($reg,$form1,$form2,$form3){
    $reg=_NumFilter($reg)%100;
    $all1=$reg%10;
    if($reg >10&&$reg< 20) return $form3;
    if($all1>1&&$all1<5) return $form2;
    if($all1==1) return $form1;
    return $form3;
} // Функция склонения колличества игроков

function _Time($time = 0) {
    $h = floor($time/60/60);
    $i = floor($time/60)-$h*60;
    $s = $time-$h*60*60-$i*60;
    $h = (strlen($h) == 1 ? '0'.$h : $h);
    $i = (strlen($i) == 1 ? '0'.$i : $i);
    $s = (strlen($s) == 1 ? '0'.$s : $s);
    $out = $h.':'.$i.':'.$s;
    return $out;
} // Функция времени (таймер)

function _TimeSec($time = 0) {
    $h = floor($time/60/60);
    $i = floor($time/60)-$h*60;
    $s = $time-$h*60*60-$i*60;
    $h = (strlen($h) == 1 ? '0'.$h : $h);
    $i = (strlen($i) == 1 ? '0'.$i : $i);
    $s = (strlen($s) == 1 ? '0'.$s : $s);
    $out = $i.':'.$s;
    return $out;
} // Функция времени (таймер)

function _DayTime($time) {
    if(is_numeric($time)) {
        $value=array('years'=>0,'days'=>0,'hours'=>0,'minutes'=>0,'seconds'=>0);
        if($time >= 31536000) {
            $value['years'] = floor($time/31536000);
            $time = ($time%31536000);
        }
        if($time >= 86400) {
            $value['days'] = floor($time/86400);
            $time = ($time%86400);
        }
        if($time >= 3600) {
            $value['hours'] = floor($time/3600);
            $time = ($time%3600);
        }
        if($time >= 60) {
            $value['minutes'] = floor($time/60);
            $time = ($time%60);
        }
        $value['seconds'] = floor($time);
        if($value['seconds']>0){
            $time5 = $value['seconds'].' сек. ';
        } else {
            $time5='';
        }
        if($value['minutes']>0) {
            $time4 = $value['minutes'].' мин. ';
        } else {
            $time4='';
        }
        if($value['hours']>0) {
            $time3 = $value['hours'].' час. ';
        } else {
            $time3='';
        }
        if($value['days']>0) {
            $time2 = $value['days'].' дн. ';
        } else {
            $time2='';
        }
        if($value['years']>0) {
            $time1 = $value['years'].' г. ';
        } else {
            $time1='';
        }
        return $time1.  $time2.$time3.$time4.$time5;
        return (array) $value;
    } else {
        return (bool) FALSE;
    }
} // Функция времени (годы, дни, часы, минуты, секунды

function _Smile($smile) {
    $smile=str_replace(array(':)'),'<img src="images/smiles/1.gif" alt="*"/>',$smile);
    $smile=str_replace(array(':('),'<img src="images/smiles/2.gif" alt="*"/>',$smile);
    $smile=str_replace(array(':p', ':ор', '.ор.'),'<img src="images/smiles/3.gif" alt="*"/>',$smile);
    $smile=str_replace(array(':d', ':целую', '.целую.', ':*'),'<img src="images/smiles/4.gif" alt="*"/>',$smile);
    $smile=str_replace(array(':ban', ':бан', '.бан.', '.ban.'),'<img src="images/smiles/5.gif" alt="*"/>',$smile);
    $smile=str_replace(array(':gi', ':гы', '.гы.', '.gi.'),'<img src="images/smiles/6.gif" alt="*"/>',$smile);
    $smile=str_replace(array(':zub', ':зубы', '.зубы', '.zub.'),'<img src="images/smiles/7.gif" alt="*"/>',$smile);
    $smile=str_replace(array(':fak', ':фак', '.фак.', '.fak.'),'<img src="images/smiles/8.gif" alt="*"/>',$smile);
    $smile=str_replace(array(':vkr', ':вкраску', '.вкраску.', '.vkr.'),'<img src="images/smiles/9.gif" alt="*"/>',$smile);
    $smile=str_replace(array(':sin', ':синяк', '.синяк.', '.sin.'),'<img src="images/smiles/10.gif" alt="*"/>',$smile);
    $smile=str_replace(array(':kaif', ':кайф', '.кайф.', '.kaif.'),'<img src="images/smiles/kaif.png" alt="*"/>',$smile);
    $smile=str_replace(array(':cvetok', ':цветок', '.цветок.', '.cvetok.'),'<img src="images/smiles/53.gif" alt="*"/>',$smile);
    $smile=str_replace(array(':язык', '.язык.'),'<img src="images/smiles/mini_yazyk.gif" alt="*"/>',$smile);
    $smile=str_replace(array(':pivo', ':пиво', '.пиво.', '.pivo.'),'<img src="images/smiles/mini_az.gif" alt="*"/>',$smile);
    $smile=str_replace(array(':plak', ':плак', '.плак.', '.plak.'),'<img src="images/smiles/mini_cry.gif" alt="*"/>',$smile);
    $smile=str_replace(array(':flud', ':флуд', '.флуд.', '.flud.'),'<img src="images/smiles/mini_flood.gif" alt="*"/>',$smile);
    return $smile;
} // Смайлы


if($user) {
// ПЕРСОНАЖ
    $user_id=_NumFilter($user['id']);// АЙ ДИ персонажа
    $sql->query("UPDATE user_set SET mesto=?s WHERE id=?i LIMIT ?i",_TextFilter($title),$user_id,1); // Где находимся
    $set=$sql->getRow("SELECT * FROM user_set WHERE id=?i",$user_id); // Массив данных персонажа
    if($set['lvl']==10) {
        $zvan='Ефрейтор';
    } elseif($set['lvl']==20) {
        $zvan='Мл. сержант';
    } elseif($set['lvl']==30) {
        $zvan='Сержант';
    } elseif($set['lvl']==40) {
        $zvan='Ст. сержант';
    } elseif($set['lvl']==50) {
        $zvan='Старшина';
    } elseif($set['lvl']==60) {
        $zvan='Прапорщик';
    } elseif($set['lvl']==70) {
        $zvan='Ст. прапорщик';
    } elseif($set['lvl']==80) {
        $zvan='Мл. лейтенант';
    } elseif($set['lvl']==90) {
        $zvan='Лейтенант';
    } elseif($set['lvl']==100) {
        $zvan='Ст. лейтенант';
    } elseif($set['lvl']==110) {
        $zvan='Капитан';
    } elseif($set['lvl']==120) {
        $zvan='Майор';
    } elseif($set['lvl']==130) {
        $zvan='Подполковник';
    } elseif($set['lvl']==140) {
        $zvan='Полковник';
    } elseif($set['lvl']==150) {
        $zvan='Генерал-майор';
    } elseif($set['lvl']==160) {
        $zvan='Генерал-лейтенант';
    } elseif($set['lvl']==170) {
        $zvan='Генерал-полковник';
    } elseif($set['lvl']==180) {
        $zvan='Генерал армии';
    } elseif($set['lvl']==200) {
        $zvan='Маршал';
    } else {
        $zvan=$set['zvanie'];
    }
    if($set['zvanie']!=$zvan) {
        $sql->query("UPDATE user_set SET zvanie=?s WHERE id=?i",$zvan,$user_id);
    } // назначение званий

    if($set['mesto']!='Курс молодого бойца' AND $set['start']<12) {
        $_SESSION['err'] = 'Вы не закончили обучение!';
        header("Location: start.php?case=".$set['start']."");
        exit();
    } // Обучение

    if($set['fon']=='blue') {
        $cvet='синий';
    } elseif($set['fon']=='green') {
        $cvet='зелёный';
    } elseif($set['fon']=='red') {
        $cvet='красный';
    } else {
        $cvet='стандартный';
    }
    echo'<link rel="stylesheet" href="//gmisspo.ru/style/'.$set['fon'].'/style.css" type="text/css" />'; // Фон игры

    if($browser!=$set['browser_new']) {
        $sql->query("UPDATE user_set SET browser_new=?s WHERE id=?i",$browser,$user_id);
    } // Новый браузер персонажа

    if($ip!=$set['ip_new']) {
        $sql->query("UPDATE user_set SET ip_new=?s WHERE id=?i",$ip,$user_id);
    } // Новый Ай Пи персонажа

    $sql->query("UPDATE user_set SET online=?i, last_date_visit = ?s, last_time_visit = ?s WHERE id = ?i",time(),$dater,$timer,$user_id);
// Онлайн

    $user_alliance=$sql->getOne("SELECT count(id) FROM alliance_user WHERE kto=?i OR s_kem=?i",$user_id,$user_id); // Колличество альянса

    $sanctions=$sql->getOne("SELECT count(id) FROM sanction WHERE time_up<?i",time());
    if($sanctions>0) {
        $sql->query("UPDATE sanction SET time_up='0' WHERE time_up<?i",time());
    } // Регенерация санкций

    $stavka =$sql->getOne("SELECT count(id) FROM sanction WHERE data!=?s",$dater);
    if($stavka>0) {
        $sql->query("UPDATE sanction SET stavka=?i WHERE data!=?s",100,$dater);
    } // Ежедневный сброс ставки для санкций

    $priglas=$sql->getOne("SELECT count(id) FROM alliance_priglas WHERE kogo =?i",$user_id);
    if($priglas) {
        $plus_priglas = "<img src='/img/alli2.png' class=\"img-responsive\" alt=''/>";
        $plus_prigl = '<span style="float: right;"><span style="color: #3c3;">+</span></span>';
    } else {
        $plus_priglas = "<img src='/img/alli.png' class=\"img-responsive\" alt=''/>";
        $plus_prigl = FALSE;
    } // Оповещение о приглашении в альянс

    $pri=$sql->getRow("SELECT * FROM alliance_diplom WHERE id_user = ?i ORDER BY id ASC LIMIT ?i",$user_id,1);
    if(isset($pri) AND $pri['diplom_up'] < time()) {
        $sql->query("DELETE FROM alliance_diplom WHERE  id_user = ?i AND diplom_up < ?i LIMIT ?i",$user_id,time(),1);
        if($set['diplomat'] < $set['diplomat_max']) {
            $sql->query("UPDATE user_set SET diplomat = diplomat + ?i WHERE id = ?i",1,$user_id);
        }
    } // Регенерация дипломатов 1 час

    $dip = $sql->getRow("SELECT * FROM alliance_priglas WHERE kogo = ?i ORDER BY id DESC",$user_id);
    if($dip) {
        if($dip['priglas_up'] < time()) {
            $sql->query("DELETE FROM alliance_priglas WHERE  kogo = ?i AND priglas_up < ?i",$user_id,time());
        }
    } // Удаление приглашений более 3 часов

    if($set['sex']=='w') {
        $pol='Девушка';
    } elseif($set['sex']=='m') {
        $pol='Парень';
    } else {
        $pol='Не известно';
    } // Пол персонажа

    if($set['side'] == 'r') {
        $strana = 'Россия';
    } elseif ($set['side'] == 'g') {
        $strana = 'Германия';
    } elseif ($set['side'] == 'a') {
        $strana = 'США';
    } elseif ($set['side'] == 'u') {
        $strana = 'Украина';
    } elseif ($set['side'] == 'b') {
        $strana = 'Белоруссия';
    } elseif ($set['side'] == 'c') {
        $strana = 'Китай';
    } elseif ($set['side'] == 'k') {
        $strana = 'Казахстан';
    } else {
        $strana = 'Не известно';
    }// Страна персонажа

    $data_build=$sql->getRow("SELECT * FROM build WHERE lvl=?i LIMIT ?i",$set[lvl],1);
    if(!$data_build){$data_build[lvl]="FALSE";}
    $user_build=$sql->getRow("SELECT * FROM user_build WHERE id_user=?i AND lvl=?s LIMIT ?i",$user_id,$data_build[lvl],1);

    if(!$user_build) {
        $sql->query("INSERT INTO user_build (id_user,id_build,name,tip,lvl,kol,bonus,cena) VALUES ('".$user_id."','".$data_build['id']."','".$data_build['name']."','".$data_build['tip']."','".$data_build['lvl']."','".$data_build['kol']."','".$data_build['bonus']."','".$data_build['cena']."')");
        $sql->query("UPDATE user_set SET build_up=?i WHERE id=?i",time(),$user_id);
    } //Добавление построек по уровням


    if (time()>$set['build_up'] AND $set['build_up']!=0) {
        $dohod_up=_NumFilter(time()-$set['build_up'])/3600;
        $dohod_new=_NumFilter($set['chistaya']*$dohod_up);
        if($dohod_up>=1) {

            $sql->query("UPDATE user_set SET baks=baks+?i, build_up=?i, refer_baks=refer_baks+?i WHERE id = ?i",$dohod_new,time(),round($dohod_new/10),$user_id);

            $sql->query("UPDATE user_set SET baks=baks+?i WHERE id = ?i",round($dohod_new/10),$user[refer]);
        }
    } // Выплата с доходных построек

    /* $user_build_dohod=$sql->getRow("SELECT * FROM user_build WHERE id_user=?i AND tip=?i LIMIT ?i",$user_id,1,1);
    while ($user_build_dohod) {
        for ($ki=1; $ki < 10; $ki++) {
            $sum_kol=$sql->getRow("SELECT * FROM user_build WHERE id = ?i AND id_user=?i LIMIT ?i",$ki,$user_id,1);
        }
        $summ_vs = $sum_kol[kol]*$sum_kol[bonus];
        $sql->query("UPDATE user_set SET dohod=?i, chistaya=?i, WHERE id = ?i",$summ_vs,($summ_vs-$set[soderzhanie]));
    }

    $data_unit=$sql->getRow("SELECT * FROM unit WHERE lvl = ?i LIMIT ?i",$set[lvl],1);
    $user_unit=$sql->getRow("SELECT * FROM user_unit WHERE id_user = ?i AND lvl = ?i LIMIT ?i",$user_id,$data_unit[lvl],1);
    if(!$user_unit AND $data_unit) {
        $sql->query("INSERT INTO user_unit (id_user,id_unit,name,tip,lvl,kol,ataka,zaschita,soderzhanie,cena) VALUES ('".$user_id."','".$data_unit['id']."','".$data_unit['name']."','".$data_unit['tip']."','".$data_unit['lvl']."','".$data_unit['kol']."','".$data_unit['ataka']."','".$data_unit['zaschita']."','".$data_unit['soderzhanie']."','".$data_unit['cena']."')");
    } //Добавление техники по уровням

    $user_trof=$sql->getRow("SELECT * FROM user_trofei WHERE id_user = ?i",$user_id);
    if(!$user_trof) {
        for ($t = 1; $t <= 18; $t++) {
            $data_trof=$sql->getRow("SELECT * FROM trofei WHERE id = ?i LIMIT ?i",$t,1);
            $sql->query("INSERT INTO user_trofei (id_user,id_trof,status,lvl,cena_baks,cena_gold,time_up,day,bonus_1,bonus_2,next_1,next_2) VALUES ('".$user_id."','".$data_trof['id']."','".$data_trof['status']."','".$data_trof['lvl']."','".$data_trof['cena_baks']."','".$data_trof['cena_gold']."','".$data_trof['time_up']."','".$data_trof['day']."','".$data_trof['bonus_1']."','".$data_trof['bonus_2']."','".$data_trof['next_1']."','".$data_trof['next_2']."')");
        }
    } //Добавление трофеев

    $time_trof=_FetchAssoc("SELECT * FROM user_trofei WHERE id_user = '".$user_id."' AND time_up!='0' LIMIT 1");
    $shag_time=_FetchAssoc("SELECT name, shag_1, shag_2 FROM trofei WHERE id = '".$time_trof['id_trof']."' LIMIT 1");
    if($time_trof['time_up']<=time()) {
        mysql_query("UPDATE user_trofei SET lvl='".($time_trof['lvl']+1)."', time_up='0', cena_baks='".($time_trof['cena_baks']*2)."', cena_gold='".($time_trof['cena_gold']*2)."', day='".($time_trof['day']+2)."', bonus_1='".($time_trof['bonus_1']+$shag_time['shag_1'])."', bonus_2='".($time_trof['bonus_2']+$shag_time['shag_2'])."', next_1='".($time_trof['next_1']+$shag_time['shag_1'])."', next_2='".($time_trof['next_2']+$shag_time['shag_2'])."' WHERE id_user='".$user_id."' AND id_trof='".$time_trof['id_trof']."' LIMIT 1");

        if($time_trof['id_trof']==6) {
            $trof_hp=$set['hp']/100*($time_trof['bonus_1']+$shag_time['shag_1']);
            $trof_max_hp=$set['max_hp']/100*($time_trof['bonus_1']+$shag_time['shag_1']);
            mysql_query("UPDATE user_set SET hp=hp+'".$trof_hp."', max_hp=max_hp+'".$trof_max_hp."' WHERE id='".$user_id."' LIMIT 1");
        }

        if($time_trof['id_trof']==4){
            $soderzhanie=$set['soderzhanie']/100*($time_trof['bonus_1']+$shag_time['shag_1']);
            $chistaya=$set['chistaya']+$soderzhanie;
            mysql_query("UPDATE user_set SET soderzhanie=soderzhanie-'".$soderzhanie."', chistaya='".$chistaya."' WHERE id='".$user_id."' LIMIT 1");
        }

    } // Окончание прокачки трофея

    $user_superunit=_FetchAssoc("SELECT * FROM user_superunit WHERE id_user = '".$user_id."'");
    if(!$user_superunit) {
        for ($i = 1; $i <= 10; $i++) {
            $data_superunit=_FetchAssoc("SELECT * FROM superunit WHERE id = '".$i."' LIMIT 1");
            mysql_query("INSERT INTO user_superunit (id_user,id_unit,name,kol,ataka,zaschita) VALUES ('".$user_id."','".$data_superunit['id']."','".$data_superunit['name']."','".$data_superunit['kol']."','".$data_superunit['ataka']."','".$data_superunit['zaschita']."')");
        }
    } //Добавление супертехники

    $user_bonus=_FetchAssoc("SELECT * FROM user_bonus WHERE id_user = '".$user_id."'");
    if(!$user_bonus) {
        mysql_query("INSERT INTO user_bonus SET id_user = '".$user_id."', day = '".date("d")."', month = '".date("F")."', year = '".date("Y")."'");
        mysql_query("INSERT INTO user_set SET skoko_spusk=0 WHERE id='".$user_id."' LIMIT 1");
    } //Добавление в ежедневный бонус

    $old_bonus =_FetchAssoc("SELECT status_bonus FROM user_bonus WHERE id_user = '".$user_id."' AND status_bonus='1' AND (day!='".date("d")."' OR month = !'".date("F")."' OR year != '".date("Y")."') LIMIT 1");
    if($old_bonus) {
        mysql_query("UPDATE user_bonus SET status_bonus='0' WHERE id_user = '".$user_id."'");
        header('Location: bonus.php');
        exit();
    } // Сброс отметки получения бонуса

    $user_naem=_FetchAssoc("SELECT * FROM user_naemniki WHERE id_user = '".$user_id."'");
    if(!$user_naem) {
        for ($i = 1; $i <= 5; $i++) {
            mysql_query("INSERT INTO user_naemniki SET id_user = '".$user_id."', id_naemnik = '".$i."'");
        }
    } //Добавление наёмников

    $user_n=_FetchAssoc("SELECT * FROM user_naemniki WHERE id_user = '".$user_id."' AND time_up <= '".time()."' AND status = '1'");
    if($user_n) {
        mysql_query("UPDATE user_naemniki SET status = '0' WHERE id_user = '".$user_id."' AND time_up <= '".time()."' AND status = '1'");
    } //конец действия наёмников

    $user_lab=_FetchAssoc("SELECT * FROM user_laboratory WHERE id_user = '".$user_id."'");
    if(!$user_lab) {
        for ($i = 1; $i <= 6; $i++) {
            mysql_query("INSERT INTO user_laboratory SET id_user = '".$user_id."', id_lab = '".$i."'");
        }
    } //Добавление лаборатории

    $user_l=_FetchAssoc("SELECT * FROM user_laboratory WHERE id_user = '".$user_id."' AND time_up <= '".time()."' AND status = '1'");
    if($user_l) {
        mysql_query("UPDATE user_laboratory SET status = '0' WHERE id_user = '".$user_id."' AND time_up <= '".time()."' AND status = '1'");
    } //конец действия лаборатории

    $s1 = _FetchAssoc("SELECT * FROM user_superunit WHERE id_unit = '1' AND id_user = '" . $user_id . "' LIMIT 1");
    $s2 = _FetchAssoc("SELECT * FROM user_superunit WHERE  id_unit = '2' AND id_user = '" . $user_id . "' LIMIT 1");
    $s3 = _FetchAssoc("SELECT * FROM user_superunit WHERE  id_unit = '3' AND id_user = '" . $user_id . "' LIMIT 1");
    $s4 = _FetchAssoc("SELECT * FROM user_superunit WHERE  id_unit = '4' AND id_user = '" . $user_id . "' LIMIT 1");
    $s5 = _FetchAssoc("SELECT * FROM user_superunit WHERE  id_unit = '5' AND id_user = '" . $user_id . "' LIMIT 1");
    $s6 = _FetchAssoc("SELECT * FROM user_superunit WHERE  id_unit = '6' AND id_user = '" . $user_id . "' LIMIT 1");
    $s7 = _FetchAssoc("SELECT * FROM user_superunit WHERE  id_unit = '7' AND id_user = '" . $user_id . "' LIMIT 1");
    $s8 = _FetchAssoc("SELECT * FROM user_superunit WHERE  id_unit = '8' AND id_user = '" . $user_id . "' LIMIT 1");
    $s9 = _FetchAssoc("SELECT * FROM user_superunit WHERE  id_unit = '9' AND id_user = '" . $user_id . "' LIMIT 1");
    $s10 = _FetchAssoc("SELECT * FROM user_superunit WHERE  id_unit = '10' AND id_user = '" . $user_id . "' LIMIT 1");// Подсчёт разработок для сборки СВЕРХСЕКРЕТНОЙ

    $data_mail_plus=_FetchAssoc("SELECT * FROM mail WHERE komu='" . $user_id . "' AND status='0'");
    if($data_mail_plus) {
        $plus_mail = "<img src=\"/img/mail2.png\" class=\"img-responsive\" alt=\" \"/>";
        $icon_mail = '<a href="mail.php"><img src="img/mail2.png" class="img-responsive" alt="Почта"></a>';
    } else {
        $plus_mail = "<img src=\"/img/mail.png\" class=\"img-responsive\" alt=\" \"/>";
        $icon_mail = ' .';
    } // Оповещение о приходе почты

    if($set['news']==1) {
        $plus_news = "<img src=\"/img/news2.png\" class=\"img-responsive\" alt=\" \"/>";
    } else {
        $plus_news = "<img src=\"/img/news.png\" class=\"img-responsive\" alt=\" \"/>";
    }// Оповещение о Новости

    $data_operation=_FetchAssoc("SELECT * FROM operation WHERE lvl='".$set['lvl']."' LIMIT 1");
    $user_operation=_FetchAssoc("SELECT * FROM user_operation WHERE id_user='".$user_id."' AND id_operation='".$data_operation['id']."' LIMIT 1");
    if(!$user_operation AND $data_operation){
        mysql_query("INSERT INTO user_operation (id_user,id_operation,name,lvl,max_exp,rang,point) VALUES ('".$user_id."','".$data_operation['id']."','".$data_operation['name']."','".$data_operation['lvl']."','".$data_operation['exp']."','".$data_operation['rang']."','".$data_operation['point']."')");
    } //Добавление спецопераций по уровням

    $data_mission=_FetchAssoc("SELECT * FROM mission WHERE lvl='".$set['lvl']."' LIMIT 1");
    $user_mission=_FetchAssoc("SELECT * FROM user_mission WHERE id_user='".$user_id."' AND id_mission='".$data_mission['id']."' LIMIT 1");
    if(!$user_mission AND $data_mission) {
        mysql_query("INSERT INTO user_mission (id_user,id_operation,id_mission,name,exp_mission,max_exp,alliance,id_unit,kol_unit,exp_priz,baks_priz,lvl) VALUES ('".$user_id."','".$data_mission['id_operation']."','".$data_mission['id']."','".$data_mission['name']."','".$data_mission['exp_mission']."','".($data_mission['exp_mission']*2)."','".$data_mission['alliance']."','".$data_mission['id_unit']."','".$data_mission['kol_unit']."','".$data_mission['exp_priz']."','".$data_mission['baks_priz']."','".$data_mission['lvl']."')");
    } //Добавление миссий по уровням

    if($set['raiting_wins']>=9) {
        mysql_query("UPDATE user_set SET raiting=raiting+'1', raiting_wins='0' WHERE id='".$user_id."' LIMIT 1");
    } // Рейтинг ПЛЮС

    if($set['raiting_loses']>=9) {
        mysql_query("UPDATE user_set SET raiting=raiting-'1', raiting_loses='0' WHERE id='".$user_id."' LIMIT 1");
    } // Рейтинг МИНУС

    if($set['hp']>=0) {
        $set['max_hp']=_NumFilter($set['max_hp']);
        if($set['hp']<$set['max_hp']) {
            $hp_up=_NumFilter(time()-$set['hp_up'])/18;
            $hp_new=_NumFilter($set['hp']+$hp_up);
            if($hp_new<$set['max_hp']) {
                if($hp_up>=1) {
                    mysql_query('UPDATE user_set SET hp="'.$hp_new.'", hp_up="'.time().'" WHERE id="'.$user_id.'"');
                }
            } else {
                mysql_query('UPDATE user_set SET hp="'.$set['max_hp'].'" WHERE id="'.$user_id.'"');
            }
        } else {
            mysql_query('UPDATE user_set SET hp="'.$set['max_hp'].'" WHERE id="'.$user_id.'"');
        }
    } else {
        mysql_query('UPDATE user_set SET hp="0" WHERE id="'.$user_id.'"');
    } // Регенерация здоровья

    if ($set['hp_up'] < time()) {
        $hp_time = 20+($set['hp_up']-time());
        $hp_time = number_format($hp_time, 0, '.', '');
        if ($hp_time < 0 || $hp_time > 20) {
            $hp_time = 0;
        }
    }

    if($set['soderzhanie']<0) {
        mysql_query('UPDATE user_set SET soderzhanie="0", chistaya="'.$set['dohod'].'" WHERE id="'.$user_id.'"');
    } // Обнуление при содержании <0


    $trof_udar=_FetchAssoc("SELECT * FROM user_trofei WHERE id_user = '".$user_id."' AND id_trof = '2'");
    if($trof_udar['status']==1 AND $trof_udar['time_up']==0) {
        $time_udar=(180-($trof_udar['bonus_1']/8*15));
    } else {
        $time_udar=180;
    }

    $user_lab_udar=_FetchAssoc('SELECT * FROM user_laboratory WHERE id_user="'.$user_id.'" AND id_lab="2" LIMIT 1');

    if($user_lab_udar['status']==1) {
        $time_udar=$time_udar/2;
    }

    if($set['udar']>=0) {
        $set['max_udar']=_NumFilter($set['max_udar']);
        if($set['udar']<$set['max_udar']) {
            $udar_up=_NumFilter(time()-$set['udar_up'])/$time_udar;
            $udar_new=_NumFilter($set['udar']+$udar_up);
            if($udar_new<$set['max_udar']) {
                if($udar_up>=1) {
                    mysql_query('UPDATE user_set SET udar="'.$udar_new.'", udar_up="'.time().'" WHERE id="'.$user_id.'"');
                }
            } else {
                mysql_query('UPDATE user_set SET udar="'.$set['max_udar'].'" WHERE id="'.$user_id.'"');
            }
        } else {
            mysql_query('UPDATE user_set SET udar="'.$set['max_udar'].'" WHERE id="'.$user_id.'"');
        }
    } else {
        mysql_query('UPDATE user_set SET udar="0" WHERE id="'.$user_id.'"');
    } // Регенерация боёв

    if ($set['udar_up'] < time()) {
        $udar_time = $time_udar+($set['udar_up']-time());
        $udar_time = number_format($udar_time, 0, '.', '');
        if ( $udar_time < 0 ) {
            $udar_time = 0;
        }
    }


    $trof_enka=_FetchAssoc("SELECT * FROM user_trofei WHERE id_user = '".$user_id."' AND id_trof = '3'");
    if($trof_enka['status']==1 AND $trof_enka['time_up']==0) {
        $time_enka=(240-($trof_enka['bonus_1']/8*15));
    } else {
        $time_enka=240;
    }

    $user_lab_mp=_FetchAssoc('SELECT * FROM user_laboratory WHERE id_user="'.$user_id.'" AND id_lab="1" LIMIT 1');

    if($user_lab_mp['status']==1) {
        $time_enka=$time_enka/2;
    }

    if($set['mp']>=0) {
        $set['max_mp']=_NumFilter($set['max_mp']);
        if($set['mp']<$set['max_mp']) {
            $mp_up=_NumFilter(time()-$set['mp_up'])/$time_enka;
            $mp_new=_NumFilter($set['mp']+($mp_up*$set['build_energy']));
            if($mp_new<$set['max_mp']) {
                if($mp_up>=1) {
                    mysql_query('UPDATE user_set SET mp="'.$mp_new.'", mp_up="'.time().'" WHERE id="'.$user_id.'"');
                }
            } else {
                mysql_query('UPDATE user_set SET mp="'.$set['max_mp'].'" WHERE id="'.$user_id.'"');
            }
        } else {
            mysql_query('UPDATE user_set SET mp="'.$set['max_mp'].'" WHERE id="'.$user_id.'"');
        }
    } else {
        mysql_query('UPDATE user_set SET mp="0" WHERE id="'.$user_id.'"');
    } // Регенерация энергии

    if ($set['mp_up'] < time()) {
        $mp_time = $time_enka+($set['mp_up']-time());
        $mp_time = number_format($mp_time, 0, '.', '');
        if ($mp_time < 0 || $mp_time > $time_enka) {
            $mp_time = 0;
        }
    }

    if(time() > $set['pomiloval'] AND $set['pomiloval'] != 0) {
        mysql_query('UPDATE user_set SET pomiloval = "0" WHERE id = "'.$user_id.'"');
    } // Регенерация помилований

    $fataliti_user =_FetchAssoc("SELECT * FROM user_fataliti WHERE id_user = '".$user_id."' LIMIT 1");
    if(!$fataliti_user) {
        mysql_query("INSERT INTO user_fataliti SET id_user = '".$user_id."'");
    } // Добавление в таблицу фаталити

    if(time() > $fataliti_user['uho1_up'] AND $fataliti_user['uho1_up'] != 0) {
        mysql_query('UPDATE user_fataliti SET uho1_kto = "0", uho1_up = "0" WHERE id_user = "'.$user_id.'"');
    }
    if(time() > $fataliti_user['uho2_up'] AND $fataliti_user['uho2_up'] != 0) {
        mysql_query('UPDATE user_fataliti SET uho2_kto = "0", uho2_up = "0"  WHERE id_user = "'.$user_id.'"');
    } // Регенерация ушей

    if(time() > $fataliti_user['fataliti1'] OR $fataliti_user['fataliti1'] != 0) {
        mysql_query('UPDATE user_fataliti SET fataliti1 = "0" WHERE id_user = "'.$user_id.'" AND fataliti1 < "'.time().'"');
    }
    if(time() > $fataliti_user['fataliti2'] OR $fataliti_user['fataliti2'] != 0) {
        mysql_query('UPDATE user_fataliti SET fataliti2 = "0" WHERE id_user = "'.$user_id.'" AND fataliti2 < "'.time().'"');
    } // Регенерация фаталити

    $old_log=_FetchAssoc("SELECT data FROM user_voina WHERE id_user = '".$user_id."' AND data!='".$dater."' LIMIT 1");
    if($old_log) {
        mysql_query("DELETE FROM user_voina WHERE data!='".$dater."'");
    } // Очистка всех логов, кроме сегодня

    $set_ofclub_dopros=_FetchAssoc('SELECT * FROM ofclub_dopros WHERE id_user = "'.$user_id.'"');
    if(!$set_ofclub_dopros) {
        mysql_query("INSERT INTO ofclub_dopros SET id_user = '".$user_id."'");
    } //добавление в допрос шпиона




    /* БОЕВАЯ СИСТЕМА ПЕРСОНАЖ
    $vuk=_NumFilter(($user_alliance+1)*5); //берём по 5 техны на каждого члена альянса

    $user_naem_z=_FetchAssoc('SELECT * FROM user_naemniki WHERE id_user="'.$user_id.'" AND id_naemnik="1" LIMIT 1');
    $user_naem_m=_FetchAssoc('SELECT * FROM user_naemniki WHERE id_user="'.$user_id.'" AND id_naemnik="2" LIMIT 1');
    $user_naem_v=_FetchAssoc('SELECT * FROM user_naemniki WHERE id_user="'.$user_id.'" AND id_naemnik="3" LIMIT 1');
    $user_naem_l=_FetchAssoc('SELECT * FROM user_naemniki WHERE id_user="'.$user_id.'" AND id_naemnik="5" LIMIT 1');

    $data_unit_a=mysql_query("SELECT * FROM voina_unit WHERE id_user = '" . $user_id . "' ORDER BY ataka DESC LIMIT $vuk");
    $A1=0;
    $A2=0;
    $A3=0;
    $A4=0;
    $A5=0;
    $A6=0;
    while ($vua=mysql_fetch_assoc($data_unit_a)){
        if($user_naem_z['status']==1 AND ($vua['tip']==1 OR $vua['tip']==4)) {
            $A4+=$vua['ataka']*0.2;// Бонус наёмник
        }
        if($user_naem_m['status']==1 AND ($vua['tip']==2 OR $vua['tip']==5)) {
            $A5+=$vua['ataka']*0.2;// Бонус наёмник
        }
        if($user_naem_v['status']==1 AND ($vua['tip']==3 OR $vua['tip']==6)) {
            $A6+=$vua['ataka']*0.2;// Бонус наёмник
        }
        if($set['side']=='r' AND ($vua['tip']==2 OR $vua['tip']==5)) {
            $A1+=$vua['ataka'];
            $A3+=$vua['ataka']*0.2;// Бонус Россия
        } elseif ($set['side']=='g' AND ($vua['tip']==1 OR $vua['tip']==4)) {
            $A1+=$vua['ataka'];
            $A3+=$vua['ataka']*0.2;// Бонус Германия
        } elseif ($set['side']=='a' AND ($vua['tip']==3 OR $vua['tip']==6)) {
            $A1+=$vua['ataka'];
            $A3+=$vua['ataka']*0.2;// Бонус США
        } else {
            $A2+=$vua['ataka'];
        }
    } // Атака техники
    $A=$A1+$A2+$A3+$A4+$A5+$A6;


    $data_unit_z=mysql_query("SELECT * FROM voina_unit WHERE id_user = '" . $user_id . "' ORDER BY zaschita DESC LIMIT $vuk");
    $Z1=0;
    $Z2=0;
    $Z3=0;
    $Z4=0;
    $Z5=0;
    $Z6=0;
    while($vuz=mysql_fetch_assoc($data_unit_z)){
        if ($user_naem_z['status']==1 AND ($vuz['tip']==1 OR $vuz['tip']==4)) {
            $Z4+=$vuz['zaschita']*0.2;// Бонус наёмник
        }
        if ($user_naem_m['status']==1 AND ($vuz['tip']==2 OR $vuz['tip']==5)) {
            $Z5+=$vuz['zaschita']*0.2;// Бонус наёмник
        }
        if ($user_naem_v['status']==1 AND ($vuz['tip']==3 OR $vuz['tip']==6)) {
            $Z6+=$vuz['zaschita']*0.2;// Бонус наёмник
        }
        if ($set['side']=='r' AND ($vuz['tip']==2 OR $vuz['tip']==5)) {
            $Z1+=$vuz['zaschita'];
            $Z3+=$vuz['zaschita']*0.2;// Бонус Россия
        } elseif ($set['side']=='g' AND ($vuz['tip']==1 OR $vuz['tip']==4)) {
            $Z1+=$vuz['zaschita'];
            $Z3+=$vuz['zaschita']*0.2;// Бонус Германия
        } elseif ($set['side']=='a' AND ($vuz['tip']==3 OR $vuz['tip']==6)) {
            $Z1+=$vuz['zaschita'];
            $Z3+=$vuz['zaschita']*0.2;// Бонус США
        } else {
            $Z2+=$vuz['zaschita'];
        }
    } // Защита техники
    $Z=$Z1+$Z2+$Z3+$Z4+$Z5+$Z6;

    $data_su_a=mysql_query("SELECT * FROM user_superunit WHERE id_user = '" . $user_id . "' ORDER BY ataka");
    $SA=0;
    while ($vsua=mysql_fetch_assoc($data_su_a)) {
        $SA+=$vsua['ataka']*$vsua['kol'];
    } // Атака супертехники

    $data_su_z=mysql_query("SELECT * FROM user_superunit WHERE id_user = '" . $user_id . "' ORDER BY zaschita");
    $SZ=0;
    while($vsuz=mysql_fetch_assoc($data_su_z)){
        $SZ+=$vsuz['zaschita']*$vsuz['kol'];
    } // Защита супертехники

    $data_u_p=mysql_query("SELECT * FROM user_build WHERE tip = '2' AND id_user = '" . $user_id . "' ORDER BY bonus");
    $PZ1=0;
    $PZ2=0;
    while($vpuz=mysql_fetch_assoc($data_u_p)){
        if ($set['side']=='k') {
            $PZ1+=$vpuz['bonus']*$vpuz['kol'];
            $PZ2+=($vpuz['bonus']*$vpuz['kol'])*0.2;// Бонус Казахстан
        } else {
            $PZ1+=$vpuz['bonus']*$vpuz['kol'];
        }
    } // Защита построек
    $PZ=$PZ1+$PZ2;



    $trof_a=_FetchAssoc("SELECT * FROM user_trofei WHERE id_user='".$user_id."' AND id_trof='7' LIMIT 1");
    if($trof_a['status']==1 AND $trof_a['time_up']==0){
        $a_trof_bonus=($A+$SA)/100*$trof_a['bonus_1'];
        $ITOG_A=$A+$SA+$a_trof_bonus;
    } else {
        $a_trof_bonus=0;
        $ITOG_A=$A+$SA;
    }

    $trof_z=_FetchAssoc("SELECT * FROM user_trofei WHERE id_user='".$user_id."' AND id_trof='8' LIMIT 1");
    if($trof_z['status']==1 AND $trof_z['time_up']==0){
        $z_trof_bonus=($Z+$SZ+$PZ)/100*$trof_z['bonus_1'];
        $ITOG_Z=$Z+$SZ+$PZ+$z_trof_bonus;
    }else{
        $z_trof_bonus=0;
        $ITOG_Z=$Z+$SZ+$PZ;
    }

    $user_lab_krit=_FetchAssoc('SELECT * FROM user_laboratory WHERE id_user="'.$user_id.'" AND id_lab="5" LIMIT 1');

    $KRIT=$set['krit'];

    if($user_lab_krit['status']==1){
        $KRIT=$set['krit']+50;
    }

    $user_lab_uvorot=_FetchAssoc('SELECT * FROM user_laboratory WHERE id_user="'.$user_id.'" AND id_lab="6" LIMIT 1');

    $UVOROT=$set['uvorot'];

    if($user_lab_uvorot['status']==1){
        $UVOROT=$set['uvorot']+50;
    }



// ПРОТИВНИК

    $vrag=_FetchAssoc("SELECT * FROM user_set WHERE id = '".$set['id_vrag']."' LIMIT 1");

    if($vrag){

        if($vrag['sex']=='w'){$vrag_pol='Девушка';$vrag_kto='ей';$vrag_kto1='её';}else{$vrag_pol='Парень';$vrag_kto = 'ему';$vrag_kto1='его';}

        if($vrag['hp']>=0){
            $vrag['max_hp']=_NumFilter($vrag['max_hp']);
            if($vrag['hp']<$vrag['max_hp']){
                $hp_up=_NumFilter(time()-$vrag['hp_up'])/20;
                $hp_new=_NumFilter($vrag['hp']+$hp_up);
                if($hp_new<$vrag['max_hp']){
                    if($hp_up>=1){
                        mysql_query('UPDATE user_set SET hp="'.$hp_new.'", hp_up="'.time().'" WHERE id="'.$vrag['id'].'"');
                    }
                }else{
                    mysql_query('UPDATE user_set SET hp="'.$vrag['max_hp'].'" WHERE id="'.$vrag['id'].'"');
                }
            }else{
                mysql_query('UPDATE user_set SET hp="'.$vrag['max_hp'].'" WHERE id="'.$vrag['id'].'"');
            }
        }else{
            mysql_query('UPDATE user_set SET hp="0" WHERE id="'.$vrag['id'].'"');
        }// Регенерация здоровья противника

        if($vrag['raiting_wins']>=9){
            mysql_query("UPDATE user_set SET raiting=raiting+'1', raiting_wins='0' WHERE id='".$vrag['id']."' LIMIT 1");
        }// Рейтинг противника ПЛЮС

        if($vrag['raiting_loses']>=9){
            mysql_query("UPDATE user_set SET raiting=raiting-'1', raiting_loses='0' WHERE id='".$vrag['id']."' LIMIT 1");
        }// Рейтинг противника МИНУС

        if (time()>$vrag['build_up'] AND $vrag['build_up']!=0){
            $dohod_up=_NumFilter(time()-$vrag['build_up'])/3600;
            $dohod_new=_NumFilter($vrag['chistaya']*$dohod_up);
            if($dohod_up>=1){
                mysql_query('UPDATE user_set SET baks=baks+"'.$dohod_new.'", build_up="'.time().'" WHERE id = "'.$vrag['id'].'"');
            }
        }// Выплата с доходных построек противника

        $fataliti_vrag=_FetchAssoc("SELECT * FROM user_fataliti WHERE id_user = '".$vrag['id']."' LIMIT 1");

        if(time() > $fataliti_vrag['uho1_up'] AND $fataliti_vrag['uho1_up'] != 0) {
            mysql_query('UPDATE user_fataliti SET uho1_kto = "0", uho1_up = "0" WHERE id_user = "'.$vrag['id'].'"');
        }
        if(time() > $fataliti_vrag['uho2_up'] AND $fataliti_vrag['uho2_up'] != 0) {
            mysql_query('UPDATE user_fataliti SET uho2_kto = "0", uho2_up = "0"  WHERE id_user = "'.$vrag['id'].'"');
        }// Регенерация ушей









// БОЕВАЯ СИСТЕМА ПРОТИВНИК
        $vrag_alliance=_NumRows("SELECT * FROM alliance_user WHERE kto='".$set['id_vrag']."' OR s_kem='".$set['id_vrag']."'");// Колличество альянса
        $vrag_vuk=_NumFilter(($vrag_alliance+1)*5);//берём по 5 техны на каждого члена альянса

        $vrag_naem_z=_FetchAssoc('SELECT * FROM user_naemniki WHERE id_user="'.$set['id_vrag'].'" AND id_naemnik="1" LIMIT 1');
        $vrag_naem_m=_FetchAssoc('SELECT * FROM user_naemniki WHERE id_user="'.$set['id_vrag'].'" AND id_naemnik="2" LIMIT 1');
        $vrag_naem_v=_FetchAssoc('SELECT * FROM user_naemniki WHERE id_user="'.$set['id_vrag'].'" AND id_naemnik="3" LIMIT 1');
        $vrag_naem_l=_FetchAssoc('SELECT * FROM user_naemniki WHERE id_user="'.$set['id_vrag'].'" AND id_naemnik="5" LIMIT 1');

        $data_unit_vrag_a=mysql_query("SELECT * FROM voina_unit WHERE id_user = '" . $set['id_vrag'] . "' ORDER BY ataka DESC LIMIT $vrag_vuk");
        $VRAG_A1=0;
        $VRAG_A2=0;
        $VRAG_A3=0;
        while ($vrag_vua=mysql_fetch_assoc($data_unit_vrag_a)){
            if($vrag['side']=='r' AND ($vrag_vua['tip']==2 OR $vrag_vua['tip']==5)){
                $VRAG_A1+=$vrag_vua['ataka'];
                $VRAG_A3+=$vrag_vua['ataka']*0.2;// Бонус Россия
            }elseif($vrag['side']=='g' AND ($vrag_vua['tip']==1 OR $vrag_vua['tip']==4)){
                $VRAG_A1+=$vrag_vua['ataka'];
                $VRAG_A3+=$vrag_vua['ataka']*0.2;// Бонус Германия
            }elseif($vrag['side']=='a' AND ($vrag_vua['tip']==3 OR $vrag_vua['tip']==6)){
                $VRAG_A1+=$vrag_vua['ataka'];
                $VRAG_A3+=$vrag_vua['ataka']*0.2;// Бонус США
            }else{
                $VRAG_A2+=$vrag_vua['ataka'];
            }
        }// Атака техники
        $VRAG_A=$VRAG_A1+$VRAG_A2+$VRAG_A3;

        $data_unit_vrag_z=mysql_query("SELECT * FROM voina_unit WHERE id_user = '" . $set['id_vrag'] . "' ORDER BY zaschita DESC LIMIT $vrag_vuk");
        $VRAG_Z1=0;
        $VRAG_Z2=0;
        $VRAG_Z3=0;
        $VRAG_Z4=0;
        $VRAG_Z5=0;
        $VRAG_Z6=0;
        while($vrag_vuz=mysql_fetch_assoc($data_unit_vrag_z)){
            if($vrag_naem_z['status']==1 AND ($vrag_vuz['tip']==1 OR $vrag_vuz['tip']==4)){
                $VRAG_Z4+=$vrag_vuz['zaschita']*0.2;// Бонус наёмник
            }
            if($vrag_naem_m['status']==1 AND ($vrag_vuz['tip']==2 OR $vrag_vuz['tip']==5)){
                $VRAG_Z5+=$vrag_vuz['zaschita']*0.2;// Бонус наёмник
            }
            if($vrag_naem_v['status']==1 AND ($vrag_vuz['tip']==3 OR $vrag_vuz['tip']==6)){
                $VRAG_Z6+=$vrag_vuz['zaschita']*0.2;// Бонус наёмник
            }
            if($vrag['side']=='r' AND ($vrag_vuz['tip']==2 OR $vrag_vuz['tip']==5)){
                $VRAG_Z1+=$vrag_vuz['zaschita'];
                $VRAG_Z3+=$vrag_vuz['zaschita']*0.2;// Бонус Россия
            }elseif($vrag['side']=='g' AND ($vrag_vuz['tip']==1 OR $vrag_vuz['tip']==4)){
                $VRAG_Z1+=$vrag_vuz['zaschita'];
                $VRAG_Z3+=$vrag_vuz['zaschita']*0.2;// Бонус Германия
            }elseif($vrag['side']=='a' AND ($vrag_vuz['tip']==3 OR $vrag_vuz['tip']==6)){
                $VRAG_Z1+=$vrag_vuz['zaschita'];
                $VRAG_Z3+=$vrag_vuz['zaschita']*0.2;// Бонус США
            }else{
                $VRAG_Z2+=$vrag_vuz['zaschita'];
            }
        }// Защита техники
        $VRAG_Z=$VRAG_Z1+$VRAG_Z2+$VRAG_Z3+$VRAG_Z4+$VRAG_Z5+$VRAG_Z6;

        $data_su_vrag_a=mysql_query("SELECT * FROM user_superunit WHERE id_user = '" . $set['id_vrag'] . "' ORDER BY ataka");
        $VRAG_SA=0;
        while ($vrag_vsua=mysql_fetch_assoc($data_su_vrag_a)){
            $VRAG_SA+=$vrag_vsua['ataka']*$vrag_vsua['kol'];
        }// Атака супертехники

        $data_su_vrag_z=mysql_query("SELECT * FROM user_superunit WHERE id_user = '" . $set['id_vrag'] . "' ORDER BY zaschita");
        $VRAG_SZ=0;
        while($vrag_vsuz=mysql_fetch_assoc($data_su_vrag_z)){
            $VRAG_SZ+=$vrag_vsuz['zaschita']*$vrag_vsuz['kol'];
        }// Защита супертехники

        $data_u_vrag_p=mysql_query("SELECT * FROM user_build WHERE tip = '2' AND id_user = '" . $set['id_vrag'] . "' ORDER BY bonus");
        $VRAG_PZ1=0;
        $VRAG_PZ2=0;
        while($vrag_vpuz=mysql_fetch_assoc($data_u_vrag_p)){
            if($vrag['side']=='k'){
                $VRAG_PZ1+=$vrag_vpuz['bonus']*$vrag_vpuz['kol'];
                $VRAG_PZ2+=($vrag_vpuz['bonus']*$vrag_vpuz['kol'])*0.2;// Бонус Казахстан
            }else{
                $VRAG_PZ1+=$vrag_vpuz['bonus']*$vrag_vpuz['kol'];
            }
        }// Защита построек
        $VRAG_PZ=$VRAG_PZ1+$VRAG_PZ2;






        $VRAG_ITOG_A=$VRAG_A+$VRAG_SA;
        $VRAG_ITOG_Z=$VRAG_Z+$VRAG_SZ+$VRAG_PZ;

        $vrag_lab_krit=_FetchAssoc('SELECT * FROM user_laboratory WHERE id_user="'.$set['id_vrag'].'" AND id_lab="5" LIMIT 1');

        $VRAG_KRIT=$vrag['krit'];

        if($vrag_lab_krit['status']==1){
            $VRAG_KRIT=$vrag['krit']+50;
        }



        $vrag_lab_uvorot=_FetchAssoc('SELECT * FROM user_laboratory WHERE id_user="'.$set['id_vrag'].'" AND id_lab="6" LIMIT 1');

        $VRAG_UVOROT=$vrag['uvorot'];

        if($vrag_lab_uvorot['status']==1){
            $VRAG_UVOROT=$vrag['uvorot']+50;
        }









    }


    $_GET['case']=isset($_GET['case'])?_TextFilter($_GET['case']):NULL;


    mysql_query("UPDATE user_set SET online='' WHERE online<'".(time()-600)."'");
}




$kol_al = $set['lvl'] * 5;
if ($user_alliance > $kol_al) {
    $_SESSION['err'] = 'У вас перебор альянса';
}



if ($set['ban_time'] < time() && $set['ban'] == 1) {
    mysql_query("UPDATE user_set SET ban = '0', ban_time='0' WHERE id = '".$user['id']."' LIMIT 1");
    $_SESSION['ok'] = 'У вас кончилось время бана, больше не нарушайте!';
}
if ($set['block_time'] < time() && $set['block'] == 1) {
    mysql_query("UPDATE user_set SET block = '0', block_time='0' WHERE id = '".$user['id']."' LIMIT 1");
    $_SESSION['ok'] = 'У вас кончилось время блока, больше не нарушайте!';
}
if ($set['premium_time'] < time() && $set['premium'] == 1) {
    mysql_query("UPDATE user_set SET premium = '0', premium_time='0' WHERE id = '".$user['id']."' LIMIT 1");
    $_SESSION['ok'] = 'У вас кочился VIP!';
}


function number_format_short($n, $precision = 2)
{
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } elseif ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n / 1000, $precision);
        $suffix = 'k';
    } elseif ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n / 1000000, $precision);
        $suffix = 'm';
    } elseif ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n / 1000000000, $precision);
        $suffix = 'b';
    } elseif ($n < 900000000000000) {
        // 0.9t-850t
        $n_format = number_format($n / 1000000000000, $precision);
        $suffix = 't';
    } elseif ($n < 900000000000000000) {
        // 0.9q-850q
        $n_format = number_format($n / 1000000000000000, $precision);
        $suffix = 'q';
    } elseif ($n < 900000000000000000000) {
        // 0.9u-850u
        $n_format = number_format($n / 1000000000000000000, $precision);
        $suffix = 'u';
    } else {
        // 0.9x-850x
        $n_format = number_format($n / 1000000000000000000000, $precision);
        $suffix = 'x';
    } // y, h, s, d, v, w, r, g, n, c, p, o, z, vi, un, du, tr, qu, qi, se, sp, oc, nv, tn, ut, dt
    // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
    // Intentionally does not affect partials, eg "1.50" -> "1.50"
    if ($precision > 0) {
        $dotzero = '.' . str_repeat('0', $precision);
        $n_format = str_replace($dotzero, '', $n_format);
    }

    return $n_format . $suffix;
}


function eregs($x1)
{
    $x1=preg_replace("/'/","",$x1);
    $x1=preg_replace("/`/","",$x1);
    $x1=preg_replace("/>/","",$x1);
    $x1=preg_replace("/</","",$x1);
    $x1=preg_replace("/#/","",$x1);
    $x1=preg_replace("/\"/","",$x1);
    $x1=preg_replace("/~/","-",$x1);
    $x1=preg_replace("/\^/","",$x1);
    $x1=preg_replace("/\&/","",$x1);
    $x1=htmlspecialchars(trim($x1));
    return $x1;
}

$ref1=htmlspecialchars(trim(eregs($_SERVER['QUERY_STRING'])));
$ref1=str_replace('%20',':', $_SERVER['QUERY_STRING']);
$ref = explode(":",$ref1);

function timm($a){
    $sec=$a;
    $hou=floor($sec/3600);
    $sec-=$hou*3600;
    $min=floor($sec/60);
    $sec-=$min*60;
    $sec=round($sec);
    if($hou>0){echo"$hou час. $min мин.";}else{
        if($min>0){echo"$min мин. $sec сек.";}else{
            echo"$sec сек.";
        }}
    return;
}

function put($page,$get,$total){
    if ($page != 1) $pervpage = '<a href=?'.$get.':'. ($page - 1) .'>&#171; Prev</a> | ';
    if ($page != $total) $nextpage = ' | <a href=?'.$get.':'. ($page + 1) .'>Next &#187;</a></a>';
    if($page>4){$pagel=' <a href=?'.$get.':1>1</a> ...| ';}else{$pagel='';}
    if(($total-3)!=$page and ($total-3)>=$page){$pagep=' |... <a href=?'.$get.':'.$total.'>'.$total.'</a> ';}else{$pagep='';}
    if(empty($pagel)){if($page - 3 > 0) $page3left = ' <a href=?'.$get.':'. ($page - 3) .'>'. ($page - 3) .'</a> | ';}else{$page3left='';}
    if($page - 2 > 0) $page2left = ' <a href=?'.$get.':'. ($page - 2) .'>'. ($page - 2) .'</a> | ';
    if($page - 1 > 0) $page1left = '<a href=?'.$get.':'. ($page - 1) .'>'. ($page - 1) .'</a> | ';
    if(empty($pagep)){if($page + 3 <= $total) $page3right = ' | <a href=?'.$get.':'. ($page + 3) .'>'. ($page + 3) .'</a>';}else{$page3right='';}
    if($page + 2 <= $total) $page2right = ' | <a href=?'.$get.':'. ($page + 2) .'>'. ($page + 2) .'</a>';
    if($page + 1 <= $total) $page1right = ' | <a href=?'.$get.':'. ($page + 1) .'>'. ($page + 1) .'</a>';
    if ($total > 1)
    {

        echo "<hr><center>";
        echo $pervpage.$pagel.$page3left.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$page3right.$pagep.$nextpage;
        echo "</center><hr>";
    }
}

function zif($a){if(preg_match("/^[0-9]+$/i", $a)){$a=round($a);}else{$a=0;} return $a;}
function go($url){header("Location: $url");}
*/
