<?php


class Router{

	private $routes;


	public function __construct(){

		$routersPath = \Api\helper::root('config/routes.php');
		$this->routes = require_once($routersPath);
	}


	// return request string

	public function run(){

		$uri = $this->getURI();

		if($uri == '')
			$uri = 'mainPage';

		$data = $this->searchForMethod($uri);
		if($data === FALSE)
			$data = [['errors/404/$1', Language::get('404title'), '', '', FALSE, ''], '404\/(.*)', '404/' . base64_encode($uri)];
		$this->callMethod($data);

	}

	// find controller and action

	private function getURI(){

		if(!empty($_SERVER['REQUEST_URI']))
			return trim($_SERVER['REQUEST_URI'], '/');
		die('REQUEST_URI IS EMPTY');
	}

	private function searchForMethod($uri){

		foreach($this->routes as $uriPattern => $data)
			if(preg_match("/^$uriPattern$/", $uri))
				return [$data, $uriPattern, $uri];

		return FALSE;
	}

	// call needed method

	private function callMethod($data){

		global $call_error;

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

		//create array of parameters
		$parameters = $segments;

		// get file path
		$controllerFile = \Api\helper::root('controllers/' . $controllerName . '.php');

		// include if exists
		if(file_exists($controllerFile))
			require_once($controllerFile); else
			die($controllerFile . ' : FILE NOT EXIST');

		Data::$thisPage = $controllerName . '/' . $actionName;
		Data::$current_uri = $uri;
		Data::$currentSettings = $routeParams;

		if(isset($call_error))
			\Api\helper::mayor_error($call_error);

		$controllerObject = new $controllerName();
		call_user_func_array([$controllerObject, $actionName], $parameters);

		//display Footer
		if($routeParams[0] !== NULL)
			MainController::actionFooter();

	}

	private function validateParams(&$params){

		$defValues = ['', '', '', FALSE, FALSE, FALSE];

		for($i = 0; $i < count($defValues); $i++)
			if(!array_key_exists($i, $params))
				$params[$i] = $defValues[$i];
	}

}