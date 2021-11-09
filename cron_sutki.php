<?php
require_once('system/sys.php');
mysql_query("UPDATE `user_set` SET `skoko_spusk`='0' ");
$sql->query("UPDATE production SET timer=?i",90);
$sql->query("DELETE FROM production_logs WHERE data<?i",(time()-604800));
// $sql->query("UPDATE user_set SET baks=?i, dohod=?i, chistaya=?i WHERE last_date_visit<?i",0, 0, 0, '1 июня');
?>