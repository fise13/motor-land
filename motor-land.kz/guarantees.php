<?php
include('hyst/php.php');
include_once('hyst/mods/customtexts/proces.php');

$SITE_TITLE = 'Гарантии | Контрактные Двигатели | Моторленд';
$SITE_DESCRIPTION = 'Гарантии на контрактные двигатели и КПП. Официальная гарантия качества от Motor Land.';
$SITE_KEYWORDS = 'гарантия контрактных двигателей, гарантия на моторы, гарантия качества двигателей';

ob_start();
?>
  <section class="section bg-primary-900 text-white">
    <div class="container-custom">
      <div class="text-center reveal">
        <h1 class="text-4xl lg:text-5xl font-bold mb-4">Гарантии</h1>
        <p class="text-xl text-primary-300">Официальная гарантия качества</p>
      </div>
    </div>
  </section>

  <section class="section bg-white">
    <div class="container-custom">
      <div class="max-w-4xl mx-auto prose prose-lg reveal">
        <?=get_customtexts('guarantees_text');?>
      </div>
    </div>
  </section>
<?php
$content = ob_get_clean();

$breadcrumbs = [
  ['name' => 'Главная', 'url' => '/', 'is_last' => false],
  ['name' => 'Гарантии', 'url' => '', 'is_last' => true],
];

$canonical_url = 'https://motor-land.kz/guarantees';
$og_url = 'https://motor-land.kz/guarantees';
$og_image = 'https://motor-land.kz/img/logo.webp';

include('components/layout.php');
?>
