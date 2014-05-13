<?php

/**
 * This class will allow a single instantiation where site-wide
 * variables can be stored without the use of globals. The single
 * registry object will be passed to the controllers that need
 * them.
 *
 * Prepare to modify this class to be abstract, removing properties
 * and setting set/get functions to protected.
 */
class Registry {
    /*
     * Ensures only ONE instance of this class!
     *
     * @var $instance
     * @access private
     */
    private static $instance = null;


	/**
	 *
	 * @var array
	 * @access protected
	 */
	protected static $vars = array();


    /*
     * Dummy construct() forced private to only allow
     * one instance of this class
     *
     * @access private
     * @return void
     */
    private function __construct() {}


    /*
     * @return new Registry
     */
    static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    /**
     * @param string $key
     * @param mixed $value
     * @throws Exception
     * @return void
     */
	public function set($key, $value)
	{
		if(isset(self::$vars[$key])) {
            throw new Exception('Attempted overwriting of variable');
        } else {
            self::$vars[$key] = $value;
        }
	}


	/**
	 * @param string $key
	 * @return mixed $value
	 */
	public function get($key)
	{
		if(isset(self::$vars[$key])) {
            return self::$vars[$key];
        }
        return null;
	}

}






















































