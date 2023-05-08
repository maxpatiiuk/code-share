<?php

class Main
{
	public static $paramethers;

	public static function getMeta($paramethers = null)
	{

		if(is_array($paramethers))
			self::$paramethers = $paramethers;

		$title = self::$paramethers[0];
		$description = self::$paramethers[1];
		$keywords = self::$paramethers[2];

		if($title)
			$title .= ' - ';
		$title .= Site::_TITLE_;
		if($description)
			$description .= ".\n";
		$description .= Site::_DESCRIPTION_;
		if($keywords)
			$keywords .= ".\n";
		$keywords .= Site::_KEYWORDS_;

		return '<meta name="keywords" content="' . $keywords . '">
			<meta name="description" content="' . $description . '">
			<title>' . $title . '</title>';
	}

	public static function getMenuItems()
	{

		global $sql;

		$res = $sql->a("SELECT id,name FROM dcategories WHERE type = 0");
		$data = $sql->res2data($res);

		return $data;

	}

	public static function getLink($class = null, $type = null, $category = null)
	{
		$url = '';

		if(strlen($class) !== 0)
			$url .= '/class/' . $class;

		if(strlen($type) !== 0)
			$url .= '/type/' . $type;

		if(strlen($category) !== 0)
			$url .= '/category/' . $category;

		return $url;
	}
}