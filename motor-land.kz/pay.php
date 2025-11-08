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
				<p>Мы обеспечиваем доставку автозапчастей и двигателей по всей территории Казахстана и в страны СНГ через транспортные компании.</p>
				<p>Если доставка официальной транспортной компанией невозможна, мы поможем организовать перевозку частными перевозчиками. Наши менеджеры подберут наиболее удобный вариант доставки и помогут с оформлением необходимых документов.</p>
				<p><strong>Условия доставки:</strong></p>
				<ul>
					<li>Расчет стоимости и сроков доставки осуществляется самой транспортной компанией.</li>
					<li>При получении обязательно проверяйте запчасть на наличие повреждений.</li>
					<li>При возврате запчастей транспортные расходы не компенсируются.</li>
					<li>Отправка товара осуществляется только после 100% предоплаты.</li>
				</ul>
				<p><strong>Способы оплаты:</strong></p>
				<ul>
					<li>Наличный и безналичный расчет – выберите удобный способ оплаты.</li>
					<li>Рассрочка и кредит – доступны через банк.</li>
				</ul>
				<p>Свяжитесь с нами для уточнения деталей и подбора оптимального варианта.</p>
			</div>
			<div class="pay-delivery-hero-image" style="background-image: url(/cms_img/2025-02/1740628959_67bfe3df8a09d.png);"></div>
		</div>

	</div>
</section>
</main>

<br><br>
<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

</body>
</html>