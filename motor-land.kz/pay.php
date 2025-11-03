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
<!-- Экран загрузки -->
<div id="loader-screen" class="loader-screen">
	<div class="loader-video-container">
		<video id="loader-video" class="loader-video" autoplay muted playsinline>
			<source src="img/loader.mp4" type="video/mp4">
			<div class="loader-fallback">Моторленд</div>
		</video>
	</div>
</div>

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

<script>
document.addEventListener('DOMContentLoaded', function() {
	var loader = document.getElementById('loader-screen');
	var video = document.getElementById('loader-video');
	
	function hideLoader() {
		if (loader && !loader.classList.contains('hidden')) {
			loader.classList.add('hidden');
			setTimeout(function() {
				if (loader) loader.style.display = 'none';
			}, 500);
		}
	}
	
	if (video) {
		video.addEventListener('ended', hideLoader);
		video.addEventListener('loadeddata', function() {
			setTimeout(hideLoader, 800);
		});
		video.play().catch(function() {});
	}
	
	setTimeout(hideLoader, 1500);
	window.addEventListener('load', function() {
		setTimeout(hideLoader, 300);
	});
});
</script>
</body>
</html>