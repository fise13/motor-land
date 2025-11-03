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

<div class="service-page">
	<div class="service-container">
		<div class="service-header">
			<div class="breadcrumbs">
				<a href="/">Главная</a> / <span>Автосервис</span>
			</div>
			<h1 class="service-title">Автосервис</h1>
			<p class="service-subtitle">Профессиональная замена и обслуживание двигателей и КПП</p>
		</div>

		<div class="service-hero">
			<div class="service-hero-content">
				<div class="service-hero-text">
					<?=get_customtexts('delivery_page');?>
				</div>
				<?php 
				$service_image = get_simple_images('service_image');
				if (!empty($service_image[0])): 
				?>
				<div class="service-hero-image" style="background-image: url(<?=$service_image[0];?>);">
				</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="service-services">
			<h2 class="service-section-title">Наши услуги</h2>
			<div class="service-cards">
				<div class="service-card">
					<div class="service-card-icon">🔧</div>
					<h3 class="service-card-title">Замена двигателя</h3>
					<p class="service-card-text">Профессиональная замена контрактного двигателя с полной диагностикой и гарантией качества работ</p>
				</div>
				<div class="service-card">
					<div class="service-card-icon">⚙️</div>
					<h3 class="service-card-title">Замена КПП</h3>
					<p class="service-card-text">Установка автоматической и механической коробки передач с заменой масла и фильтров</p>
				</div>
				<div class="service-card">
					<div class="service-card-icon">🔍</div>
					<h3 class="service-card-title">Диагностика</h3>
					<p class="service-card-text">Комплексная диагностика двигателя и трансмиссии перед покупкой и после установки</p>
				</div>
				<div class="service-card">
					<div class="service-card-icon">🛠️</div>
					<h3 class="service-card-title">Техобслуживание</h3>
					<p class="service-card-text">Обслуживание установленного двигателя: замена масла, фильтров, ремней и других расходников</p>
				</div>
			</div>
		</div>

		<div class="service-advantages">
			<h2 class="service-section-title">Почему выбирают наш сервис</h2>
			<div class="advantages-grid">
				<div class="advantage-item">
					<div class="advantage-icon">✓</div>
					<div class="advantage-content">
						<h4 class="advantage-title">Опытные мастера</h4>
						<p class="advantage-text">Работаем с автомобилями всех марок и моделей более 10 лет</p>
					</div>
				</div>
				<div class="advantage-item">
					<div class="advantage-icon">✓</div>
					<div class="advantage-content">
						<h4 class="advantage-title">Гарантия на работы</h4>
						<p class="advantage-text">Предоставляем гарантию на все виды выполненных работ</p>
					</div>
				</div>
				<div class="advantage-item">
					<div class="advantage-icon">✓</div>
					<div class="advantage-content">
						<h4 class="advantage-title">Оригинальные запчасти</h4>
						<p class="advantage-text">Используем только качественные контрактные двигатели и КПП</p>
					</div>
				</div>
				<div class="advantage-item">
					<div class="advantage-icon">✓</div>
					<div class="advantage-content">
						<h4 class="advantage-title">Сертифицированный сервис</h4>
						<p class="advantage-text">Все работы выполняются в сертифицированном автосервисе</p>
					</div>
				</div>
				<div class="advantage-item">
					<div class="advantage-icon">✓</div>
					<div class="advantage-content">
						<h4 class="advantage-title">Быстрое выполнение</h4>
						<p class="advantage-text">Замена двигателя или КПП выполняется в кратчайшие сроки</p>
					</div>
				</div>
				<div class="advantage-item">
					<div class="advantage-icon">✓</div>
					<div class="advantage-content">
						<h4 class="advantage-title">Честные цены</h4>
						<p class="advantage-text">Прозрачное ценообразование без скрытых доплат</p>
					</div>
				</div>
			</div>
		</div>

		<div class="service-cta">
			<div class="service-cta-content">
				<h2 class="service-cta-title">Записаться на обслуживание</h2>
				<p class="service-cta-text">Оставьте заявку, и мы свяжемся с вами в ближайшее время</p>
				<a href="tel:<?=preg_replace('/[^\\d+]/','', get_simple_texts('index_slider_phone'));?>" class="service-cta-btn" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});">
					Позвонить сейчас
				</a>
			</div>
		</div>
	</div>
</div>

<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

</body>
</html>