<?php
include('hyst/php.php');
include_once('hyst/mods/page_content/proces.php');

$pay_content = get_page_content('pay_page');
$SITE_TITLE = $pay_content && !empty($pay_content['meta_title']) ? htmlspecialchars($pay_content['meta_title'], ENT_QUOTES, 'UTF-8') : 'Доставка и Оплата | Контрактные Двигатели и КПП | Моторленд';
$SITE_DESCRIPTION = $pay_content && !empty($pay_content['meta_description']) ? htmlspecialchars($pay_content['meta_description'], ENT_QUOTES, 'UTF-8') : 'Доставка контрактных двигателей и КПП по Казахстану и СНГ.';
$SITE_KEYWORDS = $pay_content && !empty($pay_content['meta_keywords']) ? htmlspecialchars($pay_content['meta_keywords'], ENT_QUOTES, 'UTF-8') : 'доставка двигателей алматы, оплата контрактных моторов, доставка КПП по казахстану';
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
		<h1 id="pay-title" class="sttitle"><span><?=$pay_content && !empty($pay_content['h1_text']) ? htmlspecialchars($pay_content['h1_text'], ENT_QUOTES, 'UTF-8') : 'Доставка и Оплата Контрактных Двигателей';?></span></h1>
	</div>
</section>

<div class="pay-delivery-page">
	<div class="pay-delivery-container">
		<?php if ($pay_content && !empty($pay_content['content'])): ?>
		<div class="pay-delivery-hero">
			<?php 
			$delivery_image = get_simple_images('delivery_pay_image');
			if (!empty($delivery_image[0])): 
			?>
			<div class="pay-delivery-hero-image" style="background-image: url(<?=$delivery_image[0];?>);">
			</div>
			<?php endif; ?>
			<div class="pay-delivery-hero-text">
				<?=$pay_content['content'];?>
			</div>
		</div>
		<?php else: ?>
		<div class="pay-delivery-hero">
			<?php 
			$delivery_image = get_simple_images('delivery_pay_image');
			if (!empty($delivery_image[0])): 
			?>
			<div class="pay-delivery-hero-image" style="background-image: url(<?=$delivery_image[0];?>);">
			</div>
			<?php endif; ?>
			<div class="pay-delivery-hero-text">
				<?=get_customtexts('payment_page');?>
			</div>
		</div>
		<?php endif; ?>

		<div class="pay-delivery-methods">
			<h2 class="pay-section-title">Способы оплаты</h2>
			<div class="pay-methods-grid">
				<div class="pay-method-card">
					<div class="pay-method-icon">💳</div>
					<h3 class="pay-method-title">Наличный расчет</h3>
					<p class="pay-method-text">Оплата наличными при получении товара в пункте выдачи или при доставке курьером</p>
				</div>
				<div class="pay-method-card">
					<div class="pay-method-icon">🏦</div>
					<h3 class="pay-method-title">Банковский перевод</h3>
					<p class="pay-method-text">Перевод на расчетный счет компании. Реквизиты предоставляются после оформления заказа</p>
				</div>
				<div class="pay-method-card">
					<div class="pay-method-icon">📱</div>
					<h3 class="pay-method-title">Картой онлайн</h3>
					<p class="pay-method-text">Безопасная оплата банковской картой через платежные системы</p>
				</div>
				<div class="pay-method-card">
					<div class="pay-method-icon">💰</div>
					<h3 class="pay-method-title">Kaspi.kz / Kaspi Gold</h3>
					<p class="pay-method-text">Оплата через Kaspi.kz или рассрочка через Kaspi Gold</p>
				</div>
			</div>
		</div>

		<div class="delivery-options">
			<h2 class="pay-section-title">Варианты доставки</h2>
			<div class="delivery-options-grid">
				<div class="delivery-option-card">
					<div class="delivery-option-icon">🚚</div>
					<h3 class="delivery-option-title">Транспортные компании</h3>
					<p class="delivery-option-text">Доставка по всей территории Казахстана и в страны СНГ через транспортные компании</p>
					<ul class="delivery-option-list">
						<li>Доставка до терминала ТК</li>
						<li>Доставка до двери</li>
						<li>Отслеживание груза</li>
					</ul>
				</div>
				<div class="delivery-option-card">
					<div class="delivery-option-icon">📍</div>
					<h3 class="delivery-option-title">Самовывоз</h3>
					<p class="delivery-option-text">Заберите товар самостоятельно из наших офисов в Алматы</p>
					<ul class="delivery-option-list">
						<li>Феллиал №1: <a href="https://2gis.kz/almaty/geo/70000001083496996" target="_blank" class="delivery-link">РВ-90, 7-линия, 29</a></li>
						<li>Феллиал №2: <a href="https://2gis.kz/almaty/geo/70000001024156353" target="_blank" class="delivery-link">ул. Свердлова, 38</a></li>
						<li>Предварительная договоренность</li>
					</ul>
				</div>
				<div class="delivery-option-card">
					<div class="delivery-option-icon">🚗</div>
					<h3 class="delivery-option-title">Курьерская доставка</h3>
					<p class="delivery-option-text">Доставка по городу Алматы курьерской службой</p>
					<ul class="delivery-option-list">
						<li>Доставка в день заказа</li>
						<li>Доставка на следующий день</li>
						<li>Стоимость от 2000 тенге</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="delivery-info">
			<h2 class="pay-section-title">Условия доставки</h2>
			<div class="delivery-info-grid">
				<div class="info-card">
					<h4 class="info-card-title">Сроки доставки</h4>
					<p class="info-card-text">Доставка в Алматы: 1-2 рабочих дня<br>
					По Казахстану: 3-7 рабочих дней<br>
					В страны СНГ: 7-14 рабочих дней</p>
				</div>
				<div class="info-card">
					<h4 class="info-card-title">Стоимость доставки</h4>
					<p class="info-card-text">Расчет стоимости доставки производится индивидуально в зависимости от веса, габаритов и региона доставки. Точную стоимость уточняйте у менеджера.</p>
				</div>
				<div class="info-card">
					<h4 class="info-card-title">Упаковка</h4>
					<p class="info-card-text">Все товары тщательно упаковываются для безопасной транспортировки. Двигатели и КПП упаковываются в защитные пленки.</p>
				</div>
				<div class="info-card">
					<h4 class="info-card-title">Страхование</h4>
					<p class="info-card-text">Рекомендуем застраховать груз при отправке через транспортные компании для защиты от повреждений в пути.</p>
				</div>
			</div>
		</div>
	</div>
</div>
</main>

<br><br>
<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

</body>
</html>