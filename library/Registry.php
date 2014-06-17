<?php

/**
 * This class will allow a single instantiation where site-wide
 * variables can be stored without the use of globals. The single
 * registry object will be used by whoever needs it.
 *
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
	 * Global-ish variables are stored here
	 *
	 * @var array
	 * @access protected
	 */
	protected static $vars = array();


	/**
	 * Private construct to enforce singleton
	 */
	private function __construct() {}


	/**
	 * Get singleton instance
	 *
	 * @return null|Registry
	 */
	static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    /**
	 * Sets data[key] = value, unless data[key] is already defined.
	 *
     * @param string $key
     * @param mixed $value
     * @throws Exception
     * @return void
     */
	public function __set($key, $value)
	{
		if(isset(self::$vars[$key])) {
            throw new Exception('Attempted overwriting of variable');
        } else {
            self::$vars[$key] = $value;
        }
	}


	/**
	 * Returns data[key] (null if undefined)
	 *
	 * @param string $key
	 * @return mixed $value
	 */
	public function __get($key)
	{
		if(isset(self::$vars[$key])) {
            return self::$vars[$key];
        }
        return null;
	}
}






















































