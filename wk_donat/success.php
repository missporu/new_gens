<?php
$title = 'Покупка золота';
require_once('../system/sys.php');
_Reg();
$_SESSION['ok'] = 'Ваш баланс успешно пополнен!';
header('Location: ../menu.php');
exit();
?>
