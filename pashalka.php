<?php
$title='Обмен пасхальных яиц';
require_once('system/up.php');
_Reg();
$vrag_set=_FetchAssoc("SELECT * FROM `user_set` WHERE `id`='".$set['id_vrag']."' LIMIT 1");
$logi=_FetchAssoc("SELECT * FROM `user_voina` WHERE `id_user`='".$user_id."' AND `id_vrag`='".$vrag_set['id']."'  ORDER BY `id` DESC LIMIT 1");
$vraglimit = mysql_query("SELECT * FROM `user_set` WHERE `id` = '".$_GET['vrag']."' LIMIT 1");
$vrag_id = mysql_fetch_array($vraglimit);
switch ($_GET['case']) {
	default:
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
		<div class="row text-center">
			<p class="text-muted">Вот и прошла пасха! Но к сожалению, вы слишком долго хранили свои яйца, и они у Вас испортились!!! Что же на это скажет админ? Давайте-ка сами у него узнаем!!! Собравшись, и посовещавшись с другими генералами, Вы решаете пойти и все узнать "на месте" . А вот и Админ... Ну что ж ... Получай свои яйца!!!</p>
			<div class="col-md-12">
				<img src="images/1BB1.jpg" alt="Win" class="img-responsive">
			</div>
			<!-- /.col-md-12 -->
		</div>
		<div class="row">
			<div class="col-md-12 text-center">
				<br><a class="btn btn-primary btn-xs active" href="?case=ataka&vrag=1?>">Кинуть яйцом</a>
			</div>
		</div>
		<!-- /.row --><?php
		break;
		case 'vrag':
			if(isset($_GET['vrag'])){
				$vrag=_NumFilter($_GET['vrag']);
				mysql_query("UPDATE `user_set` SET `id_vrag`='0' WHERE `id`='".$user_id."' LIMIT 1");
				if($set['udar']==0){
					$_SESSION['err']='Закончились яйца';
					header("Location: case=vrag");
					exit();
				}
				header("Location: ?case=ataka&vrag=1");
				exit();
			}
			if (isset($_GET['vrag']) && $_GET['vrag']==1) {
				$vrag=_NumFilter($_GET['vrag']); ?>
				<row>
		            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center">
		                <div class="row left-battle"><?=$user['login']?>
		                    <img src="images/flags/<?=$set['side']?>.png" alt="Флаг" />
		                    <img src="images/icons/vs.png" alt="vs" />
		                    <img src="images/flags/<?=$vrag['side']?>.png" alt="Флаг" />
		                    <?=$vrag_set['user']?><hr><?php
		                    if (round(100 / ($vrag['max_hp'] / ($vrag['hp']))) > 100) {
		                        $proc = 100;
		                    } else {
		                        $proc = round(100 / ($vrag['max_hp'] / ($vrag['hp'])));
		                    } ?>
		                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?=$proc ?>%; height: 18px; background-color: #f00; color: #000;"><?=$vrag['hp'] ?> hp
		                    </div>
		                </div>
		                <div class="row text-center"><?php
		                    if (empty($logi['rezult'])) {
		                        header("Location: ?case=vrag");
		                        exit();
		                    }
		                    if ($logi['rezult']=='win') {
		                        if ($set['logo']=='on') { ?>
		                            <img src="images/1BB1.jpg" alt="Win" class="img-responsive"><hr><?php
		                        } ?>
		                        <h3 class="admin text-info">Победа !!!</h3><hr><?php
		                    } ?>
		                </div>
		            </div>
		            <!-- /.col-xs-12 col-sm-6 col-md-6 col-lg-6 -->
		            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-info">
		                <img src="images/icons/ataka.png" alt="ataka" /> Нанесено:
                        <span style="color: #9c9;"><?=$logi['nanes']?></span> урона
                        <?=$krit_user?><?=$uvorot_vrag?><br /><img src="images/icons/ataka.png"
                            alt="ataka" /> Получено: <span
                            style="color: #c66;"><?=$logi['poluchil']?></span> урона
                        <?=$krit_vrag?><?=$uvorot_user?><br /><img src="images/icons/baks.png"
                            alt="baks" /> Награблено: <span
                            style="color: #9c9;"><?=$logi['baks']?></span> баксов<br /><img
                            src="images/icons/lvl.png" alt="lvl" /> Заработано: <span
                            style="color: #9c9;"><?=$logi['exp']?></span> опыта
		            </div>
		            <!-- /.col-xs-12 col-sm-6 col-md-6 col-lg-6 -->
		        </row><?php
			}
			break;
		case 'ataka':
			$vrag=isset($_GET['vrag'])?_NumFilter($_GET['vrag']):NULL;
			if($set['id_vrag']==0){
				mysql_query("UPDATE `user_set` SET `id_vrag`='".$vrag."' WHERE `id`='".$user_id."' LIMIT 1");
				header('Location: ?case=ataka');
				exit();
			}
			$vrag_set=_FetchAssoc("SELECT * FROM `user_set` WHERE `id`='".$set['id_vrag']."' LIMIT 1");
			if($set['pasha']==0){
				$_SESSION['err']='Закончились яйца';
				header("Location: ?");
				exit();
			}
			$minus_yaiki = $set['pasha']-1;
			mysql_query("UPDATE `user_set` SET `pasha`='".$minus_yaiki."' WHERE `id`='".$set['id']."' LIMIT 1");
			$random_shans=rand(1,100);
			if ($random_shans <= 5) {
				$random_user_r = rand(1,9);
				$data2_sail_unit=_FetchAssoc("SELECT * FROM `user_superunit` WHERE `id_unit`='".$random_user_r."' AND `id_user`='" . $set['id'] . "' LIMIT 1");
				$plus_gold = $data2_sail_unit['pasha']+$random_user_r;
				mysql_query("UPDATE `user_superunit` SET `kol`=`kol`+'1' WHERE `id_unit`='" . $random_user_r . "' AND `id_user`='" . $set['id'] . "' LIMIT 1");
				$random2_superunit_screen='<img src="images/superunits/'.$random_user_r.'.png" style="margin-left:5px;margin-right:0px;border:1px solid #999;" alt="Разработка">';
				$random_priz = "Админ просит сжалиться и дарит Вам секретную разработку ".$random2_superunit_screen." !!!";
			} elseif ($random_shans <= 15) {
				$random_user_r = rand(1,2);
				$plus_gold = $set['pasha']+$random_user_r;
				mysql_query("UPDATE `user_set` SET `pasha`='".$plus_gold."' WHERE `id`='".$set['id']."' LIMIT 1");
				$random_priz = "Админ просит сжалиться и дает Вам еще ".$random_user_r." тухлых яиц";
			} elseif ($random_shans <= 55) {
				$random_user_r = rand(1,2);
				$plus_gold = $set['gold']+$random_user_r;
				mysql_query("UPDATE `user_set` SET `gold`='".$plus_gold."' WHERE `id`='".$set['id']."' LIMIT 1");
				$random_priz = "Админ просит сжалиться и дает Вам ".$random_user_r." Золота";
			} elseif ($random_shans <= 85) {
				$random_user_r = rand(1000000,5000000);
				$plus_gold = $set['baks']+$random_user_r;
				mysql_query("UPDATE `user_set` SET `baks`='".$plus_gold."' WHERE `id`='".$set['id']."' LIMIT 1");
				$random_priz = "Админ просит сжалиться и дает вам ".$random_user_r." Баксов";
			} else {$random_priz = "Админ спросонья смотрит на Вас, глупо моргает и просто молчит... Задайте-ка ему!";}
			echo "Вы кинули в Админа 1 тухлое яйцо! У вас в запасе еще " . $set['pasha'] . " яиц";
			?><div class="row">
				<div class="col-md-12 text-center">
					<img src="images/1admin.jpg" alt="Win" class="img-responsive"><hr>
					<p> <?=$random_priz ?></p>
					<br><a class="btn btn-primary btn-xs active" href="?case=ataka&vrag=1?>">Кинуть еще яйцо</a>
				</div>
			</div><?php
			break;
}
require_once('system/down.php');