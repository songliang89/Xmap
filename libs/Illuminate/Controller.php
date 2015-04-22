<?php namespace Libs\Illuminate;

use Libs\Illuminate\Exception\BaseException;

class Controller {
    
    private static $controller;

    private static $action;    

    /**
     * 
     * Template array 
     */
    protected $view = array();


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
            
        throw new BaseException('123', 1024);
    }
}
