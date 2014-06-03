<?php

/**
 * Class CommentModel
 *
 * This model deals with the comments table. Comments have restricted
 * access, and can only be created by users. They are deleted only
 * when a post is deleted, which is why this class implements Observer
 * pattern.
 */
class CommentModel extends Model {

	/**
	 * Constructor sets table to 'comments' and gets db connection.
	 */
	public function __construct() {
		$this->table = 'comments';
		$this->db = DBConnect::getConnection();
	}

	/**
	 * Create a comment under post with id $postid, get username from session variable
	 *
	 * @param $postid
	 */
	public function create($postid) {
		$this->getControllerData(array('comment'));
		$user = $_SESSION['user'];
		$userid = Factory::getModel('User')->getUserId($user);

		try {
			$stmt = $this->db->prepare("INSERT INTO $this->table (postid,userid,comment,created) VALUES (:postid,:userid,:comment, NOW())");

			$stmt->bindParam(':postid', $postid);
			$stmt->bindParam(':userid', $userid);
			$stmt->bindParam(':comment',$this->data['comment']);

			$stmt->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		// Store msg for successful operation
		SessionModel::set('msg', 'Your comment has been added.');
	}

	/**
	 * Retrieves all comments on post with given id. Returns comments
	 * as an array to controller.
	 *
	 * @param $postid
	 * @return mixed
	 */
	public function getComments($postid) {
		// Select the relevant attributes
		try {
			$stmt = $this->db->prepare("SELECT comments.id, comments.userid, comments.comment, comments.created
				 FROM  $this->table  WHERE postid = :postid ORDER BY created");
			$stmt->bindParam(':postid', $postid);
			$stmt->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		// Store data in generic model container
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($data as &$comment) {
			$comment = new GenericModel($comment);
		}

		// Instantiate UserModel to store username string
		$userDB = Factory::getModel('User');
		foreach ($data as &$comment) {
			$comment->username = $userDB->getUser($comment->userid);
		}
		unset($userDB);

		return $data;
	}

	/**
	 * Deletes all comments associated with postid. This function should only
	 * be called when said post is being deleted.
	 *
	 * @param $postid
	 */
	public function delete($postid) {
		try {
			$this->db->query("DELETE FROM $this->table WHERE postid =  $postid");
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}


}