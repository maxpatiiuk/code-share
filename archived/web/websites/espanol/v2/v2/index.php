<?php


//FOR FAR FUTURE
//TODO: record video tutorial and send by email after register
//TODO: record video review
//TODO: service worker + notifications
//TODO: replace cyrylics with vars
//TODO: js oop
//TODO: change email template
//TODO: redo input method (parameters > assoc array)
//TODO: if preferred language, send emails in correct language

//AFTER NEW TODOS:
//google analytics
//site
//data
//languages
//errors
//mail
//fields
//sql
//config.css
//manifest json
//TinyMCE language change
//serviceworker urls
//add domain/cron into mambo.in.ua/map/services/cron.php

//Config
use Api\User;

define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);

spl_autoload_register(function($class_name){

	if(substr($class_name, 0, 3) == "Api")
		$class_name = "Api";

	$folders_with_files = ['config', 'components', 'controllers', 'views', 'models'];

	foreach($folders_with_files as $value){
		if(file_exists(ROOT . $value . DIRECTORY_SEPARATOR . $class_name . '.php')){
			require_once(ROOT . $value . DIRECTORY_SEPARATOR . $class_name . '.php');

			return TRUE;
		}
	}

	return FALSE;
}
);

Site::setDomain(preg_replace('/www./', '', $_SERVER['HTTP_HOST']));
Site::setLink(Site::_PROTOCOL_ . '://' . Site::$domain . '/');

//Setup
if(Site::$development){
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}

//API && SQL
if(is_array(Site::$tables))
	define('_USE_SQL_', TRUE);

if(_USE_SQL_){
	require_once(ROOT . 'components' . DIRECTORY_SEPARATOR . 'Sql.php');

	sessionManager::sessionStart('account', Site::_COOKIE_DURATION_);
	if(array_key_exists('hash', $_SESSION) && strlen($_SESSION['hash']) > 30){
		if(!is_numeric($_SESSION['user_id']))
			$_SESSION['user_id'] = $sql->c('SELECT `id` FROM `dusers` WHERE `hash` = ?', $_SESSION['hash']);

		$mainUser = new User($_SESSION['user_id']);
		$type = $mainUser->get('type');
		$json = json_decode($mainUser->get('parameters'), TRUE);
		if($type == 7)
			$call_error = 'user_deleted'; elseif($type == 6)
			$call_error = 'user_banned';
		elseif(\Api\helper::safeGet('is_admin', $json, FALSE) == "true" && Site::$development == FALSE) {
			Site::$development = TRUE;
			ini_set('display_errors', 1);
			error_reporting(E_ALL);
		}

		Data::$main_user = $mainUser;

		if(!array_key_exists('dark_theme', $_SESSION)){
			$_SESSION['dark_theme'] = 0;
			if($json != NULL && Site::$is_dark_theme === FALSE && \Api\helper::safeGet('dark_theme', $json, FALSE) == "true")
				$_SESSION['dark_theme'] = 1;
		}

		if($_SERVER['REQUEST_TIME'] - $_SESSION['last_activity'] > Site::_COOKIE_DURATION_)
			sessionManager::destroy_session();

		if(Site::$comments > 0 && array_key_exists('comments_restore_info', $_COOKIE)){
			$t_info = $_COOKIE['comments_restore_info'];
			$t_info = explode('~', $t_info);
			$t_count = count($t_info);
			$t_new_data = [];

			for($i = 0; $i < $t_count; $i++){
				$t_data = explode('`', $t_info[$i]);
				if($_SERVER['REQUEST_TIME'] - $t_data[1] > 3600 * 5)
					unset($_SESSION[$t_data[0]]); else
					$t_new_data[] = $t_info[$i];
			}

			if(count($t_new_data) == 0)
				setcookie('comments_restore_info', NULL, time(), '/'); else
				setcookie('comments_restore_info', implode('~', $t_new_data), time() + 20 * 86400, '/');

		}

		$_SESSION['last_activity'] = $_SERVER['REQUEST_TIME'];
		$sql->a('UPDATE `dusers` SET `u_last_online`=? WHERE `id`=?', $_SERVER['REQUEST_TIME'], $_SESSION['user_id']);
	}
}

Data::declare();

//Router
$router = new Router();
$router->run();