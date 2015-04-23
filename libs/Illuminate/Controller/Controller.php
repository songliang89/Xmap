<?php namespace Libs\Illuminate\Controller;

use Libs\Illuminate\Exception\BaseException;
use Libs\Illuminate\BaseView;
use Libs\Illuminate\Config;

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
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                break;
            case 'POST':
                if(empty($_SERVER['HTTP_REFERER'])) {
                    throw new BaseException('Request source not allowd.', '1026');
                }
                $parseReferer = parse_url($_SERVER['HTTP_REFERER']);
                if(empty($parseReferer['host']) || !preg_match("/^[\w\.]+$/", $parseReferer['host'])) {
                    throw new BaseException('Request source not allowd.', '1026');
                }
                foreach (Config::$refer as $referer) {
                    if($referer === $parseReferer['host'] || ('.' . $referer === substr($parseReferer['host'], -(strlen($referer)+1)))) {
                        break;
                    }
                }
                break;
            case 'HEAD':
                 break;
            default:
                throw new BaseException('Request source not allowd.', '1027');
        }        
        $action = self::$action;
        if(in_array($action, array('run', 'setView', 'display', 'fetch'), true)){
            throw new BaseException('Action can not be called.', '1027');    
        }
        if(method_exists($this, $action)) {
            call_user_func([&$this, $action]); 
        } else {
            throw new BaseException('Action not exist.', '1027');
        }
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
