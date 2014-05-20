<?php

/**
 * Class CreatePostView
 *
 * Earlier, this class was derived from PostView which derived from View.
 * I found that this was causing me to duplicate code, and so changed the
 * inheritance structure.
 */
class CreatePostView extends View {

    public function __construct($data = null) {

		if (!is_null($data))
			$this->data = $data;

        $this->setTitle('Create a New Post');
        $this->setSection('create');
        $this->renderPage();
    }

    protected function setBody() {
        $this->body[] = ROOT.DS.'templates'.DS.'createpost.php';
    }
}
