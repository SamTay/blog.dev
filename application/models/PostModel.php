<?php

/**
 * The post class will handle business logic of blog posts,
 * i.e., database connections and execution of CRUD (create,
 * read, update, and delete).
 */
class PostModel extends Model {

    /**
     * Constructor sets tableName to 'posts' and gives us the primaryKey??
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
		$this->getControllerData();

		try {
			$stmt = $this->db->prepare("INSERT INTO ".$this->table." (title,body,created,modified) VALUES (:title, :body, NOW(), NOW())");

//			$stmt->bindParam(':table', $this->table);
			$stmt->bindParam(':title', $this->data['postTitle']);
			$stmt->bindParam(':body', $this->data['postBody']);

			$stmt->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

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

		$totalPosts = $this->getRowCount();

		// Call read() on the latest $N posts, store in $data array
		for($i=$totalPosts; $i>$totalPosts-$N; $i--) {
			$data[] = $this->read($i);
		}

		return $data;
	}
}