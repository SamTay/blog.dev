<?php

/**
 * The post class will handle business logic of blog posts,
 * i.e., database connections and execution of CRUD (create,
 * read, update, and delete).
 */
class Posts extends Models {

    /**
     * Constructor sets tableName to 'posts' and gives us the primaryKey??
     *
     * @param 'string'
     * @return void
     */
    public function __constructor($fieldname) {
        $this->table = 'posts';
        $this->primaryKey = $fieldname;
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
		$stmt = $this->db->prepare('SELECT * FROM :table WHERE id = :id');

		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':table', $this->table, PDO::PARAM_STR);

		$stmt->execute();

		$registry = Registry::getInstance();
		$registry->set('Post->read', $stmt->fetch(PDO::FETCH_ASSOC));

	}
}