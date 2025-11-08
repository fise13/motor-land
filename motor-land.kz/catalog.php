<?php
include('hyst/php.php');
include_once('hyst/mods/page_content/proces.php');

$catalog_content = get_page_content('catalog_page');
$SITE_TITLE = $catalog_content && !empty($catalog_content['meta_title']) ? htmlspecialchars($catalog_content['meta_title'], ENT_QUOTES, 'UTF-8') : 'Каталог Контрактных Моторов Алматы | Привозные Моторы Малайзия | Контрактные Двигатели Казахстан';
$SITE_DESCRIPTION = $catalog_content && !empty($catalog_content['meta_description']) ? htmlspecialchars($catalog_content['meta_description'], ENT_QUOTES, 'UTF-8') : 'Каталог контрактных моторов в Алматы. Привозные моторы из Малайзии. Контрактные двигатели Казахстан - большой выбор двигателей бу.';
$SITE_KEYWORDS = $catalog_content && !empty($catalog_content['meta_keywords']) ? htmlspecialchars($catalog_content['meta_keywords'], ENT_QUOTES, 'UTF-8') : 'купить контрактный мотор Алматы, контрактные двигатели Казахстан, привозные моторы Алматы';

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
<html lang="ru">
<head>
<?php include("hyst/head.php"); ?>
<link rel="canonical" href="https://motor-land.kz/catalog"/>
<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
<meta property="og:type" content="website">
<meta property="og:url" content="https://motor-land.kz/catalog">
<meta property="og:title" content="<?=$SITE_TITLE;?>">
<meta property="og:description" content="<?=$SITE_DESCRIPTION;?>">
<meta property="og:image" content="https://motor-land.kz/img/logo.webp">
<meta property="og:locale" content="ru_RU">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [{
    "@type": "ListItem",
    "position": 1,
    "name": "Главная",
    "item": "https://motor-land.kz/"
  }, {
    "@type": "ListItem",
    "position": 2,
    "name": "Каталог",
    "item": "https://motor-land.kz/catalog"
  }]
}
</script>
</head>
<body>
<?php include("hyst/sbody.php"); ?>
<?php include("des/head.php"); ?>
<main>
<br><br>
<nav class="generalw" aria-label="Навигационная цепочка">
	<div class="shirina">
		<div class="crumbsblock" itemscope itemtype="https://schema.org/BreadcrumbList">
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<a href="/" itemprop="item"><span itemprop="name">Главная</span></a>
			<meta itemprop="position" content="1" />
		</span> / 
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<span itemprop="name">Каталог</span>
			<meta itemprop="position" content="2" />
		</span>
		</div>
		
	</div>
</nav>	

<section class="generalw" aria-labelledby="catalog-title">
	<div class="shirina zgolovorleft">
		<h1 id="catalog-title" class="sttitle"><span><?=$catalog_content && !empty($catalog_content['h1_text']) ? htmlspecialchars($catalog_content['h1_text'], ENT_QUOTES, 'UTF-8') : 'Каталог';?></span></h1>
		
		<ul class="actionperekl">
			<a href="/actions"><li>акции</li></a>
			<a href="/catalog"><li class="actionpereklact" style="color: white;">каталог</li></a>
		</ul>
	</div>
</section>

<?php if ($catalog_content && !empty($catalog_content['content'])): ?>
<section class="generalw" style="padding: 20px 0;">
	<div class="shirina">
		<div class="catalog-page-content" style="max-width: 1200px; margin: 0 auto; padding: 20px; background: #f9f9f9; border-radius: 8px; margin-bottom: 30px;">
			<?=$catalog_content['content'];?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="generalw" aria-label="Фильтры и товары каталога">
	<div class="shirina">		

		
		<div class="filtersblock">
		<form method="get" action="catalog.php">
			<div class="maipttee">
				<div class="meinputer" style="border: solid 1px black;"><div class="madiv" data-val="Марка"><?php if ($_GET['mk'] != '') { echo htmlspecialchars($_GET['mk'], ENT_QUOTES, 'UTF-8'); } else { echo "Марка"; } ?></div>
					<input type="hidden" name="mk" value="<?php if ($_GET['mk'] != '') { echo htmlspecialchars($_GET['mk'], ENT_QUOTES, 'UTF-8'); } else { echo ""; } ?>">
					<div class="btmmearrow" style="font-size: 17px;">&#9660;</div>
					<div class="ddwnblock" style="border-top: solid 1px black; border-bottom: solid 1px black; border-right: solid 1px black; border-left: solid 1px black;">
						<?php
						$parent_id = 'noting';
						$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_category WHERE idp = ? ORDER BY id ASC");
						$stmt->bind_param("s", $parent_id);
						$stmt->execute();
						$tmp = $stmt->get_result();
						if ($tmp->num_rows != 0) {
							while($get = $tmp->fetch_array()):
							?>
							<div style="color: black" data-id="<?=$get['id'];?>"><?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?></div>
							<?php
							endwhile;
						}
						$stmt->close();
						?>
					</div>
				</div>
				
				<div class="meinputer" style="border: solid 1px black;"><div class="madiv" data-val="Модель"><?php if ($_GET['ml'] != '') { echo htmlspecialchars($_GET['ml'], ENT_QUOTES, 'UTF-8'); } else { echo "Модель"; } ?></div>
					<input type="hidden" name="ml" value="<?php if ($_GET['ml'] != '') { echo htmlspecialchars($_GET['ml'], ENT_QUOTES, 'UTF-8'); } else { echo ""; } ?>">
					<div class="btmmearrow" style="font-size: 17px;">&#9660;</div>
					<div class="ddwnblock" id="modellist" style="border-top: solid 1px black; border-bottom: solid 1px black; border-right: solid 1px black; border-left: solid 1px black;">
						<?php
						if ($mark) {
							$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_category WHERE idp = ? ORDER BY id ASC");
							$stmt->bind_param("i", $mark);
							$stmt->execute();
							$tmp = $stmt->get_result();
							if ($tmp->num_rows != 0) {
								while($get = $tmp->fetch_array()):
								?>
								<div style="color: black" data-id="<?=$get['id'];?>"><?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?></div>
								<?php
								endwhile;
							}
							$stmt->close();
						}
						?>
					</div>
				</div>
				
				<div class="meinputer" style="border-top: solid 1px black; border: solid 1px black;"><div class="madiv"><?php if ($_GET['yr'] != '') { echo htmlspecialchars($_GET['yr'], ENT_QUOTES, 'UTF-8'); } else { echo "Год"; } ?></div>
					<input type="hidden" name="yr" value="<?php if ($_GET['yr'] != '') { echo htmlspecialchars($_GET['yr'], ENT_QUOTES, 'UTF-8'); } else { echo ""; } ?>">
					<div class="btmmearrow" style="font-size: 17px;">&#9660;</div>
					<div class="ddwnblock" id="yearlist" style="overflow-y: scroll;border-top: solid 1px black; border-bottom: solid 1px black; border-right: solid 1px black; border-left: solid 1px black;">
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
								<div style="color: black" data-id="<?=$get['id'];?>"><?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?></div>
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
		<article class="toverblock" itemscope itemtype="https://schema.org/Product" role="article" aria-labelledby="product-title-<?=$get['id'];?>">
			<a href="/detal?id=<?=$get['id'];?>" itemprop="url" aria-label="Подробнее о товаре <?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?>">
				<?php 
				$product_img = get_optimized_image(get_farrimg($get['images'])[0]);
				?>
				<div class="toverimg" style="background-image: url(<?=$product_img['webp'] ?: $product_img['original'];?>);" loading="lazy" aria-label="<?=htmlspecialchars('Купить контрактный мотор '.$get['name'].' Алматы - привозные моторы из Малайзии', ENT_QUOTES, 'UTF-8');?>" itemprop="image" role="img">
			<?php if ($get['sale'] != 'noting') { ?>
			<div class="cationsale" aria-label="Скидка: <?=htmlspecialchars($get['sale'], ENT_QUOTES, 'UTF-8');?>"><?=$get['sale'];?></div>
			<?php } ?>
			</div></a>
			<h2 id="product-title-<?=$get['id'];?>" class="tovertitle" itemprop="name"><?=$get['name'];?></h2>
			<div class="tovaropis" itemprop="description" aria-label="Описание товара">
				<?=$get['stext'];?>
			</div>
			<div class="tovercena" itemprop="offers" itemscope itemtype="https://schema.org/Offer" aria-label="Цена товара">
				<?php if ($get['cash'] != 0 && $get['cash'] != '0') { ?>
				<span itemprop="price" aria-label="Цена"><?=$get['cash'];?></span>
				<span itemprop="priceCurrency" content="KZT" aria-label="валюта"> KZT</span>
				<?php } else { ?>
				<span aria-label="Цена по запросу">Цена по запросу</span>
				<?php } ?>
			</div>
			<a href="tel:<?=preg_replace('/[^\\d+]/','', get_simple_texts('index_slider_phone'));?>" class="toverbuton" role="button" aria-label="Купить товар <?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?>" tabindex="0" onclick="if(typeof gtag==='function'){gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});}">Купить</a>
		</article>
		<?php
			endwhile;
		}
		if (isset($stmt)) {
			$stmt->close();
		}
		?>
		
	</div>
</section>
</main>
<br><br>
<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

</body>
</html>