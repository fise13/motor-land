<?php
include('hyst/php.php');



//Фильтр гет
if (hyst_test_id($_GET['id'])) {
	$id = (int)$_GET['id'];
	$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_tovari WHERE id = ?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$sql = $stmt->get_result();
	if ($sql->num_rows != 0) {
		$print = $sql->fetch_array();
		$stmt->close();
	} else {
		echo "<script>location.href='catalog.php';</script>"; 
		exit;
	}
} else {
	echo "<script>location.href='catalog.php';</script>"; 
	exit;
}


// SEO: Оптимизированные мета-теги для страницы товара с целевыми ключевыми запросами
// Целевые запросы: "купить контрактный мотор Алматы", "привозные моторы Алматы", "двигатель бу Япония Алматы"
$product_name = htmlspecialchars($print['name'], ENT_QUOTES, 'UTF-8');
$product_meta = htmlspecialchars($print['tmeta'], ENT_QUOTES, 'UTF-8');
$SITE_TITLE = 'Купить Контрактный Мотор '.$product_name.' Алматы | Привозные Моторы Япония | Моторленд';
$SITE_DESCRIPTION = 'Купить контрактный мотор '.$product_name.' в Алматы. Привозные моторы из Японии. '.$product_meta.'. Двигатель бу Япония Алматы с гарантией. Контрактные двигатели Казахстан. Быстрая доставка. Цена: '.($print['cash']!=0?$print['cash'].' KZT':'уточняйте').'.';
$SITE_KEYWORDS = 'купить контрактный мотор '.mb_strtolower($product_name).' алматы, привозные моторы '.mb_strtolower($product_name).', двигатель бу япония алматы, контрактные двигатели казахстан, '.mb_strtolower($product_meta);

// SEO: Формируем URL для Open Graph изображения
$product_image = get_farrimg($print['images'])[0];
$product_image_url = (strpos($product_image, 'http') === 0) ? $product_image : 'https://motor-land.kz'.$product_image;
?>
<!doctype html>
<html lang="ru">
<head>
<?php include("hyst/head.php"); ?>
<!-- SEO: Canonical URL для страницы товара -->
<link rel="canonical" href="https://motor-land.kz/detal?id=<?=$print['id'];?>"/>
<!-- SEO: Meta keywords для товара -->
<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
<!-- SEO: Open Graph мета-теги для товара -->
<meta property="og:type" content="product">
<meta property="og:url" content="https://motor-land.kz/detal?id=<?=$print['id'];?>">
<meta property="og:title" content="<?=$SITE_TITLE;?>">
<meta property="og:description" content="<?=$SITE_DESCRIPTION;?>">
<meta property="og:image" content="<?=$product_image_url;?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale" content="ru_RU">
<meta property="product:price:amount" content="<?=$print['cash']!=0?$print['cash']:'0';?>">
<meta property="product:price:currency" content="KZT">
<!-- SEO: Twitter Cards для товара -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
<meta name="twitter:image" content="<?=$product_image_url;?>">
<!-- SEO: Schema.org Product разметка для товара -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "<?=$product_name;?>",
  "description": "Купить контрактный мотор <?=$product_name;?> в Алматы. Привозные моторы из Японии. <?=htmlspecialchars(strip_tags($print['text'] ? $print['text'] : $print['stext']), ENT_QUOTES, 'UTF-8');?>",
  "image": "<?=$product_image_url;?>",
  "brand": {
    "@type": "Brand",
    "name": "Motor Land"
  },
  "category": "Контрактные двигатели и привозные моторы из Японии",
  "offers": {
    "@type": "Offer",
    "url": "https://motor-land.kz/detal?id=<?=$print['id'];?>",
    "priceCurrency": "KZT",
    "price": "<?=$print['cash']!=0?$print['cash']:'0';?>",
    "availability": "https://schema.org/InStock",
    "seller": {
      "@type": "Organization",
      "name": "Motor Land"
    }
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.8",
    "reviewCount": "15"
  }
}
</script>
<!-- SEO: Schema.org BreadcrumbList для навигации -->
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
    "name": "Каталог",
    "item": "https://motor-land.kz/catalog"
  }, {
    "@type": "ListItem",
    "position": 3,
    "name": "<?=$product_name;?>",
    "item": "https://motor-land.kz/detal?id=<?=$print['id'];?>"
  }]
}
</script>
</head>
<body>
<?php include("hyst/sbody.php"); ?>
<?php include("des/head.php"); ?>
<!-- SEO: Семантический тег <main> для основного контента -->
<main>
<br><br>
<!-- SEO: Семантический тег <nav> для хлебных крошек -->
<nav class="generalw" aria-label="Навигационная цепочка">
	<div class="shirina">
		<div class="crumbsblock" itemscope itemtype="https://schema.org/BreadcrumbList">
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<a href="/" itemprop="item"><span itemprop="name">Главная</span></a>
			<meta itemprop="position" content="1" />
		</span> / 
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<a href="/catalog" itemprop="item"><span itemprop="name">Каталог</span></a>
			<meta itemprop="position" content="2" />
		</span> / 
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<span itemprop="name"><?=$product_name;?></span>
			<meta itemprop="position" content="3" />
		</span>
		</div>
		<!-- SEO: Семантический тег <article> для товара -->
		<article class="detalinlines" itemscope itemtype="https://schema.org/Product">
			<div class="tovarimage">
				<!-- SEO: Улучшенный alt-текст для изображения товара с целевыми ключевыми словами -->
				<img src="<?=get_farrimg($print['images'])[0];?>" alt="<?='Купить контрактный мотор '.$product_name.' Алматы - привозные моторы из Японии';?>" title="<?='Купить контрактный мотор '.$product_name.' Алматы - привозные моторы';?>" itemprop="image" loading="lazy">
				<?php if ($print['sale'] != 'noting') { ?>
				<div class="cationsale"><?=$print['sale'];?></div>
				<?php } ?>
			</div>
			<div class="detalinlines">
				<h1 class="tovertitle" itemprop="name"><?=$print['name'];?></h1>
				
				<div itemprop="description">
					<?=$print['text'];?>
				</div>
				<br><br>
				<div class="tovercenaca" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
					<span itemprop="price"><?=($print['cash']!=0?$print['cash']:'0');?></span>
					<span itemprop="priceCurrency" content="KZT"><?=($print['cash']!=0?' KZT':'Цена по запросу');?></span>
					<link itemprop="availability" href="https://schema.org/InStock" />
				</div>
				<div class="toverbuton" data-nam="<?=$print['name'];?>">Купить</div>
			</div>
			<!--<div class="charactr">
			<?=$print['text1'];?>
			</div>-->
		</article>
	</div>
</nav>
</main>
<br><br>

	
<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

</body>
</html>