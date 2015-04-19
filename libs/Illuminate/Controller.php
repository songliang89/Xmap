<?php namespace Libs\Illuminate;

class Controller {
    
    private static $controller;

    private static $action;    

    public function __construct($controller, $action) {
        self::$controller = $controller;
        self::$action = $action;
    }

    /**
     * Execute controller's action.
     *
     * @return void
     */
    public function run(){
        $action = self::$action;
        call_user_func([&$this, $action]); 
    }

    /**
     * Fetch and parse tpl file, then echo it. 
     *
     * @return void 
     */
    public function display($tpl) {

    }
}
