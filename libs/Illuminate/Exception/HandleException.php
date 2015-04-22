<?php namespace Libs\Illuminate\Exception;

class HandleException {

    public function bootstrap(){
        error_reporting(-1);
        //set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
    }

    public function handleException(\Exception $e) {
        $errormsg = $e->getMessage();
        $errno = $e->getCode();
        $class = get_class($e);
        $trace = $e->getTrace();
        print_r($trace);
    }

    public function render($file, $line, $function, $class) {
         
    } 
}
