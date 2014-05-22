<?php

/**
 * Class AboutController
 *
 * Simple controller to handle the two about pages. No contact with model,
 * simply calls views. In fact, this class is unnecessary as the views could
 * be generated from a FrontController->about() function. But, whatever.
 * For organization's sake, I'll keep it like this.
 */
class AboutController extends FrontController {

	public function __construct() {}

	/**
	 * Default to details page
	 */
	public function index() {
        $this->details();
    }

	/**
	 * There is probably a way to NOT duplicate code in the following two functions. Before,
	 * they were simply hardcoded like getView('AboutDetailsView'), but this seems better
	 * for some reason. Note that I can't put that code in a separate function, because
	 * then __FUNCTION__ would return THAT function..
	 */
	public function details() {
        Factory::getView(str_replace('Controller', '', __CLASS__) . ucwords(__FUNCTION__));
    }

    public function contact() {
        Factory::getView(str_replace('Controller', '', __CLASS__) . ucwords(__FUNCTION__));
    }

}