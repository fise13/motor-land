<div class="headercon mobilefix">
	<div class="shirina relhead">
		<div class="logo"></div>
		<ul class="menu">
			<a href="/"><li>Главная</li></a>
			<a href="/catalog"><li>Каталог</li></a>
			<a href="/service"><li>Автосервис</li></a>
			<a href="/pay"><li>Оплата / Доставка</li></a>
			<a href="/guarantees"><li>Гарантии</li></a>
			<li onclick="$('html,body').stop().animate({ scrollTop: 9000 }, 500);">Контакты</li>
		</ul>
		<div class="modilebtn" onclick="mobilemenu ();"></div>
	</div>
</div>
<script>

	function mobilemenu () {
		if ($('.menu').css('display') == 'block') {
			$('.menu').toggle(); 
			$('.modilebtn').css('background-image','url(./img/mmenu.png)');
		} else {
			$('.menu').toggle(); 
			$('.modilebtn').css('background-image','url(./img/crossm.png)');
		}
	}
	
	</script>