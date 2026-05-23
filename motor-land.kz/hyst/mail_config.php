<?php
/**
 * Настройки почты — подключается ТОЛЬКО при отправке форм, не на каждой странице.
 */

if (!defined('FORM_RECIPIENT_EMAIL')) {
	define('FORM_RECIPIENT_EMAIL', 'motorlendavtorazbor@gmail.com');
}

if (!defined('SITE_MAIL')) {
	define('SITE_MAIL', 'robot@xn--d1abrdhdaqq.kz');
}

$mail_local_file = __DIR__ . '/mail.local.php';
if (is_readable($mail_local_file)) {
	$mail_local_head = (string) file_get_contents($mail_local_file, false, null, 0, 10);
	if (strpos(ltrim($mail_local_head), '<?php') === 0) {
		require_once $mail_local_file;
	} else {
		error_log('mail.local.php: файл должен начинаться с <?php — иначе текст попадает на сайт');
	}
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
