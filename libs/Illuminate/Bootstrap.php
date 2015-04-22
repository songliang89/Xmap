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
       
        return new Router(); 
    }
}
