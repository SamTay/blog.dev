<?php

class IndexController {
    public function index() {
        TemplateFactory::create('IndexView');
    }

    public function contact() {
        TemplateFactory::create('ContactView');
    }
}