<?php namespace Libs\Illuminate;

use Libs\Illuminate\Exception\BaseException;
use Libs\Illuminate\BaseView;

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
            
        //throw new BaseException('123', 1024);
    }
    
    /**
     *
     * 设置模版变量
     * @param string $key  模板变量名
     * @param mixed $value 模板变量值
     */
    protected function setView($key, $value) {
        $this->view[$key] = $value;
    }

    /**
     *
     * 显示模版
     * @param string $tplFile
     * @return 
     */
    protected function display($tplFile, $cache_id=null) {
        echo $this->fetch($tplFile, $cache_id);
    }

    /**
     *
     * 返回解析内容
     * @param string $tplFile
     * @return html
     */
    protected function fetch($tplFile, $cache_id) {
        $tpl = new BaseView();
        $tpl->assign($this->view);
        return $tpl->fetch($tplFile, $cache_id);
    }

}
