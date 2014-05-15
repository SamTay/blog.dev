<?php

class AboutContactView extends View {
    protected function __construct() {
        $this->setTitle('Contact Information');
        $this->setSection('contact');
        $this->renderPage();
    }

    protected function setBody() {
        $this->body[] = ROOT.DS.'templates'.DS.'contact.php';
    }
}