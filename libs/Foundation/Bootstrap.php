<?php namespace Libs\Foundation;

use Libs\Exception\HandleException;

use Libs\Container\Common;

class Bootstrap {

    public static function _initException(){
        $handleException = new HandleException();
        $handleException->bootstrap(); 
    }

    public static function _initCompileTemplate(){
        $templateCPath = PATH_CACHE . 'templates_c/';
        Common::recursiveMkdir($templateCPath);
        define('PATH_APP_TPC', $templateCPath);
    }

    public static function _initPlugin(){
        return;
    }
}
