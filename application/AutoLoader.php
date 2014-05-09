<?php

class AutoLoader {

    /*
     * @var array $classNames
     * @access private
     */
    static private $classNames = array();


    /*
     * Recursively searches each directory for className definiton
     * in file className.php. This is an improvement from my earlier autoloader,
     * which required awkward class naming.
     *
     * @param string $dirName
     * @return void
     */
    public static function registerDirectory($dirName) {
        $di = new DirectoryIterator($dirName);
        foreach ($di as $file) {
            if ($file->isDir() && !$file->isLink() && !$file->isDot()) {
                //recursively enter directories other than links, dots
                self::registerDirectory($file->getPathname());
            } elseif (substr($file->getFilename(),-4) === '.php') {
                // save class name and filename
                $className = substr($file->getFilename(), 0, -4);
                AutoLoader::registerClass($className, $file->getPathname());
            }
        }
    }


    /*
     * Registers the fileName where className is defined
     *
     * @param string $className
     * @param string $fileName
     * @return void
     */
    public static function registerClass($className, $fileName) {
        AutoLoader::$classNames[$className] = $fileName;
    }


    /*
     * Requires file where $className is defined
     *
     * @param string $className
     * @return void
     */
    public static function loadClass($className) {
        if (isset(AutoLoader::$classNames[$className])) {
            require_once(AutoLoader::$classNames[$className]);
        }
    }
}

spl_autoload_register(array('AutoLoader', 'loadClass'));