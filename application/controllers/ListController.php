<?php

class ListController extends FrontController {

	public function __construct() {}

    private $view = array();


    /**
     * Default action for ListController; simply lists recent posts in a grid
     */
    public function index() {
//        $this->set(MODEL_Lists->recent());

    }


    public function view($pg) {
        /*delete stuff*/
        echo('Viewing stuff from the ListController with argument: '.$pg);
    }



}