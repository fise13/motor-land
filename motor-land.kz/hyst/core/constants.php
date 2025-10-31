<?php
$hystphpself = $_SERVER['PHP_SELF'];

define("REGEXP_NAME", "/^[\p{L}\p{N}\s\.,\-_]+$/u");
define("REGEXP_MAIL", "/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/");
define("REGEXP_PASS", "/^[A-Za-z0-9\.\-_#@$\%^&*]{6,}$/");
define("REGEXP_MD5", "/^[0-9a-z]+$/i");
define("REGEXP_NICKNAME", "/^[A-z0-9\.\-_]+$/");
define("REGEXP_NICK_TAG", "/^[a-z0-9\.\-_]+$/");
define("REGEXP_INT", "/^[0-9]+$/");
define("REGEXP_TITLE", <<<'EOD'
/^[A-Za-z0-9\p{Cyrillic}\p{L}\.\-_#@$\%^&*"\' ,\[\]\(\)\{\}]{3,}$/u
EOD
);

$HYSTRX['login'] = '/^(?=.*[a-zA-Z0-9_-])[\w-]{4,}$/';
$HYSTRX['email'] = '/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u';
$HYSTRX['passw'] = '/^(?=.*[a-zA-Z0-9_-])[\w-]{4,}$/';
$HYSTRX['md5'] = '/^[0-9a-z]+$/i';
$HYSTRX['telephone'] = '/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/';
$HYSTRX['name'] = '/^[а-яА-Я]{4}|[a-zA-Z]{4}$/';
$HYSTRX['adres'] = '/^[a-zA-Zа-яА-Я0-9,\.\s]+$/';
$HYSTRX['biniin'] = '/^(?=\d{1,12}$)\d+$/';

//сообщения негативные
$HYSTALERT['error_instal_bd'] = 'Не могу создать родительскую таблицу!';
$HYSTALERT['error_instal_bd0'] = 'Не могу создать медиатаблицу таблицу!';
$HYSTALERT['error_instal_file'] = 'Не могу создать дирректорию для медиа!';
$HYSTALERT['error_sql'] = 'Запрос к БД не прошел!';
$HYSTALERT['error_data_val'] = 'Не все обязательные поля заполненны не верно!';
$HYSTALERT['error_send_mail'] = 'Ошибка! Письмо могло быть не отправленно! Обратитесь к админимтрации!';
$HYSTALERT['error_anoth_login'] = 'Ошибка! Пользователь с таким логином уже существует!';
$HYSTALERT['error_anoth_email'] = 'Ошибка! Пользователь с таким E-mail уже существует!';
$HYSTALERT['error_noindb_email'] = 'Ошибка! Пользователь с таким E-mail не существует!';
$HYSTALERT['error_badact_code'] = 'Ошибка! Не верная ссылка активации!';
$HYSTALERT['error_bad_activete'] = 'Ошибка! Активация не обновлена! Обратитесь к админимтрации!';
$HYSTALERT['error_wrong_login'] = 'Ошибка! Не верный логин или пароль!';
$HYSTALERT['error_wrong_sendorder'] = 'Ошибка! Не могу отправить заказ! Обратитесь к админимтрации!';
$HYSTALERT['error_key_exist'] = 'Ошибка! Такой ключ уже существует у другой записи!';

$HYSTALERT['error_match_ajx_login'] = 'Логин может содержать только A-z0-9-_ символы (не короче 4х символов)!';
$HYSTALERT['error_match_ajx_email'] = 'Не корректный Email!';
$HYSTALERT['error_match_ajx_passw'] = 'Пароль может содержать только A-z0-9-_ символы (не короче 4х символов)!';
$HYSTALERT['error_match_ajx_telephone'] = 'Не корректный формат телефона!';
$HYSTALERT['error_match_ajx_name'] = 'Только символы А-я и A-z!';
$HYSTALERT['error_match_ajx_adres'] = 'Только символы А-я и A-z!';
$HYSTALERT['error_match_ajx_biniin'] = 'БИН\ИИН может состоять только из 12 цифр!';

$HYSTALERT['done_data_registr'] = 'Регистрация успешна! Можете авторизоваться!';
$HYSTALERT['done_user_registr'] = 'На вашу почту отпревлено письмо с ссылкой на завершение регистрации!';
$HYSTALERT['done_user_droppass'] = 'На вашу почту отпревлено письмо с новым паролем!';
$HYSTALERT['done_data_change'] = 'Изменения успешны!';
$HYSTALERT['done_data_orderaccept'] = 'Ваш заказ в обработке, в ближайшее время мы с Вами свяжемся!';