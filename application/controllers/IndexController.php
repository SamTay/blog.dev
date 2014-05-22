<?php

/**
 * Class IndexController
 *
 * Simple controller for the home page, right now index() method shows
 * the most recent $N posts.
 */
class IndexController extends FrontController {

	public function __construct() {}

    public function index() {
		$N = 6; // defines how many recent posts to show

		$data = Factory::getModel('Post')->readRecent($N);

        Factory::getView('Index', $data);
    }
}