<?php
include('hyst/php.php');
include_once('hyst/mods/customtexts/proces.php');

$SITE_TITLE = 'Доставка и Оплата | Контрактные Двигатели и КПП | Моторленд | Доставка по СНГ';
$SITE_DESCRIPTION = 'Доставка контрактных двигателей и КПП по Казахстану и странам СНГ (Россия, Беларусь, Украина, Кыргызстан, Узбекистан и др.). Удобные способы оплаты.';
$SITE_KEYWORDS = 'доставка двигателей алматы, оплата контрактных моторов, доставка КПП по казахстану, доставка двигателей СНГ, контрактные двигатели Россия, контрактные двигатели Беларусь, доставка по СНГ';

ob_start();
?>
  <section class="section bg-primary-900 text-white">
    <div class="container-custom">
      <div class="text-center reveal">
        <h1 class="text-4xl lg:text-5xl font-bold mb-4">Доставка и Оплата</h1>
        <p class="text-xl text-primary-300">Удобные способы оплаты и быстрая доставка</p>
      </div>
    </div>
  </section>

  <section class="section bg-white">
    <div class="container-custom">
      <div class="max-w-4xl mx-auto prose prose-lg reveal">
        <?=get_customtexts('pay_text');?>
      </div>
    </div>
  </section>
<?php
$content = ob_get_clean();

$breadcrumbs = [
  ['name' => 'Главная', 'url' => '/', 'is_last' => false],
  ['name' => 'Доставка и Оплата', 'url' => '', 'is_last' => true],
];

$canonical_url = 'https://motor-land.kz/pay';
$og_url = 'https://motor-land.kz/pay';
$og_image = 'https://motor-land.kz/img/logo.webp';

include('components/layout.php');
?>
