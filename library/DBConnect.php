<?php

/**
 * Database Connection class using singleton pattern
 */

class DBConnect {
	protected static $db;
	private static  $host = 'localhost';
	private static  $username = 'root';
	private static  $password = '7n3ci61t';


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
		if (!isset(self::$db)) {
			try {
				self::$db = new PDO('mysql:host='.self::$host.';dbname=blog', self::$username, self::$password);
				self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				echo "Connection Error: " . $e->getMessage();
			}
		}

		return self::$db;
	}
}