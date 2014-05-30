<?php

/**
 * Class SessionModel
 *
 * This class isn't exactly a singleton, because it only modifies the global
 * _SESSION variable, and thus has no need for an instantiation. Instead,
 * instantation and even getting instance is prohibited; this class exists only
 * to use its static functions.
 */
class SessionModel {

	function __construct() {}

	public static function get($key = false){
		if($key){
			if(array_key_exists($key, $_SESSION)){
				return $_SESSION[$key];
			}
		}
		return false;
	}

	public static function set($key = false, $value = false){
		if($key){
			$_SESSION[$key] = $value;
		}
	}

}