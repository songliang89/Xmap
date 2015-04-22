<?php namespace Libs\Illuminate\Exception;

class HttpException extends BaseException {
    public function __construct($message = null, $code = 0) {
        parent::__construct($message, $code);
    }      
}
