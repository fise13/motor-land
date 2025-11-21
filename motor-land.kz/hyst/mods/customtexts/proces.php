<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');

function get_customtexts ($i) {
	global $_DB_CONECT;
	if (!isset($_DB_CONECT) || !$_DB_CONECT) {
		return false;
	}
	$stmt = $_DB_CONECT->prepare("SELECT * FROM customtexts WHERE key_id = ? ORDER BY id DESC LIMIT 1");
	if ($stmt) {
		$stmt->bind_param("s", $i);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result && $result->num_rows != 0) {
			$row = $result->fetch_assoc();
			$stmt->close();
			return $row['text'];
		}
		$stmt->close();
	}
	return false;
}


if ($_HYST_ADMIN && ($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all'  || array_search('customtexts',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false)) {

	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = '".DB_BASE."' AND table_name = 'customtexts'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE customtexts
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(255) NOT NULL DEFAULT 'noting',
			key_id VARCHAR(255) NOT NULL DEFAULT 'noting',
			text LONGTEXT NOT NULL
		)");
		
		// Инициализация текста "О нас"
		$about_text = '<p><strong>Motor Land</strong> — ведущая компания в Казахстане по продаже и установке контрактных двигателей и коробок передач из Малайзии, Японии и других стран.</p>

<p>Мы работаем на рынке уже много лет и заслужили репутацию надежного партнера для тысяч автовладельцев по всему Казахстану. Наша специализация — поставка качественных контрактных агрегатов для японских, корейских и европейских автомобилей.</p>

<h3>Наши преимущества:</h3>
<ul>
<li><strong>Широкий ассортимент</strong> — более 500 контрактных двигателей и КПП в наличии</li>
<li><strong>Прямые поставки</strong> — работаем напрямую с поставщиками из Малайзии и Японии</li>
<li><strong>Гарантия качества</strong> — все агрегаты проходят тщательную проверку перед отправкой</li>
<li><strong>Профессиональная установка</strong> — имеем собственный сервис с опытными механиками</li>
<li><strong>Доставка по Казахстану</strong> — быстро и надежно доставляем заказы в любой город</li>
<li><strong>Конкурентные цены</strong> — предлагаем лучшие цены на рынке без переплат</li>
</ul>

<p>Мы понимаем, что покупка контрактного двигателя или КПП — это важное решение. Поэтому наша команда всегда готова предоставить профессиональную консультацию, помочь с выбором подходящего агрегата и ответить на все ваши вопросы.</p>

<p>Все наши клиенты получают полную гарантию на приобретенную продукцию и могут быть уверены в качестве и надежности нашего сервиса. Мы ценим каждого клиента и стремимся к долгосрочному сотрудничеству.</p>

<p><strong>Обращайтесь к нам, и мы поможем вам вернуть ваш автомобиль в строй!</strong></p>';
		
		$about_text_escaped = $_DB_CONECT->real_escape_string($about_text);
		$_DB_CONECT->query("INSERT INTO customtexts (name, key_id, text) VALUES ('О нас', 'index_about_text', '".$about_text_escaped."')");
		
		// Инициализация текста для страницы "Автосервис"
		$service_text = '<p>Наш автосервис предлагает профессиональную замену и обслуживание двигателей, а также замену КПП для автомобилей различных марок и моделей.</p>';
		$service_text_escaped = $_DB_CONECT->real_escape_string($service_text);
		$_DB_CONECT->query("INSERT INTO customtexts (name, key_id, text) VALUES ('Текст Автосервис (рядом с фото)', 'service_page_hero_text', '".$service_text_escaped."')");
		
		// Инициализация текста для страницы "Оплата и Доставка"
		$pay_text = '<p>Мы обеспечиваем доставку автозапчастей и двигателей по всей территории Казахстана и в страны СНГ через транспортные компании. Если доставка официальной транспортной компанией невозможна, мы поможем организовать перевозку частными перевозчиками.</p>';
		$pay_text_escaped = $_DB_CONECT->real_escape_string($pay_text);
		$_DB_CONECT->query("INSERT INTO customtexts (name, key_id, text) VALUES ('Текст Доставка и Оплата (рядом с фото)', 'pay_page_hero_text', '".$pay_text_escaped."')");
	} else {
		// Проверяем, существует ли текст "О нас", если нет - добавляем
		$stmt = $_DB_CONECT->prepare("SELECT id FROM customtexts WHERE key_id = 'index_about_text' LIMIT 1");
		if ($stmt) {
			$stmt->execute();
			$check_about = $stmt->get_result();
			$stmt->close();
		} else {
			$check_about = false;
		}
		if (!$check_about || $check_about->num_rows == 0) {
			$about_text = '<p><strong>Motor Land</strong> — ведущая компания в Казахстане по продаже и установке контрактных двигателей и коробок передач из Малайзии, Японии и других стран.</p>

<p>Мы работаем на рынке уже много лет и заслужили репутацию надежного партнера для тысяч автовладельцев по всему Казахстану. Наша специализация — поставка качественных контрактных агрегатов для японских, корейских и европейских автомобилей.</p>

<h3>Наши преимущества:</h3>
<ul>
<li><strong>Широкий ассортимент</strong> — более 500 контрактных двигателей и КПП в наличии</li>
<li><strong>Прямые поставки</strong> — работаем напрямую с поставщиками из Малайзии и Японии</li>
<li><strong>Гарантия качества</strong> — все агрегаты проходят тщательную проверку перед отправкой</li>
<li><strong>Профессиональная установка</strong> — имеем собственный сервис с опытными механиками</li>
<li><strong>Доставка по Казахстану</strong> — быстро и надежно доставляем заказы в любой город</li>
<li><strong>Конкурентные цены</strong> — предлагаем лучшие цены на рынке без переплат</li>
</ul>

<p>Мы понимаем, что покупка контрактного двигателя или КПП — это важное решение. Поэтому наша команда всегда готова предоставить профессиональную консультацию, помочь с выбором подходящего агрегата и ответить на все ваши вопросы.</p>

<p>Все наши клиенты получают полную гарантию на приобретенную продукцию и могут быть уверены в качестве и надежности нашего сервиса. Мы ценим каждого клиента и стремимся к долгосрочному сотрудничеству.</p>

<p><strong>Обращайтесь к нам, и мы поможем вам вернуть ваш автомобиль в строй!</strong></p>';
			$about_text_escaped = $_DB_CONECT->real_escape_string($about_text);
			$_DB_CONECT->query("INSERT INTO customtexts (name, key_id, text) VALUES ('О нас', 'index_about_text', '".$about_text_escaped."')");
		}
		
		// Проверяем и инициализируем текст для страницы "Автосервис"
		$stmt = $_DB_CONECT->prepare("SELECT id FROM customtexts WHERE key_id = 'service_page_hero_text' LIMIT 1");
		if ($stmt) {
			$stmt->execute();
			$check_service = $stmt->get_result();
			$stmt->close();
		} else {
			$check_service = false;
		}
		if (!$check_service || $check_service->num_rows == 0) {
			$service_text = '<p>Наш автосервис предлагает профессиональную замену и обслуживание двигателей, а также замену КПП для автомобилей различных марок и моделей.</p>';
			$service_text_escaped = $_DB_CONECT->real_escape_string($service_text);
			$_DB_CONECT->query("INSERT INTO customtexts (name, key_id, text) VALUES ('Текст Автосервис (рядом с фото)', 'service_page_hero_text', '".$service_text_escaped."')");
		}
		
		// Проверяем и инициализируем текст для страницы "Оплата и Доставка"
		$stmt = $_DB_CONECT->prepare("SELECT id FROM customtexts WHERE key_id = 'pay_page_hero_text' LIMIT 1");
		if ($stmt) {
			$stmt->execute();
			$check_pay = $stmt->get_result();
			$stmt->close();
		} else {
			$check_pay = false;
		}
		if (!$check_pay || $check_pay->num_rows == 0) {
			$pay_text = '<p>Мы обеспечиваем доставку автозапчастей и двигателей по всей территории Казахстана и в страны СНГ через транспортные компании. Если доставка официальной транспортной компанией невозможна, мы поможем организовать перевозку частными перевозчиками.</p>';
			$pay_text_escaped = $_DB_CONECT->real_escape_string($pay_text);
			$_DB_CONECT->query("INSERT INTO customtexts (name, key_id, text) VALUES ('Текст Доставка и Оплата (рядом с фото)', 'pay_page_hero_text', '".$pay_text_escaped."')");
		}
	}
	
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'customtexts_add') {
		if (!hyst_test_val($_REQUEST['customtexts_name'],REGEXP_NAME)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_val($_REQUEST['customtexts_key'],REGEXP_NICKNAME)) {
		$report['error'] = 2;
		$report['message'] = 'Ключ для вывода содержит не корреткные символы (только А-z0-9 и - _)!';
		} else if (empty($_REQUEST['customtexts_text'])) { 
		$report['error'] = 2;
		$report['message'] = 'Поле текст не может быть пустым!';
		} else { 
			// Безопасная проверка существования ключа
			$stmt = $_DB_CONECT->prepare("SELECT id FROM customtexts WHERE key_id = ? LIMIT 1");
			if ($stmt) {
				$stmt->bind_param("s", $_REQUEST['customtexts_key']);
				$stmt->execute();
				$sql = $stmt->get_result();
				$stmt->close();
				
				if ($sql && $sql->num_rows != 0) { 
					$report['error'] = 2;
					$report['message'] = 'Такой ключ для вывода уже занят другим текстом!';
				} else {
					// Безопасная вставка
					$stmt = $_DB_CONECT->prepare("INSERT INTO customtexts (name,key_id,text) VALUES (?,?,?)");
					if ($stmt) {
						$stmt->bind_param("sss", $_REQUEST['customtexts_name'], $_REQUEST['customtexts_key'], $_REQUEST['customtexts_text']);
						$result = $stmt->execute();
						$stmt->close();
						
						if ($result) {
							// Обновление времени последнего действия
							$admin_id = (int)$_HYST_ADMIN['id'];
							$last_action = time();
							$stmt = $_DB_CONECT->prepare("UPDATE `".AUT_NAME."` SET `".AUC_PREFIX."_laac` = ? WHERE id = ?");
							if ($stmt) {
								$stmt->bind_param("ii", $last_action, $admin_id);
								$stmt->execute();
								$stmt->close();
							}
							$report['error'] = 1;
							$report['message'] = 'Текст добавлен';
						} else {
							$report['error'] = 2;
							$report['message'] = 'Ошибка базы данных!';
						}
					} else {
						$report['error'] = 2;
						$report['message'] = 'Ошибка базы данных!';
					}
				}
			} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'customtexts_red') {
		if (!hyst_test_val($_REQUEST['customtexts_name'],REGEXP_NAME)) {
		$report['error'] = 2;
		$report['message'] = 'Название содержит не корреткные символы!';
		} else if (!hyst_test_val($_REQUEST['customtexts_key'],REGEXP_NICKNAME)) {
		$report['error'] = 2;
		$report['message'] = 'Ключ для вывода содержит не корреткные символы (только А-z0-9 и - _)!';
		} else if (empty($_REQUEST['customtexts_text'])) { 
		$report['error'] = 2;
		$report['message'] = 'Поле текст не может быть пустым!';
		} else if (!hyst_test_id($_REQUEST['customtexts_id'])) { 
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			// Безопасная проверка существования ключа
			$text_id = (int)$_REQUEST['customtexts_id'];
			$stmt = $_DB_CONECT->prepare("SELECT id FROM customtexts WHERE key_id = ? AND id != ? LIMIT 1");
			if ($stmt) {
				$stmt->bind_param("si", $_REQUEST['customtexts_key'], $text_id);
				$stmt->execute();
				$sql = $stmt->get_result();
				$stmt->close();
				
				if ($sql && $sql->num_rows != 0) { 
					$report['error'] = 2;
					$report['message'] = 'Такой ключ для вывода уже занят другим текстом!';
				} else {
					// Безопасное обновление
					$stmt = $_DB_CONECT->prepare("UPDATE customtexts SET name = ?, key_id = ?, text = ? WHERE id = ?");
					if ($stmt) {
						$stmt->bind_param("sssi", $_REQUEST['customtexts_name'], $_REQUEST['customtexts_key'], $_REQUEST['customtexts_text'], $text_id);
						$result = $stmt->execute();
						$stmt->close();
						
						if ($result) {
							// Обновление времени последнего действия
							$admin_id = (int)$_HYST_ADMIN['id'];
							$last_action = time();
							$stmt = $_DB_CONECT->prepare("UPDATE `".AUT_NAME."` SET `".AUC_PREFIX."_laac` = ? WHERE id = ?");
							if ($stmt) {
								$stmt->bind_param("ii", $last_action, $admin_id);
								$stmt->execute();
								$stmt->close();
							}
							$report['error'] = 3;
							$report['message'] = 'Данные обновлены';
							$report['visual_changes'] = array ('#visual_ch_slideroler_'.$text_id=>$_REQUEST['customtexts_name'].' ['.$_REQUEST['customtexts_key'].']');
						} else {
							$report['error'] = 2;
							$report['message'] = 'Ошибка базы данных!';
						}
					} else {
						$report['error'] = 2;
						$report['message'] = 'Ошибка базы данных!';
					}
				}
			} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'customtexts_del') { 
		if (!hyst_test_id($_REQUEST['customtexts_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			// Безопасное удаление
			$text_id = (int)$_REQUEST['customtexts_id'];
			$stmt = $_DB_CONECT->prepare("DELETE FROM customtexts WHERE id = ?");
			if ($stmt) {
				$stmt->bind_param("i", $text_id);
				$result = $stmt->execute();
				$stmt->close();
				
				if ($result) {
					// Обновление времени последнего действия
					$admin_id = (int)$_HYST_ADMIN['id'];
					$last_action = time();
					$stmt = $_DB_CONECT->prepare("UPDATE `".AUT_NAME."` SET `".AUC_PREFIX."_laac` = ? WHERE id = ?");
					if ($stmt) {
						$stmt->bind_param("ii", $last_action, $admin_id);
						$stmt->execute();
						$stmt->close();
					}
					$report['error'] = 3;
					$report['message'] = 'Запись удалена!';
					$report['delete_item'] = '.delet_slider_block'.$text_id;
				} else {
					$report['error'] = 2;
					$report['message'] = 'Ошибка базы данных!';
				}
			} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}


}
?>