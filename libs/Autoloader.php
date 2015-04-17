<?php
/**
 * Class of autoloader.
 *
 * Note:Excute when the class can not be found in hash tables.
 *
 */
class Autoloader {


   /**
    * Class autoload function.
    * Note: all classed can be loader by this function, you can define all you rules.
    *
    * @param  string $classname
    * @return void
    */ 
    public static function loader($classname) {
        $arr = explode('\\', $classname);
        $arr[0] = lcfirst($arr[0]);
        $prefix = PATH_ROOT . implode('/', $arr);
        self::includeFile($prefix);
    }
   
    /**
    * File include function.
    *
    * @param string $prefix
    * @param string $postfix 
    * @return void
    */  
    public static function includeFile($prefix, $postfix = '.php') {
        $filename = $prefix . $postfix;
        include($filename); 
    }
}
spl_autoload_register(array('Autoloader', 'loader'));
