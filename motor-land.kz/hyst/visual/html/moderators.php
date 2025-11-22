<div class="admin_page_header">
	<div class="admin_page_header_breadcrumb">
		<a href="/adm">Главная</a>
		<span>›</span>
		<span class="current">Модераторы</span>
	</div>
	<div class="admin_page_title">👥 Административные учетные записи</div>
	<div class="admin_page_subtitle">Управление пользователями и их правами доступа</div>
</div>

<div class="admin_roller_menu">
	<input type="checkbox" id="moderator_roller">
	<label for="moderator_roller">+</label>
	<div class="admin_roller_container">
		<interfaceform target="hyst/core/admin_profile">
			<div class="form_title">Добавить нового пользователя</div>
			
			<div class="admin_content_alignment">
				<div class="admin_content_widht300">
					<label>Название пользователя<i>*</i><br><iw><input class="width100" error="Название содержит не корректные символы!" type="text" name="title" check="name" length=">2" mandatory></iw></label>
				</div>
				<div class="admin_content_widht300">
					<label>Имя<i>*</i><br><iw><input class="width100" error="Имя содержит не корректные символы!" type="text" name="name" check="name" length=">2" mandatory></iw></label>
				</div>
				<div class="admin_content_widht300">
					<label>Email<i>*</i><br><iw><input class="width100" error="Email не корректен!" type="text" name="email" check="email" mandatory></iw></label>
				</div>
				<div class="admin_content_widht300">
					<label>Пароль<i>*</i><br><iw><input class="width100" error="Пароль может состоять только из символов A-zA-z0-9 -_#@$%^&* и быть не короче 6ти символов!" type="password" name="password" check="password" mandatory></iw></label>
				</div>
				<div class="admin_content_widht300">
					<label>Повторите пароль<i>*</i><br><iw><input class="width100" error="Пароли не совпадают!" type="password" mirror="password" check="mirror" mandatory></iw></label>
				</div>
				<div class="width100 admin_group_checkboxes hust_general_user_roles" name="moderator_role" mandatory>
					<div class="admin_group_checkboxes_title">Привилегии пользователя<i>*</i></div>
					
					<label class="admin_label_checkbox">Полный доступ <input type="checkbox" data-rms="primary" value="all"></label>
					<label class="admin_label_checkbox">Медиафайлы <input type="checkbox" data-rms="secondary" value="mediafiles"></label>
					<?php
					$mods_folders = scandir($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/');
					array_splice($mods_folders, 0, 2);
					$hidden_modules = array('seo_queries', 'page_content');
					for ($q = 0; $q < count($mods_folders); $q++) {
						if (!in_array($mods_folders[$q], $hidden_modules)) {
							if (file_exists($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/'.$mods_folders[$q].'/info.ini') && $module_info = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/'.$mods_folders[$q].'/info.ini')) {
							$module_name = $module_info['name'];
							} else {
							$module_name = $mods_folders[$q];
							}
						?>
						<label class="admin_label_checkbox"><?=$module_name;?> <input type="checkbox" data-rms="secondary" value="<?=$mods_folders[$q];?>"></label>
						<?php
						}
					}
					?>
				</div>
				<div class="admin_content_widht300">
					<input class="width100" type="button" role="submit" name="add_moderator" value="Добавить">
				</div>
			</div>
		</interfaceform>
	</div>
</div>

<sp class="admin_separator"></sp>
<div class="admin_moderators_table">
<?php
$sql = $_DB_CONECT->query("SELECT * FROM ".AUT_NAME." WHERE id!='".$_HYST_ADMIN['id']."' AND ".AUC_PREFIX."_role!='general' ORDER BY id DESC");
if ($sql->num_rows != 0) {
?>

<?php
	while($record=$sql->fetch_array()):
?>
<div class="admin_inline_ittem deleted_item<?=$record['id'];?>">
	<div class="w50">#<?=$record['id'];?></div>
	<div class="w200" id="moderator_info_title<?=$record['id'];?>"><?=$record[AUC_PREFIX.'_tip'];?></div>
	<div class="w200" id="moderator_info_name<?=$record['id'];?>">(<?=$record[AUC_PREFIX.'_name'];?>)</div>
	<div class="w250" id="moderator_info_email<?=$record['id'];?>"><u><?=$record[AUC_PREFIX.'_mail'];?></u></div>
	<div class="w150">
		<sup>последний вход</sup>
		<?php
		if ($record[AUC_PREFIX.'_laau'] == 'Не входил') { $цвет = 'thre'; } 
		else if ($record[AUC_PREFIX.'_laau'] > (time()-3600)) { $цвет = 'now'; } 
		else if ($record[AUC_PREFIX.'_laau'] > (time()-10800)) { $цвет = 'recently'; } 
		else if ($record[AUC_PREFIX.'_laau'] > (time()-43200)) { $цвет = 'half'; } 
		else if ($record[AUC_PREFIX.'_laau'] > (time()-86400)) { $цвет = 'day'; } 
		else if ($record[AUC_PREFIX.'_laau'] > (time()-259200)) { $цвет = 'thre'; } 
		else if ($record[AUC_PREFIX.'_laau'] > (time()-604800)) { $цвет = 'week'; } 
		else { $цвет = 'month'; } 
		?>
		<indicateddate class="<?=$цвет;?>"><?=$record[AUC_PREFIX.'_laau']!='Не входил'?date('H:i:s d.m.Y',$record[AUC_PREFIX.'_laau']):$record[AUC_PREFIX.'_laau'];?></indicateddate>
	</div>
	
	<div class="w150">
		<sup>был активен</sup>
		<?php
		if ($record[AUC_PREFIX.'_laac'] == 'Не входил') { $цвет = 'thre'; } 
		else if ($record[AUC_PREFIX.'_laac'] > (time()-3600)) { $цвет = 'now'; } 
		else if ($record[AUC_PREFIX.'_laac'] > (time()-10800)) { $цвет = 'recently'; } 
		else if ($record[AUC_PREFIX.'_laac'] > (time()-43200)) { $цвет = 'half'; } 
		else if ($record[AUC_PREFIX.'_laac'] > (time()-86400)) { $цвет = 'day'; } 
		else if ($record[AUC_PREFIX.'_laac'] > (time()-259200)) { $цвет = 'thre'; } 
		else if ($record[AUC_PREFIX.'_laac'] > (time()-604800)) { $цвет = 'week'; } 
		else { $цвет = 'month'; } 
		?>
		<indicateddate class="<?=$цвет;?>"><?=$record[AUC_PREFIX.'_laac']!='Не входил'?date('H:i:s d.m.Y',$record[AUC_PREFIX.'_laac']):$record[AUC_PREFIX.'_laac'];?></indicateddate>
	</div>

	<interfaceform target="hyst/core/admin_profile">
		<input type="hidden" name="id" value="<?=$record['id'];?>">
		<input type="button" role="submit" confirm-prompt="Введите слово 'Удалить' для подтверждения" name="delet_moderator" value="Удалить">
	</interfaceform>
	
	<div class="admin_roller_menu">
		<input type="checkbox" id="moderator_roller<?=$record['id'];?>">
		<label for="moderator_roller<?=$record['id'];?>"><img src="/hyst/visual/images/gear_icon.svg" height="14"></label>
		<div class="admin_roller_container">
			<interfaceform target="hyst/core/admin_profile">
				<div class="form_title">Изменить учетные денные</div>
				
				<div class="admin_content_alignment">
					<div class="admin_content_widht300">
						<label>Название пользователя<i>*</i><br><iw><input value="<?=$record[AUC_PREFIX.'_tip'];?>" class="width100" error="Название содержит не корректные символы!" type="text" name="title" check="name" length=">2" mandatory></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label>Имя<i>*</i><br><iw><input value="<?=$record[AUC_PREFIX.'_name'];?>" class="width100" error="Имя содержит не корректные символы!" type="text" name="name" check="name" length=">2" mandatory></iw></label>
					</div>
					<div class="admin_content_widht300">
						<label>Email<i>*</i><br><iw><input value="<?=$record[AUC_PREFIX.'_mail'];?>" class="width100" error="Email не корректен!" type="text" name="email" check="email" mandatory></iw></label>
					</div>
					<div class="width100 admin_group_checkboxes hust_general_user_roles" name="moderator_role" mandatory>
						<div class="admin_group_checkboxes_title">Привилегии пользователя<i>*</i></div>
						
						<label class="admin_label_checkbox">Полный доступ <input type="checkbox" data-rms="primary" value="all"<?=($record[AUC_PREFIX.'_role']=='general'||$record[AUC_PREFIX.'_role']=='all'?' checked':'');?>></label>
						<label class="admin_label_checkbox">Медиафайлы <input type="checkbox" data-rms="secondary" value="mediafiles"<?=(array_search('mediafiles',explode(',',$record[AUC_PREFIX.'_role']))!==false?' checked':'');?>></label>
						<?php
						$mods_folders = scandir($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/');
						array_splice($mods_folders, 0, 2);
						$hidden_modules = array('seo_queries');
						for ($q = 0; $q < count($mods_folders); $q++) {
							if (!in_array($mods_folders[$q], $hidden_modules)) {
								if (file_exists($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/'.$mods_folders[$q].'/info.ini') && $module_info = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/hyst/mods/'.$mods_folders[$q].'/info.ini')) {
								$module_name = $module_info['name'];
								} else {
								$module_name = $mods_folders[$q];
								}
							?>
							<label class="admin_label_checkbox"><?=$module_name;?> <input type="checkbox" data-rms="secondary" value="<?=$mods_folders[$q];?>"<?=(array_search($mods_folders[$q],explode(',',$record[AUC_PREFIX.'_role']))!==false?' checked':'');?>></label>
							<?php
							}
						}
						?>
					</div>
					<input type="hidden" name="id" value="<?=$record['id'];?>">
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
					<input type="hidden" name="id" value="<?=$record['id'];?>">
					<div class="admin_content_widht300">
						<input class="width100" type="button" role="submit" name="change_moderator_password" value="Сохранить">
					</div>
				</div>
			</interfaceform>
		</div>
	</div>
</div>
<?php
	endwhile;
?>
</div>
<?php
}
?>
</div>