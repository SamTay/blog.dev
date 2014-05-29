<?php

/**
 * Defines a single point of entry for every request,
 * delegating to other controllers. When instantiated,
 * this class parses URI and runs. The run() method
 * calls on other controllers' methods as outlined in
 * the URI:
 * URL:			blog.dev/post/view
 * call:		-> PostController->view()
 */

class FrontController {

    protected $controller = 'IndexController';
    protected $action = 'index';

    /**
     * Right now, when the FrontController is instantiated, it automatically
     * runs. Perhaps this limits flexibility - check with Thomas.
     */
    public function __construct() {
        $this->parseUri();
        $this->run();
    }

    /**
     * Parses the URI and sets properties accordingly. Scheme:
     *      www.blog.dev/post/view?id=1&pg=4
     *      -> $controller = PostController
     *      -> $action = view()
	 *
	 * Note that params array may not be necessary because _GET[] exists.
     */
    public function parseUri() {
        $uri = trim($_SERVER["REQUEST_URI"],'/');

		// Leave off the query strings
		if (stripos($uri, '?'))
			$uri = substr($uri, 0, stripos($uri,'?'));
		
        list($controller, $action) = explode('/',$uri, 2);

        if(!empty($controller)) {
            $this->controller = ucfirst(strtolower($controller)) . 'Controller';
        }
        if(!empty($action)) {
            $this->action = strtolower($action);
        }
	}

	/**
     * After parseUri(), the three properties are set and controllers are ready
     * to be deployed. This function first ensures that the controller class and their
     * action methods exist, and then calls those methods directly from here.
     *
     * @throws Exception
     */
    public function run() {
        if (class_exists($this->controller)) {
            if (method_exists($this->controller, $this->action)) {
                call_user_func( array(new $this->controller, $this->action) );
            } else {
                throw new Exception('Controller exists, but method does not.');
            }
            } else {
            throw new Exception('Controller does not exist');
        }
    }

	/**
	 * Checks if parameter is set in _GET, _POST, _SERVER and if so, returns the value. If not set,
	 * returns false.
	 *
	 * @param $key
	 * @return bool
	 */
	public static function getParam($key) {
		if (isset($_GET[$key]))
			return $_GET[$key];

		if (isset($_POST[$key]))
			return $_POST[$key];

		if (isset($_SERVER[$key]))
			return $_SERVER[$key];

		return false;
	}

	/**
	 * This method is called by controllers with actions requiring admin privileges.
	 * One call will simply allow that action to continue, or redirect (from this method)
	 * with appropriate messages.
	 */
	protected function adminPrivilege() {
		$config = Config::getConfig();
		if ($_SESSION['user'] != $config->get('admin', 'username')) {
			$_SESSION['msg'] = 'Action requires admin privileges. Please sign in.';
			$_SESSION['msg-tone'] = 'danger';
			header('location:' . BASE_URL . '/user/login');
			die;
		}
	}

	/**
	 * This method is called by controllers with actions requiring user privileges.
	 * One call will simply allow that action to continue, or redirect (from this method)
	 * with appropriate messages.
	 */
	protected function userPrivilege() {
		if (empty($_SESSION['user'])) {
			$_SESSION['msg'] = 'You need to be signed in for that action. Registering takes two seconds, cmon.';
			$_SESSION['msg-tone'] = 'warning';
			header('location:' . BASE_URL . '/user/login');
			die;
		}
	}
}






































/* This is the FrontController taken from SitePoint. The one above is written with the same idea in mind,
but more focused on my particular blog application.


class FrontController {

    const DEFAULT_CONTROLLER = "IndexController";
    const DEFAULT_ACTION = "index";


    protected $controller = self::DEFAULT_CONTROLLER;
    protected $action = self::DEFAULT_ACTION;
    protected $params = array();
    protected $basePath = "/";


    private static $instance;


    private function __construct() {}


    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new FrontController();
        }
        return self::$instance;

    }


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


    public function setController($controller) {
        $controller = ucfirst(strtolower($controller)) . "Controller";
        if (!class_exists($controller)) {
            throw new InvalidArgumentException('This controller is not defined!');
        }
        $this->controller = $controller;
        return $this;
    }


    public function setAction($action) {
        $reflector = new ReflectionClass($this->controller);
        if (!$reflector->hasMethod($action)) {
            throw new InvalidArgumentException('This controller action method is not defined!');
        }
        $this->action = $action;
        return $this;
    }


    public function setParams(array $params) {
        $this->params = $params;
        return $this;
    }


    public function run() {
        call_user_func_array(array(new $this->controller, $this->action), $this->params);
    }
}

*/