<?php

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
		$this->getControllerData();
		$user = $_SESSION['user'];
		$userid = Factory::getModel('User')->getUserId($user);

		try {
			$stmt = $this->db->prepare("INSERT INTO ".$this->table." (postid,userid,comment,created) VALUES (:postid,:userid,:comment, NOW())");

			$stmt->bindParam(':postid', $postid);
			$stmt->bindParam(':userid', $userid);
			$stmt->bindParam(':comment',$this->data['comment']);

			$stmt->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		// Store msg for successful operation
		$_SESSION['msg'] = "Your comment has been added.";
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
			$stmt = $this->db->prepare("SELECT comments.id, comments.userid, comments.comment, comments.created"
				. " FROM " . $this->table . " WHERE postid = :postid ORDER BY created");
			$stmt->bindParam(':postid', $postid);
			$stmt->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// Instantiate UserModel to store username string
		$userDB = Factory::getModel('User');
		foreach ($data as &$comment) {
			$comment['username'] = $userDB->getUser($comment['userid']);
		}
		unset($userDB);

		return $data;
	}
}