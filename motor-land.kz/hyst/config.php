<?php
/**
 * Конфигурация системы
 * ВАЖНО: Для production рекомендуется вынести credentials в отдельный файл вне web root
 */

// Режим отладки (false для production)
define("DEBUG_MODE", false);

// Настройки базы данных
// ВАЖНО: В production вынесите эти данные в отдельный файл config.local.php вне web root
if (file_exists(__DIR__ . '/config.local.php')) {
	include(__DIR__ . '/config.local.php');
} else {
	// Значения по умолчанию (для обратной совместимости)
	define("DB_HOST", "localhost");
	define("DB_USER", "un446428_bd");
	define("DB_PASSWORD", "H5#29wkg7");
	define("DB_BASE", "un446428_motor");
}

// Подключение к базе данных с обработкой ошибок
try {
	$_DB_CONECT = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_BASE);
	
	if ($_DB_CONECT->connect_error) {
		error_log('Database connection failed: ' . $_DB_CONECT->connect_error);
		if (defined('DEBUG_MODE') && DEBUG_MODE) {
			die('Database connection failed: ' . $_DB_CONECT->connect_error);
		} else {
			die('Database connection failed. Please try again later.');
		}
	}
	
	// Устанавливаем кодировку UTF-8
	$_DB_CONECT->set_charset("utf8mb4");
	
	// Устанавливаем режим SQL для безопасности
	$_DB_CONECT->query("SET sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");
} catch (Exception $e) {
	error_log('Database initialization error: ' . $e->getMessage());
	if (defined('DEBUG_MODE') && DEBUG_MODE) {
		die('Database initialization error: ' . $e->getMessage());
	} else {
		die('Database initialization error. Please try again later.');
	}
}

// Настройки системы
define("AUT_NAME", "hyst_escalibe");
define("AUC_PREFIX", "aucd");
define("AUSK_LOGIN", "aucd_login");
define("AUSK_PASSW", "aucd_passw");

// Email для отправки писем
//define("SITE_MAIL", "robot@моторленд.kz");
define("SITE_MAIL", "robot@xn--d1abrdhdaqq.kz");

// URL сайта
define("SITE_URL", "http://motor-land.kz");

// Подключаем обработчик ошибок
if (file_exists(__DIR__ . '/core/error_handler.php')) {
	include_once(__DIR__ . '/core/error_handler.php');
}

// Подключаем систему кеширования
if (file_exists(__DIR__ . '/core/cache.php')) {
	include_once(__DIR__ . '/core/cache.php');
}

// Настройки безопасности
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Установите в 1 если используете HTTPS

// Настройки отображения ошибок
if (defined('DEBUG_MODE') && DEBUG_MODE) {
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
} else {
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
	ini_set('display_errors', 0);
	ini_set('log_errors', 1);
}
