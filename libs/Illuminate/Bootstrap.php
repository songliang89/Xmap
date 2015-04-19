<?php namespace Libs\Illuminate;

use Libs\Illuminate\Router;

class Bootstrap {

    
    /**
     * To init application environment. 
     *
     * @return void
     */
    public static function init(){
       return new Router(); 
    }
}
