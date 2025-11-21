<?php
$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'DB_BASE' AND table_name = '".AUT_NAME."'");
if ($check->num_rows == 0) {
	$check = $_DB_CONECT->query("CREATE TABLE ".AUT_NAME."
	(
		id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		".AUC_PREFIX."_tip VARCHAR(255) NOT NULL,
		".AUC_PREFIX."_name VARCHAR(255) NOT NULL,
		".AUC_PREFIX."_mail VARCHAR(255) NOT NULL,
		".AUC_PREFIX."_pass VARCHAR(255) NOT NULL,
		".AUC_PREFIX."_role VARCHAR(255) NOT NULL DEFAULT 'moderator',
		".AUC_PREFIX."_laau VARCHAR(255) NOT NULL DEFAULT 'N/A',
		".AUC_PREFIX."_laac VARCHAR(255) NOT NULL DEFAULT 'N/A'
	)");
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/cms_img')) {
	if (!mkdir($_SERVER['DOCUMENT_ROOT'].'/cms_img', 0777, true)) {
	
	} else {
	$_HYST_REPORT['message'] = $HYSTALERT['error_instal_file'];
	$_HYST_REPORT['error'] = 2;
	}
}

if (isset($_GET['exit_admin'])) { unset($_SESSION[AUSK_LOGIN]); unset($_SESSION[AUSK_PASSW]); header('Location: /adm'); exit; }


$_HYST_ADMIN = FALSE;
// Безопасный запрос с prepared statement
$stmt = $_DB_CONECT->prepare("SELECT id FROM `".AUT_NAME."` WHERE `".AUC_PREFIX."_role` = 'general' LIMIT 1");
if ($stmt) {
	$stmt->execute();
	$hyst_admin_data_sql = $stmt->get_result();
	$stmt->close();
} else {
	$hyst_admin_data_sql = false;
}

if ($hyst_admin_data_sql && $hyst_admin_data_sql->num_rows != 0) {
	$_HYST_ADMIN_SETUP = FALSE;

	if (hyst_test_val($_SESSION[AUSK_LOGIN],REGEXP_MAIL) && isset($_SESSION[AUSK_PASSW])) {
		// Безопасный запрос с prepared statement
		$stmt = $_DB_CONECT->prepare("SELECT * FROM `".AUT_NAME."` WHERE `".AUC_PREFIX."_mail` = ? LIMIT 1");
		if ($stmt) {
			$stmt->bind_param("s", $_SESSION[AUSK_LOGIN]);
			$stmt->execute();
			$hyst_sql = $stmt->get_result();
			
			if ($hyst_sql && $hyst_sql->num_rows != 0) { 
				$_HYST_ADMIN = $hyst_sql->fetch_assoc();
				// Используем новую функцию проверки пароля
				if (!function_exists('hyst_verify_admin_password')) {
					// Fallback для старого формата
					if ($_HYST_ADMIN[AUC_PREFIX."_pass"] != $_SESSION[AUSK_PASSW]) {
						unset($_SESSION[AUSK_LOGIN]);
						unset($_SESSION[AUSK_PASSW]);
						$_HYST_ADMIN = false; 
					}
				} else {
					// Проверяем пароль через новую функцию
					if (!hyst_verify_admin_password($_SESSION[AUSK_PASSW], $_HYST_ADMIN[AUC_PREFIX."_pass"])) {
						unset($_SESSION[AUSK_LOGIN]);
						unset($_SESSION[AUSK_PASSW]);
						$_HYST_ADMIN = false;
					}
				}
			} else {
				unset($_SESSION[AUSK_LOGIN]);
				unset($_SESSION[AUSK_PASSW]);
			}
			$stmt->close();
		}
	} 
} else {
	$_HYST_ADMIN_SETUP = TRUE;
}
?>