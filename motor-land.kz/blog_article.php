<?php
include('hyst/php.php');

// Загружаем функции блога
include_once('hyst/mods/blog/proces.php');

// Получаем slug из URL
$article_slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if (empty($article_slug)) {
	header('HTTP/1.0 404 Not Found');
	include('404.php');
	exit;
}

// Получаем статью по slug
$article = get_blog_article($article_slug);

if (!$article) {
	header('HTTP/1.0 404 Not Found');
	include('404.php');
	exit;
}

// SEO: Оптимизированные мета-теги для статьи
$SITE_TITLE = htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') . ' | Блог | Моторленд';
$SITE_DESCRIPTION = htmlspecialchars($article['description'], ENT_QUOTES, 'UTF-8');
$SITE_KEYWORDS = !empty($article['keywords']) ? htmlspecialchars($article['keywords'], ENT_QUOTES, 'UTF-8') : 'блог контрактные двигатели, статьи о двигателях';
?>
<!doctype html>
<html lang="ru">
<head>
<?php include("hyst/head.php"); ?>
<!-- SEO: Canonical URL -->
<link rel="canonical" href="https://motor-land.kz/blog/<?=$article['slug'];?>"/>
<!-- SEO: Meta keywords -->
<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
<!-- SEO: Open Graph для статьи -->
<meta property="og:type" content="article">
<meta property="og:url" content="https://motor-land.kz/blog/<?=$article['slug'];?>">
<meta property="og:title" content="<?=$SITE_TITLE;?>">
<meta property="og:description" content="<?=$SITE_DESCRIPTION;?>">
<meta property="og:image" content="https://motor-land.kz<?=!empty($article['image']) ? $article['image'] : '/img/logo.webp';?>">
<meta property="article:published_time" content="<?=$article['date'];?>">
<meta property="article:modified_time" content="<?=$article['date_modified'];?>">
<meta property="article:author" content="<?=htmlspecialchars($article['author'], ENT_QUOTES, 'UTF-8');?>">
<meta property="article:section" content="<?=htmlspecialchars($article['category'], ENT_QUOTES, 'UTF-8');?>">
<!-- SEO: Twitter Cards -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
<meta name="twitter:image" content="https://motor-land.kz<?=!empty($article['image']) ? $article['image'] : '/img/logo.webp';?>">
<!-- SEO: BreadcrumbList -->
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
    "name": "Блог",
    "item": "https://motor-land.kz/blog"
  }, {
    "@type": "ListItem",
    "position": 3,
    "name": "<?=htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8');?>",
    "item": "https://motor-land.kz/blog/<?=$article['slug'];?>"
  }]
}
</script>
<!-- SEO: Article Schema.org -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "<?=htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8');?>",
  "description": "<?=htmlspecialchars($article['description'], ENT_QUOTES, 'UTF-8');?>",
  "image": "https://motor-land.kz<?=!empty($article['image']) ? $article['image'] : '/img/logo.webp';?>",
  "datePublished": "<?=$article['date'];?>",
  "dateModified": "<?=$article['date_modified'];?>",
  "author": {
    "@type": "Organization",
    "name": "<?=htmlspecialchars($article['author'], ENT_QUOTES, 'UTF-8');?>",
    "url": "https://motor-land.kz"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Motor Land",
    "logo": {
      "@type": "ImageObject",
      "url": "https://motor-land.kz/img/logo.webp"
    }
  },
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "https://motor-land.kz/blog/<?=$article['slug'];?>"
  }
}
</script>
</head>
<body>
<?php include("hyst/sbody.php"); ?>
<?php include("des/head.php"); ?>
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
			<span itemprop="name"><?=htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8');?></span>
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
					<span class="blog-article-category"><?=htmlspecialchars($article['category'], ENT_QUOTES, 'UTF-8');?></span>
					<time datetime="<?=$article['date'];?>" class="blog-article-date" itemprop="datePublished"><?=date('d.m.Y', strtotime($article['date']));?></time>
					<span class="blog-article-read-time"><?=htmlspecialchars($article['read_time'], ENT_QUOTES, 'UTF-8');?> чтения</span>
				</div>
				<h1 class="blog-article-title" itemprop="headline"><?=htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8');?></h1>
				<p class="blog-article-description" itemprop="description"><?=htmlspecialchars($article['description'], ENT_QUOTES, 'UTF-8');?></p>
				
				<!-- Автор статьи (E-E-A-T) -->
				<div class="blog-article-author" itemprop="author" itemscope itemtype="https://schema.org/Organization">
					<div class="blog-author-avatar">
						<img src="/img/logo.webp" alt="Motor Land" itemprop="logo">
					</div>
					<div class="blog-author-info">
						<span class="blog-author-name" itemprop="name"><?=htmlspecialchars($article['author'], ENT_QUOTES, 'UTF-8');?></span>
						<p class="blog-author-bio" itemprop="description"><?=htmlspecialchars($article['author_bio'], ENT_QUOTES, 'UTF-8');?></p>
					</div>
				</div>
			</header>
			
			<!-- Изображение статьи -->
			<?php if (!empty($article['image'])): ?>
			<div class="blog-article-image">
				<img src="<?=$article['image'];?>" alt="<?=htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8');?>" itemprop="image" loading="eager">
			</div>
			<?php endif; ?>
			
			<!-- Видео статьи -->
			<?php if (!empty($article['video'])): ?>
			<div class="blog-video-wrapper">
				<?php
				// Определяем тип видео и формируем iframe
				$video_url = $article['video'];
				if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
					// YouTube
					preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $video_url, $matches);
					if (!empty($matches[1])) {
						$video_id = $matches[1];
						echo '<iframe src="https://www.youtube.com/embed/'.$video_id.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
					}
				} else if (strpos($video_url, 'vimeo.com') !== false) {
					// Vimeo
					preg_match('/vimeo\.com\/(\d+)/', $video_url, $matches);
					if (!empty($matches[1])) {
						$video_id = $matches[1];
						echo '<iframe src="https://player.vimeo.com/video/'.$video_id.'" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
					}
				} else {
					// Прямая ссылка на видео
					echo '<video controls><source src="'.$video_url.'" type="video/mp4">Ваш браузер не поддерживает видео.</video>';
				}
				?>
			</div>
			<?php endif; ?>
			
			<!-- Содержание статьи -->
			<div class="blog-article-content" itemprop="articleBody">
				<?=$article['content'];?>
			</div>
			
			<!-- Кнопки действий -->
			<div class="blog-article-actions">
				<a href="/catalog" class="blog-action-btn blog-action-btn-primary">Перейти в каталог</a>
				<a href="/contacts" class="blog-action-btn blog-action-btn-secondary">Связаться с нами</a>
			</div>
			
			<!-- Связанные статьи -->
			<?php
			$related_articles = get_blog_articles(3, $article['category'], 'published');
			// Убираем текущую статью из списка
			$related_articles = array_filter($related_articles, function($item) use ($article) {
				return $item['id'] != $article['id'];
			});
			$related_articles = array_slice($related_articles, 0, 3);
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

