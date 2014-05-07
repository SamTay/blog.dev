<html>
<head>
</head>
<body>
<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));		// [blog.dev]/index.php

require_once(ROOT . DS . 'application'. DS . 'bootstrap.php'); // file exists, check !

//testing auto_loader
$test1 = new models_testClass();
?> <br> <?php
$test2 = new models_test3_test2_test1();

