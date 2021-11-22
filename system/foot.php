<?php Site::lineHrInContainer() ?>
<div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <a href="good.php">
                <small class="text-warning">Правила игры</small>
            </a>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-12 text-center">
            <small>
                <span id="server_time"><?= Times::setTime() ?></span> | <?= Times::setDate() ?> |<?
                if ($user->getUser()) { ?>
                    <b style="color: #fff;"><a href="online.php">Онлайн
                        (<?php echo $sql->getOne("select count(id) from users where online > ?i", time() - 600); ?>)</a>
                    </b><?
                } else { ?>
                    <b style="color: #fff;">
                    Онлайн: <?php echo $sql->getOne("select count(id) from users where online > ?i", time() - 600); ?></b><?
                } ?>
            </small>
        </div>
    </div>
</div>
<?php Site::lineHrInContainer() ?>
<div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <a href="//<?= Site::getDomen() ?>" onclick="javascript: return add_favorite(this);"
               title="Добавить в закладки">В закладки</a>
        </div>
        <? Site::PrintMiniLine() ?>
        <div class="col-xs-12 text-center">
            <script type="text/javascript" src="https://mobtop.ru/c/121843.js"></script>
            <noscript><a href="https://mobtop.ru/in/121843"><img src="https://mobtop.ru/121843.gif"
                                                                 alt="MobTop.Ru - Рейтинг и статистика мобильных сайтов"/></a>
            </noscript>
        </div>
        <? Site::PrintMiniLine() ?>
        <div class="col-xs-12 text-center">
            <p class="small">Разработка сайтов - <a href="//misspo.ru">misspo</a> &copy; 2016 - <?= date("Y"); ?>.</p>
        </div>
        <? Site::PrintMiniLine() ?>
        <div class="col-xs-12 text-center small">
            <?= round(num: microtime(as_float: 1) - $timeregen, precision: 4); ?> сек.
        </div>
        <? Site::PrintMiniLine() ?>
        <div class="col-xs-12 text-center">
            <a href="//l2.misspo.ru">Недописанная игра с чатом)</a>
        </div>
    </div>
</div>
<script src="../js/moscow-time.js"></script>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="//<?= Site::getDomen() ?>/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>