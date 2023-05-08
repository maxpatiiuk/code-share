<?php

final class Language
{

	private static $data = array(

		//different
		'404title' => array('Perdido?', 'Загубилися?'),

		//login / register
		'logIn' => array('Acceder', 'Вхід'),
		'login' => array('Login', 'Логін'),
		'password' => array('Contraseña', 'Пароль'),
		'dpassword' => array('Repetir contraseña', 'Повторити пароль'),
		'register' => array('Regístrate', 'Реєстрація'),
		'email' => array('Correo electronico', 'E-mail'),
		'forgotPassword' => array('¿Olvidaste tu contraseña?', 'Забули пароль?'),
		'email_account_freezed' => array('Su cuenta en %% está bloqueada temporalmente debido a un gran número de intentos fallidos de inicio de sesión. No hay necesidad de agitar. Para desbloquear una cuenta haz %%click aquí%%.','Ваший аккаунт в %% тимчасово заблоковано, через велику кількість невдалих спроб входу в акаунт. Хвилюватися не потрібно. Щоб розблокувати акаунт %%натисніть сюди%%.'),
		'captcha' => array('Captcha','Captcha'),

		//time
		'just_now' => array('solo','шойно'),
		'language_ago_before' => array('hace ',''),
		'x_sec_ago' => array('segundos','секунди тому'),
		'x_min_ago' => array('minutos','хвилини тому'),
		'x_hours_ago' => array('horas','години тому'),
		'after' => array('despues','через'),
		'x_sec' => array('segundos','секунди'),
		'x_min' => array('minutos','хвилини'),
		'x_hours' => array('horas','години'),

		//profile
		'profile' => array('Perfil','Профіль'),
		'user_profile_edit' => array('Editar','Редагувати'),
		'user_profile_edit_2' => array('Guardar cambios','Зберегти зміни'),
		'user_photo_edit' => array('Cambiar foto','Змінити фото'),
		'contacts' => array('Contactos','Контакти'),
		'information' => array('Informacion','Інформація'),
		'personal_life' => array('Vida personal','Персональне життя'),
		'phone' => array('Numero de telefono','Номер телефону'),
		'about_me' => array('Acerca de mi','Про мене'),
		'birth_date' => array('Fecha de nacimiento','Дата народження'),
		'register_date' => array('Registrado en','Зареєстрований з'),
		'last_online' => array('Estaba en linea','Був онлайн'),
		'city' => array('Lugar de residencia','Місце проживання'),
		'edu' => array('Institución educativa','Навчальний заклад'),
		'user_name' => array('Nombre y apellido','Ім\'я та прізвише'),
		'show_last_online' => array('Mostrar cuando estaba en línea','Показувати коли був у мережі'),
		'show_register_date' => array('Mostrar fecha de registro','Показувати дату реєстрації'),
		'' => array('',''),
	);

	public static function get($key, $language = 0)
	{
		if($language == 2 && array_key_exists($key, self::$data) && array_key_exists(0, self::$data[$key]) && array_key_exists(1, self::$data[$key]))
			return self::fill_into_data(self::$data[$key],func_get_args());
		else if(array_key_exists($key, self::$data) && array_key_exists($language, self::$data[$key]))
			return self::fill_into_data(self::$data[$key][$language],func_get_args());

		die('NO DATA FOR KEY : $data[' . $key . '][' . $language . '] <br>' . \Api\helper::debug_info());

	}

	private static function fill_into_text(&$text,$data){
		$i = 0;
		$keys = array_keys($data);
		while(true){
			$pos = strpos($text,'%%');

			if($pos === false)
				break;

			$text = substr($text,0,$pos).$data[$keys[$i]].substr($text,$pos+2);

			$i++;
		}
	}

	private static function fill_into_data($text,$data){
		unset($data[0]);
		unset($data[1]);

		if(!is_array($data) || count($data) === 0)
			return $text;

		if(is_array($text))
			foreach($text as $key => $value)
				self::fill_into_text($text[$key],$data);

		else
			self::fill_into_text($text,$data);

		return $text;
	}
}