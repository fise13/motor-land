<?php
include('hyst/php.php');

$SITE_TITLE = 'Моторленд | Акции на контрактные Моторы и КПП | Доставка по СНГ';
$SITE_DESCRIPTION = 'Акции и спецпредложения на контрактные моторы и КПП в Алматы. Скидки на привозные двигатели из Малайзии. Контрактные двигатели Казахстан, Россия, Беларусь, СНГ по выгодным ценам. Ограниченные предложения. Доставка по странам СНГ.';
$SITE_KEYWORDS = 'акции контрактные моторы, скидки на двигатели алматы, спецпредложения КПП, акции двигателей бу, контрактные двигатели СНГ, доставка двигателей СНГ';
?>
<!doctype html>
<html lang="ru">
<head>
<?php include("hyst/head.php"); ?>
<link rel="canonical" href="https://motor-land.kz/actions"/>
<meta name="keywords" content="<?=$SITE_KEYWORDS;?>">
<meta property="og:type" content="website">
<meta property="og:url" content="https://motor-land.kz/actions">
<meta property="og:title" content="<?=$SITE_TITLE;?>">
<meta property="og:description" content="<?=$SITE_DESCRIPTION;?>">
<meta name="twitter:title" content="<?=$SITE_TITLE;?>">
<meta name="twitter:description" content="<?=$SITE_DESCRIPTION;?>">
<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"BreadcrumbList",
  "itemListElement":[
    {"@type":"ListItem","position":1,"name":"Главная","item":"https://motor-land.kz/"},
    {"@type":"ListItem","position":2,"name":"Акции","item":"https://motor-land.kz/actions"}
  ]
}
</script>
</head>
<body>
<?php include("hyst/sbody.php"); ?>
<?php include("des/head.php"); ?>
<main>
<br><br>
<div class="generalw">
	<div class="shirina">
		<div class="crumbsblock" itemscope itemtype="https://schema.org/BreadcrumbList">
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<a href="/" itemprop="item"><span itemprop="name">Главная</span></a>
			<meta itemprop="position" content="1" />
		</span> /
		<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
			<span itemprop="name">Акции</span>
			<meta itemprop="position" content="2" />
		</span>
		</div>
	</div>
</div>	


<div class="generalw">
	<div class="shirina zgolovorleft">
		<h1 class="sttitle"><span>Акции на контрактные двигатели в Алматы</span></h1>
		
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
		<article class="toverblock revealator-slideup" itemscope itemtype="https://schema.org/Product">
			<a href="<?=seo_get_product_url($get['id'], $get['name']);?>" itemprop="url">
				<?php 
				$product_img = get_optimized_image(get_farrimg($get['images'])[0]);
				?>
				<div class="toverimg" data-bg-src="<?=$product_img['webp'] ?: $product_img['original'];?>" aria-label="<?=htmlspecialchars('Купить контрактный мотор '.$get['name'].' Алматы - привозные моторы из Малайзии, доставка по СНГ', ENT_QUOTES, 'UTF-8');?>" itemprop="image">
			<?php if ($get['sale'] != 'noting') { ?>
			<div class="cationsale"><?=$get['sale'];?></div>
			<?php } ?>
			</div></a>
			<h2 class="tovertitle" itemprop="name"><?=$get['name'];?></h2>
			<div class="tovaropis" itemprop="description">
				<?=$get['stext'];?>
			</div>
			<div class="tovercena" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
				<?php if ($get['cash']!=0 && $get['cash']!='0') { ?>
					<span itemprop="price"><?=$get['cash'];?></span>
					<span itemprop="priceCurrency" content="KZT"> KZT</span>
				<?php } else { ?>
					<span>Цена по запросу</span>
				<?php } ?>
			</div>
			<a href="tel:<?=preg_replace('/[^\\d+]/','', get_simple_texts('index_slider_phone'));?>" class="toverbuton" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});">Купить</a>
		</article>
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
</main>
<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>

</body>
</html>