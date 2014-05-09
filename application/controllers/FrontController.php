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
     *
     * @return FrontController
     */
    static function run() {
        $instance = new FrontController();
        return $instance;
    }


    /*
     * Delegates model/view actions based on URI
     * -finish definition using anantgarg as resource!
     *
     * @param string
     */
    function delegator($uri) {
        $uriPartition = explode("/", $uri);

        $controller = ucwords($uriPartition[0]);
        array_shift($uriPartition);

        $action = $uriPartition[0];
        array_shift($uriPartition);

        $queryString = $uriPartition;

        $model = rtrim($controller, 's');

        $controller = $controller . 'Controller';

        $dispatch = new $controller($model,$action);

        if ((int)method_exists($controller, $action)) {
            call_user_func_array(array($dispatch,$action), $queryString);
        } else {
            throw new Exception("Control-Action: not found!");
        }

    }


	
}