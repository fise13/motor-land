<?php
include('hyst/php.php');

$SITE_TITLE = 'Моторленд | Оплата';
$SITE_DESCRIPTION = 'Доставка автозапчастей и двигателей по всей территории Казахстана и в страны СНГ через транспортные компании.';
?>
<!doctype html>
<html>
<head>
	<?php include("hyst/head.php"); ?>
	<link rel="canonical" href="https://motor-land.kz/pay"/> 
</head>
<body>
<?php include("hyst/sbody.php"); ?>
<?php include("des/head.php"); ?>
<br><br>
<div class="generalw">
	<div class="shirina">
		<div class="crumbsblock">
		<a href="/">Главная</a> / Доставка и Оплата
		</div>
		
	</div>
</div>


<div class="generalw">
	<div class="shirina zgolovorleft">
		<div class="sttitle"><span>Доставка и Оплата</span></div>
	</div>
</div>

<div class="generalw">
	<div class="shirina">
		<div class="aboutblock1" style="background-image: url(<?=get_simple_images('delivery_pay_image')[0];?>);">
			<div class="abouttext1">
			<?=get_customtexts('payment_page');?>
			</div>
		</div>
	</div>
</div>

<br><br>
<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>
</body>
</html>