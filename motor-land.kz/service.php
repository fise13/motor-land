<?php
include('hyst/php.php');

// SEO: Оптимизированные мета-теги для страницы автосервиса
$SITE_TITLE = 'Автосервис - Замена Двигателей и КПП в Алматы | Моторленд';
$SITE_DESCRIPTION = 'Профессиональная замена и обслуживание контрактных двигателей и КПП в Алматы. Опытные мастера, гарантия на работы. Все марки автомобилей.';
$SITE_KEYWORDS = 'замена двигателя алматы, автосервис замена КПП, установка контрактного двигателя, автосервис алматы, замена моторов';
?>
<!doctype html>
<html lang="ru">
<head>
<?php include("hyst/head.php"); ?>
<!-- SEO: Canonical URL -->
<link rel="canonical" href="https://motor-land.kz/service"/>
<!-- SEO: Meta keywords -->
<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
<!-- SEO: Open Graph -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://motor-land.kz/service">
<meta property="og:title" content="<?=$SITE_TITLE;?>">
<meta property="og:description" content="<?=$SITE_DESCRIPTION;?>">
<meta property="og:image" content="https://motor-land.kz/img/logo.jpg">
<!-- SEO: Twitter Cards -->
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
<!-- SEO: Schema.org Service для страницы автосервиса -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "serviceType": "Автосервис - замена двигателей и КПП",
  "provider": {
    "@type": "LocalBusiness",
    "name": "Motor Land",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Алматы",
      "addressCountry": "KZ"
    }
  },
  "areaServed": {
    "@type": "City",
    "name": "Алматы"
  },
  "description": "<?=$SITE_DESCRIPTION;?>"
}
</script>
<!-- SEO: BreadcrumbList -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [{
    "@type": "ListItem",
    "position": 1,
    "name": "Главная",
    "item": "https://motor-land.kz/"
  }, {
    "@type": "ListItem",
    "position": 2,
    "name": "Автосервис",
    "item": "https://motor-land.kz/service"
  }]
}
</script>
</head>
<body>
<?php include("hyst/sbody.php"); ?>
<?php include("des/head.php"); ?>
<!-- SEO: Семантический тег <main> -->
<main>
<div class="service-page">
	<div class="service-container">
		<!-- SEO: Семантический тег <nav> для хлебных крошек -->
		<nav class="generalw" aria-label="Навигационная цепочка">
			<div class="shirina">
				<div class="crumbsblock" itemscope itemtype="https://schema.org/BreadcrumbList">
				<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a href="/" itemprop="item"><span itemprop="name">Главная</span></a>
					<meta itemprop="position" content="1" />
				</span> / 
				<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<span itemprop="name">Автосервис</span>
					<meta itemprop="position" content="2" />
				</span>
				</div>
			</div>
		</nav>

		<!-- SEO: Семантический тег <section> для заголовка -->
		<section class="generalw" aria-labelledby="service-title">
			<div class="shirina zgolovorleft">
				<h1 id="service-title" class="sttitle"><span>Автосервис</span></h1>
			</div>
		</section>

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
</main>

<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

</body>
</html>