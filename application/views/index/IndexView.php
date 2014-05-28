<?php

/**
 * Class IndexView
 *
 */
class IndexView extends View {

	protected $colWidth;
	protected $N;

    public function __construct($data) {
		$this->data = $data;
        $this->setTitle('A Coding Blog');
		$this->setSection('home');
        $this->renderPage();
    }

    protected function setBody() {
        $this->body[] = ROOT.DS.'templates'.DS.'banner.php';
        $this->body[] = ROOT.DS.'templates'.DS.'recentN.php';
    }

	public function renderPage() {
		$this->N = count($this->data);
		$this->colWidth = 12/$this->N;

		parent::renderPage();
	}
}