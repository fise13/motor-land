<?php
/**
 * API Endpoint для обработки запросов цены
 * POST /api/request-price.php
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Разрешаем только POST запросы
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	http_response_code(405);
	echo json_encode(['success' => false, 'message' => 'Метод не разрешен']);
	exit;
}

include('../hyst/php.php');

// Получение данных из POST
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$product_name = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Валидация обязательных полей
$errors = [];

if (empty($name) || strlen($name) < 2) {
	$errors[] = 'Имя должно содержать минимум 2 символа';
}

if (empty($phone)) {
	$errors[] = 'Телефон обязателен для заполнения';
} else {
	// Очистка телефона от лишних символов
	$phone_clean = preg_replace('/[^0-9+]/', '', $phone);
	if (strlen($phone_clean) < 10) {
		$errors[] = 'Некорректный номер телефона';
	}
}

if (empty($product_id) || $product_id <= 0) {
	$errors[] = 'Не указан товар';
}

// Валидация email (если указан)
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$errors[] = 'Некорректный email адрес';
}

// Если есть ошибки, возвращаем их
if (!empty($errors)) {
	http_response_code(400);
	echo json_encode([
		'success' => false,
		'message' => implode('. ', $errors),
		'errors' => $errors
	]);
	exit;
}

// Получение телефона для отправки
$contact_phone = preg_replace('/[^\\d+]/', '', get_simple_texts('index_slider_phone'));

// Подготовка данных для сохранения/отправки
$request_data = [
	'product_id' => $product_id,
	'product_name' => htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8'),
	'name' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
	'phone' => $phone_clean,
	'email' => !empty($email) ? htmlspecialchars($email, ENT_QUOTES, 'UTF-8') : '',
	'message' => !empty($message) ? htmlspecialchars($message, ENT_QUOTES, 'UTF-8') : '',
	'date' => date('Y-m-d H:i:s'),
	'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
	'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
];

// Сохранение в базу данных (если есть таблица для заявок)
// Можно создать таблицу: CREATE TABLE product_price_requests (id INT AUTO_INCREMENT PRIMARY KEY, product_id INT, name VARCHAR(255), phone VARCHAR(50), email VARCHAR(255), message TEXT, date DATETIME, ip VARCHAR(45), user_agent TEXT, status VARCHAR(20) DEFAULT 'new')
try {
	// Проверяем существование таблицы
	$check_table = $_DB_CONECT->query("SHOW TABLES LIKE 'product_price_requests'");
	
	if ($check_table && $check_table->num_rows > 0) {
		// Таблица существует, сохраняем заявку
		$stmt = $_DB_CONECT->prepare("INSERT INTO product_price_requests (product_id, name, phone, email, message, date, ip, user_agent, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'new')");
		$stmt->bind_param("isssssss", 
			$request_data['product_id'],
			$request_data['name'],
			$request_data['phone'],
			$request_data['email'],
			$request_data['message'],
			$request_data['date'],
			$request_data['ip'],
			$request_data['user_agent']
		);
		$stmt->execute();
		$stmt->close();
	}
} catch (Exception $e) {
	// Логируем ошибку, но не прерываем выполнение
	error_log('Ошибка сохранения заявки: ' . $e->getMessage());
}

// Отправка уведомления (email, SMS, Telegram и т.д.)
// Здесь можно добавить отправку на email или в Telegram

// Формирование текста уведомления
$notification_text = "Новый запрос цены\n\n";
$notification_text .= "Товар: " . $request_data['product_name'] . " (ID: " . $request_data['product_id'] . ")\n";
$notification_text .= "Имя: " . $request_data['name'] . "\n";
$notification_text .= "Телефон: " . $request_data['phone'] . "\n";
if (!empty($request_data['email'])) {
	$notification_text .= "Email: " . $request_data['email'] . "\n";
}
if (!empty($request_data['message'])) {
	$notification_text .= "Комментарий: " . $request_data['message'] . "\n";
}
$notification_text .= "\nДата: " . $request_data['date'];

$letter = new send_message(
	FORM_RECIPIENT_EMAIL,
	'Новый запрос цены с сайта',
	nl2br(htmlspecialchars($notification_text, ENT_QUOTES, 'UTF-8'))
);
if (!$letter->send()) {
	http_response_code(500);
	echo json_encode([
		'success' => false,
		'message' => 'Не удалось отправить заявку. Попробуйте позже или позвоните нам.'
	]);
	exit;
}

// Успешный ответ
echo json_encode([
	'success' => true,
	'message' => 'Запрос успешно отправлен',
	'data' => [
		'request_id' => isset($stmt) ? $_DB_CONECT->insert_id : null
	]
]);
