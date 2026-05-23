<?php
/**
 * API Endpoint для обработки вопросов
 * POST /api/request-question.php
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

require_once dirname(__DIR__) . '/hyst/form_bootstrap.php';

if (file_exists(dirname(__DIR__) . '/hyst/config.php')) {
	require_once dirname(__DIR__) . '/hyst/config.php';
}

// Получение данных из POST
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$product_name = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$question = isset($_POST['question']) ? trim($_POST['question']) : '';

// Валидация обязательных полей
$errors = [];

if (empty($name) || strlen($name) < 2) {
	$errors[] = 'Имя должно содержать минимум 2 символа';
}

if (empty($phone)) {
	$errors[] = 'Телефон обязателен для заполнения';
} else {
	$phone_clean = preg_replace('/[^0-9+]/', '', $phone);
	if (strlen($phone_clean) < 10) {
		$errors[] = 'Некорректный номер телефона';
	}
}

if (empty($question) || strlen($question) < 10) {
	$errors[] = 'Вопрос должен содержать минимум 10 символов';
}

if (empty($product_id) || $product_id <= 0) {
	$errors[] = 'Не указан товар';
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

// Подготовка данных
$request_data = [
	'product_id' => $product_id,
	'product_name' => htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8'),
	'name' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
	'phone' => $phone_clean,
	'question' => htmlspecialchars($question, ENT_QUOTES, 'UTF-8'),
	'date' => date('Y-m-d H:i:s'),
	'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
	'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
];

// Сохранение в базу данных
try {
	if (!isset($_DB_CONECT) || !($_DB_CONECT instanceof mysqli)) {
		throw new Exception('DB not available');
	}
	$check_table = $_DB_CONECT->query("SHOW TABLES LIKE 'product_questions'");
	
	if ($check_table && $check_table->num_rows > 0) {
		$stmt = $_DB_CONECT->prepare("INSERT INTO product_questions (product_id, name, phone, question, date, ip, user_agent, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'new')");
		$stmt->bind_param("issssss", 
			$request_data['product_id'],
			$request_data['name'],
			$request_data['phone'],
			$request_data['question'],
			$request_data['date'],
			$request_data['ip'],
			$request_data['user_agent']
		);
		$stmt->execute();
		$stmt->close();
	}
} catch (Exception $e) {
	error_log('Ошибка сохранения вопроса: ' . $e->getMessage());
}

// Формирование уведомления
$notification_text = "Новый вопрос о товаре\n\n";
$notification_text .= "Товар: " . $request_data['product_name'] . " (ID: " . $request_data['product_id'] . ")\n";
$notification_text .= "Имя: " . $request_data['name'] . "\n";
$notification_text .= "Телефон: " . $request_data['phone'] . "\n";
$notification_text .= "Вопрос: " . $request_data['question'] . "\n";
$notification_text .= "\nДата: " . $request_data['date'];

if (!send_form_lead('Новый вопрос о товаре с сайта', $notification_text)) {
	http_response_code(500);
	echo json_encode([
		'success' => false,
		'message' => 'Не удалось отправить вопрос. Попробуйте позже или позвоните нам.'
	]);
	exit;
}

// Успешный ответ
echo json_encode([
	'success' => true,
	'message' => 'Вопрос успешно отправлен',
	'data' => [
		'request_id' => isset($stmt) ? $_DB_CONECT->insert_id : null
	]
]);
