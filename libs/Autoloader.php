<?php

class Autoloader {

    public static function loader($classname) {
        $arr = explode('\\', $classname);
        $arr[0] = lcfirst($arr[0]);
        $prefix = PATH_ROOT . implode('/', $arr);
        self::includeFile($prefix);
    }
    
    public static function includeFile($prefix, $postfix = '.php') {
        $filename = $prefix . $postfix;
        include($filename); 
    }
}
spl_autoload_register(array('Autoloader', 'loader'));
