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
	 * returns false. Additionally can pass and return arrays.
	 *
	 * @param $keys
	 * @return bool
	 */
	public static function getParam($keys) {
		// For array parameters
		if (is_array($keys)){
			$values = array();
			foreach($keys as $key) {
				if (!empty(trim($_GET[$key]))) {
					$values[$key] = trim($_GET[$key]);
				} else if (!empty(trim($_POST[$key]))) {
					$values[$key] = trim($_POST[$key]);
				} else if (!empty(trim($_SERVER[$key]))) {
					$values[$key] = trim($_SERVER[$key]);
				} else
					$values[$key] = false;
			}

			return $values;
		}

	
		// For single parameters
		if (!empty(trim($_GET[$keys])))
			return trim($_GET[$keys]);
		if (!empty(trim($_POST[$keys])))
			return trim($_POST[$keys]);
		if (!empty(trim($_SERVER[$keys])))
			return trim($_SERVER[$keys]);

		return false;
	}

	/**
	 * This method is called by controllers with actions requiring admin privileges.
	 * One call will simply allow that action to continue, or redirect (from this method)
	 * with appropriate messages.
	 */
	protected function adminPrivilege() {
		$config = Config::getConfig();
		if (SessionModel::get('user') != $config->get('admin', 'username')) {
			SessionModel::set('msg', 'Action requires admin privileges. Please sign in.');
			SessionModel::set('msg-tone', 'danger');
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
		if (empty(SessionModel::get('user'))) {
			SessionModel::set('msg', 'You need to be signed in for that action. Registering takes two seconds, cmon.');
			SessionModel::set('msg-tone', 'danger');
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