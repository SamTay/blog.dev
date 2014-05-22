<?php

/**
 * Database Connection class using singleton pattern
 *
 */

class DBConnect {

	protected static $db;

	/**
	 * Ensure no one clones this instance.
	 */
	private function __clone(){}


	/**
	 * Construct declared private because this is a singleton. Upon
	 * creation, creates db connection.
	 */
	private function __construct(){}


	/**
	 * Starts and returns a connection, or if one already exists, simply return connection.
	 *
	 * @return DBConnect
	 */
	static function getConnection() {
		$config = Config::getConfig();

		$host = $config->get('db','host');
		$name = $config->get('db','name');
		$username = $config->get('db','username');
		$password = $config->get('db','password');

		if (!isset(self::$db)) {
			try {
				self::$db = new PDO('mysql:host='.$host.';dbname='.$name, $username, $password);
				self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				echo "Connection Error: " . $e->getMessage();
			}
		}

		return self::$db;
	}
}