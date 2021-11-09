<?php
if($user->getUser()) { ?>
    <div class="line"></div>
    <div class="foot">
        <small>
            <a href="start.php?exit=<?=$title?>">
                <img src="images/icons/exit.png" alt="Выход"/>
                <span style="color: #999;"> Выход</span>
            </a>
            <span style="float: right;">
                <a href="set.php">
                    <img src="images/icons/settings.png" alt="Настройки"/>
                    <span style="color: #999;"> Настройки
                </a>
            </span><br/>
        </small>
    </div>
    </div><?
}
require_once('foot.php');