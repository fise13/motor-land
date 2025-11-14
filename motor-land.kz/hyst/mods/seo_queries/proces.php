<?php
// Защита от повторного запуска сессии
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');

// Создание таблицы для SEO-запросов
$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = '".DB_BASE."' AND table_name = 'seo_queries'");
if ($check->num_rows == 0) {
	$_DB_CONECT->query("CREATE TABLE seo_queries (
		id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		query_text VARCHAR(500) NOT NULL,
		slug VARCHAR(255) NOT NULL,
		cluster VARCHAR(255) NOT NULL DEFAULT '',
		category VARCHAR(255) NOT NULL DEFAULT '',
		priority INT(3) NOT NULL DEFAULT 5,
		status VARCHAR(20) NOT NULL DEFAULT 'active',
		meta_title TEXT NOT NULL,
		meta_description TEXT NOT NULL,
		meta_keywords TEXT NOT NULL,
		h1_text VARCHAR(500) NOT NULL,
		content LONGTEXT NOT NULL,
		related_product_id INT(9) NOT NULL DEFAULT 0,
		search_volume INT(9) NOT NULL DEFAULT 0,
		date_added DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
		date_modified DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		INDEX idx_cluster (cluster),
		INDEX idx_status (status),
		INDEX idx_slug (slug)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
}

// Функция для автоматической кластеризации запроса
function cluster_query($query_text) {
	// Извлекаем основную модель двигателя ММЗ Д-245.12С-XXX
	// Паттерн: Двигатель ММЗ Д-245.12С-1, Двигатель ММЗ Д-245.12С-2 и т.д.
	if (preg_match('/Двигатель\s+ММЗ\s+Д-(\d+)(?:\.(\d+))?(?:\.(\d+))?(?:\.(\d+))?(?:С-(\d+))?/u', $query_text, $matches)) {
		$base_model = 'Д-'.$matches[1];
		if (!empty($matches[2])) {
			$base_model .= '.'.$matches[2];
		}
		if (!empty($matches[3])) {
			$base_model .= '.'.$matches[3];
		}
		if (!empty($matches[4])) {
			$base_model .= '.'.$matches[4];
		}
		// Если есть номер после С- (например, .12С-1, .12С-2), группируем все в один кластер
		if (!empty($matches[5])) {
			// Убираем последнюю часть с номером и добавляем .12С
			return 'ММЗ '.$base_model.'.12С'; // Группируем все варианты .12С-XXX в один кластер
		}
		return 'ММЗ '.$base_model;
	}
	
	// Если не ММЗ, ищем другие паттерны
	if (preg_match('/Двигатель\s+для\s+([^,]+)/u', $query_text, $matches)) {
		return 'Двигатель для ' . trim($matches[1]);
	}
	
	// Общая категория
	return 'Общие запросы';
}

// Функция для генерации slug из запроса
function generate_query_slug($query_text) {
	global $_DB_CONECT;
	include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
	
	$slug = hyst_translit_url(mb_strtolower($query_text));
	$slug = preg_replace('/[^a-z0-9-]/', '', $slug);
	$slug = preg_replace('/-+/', '-', $slug);
	$slug = trim($slug, '-');
	
	// Проверяем уникальность
	$original_slug = $slug;
	$counter = 1;
	$stmt = $_DB_CONECT->prepare("SELECT id FROM seo_queries WHERE slug = ?");
	while (true) {
		$stmt->bind_param("s", $slug);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows == 0) {
			break;
		}
		$slug = $original_slug . '-' . $counter;
		$counter++;
	}
	$stmt->close();
	
	return $slug;
}

// Импорт запросов из текста (массовый импорт)
if (isset($_REQUEST['seo_queries_import']) && !empty($_REQUEST['seo_queries_text'])) {
	$queries_text = trim($_REQUEST['seo_queries_text']);
	$queries = explode("\n", $queries_text);
	
	$imported = 0;
	$skipped = 0;
	
	foreach ($queries as $query_line) {
		$query_line = trim($query_line);
		if (empty($query_line)) continue;
		
		// Проверяем, существует ли уже такой запрос
		$stmt = $_DB_CONECT->prepare("SELECT id FROM seo_queries WHERE query_text = ?");
		$stmt->bind_param("s", $query_line);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows > 0) {
			$skipped++;
			$stmt->close();
			continue;
		}
		$stmt->close();
		
		// Генерируем данные для запроса
		$slug = generate_query_slug($query_line);
		$cluster = cluster_query($query_line);
		
		// Генерируем мета-теги
		$meta_title = 'Купить ' . $query_line . ' в Алматы | Контрактные двигатели | Motor Land | Доставка по СНГ';
		$meta_description = 'Купить ' . $query_line . ' в Алматы. Контрактные двигатели из Малайзии. Привозные моторы с гарантией. Быстрая доставка по Казахстану и странам СНГ (Россия, Беларусь, Украина и др.).';
		$meta_keywords = mb_strtolower($query_line) . ', купить контрактный двигатель алматы, привозные моторы, двигатель бу малайзия, контрактные двигатели СНГ, контрактные двигатели Россия, контрактные двигатели Беларусь, доставка двигателей СНГ';
		$h1_text = 'Купить ' . $query_line . ' в Алматы';
		
		// Генерируем контент
		$content = '<h2>О ' . htmlspecialchars($query_line, ENT_QUOTES, 'UTF-8') . '</h2>';
		$content .= '<p>Мы предлагаем качественные контрактные двигатели ' . htmlspecialchars($query_line, ENT_QUOTES, 'UTF-8') . ' в Алматы. Все двигатели проходят тщательную проверку перед отправкой и поставляются с гарантией качества. Осуществляем доставку по всему Казахстану и странам СНГ.</p>';
		$content .= '<h3>Преимущества покупки у нас:</h3>';
		$content .= '<ul>';
		$content .= '<li>Гарантия качества на все двигатели</li>';
		$content .= '<li>Быстрая доставка по Казахстану и странам СНГ (Россия, Беларусь, Украина, Кыргызстан, Узбекистан и др.)</li>';
		$content .= '<li>Профессиональная консультация</li>';
		$content .= '<li>Доступные цены</li>';
		$content .= '<li>Работаем с клиентами из всех стран СНГ</li>';
		$content .= '</ul>';
		
		// Вставляем запрос
		$stmt = $_DB_CONECT->prepare("INSERT INTO seo_queries (query_text, slug, cluster, meta_title, meta_description, meta_keywords, h1_text, content, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active')");
		$stmt->bind_param("ssssssss", $query_line, $slug, $cluster, $meta_title, $meta_description, $meta_keywords, $h1_text, $content);
		$stmt->execute();
		$stmt->close();
		
		$imported++;
	}
	
	echo json_encode(['success' => true, 'imported' => $imported, 'skipped' => $skipped]);
	exit;
}

// Получение списка запросов
if (isset($_REQUEST['seo_queries_get'])) {
	$cluster = isset($_REQUEST['cluster']) ? $_REQUEST['cluster'] : null;
	$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 'active';
	$limit = isset($_REQUEST['limit']) ? (int)$_REQUEST['limit'] : null;
	
	$query = "SELECT * FROM seo_queries WHERE status = ?";
	$params = [$status];
	$types = "s";
	
	if ($cluster) {
		$query .= " AND cluster = ?";
		$params[] = $cluster;
		$types .= "s";
	}
	
	$query .= " ORDER BY priority DESC, date_added DESC";
	
	if ($limit) {
		$query .= " LIMIT ?";
		$params[] = $limit;
		$types .= "i";
	}
	
	$stmt = $_DB_CONECT->prepare($query);
	if (count($params) > 0) {
		$stmt->bind_param($types, ...$params);
	}
	$stmt->execute();
	$result = $stmt->get_result();
	
	$queries = [];
	while ($row = $result->fetch_assoc()) {
		$queries[] = $row;
	}
	$stmt->close();
	
	echo json_encode($queries);
	exit;
}

// Получение одного запроса по slug
function get_seo_query($slug) {
	global $_DB_CONECT;
	
	if (!isset($_DB_CONECT) || !$_DB_CONECT) {
		return false;
	}
	
	$stmt = $_DB_CONECT->prepare("SELECT * FROM seo_queries WHERE slug = ? AND status = 'active' LIMIT 1");
	$stmt->bind_param("s", $slug);
	$stmt->execute();
	$result = $stmt->get_result();
	
	if ($result->num_rows > 0) {
		$query = $result->fetch_assoc();
		$stmt->close();
		return $query;
	}
	
	$stmt->close();
	return false;
}

// Получение кластеров
function get_seo_clusters() {
	global $_DB_CONECT;
	
	$stmt = $_DB_CONECT->query("SELECT DISTINCT cluster, COUNT(*) as count FROM seo_queries WHERE status = 'active' GROUP BY cluster ORDER BY count DESC");
	$clusters = [];
	while ($row = $stmt->fetch_assoc()) {
		$clusters[] = $row;
	}
	return $clusters;
}

// Добавление/редактирование запроса
if (isset($_REQUEST['seo_query_add'])) {
	$query_text = trim($_REQUEST['query_text']);
	$cluster = trim($_REQUEST['cluster']);
	$meta_title = trim($_REQUEST['meta_title']);
	$meta_description = trim($_REQUEST['meta_description']);
	$meta_keywords = trim($_REQUEST['meta_keywords']);
	$h1_text = trim($_REQUEST['h1_text']);
	$content = $_REQUEST['content'];
	$priority = isset($_REQUEST['priority']) ? (int)$_REQUEST['priority'] : 5;
	$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 'active';
	
	if (empty($cluster)) {
		$cluster = cluster_query($query_text);
	}
	
	$slug = generate_query_slug($query_text);
	
	$stmt = $_DB_CONECT->prepare("INSERT INTO seo_queries (query_text, slug, cluster, meta_title, meta_description, meta_keywords, h1_text, content, priority, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("ssssssssis", $query_text, $slug, $cluster, $meta_title, $meta_description, $meta_keywords, $h1_text, $content, $priority, $status);
	$stmt->execute();
	$stmt->close();
	
	echo json_encode(['success' => true]);
	exit;
}

if (isset($_REQUEST['seo_query_edit'])) {
	$id = (int)$_REQUEST['seo_query_id'];
	$query_text = trim($_REQUEST['query_text']);
	$cluster = trim($_REQUEST['cluster']);
	$meta_title = trim($_REQUEST['meta_title']);
	$meta_description = trim($_REQUEST['meta_description']);
	$meta_keywords = trim($_REQUEST['meta_keywords']);
	$h1_text = trim($_REQUEST['h1_text']);
	$content = $_REQUEST['content'];
	$priority = isset($_REQUEST['priority']) ? (int)$_REQUEST['priority'] : 5;
	$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 'active';
	
	$slug = generate_query_slug($query_text);
	
	$stmt = $_DB_CONECT->prepare("UPDATE seo_queries SET query_text = ?, slug = ?, cluster = ?, meta_title = ?, meta_description = ?, meta_keywords = ?, h1_text = ?, content = ?, priority = ?, status = ? WHERE id = ?");
	$stmt->bind_param("ssssssssisi", $query_text, $slug, $cluster, $meta_title, $meta_description, $meta_keywords, $h1_text, $content, $priority, $status, $id);
	$stmt->execute();
	$stmt->close();
	
	echo json_encode(['success' => true]);
	exit;
}

// Удаление запроса
if (isset($_REQUEST['seo_query_delete'])) {
	$id = (int)$_REQUEST['seo_query_id'];
	$stmt = $_DB_CONECT->prepare("DELETE FROM seo_queries WHERE id = ?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->close();
	
	echo json_encode(['success' => true]);
	exit;
}

?>

