<?php
$title = ''; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Музыка Miss Po</title>
    <meta name="description", content="Новая браузерная онлайн-игра, в которую можно играть с компьютера и мобильного телефона!">
    <meta name="keywords" content="Музыка для экстренных случаев Miss Po. Скачать можно но все права принадлежат артисту и творческой студии MissPo. "/>
    <meta name="robots" content="all"/>
    <meta name="author" content="misspo">
    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        audio::-internal-media-controls-download-button {
            display: none;
        }
        audio::-webkit-media-controls-enclosure {
            overflow: hidden;
        }
        audio::-webkit-media-controls-panel {
            width: calc(100% + 30px);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="text-info text-center">
                Аудио файлы misspo.ru
            </h2>
            <!-- h2 class="text-info text-center">
                Скачайте музыку или ставьте прямо с сайта на выступление (при наличие хорошего интернет - соединения)
            </h2 -->
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12"><?
            $dir = "music"; // Директория с mp3-файлами
            $files = glob("$dir/*.mp3"); // Получаем список mp3-файлов
            for ($i = 0; $i < count($files); $i++) { ?>
                <p class="text-danger"><?= basename($files[$i]) ?></p>
                <audio controls controlsList="nodownload">
                <source src="<?= $files[$i] ?>" type="audio/ogg; codecs=vorbis">
                <source src="<?= $files[$i] ?>" type="audio/mpeg">
                Тег audio не поддерживается вашим браузером.
                <? // <a href="<?= $files[$i] ">Скачайте музыку</a>. ?>
                </audio><?
            } ?>
        </div>
        <div class="col-xs-12">
            <h2 class="text-center">
                Видео
            </h2>
        </div>
        <div class="col-xs-12">
            <iframe width="100%" height="315" src="https://www.youtube.com/embed/_kvaNKObW3k" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="col-xs-12">
            <video width="100%" height="315" controls="controls">
                <source src="https://misspo.ru/video/DUET_X.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                Тег video не поддерживается вашим браузером.
                <a href="https://misspo.ru/video/DUET_X.mp4">Скачайте видео</a>.
            </video>
        </div>
    </div>
    <script>
        document.oncontextmenu = cmenu; function cmenu() { return false; }
    </script>
</div>
</body>
</html>