<?php
include('hyst/php.php');

$SITE_TITLE = '🔥 Каталог Контрактных Моторов Алматы | Привозные Моторы Малайзия | Контрактные Двигатели Россия, Казахстан, Беларусь, СНГ';
$SITE_DESCRIPTION = '✅ Каталог контрактных моторов в Алматы. Привозные моторы из Малайзии с гарантией. Контрактные двигатели Россия, Казахстан, Беларусь, Украина и все страны СНГ - большой выбор двигателей бу. Быстрая доставка по СНГ. Звоните!';
$SITE_KEYWORDS = 'купить контрактный мотор Алматы, контрактные двигатели Казахстан, контрактные двигатели Россия, контрактные двигатели Беларусь, контрактные двигатели Украина, контрактные двигатели СНГ, привозные моторы Алматы, контрактные моторы Беларусь, контрактные моторы Украина, контрактные двигатели Армения, контрактные двигатели Азербайджан, контрактные двигатели Грузия, контрактные двигатели Кыргызстан, контрактные двигатели Молдова, контрактные двигатели Таджикистан, контрактные двигатели Туркменистан, контрактные двигатели Узбекистан, доставка двигателей СНГ';

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

ob_start();
?>
  <!-- Page Header -->
  <section class="section bg-primary-900 text-white">
    <div class="container-custom">
      <div class="text-center reveal">
        <h1 class="text-4xl lg:text-5xl font-bold mb-4">Каталог двигателей</h1>
        <p class="text-xl text-primary-300">Найдите нужный двигатель по параметрам</p>
      </div>
    </div>
  </section>

  <!-- Filters -->
  <section class="section bg-white border-b border-primary-200">
    <div class="container-custom">
      <div class="max-w-4xl mx-auto reveal">
        <form method="get" action="catalog.php" class="bg-primary-50 rounded-2xl p-6 lg:p-8">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Марка -->
            <div class="dropdown relative">
              <label class="form-label text-primary-700">Марка</label>
              <button type="button" class="dropdown-trigger w-full form-input bg-white relative pr-10">
                <span class="selected-value"><?=isset($_GET['mk']) && $_GET['mk'] != '' ? htmlspecialchars($_GET['mk'], ENT_QUOTES, 'UTF-8') : 'Выберите марку';?></span>
                <input type="hidden" name="mk" value="<?=isset($_GET['mk']) && $_GET['mk'] != '' ? htmlspecialchars($_GET['mk'], ENT_QUOTES, 'UTF-8') : '';?>">
                <svg class="w-5 h-5 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              <div class="dropdown-menu absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-strong max-h-60 overflow-y-auto z-50 hidden">
                <?php
                $parent_id = 'noting';
                $stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_category WHERE idp = ? ORDER BY id ASC");
                $stmt->bind_param("s", $parent_id);
                $stmt->execute();
                $tmp = $stmt->get_result();
                if ($tmp->num_rows != 0) {
                  while($get = $tmp->fetch_array()):
                ?>
                <div class="dropdown-item px-4 py-2 hover:bg-primary-100 cursor-pointer" data-value="<?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?>" data-id="<?=$get['id'];?>">
                  <?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?>
                </div>
                <?php
                  endwhile;
                }
                $stmt->close();
                ?>
              </div>
            </div>

            <!-- Модель -->
            <div class="dropdown relative">
              <label class="form-label text-primary-700">Модель</label>
              <button type="button" class="dropdown-trigger w-full form-input bg-white relative pr-10" <?=$mark ? '' : 'disabled';?>>
                <span class="selected-value"><?=isset($_GET['ml']) && $_GET['ml'] != '' ? htmlspecialchars($_GET['ml'], ENT_QUOTES, 'UTF-8') : 'Выберите модель';?></span>
                <input type="hidden" name="ml" value="<?=isset($_GET['ml']) && $_GET['ml'] != '' ? htmlspecialchars($_GET['ml'], ENT_QUOTES, 'UTF-8') : '';?>">
                <svg class="w-5 h-5 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              <div class="dropdown-menu absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-strong max-h-60 overflow-y-auto z-50 hidden" id="modellist">
                <?php
                if ($mark) {
                  $stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_category WHERE idp = ? ORDER BY id ASC");
                  $stmt->bind_param("i", $mark);
                  $stmt->execute();
                  $tmp = $stmt->get_result();
                  if ($tmp->num_rows != 0) {
                    while($get = $tmp->fetch_array()):
                ?>
                <div class="dropdown-item px-4 py-2 hover:bg-primary-100 cursor-pointer" data-value="<?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?>" data-id="<?=$get['id'];?>">
                  <?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?>
                </div>
                <?php
                    endwhile;
                  }
                  $stmt->close();
                }
                ?>
              </div>
            </div>

            <!-- Год -->
            <div class="dropdown relative">
              <label class="form-label text-primary-700">Год</label>
              <button type="button" class="dropdown-trigger w-full form-input bg-white relative pr-10" <?=$mode ? '' : 'disabled';?>>
                <span class="selected-value"><?=isset($_GET['yr']) && $_GET['yr'] != '' ? htmlspecialchars($_GET['yr'], ENT_QUOTES, 'UTF-8') : 'Выберите год';?></span>
                <input type="hidden" name="yr" value="<?=isset($_GET['yr']) && $_GET['yr'] != '' ? htmlspecialchars($_GET['yr'], ENT_QUOTES, 'UTF-8') : '';?>">
                <svg class="w-5 h-5 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              <div class="dropdown-menu absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-strong max-h-60 overflow-y-auto z-50 hidden" id="yearlist">
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
                <div class="dropdown-item px-4 py-2 hover:bg-primary-100 cursor-pointer" data-value="<?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?>" data-id="<?=$get['id'];?>">
                  <?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?>
                </div>
                <?php
                    endwhile;
                  }
                  $stmt->close();
                }
                ?>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary w-full">
            Найти двигатель
          </button>
        </form>
      </div>
    </div>
  </section>

  <!-- Products Grid -->
  <section class="section bg-white">
    <div class="container-custom">
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
      ?>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8">
        <?php
        while($get = $tmps->fetch_array()):
        ?>
        <article class="card card-hover reveal" itemscope itemtype="https://schema.org/Product">
          <a href="/detal.php?id=<?=$get['id'];?>" class="block">
            <?php 
            $product_img = get_optimized_image(get_farrimg($get['images'])[0]);
            ?>
            <div class="relative aspect-square overflow-hidden bg-primary-100">
              <img src="<?=$product_img['webp'] ?: $product_img['original'];?>" 
                   alt="<?=htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8');?>"
                   class="w-full h-full object-cover transition-transform duration-300 hover:scale-110"
                   loading="lazy"
                   itemprop="image">
              <?php if ($get['sale'] != 'noting') { ?>
              <div class="absolute top-4 right-4 bg-accent text-white px-3 py-1 rounded-full text-sm font-bold">
                <?=$get['sale'];?>
              </div>
              <?php } ?>
            </div>
          </a>
          
          <div class="p-6">
            <h2 class="text-xl font-bold text-primary-900 mb-2" itemprop="name">
              <?=$get['name'];?>
            </h2>
            <p class="text-primary-600 text-sm mb-4 line-clamp-2" itemprop="description">
              <?=$get['stext'];?>
            </p>
            <div class="flex items-center justify-between mb-4">
              <div class="text-2xl font-bold text-primary-900" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                <?php if ($get['cash'] != 0 && $get['cash'] != '0') { ?>
                <span itemprop="price"><?=$get['cash'];?></span>
                <span itemprop="priceCurrency" content="KZT"> KZT</span>
                <?php } else { ?>
                <span>Цена по запросу</span>
                <?php } ?>
              </div>
            </div>
            <a href="tel:<?=preg_replace('/[^\\d+]/','', get_simple_texts('index_slider_phone'));?>" 
               class="btn btn-primary w-full"
               onclick="if(typeof gtag==='function'){gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});}">
              Купить
            </a>
          </div>
        </article>
        <?php
        endwhile;
        ?>
      </div>
      <?php
      } else {
      ?>
      <div class="text-center py-16 reveal">
        <p class="text-xl text-primary-600 mb-4">По вашему запросу ничего не найдено</p>
        <a href="/catalog.php" class="btn btn-primary">Сбросить фильтры</a>
      </div>
      <?php
      }
      if (isset($stmt)) {
        $stmt->close();
      }
      ?>
    </div>
  </section>
<?php
$content = ob_get_clean();

$breadcrumbs = [
  ['name' => 'Главная', 'url' => '/', 'is_last' => false],
  ['name' => 'Каталог', 'url' => '', 'is_last' => true],
];

$canonical_url = 'https://motor-land.kz/catalog';
$og_url = 'https://motor-land.kz/catalog';
$og_image = 'https://motor-land.kz/img/logo.webp';

$additional_head = '
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
</script>';

include('components/layout.php');
?>
