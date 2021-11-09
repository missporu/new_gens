<?
$title = 'Общение';
define('H', $_SERVER['DOCUMENT_ROOT'].'/');
require H."system/up.php";
_Reg();
if ($set['block']==1) {
header("Location: /blok.php");
exit();
}












require H."system/down.php";
?>