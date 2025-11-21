<?php
ini_set('session.gc_maxlifetime', 172800);

session_start();
include($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');
include($_SERVER['DOCUMENT_ROOT'].'/hyst/core/html.php');

/**
 * Валидация и очистка входных данных формы
 */
function hyst_validate_form_input($data, $type = 'string') {
	if (empty($data)) {
		return false;
	}
	
	$data = trim($data);
	
	switch ($type) {
		case 'name':
			// Имя: только буквы, пробелы, дефисы, апострофы
			if (preg_match('/^[а-яА-ЯёЁa-zA-Z\s\-\']{2,100}$/u', $data)) {
				return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
			}
			return false;
			
		case 'phone':
			// Телефон: цифры, пробелы, дефисы, скобки, плюс
			$cleaned = preg_replace('/[^\d\+\-\(\)\s]/', '', $data);
			if (preg_match('/^[\d\+\-\(\)\s]{7,20}$/', $cleaned)) {
				return $cleaned;
			}
			return false;
			
		case 'email':
			// Email валидация
			if (filter_var($data, FILTER_VALIDATE_EMAIL)) {
				return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
			}
			return false;
			
		case 'id':
			// ID: только цифры
			if (preg_match('/^\d+$/', $data)) {
				return (int)$data;
			}
			return false;
			
		case 'string':
		default:
			// Обычная строка
			return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
	}
}


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
	// Проверка honeypot поля
	if (isset($_POST['website']) && !empty($_POST['website'])) {
		// Это бот, игнорируем запрос
		exit;
	}
	
	// Валидация входных данных
	$name = isset($_POST['name']) ? hyst_validate_form_input($_POST['name'], 'name') : false;
	$phone = isset($_POST['phon']) ? hyst_validate_form_input($_POST['phon'], 'phone') : false;
	
	if ($name && $phone) {
		// Проверка времени заполнения формы (защита от спама)
		if (isset($_POST['form_time']) && is_numeric($_POST['form_time'])) {
			$form_time = (int)$_POST['form_time'];
			$time_diff = time() - $form_time;
			// Форма должна быть заполнена минимум за 2 секунды
			if ($time_diff < 2) {
				?><script type="text/javascript">alert('Ошибка! Попробуйте еще раз.');location.href="";</script><?php exit;
			}
		}
		
		$letter = new send_message(
			get_simple_texts('general_post_box'), 
			'Заявка с сайта', 
			'На сайте была заполнена форма заявки \n\n От: ' . $name . ' \n\n Телефон: ' . $phone . '\n\n'
		);
		$sending = $letter->send();
		
		if ($sending != FALSE) {
			?><script type="text/javascript">alert('Запрос отправлен, ждите ответа!');location.href="";if(typeof gtag==='function'){gtag('event', 'conversion', {'send_to': 'AW-17661940869/u-y4CIO6zLQbEIWp7-VB', 'value': 0.4, 'currency': 'USD'});}</script><?php exit;
		} else {
			?><script type="text/javascript">alert('Ошибка! Нет соединения. Попробуйте позже.');location.href="";</script><?php exit;
		}
	} else {
		?><script type="text/javascript">alert('Поля формы пусты или заполнены не корректно!');location.href="";</script><?php exit;
	}
}

if (isset($_POST['zakazat_one'])) {
	// Проверка honeypot поля
	if (isset($_POST['website']) && !empty($_POST['website'])) {
		// Это бот, игнорируем запрос
		exit;
	}
	
	// Валидация входных данных
	$name = isset($_POST['name']) ? hyst_validate_form_input($_POST['name'], 'name') : false;
	$phone = isset($_POST['phon']) ? hyst_validate_form_input($_POST['phon'], 'phone') : false;
	$id = isset($_POST['id']) ? hyst_validate_form_input($_POST['id'], 'id') : false;
	
	if ($name && $phone && $id) {
		// Проверка времени заполнения формы
		if (isset($_POST['form_time']) && is_numeric($_POST['form_time'])) {
			$form_time = (int)$_POST['form_time'];
			$time_diff = time() - $form_time;
			if ($time_diff < 2) {
				?><script type="text/javascript">alert('Ошибка! Попробуйте еще раз.');location.href="";</script><?php exit;
			}
		}
		
		$letter = new send_message(
			get_simple_texts('general_post_box'), 
			'Заявка с сайта', 
			'На сайте была заполнена форма заявки на товар ID: ' . $id . ' \n\n От: ' . $name . ' \n\n Телефон: ' . $phone . '\n\n'
		);
		$sending = $letter->send();
		
		if ($sending != FALSE) {
			?><script type="text/javascript">alert('Запрос отправлен, ждите ответа!');location.href="";</script><?php exit;
		} else {
			?><script type="text/javascript">alert('Ошибка! Нет соединения. Попробуйте позже.');location.href="";</script><?php exit;
		}
	} else {
		?><script type="text/javascript">alert('Поля формы пусты или заполнены не корректно!');location.href="";</script><?php exit;
	}
}

?>
