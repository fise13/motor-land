<?php
/**
 * Простая система кеширования для улучшения производительности
 */

if (!defined('CACHE_DIR')) {
	define('CACHE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/cache');
}

// Создаем директорию кеша, если её нет
if (!file_exists(CACHE_DIR)) {
	@mkdir(CACHE_DIR, 0755, true);
}

/**
 * Получить данные из кеша
 * @param string $key - ключ кеша
 * @param int $ttl - время жизни кеша в секундах (по умолчанию 3600 = 1 час)
 * @return mixed|false - данные из кеша или false если кеш недействителен
 */
function hyst_cache_get($key, $ttl = 3600) {
	$cache_file = CACHE_DIR . '/' . md5($key) . '.cache';
	
	if (!file_exists($cache_file)) {
		return false;
	}
	
	// Проверяем время жизни кеша
	if (time() - filemtime($cache_file) > $ttl) {
		@unlink($cache_file);
		return false;
	}
	
	$data = @file_get_contents($cache_file);
	if ($data === false) {
		return false;
	}
	
	$unserialized = @unserialize($data);
	return $unserialized !== false ? $unserialized : false;
}

/**
 * Сохранить данные в кеш
 * @param string $key - ключ кеша
 * @param mixed $data - данные для кеширования
 * @return bool - успешность операции
 */
function hyst_cache_set($key, $data) {
	$cache_file = CACHE_DIR . '/' . md5($key) . '.cache';
	
	$serialized = serialize($data);
	if ($serialized === false) {
		return false;
	}
	
	return @file_put_contents($cache_file, $serialized, LOCK_EX) !== false;
}

/**
 * Удалить данные из кеша
 * @param string $key - ключ кеша
 * @return bool - успешность операции
 */
function hyst_cache_delete($key) {
	$cache_file = CACHE_DIR . '/' . md5($key) . '.cache';
	
	if (file_exists($cache_file)) {
		return @unlink($cache_file);
	}
	
	return true;
}

/**
 * Очистить весь кеш
 * @return bool - успешность операции
 */
function hyst_cache_clear() {
	if (!is_dir(CACHE_DIR)) {
		return true;
	}
	
	$files = glob(CACHE_DIR . '/*.cache');
	$success = true;
	
	foreach ($files as $file) {
		if (is_file($file)) {
			if (!@unlink($file)) {
				$success = false;
			}
		}
	}
	
	return $success;
}

/**
 * Получить данные с кешированием (если нет в кеше, выполнить callback)
 * @param string $key - ключ кеша
 * @param callable $callback - функция для получения данных
 * @param int $ttl - время жизни кеша в секундах
 * @return mixed - данные
 */
function hyst_cache_remember($key, $callback, $ttl = 3600) {
	$cached = hyst_cache_get($key, $ttl);
	
	if ($cached !== false) {
		return $cached;
	}
	
	$data = call_user_func($callback);
	
	if ($data !== false && $data !== null) {
		hyst_cache_set($key, $data);
	}
	
	return $data;
}

