<?php

/**
 * Class TemplateFactory
 *
 * Implements Template Factory for this framework. Requires children to
 * implement the three get*() functions that will form a complete
 * web page. The renderPage is then called from the child class.
 */
abstract class TemplateFactory {


    abstract protected function setHeader();
    abstract protected function setBody();
    abstract protected function setFooter();

    public static function create($view) {
        if (class_exists($view)) {
            return new $view;
        } else {
            throw new Exception('Class $view does not exist');
        }
    }

}