<?php

/**
 * Class ListView
 *
 * Class is used for generating lists, typically any that include pagination
 *
 */
class ListView extends View {

	/**
	 * Colwidth as determined by posts per row
	 * @var
	 */
	protected $colWidth;

	/**
	 * Starting index for the given page
	 * @var
	 */
	protected $start;

	/**
	 * Ending index for the given page
	 * @var
	 */
	protected $end;

	/**
	 * Keeps track of what the user is doing (view, search)
	 * @var
	 */
	protected $action;
	

	public function __construct($data) {
		$this->data = $data;
		$this->setTitle('Greatest Posts of All Time');
		$this->setSection('list-' . $this->data['view']->sort);
		$this->action = 'view';
		$this->renderPage();
	}

	protected function setBody() {
		$this->colWidth = 12/$this->data['view']->postsPerRow;
		$this->start = ($this->data['view']->pg-1)*$this->data['view']->postsPerPage;
		$this->end = min($this->data['view']->totalPosts, $this->data['view']->pg*$this->data['view']->postsPerPage) - 1;

		$this->body[] = ROOT.DS.'templates'.DS.'banner2.php';
		$this->body[] = ROOT.DS.'templates'.DS.'pagination.php';
		$this->body[] = ROOT.DS.'templates'.DS.'list.php';
		$this->body[] = ROOT.DS.'templates'.DS.'pagination.php';
	}

	public function keepSearchParam() {
		if ($this->section == 'search')
			echo '&needle='.$this->data['view']->needle;
	}
}