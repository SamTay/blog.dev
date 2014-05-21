<?php

/**
 * Class View
 *
 * An abstract class from which specific views (i.e., CreatePostView) extend.
 */
abstract class View {

    /**
     * Title used in the header.php
     *
     * @var string
     */
    protected $title;

    /**
     * Variable used to show which link is currently selected.
     *
     * @var string
     */
    protected $section;

    /**
     * This array will be used when retrieving model information.
     *
     * @var array
     */
    protected $data = array();

    /**
     * The header/footer/body variables correspond to template files that compose
     * their respective parts of the webpage.
     */
    protected $header;
    protected $footer;
    protected $body = array();


    /**
     * Functions to set Title & Section, which are used in the generated HTML.
     */
    protected function setTitle($title) {
        $this->title = $title;
    }
    protected function setSection($section) {
        $this->section = $section;
    }


    /**
     * This class requires children to implement the setBody function, which
     * will decide what appears on each webpage.
     */
    abstract protected function setBody();


    /**
     * Currently the header and footer are set to these default templates. If
     * some page requires them to change, they can easily be overridden in
     * derived classes.
     */
    protected function setHeader() {
        $this->header = ROOT.DS.'templates'.DS.'header.php';
    }
    protected function setFooter() {
        $this->footer = ROOT.DS.'templates'.DS.'footer.php';
    }


    /**
     * This function renders the web page; it will be called from child
     * classes (after setBody has been implemented).
     */
    public function renderPage() {
        $this->setHeader();
        $this->setBody();
        $this->setFooter();

        $title = $this->title;
        $section = $this->section;

        include_once($this->header);
        foreach($this->body as $template)
            include_once($template);
        include_once($this->footer);
    }

}