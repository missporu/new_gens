<?php
$title='Тюрьма';
require_once('system/up.php');
_Reg();
$block_prichina = mysql_query("SELECT * FROM `block` WHERE `kto`='".$set['id']."' AND `tip`='2' ORDER BY `id` DESC LIMIT 1");
$block = mysql_fetch_array($block_prichina);
$timeblock1 = ($set['block_time']-time()); ?>
<div class="row text-center"><h2>Вы наказаны и находитесь в блоке!</h2>
	<div class="col-md-12">
		<img src="images/socialprev.png" alt="Тюрьма" class="img-responsive">
		<p>Причина блока: <?= $block['text'] ?></p>
		<p>Время блока: <?= _DayTime($timeblock1) ?></p>
		<p>Вы можете оспорить блок, написав в личную почту Администраторам или старшим модераторам.</p>
	</div>
	<!-- /.col-md-12 -->
</div>
<!-- /.row --><?php
require_once('system/down.php');