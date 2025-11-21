<?php
/**
 * Централизованная обработка ошибок и логирование
 */

// Установка обработчика ошибок
if (!defined('ERROR_LOG_PATH')) {
	define('ERROR_LOG_PATH', $_SERVER['DOCUMENT_ROOT'] . '/logs/error_log');
}

/**
 * Логирование ошибок
 * @param string $message - сообщение об ошибке
 * @param int $level - уровень ошибки (E_ERROR, E_WARNING, etc.)
 * @param string $file - файл, где произошла ошибка
 * @param int $line - строка, где произошла ошибка
 */
function hyst_log_error($message, $level = E_ERROR, $file = '', $line = 0) {
	$timestamp = date('Y-m-d H:i:s');
	$level_name = '';
	
	switch ($level) {
		case E_ERROR:
		case E_CORE_ERROR:
		case E_COMPILE_ERROR:
		case E_USER_ERROR:
			$level_name = 'ERROR';
			break;
		case E_WARNING:
		case E_CORE_WARNING:
		case E_COMPILE_WARNING:
		case E_USER_WARNING:
			$level_name = 'WARNING';
			break;
		case E_NOTICE:
		case E_USER_NOTICE:
			$level_name = 'NOTICE';
			break;
		default:
			$level_name = 'UNKNOWN';
	}
	
	$log_entry = sprintf(
		"[%s] [%s] %s (File: %s, Line: %d)\n",
		$timestamp,
		$level_name,
		$message,
		$file ?: 'unknown',
		$line ?: 0
	);
	
	// Логируем только если файл существует и доступен для записи
	if (file_exists(ERROR_LOG_PATH) && is_writable(ERROR_LOG_PATH)) {
		error_log($log_entry, 3, ERROR_LOG_PATH);
	}
}

/**
 * Обработчик исключений
 */
function hyst_exception_handler($exception) {
	hyst_log_error(
		'Uncaught Exception: ' . $exception->getMessage(),
		E_ERROR,
		$exception->getFile(),
		$exception->getLine()
	);
	
	// В production не показываем детали ошибки
	if (defined('DEBUG_MODE') && DEBUG_MODE) {
		echo '<div style="background: #f8d7da; color: #721c24; padding: 15px; margin: 10px; border: 1px solid #f5c6cb; border-radius: 4px;">';
		echo '<strong>Ошибка:</strong> ' . htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8') . '<br>';
		echo '<strong>Файл:</strong> ' . htmlspecialchars($exception->getFile(), ENT_QUOTES, 'UTF-8') . '<br>';
		echo '<strong>Строка:</strong> ' . $exception->getLine();
		echo '</div>';
	} else {
		// В production показываем общее сообщение
		header('HTTP/1.1 500 Internal Server Error');
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/error_docs/internal_server_error.html')) {
			include($_SERVER['DOCUMENT_ROOT'] . '/error_docs/internal_server_error.html');
		} else {
			echo 'Произошла ошибка. Пожалуйста, попробуйте позже.';
		}
	}
}

/**
 * Обработчик фатальных ошибок
 */
function hyst_error_handler($errno, $errstr, $errfile, $errline) {
	// Не логируем ошибки, которые подавлены оператором @
	if (!(error_reporting() & $errno)) {
		return false;
	}
	
	hyst_log_error($errstr, $errno, $errfile, $errline);
	
	// В production не показываем детали
	if (defined('DEBUG_MODE') && DEBUG_MODE) {
		return false; // Позволяем стандартному обработчику показать ошибку
	}
	
	// Для критических ошибок показываем страницу ошибки
	if ($errno === E_ERROR || $errno === E_CORE_ERROR || $errno === E_COMPILE_ERROR) {
		header('HTTP/1.1 500 Internal Server Error');
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/error_docs/internal_server_error.html')) {
			include($_SERVER['DOCUMENT_ROOT'] . '/error_docs/internal_server_error.html');
		} else {
			echo 'Произошла ошибка. Пожалуйста, попробуйте позже.';
		}
		exit;
	}
	
	return true;
}

// Устанавливаем обработчики
set_exception_handler('hyst_exception_handler');
set_error_handler('hyst_error_handler');

/**
 * Безопасное выполнение SQL запроса с обработкой ошибок
 * @param mysqli $connection - соединение с БД
 * @param string $query - SQL запрос
 * @param array $params - параметры для prepared statement
 * @param string $types - типы параметров (s, i, d, b)
 * @return mysqli_result|false
 */
function hyst_safe_query($connection, $query, $params = [], $types = '') {
	if (!isset($connection) || !$connection) {
		hyst_log_error('Database connection is not available', E_ERROR);
		return false;
	}
	
	try {
		$stmt = $connection->prepare($query);
		if (!$stmt) {
			hyst_log_error('SQL Prepare failed: ' . $connection->error . ' | Query: ' . $query, E_ERROR);
			return false;
		}
		
		if (!empty($params) && !empty($types)) {
			$stmt->bind_param($types, ...$params);
		}
		
		if (!$stmt->execute()) {
			hyst_log_error('SQL Execute failed: ' . $stmt->error . ' | Query: ' . $query, E_ERROR);
			$stmt->close();
			return false;
		}
		
		$result = $stmt->get_result();
		$stmt->close();
		
		return $result;
	} catch (Exception $e) {
		hyst_log_error('SQL Query Exception: ' . $e->getMessage() . ' | Query: ' . $query, E_ERROR);
		return false;
	}
}

