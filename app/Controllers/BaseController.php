<?php namespace App\Controllers;

class BaseController {
    
    private static $controller;

    private static $action;    

    public function __construct($controller, $action) {
        self::$controller = $controller;
        self::$action = $action;
    }

    public function run(){
        $action = self::$action;
        call_user_func(array(&$this, $action)); 
    }
}
