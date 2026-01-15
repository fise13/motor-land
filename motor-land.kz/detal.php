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

// Подготовка данных товара для переиспользования
$product_data = [
	'id' => $print['id'],
	'name' => htmlspecialchars($print['name'], ENT_QUOTES, 'UTF-8'),
	'price' => ($print['cash'] != 0 && $print['cash'] != '0') ? (int)$print['cash'] : null,
	'price_formatted' => ($print['cash'] != 0 && $print['cash'] != '0') ? number_format((int)$print['cash'], 0, '.', ' ') : null,
	'description' => $print['text'] ?: $print['stext'],
	'short_description' => $print['stext'] ?: '',
	'images' => get_farrimg($print['images']),
	'sale' => $print['sale'] != 'noting' ? $print['sale'] : null,
	'in_stock' => $print['instock'] > 0,
	'attributes' => $print['atributs'] ?: '',
	'attributes_opt' => $print['atributs_opt'] ?: '',
	'category' => $print['category'] ?: '',
	'subcategory' => $print['podegory'] ?: '',
	'artikul' => $print['arti'] != 'noting' ? $print['arti'] : null,
	'warranty_days' => 14, // По умолчанию 14 дней гарантии
	'country' => 'Малайзия', // Страна поставки
	'condition' => 'Контрактный', // Состояние товара
];

// SEO мета-теги
$product_name = $product_data['name'];
$product_meta = htmlspecialchars($print['tmeta'], ENT_QUOTES, 'UTF-8');
$product_price_text = $product_data['price'] ? $product_data['price_formatted'] . ' KZT' : 'уточняйте';
$SITE_TITLE = 'Купить ' . $product_name . ' в Алматы | Контрактный Мотор | Motor Land';
$short_desc = mb_substr(strip_tags($product_data['short_description']), 0, 80);
$SITE_DESCRIPTION = 'Купить контрактный мотор ' . $product_name . ' в Алматы. Привозные моторы из Малайзии с гарантией. ' . ($product_meta ? $product_meta . '. ' : '') . 'Доставка по России, Казахстану, Беларуси, СНГ. Цена: ' . $product_price_text;
$SITE_KEYWORDS = 'купить контрактный мотор ' . mb_strtolower($product_name) . ' алматы, контрактные двигатели казахстан, контрактные двигатели россия, привозные моторы, двигатель бу, доставка двигателей СНГ';

// Изображения
$all_product_images = array_filter($product_data['images']);
$product_image = !empty($all_product_images[0]) ? $all_product_images[0] : '';
$product_image_url = (strpos($product_image, 'http') === 0) ? $product_image : 'https://motor-land.kz'.$product_image;

$canonical_url = seo_get_product_url($print['id'], $print['name']);
$full_canonical_url = 'https://motor-land.kz' . $canonical_url;
$product_url_safe = htmlspecialchars($full_canonical_url, ENT_QUOTES, 'UTF-8');

// Редирект на ЧПУ URL
$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
$request_path = parse_url($request_uri, PHP_URL_PATH);
if (preg_match('#^/detal(\.php)?$#', $request_path) && isset($_GET['id']) && !preg_match('#^/katalog/#', $request_path)) {
	header('Location: ' . $canonical_url, true, 301);
	exit;
}

// Парсинг характеристик из atributs_opt для отображения
function parse_product_attributes($attributes_opt, $category, $subcategory) {
	$attrs = [];
	
	// Извлекаем год, объем, тип топлива и т.д. из atributs_opt
	// Формат: [id1][id2][id3]...
	if (!empty($attributes_opt)) {
		$attr_ids = get_farrimg($attributes_opt);
		// Здесь можно добавить запрос к БД для получения названий атрибутов
		// Пока используем базовую структуру
	}
	
	// Извлекаем марку и модель из category и subcategory
	if (!empty($category)) {
		$category_ids = get_farrimg($category);
		// Можно добавить запрос к БД для получения названия категории
	}
	
	if (!empty($subcategory)) {
		$subcategory_ids = get_farrimg($subcategory);
		// Можно добавить запрос к БД для получения названия подкатегории
	}
	
	return $attrs;
}

$parsed_attributes = parse_product_attributes($product_data['attributes_opt'], $product_data['category'], $product_data['subcategory']);
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
	<meta property="og:url" content="<?=$product_url_safe;?>">
	<meta property="og:title" content="<?=htmlspecialchars(trim($SITE_TITLE), ENT_QUOTES, 'UTF-8');?>">
	<meta property="og:description" content="<?=htmlspecialchars(trim($SITE_DESCRIPTION), ENT_QUOTES, 'UTF-8');?>">
	<meta property="og:image" content="<?=$product_image_url;?>">
	<meta property="og:image:secure_url" content="<?=$product_image_url;?>">
	<meta property="og:image:type" content="image/webp">
	<meta property="og:image:width" content="1200">
	<meta property="og:image:height" content="630">
	<meta property="og:image:alt" content="<?=htmlspecialchars('Купить контрактный мотор ' . $product_name . ' Алматы', ENT_QUOTES, 'UTF-8');?>">
	<meta property="og:locale" content="ru_RU">
	<meta property="og:site_name" content="Motor Land">
	<?php if ($product_data['price']) { ?>
	<meta property="product:price:amount" content="<?=$product_data['price'];?>">
	<meta property="product:price:currency" content="KZT">
	<meta property="product:availability" content="in stock">
	<meta property="product:condition" content="used">
	<?php } ?>
	
	<!-- Schema.org Product микроразметка -->
	<script type="application/ld+json">
	{
	  "@context": "https://schema.org",
	  "@type": "Product",
	  "name": "<?=$product_name;?>",
	  "description": "<?=htmlspecialchars(strip_tags($product_data['description']), ENT_QUOTES, 'UTF-8');?>",
	  <?php 
	  $schema_images = array();
	  foreach ($all_product_images as $img) {
		if (!empty($img)) {
		  $img_url = (strpos($img, 'http') === 0) ? $img : 'https://motor-land.kz'.$img;
		  $schema_images[] = '"' . htmlspecialchars($img_url, ENT_QUOTES, 'UTF-8') . '"';
		}
	  }
	  if (count($schema_images) > 1) {
		echo '"image": [' . implode(', ', $schema_images) . '],';
	  } else {
		echo '"image": "' . htmlspecialchars($product_image_url, ENT_QUOTES, 'UTF-8') . '",';
	  }
	  ?>
	  "brand": {
		"@type": "Brand",
		"name": "Motor Land"
	  },
	  "category": "Контрактные двигатели",
	  "offers": {
		"@type": "Offer",
		"url": "<?=$product_url_safe;?>",
		"priceCurrency": "KZT",
		"price": "<?=$product_data['price'] ?: '0';?>",
		"priceValidUntil": "<?=date('Y-m-d', strtotime('+1 year'));?>",
		"availability": "https://schema.org/InStock",
		"itemCondition": "https://schema.org/UsedCondition",
		"seller": {
		  "@type": "Organization",
		  "name": "Motor Land",
		  "url": "https://motor-land.kz"
		}
	  },
	  "sku": "<?=$product_data['id'];?>",
	  "mpn": "<?=$product_name;?>"
	}
	</script>
	
	<!-- BreadcrumbList -->
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
		"name": "<?=htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8');?>",
		"item": "<?=$product_url_safe;?>"
	  }]
	}
	</script>
	
	<!-- Подключение стилей карточки товара -->
	<link rel="stylesheet" href="/assets/css/product-card.css?v=<?=time();?>&fix=7">
</head>
<body>
<?php include("hyst/sbody.php"); ?>
<?php include("des/head.php"); ?>

<main class="product-page-main">
	<!-- Хлебные крошки -->
	<nav class="product-breadcrumbs" aria-label="Навигационная цепочка">
		<div class="container">
			<div class="breadcrumbs-list" itemscope itemtype="https://schema.org/BreadcrumbList">
				<a href="/" itemprop="item" class="breadcrumb-item">
					<span itemprop="name">Главная</span>
					<meta itemprop="position" content="1" />
				</a>
				<span class="breadcrumb-separator">/</span>
				<a href="/catalog" itemprop="item" class="breadcrumb-item">
					<span itemprop="name">Каталог</span>
					<meta itemprop="position" content="2" />
				</a>
				<span class="breadcrumb-separator">/</span>
				<span class="breadcrumb-item current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<span itemprop="name"><?=$product_name;?></span>
					<meta itemprop="position" content="3" />
				</span>
			</div>
		</div>
	</nav>

	<!-- Основная карточка товара -->
	<section class="product-card-section">
		<div class="container">
			<article class="product-card" itemscope itemtype="https://schema.org/Product">
				
				<!-- Левая колонка: Галерея изображений -->
				<div class="product-gallery">
					<?php if (!empty($all_product_images)): ?>
						<!-- Главное изображение -->
						<div class="product-gallery-main">
							<div class="product-image-container" id="main-image-container">
								<?php 
								$main_img = get_optimized_image($all_product_images[0]);
								?>
								<picture>
									<source srcset="<?=$main_img['webp'] ?: $main_img['original'];?>" type="image/webp">
									<img 
										id="main-product-image" 
										src="<?=$main_img['webp'] ?: $main_img['original'];?>" 
										alt="<?=$product_name;?>" 
										itemprop="image"
										loading="eager"
										fetchpriority="high"
										class="product-main-image"
										data-zoom-src="<?=$main_img['webp'] ?: $main_img['original'];?>">
								</picture>
								
								<!-- Кнопка увеличения -->
								<button class="product-image-zoom-btn" aria-label="Увеличить изображение" onclick="openImageModal(0)">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<circle cx="11" cy="11" r="8"></circle>
										<path d="m21 21-4.35-4.35"></path>
										<line x1="11" y1="8" x2="11" y2="14"></line>
										<line x1="8" y1="11" x2="14" y2="11"></line>
									</svg>
								</button>
								
								<?php if ($product_data['sale']): ?>
								<div class="product-badge product-badge-sale"><?=$product_data['sale'];?></div>
								<?php endif; ?>
								
								<?php if (!$product_data['in_stock']): ?>
								<div class="product-badge product-badge-out">Нет в наличии</div>
								<?php endif; ?>
							</div>
						</div>
						
						<!-- Миниатюры (если больше 1 фото) -->
						<?php if (count($all_product_images) > 1): ?>
						<div class="product-gallery-thumbs">
							<?php foreach ($all_product_images as $index => $img_path): 
								if (empty($img_path)) continue;
								$thumb_img = get_optimized_image($img_path);
							?>
							<button 
								class="product-thumb <?=$index === 0 ? 'active' : '';?>" 
								data-image-index="<?=$index;?>"
								onclick="changeMainImage(<?=$index;?>)"
								aria-label="Показать фото <?=$index + 1;?>">
								<picture>
									<source srcset="<?=$thumb_img['webp'] ?: $thumb_img['original'];?>" type="image/webp">
									<img 
										src="<?=$thumb_img['webp'] ?: $thumb_img['original'];?>" 
										alt="Фото <?=$index + 1;?>" 
										loading="lazy">
								</picture>
							</button>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
					<?php else: ?>
						<!-- Placeholder если нет изображений -->
						<div class="product-gallery-main">
							<div class="product-image-placeholder">
								<svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
									<rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
									<circle cx="8.5" cy="8.5" r="1.5"></circle>
									<polyline points="21 15 16 10 5 21"></polyline>
								</svg>
								<p>Изображение отсутствует</p>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<!-- Правая колонка: Информация о товаре -->
				<div class="product-info">
					<!-- 1. Название -->
					<h1 class="product-title" itemprop="name"><?=$product_name;?></h1>
					
					<!-- 2. Цена или статус -->
					<div class="product-price-block" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
						<?php if ($product_data['price']): ?>
							<div class="product-price">
								<span class="product-price-value" itemprop="price"><?=$product_data['price_formatted'];?></span>
								<span class="product-price-currency" itemprop="priceCurrency" content="KZT"> KZT</span>
							</div>
						<?php else: ?>
							<div class="product-price-request">
								<span class="price-label">Цена по запросу</span>
								<span class="price-hint">Уточняйте актуальную стоимость</span>
							</div>
						<?php endif; ?>
						<meta itemprop="availability" href="https://schema.org/InStock" />
					</div>
					
					<!-- 3. Основная кнопка CTA -->
					<div class="product-actions">
						<button 
							class="btn btn-primary btn-cta" 
							id="request-price-btn"
							onclick="openPriceModal()"
							data-product-id="<?=$product_data['id'];?>"
							data-product-name="<?=htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8');?>">
							<svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
							</svg>
							<span>Запросить цену</span>
						</button>
						
						<div class="product-actions-secondary">
							<button class="btn btn-secondary btn-icon-only" onclick="openQuestionModal()" aria-label="Задать вопрос">
								<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<circle cx="12" cy="12" r="10"></circle>
									<path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
									<line x1="12" y1="17" x2="12.01" y2="17"></line>
								</svg>
							</button>
							<button class="btn btn-secondary btn-icon-only" onclick="toggleFavorite()" aria-label="Добавить в избранное" id="favorite-btn">
								<svg class="icon-heart" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
								</svg>
							</button>
						</div>
					</div>
					
					<!-- 4. Краткие характеристики -->
					<div class="product-specs">
						<h3 class="product-specs-title">Основные характеристики</h3>
						<dl class="product-specs-list">
							<?php if ($product_data['artikul']): ?>
							<div class="product-spec-item">
								<dt>Артикул:</dt>
								<dd><?=$product_data['artikul'];?></dd>
							</div>
							<?php endif; ?>
							
							<div class="product-spec-item">
								<dt>Состояние:</dt>
								<dd><?=$product_data['condition'];?></dd>
							</div>
							
							<div class="product-spec-item">
								<dt>Страна поставки:</dt>
								<dd><?=$product_data['country'];?></dd>
							</div>
							
							<div class="product-spec-item">
								<dt>Гарантия:</dt>
								<dd><?=$product_data['warranty_days'];?> дней</dd>
							</div>
							
							<div class="product-spec-item">
								<dt>Наличие:</dt>
								<dd class="<?=$product_data['in_stock'] ? 'in-stock' : 'out-of-stock';?>">
									<?=$product_data['in_stock'] ? 'В наличии' : 'Нет в наличии';?>
								</dd>
							</div>
						</dl>
					</div>
					
					<!-- 5. Блок доверия -->
					<div class="product-trust">
						<h3 class="product-trust-title">Гарантии качества</h3>
						<ul class="product-trust-list">
							<li class="trust-item">
								<svg class="trust-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
									<polyline points="22 4 12 14.01 9 11.01"></polyline>
								</svg>
								<span>Проверен перед отправкой</span>
							</li>
							<li class="trust-item">
								<svg class="trust-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<rect x="3" y="8" width="18" height="4" rx="1"></rect>
									<path d="M12 8v13"></path>
									<path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"></path>
									<path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"></path>
								</svg>
								<span>Гарантия <?=$product_data['warranty_days'];?> дней</span>
							</li>
							<li class="trust-item">
								<svg class="trust-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
									<circle cx="8.5" cy="8.5" r="1.5"></circle>
									<polyline points="21 15 16 10 5 21"></polyline>
								</svg>
								<span>Фото и видео по запросу</span>
							</li>
							<li class="trust-item">
								<svg class="trust-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
									<polyline points="14 2 14 8 20 8"></polyline>
									<line x1="16" y1="13" x2="8" y2="13"></line>
									<line x1="16" y1="17" x2="8" y2="17"></line>
									<polyline points="10 9 9 9 8 9"></polyline>
								</svg>
								<span>Документы прилагаются</span>
							</li>
						</ul>
					</div>
					
					<!-- 6. Совместимость (если есть данные) -->
					<?php if (!empty($product_data['category']) || !empty($product_data['subcategory'])): ?>
					<div class="product-compatibility">
						<h3 class="product-compatibility-title">Совместимость</h3>
						<div class="product-compatibility-content">
							<p class="compatibility-text">
								Подходит для автомобилей различных марок и моделей. 
								Уточните совместимость с вашим авто при запросе.
							</p>
							<button class="btn btn-link" onclick="openQuestionModal()">
								Уточнить совместимость
							</button>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</article>
			
			<!-- Описание товара (полное) -->
			<div class="product-description-section">
				<h2 class="section-title">Описание</h2>
				<div class="product-description-content" itemprop="description">
					<?php
					$text = $product_data['description'];
					$text = preg_replace('/В наличии\s*[-–—]\s*на выбор более\s*\d+шт\.?/iu', '', $text);
					$text = preg_replace('/В наличии\s*на выбор более\s*\d+шт\.?/iu', '', $text);
					$text = preg_replace('/на выбор более\s*\d+шт\.?/iu', '', $text);
					echo $text;
					?>
				</div>
			</div>
		</div>
	</section>
</main>

<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

<!-- Модальные окна перемещены в конец body для корректной работы position: fixed -->
<!-- Модальное окно запроса цены -->
<div class="modal" id="price-modal" role="dialog" aria-labelledby="price-modal-title" aria-hidden="true">
	<div class="modal-overlay" onclick="closePriceModal()"></div>
	<div class="modal-content">
		<button class="modal-close" onclick="closePriceModal()" aria-label="Закрыть">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
				<line x1="18" y1="6" x2="6" y2="18"></line>
				<line x1="6" y1="6" x2="18" y2="18"></line>
			</svg>
		</button>
		
		<div class="modal-header">
			<h2 class="modal-title" id="price-modal-title">Запросить цену</h2>
			<p class="modal-subtitle">Заполните форму, и мы свяжемся с вами в ближайшее время</p>
		</div>
		
		<form class="modal-form" id="price-form" onsubmit="submitPriceRequest(event)">
			<input type="hidden" name="product_id" id="form-product-id" value="<?=$product_data['id'];?>">
			<input type="hidden" name="product_name" id="form-product-name" value="<?=htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8');?>">
			
			<div class="form-group">
				<label for="form-name" class="form-label">Ваше имя *</label>
				<input 
					type="text" 
					id="form-name" 
					name="name" 
					class="form-input" 
					required 
					placeholder="Иван Иванов"
					autocomplete="name">
				<span class="form-error" id="error-name"></span>
			</div>
			
			<div class="form-group">
				<label for="form-phone" class="form-label">Телефон *</label>
				<input 
					type="tel" 
					id="form-phone" 
					name="phone" 
					class="form-input" 
					required 
					placeholder="+7 (777) 123-45-67"
					autocomplete="tel">
				<span class="form-error" id="error-phone"></span>
			</div>
			
			<div class="form-group">
				<label for="form-email" class="form-label">Email (необязательно)</label>
				<input 
					type="email" 
					id="form-email" 
					name="email" 
					class="form-input" 
					placeholder="example@mail.com"
					autocomplete="email">
			</div>
			
			<div class="form-group">
				<label for="form-message" class="form-label">Комментарий (необязательно)</label>
				<textarea 
					id="form-message" 
					name="message" 
					class="form-textarea" 
					rows="4"
					placeholder="Дополнительная информация..."></textarea>
			</div>
			
			<div class="form-actions">
				<button type="submit" class="btn btn-primary btn-block">
					<span class="btn-text">Отправить запрос</span>
					<span class="btn-loader" style="display: none;">
						<svg class="spinner" width="20" height="20" viewBox="0 0 24 24" fill="none">
							<circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-dasharray="31.416" stroke-dashoffset="31.416">
								<animate attributeName="stroke-dasharray" dur="2s" values="0 31.416;15.708 15.708;0 31.416;0 31.416" repeatCount="indefinite"/>
								<animate attributeName="stroke-dashoffset" dur="2s" values="0;-15.708;-31.416;-31.416" repeatCount="indefinite"/>
							</circle>
						</svg>
					</span>
				</button>
			</div>
		</form>
	</div>
</div>

<!-- Модальное окно вопроса -->
<div class="modal" id="question-modal" role="dialog" aria-labelledby="question-modal-title" aria-hidden="true">
	<div class="modal-overlay" onclick="closeQuestionModal()"></div>
	<div class="modal-content">
		<button class="modal-close" onclick="closeQuestionModal()" aria-label="Закрыть">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
				<line x1="18" y1="6" x2="6" y2="18"></line>
				<line x1="6" y1="6" x2="18" y2="18"></line>
			</svg>
		</button>
		
		<div class="modal-header">
			<h2 class="modal-title" id="question-modal-title">Задать вопрос</h2>
			<p class="modal-subtitle">Мы ответим на все ваши вопросы</p>
		</div>
		
		<form class="modal-form" id="question-form" onsubmit="submitQuestion(event)">
			<input type="hidden" name="product_id" value="<?=$product_data['id'];?>">
			<input type="hidden" name="product_name" value="<?=htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8');?>">
			
			<div class="form-group">
				<label for="question-name" class="form-label">Ваше имя *</label>
				<input type="text" id="question-name" name="name" class="form-input" required autocomplete="name">
			</div>
			
			<div class="form-group">
				<label for="question-phone" class="form-label">Телефон *</label>
				<input type="tel" id="question-phone" name="phone" class="form-input" required autocomplete="tel">
			</div>
			
			<div class="form-group">
				<label for="question-text" class="form-label">Ваш вопрос *</label>
				<textarea id="question-text" name="question" class="form-textarea" rows="5" required></textarea>
			</div>
			
			<div class="form-actions">
				<button type="submit" class="btn btn-primary btn-block">Отправить вопрос</button>
			</div>
		</form>
	</div>
</div>

<!-- Модальное окно просмотра изображения -->
<div class="modal modal-image" id="image-modal" role="dialog" aria-hidden="true">
	<div class="modal-overlay" onclick="closeImageModal()"></div>
	<div class="modal-content-image">
		<button class="modal-close" onclick="closeImageModal()" aria-label="Закрыть">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
				<line x1="18" y1="6" x2="6" y2="18"></line>
				<line x1="6" y1="6" x2="18" y2="18"></line>
			</svg>
		</button>
		<div class="image-modal-content">
			<img id="modal-image" src="" alt="">
			<button class="image-nav image-nav-prev" onclick="navigateImage(-1)" aria-label="Предыдущее">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<polyline points="15 18 9 12 15 6"></polyline>
				</svg>
			</button>
			<button class="image-nav image-nav-next" onclick="navigateImage(1)" aria-label="Следующее">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<polyline points="9 18 15 12 9 6"></polyline>
				</svg>
			</button>
		</div>
	</div>
</div>

<!-- Toast уведомления -->
<div class="toast-container" id="toast-container" aria-live="polite" aria-atomic="true"></div>

<!-- JavaScript для карточки товара -->
<script src="/assets/js/product-card.js?v=<?=time();?>&fix=6"></script>
<script>
// Передаем данные товара в JavaScript
window.productData = {
	id: <?=$product_data['id'];?>,
	name: <?=json_encode($product_name, JSON_UNESCAPED_UNICODE);?>,
	images: <?=json_encode(array_map(function($img) {
		$opt = get_optimized_image($img);
		return ['webp' => $opt['webp'] ?: $opt['original'], 'original' => $opt['original']];
	}, $all_product_images), JSON_UNESCAPED_UNICODE);?>,
	price: <?=$product_data['price'] ?: 'null';?>,
	priceFormatted: <?=$product_data['price'] ? json_encode($product_data['price_formatted'], JSON_UNESCAPED_UNICODE) : 'null';?>
};
</script>

</body>
</html>
