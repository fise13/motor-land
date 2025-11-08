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

<div class="guarantees-page">
	<div class="guarantees-container">
		<div class="guarantees-content-wrapper">
			<?php if ($pay_content && !empty($pay_content['content'])): ?>
			<div class="guarantees-main-content">
				<?=$pay_content['content'];?>
			</div>
			<?php else: ?>
			<div class="guarantees-main-content">
				<div class="guarantee-hero">
					<h2>Удобная доставка и оплата контрактных двигателей и КПП</h2>
					<p>Компания Motor Land предлагает различные способы оплаты и доставки для вашего удобства. Мы доставляем контрактные двигатели и коробки передач по всему Казахстану и в страны СНГ, обеспечивая безопасную транспортировку и сохранность груза.</p>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
</main>

<br><br>
<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

</body>
</html>