<?php

class AboutController {
    public function index() {
        $this->details();
    }
    public function details() {
        TemplateFactory::create('AboutDetailsView');
    }
    public function contact() {
        TemplateFactory::create('AboutContactView');
    }
}