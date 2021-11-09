<?php
$title='Избиение босса';
require_once('system/up.php');
_Reg();
switch ($_GET['case']) {
	default:
		if ($set['udar']==0) {
			$_SESSION['err']='Закончились бои';
			header("Location: ?");
			exit();
		}
		$vraglimit = mysql_query("SELECT * FROM `user_set` WHERE `id` = '1' LIMIT 1");
		$vrag = mysql_fetch_array($vraglimit); 
		if (round(100 / ($vrag['max_hp'] / ($vrag['hp']))) > 100) {
			$proc = 100;
		} else {
			$proc = round(100 / ($vrag['max_hp'] / ($vrag['hp'])));
		} ?>
		<div class="row">
			<div class="col-md-6 text-center">
				<img src="images/flags/<?=$vrag['side']?>.png" alt="Флаг" /> <?php echo $vrag['user']."<br>";?>
			</div>
			<div class="col-md-6" style="background-color: #fff;">
				<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?=$proc ?>%; height: 100%; background-color: #f00; color: #000;">
				    <?=$vrag['hp'] ?> hp
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<img src="images/1BB1.jpg" alt="Win" class="img-responsive">
			</div>
			<!-- /.col-md-12 -->
		</div>
		<div class="row">
			<div class="col-md-12 text-center">
				<br><a class="btn btn-primary btn-xs active" href="?case=vrag&vrag=<?=$vrag['id']?>">Атаковать</a>
			</div>
		</div>
		<!-- /.row --><?
		break;
}
require_once('system/down.php');