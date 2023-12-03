<?php
/* TODOs
 - 404
 - config
 - main
*/


final class Site {

	public static $development = true;
	public static $debug = false;

	public static $comments = 4;//How many comments display
	public static $posts = 12;//How many posts per page display
	public static $showCaptchaAfter = 3;
	public static $hardShowCaptchaAfter = 5;
	public static $registeredAccountsBeforeCaptcha = 2;

	public const _DEFAULT_AVA_ = 'https://s8.hostingkartinok.com/uploads/images/2018/01/74c8325ebdff4081319b7ca7adf4e7e8.png';
	public const _DEFAULT_IMG_ = 'https://s8.hostingkartinok.com/uploads/images/2017/10/6360f1658d1b1423e59ddb5c95e1d0d2.jpg';
	public const _AUTHOR_ = 'Max Patiiuk';
	public const _BRAND_COLOR_ = '#eeeeee';
	public const _LOGO_ = 'public/images/logo.png';

	public static $htmlLang = "es";
	public static $charset = "utf-8";

	public static $googleAnalyticsId = 'UA-94002926-1';
	public static $captchaSecretKey = '--hey-was-here--';

	public static $domain;
	public static $link;
	public const _PROTOCOL_ = 'http';
	public const _HTTPS_ = true;
	public const _API_NAME_ = 'Api';

	public static $tables = array(
		//     name  real_name  role - users,posts,products,mv,mv2,log
		array('dusers', 'hh_users', 'simple_users'),
		array('dsusers', 'hh_users', 'simple_users'),
		array('dsproducts', 'hh_posts', 'simple_products'),
		array('dlogins', 'logins', 'logins'),
		array('dlog', 'log', 'log'),
		array('dmv', 'ee', 'mv'),
		array('dcategories', 'ee_categories', 'other'),
	);
	public static $createTables = true;//true only once
	public static $specialSymbol = '?';
	public static $useLRP = true;
	public static $createAdm = true;
	public static $confirmEmail = true;

	public static $sm = array(
		'Facebook' => 'https://s8.hostingkartinok.com/uploads/images/2018/11/9fb953d6fb69f4f60af407b19ec0652e.png',
		'YouTube' => 'https://s8.hostingkartinok.com/uploads/images/2018/11/eef33554a583d0504dbe684fc6e7b827.png',
		'Instagram' => 'https://s8.hostingkartinok.com/uploads/images/2018/11/739f90a24005d3c01381ce8d8af9cda3.png',
		'Steam' => 'https://s8.hostingkartinok.com/uploads/images/2018/11/e5fe46fe151c5460e70cc4a5b7744e1d.png',
		'Twitter' => 'https://s8.hostingkartinok.com/uploads/images/2018/11/de7a2e9f377de66d545ddaaab67ef275.png',
		'Telegram' => 'https://s8.hostingkartinok.com/uploads/images/2018/11/bb445edcf36af41e0fea0bba6b1cd70f.png',
		'LinkedIn' => 'https://s8.hostingkartinok.com/uploads/images/2018/11/3c2077ff7edb526cb5ce8de17dc9ef00.png',
		'Google+' => 'https://s8.hostingkartinok.com/uploads/images/2018/11/19a3202f955412c583eb9c7bdf322ff2.png',
		'Pinterest' => 'https://s8.hostingkartinok.com/uploads/images/2018/11/c4cb06f601a4535b3d2bd9c7ab0a235e.png',
		'Tumblr' => 'https://s8.hostingkartinok.com/uploads/images/2018/11/6ab782dc92f1a5efa57a4e6cfc15ecc2.png',
		'Social Club' => 'https://s8.hostingkartinok.com/uploads/images/2018/11/e48a8716cb177f81c4a052be46e8e2b5.png',
		'Vk' => 'https://s8.hostingkartinok.com/uploads/images/2018/11/8a440c9fb331ea5aba858d28472add53.png',
	);

	public static $mail_colors = array(
		'content_color' => '#555555',
		'footer_color' => '#888888',
		'main_color' => '#eeeeee',
		'second_color' => '#ffffff',
	);

	public const _COOKIE_DURATION_ = 86400 * 14;//2 weeks
	public const _NAME_ = 'Español';
	public const _EMAIL_ = 'max@patii.uk';
	public const _REAL_EMAIL_ = 'max@patii.uk';
	public const _TITLE_ = self::_NAME_;
	public const _DESCRIPTION_ = self::_NAME_ . ' - entrenamiento electrónico';
	public const _KEYWORDS_ = 'espanol, español, entrenamiento electrónico, entrenamiento moderno, electrónico, entrenamiento, escuela, escuela moderna, ' . self::_AUTHOR_;

	public static function getDomain() {

		return self::$domain;
	}

	public static function setDomain($value) {

		self::$domain = $value;
	}

	public static function setLink($value) {

		self::$link = $value;
	}

	public static function link($value = '') {

		return self::$link . $value;
	}

}