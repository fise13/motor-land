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
							<?=get_customtexts('service_page') ?: '<p>Наш автосервис предлагает профессиональную замену и обслуживание двигателей, а также замену КПП для автомобилей различных марок и моделей.</p>';?>
						</div>
						<div class="service-hero-image" style="background-image: url(/cms_img/2025-02/1740464745_67bd626973430.png);"></div>
					</div>
				</div>

				<div class="service-advantages">
					<h2 class="service-section-title">Почему выбирают нас?</h2>
					<div class="advantages-grid">
						<div class="advantage-item">
							<div class="advantage-icon">✓</div>
							<div class="advantage-content">
								<h3 class="advantage-title">Комплексная диагностика и подбор</h3>
								<p class="advantage-text">Точно определяем причину неисправности и подберем нужную запчасть</p>
							</div>
						</div>
						<div class="advantage-item">
							<div class="advantage-icon">✓</div>
							<div class="advantage-content">
								<h3 class="advantage-title">Квалифицированные мастера</h3>
								<p class="advantage-text">Специалисты с большим опытом работы</p>
							</div>
						</div>
						<div class="advantage-item">
							<div class="advantage-icon">✓</div>
							<div class="advantage-content">
								<h3 class="advantage-title">Современное оборудование</h3>
								<p class="advantage-text">Гарантия точности и надежности</p>
							</div>
						</div>
						<div class="advantage-item">
							<div class="advantage-icon">✓</div>
							<div class="advantage-content">
								<h3 class="advantage-title">Гарантия на работы и запчасти</h3>
								<p class="advantage-text">Уверенность в качестве</p>
							</div>
						</div>
						<div class="advantage-item">
							<div class="advantage-icon">✓</div>
							<div class="advantage-content">
								<h3 class="advantage-title">Скорость ремонта</h3>
								<p class="advantage-text">Собственный склад запчастей сокращает сроки обслуживания</p>
							</div>
						</div>
						<div class="advantage-item">
							<div class="advantage-icon">✓</div>
							<div class="advantage-content">
								<h3 class="advantage-title">Работа "под ключ"</h3>
								<p class="advantage-text">Широкий ассортимент расходных материалов и масел всегда в наличии</p>
							</div>
						</div>
					</div>
				</div>

				<div class="service-cta">
					<div class="service-cta-content">
						<h2 class="service-cta-title">Обратитесь к нам</h2>
						<p class="service-cta-text">Обратитесь к нам, и ваш автомобиль снова будет в отличном состоянии!</p>
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