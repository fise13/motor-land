<?php
include('hyst/php.php');
include_once('hyst/mods/customtexts/proces.php');

$SITE_TITLE = 'Доставка и Оплата | Контрактные Двигатели и КПП | Моторленд';
$SITE_DESCRIPTION = 'Доставка контрактных двигателей и КПП по Казахстану и СНГ.';
$SITE_KEYWORDS = 'доставка двигателей алматы, оплата контрактных моторов, доставка КПП по казахстану';
?>
<!doctype html>
<html lang="ru">
<head>
	<?php include("hyst/head.php"); ?>
	<link rel="canonical" href="https://motor-land.kz/pay"/>
	<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://motor-land.kz/pay">
	<meta property="og:title" content="<?=$SITE_TITLE;?>">
	<meta property="og:description" content="<?=$SITE_DESCRIPTION;?>">
	<meta property="og:image" content="https://motor-land.kz/img/logo.webp">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
	<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
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
		<h1 id="pay-title" class="sttitle"><span>Доставка и Оплата Контрактных Двигателей</span></h1>
	</div>
</section>

<section class="generalw">
	<div class="shirina">
		<div class="pay-delivery-hero">
			<div class="pay-delivery-hero-text">
				<p>Компания Motor Land предлагает различные способы оплаты и доставки для вашего удобства. Мы доставляем контрактные двигатели и коробки передач по всему Казахстану и в страны СНГ, обеспечивая безопасную транспортировку и сохранность груза.</p>
			</div>
			<div class="pay-delivery-hero-image" style="background-image: url(/cms_img/2025-02/1740628959_67bfe3df8a09d.png);"></div>
		</div>

		<div class="pay-delivery-methods">
			<h2 class="pay-section-title">Способы оплаты</h2>
			<div class="pay-methods-grid">
				<div class="pay-method-card">
					<span class="pay-method-icon">💵</span>
					<h3 class="pay-method-title">Наличный расчет</h3>
					<p class="pay-method-text">Оплата наличными при получении товара в пункте выдачи или при доставке курьером</p>
				</div>
				<div class="pay-method-card">
					<span class="pay-method-icon">🏦</span>
					<h3 class="pay-method-title">Банковский перевод</h3>
					<p class="pay-method-text">Перевод на расчетный счет компании. Подходит для юридических лиц и крупных заказов</p>
				</div>
				<div class="pay-method-card">
					<span class="pay-method-icon">💳</span>
					<h3 class="pay-method-title">Онлайн оплата картой</h3>
					<p class="pay-method-text">Безопасная оплата банковской картой через платежные системы</p>
				</div>
				<div class="pay-method-card">
					<span class="pay-method-icon">📱</span>
					<h3 class="pay-method-title">Kaspi.kz / Kaspi Gold</h3>
					<p class="pay-method-text">Оплата через Kaspi.kz или рассрочка через Kaspi Gold до 24 месяцев</p>
				</div>
			</div>
		</div>

		<div class="delivery-options">
			<h2 class="pay-section-title">Варианты доставки</h2>
			<div class="delivery-options-grid">
				<div class="delivery-option-card">
					<div class="delivery-option-icon">🚚</div>
					<h3 class="delivery-option-title">Доставка по Казахстану</h3>
					<p class="delivery-option-text">Доставка через транспортные компании по всему Казахстану</p>
					<ul class="delivery-option-list">
						<li>Доставка до терминала ТК</li>
						<li>Доставка до двери</li>
						<li>Отслеживание груза</li>
						<li>Сроки: 3-7 рабочих дней</li>
					</ul>
				</div>
				<div class="delivery-option-card">
					<div class="delivery-option-icon">🌍</div>
					<h3 class="delivery-option-title">Доставка в страны СНГ</h3>
					<p class="delivery-option-text">Доставка контрактных двигателей и КПП в страны СНГ</p>
					<ul class="delivery-option-list">
						<li>Россия, Беларусь, Узбекистан</li>
						<li>Кыргызстан, Таджикистан</li>
						<li>Таможенное оформление</li>
						<li>Сроки: 7-14 рабочих дней</li>
					</ul>
				</div>
				<div class="delivery-option-card">
					<div class="delivery-option-icon">📍</div>
					<h3 class="delivery-option-title">Самовывоз</h3>
					<p class="delivery-option-text">Забрать товар самостоятельно из наших офисов в Алматы</p>
					<ul class="delivery-option-list">
						<li>РВ-90, 7-линия, 29</li>
						<li>ул. Свердлова, 38</li>
						<li>Пн-Сб: 9:00 - 18:00</li>
						<li>Вс: выходной</li>
					</ul>
				</div>
				<div class="delivery-option-card">
					<div class="delivery-option-icon">🚗</div>
					<h3 class="delivery-option-title">Курьерская доставка</h3>
					<p class="delivery-option-text">Курьерская доставка по Алматы</p>
					<ul class="delivery-option-list">
						<li>Доставка в день заказа (при заказе до 14:00)</li>
						<li>Доставка на следующий день</li>
						<li>Стоимость от 2000 тенге</li>
						<li>Связь с курьером заранее</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="delivery-info">
			<h2 class="pay-section-title">Условия доставки</h2>
			<div class="delivery-info-grid">
				<div class="info-card">
					<h3 class="info-card-title">Упаковка</h3>
					<p class="info-card-text">Все товары тщательно упаковываются для безопасной транспортировки. Двигатели и КПП упаковываются в защитные пленки и картонные коробки.</p>
				</div>
				<div class="info-card">
					<h3 class="info-card-title">Страхование</h3>
					<p class="info-card-text">Рекомендуем застраховать груз при отправке через транспортные компании. Страхование защитит вас от возможных повреждений в пути.</p>
				</div>
				<div class="info-card">
					<h3 class="info-card-title">Проверка при получении</h3>
					<p class="info-card-text">При получении товара необходимо проверить целостность упаковки, соответствие заказу и наличие всех комплектующих.</p>
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