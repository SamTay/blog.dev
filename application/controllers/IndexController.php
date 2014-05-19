<?php

class IndexController extends FrontController {

	public function __construct() {}

    public function index() {
		$N = 3; // defines how many recent posts to show

		$data = Factory::getModel('Post')->readRecent($N);

        Factory::getView('Index', $data);
    }
}