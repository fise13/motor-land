<!-- Accessibility: Семантический header с навигацией -->
<header class="headercon mobilefix" role="banner">
	<div class="shirina relhead">
		<!-- Accessibility: Логотип с ссылкой на главную -->
		<a href="/" class="logo" aria-label="Motor Land - Главная страница">
			<span class="sr-only">Motor Land - Главная страница</span>
		</a>
		<!-- Accessibility: Основная навигация сайта -->
		<nav class="menu" role="navigation" aria-label="Основная навигация">
			<a href="/" aria-label="Перейти на главную страницу"><li>Главная</li></a>
			<a href="/catalog" aria-label="Перейти в каталог товаров"><li>Каталог</li></a>
			<a href="/service" aria-label="Перейти на страницу автосервиса"><li>Автосервис</li></a>
			<a href="/pay" aria-label="Перейти на страницу оплаты и доставки"><li>Оплата / Доставка</li></a>
			<a href="/guarantees" aria-label="Перейти на страницу гарантий"><li>Гарантии</li></a>
			<a href="/contacts.php" aria-label="Перейти на страницу контактов"><li>Контакты</li></a>
		</nav>
		<!-- Accessibility: Кнопка мобильного меню с ARIA атрибутами -->
		<button class="modilebtn" onclick="mobilemenu();" aria-label="Открыть меню навигации" aria-expanded="false" aria-controls="mobile-menu" type="button">
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
		</button>
		<div class="menu-overlay" aria-hidden="true" role="presentation"></div>
	</div>
</header>
	<!-- Performance: Скрипт мобильного меню загружается с defer -->
	<script defer>
	// Performance: Ожидание загрузки jQuery перед использованием
	(function() {
		function waitForJQuery(callback) {
			if (typeof window.jQuery !== 'undefined' && typeof window.$ !== 'undefined') {
				callback();
			} else {
				setTimeout(function() { waitForJQuery(callback); }, 50);
			}
		}
		
		function initMobileMenu() {
			var $ = window.jQuery || window.$;
			if (!$) {
				waitForJQuery(initMobileMenu);
				return;
			}
			
			/**
			 * Функция: Переключение мобильного меню
			 * Описание: Показывает/скрывает мобильное меню с анимацией и переключает состояние кнопки.
			 * Accessibility: Обновляет ARIA атрибуты для screen readers
			 * Параметры: нет
			 * Возвращает: ничего
			 */
			window.mobilemenu = function() {
				var menu = $('.menu');
				var btn = $('.modilebtn');
				var overlay = $('.menu-overlay');
				var isOpen = menu.hasClass('open');
				
				if (isOpen) {
					// Закрытие меню
					menu.removeClass('open');
					btn.removeClass('active');
					overlay.removeClass('active');
					btn.attr('aria-expanded', 'false');
					overlay.attr('aria-hidden', 'true');
				} else {
					// Открытие меню
					menu.addClass('open').attr('id', 'mobile-menu');
					btn.addClass('active');
					overlay.addClass('active');
					btn.attr('aria-expanded', 'true');
					overlay.attr('aria-hidden', 'false');
				}
			};
			
			// Закрытие меню при клике на затемненный фон
			$(document).on('click', '.menu-overlay', function() {
				var menu = $('.menu');
				var btn = $('.modilebtn');
				var overlay = $('.menu-overlay');
				
				menu.removeClass('open');
				btn.removeClass('active');
				overlay.removeClass('active');
				btn.attr('aria-expanded', 'false');
				overlay.attr('aria-hidden', 'true');
			});
			
			// Закрытие меню при клике на ссылку в меню
			$(document).on('click', '.menu a', function() {
				var menu = $('.menu');
				var btn = $('.modilebtn');
				var overlay = $('.menu-overlay');
				
				// Небольшая задержка для плавного закрытия
				setTimeout(function() {
					menu.removeClass('open');
					btn.removeClass('active');
					overlay.removeClass('active');
					btn.attr('aria-expanded', 'false');
					overlay.attr('aria-hidden', 'true');
				}, 100);
			});
			
			// Accessibility: Закрытие меню по ESC
			$(document).on('keydown', function(e) {
				if (e.key === 'Escape' && $('.menu').hasClass('open')) {
					window.mobilemenu();
				}
			});
		}
		
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', function() {
				waitForJQuery(initMobileMenu);
			});
		} else {
			waitForJQuery(initMobileMenu);
		}
	})();
	</script>