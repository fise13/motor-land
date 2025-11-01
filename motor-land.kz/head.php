<div class="headercon mobilefix">
	<div class="shirina relhead">
		<a href="/" class="logo"><img src="img/logo.png" alt="Моторленд"></a>
		<ul class="menu">
			<a href="/"><li>Главная</li></a>
			<a href="/catalog"><li>Каталог</li></a>
			<a href="/service"><li>Сервис</li></a>
			<a href="/pay"><li>Оплата / Доставка</li></a>
			<a href="/guarantees"><li>Гарантии</li></a>
			<li onclick="$('html,body').stop().animate({ scrollTop: 9000 }, 500);">Контакты</li>
		</ul>
			<label class="modilebtn" onclick="mobilemenu ();">
				<svg viewBox="0 0 32 32 ">
				<path class="line line-top-bottom" d="M27 10 13 10C10.8 10 9 8.2 9 6 9 3.5 10.8 2 13 2 15.2 2 17 3.8 17 6L17 26C17 28.2 18.8 30 21 30 23.2 30 25 28.2 25 26 25 23.8 23.2 22 21 22L7 22"></path>
				<path class="line" d="M7 16 27 16"></path>
				</svg>
			</label>
		</div>
	</div>
</div>
<script>

function mobilemenu() {
	const menu = document.querySelector('.menu');
	const btn = document.querySelector('.modilebtn');

btn.addEventListener('click', () => {
    menu.classList.toggle('open');

    if (menu.classList.contains('open')) {
        btn.style.backgroundImage = "url('./img/crossm.png')"; // крестик
    } else {
        btn.style.backgroundImage = "url('./img/mmenu.png')"; // гамбургер
    }
});
	
</script>