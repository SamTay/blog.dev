<?php

/**
 * Class IndexView
 *
 * In contrast to PostView, which is abstract and has individual pages as
 * children, this concrete class extends directly from View. This is to
 * simplify the home page, and allow it to be a default value specified
 * in View. In reality, this is most likely very unnecessary.
 *
 */
class ListView extends View {

	protected $colWidth;

	public function __construct($data) {
		$this->data = $data;
		$this->setTitle('A Coding Blog');
		$this->setSection('home');
		$this->renderPage();
	}

	protected function setBody() {
		$this->colWidth = 12/$this->data['postsPerRow'];

		$this->body[] = ROOT.DS.'templates'.DS.'list.php';
	}

}