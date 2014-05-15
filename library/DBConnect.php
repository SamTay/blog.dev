<?php

/**
 * Database Connection class using singleton pattern
 */

class DBConnect {
	protected static $db;

	/**
	 * Construct declared private because this is a singleton. Upon
	 * creation, creates db connection.
	 */
	private function __construct(){
		try {
			self::$db = new PDO('mysql:host=localhost;dbname=blog','root','7n3ci61t');
			self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo "Connection Error: " . $e->getMessage();
		}
	}


	/**
	 * Starts and returns a connection, or if one already exists, simply return connection.
	 *
	 * @return DBConnect
	 */
	static function getConnection() {
		if (!isset(self::$db)) {
			self::$db = new self(); //possibly try just new self();
		}

		return self::$db;
	}
}