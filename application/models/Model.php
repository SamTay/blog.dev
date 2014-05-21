<?php

/**
 * Need to Refactor models to keep table as variable (prepare and execute MySQL statements)
 */
abstract class Model {

	protected $db;

    /**
     * Name of database table
     *
     * @var string
     */
    protected $table = null;


    /**
     * The field name in the database
     *
     * @var string
     */
    protected $primaryKey = null;


    /**
     * Container for data retrieved from database
     *
     * @var array
     */

    public $data = array();


	protected function getControllerData() {

		// Find the appropriate controller
		$controller = str_replace('Model', 'Controller', get_class($this));

		// Or just use front controller
		if (!class_exists($controller)) {
			$controller = 'FrontController';
		}

		//If these global variables are set, store them in $data
		if ($controller::getParam('id') !== false)
			$this->data['id'] = $controller::getParam('id');

		if ($controller::getParam('postTitle') !== false)
			$this->data['postTitle'] = $controller::getParam('postTitle');

		if ($controller::getParam('postBody') !== false)
			$this->data['postBody'] = $controller::getParam('postBody');
	}

	/**
	 * Return the current number of rows in posts table.
	 *
	 * @return mixed
	 */
	protected function getRowCount() {
		try {
			$stmt = $this->db->query('SELECT COUNT(*) AS id FROM '. $this->table);
		} catch (PDOException $e) {
			echo "Connection Error: " . $e->getMessage();
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
	protected function getRowIds() {
		try {
			$stmt = $this->db->query('SELECT posts.id FROM '. $this->table);
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