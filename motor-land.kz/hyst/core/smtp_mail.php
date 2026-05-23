<?php

/**
 * Отправка письма через SMTP (Gmail и др.).
 */
function smtp_send_mail($to, $subject, $html_body, $reply_to = null) {
	if (!defined('SMTP_HOST') || !defined('SMTP_USER') || !defined('SMTP_PASS') || SMTP_PASS === '') {
		return false;
	}

	$host = SMTP_HOST;
	$port = defined('SMTP_PORT') ? (int) SMTP_PORT : 587;
	$user = SMTP_USER;
	$pass = SMTP_PASS;
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
		return false;
	}

	stream_set_timeout($socket, 30);

	$read = function () use ($socket) {
		$response = '';
		while ($line = @fgets($socket, 515)) {
			$response .= $line;
			if (isset($line[3]) && $line[3] === ' ') {
				break;
			}
		}
		return $response;
	};

	$expect = function ($response, $codes) {
		$code = (int) substr($response, 0, 3);
		return in_array($code, $codes, true);
	};

	$write = function ($command) use ($socket, $read) {
		fwrite($socket, $command . "\r\n");
		return $read();
	};

	$banner = $read();
	if (!$expect($banner, [220])) {
		fclose($socket);
		return false;
	}

	$ehlo_host = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost';
	$resp = $write('EHLO ' . $ehlo_host);
	if (!$expect($resp, [250])) {
		fclose($socket);
		return false;
	}

	$resp = $write('STARTTLS');
	if (!$expect($resp, [220])) {
		fclose($socket);
		return false;
	}

	if (!@stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
		fclose($socket);
		return false;
	}

	$resp = $write('EHLO ' . $ehlo_host);
	if (!$expect($resp, [250])) {
		fclose($socket);
		return false;
	}

	$resp = $write('AUTH LOGIN');
	if (!$expect($resp, [334])) {
		fclose($socket);
		return false;
	}

	$resp = $write(base64_encode($user));
	if (!$expect($resp, [334])) {
		fclose($socket);
		return false;
	}

	$resp = $write(base64_encode($pass));
	if (!$expect($resp, [235])) {
		fclose($socket);
		return false;
	}

	$resp = $write('MAIL FROM:<' . $from_email . '>');
	if (!$expect($resp, [250])) {
		fclose($socket);
		return false;
	}

	$resp = $write('RCPT TO:<' . $to . '>');
	if (!$expect($resp, [250, 251])) {
		fclose($socket);
		return false;
	}

	$resp = $write('DATA');
	if (!$expect($resp, [354])) {
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

	$body = str_replace(["\r\n.", "\n."], ["\r\n..", "\n.."], $html_body);
	fwrite($socket, $headers . $body . "\r\n.\r\n");
	$resp = $read();
	if (!$expect($resp, [250])) {
		fclose($socket);
		return false;
	}

	$write('QUIT');
	fclose($socket);
	return true;
}

function encode_mail_header_name($name) {
	if (preg_match('/[^\x20-\x7E]/', $name)) {
		return '=?UTF-8?B?' . base64_encode($name) . '?=';
	}
	return $name;
}
