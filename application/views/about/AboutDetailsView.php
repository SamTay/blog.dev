<?php

class AboutDetailsView extends View {
    public function __construct() {
        $this->setTitle('About Me');
        $this->setSection('about');
        $this->renderPage();
    }

    protected function setBody() {
        $this->body[] = ROOT.DS.'templates'.DS.'about.php';
    }

}