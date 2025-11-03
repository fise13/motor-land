<?php
include('hyst/php.php');

$SITE_TITLE = 'Моторленд | Контрактные Моторы и КПП';
$SITE_DESCRIPTION = 'Компания "Motor Land" - поставка контрактных двигателей и КПП в Алматы';
?>
<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include("hyst/head.php"); ?>
<link rel="canonical" href="https://motor-land.kz/"/> 
</head>
<body>
<?php include("hyst/sbody.php"); ?>
<?php include("des/head.php"); ?>

<div class="slider">
	<div id="slidess">
		<?php
		$slider = get_slider ('index_slider');
		while($slide=$slider->fetch_array()):
		?>
		<div class="sliderslid" style="background-image: url(<?=$slide['image'];?>);"></div>
		<?php
		endwhile;
		?>
	</div>
	<script>
		/**
		 * Функция: Автоматическая смена слайдов
		 * Описание: Переключает слайды в главном слайдере каждые 3 секунды.
		 * 			Находит текущий отображаемый слайд и плавно показывает следующий.
		 * Параметры: нет
		 * Возвращает: ничего
		 */
		function slider () {
			var cil = $("#slidess").children('div').length - 1;
			var cur = 0;
			$("#slidess").children('div').each(function(index, element){	
				if ($(element).css('display') == 'block') {
				cur = index;
				}	
			});
			
			if (cur >= cil) { cur = 0; } else { cur++; }
			
			$("#slidess").children('div').each(function(index, element){	
				if ($(element).css('display') == 'block') { $(element).fadeOut(500); }
				if (cur == index) {
				$(element).fadeIn(500);
				}	
			});
			
			setTimeout(function() { slider () }, 3000);
		}
		
		setTimeout(function() { slider () }, 3000);
		</script>
	<div class="slidercoun shirina">
					
		<div class="titlephon"><?=get_simple_texts ('index_slider_title');?></div>
		<div class="sliderbtns"><a href="tel:<?=get_simple_texts ('index_slider_phone');?>" class="phone" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});"><?=get_simple_texts ('index_slider_phone');?></a><br><a href="catalog.php"><div class="atalogb">Каталог</div></a></div>
		<div class="sliderform">что ищем?
		
		
		<!---
		<form method="get" action="catalog.php">
		<input type="text" name="mk" placeholder="Марка" list="makrlist" id="idmark">
			<datalist id="makrlist">
			</datalist>
		<input type="text" name="nl" placeholder="Модель" list="modellist" id="idmode">
			<datalist id="modellist">
			</datalist>
		<input type="text" name="yr" placeholder="Год" list="yearlist" id="idyear">
			<datalist id="yearlist">
			</datalist>
		<input type="submit" name="sear" value=" ">
		</form>--->
			
		<form method="get" action="catalog.php">
			<!--<input type="text" name="setxt" class="searchbloinput" placeholder="Что вы хотели найти.."><br>--->
		
			<div class="maipttee">
				<div class="meinputer"><div class="madiv" data-val="Марка">Марка</div>
					<input type="hidden" name="mk">
					<div class="btmmearrow">&#9660;</div>
					<div class="ddwnblock">
						<?php
						$parent_id = 'noting';
						$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_category WHERE idp = ? ORDER BY name ASC");
						$stmt->bind_param("s", $parent_id);
						$stmt->execute();
						$sql = $stmt->get_result();
						if ($sql->num_rows != 0) {
							while($get = $sql->fetch_array()):
							?>
							<div data-id="<?=$get['id'];?>"><?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?></div>
							<?php
							endwhile;
						}
						$stmt->close();
						?>
					</div>
				</div>
				
				<div class="meinputer"><div class="madiv" data-val="Модель">Модель</div>
					<input type="hidden" name="ml">
					<div class="btmmearrow">&#9660;</div>
					<div class="ddwnblock" id="modellist"></div>
				</div>
				
				<div class="meinputer"><div class="madiv" data-val="Год">Год</div>
					<input type="hidden" name="yr">
					<div class="btmmearrow">&#9660;</div>
					<div class="ddwnblock" id="yearlist" style="overflow-y: scroll;"></div>
				</div>
			</div>
			<input type="submit" name="sear" value=" ">
		</form>
		</div>
	</div>
</div>

<div class="generalw forsbgf consult-section">
	<div class="shirina forsliderform JF_parent_form consult-container">
		<div class="consult-title">Хотите получить бесплатную консультацию?</div>
		<div class="consult-subtitle">заполните форму</div>
		<form method="post" class="consult-form">
			<div class="form-control consult-form-control">
				<label for="consult-name">Имя</label>
				<input type="text" name="name" id="consult-name" class="consult-input consult-name" placeholder="Имя" required>
			</div>
			<div class="form-control consult-form-control">
				<label for="consult-phone">Телефон</label>
				<input type="text" name="phon" id="consult-phone" class="consult-input consult-phone" placeholder="Телефон" required>
			</div>
			<div class="consult-btn-wrapper">
				<input type="hidden" name="send_one" value="send">
				<button type="button" name="JF_send_casual" class="consult-btn"><span>Отправить</span></button>
			</div>
		</form>
	</div>
</div>

<div class="generalw">
	<div class="shirina zgolovorleft">
		<div class="sttitle"><span>О нас</span></div>
	</div>
</div>

<div class="generalw">
	<div class="shirina">
		<div class="aboutblock">
			<div class="sssskartins revealator-slideright" style="background-image: url(<?=get_simple_images('index_about_image')[0];?>);"></div>
			<div class="abouttext revealator-slideleft">
			<?=get_customtexts('index_about_text');?>
			</div>
		</div>
	</div>
</div>

<div class="generalw">
	<div class="shirina zgolovorright">
	</div>
</div>

<div class="generalw frayalpfhon">
	<div class="shirina">
		<ul class="actionbtms">
			<li class="liacactive" data-typ="ac">Каталог</li>
			<li data-typ="ca">Акции</li>
		</ul>
	</div>
</div>

<div class="generalw">
	<div class="shirina">
		<br>
		<div id="actionb">
			<?php
			$limit = 4;
			$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_tovari ORDER BY prio ASC LIMIT ?");
			$stmt->bind_param("i", $limit);
			$stmt->execute();
			$tmp = $stmt->get_result();
			while($get = $tmp->fetch_array()):
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
			if (isset($stmt)) {
				$stmt->close();
			}
			?>
		</div>
		<div id="goodsb" style="display: none;">
			<?php
			$sale_value = 'noting';
			$limit = 4;
			$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_tovari WHERE sale != ? ORDER BY prio ASC LIMIT ?");
			$stmt->bind_param("si", $sale_value, $limit);
			$stmt->execute();
			$tmp = $stmt->get_result();
			while($get = $tmp->fetch_array()):
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
			<a href="tel:<?=preg_replace('/[^\\d+]/','', get_simple_texts('index_slider_phone'));?>" class="toverbuton" onclick="gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});">Позвонить</a>
			</div>
			<?php
			endwhile;
			if (isset($stmt)) {
				$stmt->close();
			}
			?>			
		</div>
		<br>
		<br>
		<a href="/catalog"><div class="okazatybolsh">Показать больше</div></a>
		<br>
		<br>
	</div>
</div>

<?php include("des/foter.php"); ?>
<?php include("hyst/fbody.php"); ?>
</body>
</html>