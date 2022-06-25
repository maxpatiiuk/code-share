<?php


class sessionManager{

	public static function sessionStart($name,
	                                    $limit = 0,
	                                    $path = '/',
	                                    $domain = NULL,
	                                    $secure = NULL
	){

		session_name($name . '_session');

		$domain = isset($domain)
			? $domain
			: Site::$domain;
		$https = isset($secure)
			? $secure
			: Site::_HTTPS_;

		session_set_cookie_params($limit, $path, $domain, $secure, $https);
		session_start();

		//make sure the session hasn't expired, and destroy it if it had
		if(self::session_valid()){

			if(self::session_hijacked()){
				//reset session data and regenerate id
				$_SESSION = [];
				$_SESSION['ip_address'] = \Api\helper::get_user_ip();
				self::regenerate_session();
			} elseif(rand(1, 100) <= 5)
				self::regenerate_session();
		} else {
			session_unset();
			session_destroy();
			session_start();
		}
	}

	private static function session_valid(){

		if(isset($_SESSION['obsolete']) && !isset($_SESSION['expires']))
			return FALSE;

		if(isset($_SESSION['expires']) && $_SESSION['expires'] < time())
			return FALSE;

		return TRUE;
	}

	private static function session_hijacked(){

		if(!isset($_SESSION['ip_address']))
			return TRUE;

		if($_SESSION['ip_address'] != \Api\helper::get_user_ip())
			return TRUE;

		return FALSE;
	}

	public static function regenerate_session(){

		if(array_key_exists('obsolete', $_SESSION) && (isset($_SESSION['obsolete']) || $_SESSION['obsolete'] == TRUE))
			return;

		//set current session to expire in 10 seconds
		$_SESSION['obsolete'] = TRUE;
		$_SESSION['expires'] = time() + 10;

		//create new session without destroying the old one
		session_regenerate_id();

		//grab current session ID and close both sessions to allow other scripts to use them
		$newSession = session_id();
		session_write_close();

		//set session ID to the new one, and start it back up again
		session_id($newSession);
		session_start();

		//now we unset the obsolete and expiration values for the session we want to keep
		unset($_SESSION['obsolete']);
		unset($_SESSION['expires']);

	}

	public static function destroy_session(){

		session_unset();
		session_destroy();
		Data::$main_user = NULL;
	}

}