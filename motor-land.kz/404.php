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
<section class="error-404-section">
	<div class="error-404-container">
		<div class="error-404-content">
			<!-- Анимированная иконка 404 -->
			<div class="error-404-icon">
				<div class="error-404-number">404</div>
				<svg class="error-404-svg" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
					<circle class="error-circle-1" cx="50" cy="50" r="8" fill="#fe0000" opacity="0.8"/>
					<circle class="error-circle-2" cx="150" cy="80" r="6" fill="#fe0000" opacity="0.6"/>
					<circle class="error-circle-3" cx="80" cy="150" r="10" fill="#fe0000" opacity="0.7"/>
					<path class="error-path" d="M30 100 Q100 50 170 100" stroke="#fe0000" stroke-width="2" fill="none" opacity="0.3"/>
				</svg>
</div>

			<h1 id="error-title" class="error-404-title">Страница не найдена</h1>
			
			<p class="error-404-description">
				Извините, такой страницы не существует. Возможно, она была перемещена или удалена.
			</p>
			
			<div class="error-404-actions">
				<a href="/" class="error-404-btn error-404-btn-primary">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M10 2L3 7V17H8V12H12V17H17V7L10 2Z" fill="currentColor"/>
					</svg>
					<span>Вернуться на главную</span>
				</a>
				<a href="/catalog" class="error-404-btn error-404-btn-secondary">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M2 4H4V18H2V4ZM6 4H8V18H6V4ZM10 4H12V18H10V4ZM14 4H16V18H14V4Z" fill="currentColor"/>
					</svg>
					<span>Каталог товаров</span>
				</a>
	</div>
			
			<div class="error-404-links">
				<p class="error-404-links-title">Полезные ссылки:</p>
				<ul class="error-404-links-list">
					<li><a href="/service">Автосервис</a></li>
					<li><a href="/pay">Доставка и оплата</a></li>
					<li><a href="/guarantees">Гарантии</a></li>
					<li><a href="/contacts">Контакты</a></li>
				</ul>
</div>

			<p class="error-404-help">
				Если вы уверены, что страница должна существовать, пожалуйста, 
				<a href="/contacts" class="error-404-help-link">свяжитесь с нами</a>.
			</p>
		</div>
	</div>
</section>
</main>
<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>
</body>
</html>