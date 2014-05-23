<?php

/**
 * Class UserLoginView
 *
 * Basic Login view; most likely will be used very little, since
 * login option is available in header.
 */
class UserLoginView extends View {

	public function __construct($data = null) {

		if (!is_null($data))
			$this->data = $data;

		$this->setTitle('Login');
		$this->setSection('login');
		$this->renderPage();
	}

	protected function setBody() {
		$this->body[] = ROOT.DS.'templates'.DS.'login.php';
	}
}