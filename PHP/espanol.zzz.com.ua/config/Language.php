<?php


final class Language{

	private static $data = [

		//different
		'404title'                 => ['Ha perdido?', 'Загубилися?'],
		'page_not_found'           => ['Página no encontrada', 'Сторінку не знайдено'],
		'main_page'                => ['Inicio', 'Головна'],
		'yes'                      => ['Sí', 'Так'],
		'no'                       => ['No', 'Ні'],

		//contacts
		'contact_us'               => ['Nuestros contactos', 'Наші контакти'],
		'msg'                      => ['Mensaje', 'Повідовлення'],
		'tel'                      => ['Número de teléfono', 'Номер телефону'],
		'tel2'                     => ['Número de teléfono 2', 'Номер телефону 2'],
		'email2'                   => ['Correo electrónico 2', 'E-mail 2'],
		'addr'                     => ['Dirección', 'Адреса'],
		'addr2'                    => ['Dirección 2', 'Адреса 2'],
		'write_to_us'              => ['Escríbanos', 'Напишіть нам'],
		'new_question_subject'     => ['Nuevo mensaje', 'Нове повідомлення'],
		'new_question_content'     => ['Nuevo mensaje del usuario', 'Нове повідомлення від користувача'],
		'email_send'               => ['La carta ha sido enviada exitosamente', 'Лист успішно надіслано'],

		//login / register
		'logIn'                    => ['Acceso', 'Вхід'],
		'login'                    => ['Login', 'Логін'],
		'password'                 => ['Contraseña', 'Пароль'],
		'new_password'             => ['Contraseña nueva', 'Новий пароль'],
		'dpassword'                => ['Repetir contraseña', 'Повторити пароль'],
		'register'                 => ['Registrarse', 'Реєстрація'],
		'email'                    => ['Correo electrónico', 'E-mail'],
		'new_email'                => ['Correo electrónico nuevo', 'Новий e-mail'],
		'forgotPassword'           => ['¿Olvidó su contraseña?', 'Забули пароль?'],
		'password_changed_email'   => ['La contraseña para su cuenta en VALUE_SITE_NAME_END se ha cambiado. Para cancelar esta acción y cambiar su contraseña, vaya aquí - ', 'Пароль до вашого акаунту в VALUE_SITE_NAME_END був змінений. Щоб скасувати цю дію та змінити пароль натисніть сюди - ', 1],
		'password_reset_email'     => ['Para cambiar la contraseña de su cuenta, haga clic aquí - ', 'Щоб змінити пароль до вашого акаунту, натисніть сюди - ', 1],
		'email_change'             => ['Cambiar correo electrónico', 'Зміна E-mail адресу'],
		'email_changed_email'      => ['El correo electrónico para su cuenta en VALUE_SITE_NAME_END se ha cambiado. Para cancelar esta acción y cambiar su contraseña, <a href="VALUE_PASSWORD_RESET_LINK_END">vaya aquí</a>', 'Email до вашого акаунту в VALUE_SITE_NAME_END був змінений. Щоб скасувати цю дію та змінити пароль <a href="VALUE_PASSWORD_RESET_LINK_END">перейдіть сюди</a>', 1],
		'email_changed_email_2'    => ['Correo electrónico nuevo -', 'Нова електронна пошта -'],
		'email_confirm_content'    => ['Su dirección de correo electrónico en VALUE_SITE_NAME_END se ha cambiado. Para confirmar la nueva dirección de correo electrónico haga clic aquí -', 'Вашу електронну адресу в VALUE_SITE_NAME_END змінено. Щоб підтвердити нову E-mail адресу, натисніть сюди -', 1],
		'captcha'                  => ['Captcha', 'Captcha'],
		'change_password'          => ['Cambiar contraseña', 'Змінити пароль'],
		'send'                     => ['Enviar', 'Надіслати'],
		'invalid_link'             => ['Enlace incorrecto', 'Неправильне посилання'],
		'reset_email'              => ['Restablecer dirección de correo electrónico', 'Скинути E-mail адресу'],
		'confirm_email'            => ['Confirmar correo electrónico nuevo', 'Підтвердити E-mail адресу'],
		'email_confirmed'          => ['Dirección de correo electrónico verificada', 'E-mail адресу підтверджено'],

		//time
		'just_now'                 => ['reciente', 'щойно'],
		'language_ago_before'      => ['hace ', ''],
		'x_sec_ago'                => ['segundos', 'секунди тому'],
		'x_min_ago'                => ['minutos', 'хвилини тому'],
		'x_hours_ago'              => ['horas', 'години тому'],
		'after'                    => ['en', 'через'],
		'x_sec'                    => ['segundos', 'секунди'],
		'x_min'                    => ['minutos', 'хвилини'],
		'x_hours'                  => ['horas', 'години'],

		//profile
		'profile'                  => ['Perfil', 'Профіль'],
		'edit'                     => ['Editar', 'Редагувати'],
		'user_profile_edit_2'      => ['Guardar cambios', 'Зберегти зміни'],
		'user_photo_edit'          => ['Cambiar foto', 'Змінити фото'],
		'contacts'                 => ['Contactos', 'Контакти'],
		'information'              => ['Información', 'Інформація'],
		'personal_life'            => ['Vida personal', 'Персональне життя'],
		'phone'                    => ['Número de teléfono', 'Номер телефону'],
		'about_me'                 => ['Acerca de mí', 'Про мене'],
		'birth_date'               => ['Fecha de nacimiento', 'Дата народження'],
		'register_date'            => ['Registrado en', 'Зареєстрований з'],
		'last_online'              => ['Estaba en línea', 'Був онлайн'],
		'city'                     => ['Lugar de residencia', 'Місце проживання'],
		'edu'                      => ['Institución educativa', 'Навчальний заклад'],
		'user_name'                => ['Nombre y apellido', 'Ім\'я та прізвише'],
		'show_last_online'         => ['Mostrar cuando estaba en línea', 'Показувати коли був у мережі'],
		'show_register_date'       => ['Mostrar fecha de registro', 'Показувати дату реєстрації'],
		'upload_file'              => ['Descargar el archivo', 'Завантажити файл'],
		'choose_file'              => ['Selecciona', 'Виберіть'],
		'or_drag_file'             => ['o arrastra el archivo', 'або перетягніть файл'],
		'file_uploading'           => ['El archivo se descarga', 'Файл завантажується'],
		'file_uploaded'            => ['Archivo está subido', 'Файл завантажено'],
		'error_uploading'          => ['Error al cargar el archivo', 'Помилка завантаження файлу'],
		'access_denied'            => ['¡El acceso está prohibido!', 'Доступ заборонено!'],
		'profile_edit'             => ['Editar perfil', 'Редагувати профіль'],
		'log_out'                  => ['Cerrar sesión', 'Вийти'],
		'send_message'             => ['Escribir', 'Написати повідомлення'],
		'see_posts'                => ['Artículos', 'Пости'],
		'profile_not_found'        => ['Usuario no encontrado', 'Користувача не знайдено'],
		'profile_is_private'       => ['Cuenta de usuario es privada', 'Акаунт користувача приватний'],
		'log_in_to_see_profile'    => ['<a href="VALUE_LOGIN_LINK_END">Inicie sesión</a> en su cuenta para ver esta cuenta', '<a href="VALUE_LOGIN_LINK_END">Увійдіть</a> у ваший аккаунт, щоб побачити цей акаунт', 1],
		'no_internet'              => ['No hay internet! Inténtelo de nuevo cuando aparezca ...', 'Немає інтернету! Спробуйте ще раз, коли він появиться...'],
		'delete_user_confirmation' => ['Eliminar usuario', 'Видалити користувача'],
		'ban_user_confirmation'    => ['Eliminar usuario', 'Видалити користувача'],
		'happy_birthday_subject'   => ['Feliz cumpleaños', 'З днем народження!'],
		'happy_birthday_content_1' => ['Felicitaciones por tu', 'Вітаємо з вашим'],
		'happy_birthday_content_2' => ['cumpleaños!', 'днем народження!'],

		//advanced profile
		'password_change'          => ['Cambiar contraseña', 'Змінити пароль'],
		'password_changed'         => ['Contraseña cambiada', 'Пароль змінено'],
		'old_password'             => ['La contraseña actual', 'Нинішний пароль'],
		'return_to_profile'        => ['Volver al perfil', 'Повернутися до профілю'],
		'receive_newsletters'      => ['Recibe las novedades por email', 'Отримувати новини на email'],
		'notifications'            => ['Notificaciones', 'Сповіщення'],
		'email_visibility'         => ['Visibilidad del su correo electónico', 'Видимість пошти'],
		'type_min_1'               => ['Para todos', 'Всім'],
		'type_0'                   => ['Para nadie', 'Нікому'],
		'type_1'                   => ['Para aquellos que han iniciado sessión', 'Для тих, хто ввійшов у акаунт'],
		'delete_account'           => ['Eliminar cuenta', 'Видалити акаунт'],
		'profile_visibility'       => ['Visibilidad del su perfil', 'Видимість акаунту'],
		'redirect'                 => ['Las referencias a la página principal ahora tendrán lugar. Si no, <a href="VALUE_MAIN_PAGE_END">haga clic aquí</a>', 'Зараз відбудеться перенаправлення на головну сторінку. Якщо ні, <a href="VALUE_MAIN_PAGE_END">то натисніть сюди</a>', 1],
		'saved'                    => ['¡Guardado!', 'Збережено!'],
		'error_while_saving'       => ['Se produjo un error al guardar los cambios. Llegar mas tarde', 'Виникла помилка при зберіганні змін. Спробуйте пізніше'],
		'dark_theme'               => ['El tema oscuro del sitio', 'Темна тема сайту'],

		//posts
		'add_post'                 => ['Crear una publicación', 'Створити пост'],
		'edit_post'                => ['Editar una publicación', 'Редагувати пост'],
		'show_posts'               => ['Mostrar mis publicaciones', 'Показати мої пости'],
		'cancel'                   => ['Сancelar', 'Скасувати'],
		'class'                    => ['Clase', 'Клас'],
		'classes'                  => ['Clases', 'Класи'],
		'graduated'                => ['Graduados', 'Випускники'],
		'all'                      => ['Todas', 'Всі'],
		'class_undefined'          => ['No especifique', 'Не вказувати'],
		'category'                 => ['Categoría', 'Категорія'],
		'theme'                    => ['Tema', 'Тема'],
		'name'                     => ['Nombre', 'Назва'],
		'content'                  => ['Contenido', 'Контент'],
		'author'                   => ['Autor', 'Автор'],
		'keywords'                 => ['Etiquetas', 'Теги'],
		'description'              => ['Descripción', 'Опис'],
		'post_not_found'           => ['Esta publicación no fue encontrada', 'Цей пост не знайдено'],
		'created_by'               => ['Publicado por', 'Написав'],
		'created_on'               => ['en', 'в'],
		'search'                   => ['Buscar', 'Шукати'],
		'error_while_getting_data' => ['Ocurrió un error al recibir información. Inténtalo más tarde', 'Виникла помилка при отриманні інформації. Спробуйте пізніше'],
		'file'                     => ['Subir imagen o enlace a una imagen', 'Завантажте зображення або вкажіть посилання на зображення'],
		'post_created_by'          => ['Publicaciones que escribió', 'Пости, що написав'],
		'image_preview'            => ['Bosquejo de ayuno', 'Ескіз посту'],
		'no_permission_to_edit'    => ['No tienes permiso para editar esta publicación', 'Ви не маєте доступу редагувати цей пост'],
		'comment'                  => ['Comentario', 'Коментарь'],
		'post_comment'             => ['Comentar', 'Коментувати'],
		'teacher_comment'          => ['Comentario del maestro', 'Коментарь вчителя'],
		'delete_post'              => ['Eliminar publicación', 'Видалити пост'],
		'delete'                   => ['Eliminar', 'Видалити'],
		'not_allowed_to_post'      => ['No tienes acceso a las publicaciones', 'Ви не маєте доступу до постів'],
		'post_verified_subject'    => ['Publicación verificada', 'Пост перевірено'],
		'post_verified_content'    => ['Su publicación en el <a href="VALUE_MAIN_PAGE_END">VALUE_SITE_NAME_END</a> ya ha sido verificada. Ver publicación -', 'Ваший пост на <a href="VALUE_MAIN_PAGE_END">VALUE_SITE_NAME_END</a> вже перевірено. Переглянути пост - ', 1],
		'not_logged_to_login'      => ['Para ver el arreglo, inicie sesión en la cuenta desde la que escribió esta publicación.', 'Щоб переглянути виправлення, увійдіть в акаунт з якого ви написали цей пост'],
		'not_your_post'            => ['Puedes ver la corrección solo para tus propias publicaciones', 'Ви можете переглянути виправлення лише для власних постів'],
		'view_post'                => ['Ver publicación', 'Переглянути пост'],
		'formatting_changed'       => ['Marcado cambiado', 'Змінилися розмітка'],
		'accept_edit'              => ['Confirmar la edición', 'Підтвердити редагування'],
		'no_posts_found'           => ['No se encontraron publicaciones', 'Постів не знайдено'],
		'new_post_subject'         => ['La publicación está esperando una verificcation', 'Пост чекає на перевірку'],
		'new_post_content'         => ['La publicación está a la espera de una corrección. Para comprobar, haga clic aquí - ', 'Пост чекає на перевірку. Щоб перевірити, натисніть сюди - '],
		'delete_post_confirmation' => ['¿Eliminar publicación?', 'Видалити пост?'],
		'no_changes_made'          => ['No se han realizado cambios', 'Ніяких змін не зроблено'],
		'anonymous'                => ['Anónimo', 'Анонімний'],
		'reply'                    => ['Responder', 'Відповісти'],
		'commented_deleted_1'      => ['Comentario eliminado.', 'Коментар видалено.'],
		'commented_deleted_2'      => ['Devolver un comentario', 'Повернути коментар'],
		'new_comment'              => ['Nuevo comentario', 'Новий коментар'],
		'pages'                    => ['Páginas', 'Сторінки'],

		//adm
		'admin_panel'              => ['Ajustes', 'Налаштування'],
		'annonymos'                => ['Anónimo', 'Анонімний'],
		'users'                    => ['Usuarios', 'Користувачі'],
		'type'                     => ['Tipo', 'Тип'],
		'user'                     => ['El usuario', 'Користувач'],
		'admin'                    => ['Administrador', 'Адміністратор'],
		'partial_admin'            => ['Oculto', 'Схований'],
		'spectator'                => ['El administrador oculto', 'Схований адміністратор'],
		'admin_spectator'          => ['Administrador parcial', 'Частковий адміністратор'],
		'banned'                   => ['Bloqueado', 'Заблокований'],
		'deleted'                  => ['Eliminado', 'Видалений'],
		'no_users'                 => ['No se encontraron usuarios', 'Користувачів не знайдено'],
		'ban_user'                 => ['Bloquear usuario', 'Заблокувати користувача'],
		''                         => ['', ''],
	];

	public static function get(
		$key,
		$language = 0
	){

		if($language === 0 && array_key_exists($key, self::$data) && array_key_exists(Site::$current_language,
		                                                                              self::$data[$key]
			)){
			if(array_key_exists(2, self::$data[$key]) && self::$data[$key][2] === 1)
				return \Api\helper::replaceData(self::$data[$key][Site::$current_language]); else
				return self::$data[$key][Site::$current_language];
		} elseif($language === 1 && Site::_LANGUAGE_MODE_ === -1 && array_key_exists($key,
		                                                                             self::$data
			) && array_key_exists(Site::$current_language + 1, self::$data[$key])) {
			if(array_key_exists(2, self::$data[$key]) && self::$data[$key][2] === 1)
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

		die('NO DATA FOR KEY : $data[' . $key . '][' . $language . '] <br>' . \Api\helper::debug_info());

	}

	public static function array_key_exists($key){

		return array_key_exists($key, self::$data);
	}

}