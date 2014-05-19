<?php

class AboutController extends FrontController {

	public function __construct() {}

    public function index() {
        $this->details();
    }
    public function details() {
        Factory::getView('AboutDetails');
    }
    public function contact() {
        Factory::getView('AboutContact');
    }
}