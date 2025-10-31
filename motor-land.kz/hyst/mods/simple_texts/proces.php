<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');

function get_simple_texts ($i) {
	global $_DB_CONECT;
	$hyst_sql = $_DB_CONECT->query("SELECT * FROM simple_texts WHERE key_id='".$i."' ORDER BY id DESC");
	if (mysqli_num_rows($hyst_sql) != 0) { return mysqli_fetch_array($hyst_sql)['text']; } else { return false; }
}


if ($_HYST_ADMIN && ($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all'  || array_search('simple_texts',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false)) {

	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'DB_BASE' AND table_name = 'simple_texts'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE simple_texts
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(255) NOT NULL DEFAULT 'noting',
			key_id VARCHAR(255) NOT NULL DEFAULT 'noting',
			text TEXT NOT NULL
		)");
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
			$sql = $_DB_CONECT->query("SELECT id FROM simple_texts WHERE key_id='".$_REQUEST['simple_texts_key']."'");
			if (mysqli_num_rows($sql) != 0) { 
			$report['error'] = 2;
			$report['message'] = 'Такой ключ для вывода уже занят другим текстом!';
			} else {
		
				$sql = $_DB_CONECT->query("INSERT INTO simple_texts (name,key_id,text) VALUES ('".$_REQUEST['simple_texts_name']."','".$_REQUEST['simple_texts_key']."','".$_REQUEST['simple_texts_text']."')");
				if ($sql != false) {
				$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
				$report['error'] = 1;
				$report['message'] = 'Текст добавлен';
				} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных!';
				}
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
			$sql = $_DB_CONECT->query("SELECT id FROM simple_texts WHERE key_id='".$_REQUEST['simple_texts_key']."' AND id!='".$_REQUEST['simple_texts_id']."'");
			if (mysqli_num_rows($sql) != 0) { 
			$report['error'] = 2;
			$report['message'] = 'Такой ключ для вывода уже занят другим текстом!';
			} else {
		
				$sql = $_DB_CONECT->query("UPDATE simple_texts SET name='".$_REQUEST['simple_texts_name']."',key_id='".$_REQUEST['simple_texts_key']."',
				text='".$_REQUEST['simple_texts_text']."' WHERE id='".$_REQUEST['simple_texts_id']."'");
				if ($sql != false) {
				$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
				$report['error'] = 3;
				$report['message'] = 'Данные обновлены';
				$report['visual_changes'] = array ('#visual_ch_slideroler_'.$_REQUEST['simple_texts_id']=>$_REQUEST['simple_texts_name'].' ['.$_REQUEST['simple_texts_key'].']');
				} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных!';
				}
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'simple_texts_del') { 
		if (!hyst_test_id($_REQUEST['simple_texts_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			$sql = $_DB_CONECT->query("DELETE FROM simple_texts WHERE id='".$_REQUEST['simple_texts_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 3;
			$report['message'] = 'Текст удален!';
			$report['delete_item'] = '.delet_slider_block'.$_REQUEST['simple_texts_id'];
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
}

?>