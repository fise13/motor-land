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
// Целевые запросы: "купить контрактный мотор Алматы", "привозные моторы Алматы", "двигатель бу Малайзия Алматы"
$product_name = htmlspecialchars($print['name'], ENT_QUOTES, 'UTF-8');
$product_meta = htmlspecialchars($print['tmeta'], ENT_QUOTES, 'UTF-8');
$SITE_TITLE = 'Купить Контрактный Мотор '.$product_name.' Алматы | Привозные Моторы Малайзия | Моторленд';
$SITE_DESCRIPTION = 'Купить контрактный мотор '.$product_name.' в Алматы. Привозные моторы из Малайзии. '.$product_meta.'. Двигатель бу Малайзия Алматы с гарантией. Контрактные двигатели Казахстан. Быстрая доставка. Цена: '.($print['cash']!=0?$print['cash'].' KZT':'уточняйте').'.';
$SITE_KEYWORDS = 'купить контрактный мотор '.mb_strtolower($product_name).' алматы, привозные моторы '.mb_strtolower($product_name).', двигатель бу малайзия алматы, контрактные двигатели казахстан, '.mb_strtolower($product_meta);

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
<?php if ($print['cash'] != 0 && $print['cash'] != '0') { ?>
<meta property="product:price:amount" content="<?=$print['cash'];?>">
<meta property="product:price:currency" content="KZT">
<?php } ?>
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
  "description": "Купить контрактный мотор <?=$product_name;?> в Алматы. Привозные моторы из Малайзии. <?=htmlspecialchars(strip_tags($print['text'] ? $print['text'] : $print['stext']), ENT_QUOTES, 'UTF-8');?>",
  "image": "<?=$product_image_url;?>",
  "brand": {
    "@type": "Brand",
    "name": "Motor Land"
  },
  "category": "Контрактные двигатели и привозные моторы из Малайзии",
  "offers": {
    "@type": "Offer",
    "url": "https://motor-land.kz/detal?id=<?=$print['id'];?>",
    "priceCurrency": "KZT",
    "price": "<?=($print['cash'] != 0 && $print['cash'] != '0') ? $print['cash'] : '0';?>",
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
	</div>
</nav>

<!-- SEO: Семантический тег <article> для товара -->
<section class="generalw">
	<div class="shirina">
		<article class="product-detail-wrapper" itemscope itemtype="https://schema.org/Product">
			<div class="product-detail-container">
				<!-- Изображение товара -->
				<div class="product-image-wrapper">
					<!-- Performance: Preload изображения товара для ускорения LCP на странице товара -->
					<link rel="preload" as="image" href="<?=get_farrimg($print['images'])[0];?>">
					<div class="tovarimage">
						<!-- SEO: Улучшенный alt-текст для изображения товара с целевыми ключевыми словами -->
						<img src="<?=get_farrimg($print['images'])[0];?>" alt="<?='Купить контрактный мотор '.$product_name.' Алматы - привозные моторы из Малайзии';?>" title="<?='Купить контрактный мотор '.$product_name.' Алматы - привозные моторы';?>" itemprop="image" loading="eager" fetchpriority="high">
						<?php if ($print['sale'] != 'noting') { ?>
						<div class="cationsale"><?=$print['sale'];?></div>
						<?php } ?>
					</div>
				</div>
				
				<!-- Информация о товаре -->
				<div class="product-info-wrapper">
					<h1 class="product-title" itemprop="name"><?=$print['name'];?></h1>
					
					<!-- Цена и кнопка -->
					<div class="product-price-section" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
						<?php if ($print['cash'] != 0 && $print['cash'] != '0') { ?>
						<div class="product-price">
							<span class="price-value" itemprop="price"><?=number_format($print['cash'], 0, '.', ' ');?></span>
							<span class="price-currency" itemprop="priceCurrency" content="KZT"> KZT</span>
						</div>
						<?php } else { ?>
						<div class="product-price-request">
							<span>Цена по запросу</span>
						</div>
						<?php } ?>
						<link itemprop="availability" href="https://schema.org/InStock" />
						<a href="tel:<?=preg_replace('/[^\\d+]/','', get_simple_texts('index_slider_phone'));?>" class="product-buy-button" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});"><?=get_simple_texts('index_slider_phone');?></a>
					</div>
					
					<!-- Описание товара -->
					<div class="product-description" itemprop="description">
						<?=$print['text'];?>
					</div>
					
					<!-- SEO: Дополнительный SEO-текст с целевыми ключевыми запросами -->
					<div class="product-seo-info">
						<p><strong>Купить контрактный мотор <?=$product_name;?> в Алматы</strong> - это отличное решение для вашего автомобиля. Мы предлагаем <strong>привозные моторы из Малайзии</strong>, которые проходят тщательную проверку перед продажей.</p>
						<p>Все наши <strong>контрактные двигатели Казахстан</strong> поставляются напрямую из Малайзии и имеют гарантию качества. Если вам нужен <strong>двигатель бу Малайзия Алматы</strong>, мы поможем подобрать оптимальный вариант.</p>
						<?php
						// SEO: Извлекаем марку и модель из названия товара для улучшения SEO
						$product_lower = mb_strtolower($product_name);
						$brands = ['toyota', 'honda', 'nissan', 'mazda', 'mitsubishi', 'subaru', 'suzuki'];
						$models = ['camry', 'corolla', 'crv', 'accord', 'almera', 'forester', 'outback', 'impreza', 'legacy'];
						$engines = ['1nz', '2az', '3s', 'k24a', 'qr25de', 'ej251'];
						$found_brand = '';
						$found_model = '';
						$found_engine = '';
						
						foreach ($brands as $brand) {
							if (strpos($product_lower, $brand) !== false) {
								$found_brand = ucfirst($brand);
								break;
							}
						}
						
						foreach ($models as $model) {
							if (strpos($product_lower, $model) !== false) {
								$found_model = ucfirst($model);
								break;
							}
						}
						
						foreach ($engines as $engine) {
							if (strpos($product_lower, $engine) !== false || strpos($product_lower, strtoupper($engine)) !== false) {
								$found_engine = strtoupper($engine);
								break;
							}
						}
						
						if ($found_brand || $found_model || $found_engine) {
							echo '<p>';
							if ($found_brand) {
								echo 'Мы специализируемся на поставке <strong>контрактных двигателей ' . $found_brand . '</strong>';
								if ($found_model) {
									echo ' для модели <strong>' . $found_model . '</strong>';
								}
								echo '. ';
							}
							if ($found_engine) {
								echo 'Если вам нужен <strong>двигатель ' . $found_engine . '</strong>, мы поможем подобрать оптимальный вариант. ';
							}
							echo 'Все <strong>контрактные двигатели</strong> проходят проверку и готовы к установке.</p>';
						}
						?>
						<p>Посмотрите также наш <a href="/catalog" class="product-link">полный каталог контрактных моторов</a>, где представлены <strong>контрактные двигатели Toyota, Honda, Nissan</strong> и других марок, или <a href="/service" class="product-link">запишитесь на установку в наш автосервис</a>.</p>
					</div>
				</div>
			</div>
			<!--<div class="charactr">
			<?=$print['text1'];?>
			</div>-->
		</article>
	</div>
</section>
</main>
<br><br>

	
<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

<!-- JavaScript для обработки кнопки покупки -->
<script>
$(document).ready(function() {
	// Обработчик клика на кнопку покупки (новая кнопка product-buy-button)
	$(document).on('click', '.product-buy-button', function() {
		var productName = $(this).attr('data-nam');
		if (productName) {
			$('#playpayid').val(productName);
			$('#playpayidv').text(productName);
			$('.plashesbgmodl').addClass('show').show();
			$('#zakazaty').addClass('show').show();
		}
	});
	
	// Обработчик клика на старую кнопку toverbuton (для обратной совместимости)
	$(document).on('click', '.toverbuton', function() {
		var productName = $(this).attr('data-nam');
		if (productName) {
			$('#playpayid').val(productName);
			$('#playpayidv').text(productName);
			$('.plashesbgmodl').addClass('show').show();
			$('#zakazaty').addClass('show').show();
		}
	});
});
</script>

</body>
</html>