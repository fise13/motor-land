<?php
include('hyst/php.php');
include_once('hyst/mods/customtexts/proces.php');

$SITE_TITLE = 'Доставка и Оплата | Контрактные Двигатели и КПП | Моторленд | Доставка по СНГ';
$SITE_DESCRIPTION = 'Доставка контрактных двигателей и КПП по Казахстану и странам СНГ (Россия, Беларусь, Украина, Кыргызстан, Узбекистан и др.). Удобные способы оплаты.';
$SITE_KEYWORDS = 'доставка двигателей алматы, оплата контрактных моторов, доставка КПП по казахстану, доставка двигателей СНГ, контрактные двигатели Россия, контрактные двигатели Беларусь, доставка по СНГ';
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
	<link rel="canonical" href="https://motor-land.kz/pay"/>
	<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://motor-land.kz/pay">
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
	  "@type": "BreadcrumbList",
	  "itemListElement": [{
	    "@type": "ListItem",
	    "position": 1,
	    "name": "Главная",
	    "item": "https://motor-land.kz/"
	  }, {
	    "@type": "ListItem",
	    "position": 2,
	    "name": "Доставка и Оплата",
	    "item": "https://motor-land.kz/pay"
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
			<span itemprop="name">Доставка и Оплата</span>
			<meta itemprop="position" content="2" />
		</span>
		</div>
	</div>
</nav>

<section class="generalw" aria-labelledby="pay-title">
	<div class="shirina zgolovorleft">
		<h1 id="pay-title" class="sttitle"><span>Доставка и Оплата</span></h1>
	</div>
</section>

<section class="generalw">
	<div class="shirina">
		<div class="pay-delivery-hero">
			<div class="pay-delivery-hero-text">
				<?php
				$pay_hero_text = get_customtexts('pay_page_hero_text');
				if ($pay_hero_text) {
					echo $pay_hero_text;
				} else {
					echo '<p>Мы обеспечиваем доставку автозапчастей и двигателей по всей территории Казахстана и в страны СНГ через транспортные компании. Если доставка официальной транспортной компанией невозможна, мы поможем организовать перевозку частными перевозчиками.</p>';
				}
				?>
			</div>
			<div class="pay-delivery-hero-image" style="background-image: url(/cms_img/2025-02/1740628959_67bfe3df8a09d.png);"></div>
		</div>

		<div class="pay-delivery-methods">
			<h2 class="pay-section-title">Способы оплаты</h2>
			<div class="pay-methods-grid">
				<div class="pay-method-card">
					<span class="pay-method-icon">💵</span>
					<h3 class="pay-method-title">Наличный и безналичный расчет</h3>
					<p class="pay-method-text">Выберите удобный способ оплаты</p>
				</div>
				<div class="pay-method-card">
					<span class="pay-method-icon">💳</span>
					<h3 class="pay-method-title">Рассрочка и кредит</h3>
					<p class="pay-method-text">Доступны через банк</p>
				</div>
			</div>
		</div>

		<div class="delivery-options">
			<h2 class="pay-section-title">Условия доставки</h2>
			<div class="delivery-options-grid">
				<div class="delivery-option-card">
					<div class="delivery-option-icon">📋</div>
					<h3 class="delivery-option-title">Расчет стоимости</h3>
					<p class="delivery-option-text">Расчет стоимости и сроков доставки осуществляется самой транспортной компанией.</p>
				</div>
				<div class="delivery-option-card">
					<div class="delivery-option-icon">✓</div>
					<h3 class="delivery-option-title">Проверка при получении</h3>
					<p class="delivery-option-text">При получении обязательно проверяйте запчасть на наличие повреждений.</p>
				</div>
				<div class="delivery-option-card">
					<div class="delivery-option-icon">⚠️</div>
					<h3 class="delivery-option-title">Возврат</h3>
					<p class="delivery-option-text">При возврате запчастей транспортные расходы не компенсируются.</p>
				</div>
				<div class="delivery-option-card">
					<div class="delivery-option-icon">💰</div>
					<h3 class="delivery-option-title">Предоплата</h3>
					<p class="delivery-option-text">Отправка товара осуществляется только после 100% предоплаты.</p>
				</div>
			</div>
		</div>

		<div class="delivery-info">
			<h2 class="pay-section-title">Варианты доставки</h2>
			<div class="delivery-info-grid">
				<div class="info-card">
					<h3 class="info-card-title">🚚 Доставка по Казахстану</h3>
					<p class="info-card-text">Доставка через транспортные компании по всему Казахстану. Сроки: 3-7 рабочих дней.</p>
				</div>
				<div class="info-card">
					<h3 class="info-card-title">🌍 Доставка в страны СНГ</h3>
					<p class="info-card-text">Доставка контрактных двигателей и КПП в страны СНГ. Сроки: 7-14 рабочих дней.</p>
				</div>
				<div class="info-card">
					<h3 class="info-card-title">📍 Самовывоз</h3>
					<p class="info-card-text">Забрать товар самостоятельно из наших офисов в Алматы: РВ-90, 7-линия, 29 или ул. Свердлова, 38.</p>
				</div>
			</div>
		</div>

	</div>
</section>
</main>

<br><br>
<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

</body>
</html>