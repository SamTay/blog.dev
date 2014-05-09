<?php

/*
 * Defines a single point of entry for every request,
 * delegating to models and views.
 */
class FrontController {

    /*
     * Private construct to ensure single instance
     */
    private function __construct() {}


    /*
     * creates FrontController and calls handleRequest()
     */
    static function run() {
        $instance = new FrontController();
        $instance->handleRequest();
    }


    /*
     *
     */
    function handleRequest() {
        $request = new Request();
        $cmd_r = new CommandResolver();
        $cmd = $cmd_r->getCommand($request);
        $cmd->execute($request);
    }


	
}