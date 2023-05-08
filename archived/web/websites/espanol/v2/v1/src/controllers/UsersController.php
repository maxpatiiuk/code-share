<?php

class UsersController
{
	public static function actionLogin(){
		if(Data::$main_user !== null || array_key_exists('hash',$_SESSION))
			\Api\helper::redirect();

		Data::formatData("extra","assign",'<script src="https://www.google.com/recaptcha/api.js"></script>');

		MainController::actionHeader();
		\Api\lrp::login();
	}

	public static function actionRegister(){
		if(Data::$main_user !== null || array_key_exists('hash',$_SESSION))
			echo 'Redirect: '.Site::link();

		MainController::actionHeader();
		\Api\lrp::register();
	}

	public static function actionConfirm(){
		MainController::actionHeader();
		\Api\lrp::confirm();
	}

	public static function actionReset(){
		MainController::actionHeader();
		\Api\lrp::reset();
	}

	public static function actionProfile() {
		Data::formatData("extra","assign",'<link rel="stylesheet" href="'.Site::link('public/css/api'.Data::$cssExt).'">');
		MainController::actionHeader();

		\Api\lrp::profile(func_get_args());
	}


	public static function actionValidateLogin() {
		if(Data::$main_user !== null || array_key_exists('hash',$_SESSION))
			echo 'Redirect: '.Site::link();

		echo \Api\lrp::validate_login();
	}

	public static function actionValidateRegister() {
		if(Data::$main_user !== null || array_key_exists('hash',$_SESSION))
			echo 'Redirect: '.Site::link();

		echo \Api\lrp::validate_register();
	}

	public static function actionValidateProfile() {
		echo \Api\lrp::validate_profile();
	}

	public static function actionValidateConfirm() {
		echo \Api\lrp::validate_confirm();
	}

	public static function actionValidateReset() {
		echo \Api\lrp::validate_reset();
	}

	public static function actionNeedLoginCaptcha() {
		if(Data::$main_user !== null || array_key_exists('hash',$_SESSION))
			echo 'Redirect: '.Site::link();

		echo \Api\lrp::need_login_captcha();
	}

	public static function actionNeedRegisterCaptcha() {
		if(Data::$main_user !== null || array_key_exists('hash',$_SESSION))
			echo 'Redirect: '.Site::link();

		echo \Api\lrp::need_register_captcha();
	}

	public static function actionEditProfile(){
		echo \Api\lrp::edit_profile();
	}
}