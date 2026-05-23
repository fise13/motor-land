<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/hyst/form_bootstrap.php';

if (isset($_POST['send_leed'])) {
	if (!check_form_spam_protection()) {
		echo json_encode(['error' => true, 'message' => 'Ошибка безопасности!']);
		exit;
	}

	if (!empty($_POST['name']) && !empty($_POST['phon'])) {
		$name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
		$phone = htmlspecialchars(trim($_POST['phon']), ENT_QUOTES, 'UTF-8');

		if (mb_strlen($name) > 100) {
			echo json_encode(['error' => true, 'message' => 'Ошибка! Имя слишком длинное!']);
			exit;
		}
		if (mb_strlen($phone) > 20) {
			echo json_encode(['error' => true, 'message' => 'Ошибка! Номер телефона слишком длинный!']);
			exit;
		}

		$message_text = "На сайте была заполнена форма заявки\n\n"
			. "От: {$name}\n"
			. "Телефон: {$phone}\n\n"
			. "Время отправки: " . date('Y-m-d H:i:s') . "\n";

		if (send_form_lead('Заявка с сайта', $message_text)) {
			echo json_encode([
				'error' => false,
				'message' => 'Запрос отправлен, ждите ответа!',
				'conversion' => true,
			]);
		} else {
			echo json_encode(['error' => true, 'message' => 'Ошибка! Не удалось сохранить заявку.']);
		}
	} else {
		echo json_encode(['error' => true, 'message' => 'Ошибка! Не заполнены обязательные поля Имя и Телефон!']);
	}
	exit;
}

if (isset($_POST['zakaz'])) {
	if (!check_form_spam_protection()) {
		echo json_encode(['error' => true, 'message' => 'Ошибка безопасности!']);
		exit;
	}

	if (!empty($_POST['name']) && !empty($_POST['phon']) && !empty($_POST['id'])) {
		$name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
		$phone = htmlspecialchars(trim($_POST['phon']), ENT_QUOTES, 'UTF-8');
		$product = htmlspecialchars(trim($_POST['id']), ENT_QUOTES, 'UTF-8');

		if (mb_strlen($name) > 100 || mb_strlen($phone) > 20 || mb_strlen($product) > 255) {
			echo json_encode(['error' => true, 'message' => 'Ошибка! Слишком длинные данные в форме.']);
			exit;
		}

		$message_text = "На сайте была заполнена форма заявки на товар\n\n"
			. "Товар: {$product}\n"
			. "От: {$name}\n"
			. "Телефон: {$phone}\n\n"
			. "Время отправки: " . date('Y-m-d H:i:s') . "\n";

		if (send_form_lead('Заявка на товар с сайта', $message_text)) {
			echo json_encode([
				'error' => false,
				'message' => 'Запрос отправлен, ждите ответа!',
				'conversion' => true,
			]);
		} else {
			echo json_encode(['error' => true, 'message' => 'Ошибка! Не удалось сохранить заявку.']);
		}
	} else {
		echo json_encode(['error' => true, 'message' => 'Поля формы пусты или заполненны не корректно!']);
	}
	exit;
}

http_response_code(400);
echo json_encode(['error' => true, 'message' => 'Неверный запрос']);
