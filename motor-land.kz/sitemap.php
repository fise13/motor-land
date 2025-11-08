<?php
/**
 * SEO: XML Sitemap для поисковых систем
 * Генерирует карту сайта со всеми важными страницами и товарами
 * Автоматически обновляется при добавлении новых товаров
 * Поддерживает изображения в sitemap для лучшей индексации
 */
header('Content-Type: application/xml; charset=utf-8');
include('hyst/php.php');

$base_url = 'https://motor-land.kz';

// SEO: Функция для безопасного вывода URL
function escape_xml($string) {
    return htmlspecialchars($string, ENT_XML1, 'UTF-8');
}

// SEO: Функция для форматирования даты в W3C формате
function format_date($date) {
    if ($date && $date != '0000-00-00 00:00:00' && $date != '0000-00-00') {
        return date('Y-m-d', strtotime($date));
    }
    return date('Y-m-d');
}

// SEO: XML заголовок с правильной кодировкой
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
echo '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

// SEO: Главная страница - наивысший приоритет
echo '  <url>' . "\n";
echo '    <loc>' . escape_xml($base_url . '/') . '</loc>' . "\n";
echo '    <lastmod>' . format_date(date('Y-m-d')) . '</lastmod>' . "\n";
echo '    <changefreq>daily</changefreq>' . "\n";
echo '    <priority>1.0</priority>' . "\n";
echo '  </url>' . "\n";

// SEO: Основные страницы сайта с приоритетами
$pages = [
    ['/catalog.php', 'daily', '0.9'],      // Каталог - обновляется часто
    ['/catalog', 'daily', '0.9'],          // Альтернативный URL каталога
    ['/service', 'monthly', '0.8'],        // Автосервис
    ['/pay', 'monthly', '0.8'],            // Оплата и доставка
    ['/guarantees', 'monthly', '0.8'],     // Гарантии
    ['/contacts.php', 'monthly', '0.8']    // Контакты
];

foreach ($pages as $page) {
    echo '  <url>' . "\n";
    echo '    <loc>' . escape_xml($base_url . $page[0]) . '</loc>' . "\n";
    echo '    <lastmod>' . format_date(date('Y-m-d')) . '</lastmod>' . "\n";
    echo '    <changefreq>' . $page[1] . '</changefreq>' . "\n";
    echo '    <priority>' . $page[2] . '</priority>' . "\n";
    echo '  </url>' . "\n";
}

// SEO: Товары из каталога - динамически добавляются с изображениями
// Получаем товары с изображениями для добавления в image sitemap
$stmt = $_DB_CONECT->prepare("SELECT id, name, images FROM internet_magazin_tovari ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $product_url = $base_url . '/detal.php?id=' . $row['id'];
    
    echo '  <url>' . "\n";
    echo '    <loc>' . escape_xml($product_url) . '</loc>' . "\n";
    echo '    <lastmod>' . format_date(date('Y-m-d')) . '</lastmod>' . "\n";
    echo '    <changefreq>weekly</changefreq>' . "\n";
    echo '    <priority>0.7</priority>' . "\n";
    
    // SEO: Добавляем изображения товара в sitemap для лучшей индексации
    if (!empty($row['images'])) {
        $images = get_farrimg($row['images']);
        $product_name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
        
        foreach ($images as $image) {
            if (!empty($image)) {
                $image_url = (strpos($image, 'http') === 0) ? $image : $base_url . $image;
                echo '    <image:image>' . "\n";
                echo '      <image:loc>' . escape_xml($image_url) . '</image:loc>' . "\n";
                echo '      <image:title>' . escape_xml('Контрактный мотор ' . $product_name . ' Алматы') . '</image:title>' . "\n";
                echo '      <image:caption>' . escape_xml('Купить контрактный мотор ' . $product_name . ' в Алматы. Привозные моторы из Малайзии.') . '</image:caption>' . "\n";
                echo '    </image:image>' . "\n";
            }
        }
    }
    
    echo '  </url>' . "\n";
}

$stmt->close();

echo '</urlset>';

