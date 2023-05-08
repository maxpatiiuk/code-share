<?php


final class Errors{

	private static $data = ['user_deleted'           => ['Este usuario ha sido eliminado. Si necesitas ayuda, <a href="VALUE_SUPPORT_LINK_END">contacta con el centro de soporte</a>', 'Цей користувач видалений. Якщо потрібна допомога, <a href="VALUE_SUPPORT_LINK_END">зверніться в центр підтримки</a>', 1],
	                        'user_banned'            => ['Este usuario ha sido bloqueado. Si necesitas ayuda, <a href="VALUE_SUPPORT_LINK_END">contacta con el centro de soporte</a>', 'Цей користувач заблокований. Якщо потрібна допомога, <a href="VALUE_SUPPORT_LINK_END">зверніться в центр підтримки</a>', 1],
	                        'user_freezed'           => ['Esta cuenta está temporalmente congelada. Las herramientas de descongelación se envían a la dirección de correo electrónico adjunta a la cuenta. Si necesitas ayuda, <a href="VALUE_SUPPORT_LINK_END">contacta con el centro de soporte</a>', 'Цей акаунт тимчасово заморожено. Інстркції по розмороженні надішлені на електронна адресу приєднану до акаунту. Якщо потрібна допомога, <a href="VALUE_SUPPORT_LINK_END">зверніться в центр підтримки</a>', 1],
	                        'user_banned_ip'         => ['Esta dirección IP no le permite iniciar sesión en esta cuenta. Si necesitas ayuda, <a href="VALUE_SUPPORT_LINK_END">contacta con el centro de soporte</a>', 'Цей IP адрес не дозволяє увійти в даний аккаунт. Якщо потрібна допомога, <a href="VALUE_SUPPORT_LINK_END">зверніться в центр підтримки</a>', 1],
	                        'login_taken'            => ['Este inicio de sesión ya está en uso. Especifique otra o <a href="VALUE_LOGIN_LINK_END">inicie sesión en esta cuentae</a>', 'Даний логін вже використовується. Вкажіть інший або <a href="VALUE_LOGIN_LINK_END">ввійдіть в цей акаунт</a>', 1],
	                        'email_taken'            => ['Esta dirección de correo electrónico ya está en uso. Especifique otra o <a href="VALUE_LOGIN_LINK_END">inicie sesión en esta cuenta</a>', 'Дана електронна адреса вже використовується. Вкажіть інший або <a href="VALUE_LOGIN_LINK_END">ввійдіть в цей акаунт</a>', 1],
	                        'password_not_dpassword' => ['Las contraseñas no coinciden', 'Паролі не співпадають'],
	                        'password_to_simple'     => ['La contraseña es demasiado simple', 'Пароль занадто простий'],
	                        'password_is_login'      => ['La contraseña y el login no pueden ser los mismos.', 'Пароль та логін не можуть бути однаковими'],
	                        'captcha_is_necessary'   => ['Captcha debe ser llenado', 'Капча повинна бути заповненою'],
	                        'captcha_failed'         => ['Capcha es una necesidad', 'Капча є обов\'язковою'],
	                        'wrong_password'         => ['Nombre de usuario / contraseña no válido', 'Неправильний логін/пароль'],
	                        'try_later'              => ['Se han realizado demasiados intentos de inicio de sesión no válidos en esta cuenta. Inténtalo de nuevo más tarde', 'Надто багато неправильних спроб входу було виконано в цей акаунт. Спробуйте пізніше'],
	                        'profile_not_found'      => ['Este perfil no ha sido encontrado. <a href="VALUE_MAIN_PAGE_END">Volver a la principal</a>', 'Даний профіль не знайдено. <a href="VALUE_MAIN_PAGE_END">Повернутися на головну</a>'],
	                        'no_file_uploaded'       => ['No has seleccionado un archivo', 'Ви не вибрали файл'],
	                        'file_is_not_an_image'   => ['El archivo no es una foto.', 'Файл не є фотографією'],
	                        'forbidden_extension'    => ['El archivo tiene una extensión prohibida', 'Файл має заборонене розширення'],
	                        'file_size_too_big'      => ['El archivo es demasiado grande', 'Файл має заборонене розширення'],
	                        'file_already_exists'    => ['El archivo ya existe', 'Файл вже існує'],
	                        'failed_to_upload'       => ['Falló la descarga. Prueba otro archivo o descarga más tarde', 'Помилка завантаження. Спробуйте інший файл або завантажити пізніше'],
	                        'same_password'          => ['La contraseña anterior y nueva no puede ser la misma.', 'Попередній та новий пароль не може бути однаковим'],
	                        ''                       => ['', ''],
	];

	public static function to_json(
		$field,
		$key,
		$is_error = TRUE/*or action*/
	){

		$return['error'] = 1;
		if($is_error){
			$temp_data = Errors::get($key, 2);
			array_unshift($temp_data, $field);
			$return[$field] = $temp_data;
		} else
			$return[$field] = $key;//key>value
		return json_encode($return);
	}

	public static function get(
		$key,
		$language = 0
	){

		if($language === 0 && array_key_exists($key, self::$data) && array_key_exists(Site::$current_language, self::$data[$key])){
			if(array_key_exists(2, self::$data) && self::$data[2] === 1)
				return \Api\helper::replaceData(self::$data[$key][Site::$current_language]); else
				return self::$data[$key][Site::$current_language];
		} elseif($language === 1 && Site::_LANGUAGE_MODE_ === -1 && array_key_exists($key, self::$data) && array_key_exists(Site::$current_language + 1, self::$data[$key])) {
			if(array_key_exists(2, self::$data) && self::$data[2] === 1)
				return \Api\helper::replaceData(self::$data[$key][Site::$current_language + 1]); else
				return self::$data[$key][Site::$current_language + 1];
		} elseif($language === 1 && Site::_LANGUAGE_MODE_ !== -1)
			return '';
		elseif($language === 2 && array_key_exists($key, self::$data))
			return \Api\helper::replaceData(self::$data[$key]);
		elseif($language === 3 && array_key_exists($key, self::$data))
			return \Api\helper::replaceData(self::$data[$key],
			                                $key
			);

		die('NO ERRORS FOR KEY : $data[' . $key . '][' . $language . '] <br>' . \Api\helper::debug_info());

	}

}