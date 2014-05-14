<?php

/**
 * Class View
 *
 * Currently an abstract class from which specific views (i.e., CreatePostView)
 * extend. However, if no functions are declared abstract, I could change this
 * to be concrete for general index pages.
 */
abstract class View extends  TemplateFactory{

    /**
     * Title used in the header.php
     *
     * @var string
     */
    protected $title;

    protected $modelData = array();

    protected $header;
    protected $footer;
    protected $body;

    protected function setTitle($title) {
        $this->title = $title;
    }


    /**
     * The following set() functions might be changed to abstract if it
     * turns out that my header/footer varies with each page. Note that
     * setBody() currently generates an index page, but child classes are
     * intended to overwrite this function, and generate bodies specific
     * to each view.
     */
    protected function setHeader() {
        $this->header = ROOT.DS.'templates'.DS.'header.php';
    }
    protected function setBody() {
        $this->body = file_get_contents(ROOT.DS.'templates'.DS.'index.php');
    }
    protected function setFooter() {
        $this->footer = ROOT.DS.'templates'.DS.'footer.php';
    }


    /**
     * This function renders the web page; it will be called from child
     * classes.
     */
    public function renderPage() {
        $this->setHeader();
        $this->setBody();
        $this->setFooter();

        $title = $this->title;

        include_once($this->header);
        echo $this->body;
        include_once($this->footer);
    }

}