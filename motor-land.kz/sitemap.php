<?php
/**
 * SEO: XML Sitemap для поисковых систем
 * Генерирует карту сайта со всеми важными страницами и товарами
 * Автоматически обновляется при добавлении новых товаров
 */
header('Content-Type: application/xml; charset=utf-8');
include('hyst/php.php');

$base_url = 'https://motor-land.kz';

// SEO: XML заголовок с правильной кодировкой
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// SEO: Главная страница - наивысший приоритет
echo '  <url>' . "\n";
echo '    <loc>' . $base_url . '/</loc>' . "\n";
echo '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
echo '    <changefreq>daily</changefreq>' . "\n";
echo '    <priority>1.0</priority>' . "\n";
echo '  </url>' . "\n";

// SEO: Основные страницы сайта с приоритетами
$pages = [
    ['/catalog', 'daily', '0.9'],      // Каталог - обновляется часто
    ['/service', 'monthly', '0.8'],     // Автосервис
    ['/pay', 'monthly', '0.8'],         // Оплата и доставка
    ['/guarantees', 'monthly', '0.8'],  // Гарантии
    ['/faq', 'monthly', '0.7'],         // FAQ - часто задаваемые вопросы
    ['/contacts', 'monthly', '0.8']     // Контакты (без .php)
];

foreach ($pages as $page) {
    echo '  <url>' . "\n";
    echo '    <loc>' . $base_url . $page[0] . '</loc>' . "\n";
    echo '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    echo '    <changefreq>' . $page[1] . '</changefreq>' . "\n";
    echo '    <priority>' . $page[2] . '</priority>' . "\n";
    echo '  </url>' . "\n";
}

// SEO: Товары из каталога - динамически добавляются с ЧПУ URL
$stmt = $_DB_CONECT->prepare("SELECT id, name FROM internet_magazin_tovari ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    // Генерируем ЧПУ URL для товара
    $product_url = seo_get_product_url($row['id'], $row['name']);
    echo '  <url>' . "\n";
    echo '    <loc>' . $base_url . htmlspecialchars($product_url, ENT_XML1, 'UTF-8') . '</loc>' . "\n";
    echo '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    echo '    <changefreq>weekly</changefreq>' . "\n";
    echo '    <priority>0.7</priority>' . "\n";
    echo '  </url>' . "\n";
    // Также добавляем старый URL с параметром для обратной совместимости (низкий приоритет)
    echo '  <url>' . "\n";
    echo '    <loc>' . $base_url . '/detal?id=' . $row['id'] . '</loc>' . "\n";
    echo '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    echo '    <changefreq>monthly</changefreq>' . "\n";
    echo '    <priority>0.5</priority>' . "\n";
    echo '  </url>' . "\n";
}

$stmt->close();

echo '</urlset>';

