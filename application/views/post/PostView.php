<?php


class PostView extends View {

	public function __construct($data) {
		$this->data = $data;
		$this->setTitle($this->data['title']);
		$this->setSection('postview');
		$this->renderPage();
	}

	protected function setBody() {
		$this->body[] = ROOT.DS.'templates'.DS.'post.php';
		$this->body[] = ROOT.DS.'templates'.DS.'comments.php';
	}
}
