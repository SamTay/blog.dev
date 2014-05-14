<?php

class CreatePostView extends PostView {

    protected function __construct() {
        $this->setTitle('Create a New Post');
        $this->renderPage();
    }

    protected function generateBody() {
        $body = file_get_contents(ROOT.DS.'templates'.DS.'banner.php');
        return $body;
    }
}
