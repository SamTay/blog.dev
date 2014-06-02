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
		$this->setTitle("Search Results for '$this->data['view']->needle'");
		$this->setSection('search');
		$this->action = 'search';
		$this->renderPage();
	}

	protected function setBody() {
		$this->colWidth = 12/$this->data['view']->postsPerRow;
		$this->start = ($this->data['view']->pg-1)*$this->data['view']->postsPerPage;
		$this->end = min($this->data['view']->totalPosts, $this->data['view']->pg*$this->data['view']->postsPerPage) - 1;

		$this->body[] = ROOT.DS.'templates'.DS.'pagination.php';
		$this->body[] = ROOT.DS.'templates'.DS.'list.php';
		$this->body[] = ROOT.DS.'templates'.DS.'pagination.php';
	}
}