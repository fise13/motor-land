<?php
include('hyst/php.php');

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
		header('Location: /catalog.php');
		exit;
	}
} else {
	header('Location: /catalog.php');
	exit;
}

$product_name = htmlspecialchars($print['name'], ENT_QUOTES, 'UTF-8');
$product_meta = htmlspecialchars($print['tmeta'], ENT_QUOTES, 'UTF-8');
$SITE_TITLE = '✅ Купить Контрактный Мотор '.$product_name.' Алматы | Привозные Моторы Малайзия | Моторленд | Доставка по России, Казахстану, Беларуси, СНГ';
$SITE_DESCRIPTION = '🔥 Купить контрактный мотор '.$product_name.' в Алматы. Привозные моторы из Малайзии с гарантией. '.$product_meta.'. Двигатель бу Малайзия Алматы. Контрактные двигатели Россия, Казахстан, Беларусь, Украина и все страны СНГ. Быстрая доставка по СНГ. Цена: '.($print['cash']!=0?$print['cash'].' KZT':'уточняйте').'. Звоните сейчас!';
$SITE_KEYWORDS = 'купить контрактный мотор '.mb_strtolower($product_name).' алматы, привозные моторы '.mb_strtolower($product_name).', двигатель бу малайзия алматы, контрактные двигатели казахстан, контрактные двигатели россия, контрактные двигатели беларусь, контрактные двигатели украина, контрактные двигатели СНГ, '.mb_strtolower($product_meta).', контрактный двигатель Toyota, контрактный двигатель Honda, контрактный двигатель Nissan, двигатель бу, контрактные двигатели, двигатели бу, доставка двигателей СНГ, контрактные моторы Беларусь, контрактные моторы Украина, контрактные двигатели Армения, контрактные двигатели Азербайджан, контрактные двигатели Грузия, контрактные двигатели Кыргызстан, контрактные двигатели Молдова, контрактные двигатели Таджикистан, контрактные двигатели Туркменистан, контрактные двигатели Узбекистан';

$product_image = get_farrimg($print['images'])[0];
$product_image_url = (strpos($product_image, 'http') === 0) ? $product_image : 'https://motor-land.kz'.$product_image;

$canonical_url = seo_get_product_url($print['id'], $print['name']);
$full_canonical_url = 'https://motor-land.kz' . $canonical_url;

if (preg_match('#^/detal(\.php)?$#', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) && isset($_GET['id']) && !preg_match('#^/katalog/#', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
	header('Location: ' . $canonical_url, true, 301);
	exit;
}

ob_start();
?>
  <!-- Product Detail -->
  <section class="section bg-white">
    <div class="container-custom">
      <article itemscope itemtype="https://schema.org/Product">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
          <!-- Product Image -->
          <div class="reveal">
            <?php 
            $product_img = get_optimized_image(get_farrimg($print['images'])[0]);
            ?>
            <div class="relative rounded-2xl overflow-hidden shadow-strong bg-primary-100 aspect-square">
              <img src="<?=$product_img['webp'] ?: $product_img['original'];?>" 
                   alt="<?='Купить контрактный мотор '.$product_name.' Алматы';?>"
                   class="w-full h-full object-cover"
                   loading="eager"
                   fetchpriority="high"
                   itemprop="image">
              <?php if ($print['sale'] != 'noting') { ?>
              <div class="absolute top-4 right-4 bg-accent text-white px-4 py-2 rounded-full text-lg font-bold">
                <?=$print['sale'];?>
              </div>
              <?php } ?>
            </div>
          </div>

          <!-- Product Info -->
          <div class="reveal">
            <h1 class="text-3xl lg:text-4xl font-bold text-primary-900 mb-6" itemprop="name">
              <?=$print['name'];?>
            </h1>

            <div class="mb-6" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
              <?php if ($print['cash'] != 0 && $print['cash'] != '0') { ?>
              <div class="text-4xl font-bold text-primary-900 mb-2">
                <span itemprop="price"><?=number_format($print['cash'], 0, '.', ' ');?></span>
                <span itemprop="priceCurrency" content="KZT" class="text-2xl"> KZT</span>
              </div>
              <?php } else { ?>
              <div class="text-2xl font-bold text-primary-600">
                Цена по запросу
              </div>
              <?php } ?>
              <link itemprop="availability" href="https://schema.org/InStock" />
            </div>

            <a href="tel:<?=preg_replace('/[^\\d+]/','', get_simple_texts('index_slider_phone'));?>" 
               class="btn btn-primary w-full text-lg py-4 mb-8"
               onclick="if(typeof gtag==='function'){gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});}">
              <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
              Купить сейчас
            </a>

            <div class="prose prose-lg max-w-none text-primary-700" itemprop="description">
              <?php
              $text = $print['text'];
              $text = preg_replace('/В наличии\s*[-–—]\s*на выбор более\s*\d+шт\.?/iu', '', $text);
              $text = preg_replace('/В наличии\s*на выбор более\s*\d+шт\.?/iu', '', $text);
              $text = preg_replace('/на выбор более\s*\d+шт\.?/iu', '', $text);
              echo $text;
              ?>
            </div>
          </div>
        </div>
      </article>
    </div>
  </section>
<?php
$content = ob_get_clean();

$breadcrumbs = [
  ['name' => 'Главная', 'url' => '/', 'is_last' => false],
  ['name' => 'Каталог', 'url' => '/catalog.php', 'is_last' => false],
  ['name' => $product_name, 'url' => '', 'is_last' => true],
];

$canonical_url = $full_canonical_url;
$og_url = 'https://motor-land.kz/detal?id='.$print['id'];
$og_image = $product_image_url;

$additional_head = '
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "'.$product_name.'",
  "description": "Купить контрактный мотор '.$product_name.' в Алматы. Привозные моторы из Малайзии с гарантией.",
  "image": "'.$product_image_url.'",
  "brand": {
    "@type": "Brand",
    "name": "Motor Land"
  },
  "offers": {
    "@type": "Offer",
    "url": "https://motor-land.kz/detal?id='.$print['id'].'",
    "priceCurrency": "KZT",
    "price": "'.($print['cash'] != 0 && $print['cash'] != '0' ? $print['cash'] : '0').'",
    "availability": "https://schema.org/InStock"
  }
}
</script>';

include('components/layout.php');
?>
