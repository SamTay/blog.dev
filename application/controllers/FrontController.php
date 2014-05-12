<?php

/**
 * Defines a single point of entry for every request,
 * delegating to models and views.
 */
class FrontController {

    /**
     * Private construct to ensure single instance
     */
    private function __construct() {}


    /**
     * creates FrontController and calls handleRequest()
     *
     * @return FrontController
     */
    static function run() {
        $instance = new FrontController();
        return $instance;
    }


    /**
     * Delegates model/view actions based on URI
     * -finish definition using anantgarg as resource!
     *
     * @param string
     * @throws Exception
     */
    function delegator($uri) {
        $uriPartition = explode("/", $uri);
        array_shift($uriPartition);
        var_dump($uriPartition);                        //test
        $controller = ucwords($uriPartition[0]);
        array_shift($uriPartition);

        $model = $controller . 's';

        $action = $uriPartition[0];
        array_shift($uriPartition);

        $queryString = $uriPartition;

        $controller = $controller . 'Controller';
        var_dump($controller);                          //test
        var_dump($action);                              //test
        var_dump($queryString);                         //test

        $dispatch = new $controller($action, $model);

        if ((int)method_exists($controller, $action)) {
            call_user_func_array(array($dispatch,$action), $queryString);
        } else {
            throw new Exception("Controller-Action: not found!");
        }

    }


	
}