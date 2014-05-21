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

		$this->id = $this->data['id'];
		$this->setTitle('Update Post');
		$this->setSection('update');
		$this->renderPage();
	}

	protected function setBody() {
		$this->data['postTitle'] = $this->data['title'];
		$this->data['postBody'] = $this->data['body'];

		$this->body[] = ROOT.DS.'templates'.DS.'createpost.php';
	}
}
