<?php
include('hyst/php.php');

$SITE_TITLE = 'Моторленд | Каталог контрактных Моторов и КПП';
$SITE_DESCRIPTION = 'Контрактные моторы и КПП в Алматы, подбор мо марке и модели';

if (isset($_GET['mk']) && $_GET['mk']!='') {
	$tmpcat = $_DB_CONECT->query("SELECT id FROM internet_magazin_category WHERE name='".trim($_GET['mk'])."'");
	if ($tmpcat->num_rows != 0) {
	$mark = $tmpcat->fetch_array()['id'];
	} else {
	$mark = false;
	}
} else {
$mark = false;
}

if (isset($_GET['ml']) && $_GET['ml']!='') {
	$tmpcat = $_DB_CONECT->query("SELECT id FROM internet_magazin_category WHERE name='".trim($_GET['ml'])."'");
	if ($tmpcat->num_rows != 0) {
	$mode = $tmpcat->fetch_array()['id'];
	} else {
	$mode = false;
	}
} else {
$mode = false;
}

if (isset($_GET['yr']) && $_GET['yr']!='') {
	$tmpcat = $_DB_CONECT->query("SELECT id FROM internet_magazin_atributs_options WHERE name='".trim($_GET['yr'])."'");
	if ($tmpcat->num_rows != 0) {
	$year = $tmpcat->fetch_array()['id'];
	} else {
	$year = false;
	}
} else {
$year = false;
}
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
		<a href="/">Главная</a> / Каталог
		</div>
		
	</div>
</div>	


<div class="generalw">
	<div class="shirina zgolovorleft">
		<div class="sttitle"><span>Каталог</span></div>
		
		<ul class="actionperekl">
			<a href="/actions"><li>акции</li></a>
			<a href="/catalog"><li class="actionpereklact" style="color: white;">каталог</li></a>
		</ul>
	</div>
</div>


<div class="generalw">
	<div class="shirina">		

		
		<div class="filtersblock">
		<form method="get" action="catalog.php">
			<!---<input type="text" name="setxt" class="searchbloinput" placeholder="Что вы хотели найти.."><br>--->
			<div class="maipttee">
				<div class="meinputer" style="border: solid 1px black;"><div class="madiv" data-val="Марка"><?php if ($_GET['mk'] != '') { echo $_GET['mk']; } else { echo "Марка"; } ?></div>
					<input type="hidden" name="mk" value="<?php if ($_GET['mk'] != '') { echo $_GET['mk']; } else { echo "Марка"; } ?>">
					<div class="btmmearrow" style="font-size: 17px;">&#9660;</div>
					<div class="ddwnblock" style="border-top: solid 1px black; border-bottom: solid 1px black; border-right: solid 1px black; border-left: solid 1px black;">
						<?php
						$tmp = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp='noting' ORDER BY id ASC");
						if ($tmp->num_rows != 0) {
						while($get = $tmp->fetch_array()):
						?>
						<div style="color: black" data-id="<?=$get['id'];?>"><?=$get['name'];?></div>
						<?php
						endwhile;
						}
						?>
					</div>
				</div>
				
				<div class="meinputer" style="border: solid 1px black;"><div class="madiv" data-val="Модель"><?php if ($_GET['ml'] != '') { echo $_GET['ml']; } else { echo "Модель"; } ?></div>
					<input type="hidden" name="ml" value="<?php if ($_GET['ml'] != '') { echo $_GET['ml']; } else { echo ""; } ?>">
					<div class="btmmearrow" style="font-size: 17px;">&#9660;</div>
					<div class="ddwnblock" id="modellist" style="border-top: solid 1px black; border-bottom: solid 1px black; border-right: solid 1px black; border-left: solid 1px black;">
						<?php
						if ($mark) {
						$tmp = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp='".$mark."' ORDER BY id ASC");
							if ($tmp->num_rows != 0) {
							while($get = $tmp->fetch_array()):
							?>
							<div style="color: black" data-id="<?=$get['id'];?>"><?=$get['name'];?></div>
							<?php
							endwhile;
							}
						}
						?>
					</div>
				</div>
				
				<div class="meinputer" style="border-top: solid 1px black; border: solid 1px black;"><div class="madiv"><?php if ($_GET['yr'] != '') { echo $_GET['yr']; } else { echo "Год"; } ?></div>
					<input type="hidden" name="yr" value="<?php if ($_GET['yr'] != '') { echo $_GET['yr']; } else { echo ""; } ?>">
					<div class="btmmearrow" style="font-size: 17px;">&#9660;</div>
					<div class="ddwnblock" id="yearlist" style="overflow-y: scroll;border-top: solid 1px black; border-bottom: solid 1px black; border-right: solid 1px black; border-left: solid 1px black;">
						<?php
						if ($mode) {
							$sql = $_DB_CONECT->query("SELECT internet_magazin_atributs_options.*
							FROM internet_magazin_atributs_options 
							INNER JOIN internet_magazin_tovari ON  LOCATE(CONCAT('[', internet_magazin_atributs_options.id, ']'), internet_magazin_tovari.atributs_opt) > 0 
							AND LOCATE('[".$mode."]', internet_magazin_tovari.podegory) > 0
							WHERE internet_magazin_atributs_options.idp = 1");
							if ($sql->num_rows != 0) {
							while($get = $sql->fetch_array()):
							?>
							<div style="color: black" data-id="<?=$get['id'];?>" data-id="<?=$get['id'];?>"><?=$get['name'];?></div>
							<?php
							endwhile;
							}
						}
						?>	
						
						
					</div>
				</div>
			</div>
			<input type="submit" name="sear" value=" ">
		</form>
		</div>
		<?php
		$where = '';
		if ($mark) { 
			if ($where == '') { $where .= ' WHERE'; }
			 $where .= " LOCATE('[".$mark."]', category)";
		}
		if ($mode) { 
			if ($where == '') { $where .= ' WHERE'; } else { $where .= ' AND'; }
			 $where .= " LOCATE('[".$mode."]', podegory)";
		}
		if ($year) { 
			if ($where == '') { $where .= ' WHERE'; } else { $where .= ' AND'; }
			 $where .= " LOCATE('[".$year."]', atributs_opt)";
		}
		
		$tmps = $_DB_CONECT->query("SELECT * FROM internet_magazin_tovari ".$where." ORDER BY prio ASC");
		
		if ($tmps->num_rows != 0) { 
		while($get=$tmps->fetch_array()):
		?>
		<div class="toverblock">
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
		<a href="tel:<?=preg_replace('/[^\\d+]/','', get_simple_texts('index_slider_phone'));?>" class="toverbuton" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});">Купить</a>
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