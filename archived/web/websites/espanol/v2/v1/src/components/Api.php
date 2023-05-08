<?php

namespace Api;


class lrp {

	private static function getData() {

		$field = array();

		foreach($_POST['arr'] as $fieldRow)
			$field[array_shift($fieldRow)] = $fieldRow;

		return $field;
	}

	private static function validate_data(&$data) {

		foreach($data as $fieldName => $values)
			if(array_key_exists(1, $values) && strlen($values[1]) !== 0 && !preg_match('/' . $values[1] . '/', $values[0]))
				return 'Field: ' . $fieldName;

		return '';
	}

	public static function validate_fields() {

		global $field;

		if(count($_POST) === 0)
			return 'POST NOT SET';

		$field = self::getData();

		return self::validate_data($field);

	}

	private static function error($type, $reason, $id, $ip) {

		global $sql;

		$sql->a('INSERT INTO dlogins(domain,user,ip,time,type,info) VALUES(?,?,?,?,?,?)', \Site::$domain, $id, $ip, $_SERVER['REQUEST_TIME'], $type, $reason);

		$failed_logins0 = self::get_failed_logins($id, 0);
		$max_failed_logins0 = \Site::$showCaptchaAfter;
		$captcha = '';
		if($failed_logins0 >= $max_failed_logins0)
			$captcha = "Captcha\n";

		return $captcha . 'Error: ' . $reason . '\n' . \Errors::formatError(\Errors::get($reason, 2));
	}

	private static function get_failed_logins($user_id = null, $type = 0) {

		global $sql;

		if($type == 0)
			$type_str = 'IN(0,2)';
		else
			$type_str = '= 2';

		if($user_id != null)
			return $sql->c('SELECT COUNT(id) FROM dlogins WHERE domain=? AND user=? AND type ' . $type_str . ' AND UNIX_TIMESTAMP() - time < 3600', \Site::$domain, $user_id);

		$ip = helper::get_user_ip();
		return $sql->c('SELECT COUNT(id) FROM dlogins WHERE domain=? AND ip=? AND type ' . $type_str . ' AND UNIX_TIMESTAMP() - time < 3600', \Site::$domain, $ip);

	}

	public static function need_login_captcha() {

		return (self::get_failed_logins() >= \Site::$showCaptchaAfter) ? '1' : '0';
	}

	public static function need_register_captcha() {

		global $sql;

		$registered_accounts = $sql->c('SELECT COUNT(id) FROM dusers WHERE register_ip=? AND register_date - UNIX_TIMESTAMP() < 3600', helper::get_user_ip());

		return $registered_accounts >= \Site::$registeredAccountsBeforeCaptcha ? '1' : '0';
	}

	private static function can_login($ip, $register_ip, $id) {

		$failed_logins0 = self::get_failed_logins($id, 0);

		if($register_ip == $ip)
			$max_failed_logins0 = 6;
		else
			$max_failed_logins0 = 4;

		if($failed_logins0 >= $max_failed_logins0)
			return self::error(0, 'try_later', $id, $ip);
		return '';
	}

	private static function captcha_validate($field, $id, $ip) {

		$reCaptchaFailed = true;
		$max_failed_logins2 = \Site::$showCaptchaAfter;
		$failed_logins2 = self::get_failed_logins($id, 2);

		if($failed_logins2 >= $max_failed_logins2) {
			if(array_key_exists('g-recaptcha-response', $field)) {
				$secret = \Site::$captchaSecretKey;
				$captcha = $field['g-recaptcha-response'];
				$response_url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&captcha=$captcha&remoteip=$ip";
				var_dump($response_url);

				$answer = json_decode($response_url, true);
				var_dump($answer);
				if($answer['success'])
					$reCaptchaFailed = false;
			}
			else if($failed_logins2 <= \Site::$hardShowCaptchaAfter)
				$reCaptchaFailed = false;
		}
		else
			$reCaptchaFailed = false;
		if($reCaptchaFailed)
			return self::error(2, 'captcha_failed', $id, $ip);
		return '';
	}

	public static function login() {

		if(\Data::$main_user !== null)
			header('Location: ' . helper::root(''));

		//show login form
		?>

		<form method="post">

			<?php
			helper::input(\Language::get('login', 2), 'login', 'text', true, array('post', 'login'), '', \Fields::get('lLogin', 2));
			helper::input(\Language::get('password', 2), 'password', 'password', true, array('post', 'password'), '', \Fields::get('lPassword', 2));
			helper::input(\Language::get('captcha', 2), 'captcha', 'captcha', false, null, null, null, '', 'class="d-none"');
			helper::input('other', 'btn-group');
			helper::input('', 'submit', 'submit', 'btn-dark', \Language::get('logIn', 2), '', '', 'type="button"');
			helper::input('', '', 'a', 'btn-light btn-outline-dark', \Language::get('register', 2), '', '', 'href="' . \Site::link('register/') . '"');
			helper::input('', '', 'a', 'btn-light btn-outline-danger', \Language::get('forgotPassword', 2), '', '', 'href="' . \Site::link(\Data::$password_reset_link) . '"');
			helper::input('other', '</div>');

			?>

		</form>

		<script>
			$(function() {
				forming($('#a2submit'), '<?=\Site::link('validate/login')?>', '<?=\Site::link()?>', null, '#a2captcha', '<?=\Site::link()?>validate/captcha');
			})
		</script>

		<?php

	}

	public static function validate_login() {

		global $field, $sql;

		$validation_results = self::validate_fields();
		if($validation_results !== '')
			return $validation_results;

		$login = $field['login'][0];
		$data = $sql->r("SELECT id,type,hash,banned_ips,register_ip FROM dusers WHERE login = ? OR email = ? OR u_phone = ? LIMIT 1", $login, $login, $login);
		$password = $field['password'][0];
		$hash = $data['hash'];

		$ip = helper::get_user_ip();
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
		if(strlen($hash) < 2 || !password_verify($password, $hash))
			return self::error(0, 'wrong_password', $data['id'], $ip);

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
		\sessionManager::destroy_session();
		\sessionManager::sessionStart('account', \Site::_COOKIE_DURATION_);
		$_SESSION['hash'] = $hash;
		$_SESSION['user_id'] = $data['id'];
		$_SESSION['last_activity'] = $_SERVER['REQUEST_TIME'];

		$sql->a('INSERT INTO dlogins(domain,user,ip,time) VALUES(?,?,?,?)', \Site::$domain, $data['id'], $ip, $unix_time);

		return 'ok';

	}

	public static function register() {

		if(\Data::$main_user !== null)
			header('Location: ' . helper::root(''));

		//show register form
		?>

		<form method="post">

			<?php
			helper::input(\Language::get('login', 2), 'login', 'text', true, array('post', 'login'), '', \Fields::get('rlogin', 2));
			helper::input(\Language::get('password', 2), 'password', 'password', true, array('post', 'password'), '', \Fields::get('rpassword', 2));
			helper::input(\Language::get('dpassword', 2), 'dpassword', 'password', true, array('post', 'dpassword'), '', \Fields::get('rdpassword', 2));
			helper::input(\Language::get('email', 2), 'email', 'email', true, array('post', 'email'), '', \Fields::get('remail', 2));
			helper::input(\Language::get('captcha', 2), 'captcha', 'captcha', false, null, null, null, '', 'class="d-none"');
			helper::input('other', 'btn-group');
			helper::input('', 'submit', 'button', 'btn-dark', \Language::get('register', 2), '', '', 'type="button"');
			helper::input('', '', 'a', 'btn-light btn-outline-dark', \Language::get('logIn', 2), '', '', 'href="' . \Site::link('login/') . '"');
			helper::input('other', '</div>');
			?>

		</form>

		<script>
			$(function() {
				forming($('#a2submit'), '<?=\Site::link('validate/register')?>', '<?=\Site::link()?>', null, '#a2captcha', '<?=\Site::link()?>validate/r_captcha');
			})
		</script>

		<?php

	}

	public static function validate_register() {

		global $field, $sql;

		$validation_results = self::validate_fields();
		if($validation_results !== '')
			return $validation_results;

		$login = $field['login'][0];
		$password = $field['password'][0];
		$dpassword = $field['dpassword'][0];
		$email = $field['email'][0];
		$ip = helper::get_user_ip();
		$unix_time = $_SERVER['REQUEST_TIME'];

		//check whether login is taken
		$data = $sql->c("SELECT id FROM dusers WHERE login = ?", $login);
		if(strlen($data) !== 0)
			return 'Field: login\n' . \Errors::formatError(\Errors::get('login_taken', 2));

		//check whether email is taken
		$data = $sql->c("SELECT id FROM dusers WHERE email = ?", $email);
		if(strlen($data) !== 0)
			return 'Field: email\n' . \Errors::formatError(\Errors::get('email_taken', 2));

		//check whether password == dpassword
		if($password !== $dpassword)
			return 'Code: password_not_dpassword\n' . \Errors::formatError(\Errors::get('password_not_dpassword', 2));

		//check whether password !== login
		if($password === $login)
			return 'Code: password_is_login\n' . \Errors::formatError(\Errors::get('password_is_login', 2));

		//check whether password is not too simple
		if(!helper::is_password_secure($password))
			return 'Code: password_to_simple\n' . \Errors::formatError(\Errors::get('password_to_simple', 2));

		$hash = password_hash($password, PASSWORD_DEFAULT);

		$user_id = $sql->c('INSERT INTO dusers(login,hash,email,register_date,register_ip) VALUES(?,?,?,?,?); SELECT SCOPE_IDENTITY()', $login, $hash, $email, $unix_time, $ip);
		var_dump($user_id);

		\sessionManager::sessionStart('account', \Site::_COOKIE_DURATION_);
		\sessionManager::destroy_session();
		$_SESSION['hash'] = $hash;
		$_SESSION['user_id'] = $user_id;
		$_SESSION['last_activity'] = $_SERVER['REQUEST_TIME'];

		return 'ok';
	}

	public static function confirm() {

	}

	public static function validate_confirm() {

		return 'ok';
	}

	public static function reset() {

	}

	public static function validate_reset() {

		return 'ok';
	}

	public static function profile() {

		global $sql;
		$args = func_get_args()[0];

		//id was specified
		if(count($args) == 1) {
			if(is_numeric($args[0]) && $args[0] >= 0)
				$profile_id = $args[0];

			else if(preg_match('/^@?[A-Za-z0-9_\-]{3,60}$/', $args[0])) {

				if($args[0][0] == '@')
					$login = substr($args[0], 1);
				else
					$login = $args[0];

				if(\Data::$main_user !== null && \Data::$main_user->get('login') == $login)
					$profile_id = \Data::$main_user->get('id');
				else
					$profile_id = $sql->c('SELECT id FROM dusers WHERE login=?', $login);
			}
		}


		//id was not specified and user is not logged in
		else if(\Data::$main_user === null)
			helper::redirect('login/');

		//id was not specified but user is logged in
		else
			helper::redirect('profile/' . \Data::$main_user->get('id'));

		if(\Data::$main_user == null)
			$is_owner = false;
		else
			$is_owner = true;

		if(!is_numeric($profile_id) || strlen($profile_id) == 0)
			helper::alert(\Language::get('profile_not_found', 2), 'danger');

		//show current users's profile
		if(isset($profile_id))
			self::display_profile($profile_id, $is_owner);

	}

	public static function display_profile($id = 0, $is_owner = false) {

		if($is_owner)
			$user = \Data::$main_user;
		else
			$user = new User($id);
		$user->set('*');

		//getting full user name
		$login = $user->get('login');
		$displayed_login = '@' . $login;

		$u_name = $user->get('u_name');
		$u_surname = $user->get('u_surname');

		$isset_name = false;
		$u_full_name = '';
		if(strlen($u_name . $u_surname) != 0) {
			$isset_name = true;
			$u_full_name = $u_name . ' ' . $u_surname;
		}

		//getting user avatar
		$u_ava = $user->get_u_ava();

		//languageLines
		$user_profile_edit = \Language::get('user_profile_edit', 2);
		$user_profile_edit_2 = \Language::get('user_profile_edit_2', 2);

		$json = json_decode($user->get('parameters'), true, 512, JSON_OBJECT_AS_ARRAY);

		?>
		<!-- main section -->
		<div class="col">
			<div class="section shadow text-center" id="section_main"> <?php

				if($is_owner) { ?>
					<div class="user_profile_edit op-0 op-ts-1">
						<span title="<?= $user_profile_edit[1] ?>"><?= $user_profile_edit[0] ?></span><span title="<?= $user_profile_edit_2[1] ?>"><?= $user_profile_edit_2[0] ?></span>
					</div> <?php
				} ?>

				<div id="user_picture" class="zoomable" style="background-image:url(<?= $u_ava ?>)"></div> <?php

				if($is_owner) { ?>
					<div id="user_picture_edit" class="user_profile_edit_center user_profile_edit_hidden  pt-1 pb-1" title="<?= \Language::get('user_photo_edit', 1) ?>" onclick="modal_edit('image_upload','user_picture',)">
						<i class="fas fa-pencil-alt fam"></i><?= \Language::get('user_photo_edit', 0) ?>
					</div> <?php
				} ?>

				<input type="text" name="user_name_edit" class="user_profile_edit_field" placeholder="<?= \Language::get('user_name') ?>" value="<?= $u_full_name ?>">
				<div class="mb-1"></div><?php
				if($isset_name) { ?>
					<h2 id="user_name" class="user_profile_not_edit"><?= $u_full_name ?></h2>
					<h3 id="user_login" class="user_profile_not_edit"><?= $displayed_login ?></h3> <?php
				}
				else { ?>
					<h2 id="user_name"><?= $displayed_login ?></h2> <?php
				} ?>
				<input type="text" name="user_login_edit" class="user_profile_edit_field" placeholder="<?= \Language::get('login') ?>" value="<?= $displayed_login ?>">

			</div>

			<!-- contacts section -->
			<div class="section shadow" id="contacts_section"> <?php

				if($is_owner) { ?>
					<div class="user_profile_edit op-0 op-ts-1">
						<span title="<?= $user_profile_edit[1] ?>"><?= $user_profile_edit[0] ?></span><span title="<?= $user_profile_edit_2[1] ?>"><?= $user_profile_edit_2[0] ?></span>
					</div> <?php
				} ?>

				<h2 class="section_title" title="<?= \Language::get('contacts', 1) ?>"><?= \Language::get('contacts') ?></h2> <?php

				if(strlen($user->get('u_phone')) > 1) { ?>
					<div class="section_field">
						<h3 class="section_field_title" title="<?= \Language::get('phone', 1) ?>"><?= \Language::get('phone') ?></h3>
						<input name="phone_edit" type="text" class="user_profile_edit_field" value="<?= $user->get('u_phone') ?>">
						<p class="section_field_value user_profile_not_edit"><?= $user->get('u_phone') ?></p>
					</div> <?php
				} ?>


				<div class="section_field">
					<h3 class="section_field_title" title="<?= \Language::get('email', 1) ?>"><?= \Language::get('email') ?></h3>
					<input name="email_edit" type="email" class="user_profile_edit_field" value="<?= $user->get('email') ?>">
					<p class="section_field_value"><?= $user->get('email') ?></p>
				</div>

				<?php

				$u_sm = $user->get('u_sm');
				if(strlen($u_sm) > 1 && strpos($u_sm, '~') !== false) {
					$u_sm = explode('~', $u_sm);

					$sm_names = array_keys(\Site::$sm);
					for($i = 0; $i < count(\Site::$sm); $i++) {
						if(!$is_owner && !array_key_exists($i, $u_sm))
							continue;
						if(!array_key_exists($i, $u_sm))
							$u_sm[$i] = ''; ?>
						<div class="section_field <?php if($is_owner && (strlen($u_sm[$i]) < 1)) echo 'user_profile_edit_hidden'; ?>">
							<h3 class="section_field_title"><?= $sm_names[$i] ?></h3>
							<input name="sm" data-sm_name="<?= $sm_names[$i] ?>" type="text" class="user_profile_edit_field" value="<?= $u_sm[$i] ?>">
							<p class="section_field_value"><?php if(strlen($u_sm[$i]) > 1) echo helper::text2url($u_sm[$i]); ?></p>
						</div> <?php
					}
				}

				?>

			</div>

			<!-- information section -->
			<div class="section shadow" id="information_section"> <?php

				if($is_owner) { ?>
					<div class="user_profile_edit op-0 op-ts-1">
						<span title="<?= $user_profile_edit[1] ?>"><?= $user_profile_edit[0] ?></span><span title="<?= $user_profile_edit_2[1] ?>"><?= $user_profile_edit_2[0] ?></span>
					</div> <?php
				} ?>

				<h2 class="section_title" title="<?= \Language::get('information', 1) ?>"><?= \Language::get('information') ?></h2> <?php

				if(strlen($user->get('u_about')) > 1) { ?>
					<div class="section_field">
						<h3 class="section_field_title" title="<?= \Language::get('about_me', 1) ?>"><?= \Language::get('about_me') ?></h3>
						<input name="about_edit" type="text" class="user_profile_edit_field" value="<?= $user->get('u_about') ?>">
						<p class="section_field_value"><?= $user->get('u_about') ?></p>
					</div> <?php
				} ?>

				<div class="section_field">
					<h3 class="section_field_title" title="<?= \Language::get('last_online', 1) ?>"><?= \Language::get('last_online') ?></h3>
					<div class="custom-control custom-checkbox user_profile_edit_hidden mb-4">
						<input type="checkbox" name="online_edit" class="custom-control-input" id="online_edit" <?= (helper::safeGet('show_last_online', $json, true) == true) ? "checked" : "" ?>>
						<label class="custom-control-label" for="online_edit">
							<span title="<?= \Language::get('show_last_online', 1) ?>">
								<?= \Language::get('show_last_online') ?>
							</span>
						</label>
					</div>
					<p class="section_field_value"><?= helper::format_date($user->get('u_last_online'), 'friendlify') ?></p>
				</div> <?php

				if(strlen($user->get('birth_date')) > 1) { ?>
					<div class="section_field">
						<h3 class="section_field_title" title="<?= \Language::get('birth_date', 1) ?>"><?= \Language::get('birth_date') ?></h3>
						<input name="birth_edit" type="date" class="user_profile_edit_field" value="<?= helper::format_date($user->get('birth_date'), 'html_input') ?>">
						<p class="section_field_value"><?= helper::format_date($user->get('birth_date'), 'friendlify') ?></p>
					</div> <?php
				} ?>

				<div class="section_field">
					<h3 class="section_field_title" title="<?= \Language::get('register_date', 1) ?>"><?= \Language::get('register_date') ?></h3>
					<div class="custom-control custom-checkbox user_profile_edit_hidden mb-4">
						<input type="checkbox" name="register_edit" class="custom-control-input" id="register_edit" <?= (helper::safeGet('show_register_date', $json, true) == true) ? "checked" : "" ?>>
						<label class="custom-control-label" for="register_edit">
							<span title="<?= \Language::get('show_register_date', 1) ?>">
								<?= \Language::get('show_register_date') ?>
							</span>
						</label>
					</div>
					<p class="section_field_value"><?= helper::format_date($user->get('register_date'), 'friendlify') ?></p>
				</div>

			</div>

			<!-- personal section -->
			<div class="section shadow" id="personal_section"> <?php

				if($is_owner) { ?>
					<div class="user_profile_edit op-0 op-ts-1">
						<span title="<?= $user_profile_edit[1] ?>"><?= $user_profile_edit[0] ?></span><span title="<?= $user_profile_edit_2[1] ?>"><?= $user_profile_edit_2[0] ?></span>
					</div> <?php
				} ?>

				<h2 class="section_title" title="<?= \Language::get('personal_life', 1) ?>"><?= \Language::get('personal_life') ?></h2> <?php

				if(strlen($user->get('u_city')) > 1) { ?>
					<div class="section_field">
						<h3 class="section_field_title" title="<?= \Language::get('city', 1) ?>"><?= \Language::get('city') ?></h3>
						<input name="city_edit" type="text" class="user_profile_edit_field m-auto" value="<?= $user->get('u_city') ?>">
						<p class="section_field_value"><?= $user->get('u_city') ?></p>
					</div> <?php
				}

				if(strlen($user->get('u_edu')) > 1) { ?>
					<div class="section_field">
						<h3 class="section_field_title" title="<?= \Language::get('edu', 1) ?>"><?= \Language::get('edu') ?></h3>
						<input name="edu_edit" type="text" class="user_profile_edit_field m-auto" value="<?= $user->get('u_edu') ?>">
						<p class="section_field_value"><?= $user->get('u_edu') ?></p>
					</div> <?php
				} ?>

			</div>

		</div>

		<?php

	}

	public static function validate_profile() {

		return 'ok';
	}

	public static function edit_profile() {

		global $field, $sql;

		$validation_results = self::validate_fields();
		if($validation_results !== '')
			return $validation_results;

		if(!array_key_exists('type', $field))
			return 'false';

		$type = $field['type'];

		switch($type) {
			case 'ava_change':
				if($_FILES['ava']['error'] > 0)
					return 'false';

				if(!in_array($_FILES['ava']['tmp_name'], \Site::$image_formats))
					move_uploaded_file($_FILES['ava']['tmp_name'], 'uploads/' . $_FILES['ava']['name']);
				break;
		}
	}
}


class User {

	public $data = array();


	public function __construct($id) {

		$this->data['id'] = $id;
	}

	public function get($name_of_field) {

		if(array_key_exists($name_of_field, $this->data))
			return $this->data[$name_of_field];
		return $this->set($name_of_field);
	}

	public function get_u_full_name() {

		global $api;

		$u_name = $this->get('u_name');
		$u_surname = $this->get('u_surname');
		if(strlen($u_name . $u_surname) == 0)
			return $this->get('login');
		else
			return $u_name . ' ' . $u_surname;
	}

	public function get_u_ava() {

		$u_ava = $this->get('u_ava');

		if(strlen($u_ava) == 0)
			return \Site::_DEFAULT_AVA_;
		else
			return \Site::link('public/images/users/' . $this->get('login') . '.' . $u_ava);
	}

	public function set($name_of_field) {

		global $sql;

		if($name_of_field === '*')
			$this->data = array_merge($this->data, $sql->r("SELECT * FROM dusers WHERE id=?", $this->data['id']));

		else if(strpos($name_of_field, ', ') !== false)
			$this->data = array_merge($this->data, $sql->r("SELECT " . $name_of_field . " FROM dusers WHERE id=?", $this->data['id']));

		else {
			$this->data[$name_of_field] = $sql->c("SELECT " . $name_of_field . " FROM dusers WHERE id=?", $this->data['id']);
			return $this->data[$name_of_field];
		}

		return null;
	}
}


class helper {

	public static $separator = DIRECTORY_SEPARATOR;
	public static $user_ip = 0;

	private static $syntaxBegin = 'VALUE_';
	private static $syntaxEnd = '_END';
	private static $syntaxUsageIndicatorIndex = 2;


	//public methods
	//main methods
	public static function redirect($link = '') {

		header('Location: ' . \Site::link($link));
	}

	public static function debug_info() {

		$e = new \Exception();
		return '<br><br>Php version => ' . phpversion() . '<br>
			Time => ' . time() . '<br><br>'
			. preg_replace(array('/#/', '/\.php\(/', '/\): /'), array('<br>#', '.php(<b>', '</b>): '), $e->getTraceAsString());
	}

	public static function mayor_error($key) {

		\MainController::actionHeader();
		self::alert(\Errors::get($key, 2), 'danger');
		\sessionManager::destroy_session();
		die;
	}

	public static function root($path = '') {

		return ROOT . preg_replace('/[\/\\\\]{1}/m', self::$separator, $path);
	}

	public static function safeGet($key, array &$array, $default = '') {

		if(is_array($array) && array_key_exists($key, $array))
			return $array[$key];
		else if($default === 'error')
			die('NO KEY ' . $key . ' IN ARRAY ' . $array . self::debug_info());
		else
			return $default;
	}

	public static function alert($text, $type) {


		if(is_array($text)) {
			$extra = 'title="' . $text[1] . '"';
			$text = $text[0];
		}
		else
			$extra = ''; ?>
		<div class="alert alert-<?= $type ?>" <?= $extra ?>><?= $text ?></div> <?php
	}

	//others methods

	/*public static function upload_file($file_field = null, $check_image = false, $random_name = false) {

		//config
		$path = \Site::getDomain(\Site::$images_path);
		$max_size = \Site::$max_file_size;
		$whitelist_ext = \Site::$image_formats;

		//validation

		if(!$file_field)
			return "Please specify a valid form field name";

		if(!$path) {
			$out['error'][] = "Please specify a valid upload path";
		}

		if(count($out['error']) > 0) {
			return $out;
		}

//Make sure that there is a file
		if((!empty($_FILES[$file_field])) && ($_FILES[$file_field]['error'] == 0)) {

// Get filename
			$file_info = pathinfo($_FILES[$file_field]['name']);
			$name = $file_info['filename'];
			$ext = $file_info['extension'];

//Check file has the right extension
			if(!in_array($ext, $whitelist_ext)) {
				$out['error'][] = "Invalid file Extension";
			}

//Check that the file is of the right type
			if(!in_array($_FILES[$file_field]["type"], $whitelist_type)) {
				$out['error'][] = "Invalid file Type";
			}

//Check that the file is not too big
			if($_FILES[$file_field]["size"] > $max_size) {
				$out['error'][] = "File is too big";
			}

//If $check image is set as true
			if($check_image) {
				if(!getimagesize($_FILES[$file_field]['tmp_name'])) {
					$out['error'][] = "Uploaded file is not a valid image";
				}
			}

//Create full filename including path
			if($random_name) {
				// Generate random filename
				$tmp = str_replace(array('.', ' '), array('', ''), microtime());

				if(!$tmp || $tmp == '') {
					$out['error'][] = "File must have a name";
				}
				$newname = $tmp . '.' . $ext;
			}
			else {
				$newname = $name . '.' . $ext;
			}

//Check if file already exists on server
			if(file_exists($path . $newname)) {
				$out['error'][] = "A file with this name already exists";
			}

			if(count($out['error']) > 0) {
				//The file has not correctly validated
				return $out;
			}

			if(move_uploaded_file($_FILES[$file_field]['tmp_name'], $path . $newname)) {
				//Success
				$out['filepath'] = $path;
				$out['filename'] = $newname;
				return $out;
			}
			else {
				$out['error'][] = "Server Error!";
			}

		}
		else {
			$out['error'][] = "No file uploaded";
			return $out;
		}
	}


if(isset($_POST['submit'])) {

$file = uploadFile('file', true, true);
if(is_array($file['error'])) {

$message = '';
foreach($file['error'] as $msg) {

$message .= '<p>'.$msg.'</p>';
}
} else {
	$message = "File uploaded successfully" . $newname;
}
echo $message;
}
}*/

public
static function fill_into_string($string) {

	while(true) {
		$variableBegin = strpos($string, self::$syntaxBegin);

		if($variableBegin === false)
			break;

		$newValue = substr($string, 0, $variableBegin);
		$variableBegin += strlen(self::$syntaxBegin);
		$variableEnd = strpos(substr($string, $variableBegin), self::$syntaxEnd);

		if($variableEnd === false)
			break;

		$variableName = substr($string, $variableBegin, $variableEnd);
		$variableEnd += strlen(self::$syntaxEnd);
		$variableName = strtolower($variableName);
		$variableValue = \Data::$$variableName;
		$newValue .= $variableValue . substr($string, $variableBegin + $variableEnd);
		$string = $newValue;
	}
	return $string;
}

public
static function replaceData(&$data) {

	if(!is_array($data))
		return self::fill_into_string($data);

	if(!array_key_exists(self::$syntaxUsageIndicatorIndex, $data) || $data[self::$syntaxUsageIndicatorIndex] === 0)
		return $data;

	foreach($data as $key => $value)
		while(true) {
			$newValue = self::fill_into_string($value);
			if($newValue != $value) {
				$value = $newValue;
				$data[$key] = $value;
			}
			else
				break;
		}
	return $data;
}

public
static function is_password_secure($password) {

	//length > 9 = secure
	if(strlen($password) > 9)
		return true;

	//check for 11111
	$first_letter = $password[0];
	for($i = 1; $i < strlen($password); $i++)
		if($first_letter != $password[$i])
			break;
	if($i > strlen($password) * 0.75)
		return false;

	//check for acceding, descending or following numbers
	$count = 0;
	$max_count = 0;
	for($i = 0; $i < strlen($password); $i++) {
		if($count == 0 && is_numeric($password[$i]))
			$count = 1;
		else if($count != 0 && $password[$i] - $password[$i - 1] >= -1 && $password[$i] - $password[$i - 1] <= 1)
			$count++;
		else if($count > $max_count)
			$max_count = $count;
	}
	if($count > $max_count)
		$max_count = $count;
	if($max_count > strlen($password) * 0.75)
		return false;

	//check for common passwords
	$common_passwords = array('123456', 'Password', '12345678', 'qwerty', '12345', '123456789', 'letmein', '1234567', 'football', 'iloveyou', 'welcome', 'monkey', 'abc123', 'starwars', '123123', 'dragon', 'passw0rd', 'master', 'freedom', 'whatever', 'qazwsx', 'trustno1', '654321', 'jordan23', 'harley', 'password1', 'robert', 'matthew', 'jordan', 'asshole', 'daniel');
	if(in_array($password, $common_passwords))
		return false;

	return true;
}

public
static function get_user_ip() {

	if(self::$user_ip != 0)
		return self::$user_ip;

	if(isset($_SERVER['HTTP_CLIENT_IP']))
		self::$user_ip = $_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		self::$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_X_FORWARDED']))
		self::$user_ip = $_SERVER['HTTP_X_FORWARDED'];
	else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		self::$user_ip = $_SERVER['HTTP_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_FORWARDED']))
		self::$user_ip = $_SERVER['HTTP_FORWARDED'];
	else if(isset($_SERVER['REMOTE_ADDR']))
		self::$user_ip = $_SERVER['REMOTE_ADDR'];
	else
		self::$user_ip = 'UNKNOWN';

	return self::$user_ip;
}

public
static function input($label = '', $name = '', $type = 'text', $required = false, $value = '',
                      $placeholder = '', $regex = null, $extra = '', $label_extra = '') {

	if($label === 'other') {
		if($name === '</div>')
			echo '</div>';
		else
			echo '<div class="' . $name . '">';
	}
	else {

		//text submit checkbox radio email date color number button password range tel url file time list select
		// textarea captcha
		$attr = array();

		$t = '';
		$class = '';
		$label_class = '';
		$regexData = '';

		//if class in specified in extra, pull it into class
		if(is_string($extra) && strlen($extra) > 7 && strpos($extra, 'class="') !== false) {
			$classPos = strpos($extra, 'class="') + strlen('class="');
			$className = substr($extra, $classPos, strpos(substr($extra, $classPos), '"'));
			if($className !== false) {
				$class = $className;
				$extra = preg_replace('/class *= *"[^"]*"/m', '', $extra);
			}
		}

		//if class in specified in label_extra, pull it into class
		if(is_string($label_extra) && strlen($label_extra) > 7 && strpos($label_extra, 'class="') !== false) {
			$classPos = strpos($label_extra, 'class="') + strlen('class="');
			$className = substr($label_extra, $classPos, strpos(substr($label_extra, $classPos), '"'));
			if($className !== false) {
				$label_class = $className;
				$label_extra = preg_replace('/class *= *"[^"]*"/m', '', $label_extra);
			}
		}

		$attr['id'] = 'a2' . $name;
		$attr['name'] = $name;
		$attr['type'] = $type;
		$attr['class'] = 'form-control  ' . $class;

		//if regex for field was specified, setup it
		if(is_array($regex) && in_array($type, array('text', 'email', 'date', 'color', 'number', 'password', 'range', 'tel', 'url', 'time', 'textarea'))) {
			$regexData = ' data-regex="' . htmlspecialchars($regex[0]) . '" data-regex_warning1="' . htmlspecialchars($regex[1]) . '"';
			$attr['data-regex'] = htmlspecialchars($regex[0]);
			$attr['data-regex_warning1'] = htmlspecialchars($regex[1]);
			if(array_key_exists(2, $regex)) {
				$regexData .= ' data-regex_warning2="' . htmlspecialchars($regex[2]) . '"';
				$attr['data-regex_warning2'] = htmlspecialchars($regex[2]);
			}
		}

		if($required)
			$attr['required'] = '';
		if(strlen($placeholder) > 0)
			$attr['placeholder'] = $placeholder;

		//if value should be getted from array >>> pull it from array
		if(is_array($value)) {
			switch($value[0]) {
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
					if(is_array($value[0]))
						$attr['value'] = self::safeGet($value[1], $value[0]);
					else if($type != 'list' && $type != 'select') {
						$attr['value'] = $value[0];
						$attr['title'] = $value[1];
						$t .= ' title="' . $value[1] . '"';
					}
					break;
			}
		}
		else if(strlen($value) > 0)
			$attr['value'] = $value;

		if(is_array($label)) {
			$attr['label'] = $label[0];
			$attr['title'] = $label[1];
		}
		else
			$attr['label'] = $label;

		if(strlen($extra) > 0)
			$extra = ' ' . $extra;

		$begin = '';
		if($label !== false && $label !== 0 && $label !== 1 && $label !== '')
			$begin .= '<div class="form-group ' . $label_class . '" ' . $label_extra . '>';
		if(strlen($attr['label']) > 0)
			$begin .= '<label for="' . $attr['id'] . '" title="' . ($attr['title'] ?? '') . '">' . $attr['label'] . '</label>';
		if(($type == 'button' || $type == 'submit' || $type == 'a') && $label !== 0 && $label !== 10 && $label !== '')
			$begin .= '<br>';

		$data = '';

		if($required)
			$r = 'required';
		else
			$r = '';
		if(strlen($placeholder) > 0)
			$p = ' placeholder="' . $placeholder . '"';
		else
			$p = '';

		if($type === 'captcha')
			$data = '<div class="g-recaptcha ' . $class . '" id="' . $attr['id'] . '" data-regex_warning1="' . \Errors::get('captcha_is_necessary', 0) . '" data-regex_warning2="' . \Errors::get('captcha_is_necessary', 1) . '" data-sitekey="' . \Site::$captchaSecretKey . '"></div>';
		else if($type == 'textarea' || $type == 'select' || $type == 'list') {

			if($type == 'textarea')
				$data = '<textarea class="form-control ' . $class . '" name="' . $attr['name'] . '" id="' . $attr['id'] . '" ' . $regexData . $r . $t . $p . $extra . '>' . $attr['value'] . '</textarea>';
			else if($type == 'select' || $type == 'list') {
				if($type == 'select')
					$data = '<select class="form-control ' . $class . '" name="' . $attr['name'] . '" id="' . $attr['id'] . '" ' .
						$r . $t . $p . $extra . '>' . $attr['value'];
				else {
					if(strlen($value[0]) > 0)
						$v = ' value="' . $value[0] . '"';
					else
						$v = '';
					$data = '<input class="form-control ' . $class . '" list="' . $attr['name'] . '" name="' . $attr['name'] . '" id="' . $attr['id'] . '" ' . $r . $t . $v . $p . $extra . '><datalist id="' . $attr['name'] . '">';
				}

				if(!is_array($value)) {
					if($type == 'list')
						$value = array($value);
					else
						$value = array(array($value, $value, false));
				}

				if($type == 'list') {
					foreach($value as $d)
						$data .= '<option value="' . $d[0] . '">';
				}
				else
					foreach($value as $d) {
						if($d[2])
							$s = ' selected';
						else
							$s = '';
						$data .= '<option value="' . $d[0] . '" ' . $s . '>' . $d[1] . '</option>';
					}

				if($type == 'select')
					$data .= '</select>';
				else
					$data .= '</datalist>';
			}
		}
		else if($type == 'button')
			$data = '<button class="btn ' . $required . $class . '" name="' . $attr['name'] . '" id="' .
				$attr['id'] . '" ' . $t . $extra . '>' . $attr['value'] . '</button>';
		else if($type == 'submit')
			$data = '<input type="submit" class="btn ' . $required . $class . '" name="' . $attr['name'] . '" id="' . $attr['id'] . '" ' . $t . $extra . ' value="' . $attr['value'] . '">';
		else if($type == 'a')
			$data = '<a class="btn ' . $required . $class . '" id="' . $attr['id'] . '" ' . $t . $extra . '>' . $attr['value'] . '</a>';
		else {
			if(($type == 'checkbox' || $type == 'radio') && $required) {
				unset($attr['required']);
				$attr['checked'] = '';
			}
			$data = '<input';
			foreach($attr as $key => $value) {
				$data .= ' ' . $key;
				if(strlen($value) > 0)
					$data .= '="' . $value . '"';
			}
			$data .= $extra . '>';
		}

		$end = '';
		if($label !== false && $label !== 0 && $label !== 1 && $label !== '')
			$end .= "</div>\n";

		echo ($begin ?? '') . $data . ($end ?? '');
	}
}

public
static function p($src = 0, $default = null) {

	$ext = glob($src . '.*');
	if($ext)
		return $ext[0];
	else if($default)
		return $default;
	else
		return _DEAFULT_AVA_;
}

public
static function text2url($value, $showimg = 1, $protocols = array('http', 'mail', 'https', 'twitter'), array $attributes = array('target' => '_blank')) {

	$attr = '';
	foreach($attributes as $key => $val) {
		$attr = ' ' . $key . '="' . htmlentities($val) . '"';
	}
	$links = array();
	$value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function($match) use (&$links) {

		return '<' . array_push($links, $match[1]) . '>';
	}, $value);
	foreach((array)$protocols as $protocol) {
		switch($protocol) {
			case 'http':
			case 'https':
				$value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i',
					function($match) use ($protocol, &$links, $attr, $showimg) {

						if($match[1]) {
							$protocol = $match[1];
							$link = $match[2] ?: $match[3];
							if($showimg == 1) {
								if(strpos($link, 'youtube.com') > 0 || strpos($link, 'youtu.be') > 0) {
									$link = '<iframe width="500" height="294" src="https://www.youtube.com/embed/' . end(explode('=', $link)) . '?modestbranding=1" frameborder="0" allowfullscreen></iframe>';
									return '<' . array_push($links, $link) . '></a>';
								}
								if(strpos($link, '.png') > 0 || strpos($link, '.jpg') > 0 || strpos($link, '.jpeg') > 0 || strpos($link, '.gif') > 0 || strpos($link, '.bmp') > 0) {
									return '<' . array_push($links, "<a $attr href=\"$protocol://$link\" class=\"htmllink\"><img src=\"$protocol://$link\" class=\"htmlimg\">") . '></a>';
								}
							}
							return '<' . array_push($links, "<a $attr href=\"$protocol://$link\" class=\"htmllink\">$link</a>") . '>';
						}
					}, $value);
				break;
			case 'mail':
				$value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function($match) use (&$links, $attr) {

					return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\" class=\"htmllink\">{$match[1]}</a>") . '>';
				}, $value);
				break;
			case 'twitter':
				$value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function($match) use (&$links, $attr) {

					return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1] . "\" class=\"htmllink\">{$match[0]}</a>") . '>';
				}, $value);
				break;
			default:
				$value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function($match) use ($protocol, &$links, $attr) {

					return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\" class=\"htmllink\">{$match[1]}</a>") . '>';
				}, $value);
				break;
		}
	}
	return preg_replace_callback('/<(\d+)>/', function($match) use (&$links) {

		return $links[$match[1] - 1];
	}, $value);
}

public
static function str_replace_first($search, $replace, $subject, $reverse = false) {

	if($reverse)
		$pos = strrpos($subject, $search);
	else
		$pos = strpos($subject, $search);
	if($pos !== false)
		return substr_replace($subject, $replace, $pos, strlen($replace));
	return $subject;
}

public
static function str_replace_first_ref($search, $replace, &$subject, $reverse = false) {

	$subject = self::str_replace_first($search, $replace, $subject, $reverse);
}

public
static function format_date($date, string $type) {

	if(!is_numeric($date) || !$date > 0)
		return false;

	if($type == 'html_input' && is_numeric($date) && $date > 0)
		return date('Y-m-d', $date);
	else if($type == 'friendlify')
		return self::friendlyfy_date($date);
}


//private methods

private
static function friendlyfy_date($unix_date) {

	$unix_now = $_SERVER['REQUEST_TIME'];

	if($unix_date <= $unix_now) {//past
		if($unix_now - $unix_date < 10)
			return \Language::get('just_now');
		if($unix_now - $unix_date < 60)
			return \Language::get('language_ago_before') . ' ' . ($unix_now - $unix_date) . ' ' . \Language::get('x_sec_ago');
		if($unix_now - $unix_date < 3600)
			return \Language::get('language_ago_before') . ' ' . round(($unix_now - $unix_date) / 60) . ' ' . \Language::get('x_min_ago');
		if($unix_now - $unix_date < 86400)
			return \Language::get('language_ago_before') . ' ' . round(($unix_now - $unix_date) / 3600) . ' ' . \Language::get('x_hours_ago');
		if($unix_now - $unix_date < 86400 * 365)
			return date('d.m', $unix_date);

		return date('d.m.Y', $unix_date);
	}
	else {//future
		if($unix_date - $unix_now < 10)
			return \Language::get('in_few_seconds');
		if($unix_date - $unix_now < 60)
			return \Language::get('after') . ' ' . ($unix_now - $unix_date) . ' ' . \Language::get('x_sec');
		if($unix_date - $unix_now < 3600)
			return \Language::get('after') . ' ' . round(($unix_now - $unix_date) / 60) . ' ' . \Language::get('x_min');
		if($unix_date - $unix_now < 86400)
			return \Language::get('after') . ' ' . round(($unix_now - $unix_date) / 3600) . ' ' . \Language::get('x_min');
		if($unix_date - $unix_now < 86400 * 365)
			return date('d.m', $unix_date);

		return date('d.m.Y', $unix_date);
	}

}
}


class sql {

	private $connection;
	private $tableNamesA;
	private $tableNamesB;
	private $specialSymbol;

	/*static function correct($str,$replace=1,$html=1){
		if($replace==1)
			$str=replaceForbit($str);
		if($replace==2)
			$str=replaceLight($str);
		if($html)
			$str=htmlentities($str, ENT_QUOTES);*/
	/*if(isInjected($str)){
		alert('Заборонено використовувати наступні слова: union, select, delete, insert, alter, drop','danger');
		logg($file,10,'SQL injection detected');
		exit('SQL injection detected');
	}*/
	/*	return $str;
	}*/
	function logg($dir, $type, $val) {

		if(\Data::$main_user != null) {
			$str = 'id';
			$id = \Data::$main_user->$$str;
		}
		else
			$id = '';
		q('INSERT INTO ' . _LOG_ . '(domain,directory,eTime,ip,userID,type,val) VALUES("' . \Site::getDomain() . '","' . $dir . '","' . date('H:i:s d:m:y') . '","' . $_SERVER['REMOTE_ADDR'] . '","' . $id . '","' . $type . '","' . $val . '")', null);
	}

	function __construct($host, $login, $password, $dbname, $tableNames, $specialSymbol = '?', $createTables = false) {

		$this->connection = new \mysqli($host, $login, $password, $dbname);

		if($this->connection->connect_error)
			die('Connection failed: ' . $this->connection->connect_error);
		if(!is_array($tableNames))
			die('Invalid table names');

		$this->specialSymbol = $specialSymbol;
		$this->tableNamesA = array();
		$this->tableNamesB = array();

		$defaultTableData = null;
		if($createTables) {
			$defaultTableData = array();
			$defaultTableData["users"] = /*"CREATE TABLE IF NOT EXISTS `mydbname`.`dusers` ( `id` INT NOT NULL AUTO_INCREMENT , `login` VARCHAR(40) NOT NULL , `hash` VARCHAR(64) NOT NULL , `email` VARCHAR(254) NOT NULL , `register_date` INT(10) NOT NULL , `birth_date` INT(10) NOT NULL , `u_name` VARCHAR(40) NOT NULL , `u_surname` VARCHAR(40) NOT NULL , `u_city` VARCHAR(60) NOT NULL , `u_edu` VARCHAR(70) NOT NULL , `u_sm` VARCHAR(600) NOT NULL , `u_about` TEXT NOT NULL , `u_ava` VARCHAR(20) NOT NULL , `u_phone` VARCHAR(200) NOT NULL, `u_last_online` INT(10) NOT NULL, `type` INT(10) NOT NULL , `parameters` VARCHAR(200) NOT NULL , `register_ip` VARCHAR(15) NOT NULL , `banned_ips` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;"*/'';
			$defaultTableData["simple_users"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dsusers` ( `id` INT NOT NULL AUTO_INCREMENT , `login` VARCHAR(40) NOT NULL , `hash` VARCHAR(64) NOT NULL , `email` VARCHAR(254) NOT NULL , `ip` VARCHAR(15) NOT NULL, PRIMARY KEY (`id`)) ENGINE = MyISAM;";
			$defaultTableData["simple_products"] = "CREATE TABLE `mydbname`.`dsproducts` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `short_content` text NOT NULL,
  `date` int(10) NOT NULL,
  `date_edit` int(10) NOT NULL,
  `url` varchar(240) NOT NULL,
  `meta_title` text NOT NULL,
  `meta_description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;";
			$defaultTableData["posts"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dposts` (
				`id` int(16) NOT NULL AUTO_INCREMENT,
				`name` varchar(100) NOT NULL,
				`content` text NOT NULL,
				`type` int(2) NOT NULL DEFAULT '0',
				`keywords` text NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;";
			$defaultTableData["products"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dproducts` (
				`id` int(10) DEFAULT NULL,
				`name` varchar(60) DEFAULT NULL,
				`price` varchar(5) DEFAULT NULL,
				`link` varchar(20) DEFAULT NULL,
				`b_link` varchar(10) DEFAULT NULL,
				`o1` text,
				`o2` text,
				`o3` text,
				`yt` varchar(15) DEFAULT NULL,
				`keywords` varchar(255) DEFAULT NULL,
				`vis` bit(1) NOT NULL DEFAULT b'1',
				`keyVal` int(3) NOT NULL AUTO_INCREMENT,
				`views` int(6) NOT NULL DEFAULT '0',
				`buys` int(6) NOT NULL DEFAULT '0',
				`unixTime` varchar(15) DEFAULT NULL,
				`comments` text,
				`parameters` varchar(100) NOT NULL DEFAULT '01111100:1:1:1:0:0:0:0',
				PRIMARY KEY (`keyVal`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;";
			$defaultTableData["mv"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dmv` (
				`name` varchar(256) NOT NULL,
				`value` text NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;";
			$defaultTableData["mv2"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dmv2` (
				`name` varchar(256) NOT NULL,
				`value` MEDIUMTEXT NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;";
			$defaultTableData["logins"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dlogins` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`domain` varchar(30) NOT NULL,
				`user` int(10) NOT NULL,
				`ip` varchar(15) NOT NULL,
				`time` int(10) NOT NULL,
				`type` int(10) NOT NULL,
				`info` varchar(60) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;";
			$defaultTableData["log"] = "CREATE TABLE IF NOT EXISTS `mydbname`.`dlog` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`domain` varchar(50) NOT NULL,
				`directory` varchar(50) NOT NULL,
				`eTime` varchar(20) NOT NULL,
				`ip` varchar(16) NOT NULL,
				`userID` int(5) NOT NULL DEFAULT '-1',
				`type` int(11) NOT NULL,
				`val` text NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;";
		}

		foreach($tableNames as $d) {
			$this->tableNamesA[] = '/' . $d[0] . '/';
			$this->tableNamesB[] = '`' . $d[1] . '`';

			if($createTables && is_array($defaultTableData) && array_key_exists($d[2], $defaultTableData) && strlen
				($defaultTableData[$d[2]]) && strlen($d[2]))
				$this->a(preg_replace(array('/mydbname/', '/' . $d[0] . '/'), array($dbname, $d[1]), $defaultTableData[$d[2]]));
		}

	}

	function disconect() {

		$this->connection->close();
	}

	function getlastid() {

		return $this->connection->insert_id;
	}

	static function fetch(\mysqli_result $res) {

		return $res->fetch_array(MYSQLI_ASSOC);
	}

	function count($result) {

		return $result->num_rows;
	}

	function c(string $query) {

		return call_user_func_array(array($this, 'a'), func_get_args())->fetch_row()[0];
	}

	function r(string $query) {

		return call_user_func_array(array($this, 'a'), func_get_args())->fetch_assoc();
	}

	function a(string $query) {

		if(!is_string($query))
			die(var_dump($query) . " is not a string. Debug info:<br>" . helper::debug_info());
		if(strlen($query) < 1)
			return null;

		$query = preg_replace($this->tableNamesA, $this->tableNamesB, $query);

		$args = func_get_args();
		array_shift($args);
		$numberOfArgs = count($args);

		if(substr_count($query, $this->specialSymbol) != $numberOfArgs)
			die('Number of paramethers (' . substr_count($query, $this->specialSymbol) . ') != number of ' . $this->specialSymbol . " in query (" . $numberOfArgs . ")(" . $query . "). Debug info:<br>" . helper::debug_info());

		if($numberOfArgs == 0)
			return $this->connection->query($query);

		$stmt = $this->connection->prepare($query);
		if($stmt === false)
			trigger_error('Wrong SQL: ' . $query . ' Error: ' . $this->connection->errno . ' ' . $this->connection->error . "<br>Debug info:<br>" . helper::debug_info(), E_USER_ERROR);
		//$stmt->bind_param();

		$a_params = array();
		$argsTypes = '';
		$a_params[] = &$argsTypes;

		for($i = 0; $i < $numberOfArgs; $i++) {

			switch(gettype($args[$i])) {
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

		//echo var_dump($query);
		//echo var_dump($a_params);

		call_user_func_array(array($stmt, 'bind_param'), $a_params);
		$stmt->execute();
		return $stmt->get_result();
	}

	function res2data($res) {

		$data = array();
		while($row = $this->fetch($res))
			$data[] = $row;

		return $data;

	}
}