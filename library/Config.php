<?php

/**
 * Class Config
 *
 * Used to access XML configuration elements, follows Singleton pattern
 */
class Config {

    protected static $xml;
	protected static $instance;

	/**
	 * Private constructor for Singleton pattern
	 */
	protected function __construct(){}

	/**
	 * Implements Singleton pattern, sets $xml to config.xml
	 *
	 * @return Config
	 */
	public static function getConfig() {
		if (!isset(self::$instance)) {
			self::$xml = simplexml_load_file(ROOT. DS . 'library' . DS . 'config.xml');
			self::$instance = new Config;
		}
		return self::$instance;
	}

	/**
	 * Returns type->key from XML file
	 *
	 * @param $type
	 * @param $key
	 * @return mixed
	 */
	public function get($type, $key) {
		return self::$xml->$type->$key;
	}

	/**
	 * I really want to get this function working for more complex XML scenarios. I would use
	 * either SimpleXMLIterator or RecursiveIteratorIterator to traverse XML tree and find keys
	 * however deep in the tree. For now, the above works.
	 *
	 * @param $levels
	 * @param $element
	 * @param $key
	 * @return mixed
	 */
	private function find($levels, $element, $key) {

		foreach ($element as $level) {
			var_dump($levels, $level, $key);
			if ($level == $key) {
				return self::$xml->$key;
			} else {
				$levels[] = $level;
				$this->find($levels, $level, $key);
			}
		}

	}
}
