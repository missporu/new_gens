<?php
$title='Война';
require_once('system/up.php');
_Reg();
$data_voina = mysql_query("SELECT * FROM `user_set` WHERE `id`!='".$user_id."' AND `lvl`>='".($set['lvl']-3)."' AND `lvl`<='".($set['lvl']+3)."' ORDER BY RAND() LIMIT 10");
$vrag_set=_FetchAssoc("SELECT * FROM `user_reg` WHERE `id`='".$set['id_vrag']."' LIMIT 1");
$logi=_FetchAssoc("SELECT * FROM `user_voina` WHERE `id_user`='".$user_id."' AND `id_vrag`='".$vrag_set['id']."'  ORDER BY `id` DESC LIMIT 1");

switch ($_GET['case']) {
	default: ?>
		<div class="row">
			<div class="col-md-6">
				Вы <a href="view.php?smotr=<?=$set['id']?>"><?=$set['user'] ?></a>: техники в бой - <?=$vuk; ?> (макс) 
				<img src="https://gmisspo.ru/images/logotips/voina.jpg" alt="Война" width="100%"><br><?php
				
				while ($user_voina=mysql_fetch_array($data_voina)) {
					$vrag_alliance_user=_NumRows("SELECT * FROM `alliance_user` WHERE `kto`='".$user_voina['id']."' OR `s_kem`='".$user_voina['id']."'");// Колличество альянса
					$vrag_vuk_user=_NumFilter(($vrag_alliance_user+1)*5);//берём по 5 техны на каждого члена альянса
					if ($user_voina['user']!=NULL) { 
						$smotr=_FetchAssoc("SELECT * FROM `user_reg` WHERE `id`='".$vrag_set['id']."' LIMIT 1");
						$smotr_set=_FetchAssoc("SELECT * FROM `user_set` WHERE `id`='".$smotr['id']."' LIMIT 1");
						$fataliti_vrag=_FetchAssoc("SELECT * FROM `user_fataliti` WHERE `id_user`='".$smotr['id']."' LIMIT 1");
						$priglas=_NumRows("SELECT * FROM `alliance_priglas` WHERE `id_user`='".$user_id."' AND `kogo`='".$smotr['id']."'");
						$vstupil=_NumRows("SELECT * FROM `alliance_user` WHERE `kto`='".$user_id."' AND `s_kem`='".$smotr['id']."'");
						$vstupil2=_NumRows("SELECT * FROM `alliance_user` WHERE `kto`='".$smotr['id']."' AND `s_kem`='".$user_id."'");
						$smotr_alliance=_NumRows("SELECT * FROM `alliance_user` WHERE `kto`='".$smotr['id']."' OR `s_kem`='".$smotr['id']."'");
						if ($vstupil == 1 OR $vstupil2 == 1) {
							$alclas = 'text-danger';
						} ?>
						<div class="row">
							<div class="col-xs-10 <?=$alclas?>">
								<img src="images/flags/<?=$user_voina['side']?>.png" alt="Флаг" /><a href="view.php?smotr=<?=$user_voina['id']?>"><?=$user_voina['user']?></a>
								<?=$user_voina['lvl']?> lvl, <?php
								echo $user_voina['hp']." hp, ";
								echo "Ал:".$vrag_alliance_user.", возьмёт ".$vrag_vuk_user." техники";?>
							</div>
							<!-- /.col-md-6 -->
							<div class="col-xs-2 text-right">
								<a class="btn btn-primary btn-xs active" href="?case=vrag&vrag=<?=$user_voina['id']?>">Атаковать</a>
							</div>
							<!-- /.col-md-6 -->
						</div><br>
						<!-- /.row --><?php
					}
					if ($user_voina['user']==NULL) {
						$proverka_user = mysql_query("SELECT * FROM `user_reg` WHERE `id` = '".$user_voina['id']."' ");
						$itogi_prover = mysql_fetch_assoc($proverka_user);
						$usr = mysql_fetch_array($proverka_user);
						$pereuser = $itogi_prover['login'];
						$perepass = $itogi_prover['pass'];
						$peremail = $itogi_prover['email'];
						$pereip = $itogi_prover['ip'];
						$perebrowser = $itogi_prover['browser'];
						$perereferer = $itogi_prover['referer'];
						$pererefer = $itogi_prover['refer'];
						$peredata_reg = $itogi_prover['data_reg'];
						$peretime_reg = $itogi_prover['time_reg'];
						$peresite = $itogi_prover['site'];
						mysql_query("UPDATE `user_set` SET `user`='$pereuser', `pass`='$perepass', `email`='$peremail', `ip`='$pereip', `browser`='$perebrowser', `referer`='$perereferer', `refer`='$pererefer', `data_reg`='$peredata_reg', `time_reg`='$peretime_reg', `site`='$peresite' WHERE`id`='".$user_voina['id']."' ");
						
					}
				} ?>
			</div>
			<div class="col-md-6">
			</div>
		</div><?php
		break;

		case 'vrag':
		if(isset($_GET['vrag'])) {
			if ($set['udar']==0) {
				$_SESSION['err']='Закончились бои';
				header("Location: ?");
				exit();
			}
			if ($set['hp']<25) {
				$_SESSION['err']='Закончилось здоровье,<br/>отдохните или сходите в <a href="hosp.php">Госпиталь</a>';
				header("Location: ?");
				exit();
			}
			$vraglimit = mysql_query("SELECT * FROM `user_set` WHERE `id` = '".$_GET['vrag']."' LIMIT 1");
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
			<!-- /.row -->
			  
			<br><a class="btn btn-primary btn-xs active" href="?case=vrag&vrag=<?=$vrag['id']?>">Атаковать</a><?php
		}
		break;
}
require_once('system/down.php');
?>
