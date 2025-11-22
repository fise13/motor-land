<?php
include('hyst/php.php');
include_once('hyst/mods/customtexts/proces.php');

$SITE_TITLE = 'Автосервис - Замена Двигателей и КПП в Алматы | Моторленд | Доставка по СНГ';
$SITE_DESCRIPTION = 'Профессиональная замена и обслуживание контрактных двигателей и КПП в Алматы. Доставка контрактных двигателей по Казахстану и странам СНГ.';
$SITE_KEYWORDS = 'замена двигателя алматы, автосервис замена КПП, установка контрактного двигателя, доставка двигателей СНГ, контрактные двигатели Россия, контрактные двигатели Беларусь';
?>
<!doctype html>
<html lang="ru">
<head>
	<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-MCG7EP4276"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-MCG7EP4276');
</script>
<?php include("hyst/head.php"); ?>
<link rel="canonical" href="https://motor-land.kz/service"/>
<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
<meta property="og:type" content="website">
<meta property="og:url" content="https://motor-land.kz/service">
<meta property="og:title" content="<?=$SITE_TITLE;?>">
<meta property="og:description" content="<?=$SITE_DESCRIPTION;?>">
<meta property="og:image" content="https://motor-land.kz/img/logo.webp">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:site_name" content="Motor Land">
<meta property="og:locale" content="ru_RU">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
<meta name="twitter:image" content="https://motor-land.kz/img/logo.webp">
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
  "areaServed": [
    {"@type": "City", "name": "Алматы"},
    {"@type": "Country", "name": "Kazakhstan"},
    {"@type": "Country", "name": "Russia"},
    {"@type": "Country", "name": "Belarus"},
    {"@type": "Country", "name": "Ukraine"},
    {"@type": "Country", "name": "Armenia"},
    {"@type": "Country", "name": "Azerbaijan"},
    {"@type": "Country", "name": "Georgia"},
    {"@type": "Country", "name": "Kyrgyzstan"},
    {"@type": "Country", "name": "Moldova"},
    {"@type": "Country", "name": "Tajikistan"},
    {"@type": "Country", "name": "Turkmenistan"},
    {"@type": "Country", "name": "Uzbekistan"}
  ],
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
				<h1 id="service-title" class="sttitle"><span>Автосервис</span></h1>
			</div>
		</section>

		<section class="generalw">
			<div class="shirina">
				<div class="service-hero">
					<div class="service-hero-content">
						<div class="service-hero-text">
							<?php
							$service_hero_text = get_customtexts('service_page_hero_text');
							if ($service_hero_text) {
								echo $service_hero_text;
							} else {
								echo '<p>Наш автосервис предлагает профессиональную замену и обслуживание двигателей, а также замену КПП для автомобилей различных марок и моделей.</p>';
							}
							?>
						</div>
						<div class="service-hero-image" style="background-image: url(/cms_img/2025-02/1740464745_67bd626973430.png);"></div>
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