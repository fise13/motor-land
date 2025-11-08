<?php
// Защита от повторного запуска сессии
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');

// Функция для получения статей блога (для использования на сайте)
function get_blog_articles($limit = null, $category = null, $status = 'published') {
	global $_DB_CONECT;
	$query = "SELECT * FROM blog_articles WHERE status='".$status."'";
	if ($category) {
		$query .= " AND category='".mysqli_real_escape_string($_DB_CONECT, $category)."'";
	}
	$query .= " ORDER BY date DESC";
	if ($limit) {
		$query .= " LIMIT ".(int)$limit;
	}
	$result = $_DB_CONECT->query($query);
	$articles = [];
	if ($result && mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$articles[] = $row;
		}
	}
	return $articles;
}

// Функция для получения статьи по slug
function get_blog_article($slug) {
	global $_DB_CONECT;
	
	if (!isset($_DB_CONECT) || !$_DB_CONECT) {
		error_log('get_blog_article: Database connection not available');
		return false;
	}
	
	if (empty($slug)) {
		error_log('get_blog_article: Empty slug provided');
		return false;
	}
	
	try {
		$slug = mysqli_real_escape_string($_DB_CONECT, $slug);
		$query = "SELECT * FROM blog_articles WHERE slug='".$slug."' AND status='published' LIMIT 1";
		$result = $_DB_CONECT->query($query);
		
		if ($result === false) {
			error_log('get_blog_article: Query error - ' . mysqli_error($_DB_CONECT));
			return false;
		}
		
		if (mysqli_num_rows($result) > 0) {
			$article = mysqli_fetch_assoc($result);
			return $article;
		}
		
		return false;
	} catch (Exception $e) {
		error_log('get_blog_article exception: ' . $e->getMessage());
		return false;
	}
}

if ($_HYST_ADMIN && ($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all' || array_search('blog',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false)) {

	// Создание таблицы если её нет
	$check = $_DB_CONECT->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'DB_BASE' AND table_name = 'blog_articles'");
	if ($check->num_rows == 0) {
		$check = $_DB_CONECT->query("CREATE TABLE blog_articles
		(
			id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			title VARCHAR(500) NOT NULL DEFAULT '',
			slug VARCHAR(255) NOT NULL DEFAULT '',
			description TEXT NOT NULL,
			content LONGTEXT NOT NULL,
			image VARCHAR(500) NOT NULL DEFAULT '',
			video VARCHAR(500) NOT NULL DEFAULT '',
			category VARCHAR(100) NOT NULL DEFAULT 'Общее',
			date DATETIME NOT NULL,
			date_modified DATETIME NOT NULL,
			read_time VARCHAR(20) NOT NULL DEFAULT '5 мин',
			author VARCHAR(255) NOT NULL DEFAULT 'Motor Land',
			author_bio TEXT NOT NULL,
			keywords VARCHAR(500) NOT NULL DEFAULT '',
			status VARCHAR(20) NOT NULL DEFAULT 'draft',
			UNIQUE KEY slug (slug)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
	}
	
	// Добавление статьи
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'blog_add') {
		if (empty($_REQUEST['blog_title']) || mb_strlen(trim($_REQUEST['blog_title'])) < 3) {
			$report['error'] = 2;
			$report['message'] = 'Заголовок должен содержать минимум 3 символа!';
		} else if (empty($_REQUEST['blog_slug']) || !hyst_test_val($_REQUEST['blog_slug'],REGEXP_NICKNAME)) {
			$report['error'] = 2;
			$report['message'] = 'URL должен содержать только латинские буквы, цифры, дефисы и подчеркивания!';
		} else if (empty($_REQUEST['blog_description'])) {
			$report['error'] = 2;
			$report['message'] = 'Описание не может быть пустым!';
		} else if (empty($_REQUEST['blog_content'])) {
			$report['error'] = 2;
			$report['message'] = 'Контент статьи не может быть пустым!';
		} else {
			// Проверяем уникальность slug
			$slug = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_slug']);
			$sql = $_DB_CONECT->query("SELECT id FROM blog_articles WHERE slug='".$slug."'");
			if (mysqli_num_rows($sql) != 0) {
				$report['error'] = 2;
				$report['message'] = 'Статья с таким URL уже существует!';
			} else {
				$title = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_title']);
				$description = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_description']);
				$content = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_content']);
				$image = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_image'] ?? '');
				$video = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_video'] ?? '');
				$category = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_category'] ?? 'Общее');
				$read_time = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_read_time'] ?? '5 мин');
				$author = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_author'] ?? 'Motor Land');
				$author_bio = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_author_bio'] ?? 'Эксперты компании Motor Land с более чем 10-летним опытом работы с контрактными двигателями.');
				$keywords = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_keywords'] ?? '');
				$status = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_status'] ?? 'draft');
				$date = date('Y-m-d H:i:s');
				
				$sql = $_DB_CONECT->query("INSERT INTO blog_articles (title,slug,description,content,image,video,category,date,date_modified,read_time,author,author_bio,keywords,status) VALUES ('".$title."','".$slug."','".$description."','".$content."','".$image."','".$video."','".$category."','".$date."','".$date."','".$read_time."','".$author."','".$author_bio."','".$keywords."','".$status."')");
				if ($sql != false) {
					$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
					$report['error'] = 1;
					$report['message'] = 'Статья добавлена';
				} else {
					$report['error'] = 2;
					$report['message'] = 'Ошибка базы данных!';
				}
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	// Редактирование статьи
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'blog_red') {
		if (!hyst_test_id($_REQUEST['blog_id'])) {
			$report['error'] = 2;
			$report['message'] = 'Неверный идентификатор!';
		} else if (empty($_REQUEST['blog_title']) || mb_strlen(trim($_REQUEST['blog_title'])) < 3) {
			$report['error'] = 2;
			$report['message'] = 'Заголовок должен содержать минимум 3 символа!';
		} else if (empty($_REQUEST['blog_slug']) || !hyst_test_val($_REQUEST['blog_slug'],REGEXP_NICKNAME)) {
			$report['error'] = 2;
			$report['message'] = 'URL должен содержать только латинские буквы, цифры, дефисы и подчеркивания!';
		} else if (empty($_REQUEST['blog_description'])) {
			$report['error'] = 2;
			$report['message'] = 'Описание не может быть пустым!';
		} else if (empty($_REQUEST['blog_content'])) {
			$report['error'] = 2;
			$report['message'] = 'Контент статьи не может быть пустым!';
		} else {
			$slug = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_slug']);
			// Проверяем уникальность slug (кроме текущей статьи)
			$sql = $_DB_CONECT->query("SELECT id FROM blog_articles WHERE slug='".$slug."' AND id!='".$_REQUEST['blog_id']."'");
			if (mysqli_num_rows($sql) != 0) {
				$report['error'] = 2;
				$report['message'] = 'Статья с таким URL уже существует!';
			} else {
				$title = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_title']);
				$description = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_description']);
				$content = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_content']);
				$image = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_image'] ?? '');
				$video = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_video'] ?? '');
				$category = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_category'] ?? 'Общее');
				$read_time = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_read_time'] ?? '5 мин');
				$author = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_author'] ?? 'Motor Land');
				$author_bio = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_author_bio'] ?? 'Эксперты компании Motor Land с более чем 10-летним опытом работы с контрактными двигателями.');
				$keywords = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_keywords'] ?? '');
				$status = mysqli_real_escape_string($_DB_CONECT, $_REQUEST['blog_status'] ?? 'draft');
				$date_modified = date('Y-m-d H:i:s');
				
				$sql = $_DB_CONECT->query("UPDATE blog_articles SET title='".$title."',slug='".$slug."',description='".$description."',content='".$content."',image='".$image."',video='".$video."',category='".$category."',date_modified='".$date_modified."',read_time='".$read_time."',author='".$author."',author_bio='".$author_bio."',keywords='".$keywords."',status='".$status."' WHERE id='".$_REQUEST['blog_id']."'");
				if ($sql != false) {
					$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
					$report['error'] = 3;
					$report['message'] = 'Статья обновлена';
					$report['visual_changes'] = array('#visual_ch_blog_'.$_REQUEST['blog_id'] => $title.' ['.$slug.']');
				} else {
					$report['error'] = 2;
					$report['message'] = 'Ошибка базы данных!';
				}
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
	
	// Удаление статьи
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'blog_del') {
		if (!hyst_test_id($_REQUEST['blog_id'])) {
			$report['error'] = 2;
			$report['message'] = 'Неверный идентификатор!';
		} else {
			$sql = $_DB_CONECT->query("DELETE FROM blog_articles WHERE id='".$_REQUEST['blog_id']."'");
			if ($sql != false) {
				$sql = $_DB_CONECT->query("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac='".time()."' WHERE id='".$_HYST_ADMIN['id']."'");
				$report['error'] = 3;
				$report['message'] = 'Статья удалена!';
				$report['delete_item'] = '.delet_blog_block'.$_REQUEST['blog_id'];
			} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных!';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
}
?>

