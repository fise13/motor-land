<?php
include('hyst/php.php');

$SITE_TITLE = 'Моторленд | Акции на контрактные Моторы и КПП';
?>
<!doctype html>
<html>
<head>
<?php include("hyst/head.php"); ?>
</head>
<body>
<!-- Экран загрузки -->
<div id="loader-screen" class="loader-screen">
	<div class="loader-video-container">
		<video id="loader-video" class="loader-video" autoplay muted playsinline>
			<source src="img/loader.mp4" type="video/mp4">
			<div class="loader-fallback">Моторленд</div>
		</video>
	</div>
</div>

<?php include("hyst/sbody.php"); ?>
<?php include("des/head.php"); ?>
<br><br>
<div class="generalw">
	<div class="shirina">
		<div class="crumbsblock">
		<a href="/">Главная</a> / Акции
		</div>
	</div>
</div>	


<div class="generalw">
	<div class="shirina zgolovorleft">
		<div class="sttitle"><span>Акции</span></div>
		
		<ul class="actionperekl">
			<a href="/actions"><li class="actionpereklact" style="color: white;">акции</li></a>
			<a href="/catalog"><li>каталог</li></a>
		</ul>
	</div>
</div>


<div class="generalw">
	<div class="shirina">	

		<?php
		$sale_value = 'noting';
		$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_tovari WHERE sale != ? ORDER BY prio ASC");
		$stmt->bind_param("s", $sale_value);
		$stmt->execute();
		$tmps = $stmt->get_result();
		if ($tmps->num_rows != 0) {
			while($get = $tmps->fetch_array()):
		?>
		<div class="toverblock revealator-slideup">
			<a href="/detal?id=<?=$get['id'];?>"><div class="toverimg" style="background-image: url(<?=get_farrimg($get['images'])[0];?>);">
			<?php if ($get['sale'] != 'noting') { ?>
			<div class="cationsale"><?=$get['sale'];?></div>
			<?php } ?>
			</div></a>
			<div class="tovertitle"><?=$get['name'];?></div>
			<div class="tovaropis">
				<?=$get['stext'];?>
			</div>
			<div class="tovercena"><?=($get['cash']!=0?$get['cash'].' KZT':'Цена по запросу');?></div>
			<div class="toverbuton" data-nam="<?=$get['name'];?>">Купить</div>
		</div>
		<?php
			endwhile;
		}
		if (isset($stmt)) {
			$stmt->close();
		}
		?>
		
	</div>
</div>
<br><br>
<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var loader = document.getElementById('loader-screen');
	var video = document.getElementById('loader-video');
	
	function hideLoader() {
		if (loader && !loader.classList.contains('hidden')) {
			loader.classList.add('hidden');
			setTimeout(function() {
				if (loader) loader.style.display = 'none';
			}, 500);
		}
	}
	
	if (video) {
		video.addEventListener('ended', hideLoader);
		video.addEventListener('loadeddata', function() {
			setTimeout(hideLoader, 800);
		});
		video.play().catch(function() {});
	}
	
	setTimeout(hideLoader, 1500);
	window.addEventListener('load', function() {
		setTimeout(hideLoader, 300);
	});
});
</script>
</body>
</html>