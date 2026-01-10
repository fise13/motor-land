<?php
header('Content-Type: application/xml; charset=utf-8');
include('hyst/php.php');

$base_url = 'https://motor-land.kz';

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

echo '  <url>' . "\n";
echo '    <loc>' . $base_url . '/</loc>' . "\n";
echo '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
echo '    <changefreq>daily</changefreq>' . "\n";
echo '    <priority>1.0</priority>' . "\n";
// Hreflang для главной страницы - улучшает региональную индексацию
echo '    <xhtml:link rel="alternate" hreflang="ru" href="' . $base_url . '/" />' . "\n";
echo '    <xhtml:link rel="alternate" hreflang="kz" href="' . $base_url . '/" />' . "\n";
echo '    <xhtml:link rel="alternate" hreflang="by" href="' . $base_url . '/" />' . "\n";
echo '    <xhtml:link rel="alternate" hreflang="ua" href="' . $base_url . '/" />' . "\n";
echo '    <xhtml:link rel="alternate" hreflang="x-default" href="' . $base_url . '/" />' . "\n";
echo '  </url>' . "\n";

// SEO: Оптимизированные приоритеты и частоты обновления для страниц
$pages = [
    ['/catalog', 'daily', '0.9'],
    ['/service', 'monthly', '0.8'],
    ['/pay', 'monthly', '0.8'],
    ['/guarantees', 'monthly', '0.8'],
    ['/faq', 'monthly', '0.7'],
    ['/blog', 'weekly', '0.8'],
    ['/contacts', 'monthly', '0.8'],
    ['/actions', 'weekly', '0.7']
];

foreach ($pages as $page) {
    echo '  <url>' . "\n";
    echo '    <loc>' . $base_url . $page[0] . '</loc>' . "\n";
    echo '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    echo '    <changefreq>' . $page[1] . '</changefreq>' . "\n";
    echo '    <priority>' . $page[2] . '</priority>' . "\n";
    echo '  </url>' . "\n";
}

// SEO: Проверяем наличие функции get_farrimg перед использованием
if (!function_exists('get_farrimg')) {
    require_once('hyst/core/functions.php');
}

$stmt = $_DB_CONECT->prepare("SELECT id, name, images FROM internet_magazin_tovari ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    // Используем только ЧПУ URL для товаров (SEO-friendly)
    $product_url = seo_get_product_url($row['id'], $row['name']);
    $product_name = htmlspecialchars($row['name'], ENT_XML1, 'UTF-8');
    echo '  <url>' . "\n";
    echo '    <loc>' . $base_url . htmlspecialchars($product_url, ENT_XML1, 'UTF-8') . '</loc>' . "\n";
    echo '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
    echo '    <changefreq>weekly</changefreq>' . "\n";
    echo '    <priority>0.8</priority>' . "\n";
    // Добавляем изображение товара в sitemap для лучшей индексации
    if (!empty($row['images'])) {
        $images = get_farrimg($row['images']);
        if (!empty($images[0])) {
            $img_path = (strpos($images[0], 'http') === 0) ? $images[0] : $base_url . $images[0];
            echo '    <image:image>' . "\n";
            echo '      <image:loc>' . htmlspecialchars($img_path, ENT_XML1, 'UTF-8') . '</image:loc>' . "\n";
            echo '      <image:title>' . $product_name . ' - Контрактный мотор</image:title>' . "\n";
            echo '      <image:caption>Купить ' . $product_name . ' в Алматы - привозные моторы из Малайзии</image:caption>' . "\n";
            echo '    </image:image>' . "\n";
        }
    }
    echo '  </url>' . "\n";
    // Не добавляем /detal?id= - это дубликат, используем только ЧПУ URL
}

$stmt->close();

include_once('hyst/mods/blog/proces.php');
$blog_articles = get_blog_articles(null, null, 'published');
foreach ($blog_articles as $article) {
    $article_url = '/blog/' . htmlspecialchars($article['slug'], ENT_XML1, 'UTF-8');
    $article_title = !empty($article['title']) ? htmlspecialchars($article['title'], ENT_XML1, 'UTF-8') : 'Статья';
    $lastmod = !empty($article['date_modified']) ? date('Y-m-d', strtotime($article['date_modified'])) : date('Y-m-d');
    echo '  <url>' . "\n";
    echo '    <loc>' . $base_url . $article_url . '</loc>' . "\n";
    echo '    <lastmod>' . $lastmod . '</lastmod>' . "\n";
    echo '    <changefreq>monthly</changefreq>' . "\n";
    echo '    <priority>0.6</priority>' . "\n";
    // Добавляем изображение статьи в sitemap
    if (!empty($article['image'])) {
        $img_path = (strpos($article['image'], 'http') === 0) ? $article['image'] : $base_url . $article['image'];
        echo '    <image:image>' . "\n";
        echo '      <image:loc>' . htmlspecialchars($img_path, ENT_XML1, 'UTF-8') . '</image:loc>' . "\n";
        echo '      <image:title>' . $article_title . '</image:title>' . "\n";
        echo '      <image:caption>' . htmlspecialchars(strip_tags(!empty($article['description']) ? $article['description'] : ''), ENT_XML1, 'UTF-8') . '</image:caption>' . "\n";
        echo '    </image:image>' . "\n";
    }
    echo '  </url>' . "\n";
}

if (file_exists('hyst/mods/seo_queries/proces.php')) {
    include_once('hyst/mods/seo_queries/proces.php');
    if (function_exists('get_seo_clusters')) {
        $clusters = get_seo_clusters();
        foreach ($clusters as $cluster) {
            echo '  <url>' . "\n";
            echo '    <loc>' . $base_url . '/query-cluster/' . htmlspecialchars(urlencode($cluster['cluster']), ENT_XML1, 'UTF-8') . '</loc>' . "\n";
            echo '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
            echo '    <changefreq>weekly</changefreq>' . "\n";
            echo '    <priority>0.7</priority>' . "\n";
            echo '  </url>' . "\n";
        }
    }
}

if (file_exists('hyst/mods/seo_queries/proces.php')) {
    include_once('hyst/mods/seo_queries/proces.php');
    $stmt = $_DB_CONECT->prepare("SELECT slug, date_modified, priority FROM seo_queries WHERE status = 'active' ORDER BY priority DESC, date_modified DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($query = $result->fetch_assoc()) {
        echo '  <url>' . "\n";
        echo '    <loc>' . $base_url . '/query/' . htmlspecialchars($query['slug'], ENT_XML1, 'UTF-8') . '</loc>' . "\n";
        echo '    <lastmod>' . date('Y-m-d', strtotime($query['date_modified'])) . '</lastmod>' . "\n";
        echo '    <changefreq>monthly</changefreq>' . "\n";
        $priority = 0.5 + ($query['priority'] / 10 * 0.3);
        echo '    <priority>' . number_format($priority, 1) . '</priority>' . "\n";
        echo '  </url>' . "\n";
    }
    $stmt->close();
}

echo '</urlset>';

