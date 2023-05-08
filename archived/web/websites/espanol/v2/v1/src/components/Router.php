<?php


class Router {

	private $routes;


	public function __construct() {

		$routersPath = \Api\helper::root('config/routes.php');
		$this->routes = require_once($routersPath);
	}


	/* return request string */
	private function getURI() {

		if(!empty($_SERVER['REQUEST_URI']))
			return trim($_SERVER['REQUEST_URI'], '/');
		die('REQUEST_URI IS EMPTY');
	}

	/* find controller and action */
	private function seachForMethod($uri) {

		foreach($this->routes as $uriPattern => $data)
			if(preg_match("/^$uriPattern$/", $uri))
				return array($data, $uriPattern, $uri);

		return false;
	}

	private function validateParams(&$params) {

		$defValues = array('', '', '', false, false, false);

		for($i = 0; $i < count($defValues); $i++)
			if(!array_key_exists($i, $params))
				$params[$i] = $defValues[$i];
	}

	/* call needed method */
	private function callMethod($data) {

		Data::declare();

		$routeParams = array_shift($data);
		$uriPattern = array_shift($data);
		$uri = array_shift($data);
		$path = array_shift($routeParams);

		$this->validateParams($routeParams);

		//get internal route
		$internalRoute = preg_replace("^$uriPattern^", $path, $uri);

		//get segments form path
		$segments = explode('/', $internalRoute);

		// get controller name
		$controllerName = array_shift($segments) . 'Controller';
		$controllerName = ucfirst($controllerName);

		// get action name
		$actionName = 'action' . ucfirst(array_shift($segments));

		//create array of paramethers
		$paramethers = $segments;

		// get file path
		$controllerFile = \Api\helper::root('controllers/' . $controllerName . '.php');

		// include if exists
		if(file_exists($controllerFile))
			require_once($controllerFile);
		else
			die($controllerFile . ' : FILE NOT EXIST');

		Data::$thisPage = $controllerName . '/' . $actionName;
		Data::$current_uri = $uri;
		Data::$currentSettings = $routeParams;

		$controllerObject = new $controllerName;
		call_user_func_array(array($controllerObject, $actionName), $paramethers);

		//display Footer
		if($routeParams[0] !== null)
			MainController::actionFooter();

	}

	public function run() {

		$uri = $this->getURI();

		if($uri == '')
			$uri = 'mainPage';

		$data = $this->seachForMethod($uri);
		if($data === false)
			$data = array(array('errors/404/$1', Language::get('404title'), '', '', false, ''), '404\/(.*)', '404/' .
				base64_encode($uri));
		$this->callMethod($data);

	}
}