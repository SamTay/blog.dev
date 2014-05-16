<?php

class IndexController {
    public function index() {
		call_user_func_array(array('Posts', 'read'), array(1));	//instead call the readRecent once that is defined...
        TemplateFactory::create('IndexView');
    }
}