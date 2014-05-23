<?php

/**
 * Class UserModel
 *
 * Class handles business logic of users, such as creating new users
 * and logging them in. Eventually I can add update/delete options for
 * changing passwords or deleting accounts, etc..
 */
class UserModel extends Model {

	/**
	 * Constructor sets table to 'users' and gets db connection.
	 */
	public function __construct() {
		$this->table = 'users';
		$this->db = DBConnect::getConnection();
	}

	/**
	 * Registers a new user with information retrieved from controller,
	 * returns an array of data which allows tells controller if registration
	 * was successful or not
	 *
	 */
	public function register() {
		// Get data from UserController
		$this->getControllerData();

		$valid = true;
		// Check username
		if (strlen($this->data['username']) < 5) {
			$this->data['Error'] = 'Username must be at least 5 characters.';
			$valid = false;
		}
		if ($valid AND !$this->validateChar($this->data['username'])) {
			$this->data['Error'] = 'Username must consist of letters, numbers, and underscores.';
			$valid = false;
		}
		if ($valid AND $this->userExists($this->data['username'])) {
			$this->data['Error'] = 'Username already exists, please pick another one.';
			$valid = false;
		}

		// Check password
		if ($valid AND $this->data['password'] != $this->data['passwordCheck']) {
			$this->data['Error'] = 'Your two passwords did not match.';
			$valid = false;
		}
		if ($valid AND $this->data['password']=="") {
			$this->data['Error'] = 'You must specify a password.';
			$valid = false;
		}

		// IF valid
		if ($valid){
			//Encode with MD5 hash - suggested from Jay
			$this->data['password'] = md5($this->data['password']);

			// Insert (username, password) into users table
			try {
				$stmt = $this->db->prepare("INSERT INTO ".$this->table." (username,password) VALUES (:username, :password)");
				$stmt->bindParam(':username', $this->data['username']);
				$stmt->bindParam(':password', $this->data['password']);
				$stmt->execute();
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
			// Store msg for successful operation
			$registry = Registry::getInstance();
			$registry->set('msg', "Your account has been successfully created.");
			$this->data['success'] = true;
		}
		else {
			$this->data['success'] = false;
		}

		// Return data to controller
		return $this->data;
	}

	public function login() {
		// Get data from UserController
		$this->getControllerData();

		// Trim username, encode password
		$this->data['username'] = trim($this->data['username']);
		$this->data['password'] = md5($this->data['password']);

		// If the username exists in db, check username & password combo
		if($this->userExists($this->data['username'])) {
			try {
				$stmt = $this->db->prepare("SELECT COUNT(*) FROM ".$this->table." WHERE username = :username AND password = :password");
				$stmt->bindParam(':username', $this->data['username']);
				$stmt->bindParam(':password', $this->data['password']);
				$stmt->execute();
			} catch (PDOException $e) {
				echo "Connection Error: " . $e->getMessage();
			}
			$rowArray = $stmt->fetch(PDO::FETCH_NUM);
			$count = (int)$rowArray[0];
			$stmt->closeCursor();

			// If username & password combo is found, set session variable and set success to true
			if ($count>0) {
				$_SESSION['user'] = $this->data['username'];
				$this->data['success'] = true;
				// Store msg for successful operation
				$registry = Registry::getInstance();
				$registry->set('msg', "You've succcessfully logged in.");

			// Else let the controller know that success is false.
			} else
				$this->data['success'] = false;

			return $this->data;
		}


		}


	/**
	 * Validate username characters, NOT length (only because I wanted
	 * to separate the messages for length vs characters).
	 *
	 * @param $username
	 * @return bool
	 */
	private function validateChar($username) {
		// Allowed non-alphanumeric characters
		$allowed = array('_');

		// Make sure everything else is alphanumeric
		$username = str_replace($allowed, '', $username);
		return ctype_alnum($username);
	}

	/**
	 * Checks if user exists, returns true if user already exists and
	 * false if username is available.
	 *
	 * @param $username
	 * @return bool
	 */
	private function userExists($username) {
		try {
			$stmt = $this->db->prepare("SELECT COUNT(*) FROM ".$this->table." WHERE username = :username");
			$stmt->bindParam(':username', $username);
			$stmt->execute();

			// Count the rows selected
			$rowArray = $stmt->fetch(PDO::FETCH_NUM);
			$count = (int)$rowArray[0];

			$stmt->closeCursor();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		// Return true iff user already exists.
		return ($count > 0);
	}

	public function update($username) {}

	public function delete($username) {}
}