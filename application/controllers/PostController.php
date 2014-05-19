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
     * Creates blog post. If $data is null, load the view containing form to create post.
     * Then the form action will load the same uri: blog.dev/post/create/&keys=values&etc,
     * but will have _POST information to pass to the model.
     *
     * @param null $data
     */
    public function create($data = null) {

        if (is_null($data)) {

//            Make sure VIEW_Posts->create page uses a POST form.

        } else {

//            $id = MODEL_Posts->create($data);
//            Make sure Model_Posts->create() returns the $id of the created post!

        }
    }


    public function view() {
		$id = $_GET['id'];
		$data = Factory::getModel('Post')->read($id);
		Factory::getView('Post', $data);
    }

    public function update($id) {

    }

    public function delete($id) {

    }

}