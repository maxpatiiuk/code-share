<?php

namespace Api;


use Data;
use Errors;
use Exception;
use Fields;
use Language;
use mail;
use MainController;
use mysqli;
use mysqli_result;
use mysqli_stmt;
use PostsController;
use sessionManager;
use Site;

class lrp{

	public static function need_login_captcha(){

		return (self::get_failed_logins() >= Site::$showCaptchaAfter)
			? '1'
			: '0';
	}

	private static function get_failed_logins($user_id = NULL,
	                                          $type = 0
	){

		global $sql;

		if($type == 0)
			$type_str = 'IN(0,2)'; else
			$type_str = '= 2';

		if($user_id != NULL)
			return $sql->c('SELECT COUNT(id) FROM dlogins WHERE domain=? AND user=? AND type ' . $type_str . ' AND UNIX_TIMESTAMP() - time < 3600',
			               Site::$domain,
			               $user_id
			);

		$ip = helper::get_user_ip();

		return $sql->c('SELECT COUNT(id) FROM dlogins WHERE domain=? AND ip=? AND type ' . $type_str . ' AND UNIX_TIMESTAMP() - time < 3600',
		               Site::$domain,
		               $ip
		);

	}

	public static function login(){

		if(Data::$main_user !== NULL)
			header('Location: ' . helper::root(''));


		//show login form
		?>

		<div
				class="row"
				xmlns="http://www.w3.org/1999/html">
			<div class="col">
				<form method="post"> <?php

					$args = func_get_args();
					if(array_key_exists(0, $args) && array_key_exists(0, $args[0]) && $args[0][0] === "success")
						helper::alert(Language::get('email_send', 2), 'success');

					helper::input(Language::get('login', 2),
					              'login',
					              'text',
					              TRUE,
					              ['post', 'login'],
					              '',
					              Fields::get('lepLogin'),
					              'autofocus'
					);
					helper::input(Language::get('password', 2),
					              'password',
					              'password',
					              TRUE,
					              ['post', 'password'],
					              '',
					              Fields::get('lPassword')
					);
					helper::input(Language::get('captcha', 2),
					              'captcha',
					              'captcha',
					              FALSE,
					              NULL,
					              NULL,
					              NULL,
					              '',
					              'class="d-none"'
					);
					helper::input('other', 'class="btn-group"');
					helper::input('', 'submit', 'submit', 'btn-dark', Language::get('logIn', 2), '', '');
					helper::input('',
					              '',
					              'a',
					              'btn-light btn-outline-dark',
					              Language::get('register', 2),
					              '',
					              '',
					              'href="' . Site::link('register/') . '"'
					);
					helper::input('',
					              '',
					              'a',
					              'btn-light btn-outline-danger',
					              Language::get('forgotPassword', 2),
					              '',
					              '',
					              'href="' . Site::link(Data::$password_reset_link) . '"'
					);
					helper::input('other', '</div>'); ?>

				</form>
			</div>
		</div>

		<script>
			$( function () {
				forming( $( "#a2submit" ), '<?=Site::link('validate/login')?>', '<?=Site::link()?>', null, "#a2captcha", '<?=Site::link()?>validate/captcha' );
			} );
		</script> <?php

	}

	public static function validate_login(){

		global $field, $sql, $field_data;

		$field_data = ['login' => 'lepLogin', 'password' => 'lPassword',
		];

		$validation_results = self::validate_fields();
		if($validation_results['error'] !== 0)
			return json_encode($validation_results);

		$login = $field['login'];
		$ip = helper::get_user_ip();
		$data = $sql->r("SELECT `id`,`type`,`hash`,`banned_ips`,`register_ip`,`register_date` FROM `dusers` WHERE `login` = ? OR `email` = ? OR `u_phone` = ? LIMIT 1",
		                $login,
		                $login,
		                $login
		);

		if(!is_array($data))
			return self::error(0, 'wrong_password', -1, $ip, 'password', TRUE);

		$password = $field['password'];
		$hash = $data['hash'];

		$unix_time = $_SERVER['REQUEST_TIME'];

		//if is allowed to log in
		$res = self::can_login($ip, $data['register_ip'], $data['id']);
		if(strlen($res) > 0)
			return $res;

		//if captcha is valid
		$res = self::captcha_validate($field, $data['id'], $ip);
		if(strlen($res) > 0)
			return $res;

		//password validation
		if(strlen($hash) < 2 || !password_verify($password . $data['register_date'], $hash))
			return self::error(0, 'wrong_password', $data['id'], $ip, 'password', TRUE);

		//user deleted
		if($data['type'] === 7)
			return self::error(2, 'user_deleted', $data['id'], $ip);

		//user banned
		if($data['type'] === 6)
			return self::error(2, 'user_banned', $data['id'], $ip);

		//check if ip is banned
		$banned_ips = explode(':', $data['banned_ips']);
		if(in_array($ip, $banned_ips))
			return self::error(2, 'user_ip_banned', $data['id'], $ip);

		//setting up session
		sessionManager::destroy_session();
		sessionManager::sessionStart('account', Site::_COOKIE_DURATION_);
		$_SESSION['hash'] = $hash;
		$_SESSION['user_id'] = $data['id'];
		$_SESSION['last_activity'] = $_SERVER['REQUEST_TIME'];

		$sql->a('INSERT INTO `dlogins`(`domain`,`user`,`ip`,`time`) VALUES(?,?,?,?)',
		        Site::$domain,
		        $data['id'],
		        $ip,
		        $unix_time
		);

		return json_encode(['error' => 0]);

	}

	public static function validate_fields(){

		global $field;

		if(count($_POST) === 0)
			return ['error' => 1, 'msg' => 'POST_NOT_SET'];


		$field = $_POST;

		return self::validate_data($field);

	}

	private static function validate_data(&$data){

		global $field_data;

		foreach($field_data as $php_field_name => $this_field_data){

			$optional = FALSE;
			if(is_array($this_field_data)){
				if(array_key_exists(1, $this_field_data))
					$optional = 1 == $this_field_data[1];
				$current_field_data = Fields::get($this_field_data[0]);
			} else
				$current_field_data = Fields::get($this_field_data);

			if(!$optional && !array_key_exists($php_field_name, $data))
				return [['error' => 1], ['custom' => 'No data in POST for key ' . $php_field_name],
				];

			elseif((!$optional || strlen($current_field_data[0]) != 0) && array_key_exists($php_field_name, $data) && !preg_match('/' . $current_field_data[0] . '/',
			                                                                                                                      $data[$php_field_name]
				)) {
				$response['error'] = 1;
				$response[$php_field_name] = $current_field_data;

				return $response;
			}

		}

		foreach($data as $fieldName => $value){

			if(!array_key_exists($fieldName, $field_data))
				continue;

			$optional = FALSE;
			if(is_array($field_data[$fieldName])){
				if(array_key_exists(1, $field_data[$fieldName]))
					$optional = $field_data[$fieldName][1];
				$current_field_data = Fields::get($field_data[$fieldName][0]);
			} else
				$current_field_data = Fields::get($field_data[$fieldName]);

			if(!$optional && !array_key_exists($fieldName, $field_data))
				return [['error' => 1], ['custom' => 'No data in POST for key ' . $fieldName],
				];

			if((!$optional || strlen($current_field_data[0]) != 0) && !preg_match('/' . $current_field_data[0] . '/',
			                                                                      $value
				)){
				$response['error'] = 1;
				$response[$fieldName] = $current_field_data;

				return $response;
			}
		}

		return ['error' => 0];
	}

	private static function error($type,
	                              $reason,
	                              $id,
	                              $ip,
	                              $field = 'custom',
	                              $is_error = TRUE
	){

		global $sql;

		if($id != -1)
			$sql->a('INSERT INTO `dlogins`(`domain`,`user`,`ip`,`time`,`type`,`info`) VALUES(?,?,?,?,?,?)',
			        Site::$domain,
			        $id,
			        $ip,
			        $_SERVER['REQUEST_TIME'],
			        $type,
			        $reason
			);

		$failed_logins0 = self::get_failed_logins($id, 0);
		$max_failed_logins0 = Site::$showCaptchaAfter;
		$captcha = '';
		if($failed_logins0 >= $max_failed_logins0)
			$captcha = "Captcha\n";

		return Errors::to_json($field, $reason, $is_error);
	}

	private static function can_login($ip,
	                                  $register_ip,
	                                  $id
	){

		$failed_logins0 = self::get_failed_logins($id, 0);

		if($register_ip == $ip)
			$max_failed_logins0 = 6; else
			$max_failed_logins0 = 4;

		if($failed_logins0 >= $max_failed_logins0)
			return self::error(0, 'try_later', $id, $ip);

		return '';
	}

	private static function captcha_validate($field,
	                                         $id,
	                                         $ip
	){

		$reCaptchaFailed = TRUE;
		$max_failed_logins2 = Site::$showCaptchaAfter;
		$failed_logins2 = self::get_failed_logins($id, 2);

		if($failed_logins2 >= $max_failed_logins2){
			if(array_key_exists('g-recaptcha-response', $field)){
				$secret = Site::$captchaSecretKey;
				$captcha = $field['g-recaptcha-response'];
				$response_url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&captcha=$captcha&remoteip=$ip";

				$answer = json_decode($response_url, TRUE);
				if($answer['success'])
					$reCaptchaFailed = FALSE;
			} elseif($failed_logins2 <= Site::$hardShowCaptchaAfter)
				$reCaptchaFailed = FALSE;
		} else
			$reCaptchaFailed = FALSE;
		if($reCaptchaFailed)
			return self::error(2, 'captcha_failed', $id, $ip, 'captcha', FALSE);

		return '';
	}

	public static function register(){

		if(Data::$main_user !== NULL)
			header('Location: ' . helper::root(''));

		$args = func_get_args();

		if(array_key_exists(0, $args) && array_key_exists(0, $args[0]) && in_array($args[0][0],
		                                                                           [-1, 0, 5, 6, 7, 8, 9, 10, 11]
			) && Site::$use_classes)
			$class = $args[0][0]; else
			$class = 5;

		if(array_key_exists(0, $args) && array_key_exists(0, $args[0]) && in_array($args[0][0],
		                                                                           [-1, 0, 5, 6, 7, 8, 9, 10, 11]
			) && Site::$use_classes)
			$url_append = 'silent/'; else
			$url_append = ''; ?>

		<div class="row">
			<div class="col">
				<form method="post"> <?php

					helper::input(Language::get('login', 2), 'login', 'text', TRUE, '', '', Fields::get('rlogin'));
					helper::input(Language::get('password', 2),
					              'password',
					              'password',
					              TRUE,
					              '',
					              '',
					              Fields::get('rpassword')
					);
					helper::input(Language::get('dpassword', 2),
					              'dpassword',
					              'password',
					              TRUE,
					              '',
					              '',
					              Fields::get('rdpassword')
					);
					helper::input(Language::get('email', 2), 'email', 'email', TRUE, '', '', Fields::get('remail'));
					if(Site::$use_classes){

						$classes = [[5, 5, 1], [6, 6], [7, 7], [8, 8], [9, 9], [10, 10], [11, 11], [-1, Language::get('graduated')], [0, Language::get('class_undefined')],
						];
						if($class == 0)
							$classes[count($classes) - 1][2] = 1; elseif($class == -1)
							$classes[count($classes) - 2][2] = 1;
						else
							$classes[$class - 5][2] = 1;

						helper::input(Language::get('class', 2),
						              'class',
						              'select',
						              TRUE,
						              $classes,
						              '',
						              Fields::get('rclass')
						);
					}
					helper::input(Language::get('captcha', 2),
					              'captcha',
					              'captcha',
					              FALSE,
					              NULL,
					              NULL,
					              NULL,
					              '',
					              'class="d-none"'
					);
					helper::input('other', 'class="btn-group"');
					helper::input('',
					              'submit',
					              'submit',
					              'btn-dark',
					              Language::get('register', 2),
					              '',
					              '',
					              'type="button"'
					);
					helper::input('',
					              '',
					              'a',
					              'btn-light btn-outline-dark',
					              Language::get('logIn', 2),
					              '',
					              '',
					              'href="' . Site::link('login/') . '"'
					);
					helper::input('other', '</div>'); ?>

				</form>
			</div>
		</div>

		<script>
			$( function () {
				forming( $( "#a2submit" ), '<?=Site::link('validate/register/' . $url_append)?>', '<?=Site::link()?>', null, "#a2captcha", '<?=Site::link()?>validate/r_captcha' );
			} );
		</script> <?php

	}

	public static function validate_register(){

		global $field, $sql, $field_data;


		$args = func_get_args();

		if(array_key_exists(0, $args) && array_key_exists(0, $args[0]) && $args[0][0] === "silent")
			$type = 4; else
			$type = 1;


		$field_data = ['login' => 'rlogin', 'password' => 'rpassword', 'dpassword' => 'rdpassword', 'email' => 'remail', 'class' => ['rclass', Site::$use_classes],
		];

		$validation_results = self::validate_fields();
		if($validation_results['error'] !== 0)
			return json_encode($validation_results);

		$login = $field['login'];
		$password = $field['password'];
		$dpassword = $field['dpassword'];
		$email = $field['email'];
		$ip = helper::get_user_ip();
		$unix_time = $_SERVER['REQUEST_TIME'];

		//if captcha is valid
		if(self::need_register_captcha()){

			$secret = Site::$captchaSecretKey;
			$captcha = $field['g-recaptcha-response'];
			$response_url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&captcha=$captcha&remoteip=$ip";

			$answer = json_decode($response_url, TRUE);
			if(!$answer['success'])
				return Errors::to_json('captcha', 'captcha_is_necessary');

		}


		//check whether login is taken
		$data = $sql->c("SELECT `id` FROM `dusers` WHERE `login` = ?", $login);
		if(strlen($data) !== 0)
			return Errors::to_json('login', 'login_taken');

		//check whether login is forbidden
		if(in_array($login, Data::$forbidden_logins))
			return Errors::to_json('login', 'login_taken');

		//check whether email is taken
		$data = $sql->c("SELECT `id` FROM `dusers` WHERE `email` = ?", $email);
		if(strlen($data) !== 0)
			return Errors::to_json('email', 'email_taken');

		//check whether password == dpassword
		if($password !== $dpassword)
			return Errors::to_json('dpassword', 'password_not_dpassword');

		//check whether password !== login
		if($password === $login)
			return Errors::to_json('password', 'password_is_login');

		//check whether password is not too simple
		if(!helper::is_password_secure($password))
			return Errors::to_json('password_to_simple', 'password_to_simple');

		$parameters = [];
		if(Site::$use_classes){
			if(!array_key_exists('class', $field))
				$class = 0; else
				$class = $field['class'];
			$parameters['class'] = $class;
		}


		$key = '';

		if(Site::$confirmEmail){

			$key = helper::generate_random_string(10);
			$parameters['reset']['confirm_email'] = $key;
		}


		$parameters = json_encode($parameters);

		$hash = password_hash($password . $unix_time, PASSWORD_DEFAULT);

		$sql->a('INSERT INTO `dusers`(`login`,`hash`,`email`,`register_date`,`register_ip`,`parameters`,`type`) VALUES(?,?,?,?,?,?,?)',
		        $login,
		        $hash,
		        $email,
		        $unix_time,
		        $ip,
		        $parameters,
		        $type
		);
		$user_id = $sql->last_insert_id();


		if(Site::$confirmEmail)
			mail::send(Language::get('confirm_email'),
			           Language::get('email_confirm_content'
			           ) . Site::link('confirm/email/user/' . $user_id . '/key/' . $key),
			           Site::_EMAIL_,
			           $email
			);


		sessionManager::destroy_session();
		sessionManager::sessionStart('account', Site::_COOKIE_DURATION_);
		$_SESSION['hash'] = $hash;
		$_SESSION['user_id'] = $user_id;
		$_SESSION['last_activity'] = $_SERVER['REQUEST_TIME'];

		return json_encode(['error' => 0]);
	}

	public static function need_register_captcha(){

		global $sql;

		$registered_accounts = $sql->c('SELECT COUNT(`id`) FROM `dusers` WHERE `register_ip`=? AND `register_date` - UNIX_TIMESTAMP() < 3600',
		                               helper::get_user_ip()
		);

		return $registered_accounts >= Site::$registeredAccountsBeforeCaptcha
			? '1'
			: '0';
	}

	public static function profile(){

		global $sql;
		$args = func_get_args();

		$args = $args[0];
		$profile_id = NULL;
		$is_logged_in = Data::$main_user !== NULL;
		$is_teacher = FALSE;

		if(count($args) != 1 || strlen($args[0]) == 0){

			//id was not specified and user is not logged in
			if(!$is_logged_in)
				helper::redirect('login/');

			//id was not specified but user is logged in
			else
				helper::redirect('profile/@' . Data::$main_user->get('login'));

		}
		//id was specified

		if(is_numeric($args[0]) && $args[0] >= 0)
			$profile_id = $args[0];

		elseif(preg_match('/^@?[\w\.\-]{3,60}$/', $args[0])) {

			if($args[0][0] == '@')
				$login = substr($args[0], 1); else
				$login = $args[0];

			if($is_logged_in && Data::$main_user->get('login') == $login)
				$profile_id = Data::$main_user->get('id'); else
				$profile_id = $sql->c('SELECT `id` FROM `dusers` WHERE `login`=?', $login);
		}

		$is_owner = $is_logged_in && Data::$main_user->get('id') == $profile_id;

		if($is_owner)
			$user = Data::$main_user; else
			$user = new User($profile_id);

		$user->set('*');
		$type = $user->get('type');

		if($type == NULL){
			helper::alert(Language::get('profile_not_found', 2), 'danger');

			return '';
		}

		if($type == 7)
			helper::alert(Errors::get('user_deleted', 2), 'danger'); elseif($type == 6)
			helper::alert(Errors::get('user_banned', 2), 'danger');
		elseif(!$is_owner && ($type == 4 || $type == 5))
			helper::alert(Language::get('profile_not_found', 2), 'danger');
		if((!$is_owner && in_array($type, [4, 5])) || in_array($type, [6, 7]))
			return '';

		if($is_logged_in && in_array(Data::$main_user->get('type'), [2, 5]))
			$is_teacher = TRUE;

		if(!$is_logged_in || (!$is_owner && !$is_teacher)){
			$parameters = $user->get('parameters');
			if($parameters == NULL)
				$parameters = []; else
				$parameters = json_decode($parameters, TRUE);

			$profile_visibility = helper::safeGet('profile_visibility', $parameters, -1);

			if($profile_visibility == 0){
				helper::alert(Language::get('profile_is_private', 2), 'danger');

				return '';
			} elseif($profile_visibility == 1 && !$is_logged_in) {
				helper::alert(Language::get('log_in_to_see_profile', 2), 'danger');

				return '';
			}
		}

		if(!is_numeric($profile_id) || strlen($profile_id) == 0)
			helper::alert(Language::get('profile_not_found', 2), 'danger'); else
			self::display_profile($user, $is_owner, $is_teacher);

		return '';
	}

	public static function display_profile(User $user,
	                                       $is_owner = FALSE,
	                                       $is_teacher = FALSE
	){

		//getting full user name
		$login = $user->get('login');
		$displayed_login = '@' . $login;

		$u_name = $user->get('u_name');

		$isset_name = FALSE;
		$u_full_name = '';
		if(strlen($u_name) != 0){
			$isset_name = TRUE;
			$u_full_name = $u_name;
		}

		//getting user avatar
		$u_ava = $user->get_u_ava();
		$is_default_ava = $u_ava == Site::_DEFAULT_AVA_;
		$ava_class = 'dark_mode_invert';
		if($is_default_ava)
			$ava_class = '';

		//languageLines
		$user_profile_edit = Language::get('edit', 2);
		$user_profile_edit_2 = Language::get('user_profile_edit_2', 2);

		$json = json_decode($user->get('parameters'), TRUE);
		if($json == NULL)
			$json = [];

		$show_last_online = (helper::safeGet('show_last_online', $json, "true") == "true");
		$show_register_date = (helper::safeGet('show_register_date', $json, "true") == "true");

		$mail_visibility = helper::safeGet('email_visibility', $json, "true");

		$class_text = '';
		$class = 0;
		if(Site::$use_classes){

			$class = helper::safeGet('class', $json, 0);
			if($class == 0)
				$class_text = Language::get('class_undefined'); elseif($class == -1)
				$class_text = Language::get('graduated');
			else
				$class_text = $class;

		}

		$t_url_end = '';
		if($is_teacher)
			$t_url_end = $user->get('id') . '/'; ?>

		<script>
			let edit_validate_url = '<?=Site::link('edit/profile/' . $t_url_end)?>';
			text[ "upload_file" ] = <?=json_encode(Language::get('upload_file', 2))?>;
			text[ "choose_file" ] = <?=json_encode(Language::get('choose_file', 2))?>;
			text[ "or_drag_file" ] = <?=json_encode(Language::get('or_drag_file', 2))?>;
			text[ "file_uploading" ] = <?=json_encode(Language::get('file_uploading', 2))?>;
			text[ "file_uploaded" ] = <?=json_encode(Language::get('file_uploaded', 2))?>;
			text[ "error_uploading" ] = <?=json_encode(Language::get('error_uploading', 2))?>;
			text[ "class_undefined" ] = <?=json_encode(Language::get('class_undefined', 2))?>;
			text[ "graduated" ] = <?=json_encode(Language::get('graduated', 2))?>;
		</script>

		<div class="row">
			<div
					class="col"
					data-action="<?= Site::link('edit/profile/' . $t_url_end) ?>"> <?php

				if(Data::$main_user !== NULL){ //is logged in
					?>
					<!-- links section -->
					<div
							class="section shadow text-center"
							id="profile_links"> <?php

						if($is_owner){ ?>
							<a
									href="<?= Site::link('profile/edit/') ?>"
									class="account_link"
									title="<?= Language::get('profile_edit', 1) ?>"><?= Language::get('profile_edit'
								) ?></a>                            <a
									href="<?= Site::link('profile/logout/') ?>"
									class="account_link"
									title="<?= Language::get('log_out',
									                         1
									) ?>"><?= Language::get('log_out') ?></a> <?php
						} elseif($is_teacher) { ?>
							<a
									href="<?= Site::link('profile/edit/' . $user->get('id')) ?>"
									class="account_link"
									title="<?= Language::get('profile_edit', 1) ?>"><?= Language::get('profile_edit'
								) ?></a>                            <a
									href="<?= Site::link('profile/@' . Data::$main_user->get('login')) ?>"
									class="account_link"
									title="<?= Language::get('profile', 1) ?>"><?= Language::get('profile') ?></a>							<a
									href="<?= Site::link('profile/delete/' . $user->get('id')) ?>"
									class="account_link"
									title="<?= Language::get('delete_account',
									                         1
									) ?>"><?= Language::get('delete_account'
								) ?></a>                            <a
									href="<?= Site::link('profile/ban/' . $user->get('id')) ?>"
									class="account_link"
									title="<?= Language::get('ban_user', 1) ?>"><?= Language::get('ban_user'
								) ?></a> <?php
						} else {
							if($mail_visibility != 0){ ?>
								<a
										href="#"
										class="account_link"
										title="<?= Language::get('send_message',
										                         1
										) ?>"><?= Language::get('send_message'
									) ?></a> <?php
							} ?>
							<a
									href="#"
									class="account_link"
									title="<?= Language::get('see_posts', 1) ?>"><?= Language::get('see_posts'
								) ?></a> <?php
						} ?>

					</div> <?php
				} ?>


				<!-- main section -->
				<div
						class="section shadow text-center"
						id="section_main"> <?php

					if($is_owner || $is_teacher){ ?>
						<div class="user_profile_edit op-0 op-ts-1">
							<span title="<?= $user_profile_edit[1] ?>"><?= $user_profile_edit[0] ?></span><span title="<?= $user_profile_edit_2[1] ?>"><?= $user_profile_edit_2[0] ?></span>
						</div> <?php
					} ?>

					<div
							id="user_picture"
							class="zoomable <?= $ava_class ?>"
							style="background-image:url(<?= $u_ava ?>)"></div> <?php

					if($is_owner || $is_teacher) { ?>
					<div
							id="user_picture_edit"
							class="user_profile_edit_center user_profile_edit_hidden user_profile_edit_hovered pt-1 pb-4"
							title="<?= Language::get('user_photo_edit', 1) ?>"
							onclick="modal_edit('image','user_picture')">
						<i class="fas fa-pencil-alt fam"></i><?= Language::get('user_photo_edit', 0) ?>
					</div>

					<div>
						<input
								type="text"
								name="user_name_edit"
								class="user_profile_edit_field user_profile_input_optional"
								placeholder="<?= Language::get('user_name') ?>"
								value="<?= $u_full_name ?>" <?= Fields::get_formatted('p_name') ?>> <?php
						} ?>
						<h2
								id="user_name"
								class="user_profile_not_edit"><?php
							if($isset_name)
								echo $u_full_name; else {
								echo $displayed_login;
								helper::set_seo($displayed_login);
							} ?>
						</h2> <?php

						if($isset_name){ ?>
							<h3
									id="user_login"
									class="user_profile_not_edit"><?= $displayed_login ?></h3> <?php
							helper::set_seo($u_full_name);

							if($is_owner || $is_teacher){ ?>
								<input
										type="text"
										name="user_login_edit"
										class="user_profile_edit_field"
										placeholder="<?= Language::get('login') ?>"
										value="<?= $displayed_login ?>" <?= Fields::get_formatted('rlogin') ?>> <?php
							}
						}
						if($is_owner || $is_teacher){ ?>
					</div> <?php
				} ?>

				</div>

				<!-- contacts section -->
				<div
						class="section shadow"
						id="contacts_section"> <?php

					if($is_owner || $is_teacher){ ?>
						<div class="user_profile_edit op-0 op-ts-1">
							<span title="<?= $user_profile_edit[1] ?>"><?= $user_profile_edit[0] ?></span><span title="<?= $user_profile_edit_2[1] ?>"><?= $user_profile_edit_2[0] ?></span>
						</div> <?php
					} ?>

					<div class="sm_links_section"> <?php

						if($is_owner || $is_teacher || strlen($user->get('u_phone')) >= 0){ ?>
							<div
									class="section_field <?php if(strlen($user->get('u_phone')) < 1)
										echo 'user_profile_edit_hidden'; ?>">
								<h3
										class="section_field_title user_profile_edit_hidden"
										title="<?= Language::get('phone', 1) ?>">
									<label for="phone_edit">
										<?= Language::get('phone') ?>
									</label>
								</h3>
								<input
										id="phone_edit"
										name="phone_edit"
										type="tel"
										pattern="^[\+\d() ]{5,40}$"
										class="user_profile_edit_field user_profile_input_optional"
										value="<?= $user->get('u_phone') ?>" <?= Fields::get_formatted('p_phone') ?>>
								<a
										target="_blank"
										href="sms:<?= $user->get('u_phone') ?>"
										title="<?= Language::get('phone') ?>"
										class="sm_icon sms_link section_field_value user_profile_not_edit"
										style="background-image:url(<?= Site::link(Site::$sm_prefix . '/' . Site::$extra_sm['phone'] . '.svg'
										) ?>)"></a>
							</div> <?php
						}

						if($is_owner || $is_teacher || (Data::$main_user == NULL && $mail_visibility == -1) || $mail_visibility == 1){ ?>
							<div class="section_field">
								<h3
										class="section_field_title user_profile_edit_hidden"
										title="<?= Language::get('email', 1) ?>">
									<label for="email_edit">
										<?= Language::get('email') ?>
									</label>
								</h3>
								<input
										id="email_edit"
										name="email_edit"
										type="email"
										class="user_profile_edit_field"
										value="<?= $user->get('email') ?>" <?= Fields::get_formatted('remail') ?>>
								<a
										target="_blank"
										href="mailto:<?= $user->get('email') ?>"
										title="<?= Language::get('email') ?>"
										class="sm_icon section_field_value user_profile_not_edit"
										style="background-image:url(<?= Site::link(Site::$sm_prefix . '/' . Site::$extra_sm['email'] . '.svg'
										) ?>)"></a>
							</div> <?php
						}

						$u_sm = $user->get('u_sm');
						$u_sm = explode('~', $u_sm);

						$sm_names = array_keys(Site::$sm);
						$sm_regex = Fields::get_formatted('p_sm');

						for($i = 0; $i < count(Site::$sm); $i++){

							if(!$is_owner && !$is_teacher && (!array_key_exists($i, $u_sm) || strlen($u_sm[$i]) < 1))
								continue;

							if(!array_key_exists($i, $u_sm))
								$u_sm[$i] = '';

							if(array_key_exists(1, Site::$sm[$sm_names[$i]]))
								$src = Site::link(Site::$sm_prefix . '/' . Site::$sm[$sm_names[$i]][1] . '.svg'); else
								$src = Site::link(Site::$sm_prefix . '/' . strtolower($sm_names[$i]) . '.svg');

							$url = $u_sm[$i];
							if(!filter_var($u_sm[$i], FILTER_VALIDATE_URL))
								$url = Site::$sm[$sm_names[$i]][0] . $url; ?>

							<div
									class="section_field <?php if(strlen($u_sm[$i]) < 1)
										echo 'user_profile_edit_hidden'; ?>">
								<h3 class="section_field_title user_profile_edit_hidden">
									<label for="sm_<?= $i ?>_edit">
										<?= $sm_names[$i] ?>
									</label>
								</h3>
								<input
										id="sm_<?= $i ?>_edit"
										name="sm_<?= $i ?>_edit"
										data-sm_link="<?= Site::$sm[$sm_names[$i]][0] ?>"
										data-sm_name="<?= $sm_names[$i] ?>"
										type="text"
										class="user_profile_edit_field user_profile_input_optional"
										value="<?= $u_sm[$i] ?>" <?= $sm_regex ?>>
								<a
										target="_blank"
										id="sm_<?= $i ?>"
										href="<?= $url ?>"
										title="<?= $sm_names[$i] ?>"
										class="sm_icon section_field_value user_profile_not_edit dark_mode_invert"
										style="background-image:url(<?= $src ?>)"></a>
							</div> <?php
						}

						?>
					</div>

				</div>

				<!-- information section -->
				<div
						class="section shadow"
						id="information_section"> <?php

					if($is_owner || $is_teacher){ ?>
						<div class="user_profile_edit op-0 op-ts-1">
							<span title="<?= $user_profile_edit[1] ?>"><?= $user_profile_edit[0] ?></span><span title="<?= $user_profile_edit_2[1] ?>"><?= $user_profile_edit_2[0] ?></span>
						</div> <?php
					}

					?>

					<h2
							class="section_title"
							title="<?= Language::get('information', 1) ?>"><?= Language::get('information'
						) ?></h2> <?php

					if($is_owner || $is_teacher || strlen($user->get('u_about')) > 0){ ?>
						<div
								class="section_field <?php if(strlen($user->get('u_about')) < 1)
									echo 'user_profile_edit_hidden'; ?>">
							<h3
									class="section_field_title"
									title="<?= Language::get('about_me', 1) ?>">
								<label for="about_edit">
									<?= Language::get('about_me') ?>
								</label>
							</h3>
							<input
									id="about_edit"
									name="about_edit"
									type="text"
									class="user_profile_edit_field user_profile_input_optional"
									value="<?= $user->get('u_about') ?>" <?= Fields::get_formatted('p_about') ?>>
							<p class="section_field_value"><?= $user->get('u_about') ?></p>
						</div> <?php
					}

					if($is_owner || $is_teacher || $show_last_online){ ?>
						<div
								class="section_field <?php if(!$show_last_online)
									echo "user_profile_edit_hidden"; ?>">
							<h3
									class="section_field_title"
									title="<?= Language::get('last_online', 1) ?>"><?= Language::get('last_online'
								) ?></h3>
							<div class="custom-control custom-checkbox user_profile_edit_hidden mb-4 mt-2">
								<input
										type="checkbox"
										name="online_edit"
										class="custom-control-input user_profile_input_optional"
										id="online_edit" <?php if($show_last_online)
									echo "checked"; ?>>
								<label
										class="custom-control-label"
										for="online_edit">
									<span title="<?= Language::get('show_last_online', 1) ?>">
										<?= Language::get('show_last_online') ?>
									</span> </label>
							</div>
							<p class="section_field_value"><?= helper::format_date($user->get('u_last_online'),
							                                                       'friendlify'
								) ?></p>
						</div> <?php
					}

					if($is_owner || $is_teacher || $user->get('birth_date') > 0){ ?>
						<div
								class="section_field <?php if($user->get('birth_date') < 1)
									echo 'user_profile_edit_hidden'; ?>">
							<h3
									class="section_field_title"
									title="<?= Language::get('birth_date', 1) ?>">
								<label for="birth_edit">
									<?= Language::get('birth_date') ?>
								</label>
							</h3>
							<input
									id="birth_edit"
									name="birth_edit"
									type="date"
									class="user_profile_edit_field user_profile_input_optional"
									min="<?= date('Y-m-d', strtotime('100 years ago')) ?>"
									max="<?= date('Y-m-d') ?>"
									value="<?= helper::format_date($user->get('birth_date'),
									                               'html_input'
									) ?>" <?= Fields::get_formatted('p_date') ?>>
							<p class="section_field_value"><?= helper::format_date($user->get('birth_date'),
							                                                       'friendlify'
								) ?></p>
						</div> <?php
					}

					if($is_owner || $is_teacher || $show_register_date){ ?>
						<div
								class="section_field  <?php if(!$show_register_date)
									echo 'user_profile_edit_hidden'; ?>">
							<h3
									class="section_field_title"
									title="<?= Language::get('register_date', 1) ?>"><?= Language::get('register_date'
								) ?></h3>
							<div class="custom-control custom-checkbox user_profile_edit_hidden mb-4 mt-2">
								<input
										type="checkbox"
										name="register_edit"
										class="custom-control-input user_profile_input_optional"
										id="register_edit" <?php if($show_register_date)
									echo "checked"; ?>>
								<label
										class="custom-control-label"
										for="register_edit">
									<span title="<?= Language::get('show_register_date', 1) ?>">
										<?= Language::get('show_register_date') ?>
									</span> </label>
							</div>
							<p class="section_field_value"><?= helper::format_date($user->get('register_date'),
							                                                       'friendlify'
								) ?></p>
						</div> <?php
					}

					if(Site::$use_classes){ ?>
						<div class="section_field ">
							<h3
									class="section_field_title"
									title="<?= Language::get('class', 1) ?>">
								<label for="class_edit">
									<?= Language::get('class') ?>
								</label>
							</h3>

							<select
									id="class_edit"
									name="class_edit"
									class="user_profile_edit_field form-control" <?= Fields::get_formatted('rclass'
							) ?>> <?
								for($i = 5; $i < 12; $i++){ ?>
									<option
											value="<?= $i ?>" <?php if($class == $i)
										echo 'selected'; ?>><?= $i ?></option> <?php
								} ?>
								<option
										value="0" <?php if($class == 0 || !is_numeric($class))
									echo 'selected'; ?>><?= Language::get('class_undefined') ?></option>
								<option
										value="-1" <?php if($class == -1)
									echo 'selected'; ?>><?= Language::get('graduated') ?></option>
							</select>

							<p class="section_field_value"><?= $class_text ?></p>
						</div> <?php
					} ?>

				</div>

				<!-- personal section -->
				<div
						class="section shadow"
						id="personal_section"> <?php

					if($is_owner || $is_teacher){ ?>
						<div class="user_profile_edit op-0 op-ts-1">
							<span title="<?= $user_profile_edit[1] ?>"><?= $user_profile_edit[0] ?></span><span title="<?= $user_profile_edit_2[1] ?>"><?= $user_profile_edit_2[0] ?></span>
						</div> <?php
					} ?>

					<h2
							class="section_title"
							title="<?= Language::get('personal_life', 1) ?>"><?= Language::get('personal_life'
						) ?></h2> <?php

					if($is_owner || $is_teacher || strlen($user->get('u_city')) > 0){ ?>
						<div
								class="section_field <?php if(strlen($user->get('u_City')) < 1)
									echo 'user_profile_edit_hidden'; ?>">
							<h3
									class="section_field_title"
									title="<?= Language::get('city', 1) ?>">
								<label for="city_edit">
									<?= Language::get('city') ?>
								</label>
							</h3>
							<input
									id="city_edit"
									name="city_edit"
									type="text"
									class="user_profile_edit_field m-auto user_profile_input_optional"
									value="<?= $user->get('u_city') ?>" <?= Fields::get_formatted('p_city') ?>>
							<p class="section_field_value"><?= $user->get('u_city') ?></p>
						</div> <?php
					}

					if($is_owner || $is_teacher || strlen($user->get('u_edu')) > 0){ ?>
						<div
								class="section_field <?php if(($is_owner || $is_teacher) && strlen($user->get('u_edu')
								                                                            ) < 1)
									echo 'user_profile_edit_hidden'; ?>">
							<h3
									class="section_field_title"
									title="<?= Language::get('edu', 1) ?>">
								<label for="edu_edit">
									<?= Language::get('edu') ?>
								</label>
							</h3>
							<input
									id="edu_edit"
									name="edu_edit"
									type="text"
									class="user_profile_edit_field m-auto user_profile_input_optional"
									value="<?= $user->get('u_edu') ?>" <?= Fields::get_formatted('p_edu') ?>>
							<p class="section_field_value"><?= $user->get('u_edu') ?></p>
						</div> <?php
					} ?>

				</div>

			</div>
		</div> <?php

	}

	public static function edit_profile(){

		global $sql;

		$is_logged_in = Data::$main_user !== NULL;

		$args = func_get_args();
		$is_teacher = FALSE;
		if(is_array($args) && array_key_exists(0, $args) && array_key_exists(0, $args[0]) && is_numeric($args[0][0]
			) && $args[0][0] > -1){

			if(!$is_logged_in || !in_array(Data::$main_user->get('type'), [2, 5]))
				return json_encode(['error' => 1, 'msg' => 'access_denied']);

			$is_teacher = 1;
		}

		if(!array_key_exists('type', $_POST))
			return json_encode(['error' => 1, 'msg' => 'post_not_set']);

		if(!$is_logged_in)
			return json_encode(['error' => 1, 'msg' => 'access_denied']); elseif($is_teacher)
			$user = new User($args[0][0]);
		else
			$user = Data::$main_user;

		$type = $_POST['type'];
		unset($_POST['type']);

		$return = [];

		if($type === 'ava'){

			$parameters = json_decode($user->get('parameters'), TRUE);

			if(strlen($user->get('u_ava')) > 1){

				if(array_key_exists('delete_ava', $parameters) && strlen($parameters['delete_ava']) > 0)
					helper::delete_images($parameters['delete_ava'], TRUE); else
					helper::delete_images($user->get('u_ava'));

			}
			//helper::log(3, 'Delete image: ' . $user->get('u_ava'));

			if(!array_key_exists("files", $_FILES) || empty($_FILES["files"]) || $_FILES["files"]['error'] !== 0)
				return json_encode(["error"    => 1, 'error1' => Language::get('error_while_saving'
				                   ), 'error2' => Language::get('error_while_saving', 1),
				                   ]
				);//failed_to_receive_image

			$return = helper::upload_image(base64_encode(file_get_contents($_FILES["files"]["tmp_name"])),
			                               FALSE,
			                               $user->get('id')
			);
			if(!is_array($return))
				return json_encode(["error"    => 1, 'error1' => Language::get('error_while_saving'
				                   ), 'error2' => Language::get('error_while_saving', 1),
				                   ]
				);//failed_to_upload_image

			$ava_src = str_replace('\/', '/', $return[0]);
			$parameters['delete_ava'] = str_replace('\/', '/', $return[1]);
			$parameters = json_encode($parameters);

			$user->update(['u_ava', 'parameters'], [$ava_src, $parameters]);

			return json_encode(['error' => 0, 'src' => $ava_src]);

		} elseif($type === 'profile_edit') {

			$names_of_fields = [];
			$values_of_fields = [];
			$checkboxes = [];

			//                   input_name                 sql_name  field_name
			$array_of_fields = ['user_name_edit' => ['u_name', 'p_name'], 'user_login_edit' => ['login', 'rlogin', 1],//required
			                    'phone_edit'     => ['u_phone', 'p_phone'], 'email_edit' => ['email', 'remail', 1], 'sm' => ['u_sm', 'p_sm'], 'about_edit' => ['u_about', 'p_about'], 'birth_edit' => ['birth_date', 'p_date'], 'city_edit' => ['u_city', 'p_city'], 'edu_edit' => ['u_edu', 'p_edu'], 'class_edit' => ['class', 'rclass', 0, 2]//is stored in parameters col
			];
			$array_of_checkboxes = ['online_edit' => 'show_last_online', 'register_edit' => 'show_register_date',
			];
			$parameters_col = 'parameters';

			$valid = TRUE;
			$is_sm = FALSE;
			$new_email = FALSE;
			$old_email = FALSE;

			$user_sm = $user->get('u_sm');
			$user_sm = explode('~', $user_sm);
			$user_sm_copy = $user_sm;

			foreach($_POST as $key => $value){

				if($key === 'email_edit'){

					if($value == $user->get('email'))
						continue;

					$temp_data = $sql->c("SELECT `id` FROM `dusers` WHERE `email` = ?", $value);
					if(strlen($temp_data) !== 0){
						$valid = FALSE;
						$error_data = Errors::get('email_taken', 2);
						$return[$key] = ['', $error_data[0], $error_data[1]];
					}

					$new_email = $value;
					$old_email = $user->get('email');
				}

				if(substr($key, 0, 3) === "sm_"){
					$is_sm = TRUE;
					$key = substr($key, 0, strlen($key) - 5);
				}

				if($key === 'user_login_edit'){

					if($value == $user->get('login'))
						continue;

					if(in_array($value, Data::$forbidden_logins)){
						$valid = FALSE;
						$error_data = Errors::get('login_taken', 2);
						$return[$key] = ['', $error_data[0], $error_data[1]];
					}

					$temp_data = $sql->c("SELECT `id` FROM `dusers` WHERE `login` = ?", $value);
					if(strlen($temp_data) !== 0){
						$valid = FALSE;
						$error_data = Errors::get('login_taken', 2);
						$return[$key] = ['', $error_data[0], $error_data[1]];
					}
				}

				if(!is_bool($value) && array_key_exists($key, $array_of_fields) || $is_sm){

					if($is_sm)
						$field_data = Fields::get("p_sm"); else
						$field_data = Fields::get($array_of_fields[$key][1]);

					if(((!$is_sm && array_key_exists(2, $array_of_fields[$key]) && $array_of_fields[$key][2] === 1) || strlen($value) !== 0) && !preg_match('/' . $field_data[0] . '/', $value) && $key !== 'birth_edit'){
						$valid = FALSE;
						$return[$key] = $field_data;
					} elseif(!$is_sm && array_key_exists(3, $array_of_fields[$key]) && $array_of_fields[$key][3] === 2)
						$checkboxes[$array_of_fields[$key][0]] = $value;

					else {
						if($key === 'birth_edit')
							$value = strtotime($value);
						if($is_sm)
							$user_sm[substr($key, 3)] = $value; else {
							$names_of_fields[] = $array_of_fields[$key][0];
							$values_of_fields[] = $value;
						}
					}
					$is_sm = FALSE;

				} else
					$checkboxes[$array_of_checkboxes[$key]] = $value;
			}

			if($valid){
				if(count($checkboxes) > 0){
					$json = json_decode($user->get('parameters'), TRUE);
					$names_of_fields[] = $parameters_col;

					foreach($checkboxes as $key => $value)
						$json[$key] = $value;
					$values_of_fields[] = json_encode($json);
				}

				if($user_sm != $user_sm_copy){
					$names_of_fields[] = 'u_sm';
					$values_of_fields[] = implode('~', $user_sm);
				}

				$user->update($names_of_fields, $values_of_fields);

				if($new_email !== FALSE && $old_email !== FALSE && !$is_teacher){
					$key = helper::generate_random_string(10);
					$key2 = helper::generate_random_string(10);

					$json = json_decode($user->get('parameters'), TRUE);
					$json['reset']['confirm_email'] = $key;
					$json['reset']['reset_email'] = $key2;
					$json = json_encode($json);
					$user->update('parameters', $json);

					mail::send(Language::get('email_change'),
					           mail::content(Language::get('email_change'),
					                         Language::get('email_changed_email'
					                         ) . ' ' . Site::link('reset/email/user/' . $user->get('id'
					                                              ) . '/key/' . $key2
					                         ) . "\n" . Language::get('email_changed_email_2') . ' ' . $new_email
					           ),
					           Site::_EMAIL_,
					           $old_email
					);
					if(Site::$confirmEmail)
						mail::send(Language::get('confirm_email'),
						           mail::content(Language::get('confirm_email'),
						                         Language::get('email_confirm_content'
						                         ) . ' ' . Site::link('confirm/email/user/' . $user->get('id'
						                                              ) . '/key/' . $key
						                         )
						           ),
						           Site::_EMAIL_,
						           $new_email
						);
				}

				$return['error'] = 0;
			} else
				$return['error'] = 1;
		}

		return json_encode($return);
	}

	public static function advanced_edit_profile(){

		$user = Data::$main_user;

		if($user === NULL){
			helper::alert(Language::get('access_denied', 2), 'danger');

			return FALSE;
		}

		$args = func_get_args();
		$is_teacher = is_array($args) && array_key_exists(0, $args) && array_key_exists(0,
		                                                                                $args[0]
			) && is_numeric($args[0][0]) && $args[0][0] > -1;

		if($is_teacher)
			$user = new User($args[0][0]);

		$user->set('*');

		//languageLines
		$user_profile_edit_2 = Language::get('user_profile_edit_2', 2);

		$json = json_decode($user->get('parameters'), TRUE);
		if($json == NULL)
			$json = [];

		$mail_subscribed = (helper::safeGet('mail_subscribed', $json, "true") == "true");

		//-1 - all
		//1 - registered
		//0 - none
		$profile_visibility = (helper::safeGet('profile_visibility', $json, 2));
		$email_visibility = (helper::safeGet('email_visibility', $json, 2));
		if(Site::$is_dark_theme === TRUE)
			$dark_theme = FALSE; else
			$dark_theme = (helper::safeGet('dark_theme', $json, FALSE) == "true"); ?>

		<script>
			let edit_validate_url = '<?=Site::link('edit/profile/advanced/')?>';
			let mono_success_function = true;
			text[ "saved" ] = "<?=Language::get('saved')?>";
		</script>

		<div class="row">
			<div
					class="col"
					data-action="<?= Site::link('edit/profile/advanced/') ?>">

				<!-- links section-->
				<div
						class="section shadow text-center"
						id="profile_links"> <?php


					if($is_teacher){ ?>
						<a
								href="<?= Site::link('profile/@' . $user->get('login')) ?>"
								class="account_link"
								title="<?= Language::get('return_to_profile',
								                         1
								) ?>"><?= Language::get('return_to_profile'
							) ?></a>                        <a
								href="<?= Site::link('profile/@' . Data::$main_user->get('login')) ?>"
								class="account_link"
								title="<?= Language::get('profile', 1) ?>"><?= Language::get('profile') ?></a>						<a
								href="<?= Site::link('profile/delete/' . $user->get('id')) ?>"
								class="account_link"
								title="<?= Language::get('delete_account', 1) ?>"><?= Language::get('delete_account'
							) ?></a>                        <a
								href="<?= Site::link('profile/ban/' . $user->get('id')
								) ?>"
								class="account_link"
								title="<?= Language::get('ban_user',
								                         1
								) ?>"><?= Language::get('ban_user') ?></a> <?php
					} else { ?>
						<a
								href="<?= Site::link('profile/@' . $user->get('login')) ?>"
								class="account_link"
								title="<?= Language::get('return_to_profile',
								                         1
								) ?>"><?= Language::get('return_to_profile'
							) ?></a>                        <a
								href="<?= Site::link('profile/logout/') ?>"
								class="account_link"
								title="<?= Language::get('log_out',
								                         1
								) ?>"><?= Language::get('log_out') ?></a> <?php
					} ?>

				</div>

				<!-- password section -->
				<div
						class="section editing shadow"
						id="password_section">

					<div class="user_profile_edit user_profile_mono_edit op-0 op-ts-1">
						<span title="<?= $user_profile_edit_2[1] ?>"><?= $user_profile_edit_2[0] ?></span>
					</div>

					<h2
							class="section_title"
							title="<?= Language::get('password_change', 1) ?>"><?= Language::get('password_change'
						) ?></h2>

					<div class="section_field">
						<h3
								class="section_field_title"
								title="<?= Language::get('old_password', 1) ?>">
							<label for="old_password_edit">
								<?= Language::get('old_password') ?>
							</label>
						</h3>
						<input
								id="old_password_edit"
								name="old_password_edit"
								type="password"
								class="user_profile_edit_field" <?= Fields::get_formatted('lPassword') ?>>
					</div>

					<div class="section_field">
						<h3
								class="section_field_title"
								title="<?= Language::get('password', 1) ?>">
							<label for="new_password_edit">
								<?= Language::get('password') ?>
							</label>
						</h3>
						<input
								id="new_password_edit"
								name="new_password_edit"
								type="password"
								class="user_profile_edit_field" <?= Fields::get_formatted('rpassword') ?>>
					</div>

					<div class="section_field">
						<h3
								class="section_field_title"
								title="<?= Language::get('dpassword', 1) ?>">
							<label for="d_new_password_edit">
								<?= Language::get('dpassword') ?>
							</label>
						</h3>
						<input
								id="d_new_password_edit"
								name="d_new_password_edit"
								type="password"
								class="user_profile_edit_field" <?= Fields::get_formatted('rdpassword') ?>>
					</div>

				</div>

				<!-- email section -->
				<div
						class="section editing shadow"
						id="email_section">

					<div class="user_profile_edit user_profile_mono_edit op-0 op-ts-1">
						<span title="<?= $user_profile_edit_2[1] ?>"><?= $user_profile_edit_2[0] ?></span>
					</div>

					<div class="section_field">
						<h3
								class="section_field_title"
								title="<?= Language::get('notifications', 1) ?>"><?= Language::get('notifications'
							) ?></h3>
						<div class="custom-control custom-checkbox user_profile_edit_hidden mb-4 mt-2">
							<input
									type="checkbox"
									name="receive_newsletters"
									class="custom-control-input user_profile_input_optional"
									id="receive_newsletters" <?php if($mail_subscribed)
								echo "checked"; ?>>
							<label
									class="custom-control-label"
									for="receive_newsletters">
								<span title="<?= Language::get('receive_newsletters', 1) ?>">
									<?= Language::get('receive_newsletters') ?>
								</span> </label>
						</div>
					</div>

					<div class="section_field">
						<h3
								class="section_field_title"
								title="<?= Language::get('email_visibility', 1) ?>">
							<label for="email_visibility">
								<?= Language::get('email_visibility') ?>
							</label>
						</h3>
						<select
								id="email_visibility"
								name="email_visibility"
								class="user_profile_edit_field form-control" <?= Fields::get_formatted('email_visibility'
						) ?>>
							<option
									value="-1" <?php if($email_visibility == -1 || !is_numeric($email_visibility))
								echo 'selected'; ?>><?= Language::get('type_min_1') ?></option>
							<option
									value="1" <?php if($email_visibility == 1)
								echo 'selected'; ?>><?= Language::get('type_1') ?></option>
							<option
									value="0" <?php if($email_visibility == 0)
								echo 'selected'; ?>><?= Language::get('type_0') ?></option>
						</select>
					</div>

				</div>

				<!-- account section -->
				<div
						class="section editing shadow"
						id="account_section">

					<div class="user_profile_edit user_profile_mono_edit op-0 op-ts-1">
						<span title="<?= $user_profile_edit_2[1] ?>"><?= $user_profile_edit_2[0] ?></span>
					</div>

					<div class="section_field">
						<h3
								class="section_field_title"
								title="<?= Language::get('profile_visibility', 1) ?>">
							<label for="profile_visibility">
								<?= Language::get('profile_visibility') ?>
							</label>
						</h3>
						<select
								id="profile_visibility"
								name="profile_visibility"
								class="user_profile_edit_field form-control" <?= Fields::get_formatted('profile_visibility'
						) ?>>
							<option
									value="-1" <?php if($profile_visibility == -1 || !is_numeric($profile_visibility))
								echo 'selected'; ?>><?= Language::get('type_min_1') ?></option>
							<option
									value="1" <?php if($profile_visibility == 1)
								echo 'selected'; ?>><?= Language::get('type_1') ?></option>
							<option
									value="0" <?php if($profile_visibility == 0)
								echo 'selected'; ?>><?= Language::get('type_0') ?></option>
						</select>
					</div> <?php

					if(Site::$is_dark_theme == FALSE){ ?>
						<div class="section_field">
							<h3
									class="section_field_title"
									title="<?= Language::get('dark_theme', 1) ?>"><?= Language::get('dark_theme'
								) ?></h3>
							<div class="custom-control custom-checkbox user_profile_edit_hidden mb-4 mt-2">
								<input
										type="checkbox"
										name="dark_theme"
										class="custom-control-input user_profile_input_optional"
										id="dark_theme" <?php if($dark_theme)
									echo "checked"; ?>>
								<label
										class="custom-control-label"
										for="dark_theme">
								<span title="<?= Language::get('dark_theme', 1) ?>">
									<?= Language::get('dark_theme') ?>
								</span> </label>
							</div>
						</div> <?php
					} ?>

					<div class="section_field">
						<h3
								class="section_field_title"
								title="<?= Language::get('delete_account', 1) ?>"><?= Language::get('delete_account'
							) ?></h3>
						<a
								class="text-danger"
								href="<?= Site::link('profile/delete/') ?>"
								title="<?= Language::get('delete_account', 1) ?>"><?= Language::get('delete_account'
							) ?></a>
					</div>

				</div>

			</div>
		</div> <?php


		return TRUE;
	}

	public static function edit_profile_advanced(){

		if(!array_key_exists('type', $_POST))
			return 'false';

		$user = Data::$main_user;

		if($user === NULL){
			helper::alert(Language::get('access_denied', 2), 'danger');

			return FALSE;
		}

		$args = func_get_args();
		$is_teacher = is_array($args) && array_key_exists(0, $args) && array_key_exists(0,
		                                                                                $args[0]
			) && is_numeric($args[0][0]) && $args[0][0] > -1;

		if($is_teacher)
			$user = new User($args[0][0]);

		$type = $_POST['type'];
		unset($_POST['type']);

		$return = [];

		if($type === 'profile_edit'){

			$names_of_fields = [];
			$values_of_fields = [];
			$checkboxes = [];

			//                   input_name                 sql_name  field_name
			$array_of_fields = ['old_password_edit'  => ['hash', 'lPassword', 1],//required
			                    'new_password_edit'  => ['hash', 'rpassword', 1], 'd_new_password_edit' => ['hash', 'rdpassword', 1], 'email_visibility' => ['email_visibility', 'email_visibility', 1, 2],//parameters field
			                    'profile_visibility' => ['profile_visibility', 'profile_visibility', 1, 2],
			];
			$array_of_checkboxes = ['receive_newsletters' => 'mail_subscribed', 'dark_theme' => 'dark_theme',
			];
			$parameters_col = 'parameters';

			$valid = TRUE;

			foreach($_POST as $key => $value){

				if(!is_bool($value) && array_key_exists($key, $array_of_fields)){

					$field_data = Fields::get($array_of_fields[$key][1]);

					if(((array_key_exists(2, $array_of_fields[$key]) && $array_of_fields[$key][2] === 1) || strlen($value) !== 0) && !preg_match('/' . $field_data[0] . '/', $value)){
						$valid = FALSE;
						$return[$key] = $field_data;
					} elseif(array_key_exists(3, $array_of_fields[$key]) && $array_of_fields[$key][3] === 2)
						$checkboxes[$array_of_fields[$key][0]] = $value;
					else {
						$names_of_fields[] = $array_of_fields[$key][0];
						$values_of_fields[] = $value;
					}
				} else
					$checkboxes[$array_of_checkboxes[$key]] = $value;
			}

			$hashes = array_keys($names_of_fields, 'hash', TRUE);
			if(count($hashes) == 3){

				if($values_of_fields[$hashes[1]] != $values_of_fields[$hashes[2]]){
					$valid = FALSE;
					$return['d_new_password_edit'] = Fields::get('passwords_mismatch');
				} elseif(!password_verify($values_of_fields[$hashes[0]] . $user->get('register_date'),
				                          $user->get('hash')
				)) {
					$valid = FALSE;
					$return['old_password_edit'] = Fields::get('lPassword');
				} elseif(password_verify($values_of_fields[$hashes[1]] . $user->get('register_date'),
				                         $user->get('hash')
				)) {
					$valid = FALSE;
					$error_data = Errors::get('same_password', 2);
					$return['old_password_edit'] = ['', $error_data[0], $error_data[1]];
				}
			}

			if($valid){
				if(count($checkboxes) > 0){
					$json = json_decode($user->get($parameters_col), TRUE);
					$names_of_fields[] = $parameters_col;

					foreach($checkboxes as $key => $value)
						$json[$key] = $value;
					$values_of_fields[] = json_encode($json);

				}

				if(count($hashes) == 3){
					$hash = password_hash($values_of_fields[$hashes[1]] . $user->get('register_date'),
					                      PASSWORD_DEFAULT
					);

					for($i = 0; $i < 3; $i++){
						unset($names_of_fields[$hashes[$i]]);
						unset($values_of_fields[$hashes[$i]]);
					}

					$key = helper::generate_random_string(10);
					$index = array_search($parameters_col, $names_of_fields, TRUE);

					if($index !== FALSE)
						$json = json_decode($values_of_fields[$index], TRUE); else
						$json = json_decode($user->get($parameters_col), TRUE);

					$json['reset']['reset_password'] = $key;

					if($index !== FALSE)
						$values_of_fields[$index] = json_encode($json); else {
						$names_of_fields[] = $parameters_col;
						$values_of_fields[] = json_encode($json);
					}

					$_SESSION['hash'] = $hash;

					mail::send(Language::get('password_change'),
					           mail::content(Language::get('password_change'),
					                         Language::get('password_changed_email') . Site::link('reset/password/user/' . $user->get('id'
					                                                                              ) . '/key/' . $key
					                         )
					           ),
					           Site::_EMAIL_,
					           $user->get('email')
					);

					$names_of_fields[] = 'hash';
					$values_of_fields[] = $hash;
				}

				if(count($names_of_fields) != 0)
					$user->update($names_of_fields, $values_of_fields);

				if(array_key_exists('dark_theme', $_POST) && Site::$is_dark_theme === FALSE){
					if($_POST['dark_theme'] == "true")
						$_SESSION['dark_theme'] = 1; else
						$_SESSION['dark_theme'] = 0;
				}

				$return['error'] = 0;
			} else
				$return['error'] = 1;
		}

		return json_encode($return);
	}

	public static function log_out(){

		sessionManager::destroy_session();
		helper::redirect(); ?>
		<div class="row">
			<div class="col"><?php
				helper::alert(Language::get('redirect', 2), 'info'); ?>
			</div>
		</div> <?php
	}

	public static function confirm_email($id,
	                                     $key
	){

		if(Data::$main_user != NULL && Data::$main_user->get('id') == $id)
			$user = Data::$main_user; else {
			$user = new User($id);
		}
		$parameters = $user->get('parameters');
		$parameters = json_decode($parameters, TRUE);

		if($parameters === NULL || !array_key_exists('reset', $parameters) || !array_key_exists('confirm_email',
		                                                                                        $parameters['reset']
			) || $parameters['reset']['confirm_email'] != $key){
			helper::alert(Language::get('invalid_link', 2), 'danger');

			return FALSE;
		}

		unset($parameters['reset']['confirm_email']);

		$parameters = json_encode($parameters);
		$user->update('parameters', $parameters);
		?>
		<div class="row">
			<div class="col"> <?php

				helper::alert(Language::get('email_confirmed', 2), 'success'); ?>

			</div>
		</div>  <?php

		return TRUE;

	}

	public static function reset_email($id,
	                                   $key
	){

		if(Data::$main_user != NULL && Data::$main_user->get('id') == $id)
			$parameters = Data::$main_user->get('parameters'); else {
			$user = new User($id);
			$parameters = $user->get('parameters');
		}
		$parameters = json_decode($parameters, TRUE);

		if($parameters !== NULL && !array_key_exists('reset', $parameters) || !array_key_exists('reset_email',
		                                                                                        $parameters['reset']
			) || $parameters['reset']['reset_email'] != $key)
			helper::alert(Language::get('invalid_link', 2), 'danger'); else { ?>

			<div class="row">
				<form class="col">

					<h1
							class="mb-4"
							title="<?= Language::get('reset_email', 2) ?>"><?= Language::get('reset_email'
						) ?></h1><?php

					helper::input(Language::get('new_email', 2),
					              'email',
					              'email',
					              TRUE,
					              '',
					              '',
					              Fields::get('remail')
					);
					helper::input(Language::get('new_password', 2),
					              'password',
					              'password',
					              TRUE,
					              '',
					              '',
					              Fields::get('rpassword')
					);
					helper::input(Language::get('dpassword', 2),
					              'dpassword',
					              'password',
					              TRUE,
					              '',
					              '',
					              Fields::get('rdpassword')
					);
					helper::input('', 'submit', 'submit', 'btn-dark', Language::get('edit', 2), '', ''); ?>

					<script>
						$( function () {
							forming( $( "#a2submit" ), '<?=Site::link('validate/reset/email/user/' . $id . '/key/' . $key
							)?>', '<?=Site::link('profile/' . $id)?>' );
						} );
					</script>

				</form>
			</div>  <?php
		}

	}

	public static function reset_password($id,
	                                      $key
	){

		if(Data::$main_user != NULL && Data::$main_user->get('id') == $id)
			$parameters = Data::$main_user->get('parameters'); else {
			$user = new User($id);
			$parameters = $user->get('parameters');
		}
		$parameters = json_decode($parameters, TRUE);

		if($parameters !== NULL && !array_key_exists('reset', $parameters) || !array_key_exists('reset_password',
		                                                                                        $parameters['reset']
			) || $parameters['reset']['reset_password'] != $key)
			helper::alert(Language::get('invalid_link', 2), 'danger');

		else { ?>

			<div class="row">
				<form class="col">

					<h1
							class="mb-4"
							title="<?= Language::get('change_password', 2) ?>"><?= Language::get('change_password'
						) ?></h1><?php

					helper::input(Language::get('password', 2),
					              'password',
					              'password',
					              TRUE,
					              '',
					              '',
					              Fields::get('rpassword')
					);
					helper::input(Language::get('dpassword', 2),
					              'dpassword',
					              'password',
					              TRUE,
					              '',
					              '',
					              Fields::get('rdpassword')
					);
					helper::input('', 'submit', 'submit', 'btn-dark', Language::get('edit', 2), '', ''); ?>

					<script>
						$( function () {
							forming( $( "#a2submit" ), '<?=Site::link('validate/reset/password/user/' . $id . '/key/' . $key
							)?>', '<?=Site::link('profile/' . $id)?>' );
						} );
					</script>

				</form>
			</div>  <?php
		}

	}

	public static function change_password(){ ?>

		<div class="row">
			<form class="col">

				<h1
						class="mb-4"
						title="<?= Language::get('change_password', 2) ?>"><?= Language::get('change_password'
					) ?></h1><?php

				helper::input(Language::get('email', 2), 'email', 'email', TRUE, '', '', Fields::get('remail'));
				helper::input('', 'submit', 'submit', 'btn-dark', Language::get('send', 2), '', ''); ?>

				<script>
					$( function () {
						forming( $( "#a2submit" ), '<?=Site::link('validate/change/password/'
						)?>', '<?=Site::link('login/success/')?>' );
					} );
				</script>

			</form>
		</div>  <?php

	}

	public static function validate_reset_email($id,
	                                            $key
	){

		global $field_data, $field, $sql;

		$user = new User($id);
		$parameters = $user->get('parameters');
		$parameters = json_decode($parameters, TRUE);
		if($parameters === NULL || !array_key_exists('reset', $parameters) || !array_key_exists('reset_email',
		                                                                                        $parameters['reset']
			) || $parameters['reset']['reset_email'] != $key)
			return json_encode(['error' => 1, 'msg' => 'invalid_link']);

		$field_data = ['email' => 'remail', 'password' => 'rpassword', 'dpassword' => 'rdpassword',
		];

		$validation_results = self::validate_fields();
		if($validation_results['error'] !== 0)
			return json_encode($validation_results);

		$email = $field['email'];
		$password = $field['password'];
		$dpassword = $field['dpassword'];

		//check whether email is taken
		$data = $sql->c("SELECT `id` FROM `dusers` WHERE `email` = ?", $email);
		if(strlen($data) !== 0)
			return Errors::to_json('email', 'email_taken');

		//check whether password == dpassword
		if($password !== $dpassword)
			return Errors::to_json('dpassword', 'password_not_dpassword');

		//check whether password is not too simple
		if(!helper::is_password_secure($password))
			return Errors::to_json('password_to_simple', 'password_to_simple');

		unset($parameters['reset']['reset_email']);

		$parameters = json_encode($parameters);

		$hash = password_hash($password . $user->get('register_date'), PASSWORD_DEFAULT);

		sessionManager::destroy_session();
		sessionManager::sessionStart('account', Site::_COOKIE_DURATION_);
		$_SESSION['hash'] = $hash;
		$_SESSION['user_id'] = $id;
		$_SESSION['last_activity'] = $_SERVER['REQUEST_TIME'];

		$keys = ['parameters', 'email', 'hash'];
		$values = [$parameters, $email, $hash];
		$user->update($keys, $values);

		return json_encode(['error' => 0]);
	}

	public static function validate_reset_password($id,
	                                               $key
	){

		global $field_data, $field;

		$user = new User($id);
		$parameters = $user->get('parameters');
		$parameters = json_decode($parameters, TRUE);
		if($parameters !== NULL && !array_key_exists('reset', $parameters) || !array_key_exists('reset_password',
		                                                                                        $parameters['reset']
			) || $parameters['reset']['reset_password'] != $key)
			return json_encode(['error' => 1, 'msg' => 'invalid_link']);

		$field_data = ['password' => 'rpassword', 'dpassword' => 'rdpassword',
		];

		$validation_results = self::validate_fields();
		if($validation_results['error'] !== 0)
			return json_encode($validation_results);

		$password = $field['password'];
		$dpassword = $field['dpassword'];

		//check whether password == dpassword
		if($password !== $dpassword)
			return Errors::to_json('dpassword', 'password_not_dpassword');

		//check whether password is not too simple
		if(!helper::is_password_secure($password))
			return Errors::to_json('password_to_simple', 'password_to_simple');

		unset($parameters['reset']['reset_password']);

		$parameters = json_encode($parameters);

		$hash = password_hash($password . $user->get('register_date'), PASSWORD_DEFAULT);

		sessionManager::destroy_session();
		sessionManager::sessionStart('account', Site::_COOKIE_DURATION_);
		$_SESSION['hash'] = $hash;
		$_SESSION['user_id'] = $id;
		$_SESSION['last_activity'] = $_SERVER['REQUEST_TIME'];

		$keys = ['parameters', 'hash'];
		$values = [$parameters, $hash];
		$user->update($keys, $values);

		return json_encode(['error' => 0]);
	}

	public static function validate_change_password(){

		global $field_data, $field, $sql;

		$field_data = ['email' => 'remail',
		];

		$validation_results = self::validate_fields();
		if($validation_results['error'] !== 0)
			return json_encode($validation_results);

		$email = $field['email'];

		[$id, $parameters] = array_values($sql->r('SELECT `id`,`parameters` FROM `dusers` WHERE `email` = ?', $email));
		if($parameters == NULL)
			return json_encode(['error' => 1, 'msg' => 'invalid_link']);

		$parameters = json_decode($parameters, TRUE);
		$key = helper::generate_random_string(10);
		$parameters['reset']['reset_password'] = $key;
		mail::send(Language::get('change_password'),
		           mail::content(Language::get('change_password'),
		                         Language::get('password_changed_email'
		                         ) . Site::link('reset/password/user/' . $id . '/key/' . $key)
		           ),
		           Site::_EMAIL_,
		           $email
		);

		$parameters = json_encode($parameters);
		$sql->a('UPDATE `dusers` SET `parameters` = ? WHERE `email` = ?', $parameters, $email);

		return json_encode(['error' => 0]);
	}

	public static function delete_user(){

		MainController::actionHeader();

		if(Data::$main_user == NULL){
			helper::redirect('login');

			return FALSE;
		}

		$args = func_get_args();
		if(is_array($args) && array_key_exists(0, $args) && array_key_exists(0, $args[0]) && is_numeric($args[0][0]
			) && $args[0][0] > -1 && in_array(Data::$main_user->get('type'),
		                                      [2, 5]
		   ) && $args[0][0] != Data::$main_user->get('id'))
			$user = new User($args[0][0]); else
			$user = Data::$main_user;

		$user_name = $user->get_full_name();

		if(strlen($user_name) == 0){
			helper::alert(Language::get('profile_not_found', 2), 'danger');

			return FALSE;
		} ?>

		<h1
				class="mb-4"
				title="<?= Language::get('delete_user_confirmation',
				                         1
				) ?>"><?= Language::get('delete_user_confirmation'
			) ?></h1>

		<p><?= $user_name ?></p>

		<a
				href="<?= Site::link('profile/@' . $user->get('login')) ?>"
				class="btn btn-dark"
				title="<?= Language::get('no', 1) ?>"><?= Language::get('no') ?></a>
		<button
				id="delete_user"
				class="btn btn-danger"
				title="<?= Language::get('yes', 1) ?>"><?= Language::get('yes') ?></button>

		<script>
			$( "#delete_user" ).click( function () {
				$.ajax( {
					method : "POST",
					url : site_url + 'delete/profile/<?=$user->get('id')?>',
				} ).done( function ( msg ) {
						msg = JSON.parse( msg );
						if ( msg.error !== 0 && msg.error !== "0" ) {
							alert( text[ "error_while_getting_data" ] );
							mail_error( "Unable to accept changes. Ajax failed", [ msg, sorting_data ] );
						} else
							window.location.href = "<?=Site::link()?>";
					} )
					.fail( function ( xhr, ajaxOptions, thrownError ) {
						alert( "Виникла помилка при видалені користувача. Спробуйте пізніше" );
						mail_error( "Unable to delete user. Ajax failed", [ xhr, ajaxOptions, thrownError ] );
					} );
			} );
		</script><?php

		return TRUE;
	}

	public static function user_deleted(){

		global $sql;

		if(Data::$main_user == NULL)
			return json_encode(['error' => 1, 'msg' => 'not_logged_in']);

		$args = func_get_args();
		if(is_array($args) && array_key_exists(0, $args) && array_key_exists(0, $args[0]) && is_numeric($args[0][0]
			) && $args[0][0] > -1 && (in_array(Data::$main_user->get('type'),
		                                       [2, 5]
			                          ) || $args[0][0] == Data::$main_user->get('id')))
			$user = new User($args[0][0]); else
			return json_encode(['error' => 1, 'msg' => 'invalid_id']);

		$user_name = $user->get_full_name();

		if(strlen($user_name) == 0)
			return json_encode(['error' => 1, 'msg' => 'profile_not_found']);

		$posts = $sql->res2data($sql->a('SELECT `id` FROM `dposts` WHERE `creator_id` = ?', $user->get('id')));

		foreach($posts as $post_data)
			PostsController::actionDeleted($post_data['id']);

		$sql->a('UPDATE `dusers` SET `type` = 7 WHERE `id` = ?', $user->get('id'));

		return json_encode(['error' => 0]);
	}

	public static function ban_user(){

		MainController::actionHeader();

		if(Data::$main_user == NULL){
			helper::redirect('login');

			return FALSE;
		}

		$args = func_get_args();
		if(is_array($args) && array_key_exists(0, $args) && array_key_exists(0, $args[0]) && is_numeric($args[0][0]
			) && $args[0][0] > -1 && in_array(Data::$main_user->get('type'),
		                                      [2, 5]
		   ) && $args[0][0] != Data::$main_user->get('id'))
			$user = new User($args[0][0]); else
			$user = Data::$main_user;

		$user_name = $user->get_full_name();

		if(strlen($user_name) == 0){
			helper::alert(Language::get('profile_not_found', 2), 'danger');

			return FALSE;
		} ?>

		<h1
				class="mb-4"
				title="<?= Language::get('ban_user_confirmation', 1) ?>"><?= Language::get('ban_user_confirmation'
			) ?></h1>

		<p><?= $user_name ?></p>

		<a
				href="<?= Site::link('profile/@' . $user->get('login')) ?>"
				class="btn btn-dark"
				title="<?= Language::get('no', 1) ?>"><?= Language::get('no') ?></a>
		<button
				id="ban_user"
				class="btn btn-danger"
				title="<?= Language::get('yes', 1) ?>"><?= Language::get('yes') ?></button>

		<script>
			$( "#ban_user" ).click( function () {
					$.ajax( {
						method : "POST",
						url : site_url + 'ban/profile/<?=$user->get('id')?>',
					} ).done( function ( msg ) {
						msg = JSON.parse( msg );
						if ( msg.error !== 0 && msg.error !== "0" ) {
							alert( text[ "error_while_getting_data" ] );
							mail_error( "Unable to accept changes. Ajax failed", [ msg, sorting_data ] );
						} else
							window.location.href = "<?=Site::link()?>";
					} );
				} )
				.fail( function ( xhr, ajaxOptions, thrownError ) {
					alert( "Виникла помилка при блокуванні користувача. Спробуйте пізніше" );
					mail_error( "Unable to ban user. Ajax failed", [ xhr, ajaxOptions, thrownError ] );
				} );
		</script><?php

		return TRUE;
	}

	public static function user_baned(){

		global $sql;

		if(Data::$main_user == NULL){
			helper::redirect('login');

			return FALSE;
		}

		$args = func_get_args();
		if(is_array($args) && array_key_exists(0, $args) && array_key_exists(0, $args[0]) && is_numeric($args[0][0]
			) && $args[0][0] > -1 && in_array(Data::$main_user->get('type'),
		                                      [2, 5]
		   ) && $args[0][0] != Data::$main_user->get('id'))
			$user = new User($args[0][0]); else
			return json_encode(['error' => 1, 'msg' => 'invalid_id']);

		$user_name = $user->get_full_name();

		if(strlen($user_name) == 0)
			return json_encode(['error' => 1, 'msg' => 'profile_not_found']);

		$posts = $sql->res2data($sql->a('SELECT `id` FROM `dposts` WHERE `creator_id` = ?', $user->get('id')));

		foreach($posts as $post_data)
			PostsController::actionDeleted($post_data['id']);

		$sql->a('UPDATE `dusers` SET `type` = 6 WHERE `id` = ?', $user->get('id'));

		return json_encode(['error' => 0]);
	}

}


class User{

	public $data = [];


	public function __construct($id){

		$this->data['id'] = (int)$id;

	}

	public function get_full_name(){

		if(array_key_exists('u_name', $this->data) && strlen($this->data['u_name']) > 0)
			return $this->data['u_name'];

		$name = $this->get('u_name');
		if(strlen($name) > 0)
			return $name;

		$name = $this->get('login');

		return $name;
	}

	public function get($name_of_field){


		if(array_key_exists($name_of_field, $this->data))
			return $this->data[$name_of_field];

		return $this->set($name_of_field);
	}

	public function set($name_of_field){

		global $sql;

		if($name_of_field === '*'){
			$new_data = $sql->r("SELECT * FROM `dusers` WHERE `id`=?", $this->data['id']);
			if($new_data === NULL)
				return NULL;
			$this->data = array_merge($this->data, $new_data);
		} elseif(strpos($name_of_field, ', ') !== FALSE) {
			$new_data = $sql->r("SELECT " . $name_of_field . " FROM dusers WHERE id=?", $this->data['id']);
			if($new_data === NULL)
				return NULL;
			$this->data = array_merge($this->data, $new_data);
		} else {

			$this->data[$name_of_field] = $sql->c("SELECT " . $name_of_field . " FROM dusers WHERE id=?",
			                                      $this->data['id']
			);

			return $this->data[$name_of_field];
		}

		return NULL;
	}

	public function get_u_ava(){

		$u_ava = $this->get('u_ava');

		if(strlen($u_ava) == 0)
			return Site::_DEFAULT_AVA_; else
			return $u_ava;
	}

	public function update($name_of_field,
	                       $value
	){

		global $sql;

		if(is_string($name_of_field) && is_string($value) && strpos($name_of_field, ', ') !== FALSE && strpos($value,
		                                                                                                      ', '
		                                                                                               ) !== FALSE){
			$name_of_field = explode(',', $name_of_field);
			$value = explode(',', $value);
		}

		if(is_array($name_of_field) && is_array($value) && count($name_of_field) == count($value
			) && count($name_of_field) != 0){

			$fields = &$name_of_field;
			$values = &$value;

			$fields = array_values($fields);
			$values = array_values($values);

			$sql_query = 'UPDATE `dusers` SET `u`=1';
			$sql_query = substr($sql_query, 0, -5);

			$count_fields = count($name_of_field);

			if($count_fields !== count($value))
				die('USER-UPDATE : COUNT name_of_field !== values ' . printf($name_of_field) . printf($value
					) . helper::debug_info()
				);

			for($i = 0; $i < $count_fields; $i++){
				if(strlen($fields[$i]) == 0)
					continue;
				if($i !== 0)
					$sql_query .= ', ';
				$fields[$i] = trim($fields[$i]);
				$values[$i] = trim($values[$i]);
				$this->data[$fields[$i]] = $values[$i];
				$sql_query .= $fields[$i] . ' = ?';
			}

			$sql_query .= ' WHERE id = ?';

			$data = array_merge([$sql_query], $values, [$this->get('id')]);
			call_user_func_array([$sql, 'a'], $data);
		} else {
			$this->data[$name_of_field] = $value;
			$sql->a('UPDATE dusers SET ' . $name_of_field . ' = ? WHERE id = ?', $value, $this->data['id']);
		}

		return NULL;
	}

}


class helper{

	public static $separator = DIRECTORY_SEPARATOR;
	public static $user_ip = 0;

	private static $syntaxBegin = 'VALUE_';
	private static $syntaxEnd = '_END';
	private static $syntaxUsageIndicatorIndex = 2;


	//public methods
	//main methods

	public static function delete_images($image_urls,
	                                     $fix_url = FALSE
	){

		if(is_string($image_urls))
			$image_urls = [$image_urls];

		$imgbb_images = [];

		foreach($image_urls as $image_url){

			if($fix_url)
				$image_url = str_replace('\/', '/', $image_url);

			if(strpos($image_url, "ibb.co") !== FALSE)
				$imgbb_images[] = $image_url; elseif(strpos($image_url, Site::$domain) && strpos($image_url, 'images/posts/') !== FALSE) {
				$image_name = substr($image_url, strpos($image_url, 'images/posts/') + strlen('images/posts/'));
				unlink(Site::server_link('public/images/posts/' . $image_name));
			}

		}

		if(count($imgbb_images) > 0){

			mail::send('Go delete images from img.bb',
			           mail::content('Go delete images from img.bb',
			                         'Don\'t be a lazy ass and delete the following images. Asked by ' . Site::_NAME_ . ': ' . implode("\n",
			                                                                                                                           $imgbb_images
			                         )
			           ),
			           Site::_EMAIL_,
			           Site::_REAL_EMAIL_
			);

			//there does not seem to be a way to delete an image through api so need to do this manually
//				foreach($comments['delete'] as $images){
//
//					$url = str_replace('\/', '/', $images);
//					$ch = curl_init();
//			        curl_setopt($ch, CURLOPT_URL, $url);
//			        curl_close($ch);
//
//				}

		}


	}


	public static function redirect($link = '',
	                                $relative = TRUE
	){

		if($relative)
			header('Location: ' . Site::link($link)); else
			header('Location: ' . $link);
	}

	public static function mayor_error($key){

		MainController::actionHeader();
		self::alert(Errors::get($key, 2), 'danger');
		sessionManager::destroy_session();
		die;
	}

	public static function alert($text,
	                             $type
	){


		if(is_array($text)){
			$extra = 'title="' . $text[1] . '"';
			$text = $text[0];
		} else
			$extra = ''; ?>
		<div class="alert alert-<?= $type ?>" <?= $extra ?>><?= $text ?></div> <?php
	}

	public static function root($path = ''){

		return ROOT . preg_replace('/[\/\\\\]{1}/m', self::$separator, $path);
	}

	public static function reindex_array($array,
	                                     $reverse = FALSE
	){

		if(!is_array($array))
			die('VAR IS NOT AN ARRAY' . self::debug_info());

		$new_array = [];

		if($reverse === TRUE)
			foreach($array as $key => $val)
				$new_array[] = [$key, $val]; elseif($reverse == -1) {
			foreach($array as $val){
				$val = array_values($val);
				if(array_key_exists(0, $val) && array_key_exists(1, $val))
					$new_array[$val[0]] = $val[1];
			}
		} else
			foreach($array as $val){
				var_dump($val);
				if(array_key_exists(0, $val) && array_key_exists(1, $val))
					$new_array[$val[0]] = $val[1];
			}

		return $new_array;
	}

	public static function debug_info(){

		$e = new Exception();

		return '<br><br>PHP version => ' . phpversion() . '<br>
			Time => ' . time() . '<br><br>' . preg_replace(['/#/', '/\.php\(/', '/\): /'], ['<br>#', '.php(<b>', '</b>): '], $e->getTraceAsString());
	}

//other methods

	public static function upload_file($field_name = NULL,
	                                   $file_name = FALSE,
	                                   $overwrite = FALSE,
	                                   $is_image = FALSE,
	                                   $file_path = FALSE
	){

		$is_base64 = substr($field_name, 0, 11) == "data:image/";
		$base64 = '';

		//config
		if($is_image)
			$path = Site::server_link(Site::$images_path); elseif($file_path !== FALSE)
			$path = Site::server_link($file_path);
		else
			return ["error" => 'critical', 'error_details' => "Incorrect file path" . self::debug_info()];

		$max_size = Site::$max_file_size;

		//validation

		if(!$field_name)
			return ["error" => 'critical', 'error_details' => "Incorrect form field name" . self::debug_info()];

		if(!$path)
			return ["error" => 'critical', 'error_details' => "Invalid upload path" . self::debug_info()];

		//if file exists
		if($is_base64){
			$ext = substr($field_name, 11, strpos($field_name, 'base64') - 12);
			$base64 = substr($field_name, strpos($field_name, ','));
		} elseif(!array_key_exists($field_name,
		                           $_FILES
			) || empty($_FILES[$field_name]) || $_FILES[$field_name]['error'] !== 0)
			return ["error" => 'true', 'error_details' => Errors::get('no_file_uploaded', 3)];
		else
			$ext = pathinfo($_FILES[$field_name]['name'], PATHINFO_EXTENSION);

		//check file extension
		if($is_image && (strpos(strtolower($_FILES[$field_name]["type"]), 'image') === FALSE || !getimagesize($_FILES[$field_name]['tmp_name'])))
			return ["error" => 'true', 'error_details' => Errors::get('file_is_not_an_image', 3)];
		if(in_array(strtolower($ext), Site::$forbidden_extensions))
			return ["error" => 'true', 'error_details' => Errors::get('forbidden_extension', 3)];

		//check file size
		if($is_base64 && (int)(strlen(rtrim($base64, '=')) * 3 / 4) > $max_size)
			return ["error" => 'true', 'error_details' => Errors::get('file_size_too_big', 3)]; elseif(!$is_base64 && $_FILES[$field_name]["size"] > $max_size)
			return ["error" => 'true', 'error_details' => Errors::get('file_size_too_big', 3)];

		$new_name = $file_name . '.' . $ext;

		if(is_string($overwrite) && strlen($overwrite) > 0){
			$prev_ext = $overwrite;
			$overwrite = TRUE;
		} else
			$prev_ext = FALSE;

		if(!$overwrite && file_exists($path . $new_name))
			return ["error" => 'true', 'error_details' => Errors::get('file_already_exists', 3)];

		if($is_base64)
			$status = file_put_contents($path . $new_name, base64_decode($base64)); else
			$status = move_uploaded_file($_FILES[$field_name]['tmp_name'], $path . $new_name);
		if(!$status)
			return ["error" => 'true', 'error_details' => Errors::get('failed_to_upload', 3)];


		if($prev_ext !== FALSE && $ext !== $prev_ext)
			unlink($path . $field_name . '.' . $prev_ext);

		return ['error' => 0, 'ext' => $ext];
	}

	public static function upload_image($url,
	                                    $thumb = FALSE,
	                                    $name = ''
	){

		if(strpos(substr($url, 0, 30), ",") !== FALSE)
			$img = substr($url, strpos(substr($url, 0, 30), ",") + 1); else
			$img = $url;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.imgbb.com/1/upload?key=" . Site::$imgbb_api_key);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1000);
		curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
		if(strlen($name) != 0)
			$data = ['image' => $img, 'name' => $name]; else
			$data = ['image' => $img];
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

		if(curl_errno($ch) !== 0)
			return FALSE;

		$output = json_decode(curl_exec($ch));
		curl_close($ch);

		if(!property_exists($output, 'data'))
			return FALSE;

		if($thumb && property_exists($output->data, 'thumb'))
			$url = $output->data->thumb->url; elseif(property_exists($output->data, 'medium'))
			$url = $output->data->medium->url;
		else//$('.delete-link')[0].click();$('#fullscreen-modal-box button').click();
			$url = $output->data->url;

		$delete_url = preg_replace('/\\\\\//', '/', $output->data->url_viewer/*delete_url*/);

		return [$url, $delete_url];
	}

	public static function generate_random_string(int $length = 10){

		return substr(str_shuffle(MD5(microtime())), 0, $length);
	}

	public static function replaceData(&$data,
	                                   $key = ''
	){

		if(is_array($data)){
			if(!(array_key_exists(self::$syntaxUsageIndicatorIndex,
			                      $data
			     ) && $data[self::$syntaxUsageIndicatorIndex] === 1))
				return $data;

			if(array_key_exists(self::$syntaxUsageIndicatorIndex, $data))
				unset($data[self::$syntaxUsageIndicatorIndex]);
		}

		if($key !== '')
			$data = array_merge([$key], $data);

		if(!is_array($data))
			return self::fill_into_string($data);

		$i = 0;
		foreach($data as $key => $value){

			while(TRUE){
				$newValue = self::fill_into_string($value);
				if($newValue != $value){
					$value = $newValue;
					$data[$key] = $value;
				} else {
					if(Site::_LANGUAGE_MODE_ === -1 && $i == 1)
						$data[$key] = htmlspecialchars(strip_tags($value));
					break;
				}
			}

			$i++;
		}

		return $data;
	}

	public static function fill_into_string($string){

		while(TRUE){
			$variableBegin = strpos($string, self::$syntaxBegin);

			if($variableBegin === FALSE)
				break;

			$newValue = substr($string, 0, $variableBegin);
			$variableBegin += strlen(self::$syntaxBegin);
			$variableEnd = strpos(substr($string, $variableBegin), self::$syntaxEnd);

			if($variableEnd === FALSE)
				break;

			$variableName = substr($string, $variableBegin, $variableEnd);
			$variableEnd += strlen(self::$syntaxEnd);
			$variableName = strtolower($variableName);
			$variableValue = Data::$$variableName;
			$newValue .= $variableValue . substr($string, $variableBegin + $variableEnd);
			$string = $newValue;
		}

		return $string;
	}

	public static function html2text($html){

		//return trim(preg_replace('/[ \t\n\r\0\x0B\xC2\xA0]{2,}/','<br>',strip_tags($html)));
		//return trim(preg_replace(['/<br>|[\s\xC2\xA0]{2,}/','/\n/'],["\n","<br>"],str_replace( [ '\xC2\xA0', '&nbsp;' ], ' ', strip_tags($html) )));
		return str_replace("\n",
		                   '<br>',
		                   trim(preg_replace(['/<br>|[\s\xC2\xA0]{2,}/', '/\n{2,}/'],
		                                     ["\n", "\n"],
		                                     str_replace(['\xC2\xA0', '&nbsp;'], ' ', strip_tags($html))
		                        )
		                   )
		);
		//return trim(preg_replace(['/<br>|[\s\xC2\xA0]{2,}/','/\n/'],["\n","<br>"],strip_tags($html)));
		//return str_replace('&nbsp;','',trim(preg_replace(['/<br>|[\s\xC2\xA0]{2,}/','/\n/'],["\n","<br>"],strip_tags($html))));
		//return preg_replace(['/<br>|&nbsp;|[\s\p{Z}\p{C}\x85\xA0\x{0085}\x{00A0}\x{FFFD}]{2,}/','/\n/'],["\n","<br>"],strip_tags($html));
		//return trim(preg_replace( "/[\n\r\t ]+/", ' ', str_replace( [ '\xC2\xA0', '&nbsp;' ], ' ', strip_tags($html) )));
	}

	public static function is_password_secure($password){

		//length > 9 = secure
		if(strlen($password) > 9)
			return TRUE;

		//check for 11111
		$first_letter = $password[0];
		for($i = 1; $i < strlen($password); $i++)
			if($first_letter != $password[$i])
				break;
		if($i > strlen($password) * 0.75)
			return FALSE;

		//check for acceding, descending or following numbers
		$count = 0;
		$max_count = 0;
		for($i = 0; $i < strlen($password); $i++){
			if($count == 0 && is_numeric($password[$i]))
				$count = 1; elseif($count != 0 && $password[$i] - $password[$i - 1] >= -1 && $password[$i] - $password[$i - 1] <= 1)
				$count++;
			elseif($count > $max_count)
				$max_count = $count;
		}
		if($count > $max_count)
			$max_count = $count;
		if($max_count > strlen($password) * 0.75)
			return FALSE;

		//check for common passwords
		$common_passwords = ['123456', 'Password', '12345678', 'qwerty', '12345', '123456789', 'letmein', '1234567', 'football', 'iloveyou', 'welcome', 'monkey', 'abc123', 'starwars', '123123', 'dragon', 'passw0rd', 'master', 'freedom', 'whatever', 'qazwsx', 'trustno1', '654321', 'jordan23', 'harley', 'password1', 'robert', 'matthew', 'jordan', 'asshole', 'daniel'];
		if(in_array($password, $common_passwords))
			return FALSE;

		return TRUE;
	}

	public static function input($label = '',
	                             $name = '',
	                             $type = 'text',
	                             $required = FALSE,
	                             $value = '',
	                             $placeholder = '',
	                             $regex = NULL,
	                             $extra = '',
	                             $label_extra = ''
	){

		if($label === 'other'){

			if($name === '</div>')
				echo '</div>'; else {

				[$class, $name] = helper::declasify($name);
				echo '<div class="' . $class . '" ' . $name . '>';

			}

		} else {

			//text submit checkbox radio email date color number button password range tel url file time list select
			// textarea captcha
			$attr = [];

			$t = '';
			$class = '';
			$label_class = '';
			$regexData = '';

			//if class in specified in extra, pull it into class
			[$class, $extra] = helper::declasify($extra);

			//if class in specified in label_extra, pull it into class
			[$label_class, $label_extra] = helper::declasify($label_extra);

			$attr['id'] = 'a2' . $name;
			if($name !== ''){
				$attr['name'] = $name;
				$id = 'id="a2' . $name . '"';
				$name = 'name="' . $name . '" ';
			} else {
				$name = '';
				$id = '';
			}
			$attr['type'] = $type;

			if($type != 'file')
				$attr['class'] = 'form-control  ' . $class; else
				$attr['class'] = $class;

			//if regex for field was specified, setup it
			if(is_array($regex)){
				$regexData = ' data-regex="' . htmlspecialchars($regex[0]
					) . '" data-regex_warning1="' . htmlspecialchars($regex[1]) . '"';
				$attr['data-regex'] = htmlspecialchars($regex[0]);
				$attr['data-regex_warning1'] = htmlspecialchars($regex[1]);
				if(array_key_exists(2, $regex)){
					$regexData .= ' data-regex_warning2="' . htmlspecialchars($regex[2]) . '"';
					$attr['data-regex_warning2'] = htmlspecialchars($regex[2]);
				}
			}

			if($required)
				$attr['required'] = '';
			if(strlen($placeholder) > 0)
				$attr['placeholder'] = $placeholder;

			//if value should be getted from array >>> pull it from array
			if(is_array($value) && count($value) > 0){
				switch($value[0]){
					case 'post':
						$attr['value'] = self::safeGet($value[1], $_POST);
						break;
					case 'get':
						$attr['value'] = self::safeGet($value[1], $_GET);
						break;
					case 'server':
						$attr['value'] = self::safeGet($value[1], $_SERVER);
						break;
					default:
						if(is_array($value[0]) && array_key_exists(1, $value) && !is_array($value[1]))
							$attr['value'] = self::safeGet($value[1], $value[0]); elseif($type != 'list' && $type != 'select') {
							$attr['value'] = $value[0];
							$attr['title'] = $value[1];
							$t .= ' title="' . $value[1] . '"';
						}
						break;
				}
			} elseif(!is_array($value) && strlen($value) > 0)
				$attr['value'] = $value;

			if(is_array($label)){
				$attr['label'] = $label[0];
				$attr['title'] = $label[1];
			} else
				$attr['label'] = $label;

			if(strlen($extra) > 0)
				$extra = ' ' . $extra;

			$begin = '';
			if($label !== FALSE && $label !== 0 && $label !== 1 && $label !== '')
				$begin .= '<div class="form-group ' . $label_class . '" ' . $label_extra . '>';
			if(strlen($attr['label']) > 0)
				$begin .= '<label for="a2' . $attr['name'] . '" title="' . ($attr['title'] ?? '') . '">' . $attr['label'] . '</label>';
			if(($type == 'button' || $type == 'submit' || $type == 'a') && $label !== 0 && $label !== 10 && $label !== '' && $label !== NULL)
				$begin .= '<br>';

			$data = '';

			if($required)
				$r = 'required'; else
				$r = '';
			if(strlen($placeholder) > 0)
				$p = ' placeholder="' . $placeholder . '"'; else
				$p = '';

			if($type === 'captcha')
				$data = '<div class="g-recaptcha ' . $class . '" ' . $id . ' data-regex_warning1="' . Errors::get('captcha_is_necessary',
				                                                                                                  0
					) . '" data-regex_warning2="' . Errors::get('captcha_is_necessary',
				                                                1
					) . '" data-sitekey="' . Site::$captchaSecretKey . '"></div>'; elseif($type == 'textarea' || $type == 'select' || $type == 'list') {

				if($type == 'textarea'){
					if(!array_key_exists('value', $attr))
						$attr['value'] = '';
					$data = '<textarea class="form-control ' . $class . '" ' . $name . $id . ' ' . $regexData . $r . $t . $p . $extra . '>' . $attr['value'] . '</textarea>';
				} elseif($type == 'select' || $type == 'list') {

					if(!is_array($value)){
						if($type == 'list')
							$value = [$value]; else
							$value = [[$value, $value, FALSE]];
					}
					if($type == 'select'){
						$data = '<select class="form-control ' . $class . '" ' . $name . $id . ' ' . $r . $t . $p . $extra . $regexData . '>';

						foreach($value as $d){
							if(array_key_exists(2, $d) && $d[2])
								$s = ' selected'; else
								$s = '';
							$data .= '<option value="' . $d[0] . '" ' . $s . '>' . $d[1] . '</option>';
						}
						$data .= '</select>';
					} else {

						$t_datalist_1 = '<input class="form-control ' . $class . '" list="' . $attr['name'] . '" ' . $name . $id . ' ' . $r . $t . $p . $extra . $regexData;
						$t_datalist_2 = '><datalist id="' . $attr['name'] . '">';
						$t_value = '';

						foreach($value as $d){
							if(is_array($d) && array_key_exists(1, $d) && $d[1] == 1){
								$t_value = $d[0];
								$d = $d[0];
							}
							$t_datalist_2 .= '<option>' . $d . '</option>';
						}
						if($t_value != '')
							$t_datalist_1 .= ' value="' . $t_value . '"';

						$data .= $t_datalist_1 . $t_datalist_2 . '</datalist>';
					}
				}
			} elseif($type == 'button')
				$data = '<button class="btn ' . $required . ' ' . $class . '" ' . $name . $id . ' ' . $t . $extra . $regexData . '>' . $attr['value'] . '</button>';
			elseif($type == 'submit')
				$data = '<input type="submit" class="btn ' . $required . ' ' . $class . '" ' . $name . $id . ' ' . $t . $extra . $regexData . ' value="' . $attr['value'] . '">';
			elseif($type == 'a')
				$data = '<a class="btn ' . $required . ' ' . $class . '" ' . $id . ' ' . $t . $extra . '>' . $attr['value'] . $regexData . '</a>';
			else {
				if(($type == 'checkbox' || $type == 'radio') && $required){
					unset($attr['required']);
					$attr['checked'] = '';
				}

				unset($attr['label']);

				$data = '<input';

				foreach($attr as $key => $value){
					$data .= ' ' . $key;
					if(strlen($value) > 0)
						$data .= '="' . $value . '"';
				}
				$data .= $extra . '>';
			}

			$end = '';
			if($label !== FALSE && $label !== 0 && $label !== 1 && $label !== '')
				$end .= "</div>\n";

			echo ($begin ?? '') . $data . ($end ?? '');
		}
	}

	private static function declasify($string){

		$class = '';
		if(is_string($string) && strlen($string) > 7 && strpos($string, 'class="') !== FALSE){
			$classPos = strpos($string, 'class="') + strlen('class="');
			$className = substr($string, $classPos, strpos(substr($string, $classPos), '"'));
			if($className !== FALSE){
				$class = $className;
				$string = preg_replace('/class *= *"[^"]*"/m', '', $string);
			}
		}

		return [$class, $string];

	}

	public static function safeGet($key,
	                               &$array,
	                               $default = ''
	){

		if(is_array($array) && array_key_exists($key, $array))
			return $array[$key]; elseif($default === 'error') {
			ob_start();
			var_dump($array);
			$result = ob_get_clean();
			die('NO KEY ' . $key . ' IN ARRAY ' . $result . self::debug_info());
		} else
			return $default;
	}

	public static function p($src = 0,
	                         $default = NULL
	){

		$ext = glob($src . '.*');
		if($ext)
			return $ext[0]; elseif($default)
			return $default;
		else
			return _DEAFULT_AVA_;
	}

	public static function text2url($value,
	                                $show_img = 1,
	                                $protocols = ['http', 'mail', 'https', 'twitter'],
	                                array $attributes = ['target' => '_blank']
	){

		$attr = '';
		foreach($attributes as $key => $val){
			$attr = ' ' . $key . '="' . htmlentities($val) . '"';
		}
		$links = [];
		$value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i',
			function($match) use
			(
				&
				$links
			){

				return '<' . array_push($links, $match[1]) . '>';
			},
			                           $value
		);
		foreach((array)$protocols as $protocol){
			switch($protocol){
				case 'http':
				case 'https':
					$value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i',
						function($match) use
						(
							$protocol,
							&
							$links,
							$attr,
							$show_img
						){

							if($match[1]){
								$protocol = $match[1];
								$link = $match[2]
									?: $match[3];
								if($show_img == 1){
									if(strpos($link, 'youtube.com') > 0 || strpos($link, 'youtu.be') > 0){
										$exploded_link = explode('=',
										                         $link
										);
										$link = '<iframe width="500" height="294" src="https://www.youtube.com/embed/' . end($exploded_link
											) . '?modestbranding=1" frameborder="0" allowfullscreen></iframe>';

										return '<' . array_push($links, $link) . '></a>';
									}
									if(strpos($link, '.png') > 0 || strpos($link, '.jpg') > 0 || strpos($link,
									                                                                    '.jpeg'
									                                                             ) > 0 || strpos($link,
									                                                                             '.gif'
									                                                                      ) > 0 || strpos($link,
									                                                                                      '.bmp'
									                                                                               ) > 0){
										return '<' . array_push($links,
										                        "<a $attr href=\"$protocol://$link\" class=\"htmllink\"><img src=\"$protocol://$link\" class=\"htmlimg\">"
											) . '></a>';
									}
								}

								return '<' . array_push($links,
								                        "<a $attr href=\"$protocol://$link\" class=\"htmllink\">$link</a>"
									) . '>';
							}

							return '';
						},
						                           $value
					);
					break;
				case 'mail':
					$value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~',
						function($match) use
						(
							&
							$links,
							$attr
						){

							return '<' . array_push($links,
							                        "<a $attr href=\"mailto:{$match[1]}\" class=\"htmllink\">{$match[1]}</a>"
								) . '>';
						},
						                           $value
					);
					break;
				case 'twitter':
					$value = preg_replace_callback('~(?<!\w)[@#](\w++)~',
						function($match) use
						(
							&
							$links,
							$attr
						){

							return '<' . array_push($links,
							                        "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@'
								                        ? ''
								                        : 'search/%23') . $match[1] . "\" class=\"htmllink\">{$match[0]}</a>"
								) . '>';
						},
						                           $value
					);
					break;
				default:
					$value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i',
						function($match) use
						(
							$protocol,
							&
							$links,
							$attr
						){

							return '<' . array_push($links,
							                        "<a $attr href=\"$protocol://{$match[1]}\" class=\"htmllink\">{$match[1]}</a>"
								) . '>';
						},
						                           $value
					);
					break;
			}
		}

		return preg_replace_callback('/<(\d+)>/',
			function($match) use
			(
				&
				$links
			){

				return $links[$match[1] - 1];
			},
			                         $value
		);
	}

	public static function str_replace_first_ref($search,
	                                             $replace,
	                                             &$subject,
	                                             $reverse = FALSE
	){

		$subject = self::str_replace_first($search, $replace, $subject, $reverse);
	}

	public static function str_replace_first($search,
	                                         $replace,
	                                         $subject,
	                                         $reverse = FALSE
	){

		if($reverse)
			$pos = strrpos($subject, $search); else
			$pos = strpos($subject, $search);
		if($pos !== FALSE)
			return substr_replace($subject, $replace, $pos, strlen($replace));

		return $subject;
	}

	public static function set_seo($data = '',
	                               $formatted = 1
	){

		$title = NULL;
		$keywords = NULL;
		$description = NULL;

		if(is_array($data)){
			if(array_key_exists(0, $data))
				$title = $data[0];
			if(array_key_exists(1, $data))
				$keywords = $data[1];
			if(array_key_exists(2, $data))
				$description = $data[2];
		} elseif(is_string($data))
			$title = $data;

		if($formatted){
			if($title != NULL){
				if(strlen($title) > 0)
					$title .= ' - ';
				$title = $title . Site::_NAME_;
			}
			if($keywords != NULL){
				if(strlen($keywords) > 0)
					$keywords .= ', ';
				if($formatted == 1)
					$keywords = $keywords . Site::_KEYWORDS_; else
					$keywords = $keywords . Data::$currentSettings[1] . ', ' . Site::_KEYWORDS_;
			}
			if($description != NULL){
				if(strlen($description) > 0)
					$description .= ".\n";
				if($formatted == 1)
					$description = $description . Site::_DESCRIPTION_; else
					$description = $description . Data::$currentSettings[2] . ".\n" . Site::_DESCRIPTION_;
			}
		}

		if(strlen($title) > 0){ ?>
			<script>
				$( "title" ).text( `<?=$title?>` );
			</script> <?php
		}
		if(strlen($keywords) > 0){ ?>
			<script>
				$( "meta[name=\"keywords\"]" ).attr( "content", `<?=$keywords?>` );
			</script> <?php
		}
		if(strlen($description) > 0){ ?>
			<script>
				$( "meta[name=\"description\"]" ).attr( "content", `<?=$description?>` );
			</script> <?php
		}
	}

	public static function format_date($date,
	                                   string $type
	){

		if(!is_numeric($date) || !$date > 0)
			return FALSE;

		if($type == 'html_input' && is_numeric($date) && $date > 0)
			return date('Y-m-d', $date); elseif($type == 'friendlify')
			return self::friendlify_date($date);

		return FALSE;
	}

	private static function friendlify_date($unix_date){

		$unix_now = $_SERVER['REQUEST_TIME'];

		if($unix_date <= $unix_now){//past
			if($unix_now - $unix_date < 10)
				return Language::get('just_now');
			if($unix_now - $unix_date < 60)
				return Language::get('language_ago_before'
					) . ' ' . ($unix_now - $unix_date) . ' ' . Language::get('x_sec_ago');
			if($unix_now - $unix_date < 3600)
				return Language::get('language_ago_before') . ' ' . round(($unix_now - $unix_date) / 60
					) . ' ' . Language::get('x_min_ago');
			if($unix_now - $unix_date < 86400)
				return Language::get('language_ago_before') . ' ' . round(($unix_now - $unix_date) / 3600
					) . ' ' . Language::get('x_hours_ago');
			if($unix_now - $unix_date < 86400 * 365)
				return date('d.m', $unix_date);

			return date('d.m.Y', $unix_date);
		} else {//future
			if($unix_date - $unix_now < 10)
				return Language::get('in_few_seconds');
			if($unix_date - $unix_now < 60)
				return Language::get('after') . ' ' . ($unix_now - $unix_date) . ' ' . Language::get('x_sec');
			if($unix_date - $unix_now < 3600)
				return Language::get('after') . ' ' . round(($unix_now - $unix_date) / 60
					) . ' ' . Language::get('x_min');
			if($unix_date - $unix_now < 86400)
				return Language::get('after') . ' ' . round(($unix_now - $unix_date) / 3600
					) . ' ' . Language::get('x_min');
			if($unix_date - $unix_now < 86400 * 365)
				return date('d.m', $unix_date);

			return date('d.m.Y', $unix_date);
		}

	}

	public static function html_diff($old,
	                                 $new,
	                                 $formatting = [],
	                                 $splitting = 1
	){

		if($splitting)
			$diff = self::diff(str_split($old, 1), str_split($new, 1)); else
			$diff = self::diff(str_split($old, 1), str_split($new, 1));
		$ret = '';

		if(is_array($formatting) && count($formatting) == 4){
			$h1 = $formatting[0];
			$h2 = $formatting[1];
			$h3 = $formatting[2];
			$h4 = $formatting[3];
		} elseif($formatting == 'divs') {
			$h1 = '<div class="old">';
			$h2 = '</div> ';
			$h3 = '<div class="new">';
			$h4 = '</div> ';
		} else {
			$h1 = '<del>';
			$h2 = '</del> ';
			$h3 = '<ins>';
			$h4 = '</ins> ';
		}

		foreach($diff as $k){
			if(is_array($k))
				$ret .= (!empty($k['d'])
						? $h1 . implode('', $k['d']) . $h2
						: '') . (!empty($k['i'])
						? $h3 . implode('', $k['i']) . $h4
						: ''); else $ret .= $k;
		}

		return $ret;
	}

	public static function diff($old,
	                            $new
	){

		$max_len = 0;
		$matrix = [];
		$o_max = 0;
		$n_max = 0;
		foreach($old as $o_index => $o_value){
			$n_keys = array_keys($new, $o_value);
			foreach($n_keys as $n_index){
				$matrix[$o_index][$n_index] = isset($matrix[$o_index - 1][$n_index - 1])
					? $matrix[$o_index - 1][$n_index - 1] + 1
					: 1;
				if($matrix[$o_index][$n_index] > $max_len){
					$max_len = $matrix[$o_index][$n_index];
					$o_max = $o_index + 1 - $max_len;
					$n_max = $n_index + 1 - $max_len;
				}
			}
		}
		if($max_len == 0)
			return [['d' => $old, 'i' => $new]];

		return array_merge(self::diff(array_slice($old, 0, $o_max), array_slice($new, 0, $n_max)),
		                   array_slice($new, $n_max, $max_len),
		                   self::diff(array_slice($old, $o_max + $max_len), array_slice($new, $n_max + $max_len))
		);
	}

	public static function log($type,
	                           $value
	){

		global $sql;

		if(Data::$main_user == NULL)
			$id = -1; else
			$id = Data::$main_user->get('id');

		$sql->a('INSERT INTO `dlog`(`domain`,`directory`,`etime`,`ip`,`userid`,`type`,`val`) VALUES(?,?,?,?,?,?,?)',
		        Site::$domain,
		        Data::$current_uri,
		        date('H:i:s d:m:y'),
		        helper::get_user_ip(),
		        $id,
		        $type,
		        $value
		);

	}

	public static function get_user_ip(){

		if(self::$user_ip != 0)
			return self::$user_ip;

		if(isset($_SERVER['HTTP_CLIENT_IP']))
			self::$user_ip = $_SERVER['HTTP_CLIENT_IP']; elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			self::$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		elseif(isset($_SERVER['HTTP_X_FORWARDED']))
			self::$user_ip = $_SERVER['HTTP_X_FORWARDED'];
		elseif(isset($_SERVER['HTTP_FORWARDED_FOR']))
			self::$user_ip = $_SERVER['HTTP_FORWARDED_FOR'];
		elseif(isset($_SERVER['HTTP_FORWARDED']))
			self::$user_ip = $_SERVER['HTTP_FORWARDED'];
		elseif(isset($_SERVER['REMOTE_ADDR']))
			self::$user_ip = $_SERVER['REMOTE_ADDR'];
		else
			self::$user_ip = 'UNKNOWN';

		return self::$user_ip;
	}

	public static function admin_notify($subject,
	                                    $content
	){


		if(is_null(Data::$main_user)){
			$user = 'not_logged_in';
			$user_email = '';
		} else {
			$user = Data::$main_user;
			$user_email = $user->get('email');
		}

		ob_start();
		var_dump($user);
		$content .= '<br><br><br>' . ob_get_clean();

		mail::send($subject,
		           mail::content($subject, $content),
		           $user_email,
		           Site::_ADMIN_EMAIL_
		);
	}


//private methods

	public static function random_str($length,
	                                  $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
	){

		$pieces = [];
		$max = mb_strlen($keyspace, '8bit') - 1;
		for($i = 0; $i < $length; ++$i){
			try {
				$pieces [] = $keyspace[random_int(0, $max)];
			} catch(Exception $e){
			}
		}

		return implode('', $pieces);
	}

}


class sql{

	private $connection;
	private $tableNamesA;
	private $tableNamesB;
	private $specialSymbol;

	public function __construct($host,
	                            $login,
	                            $password,
	                            $db_name,
	                            $tableNames,
	                            $specialSymbol = '?',
	                            $createTables = FALSE
	){

		$this->connection = new mysqli($host, $login, $password, $db_name);

		if($this->connection->connect_error)
			die('Connection failed: ' . $this->connection->connect_error);
		if(!is_array($tableNames))
			die('Invalid table names');

		$this->specialSymbol = $specialSymbol;
		$this->tableNamesA = [];
		$this->tableNamesB = [];

		$defaultTableData = NULL;
		if($createTables){
			$defaultTableData = [];
			$defaultTableData["users"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dusers` (
			  `id` INT(11) NOT NULL AUTO_INCREMENT,
			  `login` VARCHAR(40) NOT NULL,
			  `hash` VARCHAR(255) NOT NULL,
			  `email` VARCHAR(254) NOT NULL,
			  `register_date` INT(10) NOT NULL,
			  `birth_date` INT(10) NOT NULL,
			  `u_name` VARCHAR(50) NOT NULL,
			  `u_city` VARCHAR(60) NOT NULL,
			  `u_edu` VARCHAR(70) NOT NULL,
			  `u_sm` TEXT NOT NULL,
			  `u_about` TEXT NOT NULL,
			  `u_ava` VARCHAR(255) NOT NULL,
			  `u_phone` VARCHAR(40) NOT NULL,
			  `u_last_online` INT(10) NOT NULL,
			  `type` INT(10) NOT NULL DEFAULT 1,
			  `parameters` TEXT NOT NULL,
			  `register_ip` VARCHAR(15) NOT NULL,
			  `banned_ips` TEXT NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=`utf8mb4`;";
			$defaultTableData["posts"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dposts` (
			  `id` INT(11) NOT NULL AUTO_INCREMENT,
			  `name` VARCHAR(256) NOT NULL,
			  `content` MEDIUMTEXT NOT NULL,
			  `keywords` TEXT NOT NULL,
			  `description` TEXT NOT NULL,
			  `category_id` INT(11) NOT NULL,
			  `theme_id` INT(11) NOT NULL,
			  `creator_id` INT(11) NOT NULL,
			  `created_unix` INT(10) NOT NULL,
			  `verified` INT(2) NOT NULL,
			  `comments` TEXT NOT NULL,
			  `src` TEXT NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=`utf8mb4`;";
			$defaultTableData["categories"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dcategories` (
			  `id` INT(11) NOT NULL AUTO_INCREMENT,
			  `name` VARCHAR(256) NOT NULL,
			  `type` INT(2) NOT NULL,
			  `class` INT(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=`utf8mb4`;";
			$defaultTableData["products"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dproducts` (
				`id` INT(10) DEFAULT NULL,
				`name` VARCHAR(60) DEFAULT NULL,
				`price` VARCHAR(5) DEFAULT NULL,
				`link` VARCHAR(20) DEFAULT NULL,
				`b_link` VARCHAR(10) DEFAULT NULL,
				`o1` TEXT,
				`o2` TEXT,
				`o3` TEXT,
				`yt` VARCHAR(15) DEFAULT NULL,
				`keywords` VARCHAR(255) DEFAULT NULL,
				`vis` BIT(1) NOT NULL DEFAULT b'1',
				`keyval` INT(3) NOT NULL AUTO_INCREMENT,
				`views` INT(6) NOT NULL DEFAULT '0',
				`buys` INT(6) NOT NULL DEFAULT '0',
				`unixtime` VARCHAR(15) DEFAULT NULL,
				`comments` TEXT,
				`parameters` VARCHAR(100) NOT NULL DEFAULT '01111100:1:1:1:0:0:0:0',
				PRIMARY KEY (`keyval`)
			) ENGINE=MyISAM DEFAULT CHARSET=`utf8mb4`;";
			$defaultTableData["mv"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dmv` (
			  `name` VARCHAR(256) NOT NULL,
			  `value` TEXT NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=`utf8mb4`;";
			$defaultTableData["mv2"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dmv2` (
				`name` VARCHAR(256) NOT NULL,
				`value` MEDIUMTEXT NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=`utf8mb4`;";
			$defaultTableData["logins"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dlogins` (
				`id` INT(11) NOT NULL AUTO_INCREMENT,
				`domain` VARCHAR(30) NOT NULL,
				`user` INT(10) NOT NULL,
				`ip` VARCHAR(15) NOT NULL,
				`time` INT(10) NOT NULL,
				`type` INT(10) NOT NULL,
				`info` VARCHAR(60) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=`utf8mb4`;";
			$defaultTableData["log"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dlog` (
				`id` INT(11) NOT NULL AUTO_INCREMENT,
				`domain` VARCHAR(50) NOT NULL,
				`directory` VARCHAR(50) NOT NULL,
				`etime` VARCHAR(20) NOT NULL,
				`ip` VARCHAR(16) NOT NULL,
				`userid` INT(5) NOT NULL DEFAULT '-1',
				`type` INT(11) NOT NULL,
				`val` TEXT NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=`utf8mb4`;";
		}

		foreach($tableNames as $d){
			$this->tableNamesA[] = '/`?' . $d[0] . '`?/';
			$this->tableNamesB[] = '`' . $d[1] . '`';
			if($createTables && is_array($defaultTableData) && array_key_exists($d[2], $defaultTableData) && strlen($defaultTableData[$d[2]]
				))
				$this->a(preg_replace(['/mydbname/', '/`?' . $d[0] . '`?/'],
				                      [$db_name, $d[1]],
				                      $defaultTableData[$d[2]]
				         )
				);
		}

	}

	public function a(string $query){//array

		$args = func_get_args();

		if(count($args) < 2)
			return $this->connection->query($this->fill_in_query($query));

		[$args, $numberOfArgs, $stmt] = call_user_func_array([$this, 'p'], array_merge([TRUE], func_get_args()));


		return $this->b($args, $numberOfArgs, $stmt);
	}

	public function fill_in_query(string $query){

		if(strlen($query) < 1)
			return NULL;

		return preg_replace($this->tableNamesA, $this->tableNamesB, $query);
	}

	public function b($args,
	                  $numberOfArgs,
	                  mysqli_stmt $stmt
	){//bind

		if($numberOfArgs == -1)
			$numberOfArgs = count($args);

		$a_params = [];
		$argsTypes = '';
		$a_params[] = &$argsTypes;

		for($i = 0; $i < $numberOfArgs; $i++){

			if(is_numeric($args[$i]))
				$args[$i] = (int)$args[$i];

			switch(gettype($args[$i])){
				case 'integer':
					$argsTypes .= 'i';
					break;
				case 'double':
					$argsTypes .= 'd';
					break;
				case 'string':
					$argsTypes .= 's';
					break;
				default:
					$argsTypes .= 's';
					$args[$i] = (string)$args[$i];
					break;
			}

			$a_params[] = &$args[$i];

		}

		call_user_func_array([$stmt, 'bind_param'], $a_params);
		$stmt->execute();

		return $stmt->get_result();

	}

	public function logg($dir,
	                     $type,
	                     $val
	){

		if(Data::$main_user != NULL){
			$str = 'id';
			$id = Data::$main_user->$$str;
		} else
			$id = '';
		q('INSERT INTO ' . _LOG_ . '(domain,directory,eTime,ip,userID,type,val) VALUES("' . Site::getDomain() . '","' . $dir . '","' . date('H:i:s d:m:y'
		  ) . '","' . $_SERVER['REMOTE_ADDR'] . '","' . $id . '","' . $type . '","' . $val . '")',
		  NULL
		);
	}

	public function disconect(){

		$this->connection->close();
	}

	public function last_insert_id(){

		return $this->connection->insert_id;
	}

	public function count($result){

		return $result->num_rows;
	}

	public function c(string $query){//col

		$data = call_user_func_array([$this, 'a'], func_get_args());

		if($data === FALSE)
			return FALSE;

		$result = $data->fetch_row();
		if(is_array($result) && array_key_exists(0, $result))
			return $result[0]; else
			return FALSE;
	}

	public function r(string $query){//row

		$data = call_user_func_array([$this, 'a'], func_get_args());
		if($data != FALSE)
			$r = $data->fetch_assoc(); else
			$r = $data;
		$data->free();

		return $r;
	}

	public function m(string $query){//multiple

		return $this->connection->multi_query($this->fill_in_query($query));
	}

	public function p(bool $return_all,
	                  string $query
	){//prepare

		$args = func_get_args();
		array_shift($args);
		$query = $this->fill_in_query(array_shift($args));
		$numberOfArgs = count($args);

		if(substr_count($query, $this->specialSymbol) != $numberOfArgs)
			die('Number of parameters (' . substr_count($query,
			                                            $this->specialSymbol
				) . ') != number of ' . $this->specialSymbol . " in query (" . $numberOfArgs . ")(" . $query . "). Debug info:<br>" . helper::debug_info()
			);

		$stmt = $this->connection->prepare($query);
		if($stmt === FALSE)
			die('Wrong SQL: ' . $query . ' Error: ' . $this->connection->errno . ' ' . $this->connection->error . "<br>Debug info:<br>" . helper::debug_info()
			);

		if($return_all)
			return [$args, $numberOfArgs, $stmt]; else
			return $stmt;
	}

	public function res2data($res,
	                         bool $fix_assoc = FALSE,
	                         bool $index = FALSE
	){

		if(is_bool($res))
			return $res;

		$data = [];
		if($fix_assoc)
			while($row = $this->fetch($res, $index))
				$data[] = array_shift($row); else
			while($row = $this->fetch($res, $index))
				$data[] = $row;

		return $data;

	}

	public static function fetch(mysqli_result $res,
	                             $indexed = FALSE
	){

		if($indexed == TRUE)
			return $res->fetch_array(MYSQLI_NUM);

		return $res->fetch_array(MYSQLI_ASSOC);
	}

}
