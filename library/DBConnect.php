<?php

/**
 * Database Connection class using singleton pattern
 */

class DBConnect {
	protected static $db;
	private $host = 'localhost';
	private $username = 'root';
	private $password = '7n3ci61t';


	/**
	 * Ensure no one clones this instance.
	 */
	private function __clone(){}


	/**
	 * Construct declared private because this is a singleton. Upon
	 * creation, creates db connection.
	 */
	private function __construct(){
		try {
			self::$db = new PDO('mysql:host='.$this->host.';dbname=blog', $this->username, $this->password);
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