<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');


function get_simple_images ($i) {
	global $_DB_CONECT;
	$hyst_sql = mysqli_query($_DB_CONECT,"SELECT * FROM simple_images WHERE key_id='".$i."' ORDER BY id DESC");
	if (mysqli_num_rows($hyst_sql) != 0) { 
	$e = explode('][',mysqli_fetch_array($hyst_sql)['images']);
	$r = array();
	foreach ($e as $v) {
	$v = str_ireplace("]", "", $v);
	$v = str_ireplace("[", "", $v);
	array_push($r, $v);
	}
	return $r;
	} else { return '#ОБЪЕКТ НЕ НАЙДЕН#'; }
}

if ($_HYST_ADMIN && ($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all'  || array_search('simple_images',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false)) {

	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'DB_BASE' AND table_name = 'simple_images'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE simple_images
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(255) NOT NULL DEFAULT 'noting',
			key_id VARCHAR(255) NOT NULL DEFAULT 'noting',
			images TEXT NOT NULL
		)");
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
			$sql = $_DB_CONECT->query("SELECT id FROM simple_images WHERE key_id='".$_REQUEST['simple_images_key']."'");
			if (mysqli_num_rows($sql) != 0) { 
			$report['error'] = 2;
			$report['message'] = 'Такой ключ для вывода уже занят другим изображением!';
			} else {
		
				$sql = $_DB_CONECT->query("INSERT INTO simple_images (name,key_id,images) 
				VALUES ('".$_REQUEST['simple_images_name']."','".$_REQUEST['simple_images_key']."','".$_REQUEST['simple_images_image']."')");
				if ($sql != false) {
				$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
				$report['error'] = 1;
				$report['message'] = 'Сохранено!';
				} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных!';
				}
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
			$sql = $_DB_CONECT->query("SELECT id FROM simple_images WHERE key_id='".$_REQUEST['simple_images_key']."' AND id!='".$_REQUEST['simple_images_id']."'");
			if (mysqli_num_rows($sql) != 0) { 
			$report['error'] = 2;
			$report['message'] = 'Такой ключ для вывода уже занят другим изображением!';
			} else {
		
				$sql = $_DB_CONECT->query("UPDATE simple_images SET name='".$_REQUEST['simple_images_name']."',key_id='".$_REQUEST['simple_images_key']."',
				images='".$_REQUEST['simple_images_image']."' WHERE id='".$_REQUEST['simple_images_id']."'");
				if ($sql != false) {
				$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
				$report['error'] = 1;
				$report['message'] = 'Сохранено!';
				} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных!';
				}
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}

	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'simple_images_del') { 
		if (!hyst_test_id($_REQUEST['simple_images_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			$sql = $_DB_CONECT->query("DELETE FROM simple_images WHERE id='".$_REQUEST['simple_images_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 3;
			$report['message'] = 'Удалено!';
			$report['delete_item'] = '.delet_slider_block'.$_REQUEST['simple_images_id'];
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
}
?>