<?php
include('hyst/php.php');

$SITE_TITLE = 'Моторленд | Каталог контрактных Моторов и КПП';
$SITE_DESCRIPTION = 'Контрактные моторы и КПП в Алматы, подбор мо марке и модели';

$mark = false;
$mode = false;
$year = false;

if (isset($_GET['mk']) && $_GET['mk'] != '') {
	$name = trim($_GET['mk']);
	$stmt = $_DB_CONECT->prepare("SELECT id FROM internet_magazin_category WHERE name = ?");
	$stmt->bind_param("s", $name);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows != 0) {
		$mark = $result->fetch_array()['id'];
	}
	$stmt->close();
}

if (isset($_GET['ml']) && $_GET['ml'] != '') {
	$name = trim($_GET['ml']);
	$stmt = $_DB_CONECT->prepare("SELECT id FROM internet_magazin_category WHERE name = ?");
	$stmt->bind_param("s", $name);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows != 0) {
		$mode = $result->fetch_array()['id'];
	}
	$stmt->close();
}

if (isset($_GET['yr']) && $_GET['yr'] != '') {
	$name = trim($_GET['yr']);
	$stmt = $_DB_CONECT->prepare("SELECT id FROM internet_magazin_atributs_options WHERE name = ?");
	$stmt->bind_param("s", $name);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows != 0) {
		$year = $result->fetch_array()['id'];
	}
	$stmt->close();
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
			<a href="/catalog.php"><li class="actionpereklact catalog-active-tab">каталог</li></a>
		</ul>
	</div>
</div>


<div class="generalw catalog-main-section">
	<div class="shirina">		

		
		<div class="filtersblock filtersblock-animated">
		<form method="get" action="catalog.php">
			<!---<input type="text" name="setxt" class="searchbloinput" placeholder="Что вы хотели найти.."><br>--->
			<div class="maipttee">
				<div class="meinputer meinputer-filter"><div class="madiv" data-val="Марка"><?php if ($_GET['mk'] != '') { echo htmlspecialchars($_GET['mk'], ENT_QUOTES, 'UTF-8'); } else { echo "Марка"; } ?></div>
					<input type="hidden" name="mk" value="<?php if ($_GET['mk'] != '') { echo htmlspecialchars($_GET['mk'], ENT_QUOTES, 'UTF-8'); } else { echo ""; } ?>">
					<div class="btmmearrow">&#9660;</div>
					<div class="ddwnblock ddwnblock-filter">
						<?php
						$parent_id = 'noting';
						$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_category WHERE idp = ? ORDER BY id ASC");
						$stmt->bind_param("s", $parent_id);
						$stmt->execute();
						$tmp = $stmt->get_result();
						if ($tmp->num_rows != 0) {
							while($get = $tmp->fetch_array()):
							?>
							<div class="filter-item" data-id="<?=$get['id'];?>"><?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?></div>
							<?php
							endwhile;
						}
						$stmt->close();
						?>
					</div>
				</div>
				
				<div class="meinputer meinputer-filter"><div class="madiv" data-val="Модель"><?php if ($_GET['ml'] != '') { echo htmlspecialchars($_GET['ml'], ENT_QUOTES, 'UTF-8'); } else { echo "Модель"; } ?></div>
					<input type="hidden" name="ml" value="<?php if ($_GET['ml'] != '') { echo htmlspecialchars($_GET['ml'], ENT_QUOTES, 'UTF-8'); } else { echo ""; } ?>">
					<div class="btmmearrow">&#9660;</div>
					<div class="ddwnblock ddwnblock-filter" id="modellist">
						<?php
						if ($mark) {
							$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_category WHERE idp = ? ORDER BY id ASC");
							$stmt->bind_param("i", $mark);
							$stmt->execute();
							$tmp = $stmt->get_result();
							if ($tmp->num_rows != 0) {
								while($get = $tmp->fetch_array()):
								?>
								<div class="filter-item" data-id="<?=$get['id'];?>"><?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?></div>
								<?php
								endwhile;
							}
							$stmt->close();
						}
						?>
					</div>
				</div>
				
				<div class="meinputer meinputer-filter"><div class="madiv"><?php if ($_GET['yr'] != '') { echo htmlspecialchars($_GET['yr'], ENT_QUOTES, 'UTF-8'); } else { echo "Год"; } ?></div>
					<input type="hidden" name="yr" value="<?php if ($_GET['yr'] != '') { echo htmlspecialchars($_GET['yr'], ENT_QUOTES, 'UTF-8'); } else { echo ""; } ?>">
					<div class="btmmearrow">&#9660;</div>
					<div class="ddwnblock ddwnblock-filter overflow-scroll" id="yearlist">
						<?php
						if ($mode) {
							$mode_pattern = '[' . $mode . ']';
							$stmt = $_DB_CONECT->prepare("SELECT internet_magazin_atributs_options.*
							FROM internet_magazin_atributs_options 
							INNER JOIN internet_magazin_tovari ON LOCATE(CONCAT('[', internet_magazin_atributs_options.id, ']'), internet_magazin_tovari.atributs_opt) > 0 
							AND LOCATE(?, internet_magazin_tovari.podegory) > 0
							WHERE internet_magazin_atributs_options.idp = 1");
							$stmt->bind_param("s", $mode_pattern);
							$stmt->execute();
							$sql = $stmt->get_result();
							if ($sql->num_rows != 0) {
								while($get = $sql->fetch_array()):
								?>
								<div class="filter-item" data-id="<?=$get['id'];?>"><?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?></div>
								<?php
								endwhile;
							}
							$stmt->close();
						}
						?>	
					</div>
				</div>
			</div>
			<input type="submit" name="sear" value=" ">
		</form>
		</div>
		<?php
		$conditions = [];
		$types = '';
		$params = [];
		
		if ($mark) {
			$mark_pattern = '[' . $mark . ']';
			$conditions[] = "LOCATE(?, category) > 0";
			$types .= 's';
			$params[] = &$mark_pattern;
		}
		
		if ($mode) {
			$mode_pattern = '[' . $mode . ']';
			$conditions[] = "LOCATE(?, podegory) > 0";
			$types .= 's';
			$params[] = &$mode_pattern;
		}
		
		if ($year) {
			$year_pattern = '[' . $year . ']';
			$conditions[] = "LOCATE(?, atributs_opt) > 0";
			$types .= 's';
			$params[] = &$year_pattern;
		}
		
		$where = '';
		if (!empty($conditions)) {
			$where = ' WHERE ' . implode(' AND ', $conditions);
		}
		
		$sql = "SELECT * FROM internet_magazin_tovari" . $where . " ORDER BY prio ASC";
		$stmt = $_DB_CONECT->prepare($sql);
		
		if (!empty($params)) {
			call_user_func_array([$stmt, 'bind_param'], array_merge([$types], $params));
		}
		
		$stmt->execute();
		$tmps = $stmt->get_result();
		
		if ($tmps->num_rows != 0) { 
			while($get = $tmps->fetch_array()):
		?>
		<div class="toverblock catalog-item-animated">
			<a href="/detal?id=<?=$get['id'];?>"><div class="toverimg catalog-item-image" style="background-image: url(<?=get_farrimg($get['images'])[0];?>);">
			<?php if ($get['sale'] != 'noting') { ?>
			<div class="cationsale catalog-sale-badge"><?=$get['sale'];?></div>
			<?php } ?>
			</div></a>
			<div class="tovertitle catalog-item-title"><?=$get['name'];?></div>
			<div class="tovaropis catalog-item-description">
				<?=$get['stext'];?>
			</div>
			<div class="tovercena catalog-item-price"><?=($get['cash']!=0?$get['cash'].' KZT':'Цена по запросу');?></div>
			<a href="tel:<?=preg_replace('/[^\\d+]/','', get_simple_texts('index_slider_phone'));?>" class="toverbuton catalog-buy-button" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});">Купить</a>
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
</body>
</html>