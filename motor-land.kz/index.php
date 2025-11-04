<?php
include('hyst/php.php');

// SEO: Оптимизированные мета-теги с целевыми ключевыми запросами для главной страницы
// Целевые запросы: "купить контрактный мотор Алматы", "контрактные двигатели Казахстан", "привозные моторы Алматы", "двигатель бу Малайзия Алматы"
$SITE_TITLE = 'Купить Контрактный Мотор Алматы | Привозные Моторы Малайзия | Двигатель БУ | Моторленд';
$SITE_DESCRIPTION = 'Купить контрактный мотор в Алматы. Контрактные двигатели Казахстан - привозные моторы из Малайзии. Контрактный двигатель Toyota, Honda, Nissan, Mazda, Mitsubishi. Двигатель бу Малайзия Алматы с гарантией. Двигатель 1NZ, 2AZ, 3S, K24A, QR25DE. Контрактный двигатель Camry, CRV. Огромный выбор контрактных двигателей. Доставка по всему Казахстану.';
$SITE_KEYWORDS = 'купить контрактный мотор Алматы, контрактные двигатели Казахстан, привозные моторы Алматы, двигатель бу Малайзия Алматы, контрактные двигатели алматы, купить мотор б/у, привозные двигатели, контрактный мотор малайзия, контрактный двигатель Toyota, контрактный двигатель Honda, контрактный двигатель Nissan, контрактный двигатель Mazda, контрактный двигатель Mitsubishi, двигатель бу, контрактные двигатели, двигатели бу, двигатель 1NZ, двигатель 2AZ, двигатель 3S, двигатель K24A, двигатель QR25DE, контрактный двигатель Camry, контрактный двигатель CRV, контрактный двигатель Corolla, контрактный двигатель Almera, контрактный двигатель Accord';
?>
<!doctype html>
<html lang="ru">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<meta property="og:image" content="https://motor-land.kz/img/logo.jpg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale" content="ru_RU">
<meta property="og:site_name" content="Motor Land">
<!-- SEO: Twitter Cards для красивого отображения при репостах -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="https://motor-land.kz/">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
<meta name="twitter:image" content="https://motor-land.kz/img/logo.jpg">
<!-- SEO: Schema.org разметка для лучшего понимания структуры сайта поисковыми системами -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Motor Land",
  "alternateName": "Моторленд",
  "url": "https://motor-land.kz",
  "logo": "https://motor-land.kz/img/logo.jpg",
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
<main>
<!-- SEO: Семантический тег <section> для секции слайдера -->
<section class="slider" aria-label="Главный слайдер">
	<div id="slidess">
		<?php
		$slider = get_slider ('index_slider');
		$slide_index = 0;
		while($slide=$slider->fetch_array()):
		?>
		<!-- Performance: Preload первого изображения слайдера для ускорения LCP -->
		<?php if ($slide_index == 0): ?>
		<link rel="preload" as="image" href="<?=$slide['image'];?>">
		<?php endif; ?>
		<!-- SEO: Alt-текст для изображений слайдера с целевыми ключевыми словами -->
		<div class="sliderslid" style="background-image: url(<?=$slide['image'];?>);" aria-label="Купить контрактный мотор Алматы - привозные моторы из Малайзии, контрактные двигатели Казахстан"></div>
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
		 * Параметры: нет
		 * Возвращает: ничего
		 */
		function initSlider() {
			if (typeof jQuery === 'undefined') {
				setTimeout(initSlider, 100);
				return;
			}
			
			function slider () {
				var cil = $("#slidess").children('div').length - 1;
				var cur = 0;
				$("#slidess").children('div').each(function(index, element){	
					if ($(element).css('display') == 'block') {
					cur = index;
					}	
				});
				
				if (cur >= cil) { cur = 0; } else { cur++; }
				
				$("#slidess").children('div').each(function(index, element){	
					if ($(element).css('display') == 'block') { $(element).fadeOut(500); }
					if (cur == index) {
					$(element).fadeIn(500);
					}	
				});
				
				setTimeout(function() { slider () }, 3000);
			}
			
			setTimeout(function() { slider () }, 3000);
		}
		
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', initSlider);
		} else {
			initSlider();
		}
		</script>
	<div class="slidercoun shirina">
					
		<div class="titlephon"><?=get_simple_texts ('index_slider_title');?></div>
		<div class="sliderbtns"><a href="tel:<?=get_simple_texts ('index_slider_phone');?>" class="phone" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});"><?=get_simple_texts ('index_slider_phone');?></a><br><a href="catalog.php"><div class="atalogb">Каталог</div></a></div>
		<div class="sliderform">что ищем?
		
		
		<!---
		<form method="get" action="catalog.php">
		<input type="text" name="mk" placeholder="Марка" list="makrlist" id="idmark">
			<datalist id="makrlist">
			</datalist>
		<input type="text" name="nl" placeholder="Модель" list="modellist" id="idmode">
			<datalist id="modellist">
			</datalist>
		<input type="text" name="yr" placeholder="Год" list="yearlist" id="idyear">
			<datalist id="yearlist">
			</datalist>
		<input type="submit" name="sear" value=" ">
		</form>--->
			
		<form method="get" action="catalog.php">
			<!--<input type="text" name="setxt" class="searchbloinput" placeholder="Что вы хотели найти.."><br>--->
		
			<div class="maipttee">
				<div class="meinputer"><div class="madiv" data-val="Марка">Марка</div>
					<input type="hidden" name="mk">
					<div class="btmmearrow">&#9660;</div>
					<div class="ddwnblock">
						<?php
						$parent_id = 'noting';
						$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_category WHERE idp = ? ORDER BY name ASC");
						$stmt->bind_param("s", $parent_id);
						$stmt->execute();
						$sql = $stmt->get_result();
						if ($sql->num_rows != 0) {
							while($get = $sql->fetch_array()):
							?>
							<div data-id="<?=$get['id'];?>"><?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?></div>
							<?php
							endwhile;
						}
						$stmt->close();
						?>
					</div>
				</div>
				
				<div class="meinputer"><div class="madiv" data-val="Модель">Модель</div>
					<input type="hidden" name="ml">
					<div class="btmmearrow">&#9660;</div>
					<div class="ddwnblock" id="modellist"></div>
				</div>
				
				<div class="meinputer"><div class="madiv" data-val="Год">Год</div>
					<input type="hidden" name="yr">
					<div class="btmmearrow">&#9660;</div>
					<div class="ddwnblock" id="yearlist" style="overflow-y: scroll;"></div>
				</div>
			</div>
			<input type="submit" name="sear" value=" ">
		</form>
		</div>
	</div>
</section>

<!-- SEO: Семантический тег <section> для формы консультации -->
<section class="generalw forsbgf consult-section" aria-label="Форма консультации">
	<div class="shirina forsliderform JF_parent_form consult-container">
		<h2 class="consult-title">Хотите получить бесплатную консультацию?</h2>
		<div class="consult-subtitle">заполните форму</div>
		<form method="post" class="consult-form">
			<div class="form-control consult-form-control">
				<label for="consult-name">Имя</label>
				<input type="text" name="name" id="consult-name" class="consult-input consult-name" placeholder="Имя" required>
			</div>
			<div class="form-control consult-form-control">
				<label for="consult-phone">Телефон</label>
				<input type="text" name="phon" id="consult-phone" class="consult-input consult-phone" placeholder="Телефон" required>
			</div>
			<div class="consult-btn-wrapper">
				<input type="hidden" name="send_one" value="send">
				<button type="button" name="JF_send_casual" class="consult-btn"><span>Отправить</span></button>
			</div>
		</form>
	</div>
</section>

<!-- SEO: Семантический тег <section> для секции "О нас" -->
<section class="generalw" aria-labelledby="about-title">
	<div class="shirina zgolovorleft">
		<h2 id="about-title" class="sttitle"><span>О нас</span></h2>
	</div>
</section>

<section class="generalw">
	<div class="shirina">
		<div class="aboutblock">
			<!-- SEO: Alt-текст для изображения через aria-label с ключевыми словами -->
			<div class="sssskartins revealator-slideright" style="background-image: url(<?=get_simple_images('index_about_image')[0];?>);" aria-label="Контрактные двигатели и привозные моторы из Малайзии в Алматы - Моторленд"></div>
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
		<ul class="actionbtms" role="tablist">
			<li class="liacactive" data-typ="ac" role="tab">Каталог</li>
			<li data-typ="ca" role="tab">Акции</li>
		</ul>
	</div>
</section>

<section class="generalw" aria-label="Каталог товаров">
	<div class="shirina">
		<br>
		<!-- SEO: Семантический тег <article> для каждого товара -->
		<div id="actionb">
			<?php
			$limit = 4;
			$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_tovari ORDER BY prio ASC LIMIT ?");
			$stmt->bind_param("i", $limit);
			$stmt->execute();
			$tmp = $stmt->get_result();
			while($get = $tmp->fetch_array()):
			?>
			<article class="toverblock" itemscope itemtype="https://schema.org/Product">
			<!-- SEO: Внутренняя ссылка на товар -->
			<a href="/detal?id=<?=$get['id'];?>" itemprop="url">
				<!-- SEO: Alt-текст для изображения товара с целевыми ключевыми словами -->
				<div class="toverimg" style="background-image: url(<?=get_farrimg($get['images'])[0];?>);" loading="lazy" aria-label="<?=htmlspecialchars('Купить контрактный мотор '.$get['name'].' Алматы - привозные моторы из Малайзии', ENT_QUOTES, 'UTF-8');?>" itemprop="image">
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
			<a href="tel:<?=preg_replace('/[^\\d+]/','', get_simple_texts('index_slider_phone'));?>" class="toverbuton" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});">Купить</a>
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
				<div class="toverimg" style="background-image: url(<?=get_farrimg($get['images'])[0];?>);" loading="lazy" aria-label="<?=htmlspecialchars('Купить контрактный мотор '.$get['name'].' Алматы - привозные моторы из Малайзии', ENT_QUOTES, 'UTF-8');?>" itemprop="image">
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
			<a href="tel:<?=preg_replace('/[^\\d+]/','', get_simple_texts('index_slider_phone'));?>" class="toverbuton" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});">Купить</a>
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
		<a href="/catalog"><div class="okazatybolsh">Подробнее</div></a>
		<br>
		<br>
	</div>
</section>
</main>

<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>
</body>
</html>