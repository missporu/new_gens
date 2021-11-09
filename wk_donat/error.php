<?php
$title = 'Покупка золота';
require_once('../system/sys.php');
_Reg();
$_SESSION['err'] = 'При пополнении произошла ошибка!';
header('Location: ../menu.php');
exit();
?>
