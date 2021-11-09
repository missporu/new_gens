        <hr>
        <div class="col-xs-12 grey text-center">
            <a href="good.html">
                <small class="text-warning">Правила игры</small>
            </a><br>
            <p>
                Разработка сайтов - <a href="//misspo.ru">misspo</a> &copy; 2016 - <?=date("Y");?>.
            </p>
            <script>
                function moscowTime() {
                    var d = new Date();
                    d.setHours( d.getHours() + 3, d.getMinutes() + d.getTimezoneOffset()  );
                    return d.toTimeString().substring(0,8);
                }

                onload = function () {

                setInterval(function () {
                    document.getElementById("server_time").innerHTML = moscowTime();
                }, 100);}
            </script>
            <div class="separ"></div>
            <span class="small grey">
                <?php echo round(microtime(1) - $timeregen, 4); ?> сек.,
                <span id="server_time"><?= $time ?></span> | <?= $site->getDate() ?> | <b style="color: #fff;">Онлайн: <?php echo $sql->getOne("select count(id) from users where online > ?i", time()-600); ?></b>
    </span><br>
                <a href="//<?= (new Site())->getDomen() ?>" onclick="javascript: return add_favorite(this);" title="Добавить в закладки">В закладки</a><br>
                <script type="text/javascript" src="https://mobtop.ru/c/121843.js"></script><noscript><a href="https://mobtop.ru/in/121843"><img src="https://mobtop.ru/121843.gif" alt="MobTop.Ru - Рейтинг и статистика мобильных сайтов"/></a></noscript>
                <br><? /*
$date = date("d.m.Y");
if ($user) { ?>
<div class="block_zero center"><?php
$action_on = _FetchAssoc("SELECT * FROM `setting_game` WHERE `id`='1' LIMIT 1");
if  ($action_on['data_gold'] < time()) {
    mysql_query("UPDATE `setting_game` SET `action_gold`='0', `skolko_gold`='0', `data_gold`='0' WHERE `id`='1' LIMIT 1");
}
if ($set['premium'] == 1) { ?>
    <a href="bank.php?case=worldkassa"><b style="color: #fff">До конца премиума осталось <?= _Time($set['premium_time']-time()) ?> !</b></a> <br> <?php
}
$time_action_gold = $action_on['data_gold']-time();
if ($action_on['action_gold'] == 1) { ?>
    <a href="bank.php?case=worldkassa"><b style="color: #f0f">Акция! x<?= $action_on['skolko_gold'] ?> к золоту!</b></a> <?= _DayTime($time_action_gold) ?><br> <?php
} ?>
    <small>
        <a class="text-white" href="rules.php">Правила игры</a> | 
        <a class="text-white" href="mail.php?case=post&log=1">Письмо Админу</a> | 
        <a class="text-white" href="faq.php">Помощь</a> | 
        <a class="text-white" href="https://vk.com/generals_misspo">ВКонтакте</a></br>
        <a href="https://misspo.ru">misspo.ru</a> | 
<div id="blink7"><a href="http://l2.gmisspo.ru">Linages II - (игра-партнер)</a> |</div>
        
    </small>
    <div class="separ"></div>
    <span class="small grey"><?php echo round(microtime(1) - $timeregen, 4); ?> сек., </span>
        <?php echo'<span id="server_time">'.$time.'</span>  | <b style="color: #fff;">'.$date.'</b>'; ?> | 
    <a href="online.php">
    <span style="color: #fff;"><b>Онлайн: <?php echo $sql->getOne("select  count(*) from user_set where online > ?i", time()-600); ?></b></a>
</div>
<center>
    <a href="http://statok.net/go/19478"><img src="//statok.net/imageOther/19478" alt="Statok.net" /></a>
    <script type="text/javascript" src="https://mobtop.ru/c/121844.js"></script><noscript><a href="https://mobtop.ru/in/121844"><img src="https://mobtop.ru/121844.gif" alt="MobTop.Ru - Рейтинг и статистика мобильных сайтов"/></a></noscript>
    <br/>
</center>
<?php 
} else {
    <a href="http://statok.net/go/19478"><img src="//statok.net/image/19478" alt="Statok.net" /></a><br/>
} */ ?>
            <script>
                $(function(){
                    $('[data-toggle="tooltip"]').tooltip();
                });
            </script>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="//<?= $site->getDomen() ?>/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
