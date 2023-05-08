<?php


class Data {

	public static $thisPage = '';//used to identify used controller and action
	public static $main_user = null;//represents current user data
	public static $currentSettings = array();
	public static $current_uri = '';
	public static $cssExt = '.min.css';
	public static $jsExt = '.min.js';

	public static function declare() {

		if(Site::$development) {
			self::$cssExt = '.css';
			self::$jsExt = '.js';
		}

		self::$main_page = Site::link();
	}

	public static $support_link = 'mailto:' . Site::_EMAIL_;
	public static $login_link = 'login:';
	public static $password_reset_link = 'reset/password/';
	public static $main_page = '';//will be set in constructor

	public static function formatData($key, $type = '', $value = '') {

		if(!is_array(self::$currentSettings))
			return '';

		if(is_int($key))
			return \Api\helper::safeGet($key, self::$currentSettings);

		$transform = array(
			'title'       => 0,
			'description' => 1,
			'keywords'    => 2,
			'others'      => 3,
			'container'   => 4,
			'extra'       => 5,
		);

		$result = \Api\helper::safeGet($transform[$key], self::$currentSettings, 'error');

		if($type === 'prepend' && $value !== '')
			self::$currentSettings[$transform[$key]] = $value . $result;
		else if($type === 'append' && $value !== '')
			self::$currentSettings[$transform[$key]] = $result . $value;
		else if($type === 'assign')
			self::$currentSettings[$transform[$key]] = $value;

		return $result;
	}

}