<?php
include('hyst/php.php');

// Защита от спама: honeypot, проверка времени отправки, паттерны спама
function check_spam_protection() {
	if (isset($_POST['website']) && !empty($_POST['website'])) {
		return false;
	}
	
	if (isset($_POST['form_time']) && isset($_POST['form_submit_time'])) {
		$time_diff = $_POST['form_submit_time'] - $_POST['form_time'];
		if ($time_diff < 3) {
			return false;
		}
	}
	
	if (isset($_POST['name']) && isset($_POST['phon'])) {
		$name = $_POST['name'];
		$phone = $_POST['phon'];
		
		if (preg_match('/(.)\1{4,}/', $name) || preg_match('/(.)\1{4,}/', $phone)) {
			return false;
		}
		
		$spam_words = ['viagra', 'casino', 'loan', 'credit', 'buy now', 'click here'];
		$name_lower = mb_strtolower($name);
		foreach ($spam_words as $word) {
			if (strpos($name_lower, $word) !== false) {
				return false;
			}
		}
	}
	
	return true;
}

if (isset($_POST['send_leed'])) { 
	if (!check_spam_protection()) {
		$res['error'] = true;
		$res['message'] = 'Ошибка безопасности!';
		echo json_encode($res);
		exit;
	}
	
	if (!empty($_POST['name']) && !empty($_POST['phon'])) {
	// Security: Валидация и очистка входных данных
	$name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
	$phone = htmlspecialchars(trim($_POST['phon']), ENT_QUOTES, 'UTF-8');
	
	// Дополнительная валидация длины
	if (mb_strlen($name) > 100) {
		$res['error'] = true;
		$res['message'] = 'Ошибка! Имя слишком длинное!';
		echo json_encode($res);
		exit;
	}
	
	if (mb_strlen($phone) > 20) {
		$res['error'] = true;
		$res['message'] = 'Ошибка! Номер телефона слишком длинный!';
		echo json_encode($res);
		exit;
	}
	
	// Performance: Форматирование сообщения с использованием более читаемого формата
	$message_text = "На сайте была заполнена форма заявки\n\n" .
					"От: {$name}\n" .
					"Телефон: {$phone}\n\n" .
					"Время отправки: " . date('Y-m-d H:i:s') . "\n";
	
	$letter = new send_message(get_simple_texts ('general_post_box'), 
	'Заявка с сайта', 
	$message_text);
	$sending = $letter->send();
	
		if ($sending != FALSE) {
		$res['error'] = false;
		$res['message'] = 'Запрос отправлен, ждите ответа!';
		$res['conversion'] = true;
		} else {
		$res['error'] = true;
		$res['message'] = 'Ошибка! Нет соединения!';
		}
	} else {
	$res['error'] = true;
	$res['message'] = 'Ошибка! Не заполнены обязательные поля Имя и Телефон!';
	}
	
	echo json_encode($res);
}

if (isset($_POST['zakaz'])) {
	if (!check_spam_protection()) {
		$res['error'] = true;
		$res['message'] = 'Ошибка безопасности!';
		echo json_encode($res);
		exit;
	}
	
	if (!empty($_POST['name']) && !empty($_POST['phon']) && !empty($_POST['id'])) {
	// Security: Валидация и очистка входных данных
	$name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
	$phone = htmlspecialchars(trim($_POST['phon']), ENT_QUOTES, 'UTF-8');
	$id = htmlspecialchars(trim($_POST['id']), ENT_QUOTES, 'UTF-8');
	
	// Валидация ID товара
	if (!preg_match('/^\d+$/', $id)) {
		$res['error'] = true;
		$res['message'] = 'Ошибка! Неверный идентификатор товара!';
		echo json_encode($res);
		exit;
	}
	
	// Дополнительная валидация длины
	if (mb_strlen($name) > 100) {
		$res['error'] = true;
		$res['message'] = 'Ошибка! Имя слишком длинное!';
		echo json_encode($res);
		exit;
	}
	
	if (mb_strlen($phone) > 20) {
		$res['error'] = true;
		$res['message'] = 'Ошибка! Номер телефона слишком длинный!';
		echo json_encode($res);
		exit;
	}
	
	// Performance: Форматирование сообщения с использованием более читаемого формата
	$message_text = "На сайте была заполнена форма заявки на товар\n\n" .
					"ID товара: {$id}\n" .
					"От: {$name}\n" .
					"Телефон: {$phone}\n\n" .
					"Время отправки: " . date('Y-m-d H:i:s') . "\n";
	
	$letter = new send_message(get_simple_texts ('general_post_box'), 
	'Заявка с сайта', 
	$message_text);
	$sending = $letter->send();

		if ($sending != FALSE) {
		$res['error'] = false;
		$res['message'] = 'Запрос отправлен, ждите ответа!';
		$res['conversion'] = true;
		} else {
		$res['error'] = true;
		$res['message'] = 'Ошибка! Нет соединения!';
		}
	} else {
	$res['error'] = true;
	$res['message'] = 'Поля формы пусты или заполненны не корректно!';
	}
	echo json_encode($res);
}