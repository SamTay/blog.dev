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
		
        list($controller, $action) = array_pad(explode('/',$uri, 2), 2, null);

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
                throw new Exception("Controller exists, but method $this->action does not.");
            }
        } else {
            throw new Exception("Controller $this->controller does not exist");
        }
    }

	/**
	 * Checks if parameter is set in _GET, _POST, _SERVER and if so, returns the value. If not set,
	 * returns false. Additionally can pass and return arrays.
	 *
	 * @param $keys
	 * @return mixed
	 * @throws Exception
	 */
	public static function getParam($keys) {

		// For array parameters
		if (is_array($keys)){
			$values = array();
			foreach($keys as $key) {
				if (array_key_exists($key, $_GET) && !empty(trim($_GET[$key]))) {
					$values[$key] = trim($_GET[$key]);
				} else if (array_key_exists($key, $_POST) && !empty(trim($_POST[$key]))) {
					$values[$key] = trim($_POST[$key]);
				} else if (array_key_exists($key, $_SERVER) && !empty(trim($_SERVER[$key]))) {
					$values[$key] = trim($_SERVER[$key]);
				} else {
					$values[$key] = false;
				}
			}
			return $values;
		}
	
		// For single parameters
		if (array_key_exists($keys, $_GET) && !empty(trim($_GET[$keys])))
			return trim($_GET[$keys]);
		if (array_key_exists($keys, $_POST) && !empty(trim($_POST[$keys])))
			return trim($_POST[$keys]);
		if (array_key_exists($keys, $_SERVER) && !empty(trim($_SERVER[$keys])))
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
			$this->unobtrusiveJS(BASE_URL.'/user/login');
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
			$this->unobtrusiveJS(BASE_URL.'/user/login');
		}
	}

	public static function isAjax() {
		return (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
			&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	}

	/**
	 * Determines if requested by AJAX and redirects appropriately
	 */
	public function unobtrusiveJS($location) {
		// Check if ajax request is being made
		if (self::isAjax()) {
			$registry = Registry::getInstance();
			include(ROOT.DS.'application'.DS.'models'.DS.'jsonData.php');
		// Otherwise, redirect to the given page
		} else {
			header('location:'.$location);
			die;
		}
	}
}