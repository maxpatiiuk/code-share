<?php

class UsersController{

	//front end
	public static function actionLogin(){

		if(Data::$main_user !== NULL || array_key_exists('hash', $_SESSION))
			\Api\helper::redirect();

		Data::formatData("extra", "assign", '<script src="https://www.google.com/recaptcha/api.js"></script>');

		MainController::actionHeader();

		\Api\lrp::login(func_get_args());
	}

	public static function actionRegister(){

		if(Data::$main_user !== NULL || array_key_exists('hash', $_SESSION))
			echo 'Redirect: ' . Site::link();

		MainController::actionHeader();
		\Api\lrp::register(func_get_args());
	}

	public static function actionProfile(){

		Data::formatData("extra", "assign", '<link rel="stylesheet" href="' . Site::link('public/css/api' . Data::$css_ext) . '">');
		MainController::actionHeader();

		\Api\lrp::profile(func_get_args());
	}

	public static function actionAdvancedProfileEdit(){

		Data::formatData("extra", "assign", '<link rel="stylesheet" href="' . Site::link('public/css/api' . Data::$css_ext) . '">');
		MainController::actionHeader();

		\Api\lrp::advanced_edit_profile(func_get_args());
	}

	public static function actionLogout(){

		MainController::actionHeader();

		\Api\lrp::log_out();
	}

	public static function actionConfirmEmail(){

		MainController::actionHeader();

		$args = func_get_args();
		if(count($args) !== 2 || !is_numeric($args[0]) || strlen($args[1]) !== 10)
			\Api\helper::alert(Language::get('invalid_link', 2), 'danger'); else
			\Api\lrp::confirm_email($args[0], $args[1]);
	}

	public static function actionResetEmail(){

		MainController::actionHeader();

		$args = func_get_args();

		if(Data::$main_user !== NULL)
			\Api\helper::redirect('profile/');
		if(count($args) !== 2 || !is_numeric($args[0]) || strlen($args[1]) !== 10)
			\Api\helper::alert(Language::get('invalid_link', 2), 'danger'); else
			\Api\lrp::reset_email($args[0], $args[1]);
	}

	public static function actionResetPassword(){

		MainController::actionHeader();

		$args = func_get_args();

		if(Data::$main_user !== NULL)
			\Api\helper::redirect('profile/edit/'); elseif(count($args) !== 2 || !is_numeric($args[0]) || strlen($args[1]) !== 10)
			\Api\helper::alert(Language::get('invalid_link', 2), 'danger');
		else
			\Api\lrp::reset_password($args[0], $args[1]);
	}

	public static function actionChangePassword(){

		MainController::actionHeader();

		if(Data::$main_user !== NULL)
			\Api\helper::redirect('profile/edit/'); else
			\Api\lrp::change_password();
	}

	public static function actionDelete(){

		\Api\lrp::delete_user(func_get_args());

	}

	public static function actionBan(){

		\Api\lrp::ban_user(func_get_args());

	}


	//back end
	public static function actionValidateLogin(){

		if(Data::$main_user !== NULL || array_key_exists('hash', $_SESSION))
			echo Errors::to_json('redirect', Site::link(), FALSE); else
			echo \Api\lrp::validate_login();
	}

	public static function actionValidateRegister(){

		if(Data::$main_user !== NULL || array_key_exists('hash', $_SESSION))
			echo Errors::to_json('redirect', Site::link(), FALSE);

		echo \Api\lrp::validate_register(func_get_args());
	}

	public static function actionNeedLoginCaptcha(){

		if(Data::$main_user !== NULL || array_key_exists('hash', $_SESSION))
			echo 'Redirect: ' . Site::link();

		echo \Api\lrp::need_login_captcha();
	}

	public static function actionNeedRegisterCaptcha(){

		if(Data::$main_user !== NULL || array_key_exists('hash', $_SESSION))
			echo 'Redirect: ' . Site::link();

		echo \Api\lrp::need_register_captcha();
	}

	public static function actionEditProfile(){

		echo \Api\lrp::edit_profile(func_get_args());
	}

	public static function actionAdvancedEditProfile(){

		echo \Api\lrp::edit_profile_advanced(func_get_args());
	}

	public static function actionValidateResetEmail(){

		$args = func_get_args();

		if(Data::$main_user !== NULL)
			echo json_encode(['error' => 1, 'msg' => 'user_logged_in']);
		if(count($args) !== 2 || !is_numeric($args[0]) || strlen($args[1]) !== 10)
			echo json_encode(['error' => 1, 'msg' => 'invalid_link']); else
			echo \Api\lrp::validate_reset_email($args[0], $args[1]);
	}

	public static function actionValidateResetPassword(){

		$args = func_get_args();

		if(Data::$main_user !== NULL)
			echo json_encode(['error' => 1, 'msg' => 'user_logged_in']);
		if(count($args) !== 2 || !is_numeric($args[0]) || strlen($args[1]) !== 10)
			echo json_encode(['error' => 1, 'msg' => 'invalid_link']); else
			echo \Api\lrp::validate_reset_password($args[0], $args[1]);
	}

	public static function actionValidateChangePassword(){

		if(Data::$main_user !== NULL)
			echo json_encode(['error' => 1, 'msg' => 'user_logged_in']); else
			echo \Api\lrp::validate_change_password();
	}

	public static function actionDeleteValidate(){

		echo \Api\lrp::user_deleted(func_get_args());

	}

	public static function actionBanValidate(){

		echo \Api\lrp::user_baned(func_get_args());

	}

}