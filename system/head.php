<?php
session_start();
ob_start();
$timeregen = microtime(TRUE); ?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Новая браузерная онлайн-игра, в которую можно играть с компьютера и мобильного телефона!">
    <meta name="keywords" content="войнушка, онлайн-игра, игра онлайн, онлайн, игра, компьютера, мобильного, телефона, играть, браузерная, новая, игрок, ролевая, стратегия"/>
    <meta name="robots" content="all"/>
    <meta name="author" content="misspo">
    <link rel="icon" href="/war-game.ico">
<?php
if (empty($title)) {
    $title = $site->name;
}
echo '<title>'  . $title . '</title>';
?>
    <!-- Bootstrap core CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <!-- Custom styles for this template -->
      <link rel="stylesheet" href="//<?= $site->getDomen() ?>/style/style.css">
      <link rel="stylesheet" href="//<?= $site->getDomen() ?>/style/standart/style.css">

    <!-- IE 10 css -->
      <link rel="stylesheet" href="//<?= $site->getDomen() ?>/style/ie10-viewport-bug-workaround.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="//<?= $site->getDomen() ?>/add.js"></script>
  </head>

  <body>

