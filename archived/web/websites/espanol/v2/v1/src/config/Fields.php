<?php


final class Fields {

	private static $data = array('lLogin'    => array('^[A-Za-z0-9_\-]{3,60}$', 'Nombre de usuario / contraseña no válido', 'Неправильний логін/пароль'),
	                             'lPassword' => array('^[A-Za-z0-9 _.\-!@*$?&%]{6,60}$', 'Nombre de usuario / contraseña no válido', 'Неправильний логін/пароль'),
	                             'rlogin' => array('^[A-Za-z0-9_\-]{3,60}$', 'El inicio de sesión debe estar en el rango de 3 a 60 caracteres y consiste en letras, números y caracteres ingleses grandes y _-', 'Логін повинен бути в межах від 3 до 60 символів та складатися лише з великих, маленьких англійських букв, цифр та символів _-'),
	                             'rpassword' => array('^[A-Za-z0-9 _.\-!@*$?&%]{6,60}$', 'La contraseña debe estar en el rango de 6 a 60 caracteres y debe constar de letras, espacios, números y caracteres ingleses grandes o _.\-!@*$?&%', 'Пароль повинен бути в межах від 6 до 60 символів та складатися лише з великих, маленьких англійських букв, пробілу, цифр або символів  _.\-!@*$?&%'),
	                             'rdpassword' => array('^[A-Za-z0-9 _.\-!@*$?&%]{6,60}$', 'La contraseña debe estar en el rango de 6 a 60 caracteres y debe constar de letras, espacios, números y caracteres ingleses grandes o _.\-!@*$?&%', 'Пароль повинен бути в межах від 6 до 60 символів та складатися лише з великих, маленьких англійських букв, пробілу, цифр або символів  _.\-!@*$?&%'),
	                             'remail' => array('^(?:[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$', 'La dirección de correo electrónico que ingresaste es incorrecta', 'Введена електронна адреса є неправильною'),
	);

	public static function get($key, $language = 0) {

		if($language == 2 && array_key_exists($key, self::$data) && array_key_exists(0, self::$data[$key]) && array_key_exists(1, self::$data[$key]) && array_key_exists(2, self::$data[$key]))
			return \Api\helper::replaceData(self::$data[$key]);
		else if(array_key_exists($key, self::$data) && array_key_exists($language, self::$data[$key]))
			return \Api\helper::replaceData(self::$data[$key][$language]);

		die('NO REGEX FOR KEY : $data[' . $key . '][' . $language . '] <br>' . \Api\helper::debug_info());

	}
}