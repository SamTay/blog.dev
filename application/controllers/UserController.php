<?php
/**
 * Class UserController
 *
 * Class for controlling user actions such as logging in or registering.
 * Once I learn how to use session variables, they will probably be used
 * here. NEED TO REFACTOR REDIRECTS!
 */
class UserController extends FrontController {

	public function __construct() {}

	/**
	 * Default to login page
	 */
	public function index() {
		$this->login();
	}


	/**
	 * Register a new user. First loads the register form, then that form
	 * redirects here for validation, which leads either back to the form
	 * or to model for db insertion.
	 */
	public function register() {
		// If request is not POST, get UserRegisterView
		if ($_SERVER['REQUEST_METHOD'] != 'POST') {
			Factory::getView(str_replace('Controller', '', __CLASS__) . ucwords(__FUNCTION__));

		// Else call on UserModel to handle POST data
		} else try {
			$success = Factory::getModel(str_replace('Controller', '', __CLASS__))->register();

			// If registration is successful, login and send to last visited page.
			if ($success) {
				Factory::getModel(str_replace('Controller', '', __CLASS__))->login();
			}
			// If unsuccessful, send back to form UserRegisterView with error message
			else {
				list($data['username'], $data['password'], $data['passwordCheck']) = array(self::getParam('username'), self::getParam('password'), self::getParam('passwordCheck'));
				Factory::getView(str_replace('Controller', '', __CLASS__) . ucwords(__FUNCTION__));
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function login() {
		// If request is not POST, get UserLoginView
		if ($_SERVER['REQUEST_METHOD'] != 'POST') {
			Factory::getView(str_replace('Controller', '', __CLASS__) . ucwords(__FUNCTION__));

		// Else call on UserModel to handle POST data
		} else try {
			$success = Factory::getModel(str_replace('Controller', '', __CLASS__))->login();
			$this->unobtrusiveJS($success);

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function logout() {
		unset($_SESSION['user']);
		SessionModel::set('msg', 'You&rsquo;ve successfully logged out.');
		$this->unobtrusiveJS(true);
	}

	/**
	 * Determines if requested by AJAX and redirects appropriately
	 */
	public function unobtrusiveJS($success) {
		if (self::isAjax()) {
			include(ROOT.DS.'application'.DS.'models'.DS.'jsonData.php');

		 // Otherwise, reload to the previous page
		} else {
			header('location:'.$_SERVER['HTTP_REFERER']);
			die;
		}
	}

}