
<?php

//Error Reporting On
error_reporting(E_ALL);

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));		// [blog.dev]/index.php

require_once(ROOT . DS . 'library'. DS . 'bootstrap.php');


$uri = $_SERVER['REQUEST_URI'];

$control = FrontController::run();

$control->delegator($uri);
