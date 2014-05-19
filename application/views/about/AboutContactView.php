<?php

class AboutContactView extends View {
    public function __construct() {
        $this->setTitle('Contact Information');
        $this->setSection('contact');
        $this->renderPage();
    }

    protected function setBody() {
        $this->body[] = ROOT.DS.'templates'.DS.'contact.php';
    }
}