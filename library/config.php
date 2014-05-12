<?php

/* Put parameters in xml configuration file */

$hostname = 'localhost';
$username = 'root';
$password = '7n3ci61t';
$dbname = 'blog';

try {
    $db = new PDO("mysql:dbname=".$dbname.";host=".$hostname.";", $username, $password);
    echo "PDO connection object created";
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
?>