<?php
include('hyst/php.php');

// Возвращает список моделей (typ=2) или годов (typ=3) для фильтра каталога

if (hyst_test_id($_POST['tex']) && hyst_test_id($_POST['typ'])) {
	$res['report'] = '';
	$tex_id = (int)$_POST['tex'];
	$typ = (int)$_POST['typ'];
	
	if ($typ == 2) { 
		$stmt = $_DB_CONECT->prepare("SELECT * FROM internet_magazin_category WHERE idp = ? ORDER BY name ASC");
		$stmt->bind_param("i", $tex_id);
		$stmt->execute();
		$sql = $stmt->get_result();
		if ($sql->num_rows != 0) {
			while($get = $sql->fetch_array()):
				$res['report'] .= "<div data-id='" . htmlspecialchars($get['id'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8') . "</div>";
			endwhile;
		}
		$stmt->close();
	} else if ($typ == 3) { 
		$mode_pattern = '[' . $tex_id . ']';
		$stmt = $_DB_CONECT->prepare("SELECT internet_magazin_atributs_options.*
		FROM internet_magazin_atributs_options 
		INNER JOIN internet_magazin_tovari ON LOCATE(CONCAT('[', internet_magazin_atributs_options.id, ']'), internet_magazin_tovari.atributs_opt) > 0 
		AND LOCATE(?, internet_magazin_tovari.podegory) > 0
		WHERE internet_magazin_atributs_options.idp = 1 ORDER BY internet_magazin_atributs_options.name DESC");
		$stmt->bind_param("s", $mode_pattern);
		$stmt->execute();
		$sql = $stmt->get_result();
		
		$exist = [];
		
		if ($sql->num_rows != 0) {
			while($get = $sql->fetch_array()):
				if (array_search($get['name'], $exist) === false) {
					$res['report'] .= "<div data-id='" . htmlspecialchars($get['id'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($get['name'], ENT_QUOTES, 'UTF-8') . "</div>";
					array_push($exist, $get['name']);
				}
			endwhile;
		}
		$stmt->close();
	}

	echo json_encode($res);
}
?>