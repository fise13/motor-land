<div class="headercon mobilefix">
	<div class="shirina relhead">
		<a href="/" class="logo"><img src="img/logo.webp" alt="Моторленд - Контрактные двигатели и привозные моторы из Малайзии в Алматы" width="200" height="60" loading="eager"></a>
		<ul class="menu">
			<a href="/"><li>Главная</li></a>
			<a href="/catalog.php"><li>Каталог</li></a>
			<a href="/service"><li>Сервис</li></a>
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
	function mobilemenu() {
		const menu = document.querySelector('.menu');
		const btn = document.querySelector('.modilebtn');
		const overlay = document.querySelector('.menu-overlay');
		
		if (menu.classList.contains('open')) {
			// Закрытие меню
			menu.classList.remove('open');
			btn.classList.remove('active');
			if (overlay) overlay.classList.remove('active');
		} else {
			// Открытие меню
			menu.classList.add('open');
			btn.classList.add('active');
			if (overlay) overlay.classList.add('active');
		}
	}
	
	// Закрытие меню при клике на затемненный фон
	document.addEventListener('click', function(e) {
		if (e.target.classList.contains('menu-overlay')) {
			const menu = document.querySelector('.menu');
			const btn = document.querySelector('.modilebtn');
			const overlay = document.querySelector('.menu-overlay');
			
			menu.classList.remove('open');
			btn.classList.remove('active');
			if (overlay) overlay.classList.remove('active');
		}
	});
</script>