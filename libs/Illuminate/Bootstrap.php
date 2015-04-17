<?php namespace Libs\Illuminate;

use Libs\Illuminate\Router;

class Bootstrap {

    public static function init(){
       return new Router(); 
    }
}
