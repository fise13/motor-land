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
$hyst_admin_data_sql = $_DB_CONECT->query("SELECT id FROM ".AUT_NAME." WHERE ".AUC_PREFIX."_role='general' LIMIT 1");

if (mysqli_num_rows ($hyst_admin_data_sql) != 0) {
$_HYST_ADMIN_SETUP = FALSE;

	if (hyst_test_val($_SESSION[AUSK_LOGIN],REGEXP_MAIL) && hyst_test_val ($_SESSION[AUSK_PASSW],REGEXP_MD5)) {
		
		$hyst_sql = $_DB_CONECT->query("SELECT * FROM ".AUT_NAME." WHERE ".AUC_PREFIX."_mail='".$_SESSION[AUSK_LOGIN]."'"); 
		if (mysqli_num_rows($hyst_sql) != 0) { 
			$_HYST_ADMIN = mysqli_fetch_array($hyst_sql);
			if ($_HYST_ADMIN[AUC_PREFIX."_pass"] != $_SESSION[AUSK_PASSW]) {
			unset($_SESSION[AUSK_LOGIN]);
			unset($_SESSION[AUSK_PASSW]);
			$_HYST_ADMIN = false; 
			}
		} else {
		unset($_SESSION[AUSK_LOGIN]);
		unset($_SESSION[AUSK_PASSW]);
		}
	} 
} else {
$_HYST_ADMIN_SETUP = TRUE;
}
?>