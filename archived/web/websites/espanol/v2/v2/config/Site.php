<?php


final class Site{

	public const _DEFAULT_AVA_ = 'https://s8.hostingkartinok.com/uploads/images/2018/01/74c8325ebdff4081319b7ca7adf4e7e8.png';//always true for admins
	public const _DEFAULT_IMG_ = 'https://s8.hostingkartinok.com/uploads/images/2017/10/6360f1658d1b1423e59ddb5c95e1d0d2.jpg';
	public const _AUTHOR_ = 'Maksym Patiiuk';//How many comments display // 0 = hidden
	public const _BRAND_COLOR_ = '#ffaa11';
	public const _LOGO_ = 'public/images/logo.png';//How many posts per page display // -1 - infinite
	public const _PROTOCOL_ = 'https';
	public const _HTTPS_ = TRUE;
	public const _USE_SERVICE_WORKER_ = FALSE;
	public const _COOKIE_DURATION_ = 86400 * 14;
	public const _NAME_ = 'Español';
	public const _EMAIL_ = 'max@patii.uk';
	public const _REAL_EMAIL_ = 'max@patii.uk';
	public const _ADMIN_EMAIL_ = 'max@patii.uk';
	public const _SHOW_CONTACTS = TRUE;//whether dark_mode is always on
	public const _CONTACTS_ = ['tel'      => [''], //'tel2' => ['',''],
	                           'email'    => [1],//use Site::_EMAIL_
	                           'addr'     => ['avenida Renacimiento, 20 A, c.Lutsk, Ukraine', 'пр-т. Відродження, 20 А, м.Луцьк, Україна'], //'addr2' => ['',''],
	                           'facebook' => [''], 'instagram' => [''], 'twitter' => [''], 'pinterest' => [''],
	];
	public const _TITLE_ = self::_NAME_;
	public const _DESCRIPTION_ = self::_NAME_ . ' - entrenamiento electrónico';
	public const _KEYWORDS_ = 'espanol, español, entrenamiento electrónico, entrenamiento moderno, electrónico, entrenamiento, escuela, escuela moderna, ' . self::_AUTHOR_;
	public const _LANGUAGE_MODE_ = -1;
	public static $development = FALSE;
	public static $debug = FALSE;
	public static $comments = 10;
	public static $allow_anonymous_comments = TRUE;
	public static $posts_per_page = 8;
	public static $showCaptchaAfter = 3;
	public static $hardShowCaptchaAfter = 5;
	public static $registeredAccountsBeforeCaptcha = 2;
	public static $background_color = '#ffffff';//only once
	public static $is_dark_theme = FALSE;
	public static $htmlLang = "es";
	public static $charset = "utf-8";
	public static $googleAnalyticsId = 'UA-108610375-1';
	public static $captchaSecretKey = '--key-was--here--';
	public static $imgbb_api_key = '--key-was-here--';
	public static $google_site_verification = 'google440a11905e70b281.html'; //32mb
	public static $domain;
	public static $link;
	public static $tables = [//     name  real_name  role - users,posts,products,mv,mv2,log
	                         ['dusers', 'e_users', 'users'], ['dposts', 'e_posts', 'posts'], ['dlogins', 'logins', 'logins'], ['dlog', 'log', 'log'], ['dcategories', 'e_categories', 'other'],
	];
	public static $createTables = FALSE;
	public static $specialSymbol = '?';
	public static $confirmEmail = TRUE;  //dusers>parameters[class]
	public static $users_can_post = TRUE;//dposts>verify
	public static $image_formats = ['jpeg', 'jpg', 'jif', 'jfjf', 'png', 'bmp', 'gif', 'tiff', 'tif', 'svg', 'iff', 'webp'];
	public static $forbidden_extensions = ['exe', 'msi', 'cmd', 'bat', 'reg', 'html', 'php', 'xml', 'js', 'css', 'ini', 'asp', 'asm', 'asc', 'xap', 'jar', 'com', 'bash', 'sh'];//2 weeks
	public static $images_path = 'public/images/users/';
	public static $max_file_size = 32 * 1024 * 1024;
	public static $sm_prefix = 'public/images/sm';
	public static $sm = ['Facebook' => ['https://www.facebook.com/'], 'YouTube' => ['https://www.youtube.com/channel/'], 'Instagram' => ['https://www.instagram.com/'], 'Steam' => ['https://steamcommunity.com/id/'], 'Twitter' => ['https://twitter.com/'], 'Telegram' => ['https://t.me/'], 'LinkedIn' => ['http://ca.linkedin.com/in/', 'linked_in'], 'Google+' => ['https://plus.google.com/', 'g_plus'], 'Pinterest' => ['https://www.pinterest.com/'], 'Tumblr' => ['https://www.tumblr.com/blog/'], 'Social Club' => ['https://socialclub.rockstargames.com/member/', 'social_club'], 'VK' => ['https://vk.com/'],
	];
	public static $extra_sm = ['phone' => 'phone', 'email' => 'email',
	];
	public static $mail_colors = ['content_color' => '#555555', 'footer_color' => '#888888', 'main_color' => '#eeeeee', 'second_color' => '#ffffff',
	];
	public static $current_language = 0;
	public static $use_classes = TRUE;
	public static $need_to_verify = TRUE;
	public static $seo = FALSE;

	/*
	 * -1 - second lang on hover
	 * 0 - regular
	 * */

	public static function getDomain(){

		return self::$domain;
	}

	public static function setDomain($value){

		self::$domain = $value;
	}

	public static function setLink($value){

		self::$link = $value;
	}

	public static function link($value = ''){

		return self::$link . $value;
	}

	public static function server_link($link = ''){

		return ROOT . $link;
	}

}

/*

User Types:
7- deleted
6- banned
5- silent admin
4- silent user
3- partial admin? (may be buggy)
2- admin
1- regular

 * */
