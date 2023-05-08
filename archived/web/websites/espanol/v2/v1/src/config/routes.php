<?php
return array(
	//REGEX  RESULT  TITLE  DESCRIPTION  KEYWORDS  OTHERS  CONTAINER  EXTRA
	//'news/([0-9]+)' => array('news/view/$1','Новина','',''),
	//'news' => array('news/index','','',''),
	'mainPage' => array('index/main','','','',false,false,false),
	'index.php' => array('index/main','','','',false,false,false),
	'index.php\?action=login' => array('index/loginForm','Acceder','Acceder','Acceder',false,true,false),//Entrada
	'index.php\?ready=login' => array('index/login','Acceder','Acceder','Acceder',false,true,false),//Entrada
	'index.php\?action=register' => array('index/registerForm','Regístrate','Regístrate','Regístrate',false,true,false),
	'index.php\?ready=register' => array('index/register','Regístrate','Regístrate','Regístrate',false,true,false),
	'index.php\?ready=signout' => array('index/signOut','Regístrate','Regístrate','Regístrate',false,true,false),
	'index.php\?action=profile' => array('index/profile','Regístrate','Regístrate','Regístrate',false,true,false),
	'index.php\?action=add_product' => array('index/main','Acceder','Acceder','Acceder',false,true,false),//Entrada
	'index.php\?action=edit_product' => array('index/main','Acceder','Acceder','Acceder',false,true,false),//Entrada
	'index.php\?ready=product_added' => array('index/product_added','Acceder','Acceder','Acceder',false,true,false),//Entrada
	'index.php\?ready=product_edited' => array('index/product_edited','Acceder','Acceder','Acceder',false,true,false),//Entrada
	'index.php\?ready=product_deleted' => array('index/product_deleted','Acceder','Acceder','Acceder',false,true,false),//Entrada
	'index.php\?action=show_product&product_id=([0-9]+)' => array('index/profile','Regístrate','Regístrate','Regístrate',false,true,false),
	//'profile' => array('users/profile/','Perfil','Perfil','Perfil',false,true,false),
	//'profile\/(\d+)' => array('users/profile/$1','Perfil','Perfil','Perfil',false,true,false),
	//'profile\/(@[A-Za-z0-9_\-]{3,60})' => array('users/profile/$1','Perfil','Perfil','Perfil',false,true,false),
	//'profile\/([A-Za-z0-9_\-]{3,60})' => array('users/profile/$1','Perfil','Perfil','Perfil',false,true,false),

	//'validate\/login' => array('users/validateLogin',NULL),
	//'validate\/register' => array('users/validateRegister',NULL),
	//'validate\/captcha' => array('users/needLoginCaptcha',NULL),
	//'validate\/r_captcha' => array('users/needRegisterCaptcha',NULL),

	//'edit\/profile' => array('users/editProfile',NULL),
);