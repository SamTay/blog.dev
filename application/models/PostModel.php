<?php

/**
 * The post class will handle business logic of blog posts,
 * i.e.,execution of CRUD (create, read, update, and delete).
 */
class PostModel extends Model {

    /**
     * Constructor sets table to 'posts', gets db connection, and defines observers.
     */
    public function __construct() {
        $this->table = 'posts';
		$this->db = DBConnect::getConnection();
    }

	/**
	 * Creates a post in posts table, returns the ID of post
	 * @return mixed
	 */
	public function create() {
		// Retrieve the POST data from controller::getParams()
		$this->getControllerData(array('postTitle', 'postBody'));

		try {
			$stmt = $this->db->prepare("INSERT INTO ".$this->table." (title,body,created) VALUES (:title, :body, NOW())");

			$stmt->bindParam(':title', $this->data['postTitle']);
			$stmt->bindParam(':body', $this->data['postBody']);

			$stmt->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		// Store msg for successful operation
		$_SESSION['msg'] = "Your post has been successfully created.";

		return $this->db->lastInsertId();
    }

	/**
	 * Returns all post data identified by row $id (that is, one post at a time)
	 *
	 * @param $id
	 * @return mixed
	 */
	public function read($id) {

		// Select row with $id
		try {
			$stmt = $this->db->query('SELECT * FROM posts WHERE id = ' . $id);
		} catch (PDOException $e) {
			echo "Connection Error: " . $e->getMessage();
		}

		// Store row in associate array $data
		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$data)
			$data['success'] = false;
		else
			$data['success'] = true;

		$stmt->closeCursor();
		return $data;
	}

	/**
	 * This function is pretty inefficent, as it simply calls read() to retrieve
	 * one post at at time. In the future, for lists such as this, I will obviously
	 * just query DB using say, id BETWEEN ids[totalPosts-1] AND ids[totalPosts-N-1].
	 * This will require fetchAll, or while() {fetch}.
	 *
	 * @param $N
	 * @return array
	 */
	public function readRecent($N) {
		$data = array();

		// Get ids of rows and number of rows
		$ids = $this->getRowIds();
		$totalPosts = count($ids);

		// Just in case we are asking for too many
		if ($totalPosts < $N)
			$N = $totalPosts;

		// Call read() on the latest $N posts, store in $data array
		for($i=$totalPosts-1; $i>$totalPosts-$N-1; $i--) {
			$data[] = $this->read($ids[$i]);
		}

		return $data;
	}

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

		if ($sort == 'popularity') {
			echo 'This sort method is not yet defined';
			die;
		}
		try {
			$stmt = $this->db->prepare("SELECT posts.title, posts.body, posts.created, posts.id FROM posts ORDER BY " . $sort);
			$stmt->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();

		return $data;
	}

	/**
	 * Update post with POST data, similiar to create() method.
	 *
	 * @param $id
	 */
	public function update($id) {
		$this->getControllerData(array('postTitle','postBody'));

		try {
			$stmt = $this->db->prepare("UPDATE ".$this->table." SET title = :title, body = :body, modified = NOW() WHERE id = ". $id);

			$stmt->bindParam(':title', $this->data['postTitle']);
			$stmt->bindParam(':body', $this->data['postBody']);

			$stmt->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		// Store msg for successful operation
		$_SESSION['msg'] = "Your post has been successfully updated.";
	}

	/**
	 * Deletes post from database.
	 *
	 * @param $id
	 */
	public function delete($id) {

		try {
			$this->db->query("DELETE FROM ".$this->table." WHERE id = ". $id);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		Factory::getModel('Comment')->delete($id);

		// Store msg for successful operation
		$_SESSION['msg'] = "Your post has been successfully deleted.";
	}


}