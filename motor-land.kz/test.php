<?php
// Тестовый файл для проверки работы PHP
echo "PHP работает!<br>";
echo "Текущий файл: " . __FILE__ . "<br>";
echo "DOCUMENT_ROOT: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "<br>";

// Проверка включения файлов
if (file_exists('hyst/php.php')) {
    echo "Файл hyst/php.php найден<br>";
    include('hyst/php.php');
    echo "Файл hyst/php.php успешно включен<br>";
} else {
    echo "ОШИБКА: Файл hyst/php.php НЕ найден!<br>";
    echo "Текущая директория: " . getcwd() . "<br>";
}
?>

