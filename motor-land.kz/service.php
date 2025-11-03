<?php
include('hyst/php.php');

$SITE_TITLE = 'Моторленд | Автосервис';
$SITE_DESCRIPTION = 'Профессиональная замена и обслуживание двигателей, а также замена КПП для автомобилей различных марок и моделей.';
?>
<!doctype html>
<html>
<head>
<?php include("hyst/head.php"); ?>
<link rel="canonical" href="https://motor-land.kz/service"/> 
</head>
<body>
<?php include("hyst/sbody.php"); ?>
<?php include("des/head.php"); ?>
<br><br>
<div class="generalw">
	<div class="shirina">
		<div class="crumbsblock">
		<a href="/">Главная</a> / Автосервис
		</div>
		
	</div>
</div>


<div class="generalw">
	<div class="shirina zgolovorleft">
		<div class="sttitle"><span>Автосервис</span></div>
	</div>
</div>

<div class="generalw">
	<div class="shirina">
		<div class="aboutblock1" style="background-image: url(<?=get_simple_images('service_image')[0];?>);">
			<div class="abouttext1">
			<?=get_customtexts('delivery_page');?>
			
			</div>
		</div>
	</div>
</div>

<br><br>
<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

</body>
</html>