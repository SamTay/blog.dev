<?php

/**
 * Class TemplateView
 *
 * Implements Template Method for this framework. Requires children to
 * implement the three get*() functions that will form a complete
 * web page. The renderPage is then called from the child class.
 */
abstract class TemplateView {

    protected abstract function getHeader();
    protected abstract function getBody();
    protected abstract function getFooter();

    public function renderPage($header, $body, $footer) {
        include_once($header);
        include_once($body);
        include_once($footer);
    }

}