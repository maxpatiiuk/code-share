<?php
/* TODOs
 - 404
 - config
 - main
*/

final class Site {

	public static $development = true;
	public static $debug = false;

	public static $comments=4;//How many comments display
	public static $posts=12;//How many posts per page display

	public const _DEAFULT_AVA_ = 'https://s8.hostingkartinok.com/uploads/images/2018/01/74c8325ebdff4081319b7ca7adf4e7e8.png';
	public const _DEAFULT_IMG_ = 'https://s8.hostingkartinok.com/uploads/images/2017/10/6360f1658d1b1423e59ddb5c95e1d0d2.jpg';
	public const _AUTHOR_ = 'Max Patiiuk';
	public const _BRAND_COLOR_ = '#eeeeee';

	public static $htmlLang="es";
	public static $charset="utf-8";

	public static $googleAnaliticsId = 'UA-94002926-1';

	public static $domain;
	public static $link;
	public const _PROTOCOL_ = 'https';
	public const _API_NAME_ = 'Api';

	public static $tables = array(
		//     name  real_name  role - users,posts,products,mv,mv2,log
		array('dsusers','hh_users','simple_users'),
		array('dusers','hh_users',''),
		array('dsproducts','hh_posts','simple_products'),
		array('dsposts','hh_posts',''),
		array('dlog','log','log'),
		array('dlogins','logins','logins'),
		array('dmv','hh','mv'),
	);
	public static $createTables = false;//only once
	public static $specialSymbol = '?';
	public static $useLRP = true;
	public static $createAdm = true;

	public static $image_formats = array('jpeg','jpg','jif','jfjf','png','bmp','gif','tiff','tif','svg','iff','webp');
	public static $images_path = 'public/images/ava/';
	public static $max_file_size = 3 * 1024 * 1024; //3mb

	public const _COOKIE_DURATION_ = 86400*14;//2 weeks
	public const _DEBUG_ = 'true';
	public const _NAME_ = 'Español';
	public const _EMAIL_ = 'max@patii.uk';
	public const _REAL_EMAIL_ = 'max@patii.uk';
	public const _TITLE_ = self::_NAME_;
	public const _DESCRIPTION_ = self::_NAME_.' - entrenamiento electrónico';
	public const _KEYWORDS_ = 'espanol, español, entrenamiento electrónico, entrenamiento moderno, electrónico, entrenamiento, escuela, escuela moderna, '.self::_AUTHOR_;

	public static function getDomain(){
		return self::$domain;
	}
	public static function setDomain($value){
		self::$domain = $value;
	}
	public static function setLink($value){
		self::$link = $value;
	}

	public static function link($value){
		return self::$link . $value;
	}

}