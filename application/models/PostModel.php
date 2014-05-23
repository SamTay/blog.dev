<?php

/**
 * The post class will handle business logic of blog posts,
 * i.e.,execution of CRUD (create, read, update, and delete).
 */
class PostModel extends Model {

    /**
     * Constructor sets table to 'posts' and gets db connection.
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
		$this->getControllerData();

		try {
			$stmt = $this->db->prepare("INSERT INTO ".$this->table." (title,body,created) VALUES (:title, :body, NOW())");

			$stmt->bindParam(':title', $this->data['postTitle']);
			$stmt->bindParam(':body', $this->data['postBody']);

			$stmt->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		// Store msg for successful operation
		$registry = Registry::getInstance();
		$registry->set('msg', "Your post has been successfully created.");

		return $this->db->lastInsertId();
    }

	public function read($id) {

		// Select row with $id
		try {
			$stmt = $this->db->query('SELECT * FROM posts WHERE id = ' . $id);
		} catch (PDOException $e) {
			echo "Connection Error: " . $e->getMessage();
		}

		// Store row in associate array $data
		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt->closeCursor();
		return $data;
	}

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
	 * Update post with POST data, similiar to create() method.
	 *
	 * @param $id
	 */
	public function update($id) {
		$this->getControllerData();

		try {
			$stmt = $this->db->prepare("UPDATE ".$this->table." SET title = :title, body = :body, modified = NOW() WHERE id = ". $id);

			$stmt->bindParam(':title', $this->data['postTitle']);
			$stmt->bindParam(':body', $this->data['postBody']);

			$stmt->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		// Store msg for successful operation
		$registry = Registry::getInstance();
		$registry->set('msg', "Your post has been successfully updated.");
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

		// Store msg for successful operation
		$registry = Registry::getInstance();
		$registry->set('msg', "Your post has been successfully deleted.");
	}


}