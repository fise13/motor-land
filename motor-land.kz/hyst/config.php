<?php
define("DB_HOST", "localhost");
define("DB_USER", "un446428_bd");
define("DB_PASSWORD", "H5#29wkg7");
define("DB_BASE", "un446428_motor");
$_DB_CONECT = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_BASE);


define("AUT_NAME", "hyst_escalibe");
define("AUC_PREFIX", "aucd");
define("AUSK_LOGIN", "aucd_login");
define("AUSK_PASSW", "aucd_passw");

//define("SITE_MAIL", "robot@моторленд.kz");
define("SITE_MAIL", "robot@xn--d1abrdhdaqq.kz");

/** Email для всех заявок с форм сайта */
define("FORM_RECIPIENT_EMAIL", "motorlendavtorazbor@gmail.com");

/** SMTP: настройки в mail.local.php (см. mail.local.php.example) */
if (file_exists(__DIR__ . '/mail.local.php')) {
	require_once __DIR__ . '/mail.local.php';
}
if (!defined('MAIL_USE_SMTP')) {
	define('MAIL_USE_SMTP', false);
}
if (!defined('SMTP_HOST')) {
	define('SMTP_HOST', 'smtp.gmail.com');
}
if (!defined('SMTP_PORT')) {
	define('SMTP_PORT', 587);
}
if (!defined('SMTP_USER')) {
	define('SMTP_USER', FORM_RECIPIENT_EMAIL);
}
if (!defined('SMTP_PASS')) {
	define('SMTP_PASS', '');
}
if (!defined('SMTP_FROM_EMAIL')) {
	define('SMTP_FROM_EMAIL', FORM_RECIPIENT_EMAIL);
}
if (!defined('SMTP_FROM_NAME')) {
	define('SMTP_FROM_NAME', 'Motor-Land');
}

require_once __DIR__ . '/core/smtp_mail.php';

define("SITE_URL", "http://motor-land.kz");
