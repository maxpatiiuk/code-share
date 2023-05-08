<?php

class News {
	public static function getNewsList(){
		global $api;

		$res = $api->sql->a("SELECT * FROM dposts LIMIT 10");

		$data = array();
		while($row = $api->sql->fetch($res))
			$data[] = $row;

		return $data;
	}

	public static function getListById($id){

		global $api;

		$row = $api->sql->r("SELECT * FROM dposts WHERE id=?",intval($id));

		echo var_dump(strlen($row['id']));

		if(strlen($row['id'])<1)
			return false;

		return $row;
	}
}