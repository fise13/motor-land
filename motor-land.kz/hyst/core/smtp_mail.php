<?php

function smtp_log_debug($message) {
	$dir = $_SERVER['DOCUMENT_ROOT'] . '/var';
	if (!is_dir($dir)) {
		@mkdir($dir, 0755, true);
	}
	$line = date('Y-m-d H:i:s') . ' ' . $message . "\n";
	@file_put_contents($dir . '/smtp_debug.log', $line, FILE_APPEND | LOCK_EX);
}

function smtp_dot_stuff($body) {
	$body = str_replace(["\r\n", "\r"], "\n", $body);
	$lines = explode("\n", $body);
	foreach ($lines as $i => $line) {
		if ($line !== '' && $line[0] === '.') {
			$lines[$i] = '.' . $line;
		}
	}
	return implode("\r\n", $lines);
}

function smtp_get_tls_method() {
	$methods = STREAM_CRYPTO_METHOD_TLS_CLIENT;
	if (defined('STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT')) {
		$methods |= STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;
	}
	return $methods;
}

/**
 * Отправка письма через SMTP (Gmail).
 */
function smtp_send_mail($to, $subject, $html_body, $reply_to = null) {
	if (!defined('SMTP_HOST') || !defined('SMTP_USER') || !defined('SMTP_PASS') || SMTP_PASS === '') {
		smtp_log_debug('SMTP not configured (empty password or constants missing)');
		return false;
	}

	$pass = preg_replace('/\s+/', '', SMTP_PASS);
	$port = defined('SMTP_PORT') ? (int) SMTP_PORT : 587;

	if ($port === 465) {
		return smtp_send_mail_ssl($to, $subject, $html_body, $reply_to, $pass);
	}

	return smtp_send_mail_starttls($to, $subject, $html_body, $reply_to, $pass);
}

function smtp_send_mail_ssl($to, $subject, $html_body, $reply_to, $pass) {
	$host = SMTP_HOST;
	$user = SMTP_USER;
	$from_email = defined('SMTP_FROM_EMAIL') ? SMTP_FROM_EMAIL : $user;
	$from_name = defined('SMTP_FROM_NAME') ? SMTP_FROM_NAME : 'Motor-Land';

	$socket = @stream_socket_client(
		"ssl://{$host}:465",
		$errno,
		$errstr,
		30,
		STREAM_CLIENT_CONNECT,
		stream_context_create([
			'ssl' => [
				'verify_peer' => true,
				'verify_peer_name' => true,
				'allow_self_signed' => false,
			],
		])
	);

	if (!$socket) {
		smtp_log_debug("SSL connect failed: {$errno} {$errstr}");
		return false;
	}

	return smtp_transact($socket, $to, $subject, $html_body, $reply_to, $user, $pass, $from_email, $from_name, false);
}

function smtp_send_mail_starttls($to, $subject, $html_body, $reply_to, $pass) {
	$host = SMTP_HOST;
	$port = defined('SMTP_PORT') ? (int) SMTP_PORT : 587;
	$user = SMTP_USER;
	$from_email = defined('SMTP_FROM_EMAIL') ? SMTP_FROM_EMAIL : $user;
	$from_name = defined('SMTP_FROM_NAME') ? SMTP_FROM_NAME : 'Motor-Land';

	$socket = @stream_socket_client(
		"tcp://{$host}:{$port}",
		$errno,
		$errstr,
		30,
		STREAM_CLIENT_CONNECT
	);

	if (!$socket) {
		smtp_log_debug("TCP connect failed {$host}:{$port} — {$errno} {$errstr}");
		return smtp_send_mail_ssl($to, $subject, $html_body, $reply_to, $pass);
	}

	stream_set_timeout($socket, 30);

	$read = smtp_make_reader($socket);
	$write = smtp_make_writer($socket, $read);

	$banner = $read();
	if (!smtp_expect($banner, [220])) {
		smtp_log_debug('Bad banner: ' . trim($banner));
		fclose($socket);
		return smtp_send_mail_ssl($to, $subject, $html_body, $reply_to, $pass);
	}

	$ehlo_host = smtp_ehlo_host();
	$resp = $write('EHLO ' . $ehlo_host);
	if (!smtp_expect($resp, [250])) {
		smtp_log_debug('EHLO failed: ' . trim($resp));
		fclose($socket);
		return false;
	}

	$resp = $write('STARTTLS');
	if (!smtp_expect($resp, [220])) {
		smtp_log_debug('STARTTLS failed: ' . trim($resp));
		fclose($socket);
		return smtp_send_mail_ssl($to, $subject, $html_body, $reply_to, $pass);
	}

	if (!@stream_socket_enable_crypto($socket, true, smtp_get_tls_method())) {
		smtp_log_debug('TLS handshake failed');
		fclose($socket);
		return smtp_send_mail_ssl($to, $subject, $html_body, $reply_to, $pass);
	}

	return smtp_transact($socket, $to, $subject, $html_body, $reply_to, $user, $pass, $from_email, $from_name, true, $read, $write);
}

function smtp_ehlo_host() {
	if (!empty($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] !== 'localhost') {
		return $_SERVER['SERVER_NAME'];
	}
	return 'motor-land.kz';
}

function smtp_make_reader($socket) {
	return function () use ($socket) {
		$response = '';
		while ($line = @fgets($socket, 515)) {
			$response .= $line;
			if (isset($line[3]) && $line[3] === ' ') {
				break;
			}
		}
		return $response;
	};
}

function smtp_make_writer($socket, $read) {
	return function ($command) use ($socket, $read) {
		fwrite($socket, $command . "\r\n");
		return $read();
	};
}

function smtp_expect($response, $codes) {
	$code = (int) substr($response, 0, 3);
	return in_array($code, $codes, true);
}

function smtp_transact($socket, $to, $subject, $html_body, $reply_to, $user, $pass, $from_email, $from_name, $needs_ehlo_after_tls, $read = null, $write = null) {
	stream_set_timeout($socket, 30);

	if ($read === null) {
		$read = smtp_make_reader($socket);
		$write = smtp_make_writer($socket, $read);

		$banner = $read();
		if (!smtp_expect($banner, [220])) {
			smtp_log_debug('SSL banner bad: ' . trim($banner));
			fclose($socket);
			return false;
		}
	}

	$ehlo_host = smtp_ehlo_host();
	if ($needs_ehlo_after_tls || $read !== null) {
		$resp = $write('EHLO ' . $ehlo_host);
		if (!smtp_expect($resp, [250])) {
			smtp_log_debug('EHLO after TLS failed: ' . trim($resp));
			fclose($socket);
			return false;
		}
	}

	$resp = $write('AUTH LOGIN');
	if (!smtp_expect($resp, [334])) {
		smtp_log_debug('AUTH LOGIN rejected: ' . trim($resp));
		fclose($socket);
		return false;
	}

	$resp = $write(base64_encode($user));
	if (!smtp_expect($resp, [334])) {
		smtp_log_debug('SMTP user rejected: ' . trim($resp));
		fclose($socket);
		return false;
	}

	$resp = $write(base64_encode($pass));
	if (!smtp_expect($resp, [235])) {
		smtp_log_debug('SMTP password rejected (проверьте пароль приложения Google): ' . trim($resp));
		fclose($socket);
		return false;
	}

	$resp = $write('MAIL FROM:<' . $from_email . '>');
	if (!smtp_expect($resp, [250])) {
		smtp_log_debug('MAIL FROM failed: ' . trim($resp));
		fclose($socket);
		return false;
	}

	$resp = $write('RCPT TO:<' . $to . '>');
	if (!smtp_expect($resp, [250, 251])) {
		smtp_log_debug('RCPT TO failed: ' . trim($resp));
		fclose($socket);
		return false;
	}

	$resp = $write('DATA');
	if (!smtp_expect($resp, [354])) {
		smtp_log_debug('DATA failed: ' . trim($resp));
		fclose($socket);
		return false;
	}

	$encoded_subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
	$headers = 'From: ' . encode_mail_header_name($from_name) . ' <' . $from_email . ">\r\n";
	$headers .= 'To: <' . $to . ">\r\n";
	if ($reply_to) {
		$headers .= 'Reply-To: <' . $reply_to . ">\r\n";
	}
	$headers .= 'Subject: ' . $encoded_subject . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	$headers .= "Content-Transfer-Encoding: 8bit\r\n";
	$headers .= "\r\n";

	$body = smtp_dot_stuff($html_body);
	fwrite($socket, $headers . $body . "\r\n.\r\n");
	$resp = $read();
	if (!smtp_expect($resp, [250])) {
		smtp_log_debug('Message not accepted: ' . trim($resp));
		fclose($socket);
		return false;
	}

	$write('QUIT');
	fclose($socket);
	smtp_log_debug('OK sent to ' . $to . ' subject: ' . $subject);
	return true;
}

function encode_mail_header_name($name) {
	if (preg_match('/[^\x20-\x7E]/', $name)) {
		return '=?UTF-8?B?' . base64_encode($name) . '?=';
	}
	return $name;
}
