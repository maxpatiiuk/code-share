<?php

require_once(\Api\helper::root("models/Main.php"));

class MainController
{

	public static function actionHeader($paramethers = NULL)
	{
		if($paramethers === NULL)
			$paramethers = Data::$currentSettings;

		$uri = Data::$current_uri;

		if($uri == 'mainPage')
			$uri = '';

		$result = array();

		//$defineMeta = $paramethers[0] !== false;
		//if($defineMeta)
		$result['meta'] = Main::getMeta($paramethers);

		require_once(\Api\helper::root("views/Main.php"));

		self::actionMenu();

		return true;
	}

	public static function actionMenu()
	{
		$uri = Data::$current_uri;

		if(preg_match('/category/',$uri))
			$category = substr($uri, strpos($uri,'category') + strlen('category') + 1, strpos($uri,'category') +
				strpos( substr( $uri, strpos($uri,'category') + 2 ), '/') );
		else
			$category = null;

		$menuItems = Main::getMenuItems();

		require_once(\Api\helper::root("views/Menu.php"));

		return true;

	}

	public static function actionFooter()
	{

		require_once(\Api\helper::root("views/Footer.php"));

		return true;

	}
}