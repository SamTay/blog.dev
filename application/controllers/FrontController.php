<?php

/**
 * Defines a single point of entry for every request,
 * delegating to models and views.
 */
class FrontController {

    const DEFAULT_CONTROLLER = "IndexController";
    const DEFAULT_ACTION = "index";


    protected $controller = self::DEFAULT_CONTROLLER;
    protected $action = self::DEFAULT_ACTION;
    protected $params = array();
    protected $basePath = "/";


    private static $instance;

    /**
     * Private construct to ensure single instance
     */
    private function __construct() {}


    /**
     * creates FrontController and calls handleRequest()
     *
     * @return FrontController
     */
    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new FrontController();
        }
        return self::$instance;

    }

    /**
     * Parses URI into blog.dev/controllername/actionname/params, then calls the set-methods
     * to set controller,action,params properties.
     */
    public function parseUri() {

        $path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");

        list($controller, $action, $params) = explode("/", $path, 3);

        if (isset($controller)) {
            $this->setController($controller);
        }
        if (isset($action)) {
            $this->setAction($action);
        }
        if (isset($params)) {
            $this->setParams(explode('/',$params));
        }
    }


    /**
     * Sets Controller
     *
     * @param string $controller
     * @return FrontController $this
     * @throws InvalidArgumentException
     */
    public function setController($controller) {
        $controller = ucfirst(strtolower($controller)) . "Controller";
        if (!class_exists($controller)) {
            throw new InvalidArgumentException('This controller is not defined!');
        }
        $this->controller = $controller;
        return $this;
    }


    /**
     * Sets Action
     *
     * @param string $action
     * @return FrontController $this
     * @throws InvalidArgumentException
     */
    public function setAction($action) {
        $reflector = new ReflectionClass($this->controller);
        if (!$reflector->hasMethod($action)) {
            throw new InvalidArgumentException('This controller action method is not defined!');
        }
        $this->action = $action;
        return $this;
    }


    /**
     * Sets Params
     *
     * @param array $params
     * @return FrontController $this
     */
    public function setParams(array $params) {
        $this->params = $params;
        return $this;
    }


    /**
     *  Runs the Front Controller and delegates to $controller($action);
     *
     * WILL NEED TO MODIFY IF LISTCONTROLLER HAS RESTRICTED ACCESS!
     */
    public function run() {
        call_user_func_array(array(new $this->controller, $this->action), $this->params);
    }
}