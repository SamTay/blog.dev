<?php

/**
 * Class UserRegisterView
 *
 * Basic view with form for registering new user
 */
class UserRegisterView extends View {

	public function __construct($data = null) {

		if (!is_null($data))
			$this->data = $data;

		$this->setTitle('Create a New Account');
		$this->setSection('register');
		$this->renderPage();
	}

	protected function setBody() {
		$this->body[] = ROOT.DS.'templates'.DS.'register.php';
	}
}
