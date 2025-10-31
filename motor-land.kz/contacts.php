<?php
session_start();
include("./hyst/constants.php");
include("./hyst/hyst.php");
include("./hyst/functions.php");
include("./hyst/phpincludes.php");
include("./hyst/seocore.php");

?>
<!doctype html>
<html>
<head>
	<?php include("hyst/metacore.php"); ?>
</head>
<body>
<?php include("hyst/postheabinc.php"); ?>
<?php include("des/head.php"); ?>
<br><br>
<div class="generalw">
	<div class="shirina">
		<div class="crumbsblock">
		<a href="index.php">Главная</a> / Контакты
		</div>
		<br><br><br>
		<div class="inline-contacts">
			<div class="foterconicon" style="background-image: url(./img/tel.png);"><a href="tel:+77273466699" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});">+7 727 346 66 99</a><br><a href="tel:+77771445445" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});">+7 777 1445 445</a></div>
		</div>
		
		<div class="inline-contacts">
			<div class="foterconicon" style="background-image: url(./img/pos.png);">onix_kz@inbox.ru</div>
			<div class="foterconicon" style="background-image: url(./img/day.png);">пн-сб | 10:00-19:00</div>
		</div>
		
		<div class="inline-contacts">
			<div class="foterconicon" style="background-image: url(./img/loc.png);">Алматы, ул. Свердлова, дом 38</div>
		</div>
		
		<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A7f3534207526eaa3fc4288c55720ef5bf87c1fae35fecbd8953f8b3dab48de0e&amp;width=100%25&amp;height=300&amp;lang=ru_RU&amp;scroll=true"></script>
	</div>
</div>
<br><br>
<?php include("des/foter.php"); ?>
<?php include("hyst/postbodyinc.php"); ?>
</body>
</html>