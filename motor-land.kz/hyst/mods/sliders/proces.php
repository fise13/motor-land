<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');

function get_slider ($i) {
	global $_DB_CONECT;
	$hyst_sql = $_DB_CONECT->query("SELECT * FROM sliders_slider WHERE key_id='".$i."' ORDER BY id DESC");
	if (mysqli_num_rows($hyst_sql) != 0) {
		$hyst_get = mysqli_fetch_array($hyst_sql);
		$hyst_sql = $_DB_CONECT->query("SELECT * FROM sliders_slide WHERE ids='".$hyst_get['id']."' ORDER BY id ASC");
		if (mysqli_num_rows($hyst_sql) != 0) { return $hyst_sql; } else { return FALSE; }
	} else { 
	return FALSE; 
	}
}



if ($_HYST_ADMIN && ($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all'  || array_search('sliders',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false)) {
	
	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'DB_BASE' AND table_name = 'sliders_slider'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE sliders_slider
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			key_id VARCHAR(255) NOT NULL DEFAULT 'noting',
			name VARCHAR(255) NOT NULL DEFAULT 'noting'
		)");
	}
	
	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'DB_BASE' AND table_name = 'sliders_slide'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE sliders_slide
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			ids INT(9) NOT NULL,
			image VARCHAR(255) NOT NULL DEFAULT 'noting',
			typ INT(9) NOT NULL DEFAULT '1',
			buton VARCHAR(255) NOT NULL DEFAULT 'noting',
			href VARCHAR(255) NOT NULL DEFAULT 'noting',
			text LONGTEXT NOT NULL
		)");
	}
	/*
	if (!is_null($_HYST_METAINCUDES)) {
		if (array_search('/hyst/visual/metaicludes/ckeditor/ckeditor.js',$_HYST_METAINCUDES)===false) {
		array_push($_HYST_METAINCUDES,'/hyst/visual/metaicludes/ckeditor/ckeditor.js');
		}
	}*/
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'sliders_add') { 
		if (!hyst_test_val($_REQUEST['sliders_name'],REGEXP_NAME)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_val($_REQUEST['sliders_key'],REGEXP_NICKNAME)) {
		$report['error'] = 2;
		$report['message'] = 'Ключ для вывода содержит не корреткные символы (только А-z0-9 и - _)!';
		} else { 
			$sql = $_DB_CONECT->query("SELECT id FROM sliders_slider WHERE key_id='".$_REQUEST['sliders_key']."'");
			if (mysqli_num_rows($sql) != 0) { 
			$report['error'] = 2;
			$report['message'] = 'Такой ключ для вывода уже занят другим слайдером!';
			} else {
		
				$sql = $_DB_CONECT->query("INSERT INTO sliders_slider (name,key_id) VALUES ('".$_REQUEST['sliders_name']."','".$_REQUEST['sliders_key']."')");
				if ($sql != false) {
				$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
				$report['error'] = 1;
				$report['message'] = 'Слайдер добавлен, можете приступить к его настройке!';
				} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных!';
				}
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'sliders_red') { 
		if (!hyst_test_id($_REQUEST['sliders_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else if (!hyst_test_val($_REQUEST['sliders_name'],REGEXP_NAME)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_val($_REQUEST['sliders_key'],REGEXP_NICKNAME)) {
		$report['error'] = 2;
		$report['message'] = 'Ключ для вывода содержит не корреткные символы (только А-z0-9 и - _)!';
		} else { 
			$sql = $_DB_CONECT->query("SELECT id FROM sliders_slider WHERE key_id='".$_REQUEST['sliders_key']."' AND id!='".$_REQUEST['sliders_id']."'");
			if (mysqli_num_rows($sql) != 0) { 
			$report['error'] = 2;
			$report['message'] = 'Такой ключ для вывода уже занят другим слайдером!';
			} else {
		
				$sql = $_DB_CONECT->query("UPDATE sliders_slider SET name='".$_REQUEST['sliders_name']."',key_id='".$_REQUEST['sliders_key']."' WHERE id='".$_REQUEST['sliders_id']."'");
				if ($sql != false) {
				$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
				$report['error'] = 3;
				$report['message'] = 'Изменения сохранены!';
				$report['visual_changes'] = array ('#visual_ch_slideroler_'.$_REQUEST['sliders_id']=>$_REQUEST['sliders_name'].' ['.$_REQUEST['sliders_key'].']',
					'#visual_ch_slidenamei_'.$_REQUEST['sliders_id']=>$_REQUEST['sliders_name']);
				} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных!';
				}
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'sliders_del') { 
		if (!hyst_test_id($_REQUEST['sliders_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			$sql = $_DB_CONECT->query("DELETE FROM sliders_slider WHERE id='".$_REQUEST['sliders_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("DELETE FROM sliders_slide WHERE ids='".$_REQUEST['sliders_id']."'");
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 3;
			$report['message'] = 'Слайдер удален!';
			$report['delete_item'] = '.delet_slider_block'.$_REQUEST['sliders_id'];
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'sliders_slide_add') { 
		if (!hyst_test_id($_REQUEST['sliders_ids'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else if (empty($_REQUEST['sliders_image'])) {
		$report['error'] = 2;
		$report['message'] = 'Нужно указать изображение!';
		} else {
			if (!empty($_REQUEST['sliders_href'])) { $href = $_REQUEST['sliders_href']; } else { $href = 'N/A'; }
			if (!empty($_REQUEST['sliders_name'])) { $buto = $_REQUEST['sliders_name']; } else { $buto = 'N/A'; }
			if (!empty($_REQUEST['sliders_text'])) { $text = $_REQUEST['sliders_text']; } else { $text = 'N/A'; }
			$sql = $_DB_CONECT->query("INSERT INTO sliders_slide (ids,image,buton,href,text) VALUES ('".$_REQUEST['sliders_ids']."','".$_REQUEST['sliders_image']."','".$buto."','".$href."','".$text."')");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			
				$id = $_DB_CONECT->query("SELECT id FROM sliders_slide WHERE image='".$_REQUEST['sliders_image']."' ORDER BY id DESC LIMIT 1");
				$id = mysqli_fetch_array($id)['id'];
			$report['error'] = 3;
			$report['message'] = 'Изменения сохранены!';
			$report['inserted_html'] = array('.slider_sliders_container1'=>'
			<div class="sliders_mod_slide_prev slider_sliders_delet9" onclick="slider_slide_redact('.$id.','.$_REQUEST['sliders_ids'].');" style="background-image: url('.$_REQUEST['sliders_image'].');"></div>');
			$report['clear'] = "";
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!'; $report['clear'] = "INSERT INTO sliders_slide (ids,image,buton,href,text) VALUES ('".$_REQUEST['sliders_ids']."','".$_REQUEST['sliders_image']."','".$buto."','".$href."','".$text."')";
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'get_slide_data') { 
		if (!hyst_test_id($_REQUEST['id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else {
			$sql = $_DB_CONECT->query("SELECT * FROM sliders_slide WHERE id='".$_REQUEST['id']."'");
			if ($sql->num_rows != 0) {
				$get = $sql->fetch_array();
				$report['error'] = 3;
				$report['data']['image'] = $get['image'];
				$report['data']['buton'] = ($get['buton']!='N/A'?$get['buton']:'');
				$report['data']['href'] = ($get['href']!='N/A'?$get['href']:'');
				$report['data']['text'] = ($get['text']!='N/A'?$get['text']:'');
			} else {
			$report['error'] = 2;
			$report['message'] = 'Слайд не найден!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'sliders_slide_red') { 
		if (!hyst_test_id($_REQUEST['id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else if (empty($_REQUEST['sliders_image'])) {
		$report['error'] = 2;
		$report['message'] = 'Нужно указать изображение!';
		} else {
			if (!empty($_REQUEST['sliders_href'])) { $href = $_REQUEST['sliders_href']; } else { $href = 'N/A'; }
			if (!empty($_REQUEST['sliders_name'])) { $buto = $_REQUEST['sliders_name']; } else { $buto = 'N/A'; }
			if (!empty($_REQUEST['sliders_text'])) { $text = $_REQUEST['sliders_text']; } else { $text = 'N/A'; }
			$sql = $_DB_CONECT->query("UPDATE sliders_slide SET image='".$_REQUEST['sliders_image']."',buton='".$buto."',href='".$href."',text='".$text."' WHERE id='".$_REQUEST['id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 3;
			$report['message'] = 'Изменения сохранены!';
			$report['css_changes'] = array('.slider_slide_redact_con'.$_REQUEST['ids']=>['display','none']);
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!'; $report['clear'] = "INSERT INTO sliders_slide (ids,image,buton,href,text) VALUES ('".$_REQUEST['sliders_ids']."','".$_REQUEST['sliders_image']."','".$buto."','".$href."','".$text."')";
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}

	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'slide_del') { 
		if (!hyst_test_id($_REQUEST['id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			$sql = $_DB_CONECT->query("DELETE FROM sliders_slide WHERE id='".$_REQUEST['id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 3;
			$report['message'] = 'Слайд удален!';
			$report['delete_item'] = '.slider_sliders_delet'.$_REQUEST['id'];
			$report['css_changes'] = array('.slider_slide_redact_con'.$_REQUEST['ids']=>['display','none']);
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
}

?>