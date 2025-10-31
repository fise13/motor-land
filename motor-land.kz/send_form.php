<?php
include('hyst/php.php');

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