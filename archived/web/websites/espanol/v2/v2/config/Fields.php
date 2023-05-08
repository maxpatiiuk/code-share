<?php


final class Fields{

	private static $data = ['lLogin'             => ['^[\w\-\.]{3,60}$', 'Nombre de usuario / contraseña no es válido', 'Неправильний логін/пароль'],
	                        'lepLogin'           => ['^([\w\-\.]{3,60})|([^\{\}^%@\s]{0,50}@[^\{\}^%@\s.]{0,50}(.[^\{\}^%@\s]{0,50}){1,})|([\+\d() \-]{5,40})$', 'Nombre de usuario / contraseña no es válido', 'Неправильний логін/пароль'],
	                        'lPassword'          => ['^[\w .\-!@*$?&%]{6,60}$', 'Nombre de usuario / contraseña no es válido', 'Неправильний логін/пароль'],
	                        'rlogin'             => ['^[\w\-\.]{3,60}$', 'El inicio de sesión debe estar en el límito de 3 a 60 sñombolos y consiste en letras, números y caracteres ingleses grandes y _-.', 'Логін повинен бути в межах від 3 до 60 символів та складатися лише з великих, маленьких англійських букв, цифр та символів _-.'],
	                        'rpassword'          => ['^[A-Za-z0-9 _.\-!@*$?&%]{6,60}$', 'La contraseña debe estar en el límito de 6 a 60 símbolos y debe constar de letras, espacios, números y caracteres ingleses grandes o _.\-!@*$?&%', 'Пароль повинен бути в межах від 6 до 60 символів та складатися лише з великих, маленьких англійських букв, пробілу, цифр або символів  _.\-!@*$?&%'],
	                        'rdpassword'         => ['^[A-Za-z0-9 _.\-!@*$?&%]{6,60}$', 'La contraseña debe estar en el límito de 6 a 60 símbolos y debe constar de letras, espacios, números y caracteres ingleses grandes o _.\-!@*$?&%', 'Пароль повинен бути в межах від 6 до 60 символів та складатися лише з великих, маленьких англійських букв, пробілу, цифр або символів  _.\-!@*$?&%'],
	                        'remail'             => ['^[^\{\}^%@\s]{0,50}@[^\{\}^%@\s.]{0,50}(.[^\{\}^%@\s]{0,50}){1,}$', 'La dirección de correo electrónico que ingresaste es incorrecta', 'Введена електронна адреса є неправильною'],
	                        'p_name'             => ['^[^\d!@$;:%\^&+=\[\]\{\}]{0,50}$', 'Su nombre y apellido se registran en el formato incorrecto. Intenta escoger caracteres especiales o acortar la longitud', 'Ім\'я та прізвище записане в неправильному форматі. Спробуйте забрати спеціальні символи або скоротити довжину'],
	                        'p_phone'            => ['^[\+\d() \-]{5,40}$', 'El número de teléfono introducido no es válido', 'Введений номер телефону не є дійсним'],
	                        'p_sm'               => ['^((https?:\/\/)?(www.)?[^@$%^{}\[\]\(\)]{0,50})|([^\s$%^{}\[\]\(\)]{0,100})$', 'Especifique el enlace a su página en la red social o el login correcto', 'Вкажіть посилання на вашу сторінку в соцмережі або правильний логін'],
	                        'p_about'            => ['^.{0,1000}$', 'Información acerca de Usted debe tener menos de 1000 símbolos', 'Інформація про себе повинна бути коротшою за 1000 символів'],
	                        'p_date'             => ['^(19\d{2})|(20\d{2})-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$', 'La fecha debe estar en el siguiente formato: aaaa-mm-dd', 'Дата повинна бути в такому форматі: yyyy-mm-dd'],
	                        'p_city'             => ['^[^\{\}^%@\<\>]{0,60}$', 'El lugar de residencia debe tener menos de 60 símbolos y no los siguientes símbolos: {} ^% @', 'Місце проживання повинно бути коротшим за 50 символів та не наступних символів: {}^%@'],
	                        'p_edu'              => ['^[^\{\}^%@\<\>]{0,70}$', 'El lugar de estudio debe tener menos de 70 símbolos y no los siguientes símbolos: {} ^% @', 'Місце навчання повинно бути коротшим за 50 символів та не наступних символів: {}^%@'],
	                        'email_visibility'   => ['^(-1|0|1)$', 'Elija la visibilidad de su dirección de correo electrónico', 'Виберіть видимість вашого профілю'],
	                        'profile_visibility' => ['^(-1|0|1)$', 'Elija la visibilidad de su dirección de su perfil', 'Виберіть видимість вашого email адресу'],
	                        'passwords_mismatch' => ['', 'Las contraseñas no coinciden', 'Паролі не співпадають'],
	                        'rclass'             => ['^(-1|[05-9]|1[0-1])$', 'Especifique su clase', 'Вкажіть ваший клас'],
	                        'a_category'         => ['[\w\-"\'\(\)]{0,}', 'Especifique la categoría de publicación', 'Вкажіть категорію посту або заберіть спеціальні символи'],
	                        'a_theme'            => ['[\w\-"\'\(\)]{0,}', 'Especifica el tema del post', 'Вкажіть тему посту або заберіть спеціальні символи'],
	                        'a_name'             => ['[\w\-"\'\(\)]{1,}', 'Especifica nombre del post', 'Вкажіть назву посту або заберіть спеціальні символи'],
	                        'a_content'          => ['.{1,}', 'Especifica contenido del post', 'Вкажіть контент посту'],
	                        'a_keywords'         => ['[\w\-"\'\(\)]{1,}', 'Especifica etiquetas del post', 'Вкажіть тегм для посту або заберіть спеціальні символи'],
	                        'a_description'      => ['[\w\-"\'\(\)]{1,}', 'Especifica descripción del post', 'Вкажіть опис посту або заберіть спеціальні символи'],
	                        'a_src'              => ['([^><*]{9,})?', 'Cargar una imagen o ingresar un enlace a una imagen', 'Завантажте зображення або вкажіть посилання на зображення'],
	                        'a_comment'          => ['[^><*]*', 'Se ha producido un error, intenta eliminar los caracteres especiales (&lt;&gt;*) del comentario a la publicación', 'Виникла помилка, спробуйте видалити спеціальні символи (&lt;&gt;*) з коментаря до посту'],
	                        'msg'                => ['^.{0,1000}$', 'Mensaje debe tener menos de 1000 símbolos ', 'Повідомлення повине бути коротшим за 1000 символів'],
	                        ''                   => ['', '', ''],
	];

	public static function get_formatted($key){

		$data = self::get($key);

		$result = 'data-regex="' . htmlspecialchars($data[0]) . '" data-regex_warning1="' . htmlspecialchars($data[1]) . '"';
		if(Site::_LANGUAGE_MODE_ === -1)
			$result .= ' data-regex_warning2="' . htmlspecialchars($data[2]) . '"';

		return $result;

	}

	public static function get($key){

		if(array_key_exists($key, self::$data) && array_key_exists(0, self::$data[$key]) && array_key_exists(Site::$current_language + 1, self::$data[$key]) && ((Site::_LANGUAGE_MODE_ === -1 && array_key_exists(2, self::$data[$key])) || Site::_LANGUAGE_MODE_ === 0))
			return \Api\helper::replaceData(self::$data[$key]);

		die('NO REGEX FOR KEY : $data[' . $key . '] <br>' . \Api\helper::debug_info());

	}

}