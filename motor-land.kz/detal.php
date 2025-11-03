<?php
include('hyst/php.php');



//Фильтр гет
if (hyst_test_id($_GET['id'])) {
	$id = (int)$_GET['id'];
	$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_tovari WHERE id = ?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$sql = $stmt->get_result();
	if ($sql->num_rows != 0) {
		$print = $sql->fetch_array();
		$stmt->close();
	} else {
		echo "<script>location.href='catalog.php';</script>"; 
		exit;
	}
} else {
	echo "<script>location.href='catalog.php';</script>"; 
	exit;
}


$SITE_TITLE = 'Моторленд | '.$print['name'].' купить Алматы '.$print['tmeta'];
$SITE_DESCRIPTION = 'Купить '.$print['name'].' '.$print['tmeta'];
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
		<video id="loader-video" class="loader-video" muted playsinline>
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
		<a href="index.php">Главная</a> / <a href="catalog.php">Каталог</a> / <?=$print['name'];?>
		</div>
		<div class="detalinlines">
			<div class="tovarimage">
				<img src="<?=get_farrimg($print['images'])[0];?>" alt="<?='Купить '.$print['name'].' - '.$print['tmeta'];?>" title="<?='Купить '.$print['name'].' - '.$print['tmeta'];?>">
				<?php if ($print['sale'] != 'noting') { ?>
				<div class="cationsale"><?=$print['sale'];?></div>
				<?php } ?>
			</div>
		</div>
		<div class="detalinlines">
			<h1 class="tovertitle"><?=$print['name'];?></h1>
			
			<?=$print['text'];?>
			<br><br>
			<div class="tovercenaca"><?=($print['cash']!=0?$print['cash'].' KZT':'Цена по запросу');?></div>
			<div class="toverbuton"  data-nam="<?=$print['name'];?>">Купить</div>
		</div>
		<!--<div class="charactr">
		<?=$print['text1'];?>
		</div>-->
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
		setTimeout(function() {
			video.play();
		}, 1000);
		
		video.addEventListener('ended', hideLoader);
		video.addEventListener('loadeddata', function() {
			setTimeout(hideLoader, 800);
		});
	}
	
	setTimeout(hideLoader, 2000);
	window.addEventListener('load', function() {
		setTimeout(hideLoader, 1300);
	});
});
</script>
</body>
</html>