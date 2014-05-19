<?php

/**
 * Class CreatePostView
 *
 * Earlier, this class was derived from PostView which derived from View.
 * I found that this was causing me to duplicate code, and so changed the
 * inheritance structure.
 */
class CreatePostView extends View {

    public function __construct() {
        $this->setTitle('Create a New Post');
        $this->setSection('');
        $this->renderPage();
    }

    protected function setBody() {
//        $this->body = file_get_contents(ROOT.DS.'templates');
    }
}
