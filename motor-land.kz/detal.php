<?php
include('hyst/php.php');



//Фильтр гет
if (hyst_test_id($_GET['id'])) {
	$sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_tovari WHERE id='".$_GET['id']."' ");
	if ($sql->num_rows != 0) {
	$print = $sql->fetch_array();

	} else {
	echo "<script>location.href='catalog.php';</script>"; exit;
	}
} else {
echo "<script>location.href='catalog.php';</script>"; exit;
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
</body>
</html>