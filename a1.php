<?php
$_GET['case']=isset($_GET['case'])?htmlspecialchars($_GET['case']):NULL;
if($_GET['case']=='naemniki') {
	$titles=' | Наёмники';
} elseif($_GET['case']=='laboratory') {
	$titles=' | Лаборатория';
} elseif($_GET['case']==3) {
	$titles=' | Ресурсы';
} elseif($_GET['case']==4) {
	$titles=' | Имущество';
} elseif($_GET['case']==5) {
	$titles=' | Банк';
} else {
	$titles=FALSE;
}
$title='Чёрный рынок'.$titles.'';
require_once('system/up.php');
_Reg();
?><div class="row"><?php
switch ($_GET['case']) {
	default:
		if ($set['logo'] == 'on') { ?>
			<div class="col-md-4">
				<img src="images/logotips/blackmarket.jpg" alt="Чёрный рынок" class="img-responsive">
			</div><?php
		} ?>
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-3 text-center">
						<a class="btn" href="voentorg.php"><img src="images/icons/arrow.png" alt="*"/>Военторг</a>
					</div>
					<div class="col-md-9">
						<p>В военторге лучшие генералы закупаются уникальными секретными разработками, обладающими непревзайденными характеристиками, и позволяющими разносить вражеские армии в пух и прах без особых усилий! Особо ценится среди главнокомандующих разработка, под названием "Кузькина мать" - именно ради нее, самые отчаянные генералы, и приходят к нам, на чёрный рынок!</p><hr>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-3 text-center">
						<a class="btn" href="blackmarket.php?case=naemniki"><img src="images/icons/arrow.png" alt="*"/>Наемники</a>
					</div>
					<div class="col-md-9">
						<p>Благодаря этим бесподобным по своим качествам наемникам, Вы получите дополнительные бонусы в боях с другими генералами. Различные бонусы (к атаке и зещите) могут кардинально изменить исход боя! А наши специальные наемники шпионы - Контрагент Смит - не даст Вашему противнику узнать про Вас какую-либо информацию, а Лара Иванова - наоборот, охмурит любого контрагента, и узнает все тайны Вашего противника!</p><hr>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-3 text-center">
						<a class="btn" href="blackmarket.php?case=laboratory"><img src="images/icons/arrow.png" alt="*"/>Лаборатория</a>
					</div>
					<div class="col-md-9">
						<p>Ну заходи, <?=$set['user'] ?>, раз пришел! Специально для тебя, мой друг,эта небольшая секретная лаборатория работает каждый день, 24 часа в сутки без выходных и праздников! Ты почаще забегай, за моей дря... Химией... Кхе... Не бесплатно конечно! У нас ведь, на черном рынке, за бесплатно можно только себя продать. Кхе... Ты, это.. никому не говори только, лады? Не люблю стукачей... Кхе-кхе... </p><hr>
					</div>
				</div>
			</div>
		</div><?php
		break;
} ?>
</div>
<?php require_once('system/down.php');