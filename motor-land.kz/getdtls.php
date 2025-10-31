<?php
session_start();
include("./hyst/hyst.php");
include("./hyst/functions.php");

/**
 * Обработчик: Автоподбор марок/моделей/годов по вводу текста
 * Описание: При вводе текста в поле поиска отправляет запрос в базу данных для поиска
 * 			подходящих вариантов (марок, моделей или годов) по частичному совпадению названия.
 * 			Используется для автозаполнения в старых версиях форм.
 * Параметры: $_POST['tex'] - текст для поиска, $_POST['typ'] - тип (1=марки, 2=модели, 3=годы)
 * Возвращает: JSON с полем 'report' содержащим HTML разметку option элементов
 */
if (!empty($_POST['tex']) && hystnempnumb ($_POST['typ'])) {
	if ($_POST['typ'] == 1) { $tbnam = 'marks'; } 
	else if ($_POST['typ'] == 2) { $tbnam = 'models'; } 
	else if ($_POST['typ'] == 3) { $tbnam = 'years'; } 
	$db = new mysqli($hystbdserver,$hystbduser,$hystbdpassword,$hystbdname);
	$db->set_charset("utf8");
	$tmp = $db->query("SELECT * FROM ".$tbnam." WHERE LOCATE(lower('".$_POST['tex']."'), lower(name)) ");
	mysqli_close($db);
	if ($tmp->num_rows != 0) {
	$res['report'] = '';
	while($get=$tmp->fetch_array()):
	$res['report'] .= "<option value='".$get['name']."'>".$get['name']."</option>";
	endwhile;
	}
	echo json_encode($res);
}
?>