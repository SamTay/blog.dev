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

		// Validate comment text
		$comment = $this->getControllerData(array('comment'));
		if ($comment === false) {
			SessionModel::set('msg','You cannot insert a blank comment, asshole!');
			SessionModel::set('msg-tone', 'danger');
			return false;
		}
		
		// Validate user access
		$user = SessionModel::get('user');
		if ($user === false) {
			SessionModel::set('msg','You must be signed in to comment!');
			SessionModel::set('msg-tone', 'danger');
			return false;
		}
		$userid = Factory::getModel('User')->getUserId($user);

		try {
			$stmt = $this->db->prepare("INSERT INTO $this->table (postid,userid,comment,created) VALUES (:postid,:userid,:comment, NOW())");

			$stmt->bindParam(':postid', $postid);
			$stmt->bindParam(':userid', $userid);
			$stmt->bindParam(':comment',$comment);

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