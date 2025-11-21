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
 * Performance: Функция для оптимизации изображений - возвращает WebP с fallback
 * @param string $image_path - путь к изображению
 * @return array - массив с webp и оригинальным форматом
 */
function get_optimized_image($image_path) {
	if (empty($image_path)) {
		return ['original' => '', 'webp' => ''];
	}
	
	// Проверяем поддержку WebP через Accept заголовок
	$webp_path = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $image_path);
	
	// Если WebP существует, возвращаем его
	if (file_exists($_SERVER['DOCUMENT_ROOT'] . $webp_path)) {
		return [
			'original' => $image_path,
			'webp' => $webp_path,
			'has_webp' => true
		];
	}
	
	return [
		'original' => $image_path,
		'webp' => '',
		'has_webp' => false
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
 * Безопасная функция для работы с БД через prepared statements
 * @param string $c - команда: 'i' (insert), 'u' (update), 's' (select), 'd' (delete)
 * @param string $t - имя таблицы
 * @param array|string $v - данные для insert/update или поля для select
 * @param array|null $w - условия WHERE
 * @param string|null $s - ORDER BY
 * @param int|null $l - LIMIT
 * @return mysqli_result|false
 */
function hyst_idus($c,$t,$v,$w=null,$s=null,$l=null) {
	global $_DB_CONECT;
	
	if (!isset($_DB_CONECT) || !$_DB_CONECT) {
		return false;
	}
	
	// Валидация имени таблицы (только буквы, цифры, подчеркивания)
	if (!preg_match('/^[a-zA-Z0-9_]+$/', $t)) {
		return false;
	}

	if ($c == 'i') {
		if (is_array($v) && !empty($v)) {
			$columns = array_keys($v);
			$values = array_values($v);
			
			// Валидация имен колонок
			foreach ($columns as $col) {
				if (!preg_match('/^[a-zA-Z0-9_]+$/', $col)) {
					return false;
				}
			}
			
			$placeholders = str_repeat('?,', count($values) - 1) . '?';
			$columns_str = implode(',', $columns);
			$types = str_repeat('s', count($values));
			
			$stmt = $_DB_CONECT->prepare("INSERT INTO `{$t}` ({$columns_str}) VALUES ({$placeholders})");
			if ($stmt) {
				$stmt->bind_param($types, ...$values);
				$result = $stmt->execute();
				$stmt->close();
				return $result;
			}
		}
		return false;
	} else if ($c == 'u') {
		if (is_array($v) && !empty($v)) {
			$set_parts = [];
			$set_values = [];
			$types = '';
			
			foreach ($v as $k => $z) {
				if (!preg_match('/^[a-zA-Z0-9_]+$/', $k)) {
					return false;
				}
				$set_parts[] = "`{$k}` = ?";
				$set_values[] = $z;
				$types .= 's';
			}
			
			$where_clause = '';
			$where_values = [];
			
			if (is_array($w) && !empty($w)) {
				$where_parts = [];
				foreach ($w as $k => $z) {
					if (!preg_match('/^[a-zA-Z0-9_]+$/', $k)) {
						return false;
					}
					$where_parts[] = "`{$k}` = ?";
					$where_values[] = $z;
					$types .= 's';
				}
				$where_clause = ' WHERE ' . implode(' AND ', $where_parts);
			}
			
			$all_values = array_merge($set_values, $where_values);
			$stmt = $_DB_CONECT->prepare("UPDATE `{$t}` SET " . implode(', ', $set_parts) . $where_clause);
			if ($stmt) {
				$stmt->bind_param($types, ...$all_values);
				$result = $stmt->execute();
				$stmt->close();
				return $result;
			}
		}
		return false;
	} else if ($c == 's') {
		// Валидация полей для SELECT
		if (is_string($v)) {
			// Разрешаем только безопасные символы для полей
			if (!preg_match('/^[a-zA-Z0-9_,\s`*]+$/', $v)) {
				return false;
			}
		} else {
			return false;
		}
		
		$where_clause = '';
		$where_values = [];
		$types = '';
		
		if (is_array($w) && !empty($w)) {
			$where_parts = [];
			foreach ($w as $k => $z) {
				if (!preg_match('/^[a-zA-Z0-9_]+$/', $k)) {
					return false;
				}
				$where_parts[] = "`{$k}` = ?";
				$where_values[] = $z;
				$types .= 's';
			}
			$where_clause = ' WHERE ' . implode(' AND ', $where_parts);
		}
		
		$order_clause = '';
		if ($s != null && is_string($s)) {
			// Валидация ORDER BY (только безопасные символы)
			if (preg_match('/^[a-zA-Z0-9_,\s`]+$/', $s)) {
				$order_clause = ' ORDER BY ' . $s;
			}
		}
		
		$limit_clause = '';
		if ($l != null && is_numeric($l) && $l > 0) {
			$limit_clause = ' LIMIT ' . (int)$l;
		}
		
		$query = "SELECT {$v} FROM `{$t}`{$where_clause}{$order_clause}{$limit_clause}";
		$stmt = $_DB_CONECT->prepare($query);
		
		if ($stmt) {
			if (!empty($where_values)) {
				$stmt->bind_param($types, ...$where_values);
			}
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->close();
			return $result;
		}
		return false;
	} else if ($c == 'd') {
		$where_clause = '';
		$where_values = [];
		$types = '';
		
		if (is_array($v) && !empty($v)) {
			$where_parts = [];
			foreach ($v as $k => $z) {
				if (!preg_match('/^[a-zA-Z0-9_]+$/', $k)) {
					return false;
				}
				$where_parts[] = "`{$k}` = ?";
				$where_values[] = $z;
				$types .= 's';
			}
			$where_clause = ' WHERE ' . implode(' AND ', $where_parts);
		} else {
			// Без WHERE нельзя удалять все записи
			return false;
		}
		
		$stmt = $_DB_CONECT->prepare("DELETE FROM `{$t}`{$where_clause}");
		if ($stmt) {
			$stmt->bind_param($types, ...$where_values);
			$result = $stmt->execute();
			$stmt->close();
			return $result;
		}
		return false;
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
		return mail($this->whom,$this->title,$this->message,$this->headers);
    }
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
 * Безопасное хеширование пароля администратора
 * @param string $v - пароль
 * @param string $d - дополнительная соль (deprecated, оставлено для обратной совместимости)
 * @return string - хеш пароля
 */
function hyst_hash_admin_password($v,$d='hervam') {
	// Используем password_hash для новых паролей
	// Для обратной совместимости проверяем старый формат при проверке
	return password_hash($v, PASSWORD_BCRYPT, ['cost' => 12]);
}

/**
 * Проверка пароля администратора (поддерживает старый и новый формат)
 * @param string $password - введенный пароль
 * @param string $hash - сохраненный хеш
 * @param string $d - дополнительная соль для старого формата
 * @return bool
 */
function hyst_verify_admin_password($password, $hash, $d='hervam') {
	// Сначала пробуем новый формат
	if (password_verify($password, $hash)) {
		return true;
	}
	// Проверяем старый формат для обратной совместимости
	$old_hash = hash('ripemd160', strrev(md5($password)) . $d);
	if (hash_equals($old_hash, $hash)) {
		// Перехешируем в новый формат при следующем входе
		return true;
	}
	return false;
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