<?php

/**
 * Class CreatePostView
 *
 * Earlier, this class was derived from PostView which derived from View.
 * I found that this was causing me to duplicate code, and so changed the
 * inheritance structure.
 */
class UpdatePostView extends CreatePostView {

	public function __construct($data = null) {

		if (!is_null($data))
			$this->data = $data;

		$this->data['id'] = $this->data['post']->id;
		$this->setTitle('Update Post');
		$this->setSection('update');
		$this->renderPage();
	}

	protected function setBody() {
		$this->data['postTitle'] = $this->data['post']->title;
		$this->data['postBody'] = $this->data['post']->body;

		$this->body[] = ROOT.DS.'templates'.DS.'createpost.php';
	}
}
