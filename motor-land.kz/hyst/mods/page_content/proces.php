<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');

// Функции get_simple_texts и get_customtexts теперь в hyst/core/functions.php

// Создание таблицы для контента страниц
$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = '".DB_BASE."' AND table_name = 'page_content'");
if ($check->num_rows == 0) {
	$_DB_CONECT->query("CREATE TABLE page_content (
		id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		page_key VARCHAR(100) NOT NULL UNIQUE,
		page_name VARCHAR(255) NOT NULL,
		h1_text VARCHAR(500) NOT NULL,
		content LONGTEXT NOT NULL,
		meta_title VARCHAR(255) NOT NULL,
		meta_description TEXT NOT NULL,
		meta_keywords TEXT NOT NULL,
		date_modified DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		INDEX idx_page_key (page_key)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
	
	// Инициализация страниц с дефолтными значениями
	$default_pages = [
		['catalog_page', 'Каталог', 'Каталог', '<p>Большой выбор контрактных двигателей и КПП</p>', 'Каталог Контрактных Моторов Алматы | Привозные Моторы Малайзия | Контрактные Двигатели Казахстан', 'Каталог контрактных моторов в Алматы. Привозные моторы из Малайзии.', 'купить контрактный мотор Алматы, контрактные двигатели Казахстан'],
		['service_page', 'Автосервис', 'Замена Контрактного Двигателя в Алматы', '<p>Профессиональная замена и обслуживание контрактных двигателей и КПП</p>', 'Автосервис - Замена Двигателей и КПП в Алматы | Моторленд', 'Профессиональная замена и обслуживание контрактных двигателей и КПП в Алматы.', 'замена двигателя алматы, автосервис замена КПП'],
		['pay_page', 'Оплата и Доставка', 'Доставка и Оплата Контрактных Двигателей', '<p>Доставка контрактных двигателей и КПП по Казахстану и СНГ</p>', 'Доставка и Оплата | Контрактные Двигатели и КПП | Моторленд', 'Доставка контрактных двигателей и КПП по Казахстану и СНГ.', 'доставка двигателей алматы, оплата контрактных моторов'],
		['guarantees_page', 'Гарантии', 'Гарантия на Контрактные Двигатели и КПП', '<p>Гарантии на контрактные двигатели и КПП в Алматы</p>', 'Гарантии на Контрактные Двигатели и КПП | Моторленд', 'Гарантии на контрактные двигатели и КПП в Алматы.', 'гарантия на контрактные двигатели, гарантия на КПП'],
		['contacts_page', 'Контакты', 'Контакты', '<p>Контакты компании Motor Land в Алматы</p>', 'Контакты | Моторленд - Контрактные Двигатели и КПП в Алматы', 'Контакты компании Motor Land в Алматы.', 'контакты моторленд, адрес автосервиса алматы']
	];
	
	$stmt = $_DB_CONECT->prepare("INSERT INTO page_content (page_key, page_name, h1_text, content, meta_title, meta_description, meta_keywords) VALUES (?, ?, ?, ?, ?, ?, ?)");
	foreach ($default_pages as $page) {
		$stmt->bind_param("sssssss", $page[0], $page[1], $page[2], $page[3], $page[4], $page[5], $page[6]);
		$stmt->execute();
	}
	$stmt->close();
}

// Функция для получения контента страницы
function get_page_content($page_key) {
	global $_DB_CONECT;
	
	if (!isset($_DB_CONECT) || !$_DB_CONECT) {
		return false;
	}
	
	$stmt = $_DB_CONECT->prepare("SELECT * FROM page_content WHERE page_key = ? LIMIT 1");
	$stmt->bind_param("s", $page_key);
	$stmt->execute();
	$result = $stmt->get_result();
	
	if ($result->num_rows > 0) {
		$content = $result->fetch_assoc();
		$stmt->close();
		return $content;
	}
	
	$stmt->close();
	return false;
}

// Получение списка всех страниц
if (isset($_REQUEST['page_content_get_all'])) {
	$stmt = $_DB_CONECT->query("SELECT * FROM page_content ORDER BY id ASC");
	$pages = [];
	while ($row = $stmt->fetch_assoc()) {
		$pages[] = $row;
	}
	echo json_encode($pages);
	exit;
}

// Получение одной страницы
if (isset($_REQUEST['page_content_get'])) {
	$page_key = trim($_REQUEST['page_key']);
	$content = get_page_content($page_key);
	if ($content) {
		echo json_encode($content);
	} else {
		echo json_encode(['error' => 'Page not found']);
	}
	exit;
}

// Сохранение контента страницы
if (isset($_REQUEST['page_content_save']) || (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'page_content_save')) {
	$page_key = isset($_REQUEST['page_key']) ? trim($_REQUEST['page_key']) : '';
	$page_name = isset($_REQUEST['page_name']) ? trim($_REQUEST['page_name']) : '';
	$h1_text = isset($_REQUEST['h1_text']) ? trim($_REQUEST['h1_text']) : '';
	$content = isset($_REQUEST['content']) ? $_REQUEST['content'] : '';
	$meta_title = isset($_REQUEST['meta_title']) ? trim($_REQUEST['meta_title']) : '';
	$meta_description = isset($_REQUEST['meta_description']) ? trim($_REQUEST['meta_description']) : '';
	$meta_keywords = isset($_REQUEST['meta_keywords']) ? trim($_REQUEST['meta_keywords']) : '';
	
	if (empty($page_key)) {
		echo json_encode(['success' => false, 'error' => 'Page key is required']);
		exit;
	}
	
	// Проверяем, существует ли страница
	$existing = get_page_content($page_key);
	
	if ($existing) {
		// Обновляем существующую страницу
		$stmt = $_DB_CONECT->prepare("UPDATE page_content SET page_name = ?, h1_text = ?, content = ?, meta_title = ?, meta_description = ?, meta_keywords = ? WHERE page_key = ?");
		$stmt->bind_param("sssssss", $page_name, $h1_text, $content, $meta_title, $meta_description, $meta_keywords, $page_key);
		if ($stmt->execute()) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 3;
			$report['message'] = 'Контент страницы успешно сохранен';
		} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка при сохранении данных!';
		}
		$stmt->close();
	} else {
		// Создаем новую страницу
		$stmt = $_DB_CONECT->prepare("INSERT INTO page_content (page_key, page_name, h1_text, content, meta_title, meta_description, meta_keywords) VALUES (?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("sssssss", $page_key, $page_name, $h1_text, $content, $meta_title, $meta_description, $meta_keywords);
		if ($stmt->execute()) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 1;
			$report['message'] = 'Страница успешно создана';
		} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка при создании страницы!';
		}
		$stmt->close();
	}
	
	echo json_encode($report, JSON_UNESCAPED_UNICODE);
	exit;
}

// Создание таблицы simple_texts (если не существует)
if ($_HYST_ADMIN && ($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all' || array_search('page_content',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false || array_search('simple_texts',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false)) {
	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = '".DB_BASE."' AND table_name = 'simple_texts'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE simple_texts (
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(255) NOT NULL DEFAULT 'noting',
			key_id VARCHAR(255) NOT NULL DEFAULT 'noting',
			text TEXT NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
	}
	
	// Добавление простого текста
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'simple_texts_add') {
		if (!hyst_test_val($_REQUEST['simple_texts_name'],REGEXP_NAME)) {
			$report['error'] = 2;
			$report['message'] = 'Название содержит не корректные символы!';
		} else if (!hyst_test_val($_REQUEST['simple_texts_key'],REGEXP_NICKNAME)) {
			$report['error'] = 2;
			$report['message'] = 'Ключ для вывода содержит не корректные символы (только А-z0-9 и - _)!';
		} else if (empty($_REQUEST['simple_texts_text'])) { 
			$report['error'] = 2;
			$report['message'] = 'Поле текст не может быть пустым!';
		} else { 
			$stmt = $_DB_CONECT->prepare("SELECT id FROM simple_texts WHERE key_id = ?");
			$stmt->bind_param("s", $_REQUEST['simple_texts_key']);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows != 0) { 
				$report['error'] = 2;
				$report['message'] = 'Такой ключ для вывода уже занят другим текстом!';
			} else {
				$stmt = $_DB_CONECT->prepare("INSERT INTO simple_texts (name, key_id, text) VALUES (?, ?, ?)");
				$stmt->bind_param("sss", $_REQUEST['simple_texts_name'], $_REQUEST['simple_texts_key'], $_REQUEST['simple_texts_text']);
				if ($stmt->execute()) {
					$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
					$report['error'] = 1;
					$report['message'] = 'Текст добавлен';
				} else {
					$report['error'] = 2;
					$report['message'] = 'Ошибка базы данных!';
				}
				$stmt->close();
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
		exit;
	}
	
	// Редактирование простого текста
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'simple_texts_red') {
		if (!hyst_test_val($_REQUEST['simple_texts_name'],REGEXP_NAME)) {
			$report['error'] = 2;
			$report['message'] = 'Название содержит не корректные символы!';
		} else if (!hyst_test_val($_REQUEST['simple_texts_key'],REGEXP_NICKNAME)) {
			$report['error'] = 2;
			$report['message'] = 'Ключ для вывода содержит не корректные символы (только А-z0-9 и - _)!';
		} else if (empty($_REQUEST['simple_texts_text'])) { 
			$report['error'] = 2;
			$report['message'] = 'Поле текст не может быть пустым!';
		} else if (!hyst_test_id($_REQUEST['simple_texts_id'])) { 
			$report['error'] = 2;
			$report['message'] = 'Не верный идентификатор!';
		} else { 
			$stmt = $_DB_CONECT->prepare("SELECT id FROM simple_texts WHERE key_id = ? AND id != ?");
			$stmt->bind_param("si", $_REQUEST['simple_texts_key'], $_REQUEST['simple_texts_id']);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows != 0) { 
				$report['error'] = 2;
				$report['message'] = 'Такой ключ для вывода уже занят другим текстом!';
			} else {
				$stmt = $_DB_CONECT->prepare("UPDATE simple_texts SET name = ?, key_id = ?, text = ? WHERE id = ?");
				$stmt->bind_param("sssi", $_REQUEST['simple_texts_name'], $_REQUEST['simple_texts_key'], $_REQUEST['simple_texts_text'], $_REQUEST['simple_texts_id']);
				if ($stmt->execute()) {
					$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
					$report['error'] = 3;
					$report['message'] = 'Данные обновлены';
					$report['visual_changes'] = array ('#visual_ch_slideroler_'.$_REQUEST['simple_texts_id']=>$_REQUEST['simple_texts_name'].' ['.$_REQUEST['simple_texts_key'].']');
				} else {
					$report['error'] = 2;
					$report['message'] = 'Ошибка базы данных!';
				}
				$stmt->close();
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
		exit;
	}
	
	// Удаление простого текста
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'simple_texts_del') { 
		if (!hyst_test_id($_REQUEST['simple_texts_id'])) {
			$report['error'] = 2;
			$report['message'] = 'Не верный идентификатор!';
		} else { 
			$stmt = $_DB_CONECT->prepare("DELETE FROM simple_texts WHERE id = ?");
			$stmt->bind_param("i", $_REQUEST['simple_texts_id']);
			if ($stmt->execute()) {
				$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
				$report['error'] = 3;
				$report['message'] = 'Текст удален!';
				$report['delete_item'] = '.delet_slider_block'.$_REQUEST['simple_texts_id'];
			} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных!';
			}
			$stmt->close();
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
		exit;
	}
}

// Создание таблицы customtexts (если не существует)
if ($_HYST_ADMIN && ($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all' || array_search('page_content',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false || array_search('customtexts',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false)) {
	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = '".DB_BASE."' AND table_name = 'customtexts'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE customtexts (
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(255) NOT NULL DEFAULT 'noting',
			key_id VARCHAR(255) NOT NULL DEFAULT 'noting',
			text LONGTEXT NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
	}
	
	// Добавление контентного блока (customtexts)
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'customtexts_add') {
		if (!hyst_test_val($_REQUEST['customtexts_name'],REGEXP_NAME)) {
			$report['error'] = 2;
			$report['message'] = 'Название содержит не корректные символы!';
		} else if (!hyst_test_val($_REQUEST['customtexts_key'],REGEXP_NICKNAME)) {
			$report['error'] = 2;
			$report['message'] = 'Ключ для вывода содержит не корректные символы (только А-z0-9 и - _)!';
		} else if (empty($_REQUEST['customtexts_text'])) { 
			$report['error'] = 2;
			$report['message'] = 'Поле текст не может быть пустым!';
		} else { 
			$stmt = $_DB_CONECT->prepare("SELECT id FROM customtexts WHERE key_id = ?");
			$stmt->bind_param("s", $_REQUEST['customtexts_key']);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows != 0) { 
				$report['error'] = 2;
				$report['message'] = 'Такой ключ для вывода уже занят другим текстом!';
			} else {
				$stmt = $_DB_CONECT->prepare("INSERT INTO customtexts (name, key_id, text) VALUES (?, ?, ?)");
				$stmt->bind_param("sss", $_REQUEST['customtexts_name'], $_REQUEST['customtexts_key'], $_REQUEST['customtexts_text']);
				if ($stmt->execute()) {
					$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
					$report['error'] = 1;
					$report['message'] = 'Контентный блок добавлен';
				} else {
					$report['error'] = 2;
					$report['message'] = 'Ошибка базы данных!';
				}
				$stmt->close();
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
		exit;
	}
	
	// Редактирование контентного блока (customtexts)
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'customtexts_red') {
		if (!hyst_test_val($_REQUEST['customtexts_name'],REGEXP_NAME)) {
			$report['error'] = 2;
			$report['message'] = 'Название содержит не корректные символы!';
		} else if (!hyst_test_val($_REQUEST['customtexts_key'],REGEXP_NICKNAME)) {
			$report['error'] = 2;
			$report['message'] = 'Ключ для вывода содержит не корректные символы (только А-z0-9 и - _)!';
		} else if (empty($_REQUEST['customtexts_text'])) { 
			$report['error'] = 2;
			$report['message'] = 'Поле текст не может быть пустым!';
		} else if (!hyst_test_id($_REQUEST['customtexts_id'])) { 
			$report['error'] = 2;
			$report['message'] = 'Не верный идентификатор!';
		} else { 
			$stmt = $_DB_CONECT->prepare("SELECT id FROM customtexts WHERE key_id = ? AND id != ?");
			$stmt->bind_param("si", $_REQUEST['customtexts_key'], $_REQUEST['customtexts_id']);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows != 0) { 
				$report['error'] = 2;
				$report['message'] = 'Такой ключ для вывода уже занят другим текстом!';
			} else {
				$stmt = $_DB_CONECT->prepare("UPDATE customtexts SET name = ?, key_id = ?, text = ? WHERE id = ?");
				$stmt->bind_param("sssi", $_REQUEST['customtexts_name'], $_REQUEST['customtexts_key'], $_REQUEST['customtexts_text'], $_REQUEST['customtexts_id']);
				if ($stmt->execute()) {
					$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
					$report['error'] = 3;
					$report['message'] = 'Данные обновлены';
					$report['visual_changes'] = array ('#visual_ch_customtexts_'.$_REQUEST['customtexts_id']=>$_REQUEST['customtexts_name'].' ['.$_REQUEST['customtexts_key'].']');
				} else {
					$report['error'] = 2;
					$report['message'] = 'Ошибка базы данных!';
				}
				$stmt->close();
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
		exit;
	}
	
	// Удаление контентного блока (customtexts)
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'customtexts_del') { 
		if (!hyst_test_id($_REQUEST['customtexts_id'])) {
			$report['error'] = 2;
			$report['message'] = 'Не верный идентификатор!';
		} else { 
			$stmt = $_DB_CONECT->prepare("DELETE FROM customtexts WHERE id = ?");
			$stmt->bind_param("i", $_REQUEST['customtexts_id']);
			if ($stmt->execute()) {
				$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
				$report['error'] = 3;
				$report['message'] = 'Контентный блок удален!';
				$report['delete_item'] = '.delet_customtexts_block'.$_REQUEST['customtexts_id'];
			} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных!';
			}
			$stmt->close();
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
		exit;
	}
}

?>

