<?php
include('hyst/php.php');

/**
 * Обработчик: Отправка формы обратного звонка
 * Описание: Валидирует данные формы (имя и телефон), отправляет письмо на email,
 * 			возвращает JSON с результатом операции (успех или ошибка).
 * Параметры: $_POST['name'] - имя пользователя, $_POST['phon'] - телефон пользователя
 * Возвращает: JSON с полями 'error' (bool), 'message' (string), 'conversion' (bool)
 */
if (isset($_POST['send_leed'])) { 
	if (!empty($_POST['name']) && !empty($_POST['phon'])) {
	$name = $_POST['name']; $phone = $_POST['phon'];
	
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
	if (!empty($_POST['name']) && !empty($_POST['phon']) && !empty($_POST['id'])) {
	$name = $_POST['name']; $phone = $_POST['phon'];
	$id = $_POST['id']; 
	
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