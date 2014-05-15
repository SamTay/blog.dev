<?php

class IndexController {
    public function index() {
        TemplateFactory::create('IndexView');
    }
}