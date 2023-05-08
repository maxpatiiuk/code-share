<?php

final class Lang {

	private static $data = array(
		'404title' => 'Perdido?',
	);

	public static function text($key){

		if(array_key_exists($key, self::$data))
			return self::$data[$key];

		die('NO DATA FOR KEY : '.$key.'<br>'.helper::debug_info());

	}

}