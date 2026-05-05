<?php
include('hyst/php.php');
include_once('hyst/mods/customtexts/proces.php');

// SEO: Оптимизированные мета-теги страницы сервиса
$SITE_TITLE = 'Автосервис - Замена Двигателей и КПП в Алматы | Motor Land';
$SITE_DESCRIPTION = 'Профессиональная замена и обслуживание контрактных двигателей и КПП в Алматы. Диагностика, установка, техническое обслуживание. Доставка по Казахстану и странам СНГ.';
$SITE_KEYWORDS = 'замена двигателя алматы, автосервис замена КПП, установка контрактного двигателя, диагностика двигателя, техническое обслуживание';
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
<link rel="canonical" href="https://motor-land.kz/service"/>
<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
<meta property="og:type" content="website">
<meta property="og:url" content="https://motor-land.kz/service">
<meta property="og:title" content="<?=$SITE_TITLE;?>">
<meta property="og:description" content="<?=$SITE_DESCRIPTION;?>">
<meta property="og:image" content="https://motor-land.kz/img/og-image.jpg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:site_name" content="Motor Land">
<meta property="og:locale" content="ru_RU">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
<meta name="twitter:image" content="https://motor-land.kz/img/og-image.jpg">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "@id": "https://motor-land.kz/service#service",
  "serviceType": "Автосервис - замена двигателей и КПП",
  "name": "Замена контрактных двигателей и КПП",
  "description": "<?=htmlspecialchars($SITE_DESCRIPTION, ENT_QUOTES, 'UTF-8');?>",
  "provider": {
    "@type": "LocalBusiness",
    "@id": "https://motor-land.kz/#organization",
    "name": "Motor Land",
    "url": "https://motor-land.kz",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Алматы",
      "addressRegion": "Алматы",
      "addressCountry": {
        "@type": "Country",
        "name": "KZ"
      }
    },
    "telephone": "+7-777-144-5445"
  },
  "areaServed": [
    {"@type": "City", "name": "Алматы"},
    {"@type": "Country", "name": "Kazakhstan"},
    {"@type": "Country", "name": "Russia"},
    {"@type": "Country", "name": "Belarus"},
    {"@type": "Country", "name": "Ukraine"},
    {"@type": "Country", "name": "Armenia"},
    {"@type": "Country", "name": "Azerbaijan"},
    {"@type": "Country", "name": "Georgia"},
    {"@type": "Country", "name": "Kyrgyzstan"},
    {"@type": "Country", "name": "Moldova"},
    {"@type": "Country", "name": "Tajikistan"},
    {"@type": "Country", "name": "Turkmenistan"},
    {"@type": "Country", "name": "Uzbekistan"}
  ],
  "hasOfferCatalog": {
    "@type": "OfferCatalog",
    "name": "Услуги автосервиса",
    "itemListElement": [{
      "@type": "Offer",
      "itemOffered": {
        "@type": "Service",
        "name": "Замена двигателя",
        "description": "Профессиональная замена контрактного двигателя с полной диагностикой и гарантией на работы"
      }
    }, {
      "@type": "Offer",
      "itemOffered": {
        "@type": "Service",
        "name": "Замена КПП",
        "description": "Установка контрактных коробок передач (АКПП и МКПП) с заменой масла и фильтров"
      }
    }, {
      "@type": "Offer",
      "itemOffered": {
        "@type": "Service",
        "name": "Диагностика",
        "description": "Компьютерная диагностика двигателя и всех систем автомобиля"
      }
    }, {
      "@type": "Offer",
      "itemOffered": {
        "@type": "Service",
        "name": "Техническое обслуживание",
        "description": "Регулярное ТО для обеспечения долгой и надежной работы агрегата"
      }
    }]
  }
}
</script>
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
    "name": "Автосервис",
    "item": "https://motor-land.kz/service"
  }]
}
</script>
</head>
<body>
<?php include("hyst/sbody.php"); ?>
<?php include("des/head.php"); ?>
<main>
<div class="service-page">
	<nav class="generalw" aria-label="Навигационная цепочка">
		<div class="shirina">
			<div class="crumbsblock" itemscope itemtype="https://schema.org/BreadcrumbList">
			<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<a href="/" itemprop="item"><span itemprop="name">Главная</span></a>
				<meta itemprop="position" content="1" />
			</span> / 
			<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<span itemprop="name">Автосервис</span>
				<meta itemprop="position" content="2" />
			</span>
			</div>
		</div>
	</nav>

		<section class="generalw" aria-labelledby="service-title">
			<div class="shirina zgolovorleft">
				<h1 id="service-title" class="sttitle"><span>Автосервис</span></h1>
			</div>
		</section>

		<section class="generalw">
			<div class="shirina">
				<div class="service-hero">
					<div class="service-hero-content">
						<div class="service-hero-text">
							<?php
							$service_hero_text = get_customtexts('service_page_hero_text');
							if ($service_hero_text) {
								echo $service_hero_text;
							} else {
								echo '<p>Наш автосервис предлагает профессиональную замену и обслуживание двигателей, а также замену КПП для автомобилей различных марок и моделей.</p>';
							}
							?>
						</div>
						<!-- Слайдер фотографий автосервиса -->
						<div class="service-gallery-slider">
							<?php
							// Массив фотографий автосервиса
							$service_images = [
								'/cms_img/2025-02/1740464745_67bd626973430.webp', // Основное фото
								// Добавьте здесь пути к другим фотографиям автосервиса
								// Например: '/cms_img/2025-02/photo2.webp',
								// '/cms_img/2025-02/photo3.webp',
							];
							
							// Если есть только одно изображение, показываем его без слайдера
							if (count($service_images) > 1):
							?>
							<div class="service-slider-container">
								<div class="service-slider-wrapper">
									<?php foreach ($service_images as $index => $img_path): ?>
									<div class="service-slide <?php echo $index === 0 ? 'active' : ''; ?>" data-slide="<?=$index;?>">
										<picture>
											<source srcset="<?=$img_path;?>" type="image/webp">
											<img src="<?=$img_path;?>" 
												 alt="Автосервис Motor Land - фото <?=$index + 1;?>" 
												 loading="<?=$index === 0 ? 'eager' : 'lazy';?>"
												 style="width: 100%; height: 100%; object-fit: cover;">
										</picture>
									</div>
									<?php endforeach; ?>
								</div>
								
								<!-- Навигация слайдера -->
								<div class="service-slider-nav">
									<button class="service-slider-btn service-slider-prev" aria-label="Предыдущее фото">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M15 18l-6-6 6-6"/>
										</svg>
									</button>
									<button class="service-slider-btn service-slider-next" aria-label="Следующее фото">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M9 18l6-6-6-6"/>
										</svg>
									</button>
								</div>
								
								<!-- Индикаторы (точки) -->
								<div class="service-slider-dots">
									<?php foreach ($service_images as $index => $img_path): ?>
									<button class="service-slider-dot <?php echo $index === 0 ? 'active' : ''; ?>" 
											data-slide="<?=$index;?>" 
											aria-label="Перейти к фото <?=$index + 1;?>"></button>
									<?php endforeach; ?>
								</div>
							</div>
							<?php else: ?>
							<!-- Если только одно изображение, показываем его без слайдера -->
							<div class="service-hero-image" style="background-image: url(<?=$service_images[0];?>);"></div>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<div class="service-services">
					<h2 class="service-section-title">Наши услуги</h2>
					<div class="service-cards">
						<div class="service-card">
							<span class="service-card-icon">🔧</span>
							<h3 class="service-card-title">Замена двигателя</h3>
							<p class="service-card-text">Профессиональная замена контрактного двигателя с полной диагностикой и гарантией на работы.</p>
						</div>
						<div class="service-card">
							<span class="service-card-icon">⚙️</span>
							<h3 class="service-card-title">Замена КПП</h3>
							<p class="service-card-text">Установка контрактных коробок передач (АКПП и МКПП) с заменой масла и фильтров.</p>
						</div>
						<div class="service-card">
							<span class="service-card-icon">🔍</span>
							<h3 class="service-card-title">Диагностика</h3>
							<p class="service-card-text">Компьютерная диагностика двигателя и всех систем автомобиля.</p>
						</div>
						<div class="service-card">
							<span class="service-card-icon">🛠️</span>
							<h3 class="service-card-title">Техническое обслуживание</h3>
							<p class="service-card-text">Регулярное ТО для обеспечения долгой и надежной работы агрегата.</p>
						</div>
					</div>
				</div>

				<div class="service-cta">
					<div class="service-cta-content">
						<h2 class="service-cta-title">Записаться на обслуживание</h2>
						<p class="service-cta-text">Свяжитесь с нами для записи на обслуживание или консультации</p>
						<a href="/contacts.php" class="service-cta-btn">Связаться с нами</a>
					</div>
				</div>
			</div>
		</section>
</div>
</main>

<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

<script>
(function() {
	// Инициализация слайдера фотографий автосервиса
	function initServiceSlider() {
		var sliderContainer = document.querySelector('.service-slider-container');
		if (!sliderContainer) return;
		
		var slides = sliderContainer.querySelectorAll('.service-slide');
		if (slides.length <= 1) return; // Если слайд один, слайдер не нужен
		
		var currentSlide = 0;
		var dots = sliderContainer.querySelectorAll('.service-slider-dot');
		var prevBtn = sliderContainer.querySelector('.service-slider-prev');
		var nextBtn = sliderContainer.querySelector('.service-slider-next');
		var autoSlideInterval = null;
		
		// Функция показа слайда
		function showSlide(index) {
			// Убираем активный класс со всех слайдов
			slides.forEach(function(slide, i) {
				slide.classList.remove('active');
				if (dots[i]) {
					dots[i].classList.remove('active');
				}
			});
			
			// Добавляем активный класс к текущему слайду
			if (slides[index]) {
				slides[index].classList.add('active');
			}
			if (dots[index]) {
				dots[index].classList.add('active');
			}
			
			currentSlide = index;
		}
		
		// Переход к следующему слайду
		function nextSlide() {
			var next = (currentSlide + 1) % slides.length;
			showSlide(next);
		}
		
		// Переход к предыдущему слайду
		function prevSlide() {
			var prev = (currentSlide - 1 + slides.length) % slides.length;
			showSlide(prev);
		}
		
		// Обработчики для кнопок
		if (nextBtn) {
			nextBtn.addEventListener('click', function(e) {
				e.preventDefault();
				nextSlide();
				resetAutoSlide();
			});
		}
		
		if (prevBtn) {
			prevBtn.addEventListener('click', function(e) {
				e.preventDefault();
				prevSlide();
				resetAutoSlide();
			});
		}
		
		// Обработчики для точек
		dots.forEach(function(dot, index) {
			dot.addEventListener('click', function(e) {
				e.preventDefault();
				showSlide(index);
				resetAutoSlide();
			});
		});
		
		// Автоматическая смена слайдов
		function startAutoSlide() {
			autoSlideInterval = setInterval(nextSlide, 5000); // Меняем каждые 5 секунд
		}
		
		function resetAutoSlide() {
			if (autoSlideInterval) {
				clearInterval(autoSlideInterval);
			}
			startAutoSlide();
		}
		
		// Остановка автопрокрутки при наведении
		sliderContainer.addEventListener('mouseenter', function() {
			if (autoSlideInterval) {
				clearInterval(autoSlideInterval);
			}
		});
		
		sliderContainer.addEventListener('mouseleave', function() {
			startAutoSlide();
		});
		
		// Запускаем автопрокрутку
		startAutoSlide();
		
		// Поддержка свайпов на мобильных устройствах
		var touchStartX = 0;
		var touchEndX = 0;
		
		sliderContainer.addEventListener('touchstart', function(e) {
			touchStartX = e.changedTouches[0].screenX;
		}, { passive: true });
		
		sliderContainer.addEventListener('touchend', function(e) {
			touchEndX = e.changedTouches[0].screenX;
			handleSwipe();
		}, { passive: true });
		
		function handleSwipe() {
			var swipeThreshold = 50;
			var diff = touchStartX - touchEndX;
			
			if (Math.abs(diff) > swipeThreshold) {
				if (diff > 0) {
					// Свайп влево - следующий слайд
					nextSlide();
				} else {
					// Свайп вправо - предыдущий слайд
					prevSlide();
				}
				resetAutoSlide();
			}
		}
	}
	
	// Инициализация при загрузке страницы
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initServiceSlider);
	} else {
		initServiceSlider();
	}
})();
</script>

</body>
</html>