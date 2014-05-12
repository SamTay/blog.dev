<?php

class Template {

/**
 * @the registry
 * @access private
 */
private $registry;

/**
 * @Variables array
 * @access private
 */
private $vars = array();

/**
 * @param $registry
 */
function __construct($registry) {
    $this->registry = $registry;
}


/**
* @set undefined vars
* @param string $index
* @param mixed $value
* @return void
*/
public function __set($index, $value)
{
    $this->vars[$index] = $value;
}

/**
 * @param $name
 * @return bool
 * @throws Exception
 */
function show($name) {
    $path = ROOT . DS . 'application' . DS . 'views' . DS . $name . '.php';

    if (file_exists($path) == false)
    {
        throw new Exception('Template not found in '. $path);
        return false;
    }

    // Load variables                    ---     need to find out WHY this is necessary
    foreach ($this->vars as $key => $value)
    {
        $$key = $value;
    }

    include(ROOT . DS . 'templates' . DS . 'header.php');
    include ($path);
    include(ROOT . DS . 'templates' . DS . 'footer.php');
}

}

?>