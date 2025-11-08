<?php
include('hyst/php.php');
include_once('hyst/mods/page_content/proces.php');

$service_content = get_page_content('service_page');
$SITE_TITLE = $service_content && !empty($service_content['meta_title']) ? htmlspecialchars($service_content['meta_title'], ENT_QUOTES, 'UTF-8') : 'Автосервис - Замена Двигателей и КПП в Алматы | Моторленд';
$SITE_DESCRIPTION = $service_content && !empty($service_content['meta_description']) ? htmlspecialchars($service_content['meta_description'], ENT_QUOTES, 'UTF-8') : 'Профессиональная замена и обслуживание контрактных двигателей и КПП в Алматы.';
$SITE_KEYWORDS = $service_content && !empty($service_content['meta_keywords']) ? htmlspecialchars($service_content['meta_keywords'], ENT_QUOTES, 'UTF-8') : 'замена двигателя алматы, автосервис замена КПП, установка контрактного двигателя';
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
<div class="guarantees-page">
	<div class="guarantees-container">
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
				<h1 id="service-title" class="sttitle"><span><?=$service_content && !empty($service_content['h1_text']) ? htmlspecialchars($service_content['h1_text'], ENT_QUOTES, 'UTF-8') : 'Замена Контрактного Двигателя в Алматы';?></span></h1>
			</div>
		</section>

		<div class="guarantees-content-wrapper">
			<?php if ($service_content && !empty($service_content['content'])): ?>
			<div class="guarantees-main-content">
				<?=$service_content['content'];?>
			</div>
			<?php else: ?>
			<div class="guarantees-main-content">
				<div class="guarantee-hero">
					<h2>Профессиональный автосервис по замене контрактных двигателей и КПП</h2>
					<p>Компания Motor Land предлагает полный спектр услуг по замене и обслуживанию контрактных двигателей и коробок передач. Наш автосервис оснащен современным оборудованием, а наши мастера имеют многолетний опыт работы с автомобилями всех марок и моделей.</p>
				</div>
			</div>
			<?php endif; ?>
		</div>

	</div>
</div>
</main>

<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

</body>
</html>