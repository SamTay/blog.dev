<?php

/* Find DELETE and kill those rows
   Find MODEL / VIEW and modify those once classes are defined */

/**
 * Class PostController
 * This class should be used when clicking on a particular post. For any page
 * that views multiple posts, use ListController
 */

class PostController extends FrontController {


	public function __construct() {}

    /**
     * Default Action: Read most recent post.
     */
    public function index() {
//        $this->read(MODEL_Posts->getRecent()); OR some other default page
        echo('Index action not yet created. Planning on read()ing most recent post.');
    }


    /**
     * Creates blog post. If $data is null, ask model for the next posting ID.
     * Then the form action will load the same uri: blog.dev/post/create/&keys=values&etc,
     * but will have _POST information to pass to the model.
     */
    public function create() {

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
				$this->view($id);
			}
        }
    }


    public function view($id=null) {

		//If view() called with no argument
		if (is_null($id)) {

			// If param exists in URI, retrieve it
			if (self::getParam('id')) {
				$id = self::getParam('id');

			// If not, default to view the most recent post
			} else {
				$id = Factory::getModel('Post')->getRowCount();
			}
		}

		$data = Factory::getModel('Post')->read($id);
		Factory::getView('Post', $data);
    }

    public function update($id) {

    }

    public function delete($id) {

    }



}