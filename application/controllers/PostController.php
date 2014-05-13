<?php

/* Find DELETE and kill those rows
   Find MODEL / VIEW and modify those once classes are defined */

/**
 * Class PostController
 * This class should be used when clicking on a particular post. For any page
 * that views multiple posts, use ListController
 */

class PostController extends FrontController {


    /**
     * Default Action: Read most recent post.
     */
    public function index() {
//        $this->read(MODEL_Posts->getRecent());
    }


    /**
     * Creates blog post. If $data is null, load the view containing form to create post.
     * Then the form action will load the same uri: blog.dev/post/create/&keys=values&etc,
     * but will have _POST information to pass to the model.
     *
     * @param null $data
     */
    public function create($data = null) {
        echo ('Creating stuff from the PostController!');       //DELETE

        if (is_null($data)) {
//            VIEW_Posts->create();
//            Make sure VIEW_Posts->create page uses a POST form.

        } else {
//            Extract the POST information from the form above, modify it to the correct format,
//            store it in $data.

//            $id = MODEL_Posts->create($data);
//            Make sure Model_Posts->create() returns the $id of the created post!

            $this->read($id);

        }
    }

    public function read($id) {
//        MODEL_Posts->read($id);
        PostView->read($id);
    }

    public function edit($id) {
        echo ('Editing stuff from the PostController! Parameter: ' . $id);        //DELETE

//        This function will probably have the same format as $this->create()

//        MODEL_Posts->edit($id);
    }

    public function delete($id) {
//        MODEL_Posts->delete($id);
//        either VIEW_List('index') OR VIEW_Post(previous post (retrieved from previous line));
    }

}