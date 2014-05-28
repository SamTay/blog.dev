<?php


/**
 * Class PostController
 * This class should be used when clicking on a particular post. For any page
 * that views multiple posts, use ListController. Once ListController is defined,
 * refactor and put readRecent in there.
 */

class PostController extends FrontController {


	public function __construct() {}

    /**
     * Default Action: Read most recent post.
     */
    public function index() {
		//Get most recent post's id
		$id = Factory::getModel('Post')->getRowIds()[Factory::getModel('Post')->getRowCount() - 1];

		// Get model data and send it to view
		$data = Factory::getModel('Post')->read($id);
		Factory::getView('Post', $data);
	}


    /**
     * Creates blog post. If method is not POST, load the createpostview (form).
     * Then the form action will load the same uri: blog.dev/post/create
     * but will have _POST information to pass to the model.
     */
    public function create() {
		$this->adminPrivelege();

		// If request is not POST, get CreatePostView
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
			Factory::getView('CreatePost');

		// Else check for valid entries
        } else {
			$data = array();
			$data['postTitle'] = trim($_POST["postTitle"]);				/* REFACTOR to check if POST variables exist or not */
			$data['postBody'] = trim($_POST["postBody"]);

			// If invalid, get CreatePostView again
			if ($data['postTitle']=="" OR $data['postBody']=="") {
				$data['postError'] = 'You must specify a title and body.';
				Factory::getView('CreatePost', $data);

			// If Valid, send post to PostModel for insertion
			} else {
				$id = Factory::getModel('Post')->create();
				header('location:'.BASE_URL.'/post/view?id='.$id);
			}
        }
    }

	/**
	 * Views post with id given from argument or URI
	 *
	 * @param null $id
	 */
	public function view($id=null) {

		// If view() called with no argument
		if (is_null($id)) {

			// If param exists in URI, retrieve it
			if (self::getParam('id')) {
				$id = self::getParam('id');

			// If not, default to view the most recent post
			} else {
				$id = Factory::getModel('Post')->getRowIds()[Factory::getModel('Post')->getRowCount() - 1];
			}
		}

		// Get model data
		$data = Factory::getModel('Post')->read($id);

		// If post info was received, get the comments and generate view
		if ($data['success']) {
			$data['comments'] = Factory::getModel('Comment')->getComments($id);
			Factory::getView('Post', $data);

		// Otherwise, get most recent post												/* REFACTOR TO INCLUDE ERROR PAGE */
		} else {
			$_SESSION['msg'] = 'Sorry, that post doesn&rsquo;t exist. This is the most recent post.';
			$_SESSION['msg-tone'] = 'warning';
			header('location: ' . BASE_URL . DS . 'post' . DS . 'view');
		}
    }

	/**
	 * Updates blog post. If id is not retrievable, throws exception.
	 * This creates and/or modifies the "modified" value in database.
	 *
	 * @param null $id
	 * @throws Exception
	 */
	public function update($id=null) {
		$this->adminPrivelege();

		// If update() called with no argument
		if (is_null($id)) {

			// If param exists in URI, retrieve it
			if (self::getParam('id') !== false) {
				$id = self::getParam('id');

				// If not, throw exception
			} else {
				throw new Exception('Post id not found.'); //maybe redirect to error page?
			}
		}

		// If the update form has not yet been submitted
		if ($_SERVER['REQUEST_METHOD'] != 'POST') {

			// Get model data and send it to view
			$data = Factory::getModel('Post')->read($id);
			Factory::getView('UpdatePost', $data);

		// Else if the form has been submitted
		} else {

			// Send data to model and view the upated post
			Factory::getModel('Post')->update($id);
			header('location:'.BASE_URL.'/post/view?id='.$id);
		}
    }

	/**
	 * Delete function simply deletes post with given id. If no id
	 * is given, throws an exception. The confirmation to delete
	 * happens within the HTML "on-click" attribute.
	 *
	 * @param null $id
	 * @throws Exception
	 */
	public function delete($id=null) {
		$this->adminPrivelege();

		// If delete() called with no argument
		if (is_null($id)) {

			// If param exists in URI, retrieve it
			if (self::getParam('id') !== false) {
				$id = self::getParam('id');

				// If not, throw exception
			} else {
				throw new Exception('Post id not found.'); //maybe redirect to error page?
			}
		}

		// Delete the post and load the home page.
		Factory::getModel('Post')->delete($id);
		header('location:'.BASE_URL);
    }

	/**
	 * Ensures user is signed in, then stores comment and loads post view
	 */
	public function comment($id=null) {
		$this->userPrivelege();
		// If comment() called with no argument
		if (is_null($id)) {

			// If param exists in URI, retrieve it
			if (self::getParam('id') !== false) {
				$id = self::getParam('id');

				// If not, throw exception
			} else {
				throw new Exception('Post id not found.'); //maybe redirect to error page?
			}
		}

		$comment = trim(self::getParam('comment'));

		// If comment is empty, redirect to post/view with angry message
		if ($comment == "") {
			$_SESSION['msg'] = 'You cannot insert a blank comment, asshole!';
			$_SESSION['msg-tone'] = 'danger';
			header('location:' . BASE_URL . '/post/view?id='.$id);

		// Otherwise, store comment in DB and reload the post view
		} else {
			Factory::getModel('Comment')->create($id);
			header('location:' . BASE_URL . '/post/view?id='.$id);
		}

	}

}