<?php

/**
 * Class SearchView
 *
 * The view used for search results
 *
 */
class SearchView extends ListView {

	public function __construct($data) {
		$this->data = $data;
		$this->setTitle('Search Results');
		$this->setSection('search');
		$this->action = 'search';
		$this->renderPage();
	}

	protected function setBody() {
		$this->colWidth = 12/$this->data['postsPerRow'];
		$this->start = ($this->data['pg']-1)*$this->data['postsPerPage'];
		$this->end = min($this->data['totalPosts'], $this->data['pg']*$this->data['postsPerPage']) - 1;

		$this->body[] = ROOT.DS.'templates'.DS.'pagination.php';
		$this->body[] = ROOT.DS.'templates'.DS.'list.php';
		$this->body[] = ROOT.DS.'templates'.DS.'pagination.php';
	}
}