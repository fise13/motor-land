<?php
ini_set('session.gc_maxlifetime', 172800);

session_start();
include($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');
include($_SERVER['DOCUMENT_ROOT'].'/hyst/core/html.php');


$_HYST_METAINCUDES = [];

$mods_folders = scandir($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/');
array_splice($mods_folders, 0, 2);
$hidden_modules = array('seo_queries', 'page_content');
for ($q = 0; $q < count($mods_folders); $q++) {
	if (!in_array($mods_folders[$q], $hidden_modules)) {
		if (file_exists($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/'.$mods_folders[$q].'/proces.php')) {
	include($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/'.$mods_folders[$q].'/proces.php');	
		}
	}
}




if (isset($_POST['send_one'])) { 
	if (!empty($_POST['name']) && !empty($_POST['phon'])) {
	$name = $_POST['name']; $phone = $_POST['phon'];
	
	$letter = new send_message(get_simple_texts ('general_post_box'), 
	'Заявка с сайта', 
	'На сайте была заполненна форма заявки \n\n 
	От: '.$name.' \n\n Телефон: '.$phone.'\n\n');
	$sending = $letter->send();
	
	
		if ($sending != FALSE) {
		?><script type="text/javascript">alert('Запрос отправлен, ждите ответа!');location.href="";gtag('event', 'conversion', {'send_to': 'AW-17661940869/u-y4CIO6zLQbEIWp7-VB', 'value': 0.4, 'currency': 'USD'});</script><?php exit;
		} else {
		?><script type="text/javascript">alert('Ошибка нет соединения!');location.href="";</script><?php exit;
		}
	} else {
	?><script type="text/javascript">alert('Поля формы пусты или заполненны не корректно!');location.href="";</script><?php exit;
	}
}

if (isset($_POST['zakazat_one'])) {
	if (!empty($_POST['name']) && !empty($_POST['phon']) && !empty($_POST['id'])) {
	$name = $_POST['name']; $phone = $_POST['phon'];
	$id = $_POST['id']; 
	
	$letter = new send_message(get_simple_texts ('general_post_box'), 
	'Заявка с сайта', 
	'На сайте была заполненна форма заявки на: '.$id.' \n\n 
	От: '.$name.' \n\n Телефон: '.$phone.'\n\n');
	$sending = $letter->send();
	

		if ($sending != FALSE) {
		?><script type="text/javascript">alert('Запрос отправлен, ждите ответа!');location.href="";</script><?php exit;
		} else {
		?><script type="text/javascript">alert('Ошибка нет соединения!');location.href="";</script><?php exit;
		}
	} else {
	?><script type="text/javascript">alert('Поля формы пусты или заполненны не корректно!');location.href="";</script><?php exit;
	}
}

?>
