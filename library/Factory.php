<?php

/**
 * Class Factory
 *
 * Uses static functions to instantiate Model & View classes.
 */
class Factory {

	/**
	 * Returns new model class if it exists, has option to pass $data to constructor
	 * @param $className
	 * @param null $data
	 * @return mixed
	 * @throws Exception
	 */
	public static function getModel($className, $data=null){
		if (class_exists($className.'Model')) {
			$className = $className.'Model';
			if (is_null($data)) {
				return new $className;
			} else {
				return new $className($data);
			}
		} else throw new Exception('Model class does not exist');
	}

	/**
	 * Returns new view class if it exists, has option to pass $data to constructor
	 *
	 * @param $className
	 * @param null $data
	 * @return string
	 * @throws Exception
	 */
	public static function getView($className, $data=null) {

		if (class_exists($className.'View')) {
			$className = $className.'View';
			if (is_null($data)) {
				return new $className;
			} else {
				return new $className($data);
			}
		} else throw new Exception('View class does not exist');

	}
}