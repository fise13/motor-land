		<div class="authorization_block">
			<div class="authorization_form">
				<interfaceform target="hyst/core/admin_profile">
					<div class="form_title text-center">Регистрация первичного пользователя системы</div>
					
					<label>Название пользователя<i>*</i><br><iw><input class="width100" error="Название содержит не корректные символы!" type="text" name="title" check="name" length=">2" mandatory></iw></label>
					<label>Имя<i>*</i><br><iw><input class="width100" error="Имя содержит не корректные символы!" type="text" name="name" check="name" length=">2" mandatory></iw></label>
					<label>Email<i>*</i><br><iw><input class="width100" error="Email не корректен!" type="text" name="email" check="email" mandatory></iw></label>
					<label>Пароль<i>*</i><br><iw><input class="width100" error="Пароль может состоять только из символов A-zA-z0-9 -_#@$%^&* и быть не короче 6ти символов!" type="password" name="password" check="password" mandatory></iw></label>
					<label>Повторите пароль<i>*</i><br><iw><input class="width100" error="Пароли не совпадают!" type="password" mirror="password" check="mirror" mandatory></iw></label>
					<input class="width100" type="button" role="submit" name="primary_registration" value="Регистрация">
				</interfaceform>
			</div>
		</div>
