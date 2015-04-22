<?php namespace Libs\Illuminate;

use Libs\Illuminate\Router;
use Libs\Illuminate\Exception\HandleException;
class Bootstrap {

    
    /**
     * To init application environment. 
     *
     * @return void
     */
    public static function init(){
        
        $handleException = new HandleException();
        $handleException->bootstrap(); 
  
        self::initCompileTemplate(); 
         
        return new Router(); 
    }

    /**
     * Init compile dir template_c
     *
     * @return void
     */
    public static function initCompileTemplate() {
        
        $templateCPath = PATH_CACHE . 'templates_c/';
        
        Common::recursiveMkdir($templateCPath);
        
        define('PATH_APP_TPC', $templateCPath);
    }
}
