<?php
include('hyst/php.php');

// Получаем кластер из URL
$cluster_name = isset($_GET['cluster']) ? urldecode(trim($_GET['cluster'])) : '';
// Декодируем еще раз на случай двойного кодирования
$cluster_name = urldecode($cluster_name);

if (empty($cluster_name)) {
	header('HTTP/1.0 404 Not Found');
	include('404.php');
	exit;
}

// Загружаем функции SEO-запросов
include_once('hyst/mods/seo_queries/proces.php');

// Получаем все запросы из кластера
$stmt = $_DB_CONECT->prepare("SELECT * FROM seo_queries WHERE cluster = ? AND status = 'active' ORDER BY priority DESC, query_text ASC");
$stmt->bind_param("s", $cluster_name);
$stmt->execute();
$result = $stmt->get_result();

$queries = [];
while ($row = $result->fetch_assoc()) {
	$queries[] = $row;
}
$stmt->close();

if (count($queries) == 0) {
	header('HTTP/1.0 404 Not Found');
	include('404.php');
	exit;
}

// SEO: Оптимизированные мета-теги для кластера
$SITE_TITLE = 'Купить ' . htmlspecialchars($cluster_name, ENT_QUOTES, 'UTF-8') . ' в Алматы | Контрактные двигатели | Motor Land | Доставка по СНГ';
$SITE_DESCRIPTION = 'Каталог контрактных двигателей ' . htmlspecialchars($cluster_name, ENT_QUOTES, 'UTF-8') . ' в Алматы. Привозные моторы из Малайзии с гарантией. Большой выбор двигателей. Быстрая доставка по Казахстану и странам СНГ (Россия, Беларусь, Украина и др.).';
$SITE_KEYWORDS = mb_strtolower($cluster_name) . ', купить контрактный двигатель алматы, привозные моторы, двигатель бу малайзия, контрактные двигатели СНГ, контрактные двигатели Россия, контрактные двигатели Беларусь, доставка двигателей СНГ';
?>
<!doctype html>
<html lang="ru">
<head>
<?php include("hyst/head.php"); ?>
<link rel="canonical" href="https://motor-land.kz/query-cluster/<?=urlencode($cluster_name);?>"/>
<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
<meta property="og:type" content="website">
<meta property="og:url" content="https://motor-land.kz/query-cluster/<?=urlencode($cluster_name);?>">
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
      "name" => htmlspecialchars($cluster_name, ENT_QUOTES, 'UTF-8'),
      "item" => "https://motor-land.kz/query-cluster/" . urlencode($cluster_name)
    ]
  ]
];
echo json_encode($breadcrumb_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT | JSON_HEX_APOS);
?>
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
			<span itemprop="name"><?=htmlspecialchars($cluster_name, ENT_QUOTES, 'UTF-8');?></span>
			<meta itemprop="position" content="2" />
		</span>
		</div>
	</div>
</nav>

<section class="generalw" style="padding: 40px 0;">
	<div class="shirina">
		<h1 style="font-size: 36px; font-weight: 700; margin-bottom: 30px; color: #1a1a1a; font-family: robotob, sans-serif;">
			<?=htmlspecialchars($cluster_name, ENT_QUOTES, 'UTF-8');?>
		</h1>
		<p style="font-size: 18px; color: #666; margin-bottom: 40px;">
			Найдено запросов: <?=count($queries);?>
		</p>

		<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
			<?php foreach ($queries as $query_item): ?>
			<article class="toverblock" style="background: #ffffff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
				<a href="/query/<?=htmlspecialchars($query_item['slug'], ENT_QUOTES, 'UTF-8');?>" style="text-decoration: none; color: inherit;">
					<h3 style="font-size: 18px; font-weight: 600; margin-bottom: 10px; color: #1a1a1a; font-family: robotob, sans-serif;">
						<?=htmlspecialchars($query_item['query_text'], ENT_QUOTES, 'UTF-8');?>
					</h3>
					<?php if (!empty($query_item['meta_description'])): ?>
					<p style="font-size: 14px; color: #666; line-height: 1.6; margin-bottom: 15px;">
						<?=htmlspecialchars(mb_substr(strip_tags($query_item['meta_description']), 0, 120), ENT_QUOTES, 'UTF-8');?>...
					</p>
					<?php endif; ?>
					<span style="color: #fe0000; font-weight: 600; font-size: 14px;">Подробнее →</span>
				</a>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<br><br>
</main>

<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>
</body>
</html>

