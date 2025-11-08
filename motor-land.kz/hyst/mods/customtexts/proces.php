<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');

function get_customtexts ($i) {
	global $_DB_CONECT;
	$hyst_sql = $_DB_CONECT->query("SELECT * FROM customtexts WHERE key_id='".$i."' ORDER BY id DESC");
	if (mysqli_num_rows($hyst_sql) != 0) { return mysqli_fetch_array($hyst_sql)['text']; } else { return false; }
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
	} else {
		// Проверяем, существует ли текст "О нас", если нет - добавляем
		$check_about = $_DB_CONECT->query("SELECT id FROM customtexts WHERE key_id='index_about_text'");
		if ($check_about->num_rows == 0) {
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
			$sql = $_DB_CONECT->query("SELECT id FROM customtexts WHERE key_id='".$_REQUEST['customtexts_key']."'");
			if (mysqli_num_rows($sql) != 0) { 
			$report['error'] = 2;
			$report['message'] = 'Такой ключ для вывода уже занят другим текстом!';
			} else {
		
				$sql = $_DB_CONECT->query("INSERT INTO customtexts (name,key_id,text) VALUES ('".$_REQUEST['customtexts_name']."','".$_REQUEST['customtexts_key']."','".$_REQUEST['customtexts_text']."')");
				if ($sql != false) {
				$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
				$report['error'] = 1;
				$report['message'] = 'Текст добавлен';
				} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных!';
				}
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
			$sql = $_DB_CONECT->query("SELECT id FROM customtexts WHERE key_id='".$_REQUEST['customtexts_key']."' AND id!='".$_REQUEST['customtexts_id']."'");
			if (mysqli_num_rows($sql) != 0) { 
			$report['error'] = 2;
			$report['message'] = 'Такой ключ для вывода уже занят другим текстом!';
			} else {
		
				$sql = $_DB_CONECT->query("UPDATE customtexts SET name='".$_REQUEST['customtexts_name']."',key_id='".$_REQUEST['customtexts_key']."',
				text='".$_REQUEST['customtexts_text']."' WHERE id='".$_REQUEST['customtexts_id']."'");
				if ($sql != false) {
				$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
				$report['error'] = 3;
				$report['message'] = 'Данные обновлены';
				$report['visual_changes'] = array ('#visual_ch_slideroler_'.$_REQUEST['customtexts_id']=>$_REQUEST['customtexts_name'].' ['.$_REQUEST['customtexts_key'].']');
				} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных!';
				}
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'customtexts_del') { 
		if (!hyst_test_id($_REQUEST['customtexts_id'])) {
		$report['error'] = 2;
		$report['message'] = 'Не верный идентификатор!';
		} else { 
			$sql = $_DB_CONECT->query("DELETE FROM customtexts WHERE id='".$_REQUEST['customtexts_id']."'");
			if ($sql != false) {
			$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
			$report['error'] = 3;
			$report['message'] = 'Запись удалена!';
			$report['delete_item'] = '.delet_slider_block'.$_REQUEST['customtexts_id'];
			} else {
			$report['error'] = 2;
			$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}


}
?>