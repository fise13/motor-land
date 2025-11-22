<?php
include('hyst/php.php');

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

$product_name = htmlspecialchars($print['name'], ENT_QUOTES, 'UTF-8');
$product_meta = htmlspecialchars($print['tmeta'], ENT_QUOTES, 'UTF-8');
$SITE_TITLE = 'Купить Контрактный Мотор '.$product_name.' Алматы | Привозные Моторы Малайзия | Моторленд | Доставка по СНГ';
$SITE_DESCRIPTION = 'Купить контрактный мотор '.$product_name.' в Алматы. Привозные моторы из Малайзии. '.$product_meta.'. Двигатель бу Малайзия Алматы с гарантией. Контрактные двигатели Казахстан, Россия, Беларусь, Украина, СНГ. Контрактный двигатель Toyota, Honda, Nissan. Двигатель бу. Быстрая доставка по странам СНГ. Цена: '.($print['cash']!=0?$print['cash'].' KZT':'уточняйте').'.';
$SITE_KEYWORDS = 'купить контрактный мотор '.mb_strtolower($product_name).' алматы, привозные моторы '.mb_strtolower($product_name).', двигатель бу малайзия алматы, контрактные двигатели казахстан, контрактные двигатели россия, контрактные двигатели СНГ, '.mb_strtolower($product_meta).', контрактный двигатель Toyota, контрактный двигатель Honda, контрактный двигатель Nissan, двигатель бу, контрактные двигатели, двигатели бу, доставка двигателей СНГ, контрактные моторы Беларусь, контрактные моторы Украина';

$product_image = get_farrimg($print['images'])[0];
$product_image_url = (strpos($product_image, 'http') === 0) ? $product_image : 'https://motor-land.kz'.$product_image;

$canonical_url = seo_get_product_url($print['id'], $print['name']);
$full_canonical_url = 'https://motor-land.kz' . $canonical_url;

// SEO: Редирект на ЧПУ URL, если доступ через старый URL с параметром id
// Проверяем, что это не прямой доступ к ЧПУ URL (чтобы избежать циклов)
$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
$request_path = parse_url($request_uri, PHP_URL_PATH);
// Если это доступ через /detal или /detal.php с параметром id, и это НЕ ЧПУ URL, перенаправляем на ЧПУ URL
if (preg_match('#^/detal(\.php)?$#', $request_path) && isset($_GET['id']) && !preg_match('#^/katalog/#', $request_path)) {
	header('Location: ' . $canonical_url, true, 301);
	exit;
}
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
<link rel="canonical" href="<?=$full_canonical_url;?>"/>
<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
<meta property="og:type" content="product">
<meta property="og:url" content="https://motor-land.kz/detal?id=<?=$print['id'];?>">
<meta property="og:title" content="<?=$SITE_TITLE;?>">
<meta property="og:description" content="<?=$SITE_DESCRIPTION;?>">
<meta property="og:image" content="<?=$product_image_url;?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale" content="ru_RU">
<meta property="og:site_name" content="Motor Land">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<?php if ($print['cash'] != 0 && $print['cash'] != '0') { ?>
<meta property="product:price:amount" content="<?=$print['cash'];?>">
<meta property="product:price:currency" content="KZT">
<?php } ?>
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
<meta name="twitter:image" content="<?=$product_image_url;?>">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "<?=$product_name;?>",
  "description": "Купить контрактный мотор <?=$product_name;?> в Алматы. Привозные моторы из Малайзии. Доставка по странам СНГ. <?=htmlspecialchars(strip_tags($print['text'] ? $print['text'] : $print['stext']), ENT_QUOTES, 'UTF-8');?>",
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
    "priceValidUntil": "<?=date('Y-m-d', strtotime('+1 year'));?>",
    "availability": "https://schema.org/InStock",
    "itemCondition": "https://schema.org/UsedCondition",
    "seller": {
      "@type": "Organization",
      "name": "Motor Land",
      "url": "https://motor-land.kz"
    },
    "shippingDetails": {
      "@type": "OfferShippingDetails",
      "shippingRate": {
        "@type": "MonetaryAmount",
        "value": "0",
        "currency": "KZT"
      },
      "shippingDestination": {
        "@type": "DefinedRegion",
        "addressCountry": ["KZ", "RU", "BY", "UA", "AM", "AZ", "GE", "KG", "MD", "TJ", "TM", "UZ"]
      }
    }
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.8",
    "reviewCount": "15",
    "bestRating": "5",
    "worstRating": "1"
  },
  "sku": "<?=$print['id'];?>",
  "mpn": "<?=$product_name;?>",
  "gtin": "",
  "additionalProperty": [{
    "@type": "PropertyValue",
    "name": "Состояние",
    "value": "Бывший в употреблении"
  }, {
    "@type": "PropertyValue",
    "name": "Страна происхождения",
    "value": "Малайзия"
  }]
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

<section class="generalw">
	<div class="shirina">
		<article class="product-detail-wrapper" itemscope itemtype="https://schema.org/Product">
			<div class="product-detail-container">
				<div class="product-image-wrapper">
					<?php 
					$product_img = get_optimized_image(get_farrimg($print['images'])[0]);
					?>
					<link rel="preload" as="image" href="<?=$product_img['webp'] ?: $product_img['original'];?>">
			<div class="tovarimage">
						<picture>
							<source srcset="<?=$product_img['webp'] ?: $product_img['original'];?>" type="image/webp">
							<img src="<?=$product_img['webp'] ?: $product_img['original'];?>" alt="<?='Купить контрактный мотор '.$product_name.' Алматы - привозные моторы из Малайзии, доставка по СНГ';?>" title="<?='Купить контрактный мотор '.$product_name.' Алматы - привозные моторы, доставка по СНГ';?>" itemprop="image" loading="eager" fetchpriority="high" width="600" height="450" decoding="async">
						</picture>
				<?php if ($print['sale'] != 'noting') { ?>
				<div class="cationsale"><?=$print['sale'];?></div>
				<?php } ?>
			</div>
		</div>
				
				<div class="product-info-wrapper">
					<h1 class="product-title" itemprop="name"><?=$print['name'];?></h1>
			
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
					</div>
					
					<a href="tel:<?=preg_replace('/[^\\d+]/','', get_simple_texts('index_slider_phone'));?>" class="product-buy-button" role="button" aria-label="Купить товар <?=htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8');?>" tabindex="0" onclick="if(typeof gtag==='function'){gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});}">Купить</a>
					
					<div class="product-description" itemprop="description">
						<?php
						$text = $print['text'];
						$text = preg_replace('/В наличии\s*[-–—]\s*на выбор более\s*\d+шт\.?/iu', '', $text);
						$text = preg_replace('/В наличии\s*на выбор более\s*\d+шт\.?/iu', '', $text);
						$text = preg_replace('/на выбор более\s*\d+шт\.?/iu', '', $text);
						echo $text;
						?>
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

<script defer>
(function() {
	function waitForJQuery(callback) {
		if (typeof window.jQuery !== 'undefined' && typeof window.$ !== 'undefined') {
			callback();
		} else {
			setTimeout(function() { waitForJQuery(callback); }, 50);
		}
	}
	
	function initBuyButtons() {
		var $ = window.jQuery || window.$;
		if (!$) {
			waitForJQuery(initBuyButtons);
			return;
		}
		
		$(document).on('click', '.product-buy-button', function(e) {
			if ($(this).attr('href') && $(this).attr('href').indexOf('tel:') === 0) {
				return;
			}
			e.preventDefault();
			var productName = $(this).closest('.product-info-wrapper').find('.product-title').text() || 
			                  $(this).attr('data-nam') || 
			                  $('#playpayidv').text();
			if (productName) {
				$('#playpayid').val(productName);
				$('#playpayidv').text(productName);
				if (typeof openModal === 'function') {
					openModal();
				} else {
					$('.plashesbgmodl').addClass('show').show().attr('aria-hidden', 'false');
					$('#zakazaty').addClass('show').show().attr('aria-hidden', 'false');
				}
			}
		});
		
		$(document).on('click', '.toverbuton', function(e) {
			if ($(this).attr('href') && $(this).attr('href').indexOf('tel:') === 0) {
				return;
			}
			e.preventDefault();
			var productName = $(this).closest('article').find('.tovertitle').text() || 
			                  $(this).attr('data-nam') || 
			                  $('#playpayidv').text();
			if (productName) {
				$('#playpayid').val(productName);
				$('#playpayidv').text(productName);
				if (typeof openModal === 'function') {
					openModal();
				} else {
					$('.plashesbgmodl').addClass('show').show().attr('aria-hidden', 'false');
					$('#zakazaty').addClass('show').show().attr('aria-hidden', 'false');
				}
			}
		});
	}
	
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			waitForJQuery(initBuyButtons);
		});
	} else {
		waitForJQuery(initBuyButtons);
	}
})();
</script>

</body>
</html>