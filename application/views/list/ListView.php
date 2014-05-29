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
	 * This is a fucking hack and should be done better; basically
	 * takes away sorting methods during search
	 *
	 * @var string
	 */
	protected $action;

	public function __construct($data) {
		$this->data = $data;
		$this->setTitle('Greatest Posts of All Time');
		$this->setSection('list-' . $this->data['sort']);
		$this->action = 'view';
		$this->renderPage();
	}

	protected function setBody() {
		$this->colWidth = 12/$this->data['postsPerRow'];
		$this->start = ($this->data['pg']-1)*$this->data['postsPerPage'];
		$this->end = min($this->data['totalPosts'], $this->data['pg']*$this->data['postsPerPage']) - 1;

		$this->body[] = ROOT.DS.'templates'.DS.'banner2.php';
		$this->body[] = ROOT.DS.'templates'.DS.'pagination.php';
		$this->body[] = ROOT.DS.'templates'.DS.'list.php';
		$this->body[] = ROOT.DS.'templates'.DS.'pagination.php';
	}

}