<?php

//FRONT CONTROLLER

//TODO: mainfest.json
//TODO: data.mambo.in.ua
//TODO: Api/Correct
//TODO: change main.css > import config.css to config.min.css
//TODO: reset/account/
//TODO: reset/password/
//TODO: delete commented code

//FOR FAR FUTURE
//TODO: js oop
//TODO: dynamic languages
//TODO: MYSQLi > PDO

//Config
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);

spl_autoload_register(function($class_name) {

	if(substr($class_name,0,3) == "Api")
		$class_name = "Api";

	$folders_with_files = array('config', 'components', 'controllers', 'views', 'models');

	foreach($folders_with_files as $value) {
		if(file_exists(ROOT . $value . DIRECTORY_SEPARATOR . $class_name . '.php')) {
			require(ROOT . $value . DIRECTORY_SEPARATOR . $class_name . '.php');
			return true;
		}
	}
	return false;
});

Site::setDomain(preg_replace('/www./', '', $_SERVER['HTTP_HOST']));
Site::setLink(Site::_PROTOCOL_ . '://' . Site::$domain . '/');

//Setup
if(Site::$development) {
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}

//API && SQL
if(is_array(Site::$tables))
	define('_USE_SQL_', true);

if(_USE_SQL_){
	require_once(ROOT . 'components' . DIRECTORY_SEPARATOR . 'Sql.php');

	sessionManager::sessionStart('account',Site::_COOKIE_DURATION_);
	/*if(array_key_exists('hash',$_SESSION) &&  strlen($_SESSION['hash']) > 30){
		if(!is_numeric($_SESSION['user_id']))
			$_SESSION['user_id'] = $sql->c('SELECT id FROM dusers WHERE hash = ?',$_SESSION['hash']);

		$mainUser = new \Api\User($_SESSION['user_id']);

		$type = $mainUser->get('type');
		if($type == 7)
			\Api\helper::mayor_error('user_deleted');
		else if($type == 8)
			\Api\helper::mayor_error('user_banned');

		Data::$main_user = $mainUser;

		if($_SERVER['REQUEST_TIME'] - $_SESSION['last_activity'] > Site::_COOKIE_DURATION_)
			sessionManager::destroy_session();

		$_SESSION['last_activity'] = $_SERVER['REQUEST_TIME'];
		$sql->a('UPDATE dusers SET u_last_online=? WHERE id=?',$_SERVER['REQUEST_TIME'],$_SESSION['user_id']);
	}*/
}

//Router
$router = new Router();
$router->run();