<?php
include('hyst/php.php');

// SEO: Оптимизированные мета-теги с целевыми ключевыми запросами для главной страницы
// Целевые запросы: "купить контрактный мотор Алматы", "контрактные двигатели Казахстан", "привозные моторы Алматы", "двигатель бу Малайзия Алматы"
$SITE_TITLE = 'Купить Контрактный Мотор Алматы | Привозные Моторы Малайзия | Двигатель БУ | Моторленд';
$SITE_DESCRIPTION = 'Купить контрактный мотор в Алматы. Контрактные двигатели Казахстан - привозные моторы из Малайзии. Контрактный двигатель Toyota, Honda, Nissan, Mazda, Mitsubishi. Двигатель бу Малайзия Алматы с гарантией. Двигатель 1NZ, 2AZ, 3S, K24A, QR25DE. Контрактный двигатель Camry, CRV. Огромный выбор контрактных двигателей. Доставка по всему Казахстану.';
$SITE_KEYWORDS = 'купить контрактный мотор Алматы, контрактные двигатели Казахстан, привозные моторы Алматы, двигатель бу Малайзия Алматы, контрактные двигатели алматы, купить мотор б/у, привозные двигатели, контрактный мотор малайзия, контрактный двигатель Toyota, контрактный двигатель Honda, контрактный двигатель Nissan, контрактный двигатель Mazda, контрактный двигатель Mitsubishi, двигатель бу, контрактные двигатели, двигатели бу, двигатель 1NZ, двигатель 2AZ, двигатель 3S, двигатель K24A, двигатель QR25DE, контрактный двигатель Camry, контрактный двигатель CRV, контрактный двигатель Corolla, контрактный двигатель Almera, контрактный двигатель Accord';

$mark = false;
$mode = false;
$year = false;

if (isset($_GET['mk']) && $_GET['mk'] != '') {
	$name = trim($_GET['mk']);
	$stmt = $_DB_CONECT->prepare("SELECT id FROM internet_magazin_category WHERE name = ?");
	$stmt->bind_param("s", $name);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows != 0) {
		$mark = $result->fetch_array()['id'];
	}
	$stmt->close();
}

if (isset($_GET['ml']) && $_GET['ml'] != '') {
	$name = trim($_GET['ml']);
	$stmt = $_DB_CONECT->prepare("SELECT id FROM internet_magazin_category WHERE name = ?");
	$stmt->bind_param("s", $name);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows != 0) {
		$mode = $result->fetch_array()['id'];
	}
	$stmt->close();
}

if (isset($_GET['yr']) && $_GET['yr'] != '') {
	$name = trim($_GET['yr']);
	$stmt = $_DB_CONECT->prepare("SELECT id FROM internet_magazin_atributs_options WHERE name = ?");
	$stmt->bind_param("s", $name);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows != 0) {
		$year = $result->fetch_array()['id'];
	}
	$stmt->close();
}
?>
<!doctype html>
<html lang="ru">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Accessibility: Skip link для быстрой навигации с клавиатуры -->
<a href="#main-content" class="skip-link">Перейти к основному содержимому</a>
<?php include("hyst/head.php"); ?>
<!-- SEO: Canonical URL для предотвращения дублей контента -->
<link rel="canonical" href="https://motor-land.kz/"/>
<!-- SEO: Meta keywords для дополнительной индексации -->
<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
<!-- SEO: Open Graph мета-теги для социальных сетей (Facebook, VK) -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://motor-land.kz/">
<meta property="og:title" content="<?=$SITE_TITLE;?>">
<meta property="og:description" content="<?=$SITE_DESCRIPTION;?>">
<meta property="og:image" content="https://motor-land.kz/img/logo.webp">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale" content="ru_RU">
<meta property="og:site_name" content="Motor Land">
<!-- SEO: Twitter Cards для красивого отображения при репостах -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://motor-land.kz/">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
<meta name="twitter:image" content="https://motor-land.kz/img/logo.webp">
<!-- SEO: Schema.org разметка для лучшего понимания структуры сайта поисковыми системами -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Motor Land",
  "alternateName": "Моторленд",
  "url": "https://motor-land.kz",
  "logo": "https://motor-land.kz/img/logo.webp",
  "description": "Купить контрактный мотор в Алматы. Контрактные двигатели Казахстан - привозные моторы из Малайзии. Двигатель бу Малайзия Алматы с гарантией.",
  "address": [{
    "@type": "PostalAddress",
    "streetAddress": "РВ-90, 7-линия, 29",
    "addressLocality": "Алматы",
    "addressCountry": "KZ",
    "addressRegion": "Алматы"
  }, {
    "@type": "PostalAddress",
    "streetAddress": "улица Свердлова, 38",
    "addressLocality": "Алматы",
    "addressCountry": "KZ",
    "addressRegion": "Алматы"
  }],
  "contactPoint": [{
    "@type": "ContactPoint",
    "telephone": "+7-777-144-5445",
    "contactType": "Sales",
    "areaServed": "KZ",
    "availableLanguage": ["Russian", "Kazakh"]
  }, {
    "@type": "ContactPoint",
    "telephone": "+7-701-144-5445",
    "contactType": "Sales",
    "areaServed": "KZ",
    "availableLanguage": ["Russian", "Kazakh"]
  }],
  "sameAs": [
    "https://2gis.kz/almaty/geo/70000001083496996",
    "https://2gis.kz/almaty/geo/70000001024156353"
  ],
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.8",
    "reviewCount": "150"
  }
}
</script>
</head>
<body>
<?php include("hyst/sbody.php"); ?>
<?php include("des/head.php"); ?>

<!-- SEO: Семантический тег <main> для основного контента страницы -->
<!-- Accessibility: Основной контент страницы с идентификатором для skip link -->
<main id="main-content" role="main">
<!-- SEO: Семантический тег <section> для секции слайдера -->
<section class="slider" aria-label="Главный слайдер">
	<div id="slidess">
		<?php
		$slider = get_slider ('index_slider');
		$slide_index = 0;
		while($slide=$slider->fetch_array()):
		?>
		<!-- Performance: Оптимизация LCP - первый слайд использует <img> вместо background-image -->
		<?php if ($slide_index == 0): 
			$slide_img = get_optimized_image($slide['image']);
		?>
		<!-- Performance: Preload первого изображения с высоким приоритетом для улучшения LCP -->
		<link rel="preload" as="image" href="<?=$slide_img['webp'] ?: $slide_img['original'];?>" fetchpriority="high">
		<!-- Performance: Используем <img> для LCP элемента вместо background-image с WebP поддержкой -->
		<!-- SEO: H1 заголовок на главной странице должен быть только один -->
		<picture>
			<?php if ($slide_img['webp']): ?>
			<source srcset="<?=$slide_img['webp'];?>" type="image/webp">
			<?php endif; ?>
			<img src="<?=$slide_img['original'];?>" alt="Купить контрактный мотор Алматы - привозные моторы из Малайзии, контрактные двигатели Казахстан" class="sliderslid" loading="eager" fetchpriority="high" width="1920" height="600" decoding="async" style="object-fit:cover;width:100%;height:100%;position:absolute;top:0;left:0;display:block;">
		</picture>
		<?php else: 
			$slide_img = get_optimized_image($slide['image']);
		?>
		<!-- Performance: Оптимизированные изображения слайдера с WebP -->
		<div class="sliderslid" style="background-image: url(<?=$slide_img['webp'] ?: $slide_img['original'];?>);" aria-label="Купить контрактный мотор Алматы - привозные моторы из Малайзии, контрактные двигатели Казахстан" loading="lazy"></div>
		<?php endif; ?>
		<?php
		$slide_index++;
		endwhile;
		?>
	</div>
	<!-- Performance: Скрипт слайдера выполняется после загрузки DOM и jQuery -->
	<script>
		/**
		 * Функция: Автоматическая смена слайдов
		 * Описание: Переключает слайды в главном слайдере каждые 3 секунды.
		 * 			Находит текущий отображаемый слайд и плавно показывает следующий.
		 * Performance: Ожидает загрузки jQuery перед использованием
		 * Параметры: нет
		 * Возвращает: ничего
		 */
		(function() {
			function waitForJQuery(callback) {
				if (typeof window.jQuery !== 'undefined' && typeof window.$ !== 'undefined') {
					callback();
				} else {
					setTimeout(function() { waitForJQuery(callback); }, 50);
				}
			}
			
			function initSlider() {
				var $ = window.jQuery || window.$;
				if (!$) {
					waitForJQuery(initSlider);
					return;
				}
				
				function slider() {
					var cil = $("#slidess").children('div, img').length - 1;
			var cur = 0;
					$("#slidess").children('div, img').each(function(index, element){	
						if ($(element).css('display') == 'block' || $(element).is(':visible')) {
				cur = index;
				}	
			});
			
			if (cur >= cil) { cur = 0; } else { cur++; }
			
					$("#slidess").children('div, img').each(function(index, element){	
						if ($(element).css('display') == 'block' || $(element).is(':visible')) { 
							$(element).fadeOut(500); 
						}
				if (cur == index) {
				$(element).fadeIn(500);
				}	
			});
			
					setTimeout(function() { slider(); }, 3000);
		}
		
				setTimeout(function() { slider(); }, 3000);
			}
			
			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', function() {
					waitForJQuery(initSlider);
				});
			} else {
				waitForJQuery(initSlider);
			}
		})();
		</script>
	<div class="slidercoun shirina">
		<!-- SEO: H1 заголовок на главной странице (единственный H1 на странице) -->
		<!-- Accessibility: Заголовок слайдера -->
		<h1 class="titlephon" role="heading" aria-level="1"><?=get_simple_texts ('index_slider_title');?></h1>
		<!-- Accessibility: Кнопки действий с ARIA атрибутами -->
		<div class="sliderbtns" role="group" aria-label="Действия на главной странице">
			<a href="tel:<?=get_simple_texts ('index_slider_phone');?>" class="phone" aria-label="Позвонить по телефону <?=get_simple_texts ('index_slider_phone');?>" role="button" tabindex="0" onclick="if(typeof gtag==='function'){gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});}"><?=get_simple_texts ('index_slider_phone');?></a><br>
			<a href="catalog.php" aria-label="Перейти в каталог товаров"><div class="atalogb" role="button" tabindex="0">Каталог</div></a>
		</div>
		<!-- Accessibility: Форма поиска с правильными labels -->
		<div class="sliderform" role="search" aria-label="Поиск товаров по параметрам">
			<label for="search-form" class="sr-only">Поиск товаров</label>
			<span id="search-form-label">что ищем?</span>
		
		<form method="get" action="catalog.php" aria-labelledby="search-form-label">
			<div class="maipttee">
				<div class="meinputer" style="border: solid 1px white;"><div class="madiv" data-val="Марка"><?php if (isset($_GET['mk']) && $_GET['mk'] != '') { echo htmlspecialchars($_GET['mk'], ENT_QUOTES, 'UTF-8'); } else { echo "Марка"; } ?></div>
					<input type="hidden" name="mk" value="<?php if (isset($_GET['mk']) && $_GET['mk'] != '') { echo htmlspecialchars($_GET['mk'], ENT_QUOTES, 'UTF-8'); } else { echo ""; } ?>">
					<div class="btmmearrow" style="font-size: 17px;">&#9660;</div>
					<div class="ddwnblock" style="border-top: solid 1px white; border-bottom: solid 1px white; border-right: solid 1px white; border-left: solid 1px white;">
						<?php
						$parent_id = 'noting';
						$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_category WHERE idp = ? ORDER BY id ASC");
						$stmt->bind_param("s", $parent_id);
						$stmt->execute();
						$tmp = $stmt->get_result();
						if ($tmp->num_rows != 0) {
							while($get = $tmp->fetch_array()):
							?>
							<div style="color: black" data-id="<?=$get['id'];?>"><?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?></div>
							<?php
							endwhile;
						}
						$stmt->close();
						?>
					</div>
				</div>
				
				<div class="meinputer" style="border: solid 1px white;"><div class="madiv" data-val="Модель"><?php if (isset($_GET['ml']) && $_GET['ml'] != '') { echo htmlspecialchars($_GET['ml'], ENT_QUOTES, 'UTF-8'); } else { echo "Модель"; } ?></div>
					<input type="hidden" name="ml" value="<?php if (isset($_GET['ml']) && $_GET['ml'] != '') { echo htmlspecialchars($_GET['ml'], ENT_QUOTES, 'UTF-8'); } else { echo ""; } ?>">
					<div class="btmmearrow" style="font-size: 17px;">&#9660;</div>
					<div class="ddwnblock" id="modellist" style="border-top: solid 1px white; border-bottom: solid 1px white; border-right: solid 1px white; border-left: solid 1px white;">
						<?php
						if ($mark) {
							$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_category WHERE idp = ? ORDER BY id ASC");
							$stmt->bind_param("i", $mark);
							$stmt->execute();
							$tmp = $stmt->get_result();
							if ($tmp->num_rows != 0) {
								while($get = $tmp->fetch_array()):
								?>
								<div style="color: black" data-id="<?=$get['id'];?>"><?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?></div>
								<?php
								endwhile;
							}
							$stmt->close();
						}
						?>
					</div>
				</div>
				
				<div class="meinputer" style="border-top: solid 1px white; border: solid 1px white;"><div class="madiv"><?php if (isset($_GET['yr']) && $_GET['yr'] != '') { echo htmlspecialchars($_GET['yr'], ENT_QUOTES, 'UTF-8'); } else { echo "Год"; } ?></div>
					<input type="hidden" name="yr" value="<?php if (isset($_GET['yr']) && $_GET['yr'] != '') { echo htmlspecialchars($_GET['yr'], ENT_QUOTES, 'UTF-8'); } else { echo ""; } ?>">
					<div class="btmmearrow" style="font-size: 17px;">&#9660;</div>
					<div class="ddwnblock" id="yearlist" style="overflow-y: scroll; border-top: solid 1px white; border-bottom: solid 1px white; border-right: solid 1px white; border-left: solid 1px white;">
						<?php
						if ($mode) {
							$mode_pattern = '[' . $mode . ']';
							$stmt = $_DB_CONECT->prepare("SELECT internet_magazin_atributs_options.*
							FROM internet_magazin_atributs_options 
							INNER JOIN internet_magazin_tovari ON LOCATE(CONCAT('[', internet_magazin_atributs_options.id, ']'), internet_magazin_tovari.atributs_opt) > 0 
							AND LOCATE(?, internet_magazin_tovari.podegory) > 0
							WHERE internet_magazin_atributs_options.idp = 1");
							$stmt->bind_param("s", $mode_pattern);
							$stmt->execute();
							$sql = $stmt->get_result();
							if ($sql->num_rows != 0) {
								while($get = $sql->fetch_array()):
								?>
								<div style="color: black" data-id="<?=$get['id'];?>"><?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?></div>
								<?php
								endwhile;
							}
							$stmt->close();
						}
						?>	
					</div>
				</div>
			</div>
			<input type="submit" name="sear" value=" ">
		</form>
		</div>
	</div>
</section>

<!-- SEO: Семантический тег <section> для формы консультации -->
<!-- Accessibility: Форма консультации с полной поддержкой screen readers -->
<section class="generalw forsbgf consult-section" aria-labelledby="consult-title" role="region">
	<div class="shirina forsliderform JF_parent_form consult-container">
		<h2 id="consult-title" class="consult-title">Хотите получить бесплатную консультацию?</h2>
		<div class="consult-subtitle" id="consult-subtitle">заполните форму</div>
		<form method="post" class="consult-form" aria-labelledby="consult-title" aria-describedby="consult-subtitle" novalidate>
			<!-- Security: Honeypot поле для защиты от спама (скрыто от пользователей) -->
			<input type="text" name="website" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0;z-index:-1;" tabindex="-1" autocomplete="off" aria-hidden="true">
			<!-- Security: Время загрузки формы (для защиты от быстрых отправок) -->
			<input type="hidden" name="form_time" value="<?=time();?>" aria-hidden="true">
			<div class="form-control consult-form-control">
				<label for="consult-name">Имя <span aria-label="обязательное поле">*</span></label>
				<input type="text" name="name" id="consult-name" class="consult-input consult-name" placeholder="Имя" required aria-required="true" autocomplete="name" maxlength="100">
			</div>
			<div class="form-control consult-form-control">
				<label for="consult-phone">Телефон <span aria-label="обязательное поле">*</span></label>
				<input type="tel" name="phon" id="consult-phone" class="consult-input consult-phone" placeholder="Телефон" required aria-required="true" autocomplete="tel" maxlength="20">
			</div>
			<div class="consult-btn-wrapper">
				<input type="hidden" name="send_one" value="send" aria-hidden="true">
				<button type="button" name="JF_send_casual" class="consult-btn" aria-label="Отправить форму обратной связи"><span>Отправить</span></button>
			</div>
		</form>
	</div>
</section>

<!-- SEO: Семантический тег <section> для секции "О нас" -->
<!-- SEO: Правильная иерархия заголовков: после H1 идет H2 -->
<section class="generalw" aria-labelledby="about-title">
	<div class="shirina zgolovorleft">
		<h2 id="about-title" class="sttitle"><span>О нас</span></h2>
	</div>
</section>

<section class="generalw">
	<div class="shirina">
		<div class="aboutblock">
			<!-- SEO: Alt-текст для изображения через aria-label с ключевыми словами -->
			<?php 
			$about_img = get_optimized_image(get_simple_images('index_about_image')[0]);
			?>
			<div class="sssskartins revealator-slideright" style="background-image: url(<?=$about_img['webp'] ?: $about_img['original'];?>);" aria-label="Контрактные двигатели и привозные моторы из Малайзии в Алматы - Моторленд" loading="lazy"></div>
			<div class="abouttext revealator-slideleft">
			<?=get_customtexts('index_about_text');?>
			</div>
		</div>
	</div>
</section>

<div class="generalw">
	<div class="shirina zgolovorright">
	</div>
</div>

<!-- SEO: Семантический тег <section> для каталога товаров -->
<section class="generalw frayalpfhon" aria-labelledby="catalog-title">
	<div class="shirina">
		<!-- Accessibility: Вкладки с ARIA атрибутами -->
		<ul class="actionbtms" role="tablist" aria-label="Переключение между каталогом и акциями">
			<li class="liacactive" data-typ="ac" role="tab" aria-selected="true" aria-controls="actionb" id="tab-catalog" tabindex="0">Каталог</li>
			<li data-typ="ca" role="tab" aria-selected="false" aria-controls="goodsb" id="tab-sales" tabindex="-1">Акции</li>
		</ul>
	</div>
</section>

<section class="generalw" aria-label="Каталог товаров">
	<div class="shirina">
		<br>
		<!-- SEO: Семантический тег <article> для каждого товара -->
		<!-- Accessibility: Контейнер каталога с ARIA атрибутами -->
		<div id="actionb" role="tabpanel" aria-labelledby="tab-catalog">
			<?php
			$limit = 4;
			$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_tovari ORDER BY prio ASC LIMIT ?");
			$stmt->bind_param("i", $limit);
			$stmt->execute();
			$tmp = $stmt->get_result();
			while($get = $tmp->fetch_array()):
			?>
			<!-- Accessibility: Карточка товара с полной поддержкой screen readers -->
			<article class="toverblock" itemscope itemtype="https://schema.org/Product" role="article" aria-labelledby="home-product-title-<?=$get['id'];?>">
			<!-- SEO: Внутренняя ссылка на товар -->
			<a href="/detal?id=<?=$get['id'];?>" itemprop="url" aria-label="Подробнее о товаре <?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?>">
				<!-- Performance: Оптимизированное изображение товара с WebP и lazy loading -->
				<?php 
				$product_img = get_optimized_image(get_farrimg($get['images'])[0]);
				?>
				<div class="toverimg" style="background-image: url(<?=$product_img['webp'] ?: $product_img['original'];?>);" loading="lazy" aria-label="<?=htmlspecialchars('Купить контрактный мотор '.$get['name'].' Алматы - привозные моторы из Малайзии', ENT_QUOTES, 'UTF-8');?>" itemprop="image" role="img"></div>
			<?php if ($get['sale'] != 'noting') { ?>
			<div class="cationsale" aria-label="Скидка: <?=htmlspecialchars($get['sale'], ENT_QUOTES, 'UTF-8');?>"><?=$get['sale'];?></div>
			<?php } ?>
			</a>
			<h3 id="home-product-title-<?=$get['id'];?>" class="tovertitle" itemprop="name"><?=$get['name'];?></h3>
			<div class="tovaropis" itemprop="description" aria-label="Описание товара">
				<?=$get['stext'];?>
			</div>
			<div class="tovercena" itemprop="offers" itemscope itemtype="https://schema.org/Offer" aria-label="Цена товара">
				<?php if ($get['cash'] != 0 && $get['cash'] != '0') { ?>
				<span itemprop="price" aria-label="Цена"><?=$get['cash'];?></span>
				<span itemprop="priceCurrency" content="KZT" aria-label="валюта"> KZT</span>
				<?php } else { ?>
				<span aria-label="Цена по запросу">Цена по запросу</span>
				<?php } ?>
			</div>
			<a href="tel:<?=preg_replace('/[^\\d+]/','', get_simple_texts('index_slider_phone'));?>" class="toverbuton" role="button" aria-label="Купить товар <?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?>" tabindex="0" onclick="if(typeof gtag==='function'){gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});}">Купить</a>
			</article>
			<?php
			endwhile;
			if (isset($stmt)) {
				$stmt->close();
			}
			?>
		</div>
		<div id="goodsb" style="display: none;">
			<?php
			$sale_value = 'noting';
			$limit = 4;
			$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_tovari WHERE sale != ? ORDER BY prio ASC LIMIT ?");
			$stmt->bind_param("si", $sale_value, $limit);
			$stmt->execute();
			$tmp = $stmt->get_result();
			while($get = $tmp->fetch_array()):
			?>
			<article class="toverblock revealator-slideup" itemscope itemtype="https://schema.org/Product">
			<a href="/detal?id=<?=$get['id'];?>" itemprop="url">
				<!-- SEO: Alt-текст для изображения товара с целевыми ключевыми словами -->
				<?php 
				$product_img = get_optimized_image(get_farrimg($get['images'])[0]);
				?>
				<div class="toverimg" style="background-image: url(<?=$product_img['webp'] ?: $product_img['original'];?>);" loading="lazy" aria-label="<?=htmlspecialchars('Купить контрактный мотор '.$get['name'].' Алматы - привозные моторы из Малайзии', ENT_QUOTES, 'UTF-8');?>" itemprop="image">
			<?php if ($get['sale'] != 'noting') { ?>
			<div class="cationsale"><?=$get['sale'];?></div>
			<?php } ?>
			</div></a>
			<h3 class="tovertitle" itemprop="name"><?=$get['name'];?></h3>
			<div class="tovaropis" itemprop="description">
				<?=$get['stext'];?>
			</div>
			<div class="tovercena" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
				<?php if ($get['cash'] != 0 && $get['cash'] != '0') { ?>
				<span itemprop="price"><?=$get['cash'];?></span>
				<span itemprop="priceCurrency" content="KZT"> KZT</span>
				<?php } else { ?>
				<span>Цена по запросу</span>
				<?php } ?>
			</div>
			<a href="tel:<?=preg_replace('/[^\\d+]/','', get_simple_texts('index_slider_phone'));?>" class="toverbuton" role="button" aria-label="Купить товар <?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?>" tabindex="0" onclick="if(typeof gtag==='function'){gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});}">Купить</a>
			</article>
			<?php
			endwhile;
			if (isset($stmt)) {
				$stmt->close();
			}
			?>			
		</div>
		<br>
		<br>
		<!-- SEO: Внутренняя ссылка на каталог с ключевыми словами в тексте -->
		<a href="/catalog" class="okazatybolsh-link" style="text-decoration: none; color: inherit; display: inline-block;"><div class="okazatybolsh">Подробнее</div></a>
		<br>
		<br>
	</div>
</section>
</main>

<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>
</body>
</html>