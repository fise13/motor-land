<div class="headercon mobilefix">
	<div class="shirina relhead">
		<div class="logo">
			<video class="logo-video" autoplay muted playsinline loop preload="none" poster="img/logo.jpg">
				<source src="img/loader.mp4" type="video/mp4">
			</video>
		</div>
		<ul class="menu">
			<a href="/"><li>Главная</li></a>
			<a href="/catalog"><li>Каталог</li></a>
			<a href="/service"><li>Автосервис</li></a>
			<a href="/pay"><li>Оплата / Доставка</li></a>
			<a href="/guarantees"><li>Гарантии</li></a>
			<a href="/contacts.php"><li>Контакты</li></a>
		</ul>
		<div class="modilebtn" onclick="mobilemenu();">
			<span></span>
			<span></span>
			<span></span>
		</div>
		<div class="menu-overlay"></div>
	</div>
</div>
<script>

	/**
	 * Функция: Переключение мобильного меню
	 * Описание: Показывает/скрывает мобильное меню с анимацией и переключает состояние кнопки.
	 * Параметры: нет
	 * Возвращает: ничего
	 */
	function mobilemenu () {
		var menu = $('.menu');
		var btn = $('.modilebtn');
		var overlay = $('.menu-overlay');
		
		if (menu.hasClass('open')) {
			// Закрытие меню
			menu.removeClass('open');
			btn.removeClass('active');
			overlay.removeClass('active');
		} else {
			// Открытие меню
			menu.addClass('open');
			btn.addClass('active');
			overlay.addClass('active');
		}
	}
	
	// Закрытие меню при клике на затемненный фон
	$(document).on('click', '.menu-overlay', function() {
		var menu = $('.menu');
		var btn = $('.modilebtn');
		var overlay = $('.menu-overlay');
		
		menu.removeClass('open');
		btn.removeClass('active');
		overlay.removeClass('active');
	});
	
	</script>