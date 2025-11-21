<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');
// Подключаем кеширование если доступно
if (file_exists($_SERVER['DOCUMENT_ROOT'].'/hyst/core/cache.php')) {
	include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/cache.php');
}

/**
 * Получить простой текст по ключу с кешированием
 * @param string $i - ключ текста
 * @return string|false - текст или false если не найден
 */
function get_simple_texts ($i) {
	global $_DB_CONECT;
	if (!isset($_DB_CONECT) || !$_DB_CONECT) {
		return false;
	}
	
	// Проверяем кеш
	if (function_exists('hyst_cache_get')) {
		$cache_key = 'simple_texts_' . $i;
		$cached = hyst_cache_get($cache_key, 3600); // Кеш на 1 час
		if ($cached !== false) {
			return $cached;
		}
	}
	
	$stmt = $_DB_CONECT->prepare("SELECT * FROM simple_texts WHERE key_id = ? ORDER BY id DESC LIMIT 1");
	if ($stmt) {
		$stmt->bind_param("s", $i);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result && $result->num_rows != 0) {
			$row = $result->fetch_assoc();
			$text = $row['text'];
			$stmt->close();
			
			// Сохраняем в кеш
			if (function_exists('hyst_cache_set')) {
				hyst_cache_set($cache_key, $text);
			}
			
			return $text;
		}
		$stmt->close();
	}
	return false;
}


if ($_HYST_ADMIN && ($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all'  || array_search('simple_texts',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false)) {

	// Безопасная проверка существования таблицы
	$stmt = $_DB_CONECT->prepare("SELECT table_name FROM information_schema.tables WHERE table_schema = ? AND table_name = 'simple_texts'");
	if ($stmt) {
		$stmt->bind_param("s", DB_BASE);
		$stmt->execute();
		$check = $stmt->get_result();
		$stmt->close();
	} else {
		$check = false;
	}
	
	if (!$check || $check->num_rows == 0) {
		$create_query = "CREATE TABLE simple_texts
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(255) NOT NULL DEFAULT 'noting',
			key_id VARCHAR(255) NOT NULL DEFAULT 'noting',
			text TEXT NOT NULL,
			INDEX idx_key_id (key_id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
		$_DB_CONECT->query($create_query);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'simple_texts_add') {
		if (!hyst_test_val($_REQUEST['simple_texts_name'],REGEXP_NAME)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_val($_REQUEST['simple_texts_key'],REGEXP_NICKNAME)) {
		$report['error'] = 2;
		$report['message'] = 'Ключ для вывода содержит не корреткные символы (только А-z0-9 и - _)!';
		} else if (empty($_REQUEST['simple_texts_text'])) { 
		$report['error'] = 2;
		$report['message'] = 'Поле текст не может быть пустым!';
		} else { 
			// Безопасная проверка существования ключа
			$stmt = $_DB_CONECT->prepare("SELECT id FROM simple_texts WHERE key_id = ? LIMIT 1");
			if ($stmt) {
				$stmt->bind_param("s", $_REQUEST['simple_texts_key']);
				$stmt->execute();
				$sql = $stmt->get_result();
				$stmt->close();
				
				if ($sql && $sql->num_rows != 0) { 
					$report['error'] = 2;
					$report['message'] = 'Такой ключ для вывода уже занят другим текстом!';
				} else {
					// Безопасная вставка
					$stmt = $_DB_CONECT->prepare("INSERT INTO simple_texts (name,key_id,text) VALUES (?,?,?)");
					if ($stmt) {
						$stmt->bind_param("sss", $_REQUEST['simple_texts_name'], $_REQUEST['simple_texts_key'], $_REQUEST['simple_texts_text']);
						$result = $stmt->execute();
						$stmt->close();
						
						if ($result) {
							// Обновление времени последнего действия
							$admin_id = (int)$_HYST_ADMIN['id'];
							$last_action = time();
							$stmt = $_DB_CONECT->prepare("UPDATE `".AUT_NAME."` SET `".AUC_PREFIX."_laac` = ? WHERE id = ?");
							if ($stmt) {
								$stmt->bind_param("ii", $last_action, $admin_id);
								$stmt->execute();
								$stmt->close();
							}
							// Очищаем кеш
							if (function_exists('hyst_cache_delete')) {
								hyst_cache_delete('simple_texts_' . $_REQUEST['simple_texts_key']);
							}
							$report['error'] = 1;
							$report['message'] = 'Текст добавлен';
						} else {
							$report['error'] = 2;
							$report['message'] = 'Ошибка базы данных!';
						}
					} else {
						$report['error'] = 2;
						$report['message'] = 'Ошибка базы данных!';
					}
				}
			} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'simple_texts_red') {
		if (!hyst_test_val($_REQUEST['simple_texts_name'],REGEXP_NAME)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_val($_REQUEST['simple_texts_key'],REGEXP_NICKNAME)) {
		$report['error'] = 2;
		$report['message'] = 'Ключ для вывода содержит не корреткные символы (только А-z0-9 и - _)!';
		} else if (empty($_REQUEST['simple_texts_text'])) { 
		$report['error'] = 2;
		$report['message'] = 'Поле текст не может быть пустым!';
		} else if (!hyst_test_id($_REQUEST['simple_texts_id'])) { 
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			// Безопасная проверка существования ключа
			$text_id = (int)$_REQUEST['simple_texts_id'];
			$stmt = $_DB_CONECT->prepare("SELECT id FROM simple_texts WHERE key_id = ? AND id != ? LIMIT 1");
			if ($stmt) {
				$stmt->bind_param("si", $_REQUEST['simple_texts_key'], $text_id);
				$stmt->execute();
				$sql = $stmt->get_result();
				$stmt->close();
				
				if ($sql && $sql->num_rows != 0) { 
					$report['error'] = 2;
					$report['message'] = 'Такой ключ для вывода уже занят другим текстом!';
				} else {
					// Безопасное обновление
					$stmt = $_DB_CONECT->prepare("UPDATE simple_texts SET name = ?, key_id = ?, text = ? WHERE id = ?");
					if ($stmt) {
						$stmt->bind_param("sssi", $_REQUEST['simple_texts_name'], $_REQUEST['simple_texts_key'], $_REQUEST['simple_texts_text'], $text_id);
						$result = $stmt->execute();
						$stmt->close();
						
						if ($result) {
							// Обновление времени последнего действия
							$admin_id = (int)$_HYST_ADMIN['id'];
							$last_action = time();
							$stmt = $_DB_CONECT->prepare("UPDATE `".AUT_NAME."` SET `".AUC_PREFIX."_laac` = ? WHERE id = ?");
							if ($stmt) {
								$stmt->bind_param("ii", $last_action, $admin_id);
								$stmt->execute();
								$stmt->close();
							}
							// Очищаем кеш
							if (function_exists('hyst_cache_delete')) {
								hyst_cache_delete('simple_texts_' . $_REQUEST['simple_texts_key']);
							}
							$report['error'] = 3;
							$report['message'] = 'Данные обновлены';
							$report['visual_changes'] = array ('#visual_ch_slideroler_'.$text_id=>$_REQUEST['simple_texts_name'].' ['.$_REQUEST['simple_texts_key'].']');
						} else {
							$report['error'] = 2;
							$report['message'] = 'Ошибка базы данных!';
						}
					} else {
						$report['error'] = 2;
						$report['message'] = 'Ошибка базы данных!';
					}
				}
			} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'simple_texts_del') { 
		if (!hyst_test_id($_REQUEST['simple_texts_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			// Безопасное удаление
			$text_id = (int)$_REQUEST['simple_texts_id'];
			$stmt = $_DB_CONECT->prepare("DELETE FROM simple_texts WHERE id = ?");
			if ($stmt) {
				$stmt->bind_param("i", $text_id);
				$result = $stmt->execute();
				$stmt->close();
				
				if ($result) {
					// Обновление времени последнего действия
					$admin_id = (int)$_HYST_ADMIN['id'];
					$last_action = time();
					$stmt = $_DB_CONECT->prepare("UPDATE `".AUT_NAME."` SET `".AUC_PREFIX."_laac` = ? WHERE id = ?");
					if ($stmt) {
						$stmt->bind_param("ii", $last_action, $admin_id);
						$stmt->execute();
						$stmt->close();
					}
					// Очищаем кеш (нужно получить ключ перед удалением)
					$stmt_key = $_DB_CONECT->prepare("SELECT key_id FROM simple_texts WHERE id = ? LIMIT 1");
					if ($stmt_key) {
						$stmt_key->bind_param("i", $text_id);
						$stmt_key->execute();
						$key_result = $stmt_key->get_result();
						if ($key_result && $key_result->num_rows > 0) {
							$key_row = $key_result->fetch_assoc();
							if (function_exists('hyst_cache_delete')) {
								hyst_cache_delete('simple_texts_' . $key_row['key_id']);
							}
						}
						$stmt_key->close();
					}
					$report['error'] = 3;
					$report['message'] = 'Текст удален!';
					$report['delete_item'] = '.delet_slider_block'.$text_id;
				} else {
					$report['error'] = 2;
					$report['message'] = 'Ошибка базы данных!';
				}
			} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
}

?>