<?php

class AboutContactView extends View {
    protected function __construct() {
        $this->setTitle('Contact Information');
        $this->renderPage();
    }

    protected function setBody() {
        $this->body = file_get_contents(ROOT.DS.'templates'.DS.'contact.php');
    }
}