<?php
include('hyst/php.php');

// SEO: Оптимизированные мета-теги для страницы 404
$SITE_TITLE = '404 - Страница не найдена | Моторленд';
$SITE_DESCRIPTION = 'Страница не найдена. Возможно, она была перемещена или удалена. Вернитесь на главную страницу или воспользуйтесь каталогом товаров.';
?>
<!doctype html>
<html lang="ru">
<head>
	<?php include("hyst/head.php"); ?>
	<!-- SEO: Canonical URL для страницы 404 -->
	<link rel="canonical" href="https://motor-land.kz/404"/>
	<!-- SEO: Meta robots для предотвращения индексации страницы 404 -->
	<meta name="robots" content="noindex, follow">
</head>
<body>
<?php include("hyst/sbody.php"); ?>
<?php include("des/head.php"); ?>
<!-- SEO: Семантический тег <main> -->
<main>
<br><br>
<!-- SEO: Семантический тег <nav> для хлебных крошек -->
<nav class="generalw" aria-label="Навигационная цепочка">
	<div class="shirina">
		<div class="crumbsblock" itemscope itemtype="https://schema.org/BreadcrumbList">
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<a href="/" itemprop="item"><span itemprop="name">Главная</span></a>
			<meta itemprop="position" content="1" />
		</span> / 
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<span itemprop="name">404 - Страница не найдена</span>
			<meta itemprop="position" content="2" />
		</span>
		</div>
	</div>
</nav>

<!-- SEO: Семантический тег <section> для контента 404 -->
<section class="generalw" aria-labelledby="error-title">
	<div class="shirina zgolovorleft">
		<h1 id="error-title">404 - Страница не найдена</h1>
	</div>
</section>

<div class="generalw">
	<div class="shirina">
		<div class="abouttext1">
			<p>Извините, такой страницы не существует. Возможно, она была перемещена или удалена.</p>
			<p>Вы можете:</p>
			<ul style="margin: 20px 0; padding-left: 30px;">
				<li><a href="/">Вернуться на главную страницу</a></li>
				<li><a href="/catalog">Перейти в каталог товаров</a></li>
				<li><a href="/service">Посмотреть услуги автосервиса</a></li>
				<li><a href="/contacts">Связаться с нами</a></li>
			</ul>
			<p>Если вы уверены, что страница должна существовать, пожалуйста, <a href="/contacts">свяжитесь с нами</a>.</p>
		</div>
	</div>
</div>

<br><br>
</main>
<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>
</body>
</html>