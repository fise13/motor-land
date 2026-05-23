<?php
/** Настройки почты без подключения к БД (для форм). */

if (!defined('FORM_RECIPIENT_EMAIL')) {
	define('FORM_RECIPIENT_EMAIL', 'motorlendavtorazbor@gmail.com');
}

if (!defined('SITE_MAIL')) {
	define('SITE_MAIL', 'robot@xn--d1abrdhdaqq.kz');
}

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
