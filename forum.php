<?php
$title = 'Форум';
require_once "system/up.php";
$user = new RegUser();
$user->_Reg();

require_once "system/down.php";