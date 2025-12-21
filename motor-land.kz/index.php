<?php
include('hyst/php.php');

$SITE_TITLE = '🔥 Контрактные Двигатели СНГ | Купить Мотор Алматы | Доставка по России, Казахстану, Беларуси | Motor Land';
$SITE_DESCRIPTION = '✅ Контрактные двигатели с гарантией! Доставка по России, Казахстану, Беларуси, Украине и всему СНГ. Привозные моторы из Малайзии. Toyota, Honda, Nissan, Mazda, Mitsubishi. Большой выбор, быстрая доставка, официальная гарантия. Звоните сейчас!';
$SITE_KEYWORDS = 'купить контрактный мотор Алматы, контрактные двигатели Казахстан, контрактные двигатели Россия, контрактные двигатели Беларусь, контрактные двигатели Украина, контрактные двигатели СНГ, привозные моторы Алматы, двигатель бу Малайзия Алматы, контрактные двигатели алматы, купить мотор б/у, привозные двигатели, контрактный мотор малайзия, контрактный двигатель Toyota, контрактный двигатель Honda, контрактный двигатель Nissan, контрактный двигатель Mazda, контрактный двигатель Mitsubishi, двигатель бу, контрактные двигатели, двигатели бу, двигатель 1NZ, двигатель 2AZ, двигатель 3S, двигатель K24A, двигатель QR25DE, контрактный двигатель Camry, контрактный двигатель CRV, контрактный двигатель Corolla, контрактный двигатель Almera, контрактный двигатель Accord, доставка двигателей СНГ, контрактные моторы Беларусь, контрактные моторы Украина, контрактные двигатели Армения, контрактные двигатели Азербайджан, контрактные двигатели Грузия, контрактные двигатели Кыргызстан, контрактные двигатели Молдова, контрактные двигатели Таджикистан, контрактные двигатели Туркменистан, контрактные двигатели Узбекистан';

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
  <!-- Hero Section -->
  <section class="relative min-h-[600px] lg:min-h-[700px] flex items-center justify-center overflow-hidden">
    <?php
    $slider = get_slider('index_slider');
    $slide_index = 0;
    $first_slide = null;
    while($slide = $slider->fetch_array()):
      if ($slide_index == 0) {
        $first_slide = $slide;
      }
      $slide_index++;
    endwhile;
    
    if ($first_slide):
      $slide_img = get_optimized_image($first_slide['image']);
    ?>
    <div class="absolute inset-0 z-0">
      <picture>
        <source srcset="<?=$slide_img['webp'] ?: $slide_img['original'];?>" type="image/webp">
        <img src="<?=$slide_img['webp'] ?: $slide_img['original'];?>" 
             alt="Контрактные двигатели Motor Land" 
             class="w-full h-full object-cover"
             loading="eager"
             fetchpriority="high"
             width="1920" 
             height="700">
      </picture>
      <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/50 to-black/70"></div>
    </div>
    <?php endif; ?>

    <div class="container-custom relative z-10">
      <div class="max-w-3xl">
        <h1 class="text-4xl lg:text-6xl font-bold text-white mb-6 reveal">
          <?=get_simple_texts('index_slider_title') ?: 'Контрактные двигатели с гарантией';?>
        </h1>
        
        <div class="flex flex-col sm:flex-row gap-4 mb-12 reveal">
          <a href="tel:<?=get_simple_texts('index_slider_phone') ?: '+77771445445';?>" 
             class="btn btn-primary text-lg px-8 py-4"
             onclick="if(typeof gtag==='function'){gtag('event', 'conversion', {'send_to': 'AW-17661940869/8IrgCNzqw7QbEIWp7-VB'});}">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
            <?=get_simple_texts('index_slider_phone') ?: '+7 777 144 5445';?>
          </a>
          <a href="/catalog.php" class="btn btn-outline text-lg px-8 py-4 border-white text-white hover:bg-white hover:text-primary-900">
            Перейти в каталог
          </a>
        </div>

        <!-- Search Form -->
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 lg:p-8 reveal">
          <form method="get" action="catalog.php" class="space-y-4">
            <div class="text-white text-lg font-medium mb-4">Найти двигатель</div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <!-- Марка -->
              <div class="dropdown relative">
                <button type="button" class="dropdown-trigger w-full form-input bg-white/20 border-white/30 text-white placeholder-white/70 focus:border-white relative pr-10">
                  <span class="selected-value"><?=isset($_GET['mk']) && $_GET['mk'] != '' ? htmlspecialchars($_GET['mk'], ENT_QUOTES, 'UTF-8') : 'Марка';?></span>
                  <input type="hidden" name="mk" value="<?=isset($_GET['mk']) && $_GET['mk'] != '' ? htmlspecialchars($_GET['mk'], ENT_QUOTES, 'UTF-8') : '';?>">
                  <svg class="w-5 h-5 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>
                <div class="dropdown-menu absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-strong max-h-60 overflow-y-auto z-50 hidden text-primary-900">
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
                <button type="button" class="dropdown-trigger w-full form-input bg-white/20 border-white/30 text-white placeholder-white/70 focus:border-white relative pr-10" <?=$mark ? '' : 'disabled';?>>
                  <span class="selected-value"><?=isset($_GET['ml']) && $_GET['ml'] != '' ? htmlspecialchars($_GET['ml'], ENT_QUOTES, 'UTF-8') : 'Модель';?></span>
                  <input type="hidden" name="ml" value="<?=isset($_GET['ml']) && $_GET['ml'] != '' ? htmlspecialchars($_GET['ml'], ENT_QUOTES, 'UTF-8') : '';?>">
                  <svg class="w-5 h-5 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>
                <div class="dropdown-menu absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-strong max-h-60 overflow-y-auto z-50 hidden text-primary-900" id="modellist">
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
                <button type="button" class="dropdown-trigger w-full form-input bg-white/20 border-white/30 text-white placeholder-white/70 focus:border-white relative pr-10" <?=$mode ? '' : 'disabled';?>>
                  <span class="selected-value"><?=isset($_GET['yr']) && $_GET['yr'] != '' ? htmlspecialchars($_GET['yr'], ENT_QUOTES, 'UTF-8') : 'Год';?></span>
                  <input type="hidden" name="yr" value="<?=isset($_GET['yr']) && $_GET['yr'] != '' ? htmlspecialchars($_GET['yr'], ENT_QUOTES, 'UTF-8') : '';?>">
                  <svg class="w-5 h-5 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>
                <div class="dropdown-menu absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-strong max-h-60 overflow-y-auto z-50 hidden text-primary-900" id="yearlist">
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
    </div>
  </section>

  <!-- Consultation Section -->
  <section class="section bg-gradient-to-b from-primary-50 to-white">
    <div class="container-custom">
      <div class="max-w-2xl mx-auto text-center reveal">
        <h2 class="section-title">Хотите получить бесплатную консультацию?</h2>
        <p class="section-subtitle">Заполните форму и наш специалист свяжется с вами</p>
        
        <form method="post" class="consult-form bg-white rounded-2xl shadow-medium p-8 lg:p-12 space-y-6">
          <input type="text" name="website" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0;z-index:-1;" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="hidden" name="form_time" value="<?=time();?>" aria-hidden="true">
          
          <div>
            <label for="consult-name" class="form-label">Имя *</label>
            <input type="text" name="name" id="consult-name" class="form-input" placeholder="Ваше имя" required maxlength="100">
          </div>
          
          <div>
            <label for="consult-phone" class="form-label">Телефон *</label>
            <input type="tel" name="phon" id="consult-phone" class="form-input" placeholder="+7 (___) ___-__-__" required maxlength="20">
          </div>
          
          <input type="hidden" name="send_one" value="send">
          <button type="submit" class="btn btn-primary w-full text-lg py-4">
            Отправить
          </button>
        </form>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section class="section">
    <div class="container-custom">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
        <div class="reveal">
          <?php 
          $about_img = get_optimized_image(get_simple_images('index_about_image')[0]);
          ?>
          <div class="relative rounded-2xl overflow-hidden shadow-strong aspect-[4/3]">
            <img src="<?=$about_img['webp'] ?: $about_img['original'];?>" 
                 alt="О компании Motor Land" 
                 class="w-full h-full object-cover"
                 loading="lazy">
          </div>
        </div>
        
        <div class="reveal">
          <h2 class="section-title">О нас</h2>
          <div class="prose prose-lg max-w-none text-primary-700 leading-relaxed">
            <?=get_customtexts('index_about_text');?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Catalog Section -->
  <section class="section bg-primary-900 text-white">
    <div class="container-custom">
      <div class="text-center mb-12 reveal">
        <h2 class="text-4xl lg:text-5xl font-bold mb-4">Каталог двигателей</h2>
        <p class="text-xl text-primary-300">Большой выбор контрактных двигателей</p>
      </div>

      <!-- Tabs -->
      <div class="flex justify-center mb-12 reveal">
        <div class="inline-flex bg-primary-800 rounded-lg p-1">
          <button class="catalog-tab active px-6 py-3 rounded-lg transition-all duration-200 bg-accent text-white" data-tab="catalog">
            Каталог
          </button>
          <button class="catalog-tab px-6 py-3 rounded-lg transition-all duration-200" data-tab="sales">
            Акции
          </button>
        </div>
      </div>

      <!-- Products Grid -->
      <div id="catalog-content" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
        <?php
        $limit = 4;
        $stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_tovari ORDER BY prio ASC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $tmp = $stmt->get_result();
        while($get = $tmp->fetch_array()):
        ?>
        <article class="card card-hover reveal bg-white" itemscope itemtype="https://schema.org/Product">
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
            <h3 class="text-xl font-bold text-primary-900 mb-2" itemprop="name">
              <?=$get['name'];?>
            </h3>
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
        if (isset($stmt)) {
          $stmt->close();
        }
        ?>
      </div>

      <!-- Sales Products (hidden by default) -->
      <div id="sales-content" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 hidden">
        <?php
        $sale_value = 'noting';
        $limit = 4;
        $stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_tovari WHERE sale != ? ORDER BY prio ASC LIMIT ?");
        $stmt->bind_param("si", $sale_value, $limit);
        $stmt->execute();
        $tmp = $stmt->get_result();
        while($get = $tmp->fetch_array()):
        ?>
        <article class="card card-hover reveal bg-white" itemscope itemtype="https://schema.org/Product">
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
            <h3 class="text-xl font-bold text-primary-900 mb-2" itemprop="name">
              <?=$get['name'];?>
            </h3>
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
        if (isset($stmt)) {
          $stmt->close();
        }
        ?>
      </div>

      <div class="text-center mt-12 reveal">
        <a href="/catalog.php" class="btn btn-outline border-white text-white hover:bg-white hover:text-primary-900">
          Смотреть все товары
        </a>
      </div>
    </div>
  </section>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('.catalog-tab');
  const catalogContent = document.getElementById('catalog-content');
  const salesContent = document.getElementById('sales-content');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const targetTab = tab.dataset.tab;
      
      tabs.forEach(t => t.classList.remove('active', 'bg-accent', 'text-white'));
      tab.classList.add('active', 'bg-accent', 'text-white');
      
      if (targetTab === 'catalog') {
        catalogContent.classList.remove('hidden');
        salesContent.classList.add('hidden');
      } else {
        catalogContent.classList.add('hidden');
        salesContent.classList.remove('hidden');
      }
    });
  });
});
</script>
<style>
.catalog-tab {
  color: rgba(255, 255, 255, 0.7);
}
.catalog-tab.active {
  background: #dc2626;
  color: white;
}
</style>
<?php
$content = ob_get_clean();

$canonical_url = 'https://motor-land.kz/';
$og_url = 'https://motor-land.kz/';
$og_image = 'https://motor-land.kz/img/logo.webp';

include('components/layout.php');
?>
