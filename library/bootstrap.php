<?php

include_once('AutoLoader.php');
AutoLoader::registerDirectory(ROOT);





























































































//// require_once(ROOT . DS . 'config' . DS . 'config.php');
//// require_once(ROOT. DS . 'library' . DS . 'shared.php');
//
///**
// * Provides auto-loading for classes with correct naming convention:
// *		//Loads application/models/my/class/name.php :
// *		auto_load('models_my_class_name');
// *
// * NOTE this function must be registered via spl_autoload_register('auto_load');
// * and the registry should occur in the boostrap.
// *
// * Be prepared to modify where class files are kept using $directory
// * in this function.
// *
// * @param  string    $class    Class name
// * @return void
// */
//function auto_load($class) {
//	$class = strtolower($class);
//
//	$file = ROOT . DS . 'application' . DS;
//	$file .= str_replace('_', DS, $class);
//	$file .= '.php';
//
//	if(is_file($file) && !class_exists($class))
//		include $file;
//}
//
//// Registering the above auto_load function:
//spl_autoload_register('auto_load');