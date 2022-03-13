<?php
/**
$bad_words = "UNION SELECT INSERT schemata FROM DELETE DROP TRUNCATE UPDATE <script> </script> javascript group_access document.cookie alert() eval() system() OUTFILE INTO";
$bad_list = explode(separator: ' ', $bad_words);
$line = $_POST ? implode(separator: " ", $_POST) : $_SERVER['QUERY_STRING'];

foreach ($bad_list as $re) {
    $Site = $_SERVER['SERVER_NAME'];
    $Cuseragent = $_SERVER['HTTP_USER_AGENT'];
    $Gde = $_SERVER['SCRIPT_NAME'];
    $Querry = $_SERVER['QUERY_STRING'];
    if (preg_match(pattern: "/$re/i", $line)) {
        header(header: 'Refresh: 5; url=http://'.$Site.'/index1.php');
        die ("Попытка взлома сайта, запросом: $Site/$Gde?$Querry, через 5 секунд вы будете переадресованы  на страницу $Site/index1.php");
    }
} */