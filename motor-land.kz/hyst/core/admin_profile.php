<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/hyst/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/hyst/core/constants.php');
include($_SERVER['DOCUMENT_ROOT'].'/hyst/core/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/hyst/core/setups.php');


if ($_HYST_ADMIN_SETUP) {
	if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'primary_registration') {
		if (!hyst_test_val($_REQUEST['title'],REGEXP_NAME)) {
		$report['error'] = 2;
		$report['message'] = 'Название не корректно!';
		} else if (!hyst_test_val($_REQUEST['name'],REGEXP_NAME)) {
		$report['error'] = 2;
		$report['message'] = 'Имя не корректно!';
		} else if (!hyst_test_val($_REQUEST['email'],REGEXP_MAIL)) {
		$report['error'] = 2;
		$report['message'] = 'Адрес электронной почты не корректен!';
		} else if (!hyst_test_val($_REQUEST['password'],REGEXP_PASS)) {
		$report['error'] = 2;
		$report['message'] = 'Пароль не должен содержать недопустимые символы и быть не короче 6ти символов!';
		} else { 
			// Security: Используем prepared statements для защиты от SQL инъекций
			$title = $_REQUEST['title'];
			$name = $_REQUEST['name'];
			$email = mb_strtolower($_REQUEST['email']);
			$password_hash = hyst_hash_admin_password($_REQUEST['password']);
			$current_time = time();
			$role = 'general';
			
			$stmt = $_DB_CONECT->prepare("INSERT INTO ".AUT_NAME." (".AUC_PREFIX."_tip,".AUC_PREFIX."_name,".AUC_PREFIX."_mail,".AUC_PREFIX."_pass,".AUC_PREFIX."_laau,".AUC_PREFIX."_laac,".AUC_PREFIX."_role)
			VALUES (?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssiiis", $title, $name, $email, $password_hash, $current_time, $current_time, $role);
			
			if ($stmt->execute()) {
				$stmt->close();
				$report['error'] = 1;
				$report['message'] = '';
			} else {
				$stmt->close();
				$report['error'] = 2;
				$report['message'] = 'Ошибка базы данных';
			}
		}
		echo json_encode($report,JSON_UNESCAPED_UNICODE);
	}
} else {
	if (!$_HYST_ADMIN) {
		if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'login') { 
			if (!hyst_test_val($_REQUEST['email'],REGEXP_MAIL)) {
			$report['error'] = 2;
			$report['message'] = 'Не верный логин или пароль!';
			} else if (!hyst_test_val($_REQUEST['password'],REGEXP_PASS)) {
			$report['error'] = 2;
			$report['message'] = 'Не верный логин или пароль!';
			} else {
				// Security: Используем prepared statements для защиты от SQL инъекций
				$email = mb_strtolower($_REQUEST['email']);
				$stmt = $_DB_CONECT->prepare("SELECT id,".AUC_PREFIX."_pass FROM ".AUT_NAME." WHERE ".AUC_PREFIX."_mail = ?");
				$stmt->bind_param("s", $email);
				$stmt->execute();
				$check = $stmt->get_result();
				
				if ($check->num_rows != 0) {
					$data = $check->fetch_array();
					$stmt->close();
					
					// Security: Обновляем время последнего входа
					$admin_id = $data['id'];
					$update_time = time();
					$stmt = $_DB_CONECT->prepare("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laau = ? WHERE id = ?");
					$stmt->bind_param("ii", $update_time, $admin_id);
					$stmt->execute();
					$stmt->close();
					
					// Security: Используем безопасную проверку пароля
					if (hyst_verify_admin_password($_REQUEST['password'], $data[AUC_PREFIX.'_pass'])) {
						// Если использовался старый хеш, обновляем на новый
						$new_hash = hyst_hash_admin_password($_REQUEST['password']);
						$stmt = $_DB_CONECT->prepare("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_pass = ? WHERE id = ?");
						$stmt->bind_param("si", $new_hash, $admin_id);
						$stmt->execute();
						$stmt->close();
						
						$_SESSION[AUSK_LOGIN] = $_REQUEST['email'];
						// Не сохраняем пароль в сессии, только проверяем хеш
						$_SESSION[AUSK_PASSW] = $new_hash;
						$report['error'] = 1;
						$report['message'] = '';
					} else { 
						$report['error'] = 2;
						$report['message'] = 'Не верный логин или пароль!';
					}
				} else {
					$stmt->close();
					$report['error'] = 2;
					$report['message'] = 'Пользователь с таким email не существует!';
				}
			}
			echo json_encode($report,JSON_UNESCAPED_UNICODE);
		}
	} else {
		if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'change_admin_data') { 
			if ($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all') {
				if (!hyst_test_val($_REQUEST['title'],REGEXP_NAME)) {
				$report['error'] = 2;
				$report['message'] = 'Название не корректно!';
				} else if (!hyst_test_val($_REQUEST['name'],REGEXP_NAME)) {
				$report['error'] = 2;
				$report['message'] = 'Имя не корректно!';
				} else if (!hyst_test_val($_REQUEST['email'],REGEXP_MAIL)) {
				$report['error'] = 2;
				$report['message'] = 'Адрес электронной почты не корректен!';
				} else { 
					// Security: Используем prepared statements для защиты от SQL инъекций
					$admin_id = $_HYST_ADMIN['id'];
					$title = $_REQUEST['title'];
					$name = $_REQUEST['name'];
					$email = mb_strtolower($_REQUEST['email']);
					$update_time = time();
					
					$stmt = $_DB_CONECT->prepare("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_tip = ?, ".AUC_PREFIX."_name = ?, ".AUC_PREFIX."_mail = ?, ".AUC_PREFIX."_laau = ? WHERE id = ?");
					$stmt->bind_param("sssii", $title, $name, $email, $update_time, $admin_id);
					
					if ($stmt->execute()) {
						$stmt->close();
						$report['error'] = 3;
						$report['message'] = 'Изменения сохранены';
						$report['visual_changes'] = array ('.admin_header_name'=>$_REQUEST['name']);
					} else {
						$stmt->close();
						$report['error'] = 2;
						$report['message'] = 'Ошибка базы данных';
					}
				}
			} else {
				if (!hyst_test_val($_REQUEST['email'],REGEXP_MAIL)) {
				$report['error'] = 2;
				$report['message'] = 'Адрес электронной почты не корректен!';
				} else { 
					// Security: Используем prepared statements для защиты от SQL инъекций
					$admin_id = $_HYST_ADMIN['id'];
					$email = mb_strtolower($_REQUEST['email']);
					$update_time = time();
					
					$stmt = $_DB_CONECT->prepare("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_mail = ?, ".AUC_PREFIX."_laau = ? WHERE id = ?");
					$stmt->bind_param("sii", $email, $update_time, $admin_id);
					
					if ($stmt->execute()) {
						$stmt->close();
						$_SESSION[AUSK_LOGIN] = $email;
						$report['error'] = 3;
						$report['message'] = 'Изменения сохранены';
					} else {
						$stmt->close();
						$report['error'] = 2;
						$report['message'] = 'Ошибка базы данных';
					}
				}
			}
			echo json_encode($report,JSON_UNESCAPED_UNICODE);
		}
		
		if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'change_admin_password') { 
			if (!hyst_test_val($_REQUEST['password'],REGEXP_PASS)) {
			$report['error'] = 2;
			$report['message'] = 'Пароль не корректен!';
			} else { 
				// Security: Используем prepared statements для защиты от SQL инъекций
				$admin_id = $_HYST_ADMIN['id'];
				$password_hash = hyst_hash_admin_password($_REQUEST['password']);
				$update_time = time();
				
				$stmt = $_DB_CONECT->prepare("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_pass = ?, ".AUC_PREFIX."_laau = ? WHERE id = ?");
				$stmt->bind_param("sii", $password_hash, $update_time, $admin_id);
				
				if ($stmt->execute()) {
					$stmt->close();
					$_SESSION[AUSK_PASSW] = $password_hash;
					$report['error'] = 3;
					$report['message'] = 'Изменения сохранены';
				} else {
					$stmt->close();
					$report['error'] = 2;
					$report['message'] = 'Ошибка базы данных';
				}
			}
			echo json_encode($report,JSON_UNESCAPED_UNICODE);
		}
		
		
		if (($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all') && isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'add_moderator') { 
			if (!hyst_test_val($_REQUEST['title'],REGEXP_NAME)) {
			$report['error'] = 2;
			$report['message'] = 'Название не корректно!';
			} else if (!hyst_test_val($_REQUEST['name'],REGEXP_NAME)) {
			$report['error'] = 2;
			$report['message'] = 'Имя не корректно!';
			} else if (!hyst_test_val($_REQUEST['email'],REGEXP_MAIL)) {
			$report['error'] = 2;
			$report['message'] = 'Адрес электронной почты не корректен!';
			} else if (!hyst_test_val($_REQUEST['password'],REGEXP_PASS)) {
			$report['error'] = 2;
			$report['message'] = 'Пароль не должен содержать недопустимые символы и быть не короче 6ти символов!';
			} else if (empty($_REQUEST['moderator_role']) || $_REQUEST['moderator_role'] == '') {
			$report['error'] = 2;
			$report['message'] = 'Нужно выбрать хотя бы одну роль!';
			} else { 
				// Security: Используем prepared statements для защиты от SQL инъекций
				$email = mb_strtolower($_REQUEST['email']);
				$stmt = $_DB_CONECT->prepare("SELECT id FROM ".AUT_NAME." WHERE ".AUC_PREFIX."_mail = ?");
				$stmt->bind_param("s", $email);
				$stmt->execute();
				$result = $stmt->get_result();
				
				if ($result->num_rows != 0) {
					$stmt->close();
					$report['error'] = 2;
					$report['message'] = 'Пользователь с такой почтой уже зарегистрирован!';
				} else {
					$stmt->close();
					
					$title = $_REQUEST['title'];
					$name = $_REQUEST['name'];
					$password_hash = hyst_hash_admin_password($_REQUEST['password']);
					$role = $_REQUEST['moderator_role'];
					$not_logged = 'Не входил';
					
					$stmt = $_DB_CONECT->prepare("INSERT INTO ".AUT_NAME." (".AUC_PREFIX."_tip,".AUC_PREFIX."_name,".AUC_PREFIX."_mail,".AUC_PREFIX."_pass,".AUC_PREFIX."_laau,".AUC_PREFIX."_laac,".AUC_PREFIX."_role)
					VALUES (?, ?, ?, ?, ?, ?, ?)");
					$stmt->bind_param("sssssss", $title, $name, $email, $password_hash, $not_logged, $not_logged, $role);
					$sql = $stmt->execute();
					if ($sql != false) {
						$stmt->close();
						
						// Обновляем время активности администратора
						$admin_id = $_HYST_ADMIN['id'];
						$update_time = time();
						$stmt = $_DB_CONECT->prepare("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac = ? WHERE id = ?");
						$stmt->bind_param("ii", $update_time, $admin_id);
						$stmt->execute();
						$stmt->close();
						
						// Получаем ID нового модератора
						$stmt = $_DB_CONECT->prepare("SELECT id FROM ".AUT_NAME." WHERE ".AUC_PREFIX."_mail = ? LIMIT 1");
						$stmt->bind_param("s", $email);
						$stmt->execute();
						$result = $stmt->get_result();
						$data = $result->fetch_array();
						$stmt->close();
						
						$html_roles = '';
						$mods_foldres = scandir($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/');
						array_splice($mods_foldres, 0, 2);
						for ($q = 0; $q < count($mods_foldres); $q++) {
							if (file_exists($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/'.$mods_foldres[$q].'/info.ini') && $module_info = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/'.$mods_foldres[$q].'/info.ini')) {
							$module_name = $module_info['name'];
							} else {
							$module_name = $mods_foldres[$q];
							}
						$html_roles .= '<label class="admin_label_checkbox">'.$module_name.' <input type="checkbox" data-rms="secondary" value="'.$mods_foldres[$q].'"'.(array_search($mods_foldres[$q],explode(',',$_REQUEST['moderator_role']))!==false?' checked':'').'></label>';	
						}
						
					$report['error'] = 3;
					$report['message'] = 'Учетная запись успешно добавлена';
					$report['clear'] = '';
					$report['inserted_html'] = array('.admin_moderators_table'=>'<div class="admin_inline_ittem deleted_item'.$data['id'].'">
						<div class="w50">#'.$data['id'].'</div>
						<div class="w200" id="moderator_info_title'.$data['id'].'">'.$_REQUEST['title'].'</div>
						<div class="w200" id="moderator_info_name'.$data['id'].'">('.$_REQUEST['name'].')</div>
						<div class="w250" id="moderator_info_email'.$data['id'].'"><u>'.$_REQUEST['email'].'</u></div>
						<div class="w150">
							<sup>последний вход</sup>
							<indicateddate class="thre">Не входил</indicateddate>
						</div>
						
						<div class="w150">
							<sup>был активен</sup>
							<indicateddate class="thre">Не входил</indicateddate>
						</div>

						<interfaceform target="hyst/core/admin_profile">
							<input type="hidden" name="id" value="'.$data['id'].'">
							<input type="button" role="submit" confirm-prompt="Введите слово \'Удалить\' для подтверждения" name="delet_moderator" value="Удалить">
						</interfaceform>
						
						<div class="admin_roller_menu">
							<input type="checkbox" id="moderator_roller'.$data['id'].'">
							<label for="moderator_roller'.$data['id'].'"><img src="/hyst/visual/images/gear_icon.svg" height="14"></label>
							<div class="admin_roller_container">
								<interfaceform target="hyst/core/admin_profile">
									<div class="form_title">Изменить учетные денные</div>
									
									<div class="admin_content_alignment">
										<div class="admin_content_widht300">
											<label>Название пользователя<i>*</i><br><iw><input value="'.$_REQUEST['title'].'" class="width100" error="Название содержит не корректные символы!" type="text" name="title" check="name" length=">2" mandatory></iw></label>
										</div>
										<div class="admin_content_widht300">
											<label>Имя<i>*</i><br><iw><input value="'.$_REQUEST['name'].'" class="width100" error="Имя содержит не корректные символы!" type="text" name="name" check="name" length=">2" mandatory></iw></label>
										</div>
										<div class="admin_content_widht300">
											<label>Email<i>*</i><br><iw><input value="'.$_REQUEST['email'].'" class="width100" error="Email не корректен!" type="text" name="email" check="email" mandatory></iw></label>
										</div>
										<div class="width100 admin_group_checkboxes hust_general_user_roles" name="moderator_role" mandatory>
											<div class="admin_group_checkboxes_title">Привилегии пользователя<i>*</i></div>
											
											<label class="admin_label_checkbox">Полный доступ <input type="checkbox" data-rms="primary" value="all"'.($_REQUEST['moderator_role']=='all'?' checked':'').'></label>
											<label class="admin_label_checkbox">Медиафайлы <input type="checkbox" data-rms="secondary" value="mediafiles"'.(array_search('mediafiles',explode(',',$_REQUEST['moderator_role']))!==false?' checked':'').'></label>
											'.$html_roles.'
										</div>
										<input type="hidden" name="id" value="'.$data['id'].'">
										<div class="admin_content_widht300">
											<input class="width100" type="button" role="submit" name="change_moderator_data" value="Изменить">
										</div>
									</div>
								</interfaceform>
								
								<interfaceform target="hyst/core/admin_profile">	
									<div class="form_title">Сменить пароль</div>
									<div class="admin_content_alignment">
										<div class="admin_content_widht300">
											<label>Пароль<i>*</i><br><iw><input class="width100" error="Пароль может состоять только из символов A-zA-z0-9 -_#@$%^&* и быть не короче 6ти символов!" type="password" name="password" check="password" mandatory></iw></label>
										</div>
										<div class="admin_content_widht300">					
											<label>Повторите пароль<i>*</i><br><iw><input class="width100" error="Пароли не совпадают!" type="password" mirror="password" check="mirror" mandatory></iw></label>
										</div>
										<input type="hidden" name="id" value="'.$data['id'].'">
										<div class="admin_content_widht300">
											<input class="width100" type="button" role="submit" name="change_moderator_password" value="Сохранить">
										</div>
									</div>
								</interfaceform>
							</div>
						</div>
					</div>');
					} else {
					$report['error'] = 2;
					$report['message'] = 'Ошибка базы данных';
					}
				}
			}
			echo json_encode($report,JSON_UNESCAPED_UNICODE);
		}
		
		if (($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all') && isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'change_moderator_data') { 
			if (!hyst_test_val($_REQUEST['title'],REGEXP_NAME)) {
			$report['error'] = 2;
			$report['message'] = 'Название не корректно!';
			} else if (!hyst_test_val($_REQUEST['name'],REGEXP_NAME)) {
			$report['error'] = 2;
			$report['message'] = 'Имя не корректно!';
			} else if (!hyst_test_val($_REQUEST['email'],REGEXP_MAIL)) {
			$report['error'] = 2;
			$report['message'] = 'Адрес электронной почты не корректен!';
			} else if (!hyst_test_id ($_REQUEST['id'])) {
			$report['error'] = 2;
			$report['message'] = 'Не корректный идентификатор!';
			} else if (empty($_REQUEST['moderator_role']) || $_REQUEST['moderator_role'] == '') {
			$report['error'] = 2;
			$report['message'] = 'Нужно выбрать хотя бы одну роль!';
				} else { 
					// Security: Используем prepared statements для защиты от SQL инъекций
					$email = mb_strtolower($_REQUEST['email']);
					$moderator_id = (int)$_REQUEST['id'];
					
					$stmt = $_DB_CONECT->prepare("SELECT id FROM ".AUT_NAME." WHERE ".AUC_PREFIX."_mail = ? AND id != ?");
					$stmt->bind_param("si", $email, $moderator_id);
					$stmt->execute();
					$result = $stmt->get_result();
					
					if ($result->num_rows != 0) {
						$stmt->close();
						$report['error'] = 2;
						$report['message'] = 'Пользователь с такой почтой уже присутствует в системе!';
					} else {
						$stmt->close();
						
						$title = $_REQUEST['title'];
						$name = $_REQUEST['name'];
						$role = $_REQUEST['moderator_role'];
						
						$stmt = $_DB_CONECT->prepare("UPDATE ".AUT_NAME." SET 
						".AUC_PREFIX."_tip = ?, ".AUC_PREFIX."_name = ?, ".AUC_PREFIX."_mail = ?, ".AUC_PREFIX."_role = ?
						WHERE id = ? AND ".AUC_PREFIX."_role != 'general'");
						$stmt->bind_param("ssssi", $title, $name, $email, $role, $moderator_id);
						$sql = $stmt->execute();
					if ($sql != false) {
						$stmt->close();
						
						// Обновляем время активности администратора
						$admin_id = $_HYST_ADMIN['id'];
						$update_time = time();
						$stmt = $_DB_CONECT->prepare("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac = ? WHERE id = ?");
						$stmt->bind_param("ii", $update_time, $admin_id);
						$stmt->execute();
						$stmt->close();
						
						$report['error'] = 3;
						$report['message'] = 'Учетная запись успешно изменена';
						$report['visual_changes'] = array ('#moderator_info_title'.$_REQUEST['id']=>$_REQUEST['title'],
						'#moderator_info_name'.$_REQUEST['id']=>$_REQUEST['name'],
						'#moderator_info_email'.$_REQUEST['id']=>$_REQUEST['email']);
					} else {
						$stmt->close();
						$report['error'] = 2;
						$report['message'] = 'Ошибка базы данных';
					}
				}
			}
			echo json_encode($report,JSON_UNESCAPED_UNICODE);
		}
		
		if (($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all') && isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'change_moderator_password') { 
			if (!hyst_test_val($_REQUEST['password'],REGEXP_PASS)) {
			$report['error'] = 2;
			$report['message'] = 'Пароль не корректен!';
			} else if (!hyst_test_id ($_REQUEST['id'])) {
			$report['error'] = 2;
			$report['message'] = 'Не корректный идентификатор!';
			} else { 
				// Security: Используем prepared statements для защиты от SQL инъекций
				$moderator_id = (int)$_REQUEST['id'];
				$password_hash = hyst_hash_admin_password($_REQUEST['password']);
				
				$stmt = $_DB_CONECT->prepare("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_pass = ?
				WHERE id = ? AND ".AUC_PREFIX."_role != 'general'");
				$stmt->bind_param("si", $password_hash, $moderator_id);
				
				if ($stmt->execute()) {
					$stmt->close();
					
					// Обновляем время активности администратора
					$admin_id = $_HYST_ADMIN['id'];
					$update_time = time();
					$stmt = $_DB_CONECT->prepare("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac = ? WHERE id = ?");
					$stmt->bind_param("ii", $update_time, $admin_id);
					$stmt->execute();
					$stmt->close();
					
					$report['error'] = 3;
					$report['message'] = 'Изменения сохранены';
				} else {
					$stmt->close();
					$report['error'] = 2;
					$report['message'] = 'Ошибка базы данных';
				}
			}
			echo json_encode($report,JSON_UNESCAPED_UNICODE);
		}
		
		if (($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all') && isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'delet_moderator') { 
			if (!hyst_test_id ($_REQUEST['id'])) {
			$report['error'] = 2;
			$report['message'] = 'Не корректный идентификатор!';
			} else { 
				// Security: Используем prepared statements для защиты от SQL инъекций
				$moderator_id = (int)$_REQUEST['id'];
				
				$stmt = $_DB_CONECT->prepare("DELETE FROM ".AUT_NAME." WHERE id = ? AND ".AUC_PREFIX."_role != 'general'");
				$stmt->bind_param("i", $moderator_id);
				
				if ($stmt->execute()) {
					$stmt->close();
					
					// Обновляем время активности администратора
					$admin_id = $_HYST_ADMIN['id'];
					$update_time = time();
					$stmt = $_DB_CONECT->prepare("UPDATE ".AUT_NAME." SET ".AUC_PREFIX."_laac = ? WHERE id = ?");
					$stmt->bind_param("ii", $update_time, $admin_id);
					$stmt->execute();
					$stmt->close();
					
					$report['error'] = 3;
					$report['message'] = 'Данные удалены';
					$report['delete_item'] = '.deleted_item'.$_REQUEST['id'];
				} else {
					$stmt->close();
					$report['error'] = 2;
					$report['message'] = 'Ошибка базы данных';
				}
			}
			echo json_encode($report,JSON_UNESCAPED_UNICODE);
		}
		
		if (($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all'  || array_search('mediafiles',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false) && isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'add_image') { 
			if (empty($_FILES['image']['name']) ||  @sizeof($_FILES['image']['name']) == 0) {
			$report['error'] = 2;
			$report['message'] = 'Нужно выбрать изображение в формате jpg,png,gif,svg или webp!';
			} else { 
				$new_folder = false;
				$date_folder = date('Y-m');
				if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/cms_img/'.$date_folder)) {
					mkdir($_SERVER['DOCUMENT_ROOT'].'/cms_img/'.$date_folder, 0777, true);
					$new_folder = $date_folder;
				}
				
				$tech_path = $_SERVER['DOCUMENT_ROOT'].'/cms_img/'.$date_folder;
				$width = (hyst_test_id($_REQUEST['width'])?$_REQUEST['width']:2000);
				$height = (hyst_test_id($_REQUEST['height'])?$_REQUEST['height']:2000);
				$resize = hyst_img_resize($_FILES['image'], $tech_path,$width,$height);
				if (hyst_test_id($_REQUEST['width'])) { $_SESSION['mediafiles_width'] = $_REQUEST['width']; }
				if (hyst_test_id($_REQUEST['height'])) { $_SESSION['mediafiles_height'] = $_REQUEST['height']; }
				if ($resize) {
					$meta = [];
					if (isset($_REQUEST['title']) && $_REQUEST['title'] != '') { $meta['title'] = $_REQUEST['title']; }
					if (isset($_REQUEST['alt']) && $_REQUEST['alt'] != '') { $meta['alt'] = $_REQUEST['alt']; }
					if (isset($_REQUEST['tags']) && $_REQUEST['tags'] != '') { $meta['tags'] = $_REQUEST['tags']; }
					if (count($meta) !== 0) {
						$add_meta = hyst_setmeta($_SERVER['DOCUMENT_ROOT'].$resize,$meta);
		
						if ($add_meta) {
						$report['error'] = 3;
						$report['message'] = 'Изображение загружено';
						$report['clear'] = '';
						} else {
						$report['error'] = 3;
						$report['message'] = 'Изображение загружено. Но метаинформация не добавленна из-за ошибки!!!';
						$report['clear'] = '';
						}
					} else {
					$report['error'] = 3;
					$report['message'] = 'Изображение загружено';
					$report['clear'] = '';
					}
						if (isset($_REQUEST['addnow'])) {
						$img_html = '<div class="mediafiles_image_con_img" onclick="hyst_setup_image(\''.$resize.'\',\''.$_REQUEST['unic'].'\');"" style="background-image: url('.$resize.');"></div>';
						} else {
						$img_html = '<div class="hyst_zoom_img mediafiles_image_con_img" data-zoom="'.$resize.'" data-width="'.$width.'" data-height="'.$height.'" style="background-image: url('.$resize.');"></div>';
						}
					if ($new_folder) {
						
						$report['inserted_html'] = array('.admin_mediafiles_general_con'=>'<div class="admin_roller_menu admin_roller100">
							<input type="checkbox" id="moderator_roller'.$new_folder.'" checked>
							<label for="moderator_roller'.$new_folder.'">'.$new_folder.'</label>
							<div class="admin_roller_container admin_roler_with_overflow img_folder_apend_'.$new_folder.'">
								<div tags="'.((isset($_REQUEST['tags']) && $_REQUEST['tags'] != '')?$_REQUEST['tags']:'N/A').'" class="mediafiles_image_con del_image_'.$date_folder.'_'.(explode('.',explode('/',str_replace('/cms_img/','',$resize))[1])[0]).'">
									<interfaceform target="hyst/core/admin_profile">
										<input type="hidden" name="url" value="'.$resize.'">
										<input confirm-yesno="Вы действительно хотите удалить картинку?" class="admin_delet_img" type="button" role="submit" name="del_image" value=" ">
									</interfaceform>
									'.$img_html.'
								</div>
							</div>
						</div>');
					} else {
					$report['inserted_html'] = array('.img_folder_apend_'.$date_folder=>'<div tags="'.((isset($_REQUEST['tags']) && $_REQUEST['tags'] != '')?$_REQUEST['tags']:'N/A').'" class="mediafiles_image_con del_image_'.$date_folder.'_'.(explode('.',explode('/',str_replace('/cms_img/','',$resize))[1])[0]).'">
						<interfaceform target="hyst/core/admin_profile">
							<input type="hidden" name="url" value="'.$resize.'">
							<input confirm-yesno="Вы действительно хотите удалить картинку?" class="admin_delet_img" type="button" role="submit" name="del_image" value=" ">
						</interfaceform>
						'.$img_html.'
					</div>');
					}
				} else {
				$report['error'] = 2;
				$report['message'] = 'Не удается загрузить изображение!';
				}
			}
			echo json_encode($report,JSON_UNESCAPED_UNICODE);
		}
		
		if (($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all'  || array_search('mediafiles',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false) && isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'del_image') { 
			if (empty($_REQUEST['url'])) {
			$report['error'] = 2;
			$report['message'] = 'Путь к изобрежению не найден!';
			} else { 
				if (unlink($_SERVER['DOCUMENT_ROOT'].$_REQUEST['url'])) {
				$report['error'] = 3;
				$report['message'] = 'Изображение удалено';
				$delclass = explode('/',str_replace('/cms_img/','',$_REQUEST['url']));
				$report['delete_item'] = '.del_image_'.$delclass[0].'_'.explode('.',$delclass[1])[0];
				} else {
				$report['error'] = 2;
				$report['message'] = 'Ошибка удаления!';
				}
			}
			echo json_encode($report,JSON_UNESCAPED_UNICODE);
		}
		
		if (isset($_REQUEST['comand']) && $_REQUEST['comand'] == 'get_mediafiles_modal') {
			
			if ($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all'  || array_search('mediafiles',explode(',',$_HYST_ADMIN[AUC_PREFIX.'_role']))!==false) {
			
			$html = '<interfaceform target="hyst/core/admin_profile">
				<div class="form_title">Добавить изображение</div>
				
				<div class="admin_content_alignment">
					<div class="admin_imgblock">
						<div class="admin_content_widht300">
							<iw class="admin_file_label_wraper">
								<label class="admin_image_label" data-allowed="jpg,jpeg,png,svg,webp" data-tip="Добавить изображение">
									<input type="file" error="Нужно выбрать изображение формата jpg,jpeg,png,svg или webp!" check="file" name="image" mandatory>
									<div class="admin_addimage_tip">+<span>Добавить изображение</span></div>
								</label>
							</iw>
						</div>
					</div>
					<div class="admin_content_alignment_remain">
						<div class="admin_content_widht300">
							<label>Сжатие длины изображения (px)<i>*</i><br><iw><input value="'.(isset($_SESSION['mediafiles_width'])?$_SESSION['mediafiles_width']:'1920').'" class="width100" error="Нужно вводить целое число!" type="text" name="width" check="number" length=">2" unclear mandatory></iw></label>
						</div>
						<div class="admin_content_widht300">
							<label>Сжатие ширины изображения (px)<i>*</i><br><iw><input value="'.(isset($_SESSION['mediafiles_height'])?$_SESSION['mediafiles_height']:'1080').'" class="width100" error="Нужно вводить целое число!" type="text" name="height" check="number" length=">2" unclear mandatory></iw></label>
						</div>
						<div class="admin_content_widht300">
							<label>Title (для SEO)<br><iw><input class="width100" error="Содержит не корректные символы!" type="text" name="title" check="name"></iw></label>
						</div>
						<div class="admin_content_widht300">
							<label>Alt (для SEO)<br><iw><input class="width100" error="Содержит не корректные символы!" type="text" name="alt" check="name"></iw></label>
						</div>
						<div class="admin_content_widht300">
							<label>Тэги для поиска<br><iw><input class="width100" error="Содержит не корректные символы!" type="text" name="tags" check="name"></iw></label>
						</div>
						<input type="hidden" name="addnow" value="true" unclear>
						<input type="hidden" name="unic" value="'.$_REQUEST['unic'].'" unclear>
						<div class="admin_content_widht300">
							<input class="width100" type="button" role="submit" name="add_image" value="Добавить">
						</div>
					</div>
				</div>
			</interfaceform>';
			
			}
			
			$html .= '<div class="admin_mediafiles_general_con">';
			
			$year_mt_folders = scandir($_SERVER['DOCUMENT_ROOT'].'/cms_img/');
			array_splice($year_mt_folders, 0, 2);
			arsort($year_mt_folders);
			$count = 0;
			foreach($year_mt_folders as $folder) {
				$images = scandir($_SERVER['DOCUMENT_ROOT'].'/cms_img/'.$folder);
				array_splice($images, 0, 2);
				if (count($images) > 0) {
					
			$html .= '<div class="admin_roller_menu admin_roller100">
						<input type="checkbox" id="moderator_roller'.$folder.'"'.($count==0?' checked':'').'>
						<label for="moderator_roller'.$folder.'">'.$folder.'</label>
						<div class="admin_roller_container admin_roler_with_overflow img_folder_apend_'.$folder.'">';
					
					foreach($images as $image) {
					$tags = hyst_imeta($_SERVER['DOCUMENT_ROOT'].'/cms_img/'.$folder.'/'.$image);
						if ($tags && !is_null($tags['tags'])) {
						$tags = $tags['tags'];
						} else {
						$tags = 'N/A';
						}
			$html .= '<div tags="'.$tags.'" class="mediafiles_image_con del_image_'.$folder.'_'.explode('.',$image)[0].'">
					<interfaceform target="hyst/core/admin_profile">
						<input type="hidden" name="url" value="/cms_img/'.$folder.'/'.$image.'">
						<input confirm-yesno="Вы действительно хотите удалить картинку?" class="admin_delet_img" type="button" role="submit" name="del_image" value=" ">
					</interfaceform>
					<div onclick="hyst_setup_image(\'/cms_img/'.$folder.'/'.$image.'\',\''.$_REQUEST['unic'].'\');" class="mediafiles_image_con_img" style="background-image: url(/cms_img/'.$folder.'/'.$image.');"></div>
					
				</div>';
					
					
					}
					
			$html .= '</div>
					</div>';	
					
				}
				if ($count == 0) { $count++; }
			}
			$html .= '</div>';
			echo $html;
		}
	}
}

?>