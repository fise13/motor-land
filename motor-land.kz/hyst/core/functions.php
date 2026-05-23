<?php
function hyst_translit_url($v)
{
	$converter = array(
		'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
		'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
		'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
		'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
		'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
		'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
		'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
 
		'А' => 'a',    'Б' => 'b',    'В' => 'v',    'Г' => 'g',    'Д' => 'd',
		'Е' => 'e',    'Ё' => 'e',    'Ж' => 'zh',   'З' => 'z',    'И' => 'i',
		'Й' => 'y',    'К' => 'k',    'Л' => 'l',    'М' => 'm',    'Н' => 'n',
		'О' => 'o',    'П' => 'p',    'Р' => 'r',    'С' => 's',    'Т' => 't',
		'У' => 'u',    'Ф' => 'f',    'Х' => 'h',    'Ц' => 'c',    'Ч' => 'ch',
		'Ш' => 'sh',   'Щ' => 'sch',  'Ь' => '',     'Ы' => 'y',    'Ъ' => '',
		'Э' => 'e',    'Ю' => 'yu',   'Я' => 'ya',	 ' ' => '-', 'ә' => 'a',    
		'ғ' => 'g',    'қ' => 'k',    'ң' => 'n',    'ө' => 'o',    'ұ' => 'u',    
		'ү' => 'u',    'һ' => 'h', 'Ә' => 'a',    'Ғ' => 'g',    'Қ' => 'k',    
		'Ң' => 'n',    'Ө' => 'o',    'Ұ' => 'u',    'Ү' => 'u',    'Һ' => 'h',    ',' => '.',    '/' => '-',
		
		'Q' => 'q',    'W' => 'w',    'E' => 'e',    'R' => 'r',    'T' => 't',
		'Y' => 'y',    'U' => 'u',    'I' => 'i',   'O' => 'o',    'P' => 'p',
		'A' => 'a',    'S' => 's',    'F' => 'f',    'G' => 'g',    'H' => 'h',
		'J' => 'j',    'K' => 'k',    'L' => 'l',    'Z' => 'z',    'X' => 'x',
		'C' => 'c',   'V' => 'v',  'B' => 'b',     'N' => 'n',    'M' => 'm',    'D' => 'd'
	);
 
	$v = strtr($v, $converter);
	return $v;
}

// SEO: Функция для генерации ЧПУ URL для товаров
function seo_get_product_url($product_id, $product_name) {
	// Создаем slug из названия товара
	$slug = hyst_translit_url(mb_strtolower($product_name));
	// Убираем лишние символы
	$slug = preg_replace('/[^a-z0-9-]/', '', $slug);
	// Убираем множественные дефисы
	$slug = preg_replace('/-+/', '-', $slug);
	// Убираем дефисы в начале и конце
	$slug = trim($slug, '-');
	// Если slug пустой, используем ID
	if (empty($slug)) {
		$slug = 'product-' . $product_id;
	}
	return '/katalog/' . $slug . '-' . $product_id;
}

// SEO: Функция для получения ID товара из ЧПУ URL
function seo_get_product_id_from_slug($slug) {
	// Извлекаем ID из конца URL (после последнего дефиса)
	if (preg_match('/-(\d+)$/', $slug, $matches)) {
		return (int)$matches[1];
	}
	return 0;
}





/**
 * Performance: Функция для оптимизации изображений - все изображения теперь в формате WebP
 * @param string $image_path - путь к изображению (все изображения теперь .webp)
 * @return array - массив с webp путем (основной формат) для совместимости с существующим кодом
 */
function get_optimized_image($image_path) {
	if (empty($image_path)) {
		return ['original' => '', 'webp' => '', 'has_webp' => false];
	}
	
	// Все изображения теперь в формате WebP
	// Если путь уже содержит .webp, используем его напрямую
	if (preg_match('/\.webp$/i', $image_path)) {
		return [
			'original' => $image_path,
			'webp' => $image_path,
			'has_webp' => true
		];
	}
	
	// Если путь в старом формате (jpg/jpeg/png), автоматически конвертируем расширение в .webp
	// Это для обратной совместимости с путями в базе данных
	$webp_path = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $image_path);
	
	$doc_root = isset($_SERVER['DOCUMENT_ROOT']) ? rtrim($_SERVER['DOCUMENT_ROOT'], '/') : '';
	$webp_fs = ($doc_root !== '' && $webp_path !== '') ? $doc_root . $webp_path : '';
	$webp_exists = ($webp_fs !== '' && is_file($webp_fs));
	
	// Возвращаем webp только если файл реально существует (иначе <picture> / фолбэк на original)
	return [
		'original' => $image_path,
		'webp' => $webp_exists ? $webp_path : '',
		'has_webp' => $webp_exists,
	];
}

function get_farrimg ($i) {
	$e = explode('][',$i);
	$r = array();
	foreach ($e as $v) {
	$v = str_ireplace("]", "", $v);
	$v = str_ireplace("[", "", $v);
	array_push($r, $v);
	}
	return $r;
}

/**
 * WARNING: Эта функция использует прямую конкатенацию SQL и уязвима к SQL инъекциям!
 * Используйте только с проверенными данными или переходите на hyst_idus_safe()
 * 
 * @deprecated Используйте hyst_idus_safe() для новых разработок
 */
function hyst_idus($c,$t,$v,$w=null,$s=null,$l=null) {
global $hyst_db;

	if ($c == 'i') {

		if (is_array($v)) {
		$co = '';
		$vl = '';
			$c = 0;
			foreach ($v as $k=>$z) {
			$co .= $k;
			$vl .= "'".$z."'";
			if (count($v) > ($c+1)) { $c++; $co .= ","; $vl .= ","; }
			}
		$sql = mysqli_query($HYST_dbconect,"INSERT INTO ".$t." (".$co.") VALUES (".$vl.")");
		return $sql;
		} else {
		return false;
		}
	} else if ($c == 'u') {
		if (is_array($v)) {
		$co = '';
			$c = 0;
			foreach ($v as $k=>$z) {
			$co .= $k."='".$z."'";
			if (count($v) > ($c+1)) { $c++; $co .= ","; }
			}
			$wh = '';
			if (is_array($w)) {
				$wh = ' WHERE';
				$c = 0;
				foreach ($w as $k=>$z) {
				$wh .= " ".$k."='".$z."'";
				if (count($w) > ($c+1)) { $c++; $wh .= " AND"; }
				}
			}
		$sql = mysqli_query($HYST_dbconect,"UPDATE ".$t." SET ".$co.$wh);
		return $sql;
		} else {
		return false;
		}
	} else if ($c == 's') {
		$wh = '';
		if (is_array($w)) {
			$wh = ' WHERE';
			$c = 0;
			foreach ($w as $k=>$z) {
			$wh .= " ".$k."='".$z."'";
			if (count($w) > ($c+1)) { $c++; $wh .= " AND"; }
			}
		}
		$so = '';
		if ($s != null) {
			$so = ' ORDER BY '.$s;
		}
		$li = '';
		if ($l != null) {
			$li = ' LIMIT '.$l;
		}
		$sql = mysqli_query($HYST_dbconect,"SELECT ".$v." FROM ".$t.$wh.$so.$li);
		return $sql;
	} else if ($c == 'd') {
		$wh = '';
		if (is_array($v)) {
			$wh = ' WHERE';
			$c = 0;
			foreach ($v as $k=>$z) {
			$wh .= " ".$k."='".$z."'";
			if (count($v) > ($c+1)) { $c++; $wh .= " AND"; }
			}
		}
		$sql = mysqli_query($HYST_dbconect,"DELETE FROM ".$t.$wh);
		return $sql;
	} else {
	return false;
	}
}

function hyst_img_resize($image, $folder, $width, $height) {

    $img_params = getimagesize($image['tmp_name']);
    $img_width = $img_params[0];
    $img_height = $img_params[1];
    $img_type = $img_params[2];

    $target_file = $folder.'/'.time() . '_' . uniqid() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);

    if ($img_width > $width || $img_height > $height) {
        switch ($img_type) {
            case IMAGETYPE_JPEG:
                $picture = imagecreatefromjpeg($image['tmp_name']);
                break;
            case IMAGETYPE_PNG:
                $picture = imagecreatefrompng($image['tmp_name']);
                break;
            case IMAGETYPE_WEBP:
                $picture = imagecreatefromwebp($image['tmp_name']);
                break;
            case IMAGETYPE_GIF:
                $picture = imagecreatefromgif($image['tmp_name']);
                break;
            case IMAGETYPE_SVG:
                copy($image['tmp_name'], $target_file);
                return str_replace($_SERVER['DOCUMENT_ROOT'],'',$target_file);
            default:
                return false;
        }

        $aspect_ratio = $img_width / $img_height;
        if ($img_width > $width || $img_height > $height) {
            if ($width / $height > $aspect_ratio) {
                $width = $height * $aspect_ratio;
            } else {
                $height = $width / $aspect_ratio;
            }
        }

        $new_image = imagecreatetruecolor($width, $height);

        imagecopyresampled($new_image, $picture, 0, 0, 0, 0, $width, $height, $img_width, $img_height);

        switch ($img_type) {
            case IMAGETYPE_JPEG:
                imagejpeg($new_image, $target_file);
                break;
            case IMAGETYPE_PNG:
                imagepng($new_image, $target_file);
                break;
            case IMAGETYPE_WEBP:
                imagewebp($new_image, $target_file);
                break;
            case IMAGETYPE_GIF:
                imagegif($new_image, $target_file);
                break;
        }

        imagedestroy($picture);
        imagedestroy($new_image);

        return str_replace ($_SERVER['DOCUMENT_ROOT'],'',$target_file);
    } else {
        move_uploaded_file($image['tmp_name'], $target_file);
        return str_replace ($_SERVER['DOCUMENT_ROOT'],'',$target_file);
    }
}


/**
 * Кодирование текста с использованием AES-256-CBC
 * Заменяет устаревшую функцию mcrypt
 * 
 * @param string $text Текст для кодирования
 * @param string $key Ключ шифрования
 * @return string Закодированный текст в base64
 */
function hyst_coder($text, $key) {
	$iv_length = openssl_cipher_iv_length('aes-256-cbc');
	$iv = openssl_random_pseudo_bytes($iv_length);
	$encrypted = openssl_encrypt($text, 'aes-256-cbc', $key, 0, $iv);
	return base64_encode($iv . $encrypted);
}

/**
 * Декодирование текста, закодированного функцией hyst_coder
 * Заменяет устаревшую функцию mcrypt
 * 
 * @param string $text Закодированный текст в base64
 * @param string $key Ключ шифрования
 * @return string|false Декодированный текст или false при ошибке
 */
function hyst_decoder($text, $key) {
	$data = base64_decode($text);
	if ($data === false) {
		return false;
	}
	$iv_length = openssl_cipher_iv_length('aes-256-cbc');
	$iv = substr($data, 0, $iv_length);
	$encrypted = substr($data, $iv_length);
	return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
}

function hyst_to_hash($str, $key) {
    $vector = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encryption = openssl_encrypt($str, 'aes-256-cbc', $key, 0, $vector);
    $str = base64_encode($vector . $encryption);
    return $str;
}

function hyst_unhash($str, $key) {
    $decrypted = base64_decode($str);
    $vector = substr($decrypted, 0, openssl_cipher_iv_length('aes-256-cbc'));
    $crypted = substr($decrypted, openssl_cipher_iv_length('aes-256-cbc'));
    $str = openssl_decrypt($crypted, 'aes-256-cbc', $key, 0, $vector);
    return $str;
}


function hyst_test_id ($val) {
	if (isset($val) && preg_match("/^[0-9]*$/",$val)) { return TRUE; } else { return FALSE; }
}

function hyst_test_img ($val) {
	if (!empty($val['name']) &&  sizeof($val['name']) != 0) { return TRUE; } else { return FALSE; }
}

class send_message {
    private $site_mail;
    private $whom;
    private $title;
    private $message;
    private $headers;
    private $boundary;

    public function __construct($whom, $title, $message, $reply_mail = false, $site_mail = SITE_MAIL) {
		$this->boundary = md5(time());
		$this->site_mail = $site_mail;
        $this->whom = $whom;
        $this->title = $title;
        $this->headers = "From: ".$site_mail."\r\n";
			if ($reply_mail) {
		$this->headers .= "Reply-To: ".$reply_mail."\r\n";	
			} else {
		$this->headers .= "Reply-To: ".$site_mail."\r\n";
			}
        $this->headers .= "MIME-Version: 1.0"."\r\n";
        $this->headers .= "Content-Type: multipart/mixed; boundary=\"".$this->boundary."\"\r\n";
		
		$this->message = "--".$this->boundary."\r\n";
		$this->message .= "Content-Type: text/html; charset=UTF-8\r\n";
		$this->message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		$this->message .= $message . "\r\n";	
    }
	
	public function attach_files($attachments) {
		if (is_array($attachments)) {
			foreach ($attachments as $file) {
				$file_content = file_get_contents($file);
				$file_content = chunk_split(base64_encode($file_content));
				$this->message .= "--".$this->boundary."\r\n";
				$this->message .= "Content-Type: application/octet-stream; name=\"" . basename($file) . "\"\r\n";
				$this->message .= "Content-Transfer-Encoding: base64\r\n";
				$this->message .= "Content-Disposition: attachment; filename=\"" . basename($file) . "\"\r\n\r\n";
				$this->message .= $file_content . "\r\n";
			}
		} else {
			$file_content = file_get_contents($attachments);
			$file_content = chunk_split(base64_encode($file_content));
			$this->message .= "--".$this->boundary."\r\n";
			$this->message .= "Content-Type: application/octet-stream; name=\"" . basename($attachments) . "\"\r\n";
			$this->message .= "Content-Transfer-Encoding: base64\r\n";
			$this->message .= "Content-Disposition: attachment; filename=\"" . basename($attachments) . "\"\r\n\r\n";
			$this->message .= $file_content . "\r\n";
		}
		$this->message .= "--".$this->boundary."--";
	}

    public function send() {
		$body = $this->message;
		$closing = '--' . $this->boundary . '--';
		if (strpos($body, $closing) === false) {
			$body .= $closing . "\r\n";
		}
		return @mail($this->whom, $this->title, $body, $this->headers);
    }
}

/**
 * Лог заявки в файл (резерв, если mail() на хостинге не сработал).
 */
function log_form_lead($subject, $message, $mail_sent = null) {
	$dir = $_SERVER['DOCUMENT_ROOT'] . '/var';
	if (!is_dir($dir)) {
		@mkdir($dir, 0755, true);
	}
	$status = $mail_sent === null ? 'unknown' : ($mail_sent ? 'email_ok' : 'email_fail');
	$line = date('Y-m-d H:i:s') . ' | ' . $status . ' | ' . $subject . ' | ' . preg_replace('/\s+/', ' ', strip_tags($message)) . "\n";
	return @file_put_contents($dir . '/form_leads.log', $line, FILE_APPEND | LOCK_EX) !== false;
}

/**
 * Отправка заявки на email + запись в лог. Успех — если записали в лог или письмо ушло.
 */
function send_form_lead($subject, $message, $reply_mail = false) {
	$body_html = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));
	$mail_sent = false;

	$smtp_ready = defined('MAIL_USE_SMTP') && MAIL_USE_SMTP && defined('SMTP_PASS') && SMTP_PASS !== '';
	if ($smtp_ready) {
		$mail_sent = smtp_send_mail(FORM_RECIPIENT_EMAIL, $subject, $body_html, $reply_mail ?: null);
	}

	if (!$mail_sent) {
		$letter = new send_message(FORM_RECIPIENT_EMAIL, $subject, $body_html, $reply_mail);
		$mail_sent = (bool) $letter->send();
	}

	$logged = log_form_lead($subject, $message, $mail_sent);
	return $mail_sent || $logged;
}

function check_form_spam_protection() {
	if (!empty($_POST['website'])) {
		return false;
	}
	if (isset($_POST['form_time'], $_POST['form_submit_time'])) {
		$time_diff = (int) $_POST['form_submit_time'] - (int) $_POST['form_time'];
		if ($time_diff < 0 || $time_diff > 86400) {
			return false;
		}
	}
	return true;
}


function hyst_test_val ($v,$r) {
	if (isset($v) && preg_match($r,$v)) { return TRUE; } else { return FALSE; }
}

function hyst_pagination($n,$l,$p) {
	$pages_count=ceil ($n/$l);
	if ($pages_count > 1) {
		if ($_SERVER['QUERY_STRING'] == '') {
		$link = $_SERVER['PHP_SELF'].'?page=';
		} else {
			parse_str($_SERVER['QUERY_STRING'], $variables);
			$link = http_build_query(array_diff_key($variables,array('page'=>"")));
			if ($link != '') {
			$link = $_SERVER['PHP_SELF'].'?'.$link.'&page=';
			} else {
			$link = $_SERVER['PHP_SELF'].'?page=';
			}
		}
		
		$html = '<ul>';
		for ($q = 1; $q <= $pages_count; $q++) {
		
		
			if ($p != $q && $q == 1 && $pages_count>1) {
			$html .= '<a href="'.$link.($p-1).'"><li> < </li></a>';
			}
			
			//  Общие страницы меньше 10ти \ (больше 10ти И первые пять ))
			if ($pages_count < 10 || ($pages_count > 10 && ($q < 6 || $q > ($pages_count - 5) || $q == $p || ($q > ($p - 6) && $q < $p) || ($q < ($p + 6) && $q > $p) ) ) ) {
				
				if ($q == ($p - 5) || $q == ($p + 5)) {
					
					$html .= '<i> ... </i>';
				
				} else {
				
					if ($p == $q) {
					$html .= '<li class="active">'.$q.'</li>';
					} else {
					$html .= '<a href="'.$link.$q.'"><li>'.$q.'</li></a>';	
					}
				}
			}
			
			
		}
		
			if ($p != $pages_count && $pages_count>1) {
		$html .= '<a href="'.$link.($p+1).'"><li> > </li></a>';
			}
		$html .= '</ul>';
		echo $html;
	}
}


/**
 * Security: Безопасная альтернатива функции hyst_idus
 * Использует prepared statements для защиты от SQL инъекций
 * 
 * @param string $operation Тип операции: 'i' (insert), 'u' (update), 's' (select), 'd' (delete)
 * @param string $table Название таблицы
 * @param array $data Данные для insert/update или поля для select
 * @param array|null $where Условия WHERE для update/select/delete
 * @param string|null $order ORDER BY для select
 * @param int|null $limit LIMIT для select
 * @param mysqli $connection Соединение с базой данных (по умолчанию $_DB_CONECT)
 * @return mysqli_result|bool Результат запроса или false при ошибке
 */
function hyst_idus_safe($operation, $table, $data, $where = null, $order = null, $limit = null, $connection = null) {
	global $_DB_CONECT;
	if ($connection === null) {
		$connection = $_DB_CONECT;
	}
	
	// Валидация названия таблицы (только буквы, цифры, подчеркивания)
	if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
		return false;
	}
	
	switch ($operation) {
		case 'i': // INSERT
			if (!is_array($data) || empty($data)) {
				return false;
			}
			
			$columns = array_keys($data);
			$values = array_values($data);
			$placeholders = str_repeat('?,', count($values) - 1) . '?';
			
			// Валидация названий колонок
			foreach ($columns as $col) {
				if (!preg_match('/^[a-zA-Z0-9_]+$/', $col)) {
					return false;
				}
			}
			
			$sql = "INSERT INTO `{$table}` (`" . implode('`, `', $columns) . "`) VALUES ({$placeholders})";
			$stmt = $connection->prepare($sql);
			if (!$stmt) {
				return false;
			}
			
			$types = str_repeat('s', count($values)); // Все как строки, можно оптимизировать
			$stmt->bind_param($types, ...$values);
			$result = $stmt->execute();
			$stmt->close();
			return $result;
			
		case 'u': // UPDATE
			if (!is_array($data) || empty($data) || !is_array($where) || empty($where)) {
				return false;
			}
			
			$set_parts = [];
			$set_values = [];
			foreach ($data as $col => $val) {
				if (!preg_match('/^[a-zA-Z0-9_]+$/', $col)) {
					return false;
				}
				$set_parts[] = "`{$col}` = ?";
				$set_values[] = $val;
			}
			
			$where_parts = [];
			$where_values = [];
			foreach ($where as $col => $val) {
				if (!preg_match('/^[a-zA-Z0-9_]+$/', $col)) {
					return false;
				}
				$where_parts[] = "`{$col}` = ?";
				$where_values[] = $val;
			}
			
			$sql = "UPDATE `{$table}` SET " . implode(', ', $set_parts) . " WHERE " . implode(' AND ', $where_parts);
			$stmt = $connection->prepare($sql);
			if (!$stmt) {
				return false;
			}
			
			$all_values = array_merge($set_values, $where_values);
			$types = str_repeat('s', count($all_values));
			$stmt->bind_param($types, ...$all_values);
			$result = $stmt->execute();
			$stmt->close();
			return $result;
			
		case 's': // SELECT
			if (!is_string($data) || empty($data)) {
				return false;
			}
			
			$sql = "SELECT {$data} FROM `{$table}`";
			$params = [];
			$types = '';
			
			if (is_array($where) && !empty($where)) {
				$where_parts = [];
				foreach ($where as $col => $val) {
					if (!preg_match('/^[a-zA-Z0-9_]+$/', $col)) {
						return false;
					}
					$where_parts[] = "`{$col}` = ?";
					$params[] = $val;
					$types .= 's';
				}
				$sql .= " WHERE " . implode(' AND ', $where_parts);
			}
			
			if ($order !== null) {
				// Валидация ORDER BY (простая, можно улучшить)
				if (preg_match('/^[a-zA-Z0-9_\s,]+$/', $order)) {
					$sql .= " ORDER BY {$order}";
				}
			}
			
			if ($limit !== null && is_numeric($limit)) {
				$sql .= " LIMIT " . (int)$limit;
			}
			
			$stmt = $connection->prepare($sql);
			if (!$stmt) {
				return false;
			}
			
			if (!empty($params)) {
				$stmt->bind_param($types, ...$params);
			}
			
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->close();
			return $result;
			
		case 'd': // DELETE
			if (!is_array($where) || empty($where)) {
				return false;
			}
			
			$where_parts = [];
			$where_values = [];
			foreach ($where as $col => $val) {
				if (!preg_match('/^[a-zA-Z0-9_]+$/', $col)) {
					return false;
				}
				$where_parts[] = "`{$col}` = ?";
				$where_values[] = $val;
			}
			
			$sql = "DELETE FROM `{$table}` WHERE " . implode(' AND ', $where_parts);
			$stmt = $connection->prepare($sql);
			if (!$stmt) {
				return false;
			}
			
			$types = str_repeat('s', count($where_values));
			$stmt->bind_param($types, ...$where_values);
			$result = $stmt->execute();
			$stmt->close();
			return $result;
			
		default:
			return false;
	}
}

function hyst_random_password($length = 6) {
    $symbols = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_';
    $password = '';
    $max_symb = strlen($symbols) - 1;
    
    for ($q = 0; $q < $length; $q++) {
        $symb = random_int(0, $max_symb);
        $password .= $symbols[$symb];
    }
    
    return $password;
}


function hyst_getdescription ($t,$l) {
	$tx = substr($t, 0, $l);
	$tx = substr ($tx, 0, strrpos($tx, ' '));
	return strip_tags($tx);
}

/**
 * Security: Функция для безопасного хеширования паролей администраторов
 * Использует password_hash с алгоритмом PASSWORD_DEFAULT (bcrypt)
 * Обеспечивает автоматическую генерацию соли и защиту от атак перебора
 * 
 * @param string $password Пароль для хеширования
 * @return string Хеш пароля в формате, совместимом с password_verify
 */
function hyst_hash_admin_password($password) {
	// Используем password_hash с PASSWORD_DEFAULT (в PHP 7.2+ это bcrypt)
	// Автоматически генерирует соль и использует оптимальную стоимость
	return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Security: Функция для проверки пароля администратора
 * Использует password_verify для безопасной проверки хеша
 * 
 * @param string $password Пароль для проверки
 * @param string $hash Хеш пароля из базы данных
 * @return bool true если пароль совпадает, false в противном случае
 */
function hyst_verify_admin_password($password, $hash) {
	// Проверяем, является ли хеш старым форматом (для обратной совместимости)
	$old_hash = hash('ripemd160', strrev(md5($password)) . 'hervam');
	if ($hash === $old_hash) {
		// Если это старый хеш, пересоздаем с новым методом
		// Возвращаем true для успешной проверки, но рекомендуется обновить хеш в БД
		return true;
	}
	// Проверяем новый формат хеша
	return password_verify($password, $hash);
}

function hyst_setmeta($file_path,$metadata) {
	
	if (pathinfo($file_path)['extension'] == 'svg') {
		$file = file_get_contents($file_path);
		if ($file) {

			$data = explode('<![CDATA[HYST_METAEND', $file);
			
			file_put_contents($file_path,$data[0].'<![CDATA[HYST_METAEND'.json_encode($metadata,JSON_UNESCAPED_UNICODE).']]></svg>');
			
		} else {
		return false;
		}
	} else {
		$file = fopen($file_path, 'r+b');
		if ($file) {
			$data = fread($file, filesize($file_path));
			$data = explode('HYST_METASTART', $data);

			$data_to_append = pack("a*", 'HYST_METASTART'.json_encode($metadata,JSON_UNESCAPED_UNICODE).'HYST_METAEND');
			fwrite($file, $data[0].$data_to_append);	

			fclose($file);
			return true;
		} else {
		return false;
		}
	}
}

function hyst_imeta($file_path) {
	if (pathinfo($file_path)['extension'] == 'svg') {
		$file = file_get_contents($file_path);
		if ($file) {

			$data = explode('<![CDATA[HYST_METAEND', $file);
			
			return json_decode(explode(']]></svg>',$data[1])[0],1);
			
		} else {
		return false;
		}
	} else {
	
		$file = fopen($file_path, 'rb');
		if ($file) {
			$data = fread($file, filesize($file_path));
			
			$data = explode('HYST_METAEND',explode('HYST_METASTART', $data)[1])[0];

			$result = json_decode($data,1); 

			fclose($file); 
			
			if (is_null($result)) {
			return false; 
			} else {
			return $result;; 
			}
		} else {
			return false;
		}
	}
}



function hyst_get_browser() {
    $browsers = [
        'Opera' => '/Opera|OPR\//',
        'Edge' => '/Edge/',
        'Chrome' => '/Chrome/',
        'Safari' => '/Safari/',
        'Firefox' => '/Firefox/',
        'Internet Explorer' => '/MSIE|Trident/'
    ];
    
    foreach ($browsers as $browser => $pattern) {
        if (preg_match($pattern, $_SERVER['HTTP_USER_AGENT'], $matches)) {
            $version = preg_match('/' . $browser . '[\/ ]([0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $matches) ? $matches[1] : '';
            return $browser . ' ' . $version;
        }
    }
    return 'Unknown Browser';
}

function hyst_get_os() {
    $operating_systems = [
        'Windows' => '/Windows NT ([0-9.]+)/',
        'Mac OS' => '/Mac OS X ([0-9_]+)/',
        'Linux' => '/Linux/',
        'iOS' => '/iPhone|iPad; CPU (iPhone|iPad) OS ([0-9_]+)/',
        'Android' => '/Android ([0-9.]+)/'
    ];
    
    foreach ($operating_systems as $os => $pattern) {
        if (preg_match($pattern, $_SERVER['HTTP_USER_AGENT'],$matches)) {
			$version = isset($matches[1]) ? str_replace('_', '.', $matches[1]) : '';
            return $os.' '.$version;
        }
    }
    return 'Unknown OS';
}
?>