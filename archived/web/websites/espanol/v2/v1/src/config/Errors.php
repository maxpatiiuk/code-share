<?php


final class Errors {

	private static $data = array(
		'user_banned'    => array('Este usuario ha sido eliminado. Si necesitas ayuda, <a href="VALUE_SUPPORT_LINK_END">contacta con el centro de soporte</a>', 'Цей користувач видалений. Якщо потрібна допомога, <a href="VALUE_SUPPORT_LINK_END">зверніться в центр підтримки</a>', 1),
		'user_deleted'   => array('Este usuario ha sido bloqueado. Si necesitas ayuda, <a href="VALUE_SUPPORT_LINK_END">contacta con el centro de soporte</a>', 'Цей користувач заблокований. Якщо потрібна допомога, <a href="VALUE_SUPPORT_LINK_END">зверніться в центр підтримки</a>', 1),
		'user_freezed'   => array('Esta cuenta está temporalmente congelada. Las herramientas de descongelación se envían a la dirección de correo electrónico adjunta a la cuenta. Si necesitas ayuda, <a href="VALUE_SUPPORT_LINK_END">contacta con el centro de soporte</a>', 'Цей акаунт тимчасово заморожено. Інстркції по розмороженні надішлені на електронна адресу приєднану до акаунту. Якщо потрібна допомога, <a href="VALUE_SUPPORT_LINK_END">зверніться в центр підтримки</a>', 1),
		'user_banned_ip' => array('Esta dirección IP no le permite iniciar sesión en esta cuenta. Si necesitas ayuda, <a href="VALUE_SUPPORT_LINK_END">contacta con el centro de soporte</a>', 'Цей IP адрес не дозволяє увійти в даний аккаунт. Якщо потрібна допомога, <a href="VALUE_SUPPORT_LINK_END">зверніться в центр підтримки</a>', 1),
		'login_taken' => array('Este inicio de sesión ya está en uso. Especifique otra o <a href="VALUE_LOGIN_LINK_END">inicie sesión en esta cuentae</a>', 'Даний логін вже використовується. Вкажіть інший або <a href="VALUE_LOGIN_LINK_END">ввійдіть в цей акаунт</a>', 1),
		'email_taken' => array('Esta dirección de correo electrónico ya está en uso. Especifique otra o <a href="VALUE_LOGIN_LINK_END">inicie sesión en esta cuenta</a>', 'Дана електронна адреса вже використовується. Вкажіть інший або <a href="VALUE_LOGIN_LINK_END">ввійдіть в цей акаунт</a>', 1),
		'password_not_dpassword' => array('Las contraseñas no coinciden', 'Паролі не співпадають'),
		'password_to_simple' => array('La contraseña es demasiado simple', 'Пароль занадто простий'),
		'password_is_login' => array('La contraseña y el login no pueden ser los mismos.','Пароль та логін не можуть бути однаковими'),
		'captcha_is_necessary' => array('Captcha debe ser llenado','Капча повинна бути заповненою'),
		'captcha_failed' => array('Capcha es una necesidad','Капча є обов\'язковою'),
		'wrong_password' => array('Nombre de usuario / contraseña no válido', 'Неправильний логін/пароль'),
		'try_later' => array('Se han realizado demasiados intentos de inicio de sesión no válidos en esta cuenta. Inténtalo de nuevo más tarde','Надто багато неправильних спроб входу було виконано в цей акаунт. Спробуйте пізніше'),
		'profile_not_found' => array('Este perfil no ha sido encontrado. <a href="VALUE_MAIN_PAGE_END">Volver a la principal</a>','Даний профіль не знайдено. <a href="VALUE_MAIN_PAGE_END">Повернутися на головну</a>'),
		'' => array('',''),
	);


	public static function get($key, $language = 0) {

		if($language === 2 && array_key_exists($key, self::$data) && array_key_exists(0, self::$data[$key]) && array_key_exists(1, self::$data[$key]))
			return \Api\helper::replaceData(self::$data[$key]);
		else if(array_key_exists($key, self::$data) && array_key_exists($language, self::$data[$key]))
			return \Api\helper::replaceData(self::$data[$key][$language]);

		die('NO ERRORS FOR KEY : $data[' . $key . '][' . $language . '] <br>' . \Api\helper::debug_info());

	}

	public static function formatError($data) {
		if(!is_array($data))
			return $data;

		return implode('\n',$data);
	}
}