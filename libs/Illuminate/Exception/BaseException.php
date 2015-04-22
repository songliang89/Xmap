<?php namespace Libs\Illuminate\Exception;   

class BaseException extends \Exception{

    public function __construct($message = null, $code = 0) {
        parent::__construct($message, $code);
    } 
}
