<?php
include('hyst/php.php');

$SITE_TITLE = 'Моторленд | Контакты';
$SITE_DESCRIPTION = 'Контакты компании Motor Land - контрактные двигатели и КПП в Алматы';
?>
<!doctype html>
<html>
<head>
<?php include("hyst/head.php"); ?>
<link rel="canonical" href="https://motor-land.kz/contacts.php"/>
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
		<a href="/">Главная</a> / Контакты
		</div>
		
	</div>
</div>	

<div class="generalw">
	<div class="shirina zgolovorleft">
		<div class="sttitle"><span>Контакты</span></div>
	</div>
</div>

<div class="generalw contacts-main">
	<div class="shirina">
		<div class="footer_contacts contacts-page">
			<div class="footer_contact_block contact-card">
				<div class="contact-card-header">
					<h3 class="contact-office-title">Офис №1</h3>
				</div>
				<div class="contact-card-content">
					<div class="contact-item contact-icon-location">
						<span class="contact-label">Адрес:</span>
						<a target="_blank" href="https://2gis.kz/almaty/search/РВ-90%2C%207-линия%2C%2029" class="contact-link">РВ-90, 7-линия, 29</a>
					</div>
					<div class="contact-item contact-icon-phone">
						<span class="contact-label">Телефон:</span>
						<a href="tel:+77771445445" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});" class="contact-link">+7 777 144 5445</a>
					</div>
					<div class="contact-item contact-icon-whatsapp">
						<span class="contact-label">WhatsApp:</span>
						<a href="https://wa.me/77771445445" class="contact-link">Написать в WhatsApp</a>
					</div>
					<div class="contact-item contact-icon-schedule">
						<span class="contact-label">Режим работы:</span>
						<div class="contact-schedule">
							пн-пт | 9:00-18:00<br>
							суббота | 10:00-15:00<br>
							воскресенье | выходной
						</div>
					</div>	
				</div>
			</div>
			<div class="footer_contact_block contact-card">
				<div class="contact-card-header">
					<h3 class="contact-office-title">Офис №2</h3>
				</div>
				<div class="contact-card-content">
					<div class="contact-item contact-icon-location">
						<span class="contact-label">Адрес:</span>
						<a target="_blank" href="https://2gis.kz/almaty/search/улица%20Свердлова%2C%2038" class="contact-link">улица Свердлова, 38</a>
					</div>
					<div class="contact-item contact-icon-phone">
						<span class="contact-label">Телефоны:</span>
						<div class="contact-phones">
							<a href="tel:+77011445445" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});" class="contact-link">+7 701 144 5445</a><br>
							<a href="tel:+77071445445" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});" class="contact-link">+7 707 144 5445</a>
						</div>
					</div>
					<div class="contact-item contact-icon-whatsapp">
						<span class="contact-label">WhatsApp:</span>
						<a href="https://wa.me/77011445445" class="contact-link">Написать в WhatsApp</a>
					</div>
					<div class="contact-item contact-icon-schedule">
						<span class="contact-label">Режим работы:</span>
						<div class="contact-schedule">
							пн-пт | 9:00-18:00<br>
							суббота | 10:00-15:00<br>
							воскресенье | выходной
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="map contacts-map">
			<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A7f3534207526eaa3fc4288c55720ef5bf87c1fae35fecbd8953f8b3dab48de0e&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
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
