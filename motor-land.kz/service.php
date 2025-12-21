<?php
include('hyst/php.php');
include_once('hyst/mods/customtexts/proces.php');

$SITE_TITLE = 'Автосервис - Замена Двигателей и КПП в Алматы | Моторленд | Доставка по СНГ';
$SITE_DESCRIPTION = 'Профессиональная замена и обслуживание контрактных двигателей и КПП в Алматы. Доставка контрактных двигателей по Казахстану и странам СНГ.';
$SITE_KEYWORDS = 'замена двигателя алматы, автосервис замена КПП, установка контрактного двигателя, доставка двигателей СНГ, контрактные двигатели Россия, контрактные двигатели Беларусь';

ob_start();
?>
  <section class="section bg-primary-900 text-white">
    <div class="container-custom">
      <div class="text-center reveal">
        <h1 class="text-4xl lg:text-5xl font-bold mb-4">Автосервис</h1>
        <p class="text-xl text-primary-300">Профессиональная замена и обслуживание двигателей</p>
      </div>
    </div>
  </section>

  <section class="section bg-white">
    <div class="container-custom">
      <div class="max-w-4xl mx-auto prose prose-lg reveal">
        <?=get_customtexts('service_text');?>
      </div>
    </div>
  </section>
<?php
$content = ob_get_clean();

$breadcrumbs = [
  ['name' => 'Главная', 'url' => '/', 'is_last' => false],
  ['name' => 'Автосервис', 'url' => '', 'is_last' => true],
];

$canonical_url = 'https://motor-land.kz/service';
$og_url = 'https://motor-land.kz/service';
$og_image = 'https://motor-land.kz/img/logo.webp';

include('components/layout.php');
?>
