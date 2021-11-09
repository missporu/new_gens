<?php
require_once('system/sys.php');
$online1=time()+3600;$online2=time()+4200;
// mysql_query("UPDATE `user_set` SET `online`='".$online1."', `mesto`='Тюрьма', `exp` = `exp`+105, `wins`=`wins`+1, `baks`=`baks`+520000 WHERE `id`='680' ");
//mysql_query("UPDATE `user_set` SET `online`='".$online1."', `mesto`='Тюрьма' WHERE `id`='680' ");
// mysql_query("UPDATE `user_set` SET `online`='".$online2."', `mesto`='Война', `exp` = `exp`+60, `wins`=`wins`+1, `baks`=`baks`+125000 WHERE `id`='74' ");
/*mysql_query("UPDATE `user_set` SET `online`='".$online."', `mesto`='Война', `exp` = `exp`+700, `raiting` = `raiting`+1, `wins`=`wins`+9, `baks`=`baks`+4000000 WHERE `id`='680' ");*/
header("Location: index.php");
exit;