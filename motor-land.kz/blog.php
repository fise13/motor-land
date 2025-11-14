<?php
include('hyst/php.php');

// SEO: Оптимизированные мета-теги для страницы блога
$SITE_TITLE = 'Блог о Контрактных Двигателях | Полезные Статьи | Моторленд';
$SITE_DESCRIPTION = 'Полезные статьи о контрактных двигателях, советы по выбору, установке и обслуживанию. Экспертные материалы от специалистов Motor Land.';
$SITE_KEYWORDS = 'блог контрактные двигатели, статьи о двигателях, как выбрать контрактный двигатель, установка контрактного двигателя, что такое контрактный двигатель';

// Загружаем функции блога
include_once('hyst/mods/blog/proces.php');

// Получаем список опубликованных статей из базы данных
$blog_articles = get_blog_articles();

// Формируем excerpt из description если нет отдельного поля
foreach ($blog_articles as &$article) {
	if (empty($article['excerpt'])) {
		$article['excerpt'] = mb_substr(strip_tags($article['description']), 0, 150) . '...';
	}
	// Если нет изображения, используем дефолтное
	if (empty($article['image'])) {
		$article['image'] = '/img/logo.webp';
	}
}
unset($article);
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
<!-- SEO: Canonical URL -->
<link rel="canonical" href="https://motor-land.kz/blog"/>
<!-- SEO: Meta keywords -->
<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
<!-- SEO: Open Graph -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://motor-land.kz/blog">
<meta property="og:title" content="<?=$SITE_TITLE;?>">
<meta property="og:description" content="<?=$SITE_DESCRIPTION;?>">
<meta property="og:image" content="https://motor-land.kz/img/logo.webp">
<!-- SEO: Twitter Cards -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
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
  }]
}
</script>
<!-- SEO: CollectionPage для блога -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "name": "Блог о Контрактных Двигателях",
  "description": "<?=$SITE_DESCRIPTION;?>",
  "url": "https://motor-land.kz/blog",
  "publisher": {
    "@type": "Organization",
    "name": "Motor Land"
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
			<span itemprop="name">Блог</span>
			<meta itemprop="position" content="2" />
		</span>
		</div>
	</div>
</nav>

<!-- SEO: Семантический тег <section> для заголовка -->
<section class="generalw" aria-labelledby="blog-title">
	<div class="shirina zgolovorleft">
		<h1 id="blog-title" class="sttitle"><span>Блог о Контрактных Двигателях</span></h1>
		<p class="blog-description">Полезные статьи, советы и руководства от экспертов Motor Land</p>
	</div>
</section>

<!-- SEO: Семантический тег <section> для статей блога -->
<section class="blog-section">
	<div class="shirina">
		<div class="blog-container">
			
			<!-- Категории блога -->
			<div class="blog-categories">
				<button class="blog-category-btn active" data-category="all">Все статьи</button>
				<button class="blog-category-btn" data-category="Общее">Общее</button>
				<button class="blog-category-btn" data-category="Советы">Советы</button>
				<button class="blog-category-btn" data-category="Гарантия">Гарантия</button>
				<button class="blog-category-btn" data-category="Услуги">Услуги</button>
			</div>
			
			<!-- Сетка статей -->
			<div class="blog-grid">
				<?php if (count($blog_articles) > 0): ?>
					<?php foreach ($blog_articles as $article): ?>
					<article class="blog-card" itemscope itemtype="https://schema.org/BlogPosting" data-category="<?=$article['category'];?>">
						<a href="/blog/<?=$article['slug'];?>" itemprop="url" class="blog-card-link">
							<div class="blog-card-image">
								<img src="<?=$article['image'];?>" alt="<?=htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8');?>" itemprop="image" loading="lazy">
								<div class="blog-card-category"><?=$article['category'];?></div>
							</div>
							<div class="blog-card-content">
								<time datetime="<?=$article['date'];?>" class="blog-card-date" itemprop="datePublished"><?=date('d.m.Y', strtotime($article['date']));?></time>
								<h2 class="blog-card-title" itemprop="headline"><?=htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8');?></h2>
								<p class="blog-card-excerpt" itemprop="description"><?=htmlspecialchars($article['excerpt'], ENT_QUOTES, 'UTF-8');?></p>
								<div class="blog-card-meta">
									<span class="blog-card-read-time"><?=htmlspecialchars($article['read_time'], ENT_QUOTES, 'UTF-8');?> чтения</span>
									<span class="blog-card-arrow">→</span>
								</div>
							</div>
						</a>
						<!-- SEO: Author information -->
						<meta itemprop="author" content="<?=htmlspecialchars($article['author'], ENT_QUOTES, 'UTF-8');?>">
						<meta itemprop="publisher" content="Motor Land">
					</article>
					<?php endforeach; ?>
				<?php else: ?>
					<div class="blog-empty">
						<p>Статьи пока отсутствуют. Скоро здесь появятся полезные материалы!</p>
					</div>
				<?php endif; ?>
			</div>
			
			<!-- Сообщение если статей нет (для фильтрации) -->
			<div class="blog-empty" style="display: none;">
				<p>Статьи в этой категории пока отсутствуют</p>
			</div>
			
		</div>
	</div>
</section>

<br><br>
</main>

<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

<script defer>
// Фильтрация статей по категориям
(function() {
	function initBlogFilter() {
		const categoryBtns = document.querySelectorAll('.blog-category-btn');
		const blogCards = document.querySelectorAll('.blog-card');
		const blogEmpty = document.querySelector('.blog-empty');
		
		if (categoryBtns.length === 0 || blogCards.length === 0) {
			return;
		}
		
		categoryBtns.forEach(btn => {
			btn.addEventListener('click', function() {
				const category = this.getAttribute('data-category');
				
				// Обновляем активную кнопку
				categoryBtns.forEach(b => b.classList.remove('active'));
				this.classList.add('active');
				
				// Фильтруем статьи
				let visibleCount = 0;
				blogCards.forEach(card => {
					if (category === 'all' || card.getAttribute('data-category') === category) {
						card.style.display = 'block';
						visibleCount++;
					} else {
						card.style.display = 'none';
					}
				});
				
				// Показываем/скрываем сообщение об отсутствии статей
				if (visibleCount === 0 && blogEmpty) {
					blogEmpty.style.display = 'block';
				} else if (blogEmpty) {
					blogEmpty.style.display = 'none';
				}
			});
		});
	}
	
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initBlogFilter);
	} else {
		initBlogFilter();
	}
})();
</script>

</body>
</html>

