<?php
include('hyst/php.php');

$SITE_TITLE = 'Моторленд | Акции на контрактные Моторы и КПП | Доставка по СНГ';
$SITE_DESCRIPTION = 'Акции и спецпредложения на контрактные моторы и КПП в Алматы. Скидки на привозные двигатели из Малайзии. Контрактные двигатели Казахстан, Россия, Беларусь, СНГ по выгодным ценам. Ограниченные предложения. Доставка по странам СНГ.';
$SITE_KEYWORDS = 'акции контрактные моторы, скидки на двигатели алматы, спецпредложения КПП, акции двигателей бу, контрактные двигатели СНГ, доставка двигателей СНГ';
?>
<!doctype html>
<html>
<head>
<?php include("hyst/head.php"); ?>
</head>
<body>
<?php include("hyst/sbody.php"); ?>
<?php include("des/head.php"); ?>
<br><br>
<div class="generalw">
	<div class="shirina">
		<div class="crumbsblock">
		<a href="/">Главная</a> / Акции
		</div>
	</div>
</div>	


<div class="generalw">
	<div class="shirina zgolovorleft">
		<div class="sttitle"><span>Акции</span></div>
		
		<ul class="actionperekl">
			<a href="/actions"><li class="actionpereklact" style="color: white;">акции</li></a>
			<a href="/catalog"><li>каталог</li></a>
		</ul>
	</div>
</div>


<div class="generalw">
	<div class="shirina">	

		<?php
		$sale_value = 'noting';
		$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_tovari WHERE sale != ? ORDER BY prio ASC");
		$stmt->bind_param("s", $sale_value);
		$stmt->execute();
		$tmps = $stmt->get_result();
		if ($tmps->num_rows != 0) {
			while($get = $tmps->fetch_array()):
		?>
		<div class="toverblock revealator-slideup">
			<a href="/detal?id=<?=$get['id'];?>"><div class="toverimg" style="background-image: url(<?=get_farrimg($get['images'])[0];?>);">
			<?php if ($get['sale'] != 'noting') { ?>
			<div class="cationsale"><?=$get['sale'];?></div>
			<?php } ?>
			</div></a>
			<div class="tovertitle"><?=$get['name'];?></div>
			<div class="tovaropis">
				<?=$get['stext'];?>
			</div>
			<div class="tovercena"><?=($get['cash']!=0 && $get['cash']!='0'?$get['cash'].' KZT':'Цена по запросу');?></div>
			<a href="tel:<?=preg_replace('/[^\\d+]/','', get_simple_texts('index_slider_phone'));?>" class="toverbuton" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});">Купить</a>
		</div>
		<?php
			endwhile;
		}
		if (isset($stmt)) {
			$stmt->close();
		}
		?>
		
	</div>
</div>
<br><br>
<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

</body>
</html>