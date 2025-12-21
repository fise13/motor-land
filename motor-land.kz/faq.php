<?php
include('hyst/php.php');

$SITE_TITLE = 'FAQ | Часто задаваемые вопросы | Моторленд';
$SITE_DESCRIPTION = 'Часто задаваемые вопросы о контрактных двигателях, доставке, гарантии и оплате.';
$SITE_KEYWORDS = 'FAQ контрактные двигатели, вопросы о моторах, доставка двигателей СНГ';

ob_start();
?>
  <section class="section bg-primary-900 text-white">
    <div class="container-custom">
      <div class="text-center reveal">
        <h1 class="text-4xl lg:text-5xl font-bold mb-4">Часто задаваемые вопросы</h1>
        <p class="text-xl text-primary-300">Ответы на популярные вопросы</p>
      </div>
    </div>
  </section>

  <section class="section bg-white">
    <div class="container-custom">
      <div class="max-w-4xl mx-auto space-y-6">
        <div class="card reveal p-8">
          <h2 class="text-2xl font-bold text-primary-900 mb-4">Доставляете ли вы контрактные двигатели в Россию, Беларусь и другие страны СНГ?</h2>
          <p class="text-primary-700">Да, мы доставляем контрактные двигатели во все страны СНГ: Россия, Беларусь, Украина, Армения, Азербайджан, Грузия, Кыргызстан, Молдова, Таджикистан, Туркменистан, Узбекистан. Доставка осуществляется надежными транспортными компаниями с полной страховкой груза.</p>
        </div>

        <div class="card reveal p-8">
          <h2 class="text-2xl font-bold text-primary-900 mb-4">Какая гарантия на контрактные двигатели?</h2>
          <p class="text-primary-700">На все контрактные двигатели предоставляется официальная гарантия. Срок гарантии зависит от модели двигателя и условий покупки. Подробности гарантии уточняйте у наших менеджеров.</p>
        </div>

        <div class="card reveal p-8">
          <h2 class="text-2xl font-bold text-primary-900 mb-4">Откуда привозные моторы?</h2>
          <p class="text-primary-700">Мы привозим контрактные двигатели из Малайзии. Все моторы проходят тщательную проверку перед отправкой. Мы работаем только с проверенными поставщиками и гарантируем качество.</p>
        </div>

        <div class="card reveal p-8">
          <h2 class="text-2xl font-bold text-primary-900 mb-4">Сколько стоит доставка контрактного двигателя в Россию или Беларусь?</h2>
          <p class="text-primary-700">Стоимость доставки зависит от веса и габаритов двигателя, а также от региона доставки. Мы рассчитаем точную стоимость доставки после выбора конкретного двигателя. Доставка по Казахстану и странам СНГ осуществляется надежными транспортными компаниями.</p>
        </div>

        <div class="card reveal p-8">
          <h2 class="text-2xl font-bold text-primary-900 mb-4">Как быстро можно получить контрактный двигатель?</h2>
          <p class="text-primary-700">Сроки доставки зависят от наличия двигателя на складе и региона доставки. Обычно доставка по Казахстану занимает 2-5 дней, в страны СНГ - 5-14 дней. При наличии на складе можем отправить в день заказа.</p>
        </div>

        <div class="card reveal p-8">
          <h2 class="text-2xl font-bold text-primary-900 mb-4">Какие марки контрактных двигателей у вас есть?</h2>
          <p class="text-primary-700">У нас большой выбор контрактных двигателей для автомобилей Toyota, Honda, Nissan, Mazda, Mitsubishi, Hyundai, Kia и других популярных марок. В каталоге представлены двигатели различных моделей и годов выпуска.</p>
        </div>
      </div>
    </div>
  </section>
<?php
$content = ob_get_clean();

$breadcrumbs = [
  ['name' => 'Главная', 'url' => '/', 'is_last' => false],
  ['name' => 'FAQ', 'url' => '', 'is_last' => true],
];

$canonical_url = 'https://motor-land.kz/faq';
$og_url = 'https://motor-land.kz/faq';
$og_image = 'https://motor-land.kz/img/logo.webp';

include('components/layout.php');
?>
