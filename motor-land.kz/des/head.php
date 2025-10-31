<div class="headercon mobilefix">
	<div class="shirina relhead">
		<div class="logo"></div>
		<div id="themeToggle" aria-label="Переключить тему" title="Переключить тему" style="position:absolute; right:50px; top:14px; width:38px; height:38px; cursor:pointer; border-radius:20px; display:flex; align-items:center; justify-content:center;">
			<label class="theme-switch">
				<input type="checkbox" id="themeToggleInput">
				<span class="slider"></span>
			</label>
		</div>
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