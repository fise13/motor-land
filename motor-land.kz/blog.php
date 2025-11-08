<?php
include('hyst/php.php');

// SEO: Оптимизированные мета-теги для страницы блога
$SITE_TITLE = 'Блог о Контрактных Двигателях | Полезные Статьи | Моторленд';
$SITE_DESCRIPTION = 'Полезные статьи о контрактных двигателях, советы по выбору, установке и обслуживанию. Экспертные материалы от специалистов Motor Land.';
$SITE_KEYWORDS = 'блог контрактные двигатели, статьи о двигателях, как выбрать контрактный двигатель, установка контрактного двигателя, что такое контрактный двигатель';

// Получаем список статей из базы данных (если есть таблица blog или используем файловую систему)
// Пока создаем структуру для статей
$blog_articles = [
    [
        'id' => 1,
        'slug' => 'chto-takoe-kontraktnyj-dvigatel',
        'title' => 'Что такое контрактный двигатель и в чем его преимущества',
        'description' => 'Подробное объяснение что такое контрактный двигатель, откуда он берется, какие у него преимущества и недостатки. Сравнение с новыми двигателями.',
        'image' => '/img/blog/contract-engine.jpg',
        'date' => '2025-01-15',
        'category' => 'Общее',
        'read_time' => '8 мин',
        'excerpt' => 'Контрактный двигатель - это бывший в употреблении двигатель, снятый с автомобиля в рабочем состоянии. Узнайте все о преимуществах и особенностях контрактных двигателей.'
    ],
    [
        'id' => 2,
        'slug' => 'kak-vybrat-kontraktnyj-dvigatel',
        'title' => 'Как выбрать контрактный двигатель: полное руководство',
        'description' => 'Пошаговое руководство по выбору контрактного двигателя. Как проверить состояние, на что обратить внимание, как избежать проблем.',
        'image' => '/img/blog/choose-engine.jpg',
        'date' => '2025-01-10',
        'category' => 'Советы',
        'read_time' => '12 мин',
        'excerpt' => 'Выбор контрактного двигателя - ответственное дело. Наше руководство поможет вам сделать правильный выбор и избежать проблем в будущем.'
    ],
    [
        'id' => 3,
        'slug' => 'garantiya-na-kontraktnyj-dvigatel',
        'title' => 'Гарантия на контрактный двигатель: что нужно знать',
        'description' => 'Все о гарантии на контрактные двигатели: сроки, условия, что покрывает гарантия, в каких случаях гарантия не действует.',
        'image' => '/img/blog/warranty.jpg',
        'date' => '2025-01-05',
        'category' => 'Гарантия',
        'read_time' => '6 мин',
        'excerpt' => 'Гарантия на контрактный двигатель - важный аспект покупки. Узнайте все условия гарантии и как правильно использовать гарантийные обязательства.'
    ],
    [
        'id' => 4,
        'slug' => 'ustanovka-kontraktnogo-dvigatelya',
        'title' => 'Установка контрактного двигателя: этапы и особенности',
        'description' => 'Подробное описание процесса установки контрактного двигателя. Этапы работы, необходимые инструменты, стоимость установки.',
        'image' => '/img/blog/installation.jpg',
        'date' => '2024-12-28',
        'category' => 'Услуги',
        'read_time' => '10 мин',
        'excerpt' => 'Установка контрактного двигателя - сложный процесс, требующий профессионализма. Узнайте все этапы установки и что нужно учитывать.'
    ]
];
?>
<!doctype html>
<html lang="ru">
<head>
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
				<?php foreach ($blog_articles as $article): ?>
				<article class="blog-card" itemscope itemtype="https://schema.org/BlogPosting" data-category="<?=$article['category'];?>">
					<a href="/blog/<?=$article['slug'];?>" itemprop="url" class="blog-card-link">
						<div class="blog-card-image">
							<img src="<?=$article['image'];?>" alt="<?=htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8');?>" itemprop="image" loading="lazy">
							<div class="blog-card-category"><?=$article['category'];?></div>
						</div>
						<div class="blog-card-content">
							<time datetime="<?=$article['date'];?>" class="blog-card-date" itemprop="datePublished"><?=date('d.m.Y', strtotime($article['date']));?></time>
							<h2 class="blog-card-title" itemprop="headline"><?=$article['title'];?></h2>
							<p class="blog-card-excerpt" itemprop="description"><?=$article['excerpt'];?></p>
							<div class="blog-card-meta">
								<span class="blog-card-read-time"><?=$article['read_time'];?> чтения</span>
								<span class="blog-card-arrow">→</span>
							</div>
						</div>
					</a>
					<!-- SEO: Author information -->
					<meta itemprop="author" content="Motor Land">
					<meta itemprop="publisher" content="Motor Land">
				</article>
				<?php endforeach; ?>
			</div>
			
			<!-- Сообщение если статей нет -->
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

