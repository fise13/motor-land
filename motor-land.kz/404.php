<?php
// SEO: Правильный HTTP 404 статус для страницы ошибки
http_response_code(404);
include('hyst/php.php');

$SITE_TITLE = 'Страница не найдена (404) | Моторленд';
$SITE_DESCRIPTION = 'Запрошенная страница не найдена. Вернитесь на главную страницу или воспользуйтесь каталогом контрактных двигателей.';
?>
<!doctype html>
<html lang="ru">
<head>
	<?php include("hyst/head.php"); ?>
	<link rel="canonical" href="https://motor-land.kz/404.php"/> 
</head>
<body>
<?php include("hyst/sbody.php"); ?>
<?php include("des/head.php"); ?>
<br><br>
<div class="generalw">
	<div class="shirina">
		<div class="crumbsblock">
		<a href="/">Главная</a> / 404 страница не найдена
		</div>
		
	</div>
</div>


<div class="generalw">
	<div class="shirina zgolovorleft">
		<h1>404 страница не найдена</h1>
	</div>
</div>

<div class="generalw">
	<div class="shirina">
		<div class="abouttext1">
		Извините такой страницы не существует, <a href="/">вернуться на главную</a>
		</div>
	</div>
</div>

<br><br>
<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>
</body>
</html>