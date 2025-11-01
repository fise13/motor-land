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
		<div class="modilebtn" onclick="mobilemenu ();"></div>
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