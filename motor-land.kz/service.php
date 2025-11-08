<?php
include('hyst/php.php');
include_once('hyst/mods/customtexts/proces.php');

$SITE_TITLE = 'Автосервис - Замена Двигателей и КПП в Алматы | Моторленд';
$SITE_DESCRIPTION = 'Профессиональная замена и обслуживание контрактных двигателей и КПП в Алматы.';
$SITE_KEYWORDS = 'замена двигателя алматы, автосервис замена КПП, установка контрактного двигателя';
?>
<!doctype html>
<html lang="ru">
<head>
<?php include("hyst/head.php"); ?>
<link rel="canonical" href="https://motor-land.kz/service"/>
<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
<meta property="og:type" content="website">
<meta property="og:url" content="https://motor-land.kz/service">
<meta property="og:title" content="<?=$SITE_TITLE;?>">
<meta property="og:description" content="<?=$SITE_DESCRIPTION;?>">
<meta property="og:image" content="https://motor-land.kz/img/logo.webp">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
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
<main>
<div class="service-page">
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

		<section class="generalw" aria-labelledby="service-title">
			<div class="shirina zgolovorleft">
				<h1 id="service-title" class="sttitle"><span>Замена Контрактного Двигателя в Алматы</span></h1>
			</div>
		</section>

		<section class="generalw">
			<div class="shirina">
				<div class="service-hero">
					<div class="service-hero-content">
						<div class="service-hero-text">
							<?=get_customtexts('service_page') ?: '<p>Компания Motor Land предлагает полный спектр услуг по замене и обслуживанию контрактных двигателей и коробок передач. Наш автосервис оснащен современным оборудованием, а наши мастера имеют многолетний опыт работы с автомобилями всех марок и моделей.</p>';?>
						</div>
						<div class="service-hero-image" style="background-image: url(/img/slide.webp);"></div>
					</div>
				</div>

				<div class="service-services">
					<h2 class="service-section-title">Наши услуги</h2>
					<div class="service-cards">
						<div class="service-card">
							<span class="service-card-icon">🔧</span>
							<h3 class="service-card-title">Замена двигателя</h3>
							<p class="service-card-text">Профессиональная замена контрактного двигателя с полной диагностикой и гарантией на работы.</p>
						</div>
						<div class="service-card">
							<span class="service-card-icon">⚙️</span>
							<h3 class="service-card-title">Замена КПП</h3>
							<p class="service-card-text">Установка контрактных коробок передач (АКПП и МКПП) с заменой масла и фильтров.</p>
						</div>
						<div class="service-card">
							<span class="service-card-icon">🔍</span>
							<h3 class="service-card-title">Диагностика</h3>
							<p class="service-card-text">Компьютерная диагностика двигателя и всех систем автомобиля.</p>
						</div>
						<div class="service-card">
							<span class="service-card-icon">🛠️</span>
							<h3 class="service-card-title">Техническое обслуживание</h3>
							<p class="service-card-text">Регулярное ТО для обеспечения долгой и надежной работы агрегата.</p>
						</div>
					</div>
				</div>

				<div class="service-advantages">
					<h2 class="service-section-title">Почему выбирают нас</h2>
					<div class="advantages-grid">
						<div class="advantage-item">
							<div class="advantage-icon">✓</div>
							<div class="advantage-content">
								<h3 class="advantage-title">Опытные мастера</h3>
								<p class="advantage-text">Многолетний опыт работы с автомобилями всех марок</p>
							</div>
						</div>
						<div class="advantage-item">
							<div class="advantage-icon">✓</div>
							<div class="advantage-content">
								<h3 class="advantage-title">Современное оборудование</h3>
								<p class="advantage-text">Профессиональное оборудование для диагностики и ремонта</p>
							</div>
						</div>
						<div class="advantage-item">
							<div class="advantage-icon">✓</div>
							<div class="advantage-content">
								<h3 class="advantage-title">Гарантия на работы</h3>
								<p class="advantage-text">Предоставляем гарантию на все виды выполненных работ</p>
							</div>
						</div>
						<div class="advantage-item">
							<div class="advantage-icon">✓</div>
							<div class="advantage-content">
								<h3 class="advantage-title">Качественные запчасти</h3>
								<p class="advantage-text">Используем только проверенные контрактные агрегаты</p>
							</div>
						</div>
						<div class="advantage-item">
							<div class="advantage-icon">✓</div>
							<div class="advantage-content">
								<h3 class="advantage-title">Быстрое выполнение</h3>
								<p class="advantage-text">Выполняем работы в кратчайшие сроки без потери качества</p>
							</div>
						</div>
						<div class="advantage-item">
							<div class="advantage-icon">✓</div>
							<div class="advantage-content">
								<h3 class="advantage-title">Прозрачные цены</h3>
								<p class="advantage-text">Честное ценообразование без скрытых доплат</p>
							</div>
						</div>
					</div>
				</div>

				<div class="service-cta">
					<div class="service-cta-content">
						<h2 class="service-cta-title">Записаться на обслуживание</h2>
						<p class="service-cta-text">Свяжитесь с нами для записи на обслуживание или консультации</p>
						<a href="/contacts.php" class="service-cta-btn">Связаться с нами</a>
					</div>
				</div>
			</div>
		</section>
</div>
</main>

<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

</body>
</html>