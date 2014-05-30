<?php

/**
 * The post class will handle business logic of blog posts,
 * i.e.,execution of CRUD (create, read, update, and delete).
 */
class PostModel extends Model {

	/**
	 * Creates a post in posts table, returns the ID of post
	 * @return mixed
	 */
	public function create() {
		// Retrieve the POST data from controller::getParams()
		$this->getControllerData(array('postTitle', 'postBody'));

		try {
			$stmt = $this->db->prepare("INSERT INTO $this->table (title,body,created) VALUES (:title, :body, NOW())");

			$stmt->bindParam(':title', $this->data['postTitle']);
			$stmt->bindParam(':body', $this->data['postBody']);

			$stmt->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		// Store msg for successful operation
		SessionModel::set('msg','Your post has been successfully created.');

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
			$stmt = $this->db->query("SELECT * FROM posts WHERE id =  $id");
		} catch (PDOException $e) {
			echo "Connection Error:  $e->getMessage()";
		}

     	$data = $stmt->fetch(PDO::FETCH_ASSOC);
		$data = (!empty($data)) ? new GenericModel($data) : false;
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
			$stmt = $this->db->prepare("UPDATE $this->table SET title = :title, body = :body, modified = NOW() WHERE id = $id");

			$stmt->bindParam(':title', $this->data['postTitle']);
			$stmt->bindParam(':body', $this->data['postBody']);

			$stmt->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		// Store msg for successful operation
		SessionModel::set('msg','Your post has been successfully updated.');
	}

	/**
	 * Deletes post from database.
	 *
	 * @param $id
	 */
	public function delete($id) {

		try {
			$this->db->query("DELETE FROM $this->table WHERE id = $id");
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		Factory::getModel('Comment')->delete($id);

		// Store msg for successful operation
		SessionModel::set('msg','Your post has been successfully deleted.');
	}


}