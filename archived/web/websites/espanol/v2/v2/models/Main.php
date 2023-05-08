<?php


class Main{

	public static $parameters;

	public static function getMeta($parameters = NULL){

		if(is_array($parameters))
			self::$parameters = $parameters;

		$title = self::$parameters[0];
		$description = self::$parameters[1];
		$keywords = self::$parameters[2];

		if($title)
			$title .= ' - ';
		$title .= Site::_TITLE_;
		if($description)
			$description .= ".\n";
		$description .= Site::_DESCRIPTION_;
		if($keywords)
			$keywords .= ", ";
		$keywords .= Site::_KEYWORDS_;

		return '<meta name="keywords" content="' . $keywords . '">
			<meta name="description" content="' . $description . '">
			<title>' . $title . '</title>';
	}

	public static function getMenuItems(){

		global $sql;

		$res = $sql->a("SELECT `id`,`name` FROM `dcategories` WHERE `class` = 0 AND `type` = 0");
		$data = $sql->res2data($res);
		if(!$data)
			$data = [];

		return $data;

	}

	public static function getLink($class = NULL,
	                               $category = NULL,
	                               $theme = NULL,
	                               $author = NULL,
	                               $show_unverified = FALSE,
	                               $page = 1
	){

		$url = '';

		if(strlen($class) !== 0 && $class != 0)
			$url .= 'class/' . $class . '/';

		if(strlen($theme) !== 0 && $theme != -1)
			$url .= 'theme/' . $theme . '/';

		if(strlen($category) !== 0 && $category != -1)
			$url .= 'category/' . $category . '/';

		if(strlen($author) !== 0 && $author != -1)
			$url .= 'author/' . $author . '/';

		if($show_unverified)
			$url .= 'unverified/1/';

		if(is_numeric($page) && $page > 1)
			$url .= 'page/' . $page . '/';

		return $url;
	}
}