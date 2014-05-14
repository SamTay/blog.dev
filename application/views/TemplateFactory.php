<?php

/**
 * Class TemplateFactory
 *
 * Implements Template Factory for this framework. Currently, there is no reason
 * for View class to inherit from this factory. Need to iron some of these things
 * out and figure out how to actually implement a factory...
 */
abstract class TemplateFactory {

    public static function create($view) {
        if (class_exists($view)) {
            return new $view;
        } else {
            throw new Exception('Class $view does not exist');
        }
    }

}