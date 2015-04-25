<?php include('Config.php');

use Libs\Exception\BaseException;

/**
 * Class of autoloader.
 *
 * Note:Excute when the class can not be found in hash tables.
 *
 */
class Autoloader {


    /**
     * Framework autoloader register. can use with other framework. 
     * 
     * Note :Example in Smarty.class.php
     * 
     * @param string $autoloader other autoloader func name
     * @return void
     */
    public static function register($autoloader){
        $loaders = spl_autoload_functions();
        foreach($loaders as $loader){
            spl_autoload_unregister($loader);
        }
        spl_autoload_register($autoloader);
        foreach($loaders as $loader){
            spl_autoload_register($loader);
        }
    }


   /**
    * Class autoload function.
    * 
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
        if (!is_file($filename)) {
           throw new BaseException($filename . ' File not exist.', 10001);
        } 
        include($filename); 
    }
}
spl_autoload_register(array('Autoloader', 'loader'));
