<?php
include('hyst/php.php');

// Установка SITE_TITLE и SITE_DESCRIPTION для админ панели ДО подключения head.php
if ($_HYST_ADMIN) {
	$page_meta = array(
		'moderators' => array(
			'title' => 'Модераторы | Админ панель',
			'description' => 'Управление пользователями и их правами доступа в административной панели'
		),
		'mediafiles' => array(
			'title' => 'Медиафайлы | Админ панель',
			'description' => 'Управление изображениями и медиа контентом в административной панели'
		),
		'index' => array(
			'title' => 'Контрольная панель | Админ панель',
			'description' => 'Главная страница административной панели'
		)
	);
	
	$current_page = '';
	
	if (isset($_GET['moderators'])) {
		$current_page = 'moderators';
	} else if (isset($_GET['mediafiles'])) {
		$current_page = 'mediafiles';
	} else if (isset($_GET['displayed'])) {
		$current_page = $_GET['displayed'];
		// Получаем название модуля из info.ini
		$module_info_file = $_SERVER['DOCUMENT_ROOT'].'/hyst/mods/'.$current_page.'/info.ini';
		if (file_exists($module_info_file)) {
			$module_info = parse_ini_file($module_info_file);
			$module_name = isset($module_info['name']) ? $module_info['name'] : $current_page;
			$page_meta[$current_page] = array(
				'title' => $module_name . ' | Админ панель',
				'description' => 'Управление модулем ' . $module_name . ' в административной панели'
			);
		} else {
			$page_meta[$current_page] = array(
				'title' => ucfirst($current_page) . ' | Админ панель',
				'description' => 'Управление модулем ' . $current_page . ' в административной панели'
			);
		}
	} else {
		$current_page = 'index';
	}
	
	// Устанавливаем SITE_TITLE и SITE_DESCRIPTION для текущей страницы
	if (isset($page_meta[$current_page])) {
		$SITE_TITLE = $page_meta[$current_page]['title'];
		$SITE_DESCRIPTION = $page_meta[$current_page]['description'];
	}
}
?>
<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" lang='ru' dir='ltr'>
<head>
<?php
include('hyst/head.php');
?>
</head>
<body class="adm_theme">
<?php
include('hyst/sbody.php');
?>
<?=hyst_show_adm(); ?>
<?php
include('hyst/fbody.php');
?>
</body>
</html>