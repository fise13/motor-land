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
		$tmps = $_DB_CONECT->query("SELECT * FROM internet_magazin_tovari WHERE sale != 'noting' ORDER BY prio ASC");
		if ($tmp->num_rows != 0) {
		while($get=$tmp->fetch_array()):
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
		?>
		
	</div>
</div>
<br><br>
<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>
</body>
</html>