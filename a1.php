<?php
require_once 'system/up.php';
$ria = (new SafeMySQL())->getCol("select sum(raiting) from user_unit where id_user = ?i", 1);
var_dump($ria);
echo $ria[0];