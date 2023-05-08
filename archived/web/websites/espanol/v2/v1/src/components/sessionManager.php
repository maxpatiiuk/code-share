<?php


class sessionManager {

	public static function sessionStart($name, $limit = 0, $path = '/', $domain = null, $secure = null) {

		session_name($name . '_session');

		$domain = isset($domain) ? $domain : Site::$domain;
		$https = isset($secure) ? $secure : Site::_HTTPS_;

		session_set_cookie_params($limit, $path, $domain, $secure, $https);
		session_start();

		if(!self::prevent_hijacking()) {
			$_SESSION = array();
			$_SESSION['ip_address'] = \Api\helper::get_user_ip();
			$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		}

		//make sure the session hasn't expired, and destroy it if it has
		if(self::validate_session()) {

			if(!self::prevent_hijacking()) {
				//reset session data and regenerate id
				$_SESSION = array();
				$_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
				self::regenerate_session();
			}
			else if(rand(1, 100) <= 5) {
				self::regenerate_session();
			}
		}
		else {
			session_unset();
			session_destroy();
			session_start();
		}
	}

	public static function destroy_session(){
		session_unset();
		session_destroy();
		Data::$main_user = null;
	}

	private static function prevent_hijacking() {

		if(!isset($_SESSION['ip_address']) || !isset($_SESSION['user_agent']))
			return false;

		if($_SESSION['ip_address'] != \Api\helper::get_user_ip())
			return false;

		if($_SESSION['user_agent'] != $_SERVER['HTTP_USER_AGENT'])
			return false;

		return true;
	}

	public static function regenerate_session() {

		if(array_key_exists('obsolete',$_SESSION) && (isset($_SESSION['obsolete']) || $_SESSION['obsolete'] == true))
			return;

		//set current session to expire in 10 seconds
		$_SESSION['obsolete'] = true;
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

	private static function validate_session() {

		if(isset($_SESSION['obsolete']) && !isset($_SESSION['expires']))
			return false;

		if(isset($_SESSION['expires']) && $_SESSION['expires'] < time())
			return false;

		return true;
	}

}