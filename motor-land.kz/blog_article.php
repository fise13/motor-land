<?php
// Включаем обработку ошибок для отладки
error_reporting(E_ALL);
ini_set('display_errors', 0); // Не показываем ошибки пользователям, но логируем
ini_set('log_errors', 1);
ini_set('error_log', $_SERVER['DOCUMENT_ROOT'] . '/logs/php_errors.log');

// Начинаем буферизацию вывода для перехвата ошибок
ob_start();

try {
	include('hyst/php.php');
	
	// Загружаем функции блога
	if (!function_exists('get_blog_article')) {
		include_once('hyst/mods/blog/proces.php');
	}
	
	// Проверяем, что функция загружена
	if (!function_exists('get_blog_article')) {
		throw new Exception('Функция get_blog_article не найдена');
	}
} catch (Exception $e) {
	error_log('Blog article initialization error: ' . $e->getMessage());
	ob_end_clean();
	header('HTTP/1.0 500 Internal Server Error');
	die('Ошибка инициализации. Пожалуйста, попробуйте позже.');
}

// Получаем slug из URL
$article_slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if (empty($article_slug)) {
	ob_end_clean();
	header('HTTP/1.0 404 Not Found');
	include('404.php');
	exit;
}

// Получаем статью по slug
try {
	if (!function_exists('get_blog_article')) {
		throw new Exception('Функция get_blog_article не определена');
	}
	
	$article = get_blog_article($article_slug);
	
	if (!$article || !is_array($article)) {
		ob_end_clean();
		header('HTTP/1.0 404 Not Found');
		include('404.php');
		exit;
	}
} catch (Exception $e) {
	error_log('Blog article error: ' . $e->getMessage() . ' | Slug: ' . $article_slug . ' | Trace: ' . $e->getTraceAsString());
	ob_end_clean();
	header('HTTP/1.0 500 Internal Server Error');
	include('404.php');
	exit;
} catch (Error $e) {
	error_log('Blog article fatal error: ' . $e->getMessage() . ' | Slug: ' . $article_slug . ' | Trace: ' . $e->getTraceAsString());
	ob_end_clean();
	header('HTTP/1.0 500 Internal Server Error');
	include('404.php');
	exit;
}

// SEO: Оптимизированные мета-теги для статьи
// Защита от ошибок при отсутствии данных
$SITE_TITLE = (!empty($article['title']) ? htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') : 'Статья') . ' | Блог | Моторленд';
$SITE_DESCRIPTION = !empty($article['description']) ? htmlspecialchars($article['description'], ENT_QUOTES, 'UTF-8') : 'Статья в блоге Motor Land';
$SITE_KEYWORDS = !empty($article['keywords']) ? htmlspecialchars($article['keywords'], ENT_QUOTES, 'UTF-8') : 'блог контрактные двигатели, статьи о двигателях';
?>
<!doctype html>
<html lang="ru">
<head>
<?php include("hyst/head.php"); ?>
<!-- SEO: Canonical URL -->
<link rel="canonical" href="https://motor-land.kz/blog/<?=!empty($article['slug']) ? htmlspecialchars($article['slug'], ENT_QUOTES, 'UTF-8') : '';?>"/>
<!-- SEO: Meta keywords -->
<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
<!-- SEO: Open Graph для статьи -->
<meta property="og:type" content="article">
<meta property="og:url" content="https://motor-land.kz/blog/<?=!empty($article['slug']) ? htmlspecialchars($article['slug'], ENT_QUOTES, 'UTF-8') : '';?>">
<meta property="og:title" content="<?=$SITE_TITLE;?>">
<meta property="og:description" content="<?=$SITE_DESCRIPTION;?>">
<meta property="og:image" content="https://motor-land.kz<?=!empty($article['image']) ? htmlspecialchars($article['image'], ENT_QUOTES, 'UTF-8') : '/img/logo.webp';?>">
<meta property="article:published_time" content="<?=!empty($article['date']) ? htmlspecialchars($article['date'], ENT_QUOTES, 'UTF-8') : date('Y-m-d H:i:s');?>">
<meta property="article:modified_time" content="<?=!empty($article['date_modified']) ? htmlspecialchars($article['date_modified'], ENT_QUOTES, 'UTF-8') : date('Y-m-d H:i:s');?>">
<meta property="article:author" content="<?=!empty($article['author']) ? htmlspecialchars($article['author'], ENT_QUOTES, 'UTF-8') : 'Motor Land';?>">
<meta property="article:section" content="<?=!empty($article['category']) ? htmlspecialchars($article['category'], ENT_QUOTES, 'UTF-8') : 'Общее';?>">
<!-- SEO: Twitter Cards -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
<meta name="twitter:image" content="https://motor-land.kz<?=!empty($article['image']) ? htmlspecialchars($article['image'], ENT_QUOTES, 'UTF-8') : '/img/logo.webp';?>">
<!-- SEO: BreadcrumbList -->
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
      "name" => "Блог",
      "item" => "https://motor-land.kz/blog"
    ],
    [
      "@type" => "ListItem",
      "position" => 3,
      "name" => !empty($article['title']) ? $article['title'] : 'Статья',
      "item" => "https://motor-land.kz/blog/" . (!empty($article['slug']) ? $article['slug'] : '')
    ]
  ]
];
echo json_encode($breadcrumb_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT | JSON_HEX_APOS);
?>
</script>
<!-- SEO: Article Schema.org -->
<script type="application/ld+json">
<?php
$article_data = [
  "@context" => "https://schema.org",
  "@type" => "BlogPosting",
  "headline" => !empty($article['title']) ? $article['title'] : 'Статья',
  "description" => !empty($article['description']) ? $article['description'] : 'Статья в блоге Motor Land',
  "image" => "https://motor-land.kz" . (!empty($article['image']) ? $article['image'] : '/img/logo.webp'),
  "datePublished" => !empty($article['date']) ? $article['date'] : date('Y-m-d H:i:s'),
  "dateModified" => !empty($article['date_modified']) ? $article['date_modified'] : date('Y-m-d H:i:s'),
  "author" => [
    "@type" => "Organization",
    "name" => !empty($article['author']) ? $article['author'] : 'Motor Land',
    "url" => "https://motor-land.kz"
  ],
  "publisher" => [
    "@type" => "Organization",
    "name" => "Motor Land",
    "logo" => [
      "@type" => "ImageObject",
      "url" => "https://motor-land.kz/img/logo.webp"
    ]
  ],
  "mainEntityOfPage" => [
    "@type" => "WebPage",
    "@id" => "https://motor-land.kz/blog/" . (!empty($article['slug']) ? $article['slug'] : '')
  ]
];
echo json_encode($article_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_QUOT | JSON_HEX_APOS);
?>
</script>
</head>
<body>
<?php 
// Очищаем буфер перед выводом контента
ob_end_flush();
try {
	include("hyst/sbody.php"); 
	include("des/head.php");
} catch (Exception $e) {
	error_log('Blog article includes error: ' . $e->getMessage());
}
?>
<!-- SEO: Семантический тег <main> -->
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
			<a href="/blog" itemprop="item"><span itemprop="name">Блог</span></a>
			<meta itemprop="position" content="2" />
		</span> / 
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<span itemprop="name"><?=!empty($article['title']) ? htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') : 'Статья';?></span>
			<meta itemprop="position" content="3" />
		</span>
		</div>
	</div>
</nav>

<!-- SEO: Семантический тег <article> для статьи -->
<article class="blog-article-section" itemscope itemtype="https://schema.org/BlogPosting">
	<div class="shirina">
		<div class="blog-article-container">
			
			<!-- Заголовок статьи -->
			<header class="blog-article-header">
				<div class="blog-article-meta">
					<span class="blog-article-category"><?=!empty($article['category']) ? htmlspecialchars($article['category'], ENT_QUOTES, 'UTF-8') : 'Общее';?></span>
					<time datetime="<?=!empty($article['date']) ? htmlspecialchars($article['date'], ENT_QUOTES, 'UTF-8') : date('Y-m-d H:i:s');?>" class="blog-article-date" itemprop="datePublished"><?=!empty($article['date']) ? date('d.m.Y', strtotime($article['date'])) : date('d.m.Y');?></time>
					<span class="blog-article-read-time"><?=!empty($article['read_time']) ? htmlspecialchars($article['read_time'], ENT_QUOTES, 'UTF-8') : '5 мин';?> чтения</span>
				</div>
				<h1 class="blog-article-title" itemprop="headline"><?=!empty($article['title']) ? htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') : 'Статья';?></h1>
				<p class="blog-article-description" itemprop="description"><?=!empty($article['description']) ? htmlspecialchars($article['description'], ENT_QUOTES, 'UTF-8') : '';?></p>
				
				<!-- Автор статьи (E-E-A-T) -->
				<div class="blog-article-author" itemprop="author" itemscope itemtype="https://schema.org/Organization">
					<div class="blog-author-avatar">
						<img src="/img/logo.webp" alt="Motor Land" itemprop="logo">
					</div>
					<div class="blog-author-info">
						<span class="blog-author-name" itemprop="name"><?=!empty($article['author']) ? htmlspecialchars($article['author'], ENT_QUOTES, 'UTF-8') : 'Motor Land';?></span>
						<p class="blog-author-bio" itemprop="description"><?=!empty($article['author_bio']) ? htmlspecialchars($article['author_bio'], ENT_QUOTES, 'UTF-8') : '';?></p>
					</div>
				</div>
			</header>
			
			<!-- Изображение статьи -->
			<?php if (!empty($article['image'])): ?>
			<div class="blog-article-image">
				<img src="<?=htmlspecialchars($article['image'], ENT_QUOTES, 'UTF-8');?>" alt="<?=!empty($article['title']) ? htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') : 'Статья';?>" itemprop="image" loading="eager">
			</div>
			<?php endif; ?>
			
			<!-- Видео статьи -->
			<?php if (!empty($article['video'])): ?>
			<div class="blog-video-wrapper">
				<?php
				// Определяем тип видео и формируем iframe
				$video_url = trim($article['video']);
				$video_embed = '';
				
				try {
					if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
						// YouTube
						if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $video_url, $matches)) {
							if (!empty($matches[1])) {
								$video_id = htmlspecialchars($matches[1], ENT_QUOTES, 'UTF-8');
								$video_embed = '<iframe src="https://www.youtube.com/embed/'.$video_id.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="blog-video-iframe"></iframe>';
							}
						}
					} else if (strpos($video_url, 'vimeo.com') !== false) {
						// Vimeo
						if (preg_match('/vimeo\.com\/(\d+)/', $video_url, $matches)) {
							if (!empty($matches[1])) {
								$video_id = htmlspecialchars($matches[1], ENT_QUOTES, 'UTF-8');
								$video_embed = '<iframe src="https://player.vimeo.com/video/'.$video_id.'" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen class="blog-video-iframe"></iframe>';
							}
						}
					} else {
						// Прямая ссылка на видео
						$video_url_escaped = htmlspecialchars($video_url, ENT_QUOTES, 'UTF-8');
						$video_embed = '<video controls class="blog-video-direct"><source src="'.$video_url_escaped.'" type="video/mp4">Ваш браузер не поддерживает видео.</video>';
					}
					
					if (!empty($video_embed)) {
						echo $video_embed;
					}
				} catch (Exception $e) {
					// В случае ошибки просто не выводим видео
					error_log('Blog video error: ' . $e->getMessage());
				}
				?>
			</div>
			<?php endif; ?>
			
			<!-- Содержание статьи -->
			<div class="blog-article-content" itemprop="articleBody">
				<?=!empty($article['content']) ? $article['content'] : '<p>Содержание статьи отсутствует.</p>';?>
			</div>
			
			<!-- Кнопки действий -->
			<div class="blog-article-actions">
				<a href="/catalog" class="blog-action-btn blog-action-btn-primary">Перейти в каталог</a>
				<a href="/contacts" class="blog-action-btn blog-action-btn-secondary">Связаться с нами</a>
			</div>
			
			<!-- Связанные статьи -->
			<?php
			try {
				$category = !empty($article['category']) ? $article['category'] : 'Общее';
				$related_articles = get_blog_articles(3, $category, 'published');
				// Убираем текущую статью из списка
				if (!empty($article['id'])) {
					$related_articles = array_filter($related_articles, function($item) use ($article) {
						return isset($item['id']) && $item['id'] != $article['id'];
					});
				}
				$related_articles = array_slice($related_articles, 0, 3);
			} catch (Exception $e) {
				error_log('Blog related articles error: ' . $e->getMessage());
				$related_articles = [];
			}
			?>
			<?php if (count($related_articles) > 0): ?>
			<div class="blog-related-articles">
				<h3 class="blog-related-title">Похожие статьи</h3>
				<div class="blog-related-grid">
					<?php foreach ($related_articles as $related): ?>
					<article class="blog-card">
						<a href="/blog/<?=$related['slug'];?>" class="blog-card-link">
							<div class="blog-card-image">
								<img src="<?=!empty($related['image']) ? $related['image'] : '/img/logo.webp';?>" alt="<?=htmlspecialchars($related['title'], ENT_QUOTES, 'UTF-8');?>" loading="lazy">
								<div class="blog-card-category"><?=htmlspecialchars($related['category'], ENT_QUOTES, 'UTF-8');?></div>
							</div>
							<div class="blog-card-content">
								<time datetime="<?=$related['date'];?>" class="blog-card-date"><?=date('d.m.Y', strtotime($related['date']));?></time>
								<h2 class="blog-card-title"><?=htmlspecialchars($related['title'], ENT_QUOTES, 'UTF-8');?></h2>
								<p class="blog-card-excerpt"><?=htmlspecialchars(mb_substr(strip_tags($related['description']), 0, 100) . '...', ENT_QUOTES, 'UTF-8');?></p>
								<div class="blog-card-meta">
									<span class="blog-card-read-time"><?=htmlspecialchars($related['read_time'], ENT_QUOTES, 'UTF-8');?> чтения</span>
									<span class="blog-card-arrow">→</span>
								</div>
							</div>
						</a>
					</article>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>
			
		</div>
	</div>
</article>

<br><br>
</main>

<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

</body>
</html>

