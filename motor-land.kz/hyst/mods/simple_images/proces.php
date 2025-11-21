<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');


function get_simple_images ($i) {
	global $_DB_CONECT;
	if (!isset($_DB_CONECT) || !$_DB_CONECT) {
		return '#ОБЪЕКТ НЕ НАЙДЕН#';
	}
	$stmt = $_DB_CONECT->prepare("SELECT * FROM simple_images WHERE key_id = ? ORDER BY id DESC LIMIT 1");
	if ($stmt) {
		$stmt->bind_param("s", $i);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result && $result->num_rows != 0) {
			$row = $result->fetch_assoc();
			$stmt->close();
			$e = explode('][', $row['images']);
			$r = array();
			foreach ($e as $v) {
				$v = str_ireplace("]", "", $v);
				$v = str_ireplace("[", "", $v);
				array_push($r, $v);
			}
			return $r;
		}
		$stmt->close();
	}
	return '#ОБЪЕКТ НЕ НАЙДЕН#';
}

if ($_HYST_ADMIN && ($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all'  || array_search('simple_images',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false)) {

	// Безопасная проверка существования таблицы
	$stmt = $_DB_CONECT->prepare("SELECT table_name FROM information_schema.tables WHERE table_schema = ? AND table_name = 'simple_images'");
	if ($stmt) {
		$stmt->bind_param("s", DB_BASE);
		$stmt->execute();
		$check = $stmt->get_result();
		$stmt->close();
	} else {
		$check = false;
	}
	
	if (!$check || $check->num_rows == 0) {
		$create_query = "CREATE TABLE simple_images
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(255) NOT NULL DEFAULT 'noting',
			key_id VARCHAR(255) NOT NULL DEFAULT 'noting',
			images TEXT NOT NULL,
			INDEX idx_key_id (key_id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
		$_DB_CONECT->query($create_query);
	}

	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'simple_images_add') { 
		if (!hyst_test_val($_REQUEST['simple_images_name'],REGEXP_NAME)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_val($_REQUEST['simple_images_key'],REGEXP_NICKNAME)) {
		$report['error'] = 2;
		$report['message'] = 'Ключ для вывода содержит не корреткные символы (только А-z0-9 и - _)!';
		} else if (empty($_REQUEST['simple_images_image'])) {
		$report['error'] = 2;
		$report['message'] = 'Изображение отсутствует!';
		} else { 
			// Безопасная проверка существования ключа
			$stmt = $_DB_CONECT->prepare("SELECT id FROM simple_images WHERE key_id = ? LIMIT 1");
			if ($stmt) {
				$stmt->bind_param("s", $_REQUEST['simple_images_key']);
				$stmt->execute();
				$sql = $stmt->get_result();
				$stmt->close();
				
				if ($sql && $sql->num_rows != 0) { 
					$report['error'] = 2;
					$report['message'] = 'Такой ключ для вывода уже занят другим изображением!';
				} else {
					// Безопасная вставка
					$stmt = $_DB_CONECT->prepare("INSERT INTO simple_images (name,key_id,images) VALUES (?,?,?)");
					if ($stmt) {
						$stmt->bind_param("sss", $_REQUEST['simple_images_name'], $_REQUEST['simple_images_key'], $_REQUEST['simple_images_image']);
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
							$report['error'] = 1;
							$report['message'] = 'Сохранено!';
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
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'simple_images_red') { 
		if (!hyst_test_val($_REQUEST['simple_images_name'],REGEXP_NAME)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_val($_REQUEST['simple_images_key'],REGEXP_NICKNAME)) {
		$report['error'] = 2;
		$report['message'] = 'Ключ для вывода содержит не корреткные символы (только А-z0-9 и - _)!';
		} else if (empty($_REQUEST['simple_images_image'])) {
		$report['error'] = 2;
		$report['message'] = 'Изображение отсутствует!';
		} else if (!hyst_test_id($_REQUEST['simple_images_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			// Безопасная проверка существования ключа
			$image_id = (int)$_REQUEST['simple_images_id'];
			$stmt = $_DB_CONECT->prepare("SELECT id FROM simple_images WHERE key_id = ? AND id != ? LIMIT 1");
			if ($stmt) {
				$stmt->bind_param("si", $_REQUEST['simple_images_key'], $image_id);
				$stmt->execute();
				$sql = $stmt->get_result();
				$stmt->close();
				
				if ($sql && $sql->num_rows != 0) { 
					$report['error'] = 2;
					$report['message'] = 'Такой ключ для вывода уже занят другим изображением!';
				} else {
					// Безопасное обновление
					$stmt = $_DB_CONECT->prepare("UPDATE simple_images SET name = ?, key_id = ?, images = ? WHERE id = ?");
					if ($stmt) {
						$stmt->bind_param("sssi", $_REQUEST['simple_images_name'], $_REQUEST['simple_images_key'], $_REQUEST['simple_images_image'], $image_id);
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
							$report['error'] = 1;
							$report['message'] = 'Сохранено!';
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

	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'simple_images_del') { 
		if (!hyst_test_id($_REQUEST['simple_images_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			// Безопасное удаление
			$image_id = (int)$_REQUEST['simple_images_id'];
			$stmt = $_DB_CONECT->prepare("DELETE FROM simple_images WHERE id = ?");
			if ($stmt) {
				$stmt->bind_param("i", $image_id);
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
					$report['error'] = 3;
					$report['message'] = 'Удалено!';
					$report['delete_item'] = '.delet_slider_block'.$image_id;
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