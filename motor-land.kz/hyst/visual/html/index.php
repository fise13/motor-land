<interfaceform target="hyst/core/admin_profile">
	<div class="form_title">Сменить учетные данные</div>
	<div class="admin_content_alignment">
		<?php
		if ($_HYST_ADMIN[AUC_PREFIX.'_role']=='general' || $_HYST_ADMIN[AUC_PREFIX.'_role']=='all') {
		?>
		<div class="admin_content_widht300">
			<label>Название пользователя<i>*</i><br><iw><input value="<?=$_HYST_ADMIN[AUC_PREFIX.'_tip'];?>" class="width100" error="Название содержит не корректные символы!" type="text" name="title" check="name" length=">2" mandatory></iw></label>
		</div>
		<div class="admin_content_widht300">
			<label>Имя<i>*</i><br><iw><input value="<?=$_HYST_ADMIN[AUC_PREFIX.'_name'];?>" class="width100" error="Имя содержит не корректные символы!" type="text" name="name" check="name" length=">2" mandatory></iw></label>
		</div>
		<?php
		}
		?>
		<div class="admin_content_widht300">
			<label>Email<i>*</i><br><iw><input value="<?=$_HYST_ADMIN[AUC_PREFIX.'_mail'];?>" class="width100" error="Email не корректен!" type="text" name="email" check="email" mandatory></iw></label>
		</div>
		<div class="admin_content_widht300">
			<input class="width100" type="button" role="submit" name="change_admin_data" value="Сохранить">
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
		<div class="admin_content_widht300">
			<input class="width100" type="button" role="submit" name="change_admin_password" value="Сохранить">
		</div>
	</div>
</interfaceform>