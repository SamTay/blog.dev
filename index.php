
<?php
//Error Reporting On
error_reporting(E_ALL);

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));		// [blog.dev]/index.php
define('BASE_URL', 'http://blog.dev');

require_once(ROOT . DS . 'library'. DS . 'bootstrap.php');


$frontController = new FrontController();


