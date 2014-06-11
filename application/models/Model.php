<?php

/**
 * Class Model
 *
 * Abstract class with basic properties/methods that children classes will use.
 */
abstract class Model {

	protected $db;
    protected $table = null;
    public $data = array();

	public function __construct() {
		$this->db = DBConnect::getConnection();
		$this->table = 'posts';
	}


	/**
	 * Refers to controller::getParam to store GET/POST/SERVER variables
	 * in $this->data
	 */
	public function getControllerData($params) {

		// Find the appropriate controller
		$controller = str_replace('Model', 'Controller', get_class($this));

		// Or just use front controller
		if (!class_exists($controller)) {
			$controller = 'FrontController';
		}

		//If these global variables are set, store them in $data
		foreach($params as $param) {
			if (empty($this->data[$param])) {
				if ($controller::getParam($param) !== false) {
					$this->data[$param] = $controller::getParam($param);
				} else {
					throw new Exception("Model could not retrieve parameter: $param from controller.");
				}
			}
		}
	}

	/**
	 * This method will most likely be used solely for testing purposes
	 *
	 * @param $params
	 */
	public function setControllerData($params) {
		// Load in the new values
		foreach ($params as $key=>$value) {
			$this->data[$key] = $value;
		}
	}

	/**
	 * Return the current number of rows in $this->table.
	 *
	 * @return mixed
	 */
	public function getRowCount() {
		try {
			$stmt = $this->db->query('SELECT COUNT(*) AS id FROM '. $this->table);
		} catch (PDOException $e) {
			echo 'Connection Error: ' . $e->getMessage();
		}

		$count = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt->closeCursor();

		return $count['id'];
	}

	/**
	 * Returns the row id numbers as a numbered array (as they may not be sequential).
	 *
	 * @return array
	 */
	public function getRowIds() {
		try {
			$stmt = $this->db->query('SELECT '.$this->table.'.id FROM '. $this->table);
		} catch (PDOException $e) {
			echo "Connection Error: " . $e->getMessage();
		}

		// Unfortunately this stores each id as an array within $idsArray
		$idsArray = $stmt->fetchAll(PDO::FETCH_NUM);

		// This makes a cleaner, 1D array (couldn't make this pretty)
		$ids = array();
		foreach($idsArray as $id) {
			$ids[] = $id[0];
		}

		$stmt->closeCursor();

		return $ids;
	}
}