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
     * Hopefully this function will eventually be used to create a blog post
	 * with body $body and title $title.
     *
     * @param string $body
	 * @param string $title
	 */
    public function create($title, $body) {
		try {
			$this->db->beginTransaction();



			$this->db->commit();
		} catch (PDOException $e) {
			$this->db->rollback();
			echo $e->getMessage();
		}
    }

	public function read($id) {

//		$stmt = $this->db->prepare('SELECT * FROM :table WHERE id = :id');
//
//		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
//		$stmt->bindParam(':table', $this->table, PDO::PARAM_STR);
//
//		$stmt->execute();


//		$sql_query = $this->db->quote('SELECT * FROM posts WHERE id = ' . $id);
//
		try {
			$stmt = $this->db->query('SELECT * FROM posts WHERE id = ' . $id);
		} catch (PDOException $e) {
			echo "Connection Error: " . $e->getMessage();
		}

		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt->closeCursor();

		return $data;
	}

	public function readRecent($N) {
		$data = array();

		$totalPosts = 3;		//FIGURE OUT HOW TO GET TOTAL POSTS.
		for($i=$totalPosts; $i>$totalPosts-$N; $i--) {
			$data[] = $this->read($i);
		}

		return $data;
	}
}