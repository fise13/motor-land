<?php
include('hyst/php.php');

/**
 * Обработчик: Получение списка моделей или годов для фильтра
 * Описание: В зависимости от типа запроса (2 - модели, 3 - годы) возвращает список элементов
 * 			для выпадающего списка фильтров каталога. Для моделей выбирает по родительской категории (марке),
 * 			для годов - по связанным товарам через атрибуты.
 * Параметры: $_POST['tex'] - ID выбранной марки или модели, $_POST['typ'] - тип (2=модели, 3=годы)
 * Возвращает: JSON с полем 'report' содержащим HTML разметку списка элементов
 */

/*
if (!empty($_POST['tex']) && hystnempnumb ($_POST['typ'])) {
	if ($_POST['typ'] == 1) { $tbnam = 'marks'; } 
	else if ($_POST['typ'] == 2) { $tbnam = 'models'; $loc = "idm='".$_POST['tex']."'"; } 
	else if ($_POST['typ'] == 3) { $tbnam = 'years'; $loc = "LOCATE('[".$_POST['tex']."]', lower(idm))"; }
	$db = new mysqli($hystbdserver,$hystbduser,$hystbdpassword,$hystbdname);
	$db->set_charset("utf8");
	$tmp = $db->query("SELECT * FROM ".$tbnam." WHERE ".$loc." ");
	mysqli_close($db);
	if ($tmp->num_rows != 0) {
	$res['report'] = '';
	while($get=$tmp->fetch_array()):
	$res['report'] .= "<div data-id='".$get['id']."'>".$get['name']."</div>";
	endwhile;
	}
	echo json_encode($res);
}*/

if (hyst_test_id($_POST['tex']) && hyst_test_id ($_POST['typ'])) {
	$res['report'] = '';
	if ($_POST['typ'] == 1) { 
	$tbnam = 'marks'; 
	
	
	} else if ($_POST['typ'] == 2) { 
	
		$sql = $_DB_CONECT->query("SELECT * FROM internet_magazin_category WHERE idp='".$_POST['tex']."' ORDER BY name ASC");
		if ($sql->num_rows != 0) {
			while($get=$sql->fetch_array()):
			$res['report'] .= "<div data-id='".$get['id']."'>".$get['name']."</div>";
			endwhile;
		}
	} else if ($_POST['typ'] == 3) { 
		$sql = $_DB_CONECT->query("SELECT internet_magazin_atributs_options.*
		FROM internet_magazin_atributs_options 
		INNER JOIN internet_magazin_tovari ON LOCATE(CONCAT('[', internet_magazin_atributs_options.id, ']'), internet_magazin_tovari.atributs_opt) > 0 
		AND LOCATE('[".$_POST['tex']."]', internet_magazin_tovari.podegory) > 0
		WHERE internet_magazin_atributs_options.idp = 1 ORDER BY internet_magazin_atributs_options.name DESC");
		
		$exist = [];
		
		if ($sql->num_rows != 0) {
			while($get=$sql->fetch_array()):
				if (array_search($get['name'],$exist)===false) {
			$res['report'] .= "<div data-id='".$get['id']."'>".$get['name']."</div>";
				array_push($exist,$get['name']);
				}
			endwhile;
		}
	}

	
	echo json_encode($res);
}
?>