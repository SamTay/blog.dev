<?php

class AboutDetailsView extends View {
    protected function __construct() {
        $this->setTitle('About Me');
        $this->renderPage();
    }

    protected function setBody() {
        $this->body = file_get_contents(ROOT.DS.'templates'.DS.'about.php');
    }

}