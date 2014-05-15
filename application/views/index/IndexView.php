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
class IndexView extends View {

    protected function __construct() {
        $this->setTitle('A Coding Blog');
		$this->setSection('home');
        $this->renderPage();
    }

    protected function setBody() {
        $this->body[] = ROOT.DS.'templates'.DS.'banner.php';
        $this->body[] = ROOT.DS.'templates'.DS.'recentThree.php';
    }
}