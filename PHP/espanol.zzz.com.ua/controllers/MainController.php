<?php

require_once(\Api\helper::root("models/Main.php"));


class MainController{

	public static function actionHeader($parameters = NULL){

		if($parameters === NULL)
			$parameters = Data::$currentSettings;

		$uri = Data::$current_uri;

		if($uri == 'mainPage')
			$uri = '';

		$result = [];

		$result['meta'] = Main::getMeta($parameters);

		require_once(\Api\helper::root("views/Main.php"));

		self::actionMenu();

		return TRUE;
	}

	public static function actionMenu(){

		$menuItems = Main::getMenuItems();

		foreach($menuItems as $key => $value)
			if($value['name'] == 'Todas')
				unset($menuItems[$key]);

		$menuItems = array_values($menuItems);

		require_once(\Api\helper::root("views/Menu.php"));

		return TRUE;

	}

	public static function actionFooter(){

		require_once(\Api\helper::root("views/Footer.php"));

		return TRUE;

	}

}