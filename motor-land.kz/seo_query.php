<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

if (ob_get_level() == 0) {
	ob_start();
}

try {
	include('hyst/php.php');
	
	if (!isset($INTERFACE_VERSION)) {
		$INTERFACE_VERSION = 0.91;
	}
	
	if (!function_exists('get_seo_query')) {
		include_once('hyst/mods/seo_queries/proces.php');
	}
	
	if (!function_exists('get_seo_query')) {
		throw new Exception('Функция get_seo_query не найдена');
	}
} catch (Exception $e) {
	error_log('SEO query initialization error: ' . $e->getMessage());
	if (ob_get_level()) {
		ob_end_clean();
	}
	header('HTTP/1.0 500 Internal Server Error');
	die('Ошибка инициализации. Пожалуйста, попробуйте позже.');
} catch (Error $e) {
	error_log('SEO query fatal error: ' . $e->getMessage());
	if (ob_get_level()) {
		ob_end_clean();
	}
	header('HTTP/1.0 500 Internal Server Error');
	die('Ошибка инициализации. Пожалуйста, попробуйте позже.');
}

$query_slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if (empty($query_slug)) {
	if (ob_get_level()) {
		ob_end_clean();
	}
	header('HTTP/1.0 404 Not Found');
	include('404.php');
	exit;
}

try {
	if (!function_exists('get_seo_query')) {
		throw new Exception('Функция get_seo_query не определена');
	}
	
	$query = get_seo_query($query_slug);
	
	if (!$query || !is_array($query)) {
		if (ob_get_level()) {
			ob_end_clean();
		}
		header('HTTP/1.0 404 Not Found');
		include('404.php');
		exit;
	}
} catch (Exception $e) {
	error_log('SEO query error: ' . $e->getMessage() . ' | Slug: ' . $query_slug);
	if (ob_get_level()) {
		ob_end_clean();
	}
	header('HTTP/1.0 500 Internal Server Error');
	include('404.php');
	exit;
} catch (Error $e) {
	error_log('SEO query fatal error: ' . $e->getMessage() . ' | Slug: ' . $query_slug);
	if (ob_get_level()) {
		ob_end_clean();
	}
	header('HTTP/1.0 500 Internal Server Error');
	include('404.php');
	exit;
}

$SITE_TITLE = !empty($query['meta_title']) ? htmlspecialchars($query['meta_title'], ENT_QUOTES, 'UTF-8') : (!empty($query['query_text']) ? htmlspecialchars($query['query_text'], ENT_QUOTES, 'UTF-8') . ' | Motor Land | Доставка по СНГ' : 'Запрос | Motor Land | Доставка по СНГ');
$SITE_DESCRIPTION = !empty($query['meta_description']) ? htmlspecialchars($query['meta_description'], ENT_QUOTES, 'UTF-8') : 'Контрактные двигатели в Алматы. Доставка по Казахстану и странам СНГ.';
$SITE_KEYWORDS = !empty($query['meta_keywords']) ? htmlspecialchars($query['meta_keywords'], ENT_QUOTES, 'UTF-8') : 'контрактные двигатели, двигатель бу, контрактные двигатели СНГ, доставка двигателей СНГ';
?>
<!doctype html>
<html lang="ru">
<head>
<?php 
if (!isset($INTERFACE_VERSION)) {
	$INTERFACE_VERSION = 0.91;
}
include("hyst/head.php"); 
?>
<link rel="stylesheet" href="/css.css?<?=$INTERFACE_VERSION;?>" type="text/css"/>
<link rel="stylesheet" href="/tab.css?<?=$INTERFACE_VERSION;?>" type="text/css" media="(min-width: 768px)" />
<link rel="stylesheet" href="/mob.css?<?=$INTERFACE_VERSION;?>" type="text/css" media="(max-width: 767px)" />
<link rel="canonical" href="https://motor-land.kz/query/<?=!empty($query['slug']) ? htmlspecialchars($query['slug'], ENT_QUOTES, 'UTF-8') : '';?>"/>
<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
<meta property="og:type" content="website">
<meta property="og:url" content="https://motor-land.kz/query/<?=!empty($query['slug']) ? htmlspecialchars($query['slug'], ENT_QUOTES, 'UTF-8') : '';?>">
<meta property="og:title" content="<?=$SITE_TITLE;?>">
<meta property="og:description" content="<?=$SITE_DESCRIPTION;?>">
<meta property="og:image" content="https://motor-land.kz/img/logo.webp">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:site_name" content="Motor Land">
<meta property="og:locale" content="ru_RU">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
<meta name="twitter:image" content="https://motor-land.kz/img/logo.webp">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
<meta name="twitter:image" content="https://motor-land.kz/img/logo.webp">
<script type="application/ld+json">
<?php
$breadcrumb_data = [
  "@context" => "https://schema.org",
  "@type" => "BreadcrumbList",
  "itemListElement" => [
    [
      "@type" => "ListItem",
      "position" => 1,
      "name" => "Главная",
      "item" => "https://motor-land.kz/"
    ],
    [
      "@type" => "ListItem",
      "position" => 2,
      "name" => !empty($query['cluster']) ? htmlspecialchars($query['cluster'], ENT_QUOTES, 'UTF-8') : 'Каталог',
      "item" => "https://motor-land.kz/query-cluster/" . (!empty($query['cluster']) ? urlencode($query['cluster']) : '')
    ],
    [
      "@type" => "ListItem",
      "position" => 3,
      "name" => !empty($query['query_text']) ? htmlspecialchars($query['query_text'], ENT_QUOTES, 'UTF-8') : 'Запрос',
      "item" => "https://motor-land.kz/query/" . (!empty($query['slug']) ? $query['slug'] : '')
    ]
  ]
];
echo json_encode($breadcrumb_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT | JSON_HEX_APOS);
?>
</script>
</head>
<body>
<?php 
while (ob_get_level() > 0) {
	ob_end_flush();
}
try {
	include("hyst/sbody.php"); 
	include("des/head.php");
} catch (Exception $e) {
	error_log('SEO query includes error: ' . $e->getMessage());
}
?>
<main>
<br><br>
<nav class="generalw" aria-label="Навигационная цепочка">
	<div class="shirina">
		<div class="crumbsblock" itemscope itemtype="https://schema.org/BreadcrumbList">
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<a href="/" itemprop="item"><span itemprop="name">Главная</span></a>
			<meta itemprop="position" content="1" />
		</span> /
		<?php if (!empty($query['cluster'])): ?>
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<a href="/query-cluster/<?=urlencode($query['cluster']);?>" itemprop="item"><span itemprop="name"><?=htmlspecialchars($query['cluster'], ENT_QUOTES, 'UTF-8');?></span></a>
			<meta itemprop="position" content="2" />
		</span> /
		<?php endif; ?>
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<span itemprop="name"><?=!empty($query['query_text']) ? htmlspecialchars($query['query_text'], ENT_QUOTES, 'UTF-8') : 'Запрос';?></span>
			<meta itemprop="position" content="<?=!empty($query['cluster']) ? '3' : '2';?>" />
		</span>
		</div>
	</div>
</nav>

<article class="blog-article-section" itemscope itemtype="https://schema.org/WebPage">
	<div class="blog-article-container">
		<header class="blog-article-header">
			<h1 class="blog-article-title" itemprop="name"><?=!empty($query['h1_text']) ? htmlspecialchars($query['h1_text'], ENT_QUOTES, 'UTF-8') : (!empty($query['query_text']) ? htmlspecialchars($query['query_text'], ENT_QUOTES, 'UTF-8') : 'Запрос');?></h1>
			<?php if (!empty($query['cluster'])): ?>
			<div class="blog-article-meta">
				<span class="blog-article-category"><?=htmlspecialchars($query['cluster'], ENT_QUOTES, 'UTF-8');?></span>
			</div>
			<?php endif; ?>
		</header>

		<div class="blog-article-content" itemprop="mainContentOfPage">
			<?=!empty($query['content']) ? $query['content'] : '<p>Содержание страницы отсутствует.</p>';?>
		</div>

		<div class="blog-article-actions">
			<a href="/catalog" class="blog-action-btn blog-action-btn-primary">Перейти в каталог</a>
			<a href="/contacts" class="blog-action-btn blog-action-btn-secondary">Связаться с нами</a>
		</div>
	</div>
</article>

<br><br>
</main>

<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

</body>
</html>

