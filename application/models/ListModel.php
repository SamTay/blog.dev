<?php

/**
 * Class ListModel
 */
class ListModel extends Model {


	/**
	 * Read all posts sorted by $sort, or default if $sort is not
	 * called correctly. Return posts as array.
	 *
	 * @param $sort
	 * @param $search
	 * @return mixed
	 */
	public function read($sort, $search=null) {

		// Ensure sort option is enabled
		if (array_search($sort,ListController::getSortOptions()) === false)
			$sort = array_values(ListController::getSortKey())[0];

		// Retrieve data in different ways according to sort method
		switch ($sort) {
			case ('popularity'):
				$sql = 'SELECT posts.title, posts.body, posts.id, COUNT(comments.postid) AS count FROM posts LEFT JOIN comments ON posts.id = comments.postid
						GROUP BY posts.id ORDER BY count DESC';
				if ($search) {
					$sql = substr_replace($sql,$search,strpos($sql,'GROUP BY'),0);
				}
				break;

			// default case is the same as 'created'
			default:
				$sql = 'SELECT posts.title, posts.body, posts.created, posts.id FROM posts ORDER BY ' . $sort;
				if ($search) {
					$sql = substr_replace($sql,$search,strpos($sql,'ORDER BY'),0);
				}
				break;
		}

		// Execute the sql statement
		try {
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		// Store data in generic model container
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($data as &$post) {
			$post = new GenericModel($post);
		}
		$stmt->closeCursor();

		return $data;
	}

	/**
	 * Returns any post that contains the given string,
	 * very rudimentary search. String already verified
	 * by controller
	 *
	 * @param $sort
	 * @param $needle
	 * @return string
	 */
	public function search($sort, $needle) {
		// Generate sql
		$needle = '%'.$needle.'%';
		$sql = " WHERE body LIKE '$needle' OR title LIKE '$needle' ";

		// Call on view with search parameter
		return $this->read($sort, $sql);
	}

	/**
	 * Returns N most recent posts for the home page
	 * @param $N
	 */
	public function recent($N) {
		// getRowIds refers to $this table, and we need post table
		$ids = Factory::getModel('Post')->getRowIds();
		$indexStart = $ids[count($ids) - $N];
		$indexEnd = end($ids);

		try {
			$stmt = $this->db->prepare("SELECT posts.id, posts.title, posts.body, posts.created
										FROM posts WHERE id BETWEEN :indexStart AND :indexEnd");
			$stmt->bindParam(':indexStart', $indexStart);
			$stmt->bindParam(':indexEnd', $indexEnd);
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		// Load into generic model container
		foreach($data as &$post) {
			$post = new GenericModel($post);
		}
		$stmt->closeCursor();

		return $data;
	}
}