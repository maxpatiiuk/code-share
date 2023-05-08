<?php


class Data{

	public static $thisPage = '';   //used to identify used controller and action
	public static $main_user = NULL;//represents current user data
	public static $currentSettings = [];
	public static $current_uri = '';
	public static $css_ext = '.min.css';
	public static $js_ext = '.min.js';
	public static $forbidden_logins = ['login', 'logins', 'logout', 'register', 'edit', 'advanced', 'confirm', 'reset', 'class', 'author', 'category', 'main', 'theme'];
	public static $support_link = 'mailto:' . Site::_EMAIL_;
	public static $login_link = '';
	public static $mail_url = "error/mail";//will be set in constructor
	public static $contacts_page = "contacts";
	public static $site_name = '';
	public static $password_reset_link = 'change/password/';//will be set in constructor
	public static $main_page = '';
	public static $closing_tags = '';//will be set in constructor

	public static function declare(){

		if(Site::$development){
			self::$css_ext = '.css';
			self::$js_ext = '.js';
		}

		self::$main_page = Site::link();
		self::$login_link = Site::link('login');
		self::$site_name = Site::_NAME_;
	}//will be set if needed. specifies HTML in footer

	public static function formatData($key,
	                                  $type = '',
	                                  $value = ''
	){

		if(!is_array(self::$currentSettings))
			return '';

		if(is_int($key))
			return \Api\helper::safeGet($key, self::$currentSettings);

		$transform = ['title' => 0, 'description' => 1, 'keywords' => 2, 'others' => 3, 'container' => 4, 'extra' => 5,
		];

		$result = \Api\helper::safeGet($transform[$key], self::$currentSettings, 'error');

		if($type === 'prepend' && $value !== '')
			self::$currentSettings[$transform[$key]] = $value . $result; elseif($type === 'append' && $value !== '')
			self::$currentSettings[$transform[$key]] = $result . $value;
		elseif($type === 'assign')
			self::$currentSettings[$transform[$key]] = $value;

		return $result;
	}

}