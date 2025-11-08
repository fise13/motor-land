<?php
include('hyst/php.php');

$SITE_TITLE = 'Контакты | Моторленд - Контрактные Двигатели и КПП в Алматы';
$SITE_DESCRIPTION = 'Контакты компании Motor Land в Алматы. Адреса офисов, телефоны, режим работы.';
$SITE_KEYWORDS = 'контакты моторленд, адрес автосервиса алматы, телефон контрактных двигателей';
?>
<!doctype html>
<html lang="ru">
<head>
<?php include("hyst/head.php"); ?>
<link rel="canonical" href="https://motor-land.kz/contacts"/>
<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
<meta property="og:type" content="website">
<meta property="og:url" content="https://motor-land.kz/contacts">
<meta property="og:title" content="<?=$SITE_TITLE;?>">
<meta property="og:description" content="<?=$SITE_DESCRIPTION;?>">
<meta property="og:image" content="https://motor-land.kz/img/logo.webp">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "Motor Land",
  "alternateName": "Моторленд",
  "image": "https://motor-land.kz/img/logo.webp",
  "description": "<?=$SITE_DESCRIPTION;?>",
  "address": [{
    "@type": "PostalAddress",
    "streetAddress": "РВ-90, 7-линия, 29",
    "addressLocality": "Алматы",
    "addressRegion": "Алматы",
    "addressCountry": "KZ"
  }, {
    "@type": "PostalAddress",
    "streetAddress": "улица Свердлова, 38",
    "addressLocality": "Алматы",
    "addressRegion": "Алматы",
    "addressCountry": "KZ"
  }],
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": "43.238949",
    "longitude": "76.889709"
  },
  "telephone": ["+7-777-144-5445", "+7-701-144-5445", "+7-707-144-5445"],
  "openingHoursSpecification": [{
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
    "opens": "09:00",
    "closes": "18:00"
  }, {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": "Saturday",
    "opens": "10:00",
    "closes": "15:00"
  }],
  "priceRange": "$$",
  "areaServed": {
    "@type": "Country",
    "name": "Kazakhstan"
  }
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
    "name": "Контакты",
    "item": "https://motor-land.kz/contacts"
  }]
}
</script>
</head>
<body>
<?php include("hyst/sbody.php"); ?>
<?php include("des/head.php"); ?>
<main>
<br><br>
<nav class="generalw" aria-label="Навигационная цепочка">
	<div class="shirina">
		<div class="crumbsblock" itemscope itemtype="https://schema.org/BreadcrumbList">
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<a href="/" itemprop="item"><span itemprop="name">Главная</span></a>
			<meta itemprop="position" content="1" />
		</span> / 
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<span itemprop="name">Контакты</span>
			<meta itemprop="position" content="2" />
		</span>
		</div>
		
	</div>
</nav>	

<section class="generalw" aria-labelledby="contacts-title">
	<div class="shirina zgolovorleft">
		<h1 id="contacts-title" class="sttitle"><span>Контакты</span></h1>
	</div>
</section>

<section class="generalw contacts-main" aria-label="Контактная информация">
	<div class="shirina">
		<div class="footer_contacts contacts-page">
			<div class="footer_contact_block contact-card">
				<div class="contact-card-header">
					<h3 class="contact-office-title">Офис №1</h3>
				</div>
				<div class="contact-card-content">
					<div class="contact-item contact-icon-location">
						<span class="contact-label">Адрес:</span>
						<a target="_blank" href="https://2gis.kz/almaty/geo/70000001083496996" class="contact-link">РВ-90, 7-линия, 29</a>
					</div>
					<div class="contact-item contact-icon-phone">
						<span class="contact-label">Телефон:</span>
						<a href="tel:+77771445445" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});" class="contact-link">+7 777 144 5445</a>
					</div>
					<div class="contact-item contact-icon-whatsapp">
						<span class="contact-label">WhatsApp:</span>
						<a href="https://wa.me/77771445445" class="contact-link">WhatsApp</a>
					</div>
					<div class="contact-item contact-icon-schedule">
						<span class="contact-label">Режим работы:</span>
						<div class="contact-schedule">
							пн-пт | 9:00-18:00<br>
							суббота | 10:00-15:00<br>
							воскресенье | выходной
						</div>
					</div>	
				</div>
			</div>
			<div class="footer_contact_block contact-card">
				<div class="contact-card-header">
					<h3 class="contact-office-title">Офис №2</h3>
				</div>
				<div class="contact-card-content">
					<div class="contact-item contact-icon-location">
						<span class="contact-label">Адрес:</span>
						<a target="_blank" href="https://2gis.kz/almaty/geo/70000001024156353" class="contact-link">улица Свердлова, 38</a>
					</div>
					<div class="contact-item contact-icon-phone">
						<span class="contact-label">Телефоны:</span>
						<div class="contact-phones">
							<a href="tel:+77011445445" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});" class="contact-link">+7 701 144 5445</a><br>
							<a href="tel:+77071445445" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});" class="contact-link">+7 707 144 5445</a>
						</div>
					</div>
					<div class="contact-item contact-icon-whatsapp">
						<span class="contact-label">WhatsApp:</span>
						<a href="https://wa.me/77011445445" class="contact-link">WhatsApp</a>
					</div>
					<div class="contact-item contact-icon-schedule">
						<span class="contact-label">Режим работы:</span>
						<div class="contact-schedule">
							пн-пт | 9:00-18:00<br>
							суббота | 10:00-15:00<br>
							воскресенье | выходной
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="map contacts-map">
			<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A7f3534207526eaa3fc4288c55720ef5bf87c1fae35fecbd8953f8b3dab48de0e&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
		</div>
	</div>
</section>
</main>

<br><br>
<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

</body>
</html>
