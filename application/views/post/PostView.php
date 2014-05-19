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
	}

	public function renderPage() {

		$body = $this->data['body'];
		$title = $this->data['title'];
		$created = $this->data['created'];
		$modified = $this->data['modified'];


		parent::renderPage();
	}
}
