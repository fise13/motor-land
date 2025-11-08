<?php
include('hyst/php.php');

/**
 * Security: Защита от спама - проверка honeypot поля
 * Если поле 'website' заполнено, это бот - блокируем отправку
 */
function check_spam_protection() {
	// Honeypot защита - проверяем скрытое поле
	if (isset($_POST['website']) && !empty($_POST['website'])) {
		return false; // Это бот
	}
	
	// Проверка на слишком быстрые отправки (менее 3 секунд после загрузки страницы)
	if (isset($_POST['form_time']) && isset($_POST['form_submit_time'])) {
		$time_diff = $_POST['form_submit_time'] - $_POST['form_time'];
		if ($time_diff < 3) {
			return false; // Слишком быстро - вероятно бот
		}
	}
	
	// Проверка на подозрительные паттерны в имени и телефоне
	if (isset($_POST['name']) && isset($_POST['phon'])) {
		$name = $_POST['name'];
		$phone = $_POST['phon'];
		
		// Проверка на повторяющиеся символы (спам паттерн)
		if (preg_match('/(.)\1{4,}/', $name) || preg_match('/(.)\1{4,}/', $phone)) {
			return false;
		}
		
		// Проверка на подозрительные слова
		$spam_words = ['viagra', 'casino', 'loan', 'credit', 'buy now', 'click here'];
		$name_lower = mb_strtolower($name);
		foreach ($spam_words as $word) {
			if (strpos($name_lower, $word) !== false) {
				return false;
			}
		}
	}
	
	return true; // Проверка пройдена
}

/**
 * Обработчик: Отправка формы обратного звонка
 * Описание: Валидирует данные формы (имя и телефон), отправляет письмо на email,
 * 			возвращает JSON с результатом операции (успех или ошибка).
 * Параметры: $_POST['name'] - имя пользователя, $_POST['phon'] - телефон пользователя
 * Возвращает: JSON с полями 'error' (bool), 'message' (string), 'conversion' (bool)
 */
if (isset($_POST['send_leed'])) { 
	// Security: Проверка защиты от спама
	if (!check_spam_protection()) {
		$res['error'] = true;
		$res['message'] = 'Ошибка безопасности!';
		echo json_encode($res);
		exit;
	}
	
	if (!empty($_POST['name']) && !empty($_POST['phon'])) {
	// Security: Санитизация входных данных
	$name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
	$phone = htmlspecialchars(trim($_POST['phon']), ENT_QUOTES, 'UTF-8');
	
	$letter = new send_message(get_simple_texts ('general_post_box'), 
	'Заявка с сайта', 
	'На сайте была заполненна форма заявки \n\n 
	От: '.$name.' \n\n Телефон: '.$phone.'\n\n');
	$sending = $letter->send();
	
	
		if ($sending != FALSE) {
		$res['error'] = false;
		$res['message'] = 'Запрос отправлен, ждите ответа!';
		$res['conversion'] = true; // Флаг для конверсии
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

/**
 * Обработчик: Отправка формы заказа товара
 * Описание: Валидирует данные формы (имя, телефон, ID товара), отправляет письмо на email
 * 			с информацией о заказе, возвращает JSON с результатом операции.
 * Параметры: $_POST['name'] - имя пользователя, $_POST['phon'] - телефон, $_POST['id'] - название товара
 * Возвращает: JSON с полями 'error' (bool), 'message' (string), 'conversion' (bool)
 */
if (isset($_POST['zakaz'])) {
	// Security: Проверка защиты от спама
	if (!check_spam_protection()) {
		$res['error'] = true;
		$res['message'] = 'Ошибка безопасности!';
		echo json_encode($res);
		exit;
	}
	
	if (!empty($_POST['name']) && !empty($_POST['phon']) && !empty($_POST['id'])) {
	// Security: Санитизация входных данных
	$name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
	$phone = htmlspecialchars(trim($_POST['phon']), ENT_QUOTES, 'UTF-8');
	$id = htmlspecialchars(trim($_POST['id']), ENT_QUOTES, 'UTF-8'); 
	
	$letter = new send_message(get_simple_texts ('general_post_box'), 
	'Заявка с сайта', 
	'На сайте была заполненна форма заявки на: '.$id.' \n\n 
	От: '.$name.' \n\n Телефон: '.$phone.'\n\n');
	$sending = $letter->send();
	

		if ($sending != FALSE) {
		$res['error'] = false;
		$res['message'] = 'Запрос отправлен, ждите ответа!';
		$res['conversion'] = true; // Флаг для конверсии
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