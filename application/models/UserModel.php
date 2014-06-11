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
		try {
			$this->getControllerData(array('username', 'password', 'passwordCheck'));
		} catch (Exception $e) {
			SessionModel::set('msg', 'Please make sure you fill out each field.');
			SessionModel::set('msg-tone', 'danger');
			return false;
		}

		$valid = $this->checkUsername();

		if ($valid) {
			$valid = $this->checkPassword();
		}

		if ($valid) {
			//Encode with MD5 hash - suggested from Jay
			$this->data['password'] = md5($this->data['password']);

			// Insert (username, password) into users table
			try {
				$stmt = $this->db->prepare("INSERT INTO $this->table (username,password) VALUES (:username, :password)");
				$stmt->bindParam(':username', $this->data['username']);
				$stmt->bindParam(':password', $this->data['password']);
				$stmt->execute();
			} catch (PDOException $e) {
				SessionModel::set('msg',$e->getMessage());
				$valid = false;
			}

			if ($valid) {
				SessionModel::set('msg','Your account has been successfully created.');
			}
		}

		if (!$valid) {
			SessionModel::set('msg-tone', 'danger');
		}

		return $valid;
	}

	public function login() {
		// Get data from UserController
		try {
			$this->getControllerData(array('username', 'password'));
		} catch (Exception $e) {
			SessionModel::set('msg', 'Please make sure you fill out each field when logging in.');
			SessionModel::set('msg-tone', 'danger');
			return false;
		}

		// Encode password
		$this->data['password'] = md5($this->data['password']);

		// If the username exists in db, check username & password combo
		if($this->userExists($this->data['username'])) {
			try {
				$stmt = $this->db->prepare("SELECT COUNT(*) FROM $this->table WHERE username = :username AND password = :password");
				$stmt->bindParam(':username', $this->data['username']);
				$stmt->bindParam(':password', $this->data['password']);
				$stmt->execute();
			} catch (PDOException $e) {
				echo "Connection Error: . $e->getMessage()";
			}
			$rowArray = $stmt->fetch(PDO::FETCH_NUM);
			$count = (int)$rowArray[0];
			$stmt->closeCursor();

			// If username & password combo is found, set session variables and return true
			if ($count>0) {
				SessionModel::set('user', $this->data['username']);
				SessionModel::set('msg', 'You&rsquo;ve successfully logged in.');
				return true;
			// Else password not correct
			} else {
				SessionModel::set('msg','Sorry, that is the incorrect password. Try again.');
			}
		// Else the username did not exist
		} else {
			SessionModel::set('msg','That username does not exist. Try registering first.');
		}

		// If true was not returned above, there must be a problem. Return false.
		SessionModel::set('msg-tone', 'danger');
		return false;
	}

	/**
	 * Retrieve username with primary key $id
	 *
	 * @param $id
	 * @return mixed
	 */
	public function getUser($id) {
		try {
			$stmt = $this->db->prepare("SELECT users.username FROM $this->table WHERE id=:id");
			$stmt->bindParam(':id', $id);
			$stmt->execute();
		} catch (PDOException $e) {
			echo "Connection Error: " . $e->getMessage();
		}
		$rowArray = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		return $rowArray[0];
	}

	/**
	 * Retrieve id with username $username
	 *
	 * @param $username
	 * @return mixed
	 */
	public function getUserId($username) {
		try {
			$stmt = $this->db->prepare("SELECT users.id FROM $this->table WHERE username=:username");
			$stmt->bindParam(':username', $username);
			$stmt->execute();
		} catch (PDOException $e) {
			echo "Connection Error: $e->getMessage()";
		}
		$rowArray = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		return $rowArray[0];
	}

	/**
	 * Checks username and sets error message appropriately
	 */
	public function checkUsername() {

		if (strlen($this->data['username']) < 5) {
			SessionModel::set('msg', 'Username must be at least 5 characters.');
			return false;
		}
		if (!$this->validateChar()) {
			SessionModel::set('msg', 'Username must consist of letters, numbers, and underscores.');
			return false;
		}
		if ($this->userExists()) {
			SessionModel::set('msg', 'Username already exists, please pick another one.');
			return false;
		}
		return true;
	}

	public function checkPassword() {
		if ($this->data['password'] != $this->data['passwordCheck']) {
			SessionModel::set('msg', 'Your two passwords did not match.');
			return false;
		}
		if ($this->data['password']=="") {
			SessionModel::set('msg', 'You must specify a password.');
			return false;
		}
	}

	/**
	 * Validate username characters, NOT length (only because I wanted
	 * to separate the messages for length vs characters).
	 *
	 * @return bool
	 */
	private function validateChar() {
		// Allowed non-alphanumeric characters
		$allowed = array('_');

		// Make sure everything else is alphanumeric
		$this->data['username']= str_replace($allowed, '', $this->data['username']);
		return ctype_alnum($this->data['username']);
	}

	/**
	 * Checks if user exists, returns true if user already exists and
	 * false if username is available.
	 *
	 * @return bool
	 */
	private function userExists() {
		try {
			$stmt = $this->db->prepare("SELECT COUNT(*) FROM $this->table WHERE username = :username");
			$stmt->bindParam(':username', $this->data['username']);
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

	public function update() {}

	public function delete() {}
}