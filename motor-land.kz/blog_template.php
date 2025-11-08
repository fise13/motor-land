<?php
include('hyst/php.php');

// SEO: Шаблон для статей блога
// Использование: blog/[slug].php или через роутинг

// Пример данных статьи (в реальности будут загружаться из БД)
$article_slug = isset($_GET['slug']) ? $_GET['slug'] : '';

// Массив статей (в реальности будет загрузка из БД)
$articles_db = [
    'chto-takoe-kontraktnyj-dvigatel' => [
        'id' => 1,
        'slug' => 'chto-takoe-kontraktnyj-dvigatel',
        'title' => 'Что такое контрактный двигатель и в чем его преимущества',
        'description' => 'Подробное объяснение что такое контрактный двигатель, откуда он берется, какие у него преимущества и недостатки. Сравнение с новыми двигателями.',
        'content' => '', // Контент будет загружаться из БД или файла
        'image' => '/img/blog/contract-engine.jpg',
        'date' => '2025-01-15',
        'date_modified' => '2025-01-15',
        'category' => 'Общее',
        'read_time' => '8 мин',
        'author' => 'Motor Land',
        'author_bio' => 'Эксперты компании Motor Land с более чем 10-летним опытом работы с контрактными двигателями.',
        'keywords' => 'что такое контрактный двигатель, контрактный двигатель что это, преимущества контрактного двигателя'
    ],
    'kak-vybrat-kontraktnyj-dvigatel' => [
        'id' => 2,
        'slug' => 'kak-vybrat-kontraktnyj-dvigatel',
        'title' => 'Как выбрать контрактный двигатель: полное руководство',
        'description' => 'Пошаговое руководство по выбору контрактного двигателя. Как проверить состояние, на что обратить внимание, как избежать проблем.',
        'content' => '',
        'image' => '/img/blog/choose-engine.jpg',
        'date' => '2025-01-10',
        'date_modified' => '2025-01-10',
        'category' => 'Советы',
        'read_time' => '12 мин',
        'author' => 'Motor Land',
        'author_bio' => 'Эксперты компании Motor Land с более чем 10-летним опытом работы с контрактными двигателями.',
        'keywords' => 'как выбрать контрактный двигатель, выбор контрактного двигателя, проверка контрактного двигателя'
    ]
];

// Получаем статью по slug
$article = isset($articles_db[$article_slug]) ? $articles_db[$article_slug] : null;

if (!$article) {
    // Если статья не найдена, перенаправляем на страницу блога
    header('Location: /blog');
    exit;
}

// SEO: Оптимизированные мета-теги для статьи
$SITE_TITLE = $article['title'] . ' | Блог | Моторленд';
$SITE_DESCRIPTION = $article['description'];
$SITE_KEYWORDS = $article['keywords'];
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
<meta property="og:image" content="https://motor-land.kz<?=$article['image'];?>">
<meta property="article:published_time" content="<?=$article['date'];?>">
<meta property="article:modified_time" content="<?=$article['date_modified'];?>">
<meta property="article:author" content="<?=$article['author'];?>">
<meta property="article:section" content="<?=$article['category'];?>">
<!-- SEO: Twitter Cards -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
<meta name="twitter:image" content="https://motor-land.kz<?=$article['image'];?>">
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
    "name": "<?=$article['title'];?>",
    "item": "https://motor-land.kz/blog/<?=$article['slug'];?>"
  }]
}
</script>
<!-- SEO: Article Schema.org -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "<?=$article['title'];?>",
  "description": "<?=$article['description'];?>",
  "image": "https://motor-land.kz<?=$article['image'];?>",
  "datePublished": "<?=$article['date'];?>",
  "dateModified": "<?=$article['date_modified'];?>",
  "author": {
    "@type": "Organization",
    "name": "<?=$article['author'];?>",
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
			<span itemprop="name"><?=$article['title'];?></span>
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
					<span class="blog-article-category"><?=$article['category'];?></span>
					<time datetime="<?=$article['date'];?>" class="blog-article-date" itemprop="datePublished"><?=date('d.m.Y', strtotime($article['date']));?></time>
					<span class="blog-article-read-time"><?=$article['read_time'];?> чтения</span>
				</div>
				<h1 class="blog-article-title" itemprop="headline"><?=$article['title'];?></h1>
				<p class="blog-article-description" itemprop="description"><?=$article['description'];?></p>
				
				<!-- Автор статьи (E-E-A-T) -->
				<div class="blog-article-author" itemprop="author" itemscope itemtype="https://schema.org/Organization">
					<div class="blog-author-avatar">
						<img src="/img/logo.webp" alt="Motor Land" itemprop="logo">
					</div>
					<div class="blog-author-info">
						<span class="blog-author-name" itemprop="name"><?=$article['author'];?></span>
						<p class="blog-author-bio" itemprop="description"><?=$article['author_bio'];?></p>
					</div>
				</div>
			</header>
			
			<!-- Изображение статьи -->
			<div class="blog-article-image">
				<img src="<?=$article['image'];?>" alt="<?=htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8');?>" itemprop="image" loading="eager">
			</div>
			
			<!-- Содержание статьи -->
			<div class="blog-article-content" itemprop="articleBody">
				<!-- Контент статьи будет здесь -->
				<!-- Пример структуры контента с таблицами, списками, цитатами -->
				
				<!-- Введение -->
				<section class="blog-content-section">
					<h2>Введение</h2>
					<p>Здесь будет вступительный текст статьи...</p>
				</section>
				
				<!-- Основной контент -->
				<section class="blog-content-section">
					<h2>Основной раздел</h2>
					<p>Основной контент статьи с полезной информацией...</p>
					
					<!-- Таблица -->
					<div class="blog-table-wrapper">
						<table class="blog-table">
							<caption>Сравнение контрактных и новых двигателей</caption>
							<thead>
								<tr>
									<th>Параметр</th>
									<th>Контрактный двигатель</th>
									<th>Новый двигатель</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Стоимость</td>
									<td>Низкая</td>
									<td>Высокая</td>
								</tr>
								<tr>
									<td>Качество</td>
									<td>Оригинальное</td>
									<td>Оригинальное</td>
								</tr>
								<tr>
									<td>Гарантия</td>
									<td>3-25 дней</td>
									<td>1-2 года</td>
								</tr>
							</tbody>
						</table>
					</div>
					
					<!-- Цитата -->
					<blockquote class="blog-quote">
						<p>"Контрактные двигатели - отличная альтернатива новым, особенно для автомобилей старше 5 лет."</p>
						<cite>— Эксперт Motor Land</cite>
					</blockquote>
					
					<!-- Список -->
					<h3>Преимущества контрактных двигателей:</h3>
					<ul class="blog-list">
						<li>Значительно ниже стоимость</li>
						<li>Оригинальное качество от производителя</li>
						<li>Полная совместимость с вашим автомобилем</li>
						<li>Экономия времени и денег</li>
					</ul>
					
				</section>
				
				<!-- Заключение -->
				<section class="blog-content-section">
					<h2>Заключение</h2>
					<p>Заключительный текст статьи с выводами...</p>
				</section>
				
			</div>
			
			<!-- Кнопки действий -->
			<div class="blog-article-actions">
				<a href="/catalog" class="blog-action-btn blog-action-btn-primary">Перейти в каталог</a>
				<a href="/contacts" class="blog-action-btn blog-action-btn-secondary">Связаться с нами</a>
			</div>
			
			<!-- Связанные статьи -->
			<div class="blog-related-articles">
				<h3 class="blog-related-title">Похожие статьи</h3>
				<div class="blog-related-grid">
					<!-- Похожие статьи будут здесь -->
				</div>
			</div>
			
		</div>
	</div>
</article>

<br><br>
</main>

<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

</body>
</html>

