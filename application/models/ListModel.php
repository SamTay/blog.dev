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
	 * @return mixed
	 */
	public function readAll($sort) {

		// Ensure sort option is enabled
		if (array_search($sort,ListController::getSortOptions()) === false)
			$sort = array_values(ListController::getSortKey())[0];

		// Retrieve data in different ways according to sort method
		switch ($sort) {
			case ('popularity'):
				try {
					$stmt = $this->db->prepare("SELECT posts.title, posts.body, posts.id, COUNT(comments.postid) AS count FROM posts LEFT JOIN comments ON posts.id = comments.postid
												GROUP BY posts.id ORDER BY count DESC");
					$stmt->execute();
				} catch (PDOException $e) {
					echo $e->getMessage();
				}
				break;
			// default case is the same as 'created'
			default:
				try {
					$stmt = $this->db->prepare("SELECT posts.title, posts.body, posts.created, posts.id FROM posts ORDER BY " . $sort);
					$stmt->execute();
				} catch (PDOException $e) {
					echo $e->getMessage();
				}
				break;
		}
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();

		return $data;
	}

	/**
	 * Returns any post that contains the given string,
	 * very rudimentary search. String already verified
	 * by controller
	 *
	 * @param $needle
	 */
	public function search($needle) {
		$needle = '%'.$needle.'%';
		try {
			$stmt = $this->db->prepare("SELECT posts.title, posts.body, posts.created, posts.id FROM posts WHERE body LIKE :needle ORDER BY created");
			$stmt->bindParam(':needle', $needle);
			$stmt->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();

		return $data;
	}
}