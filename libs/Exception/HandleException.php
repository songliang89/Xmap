<?php namespace Libs\Exception;

use Libs\Foundation\BaseView;

class HandleException {

    public function bootstrap(){
        error_reporting(-1);
        //set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
    }

    public function handleException(\Exception $e) {
        $this->render($e);
    }

    public function render($e) {
        $errormsg = $e->getMessage();
        $errno = $e->getCode();
        $class = get_class($e);
        $trace = $e->getTrace();    

        $tpl = new BaseView();
       
        $arr= array(
            'ret'   => array(
                'errno' => $errno,
                'msg'   => $errormsg,
                'trace' => $trace[0],
            ),
        );
        $tpl->assign($arr); 
        $tpl->display('message/error.html');
                 
    } 
}
