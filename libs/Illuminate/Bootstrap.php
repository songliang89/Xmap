<?php namespace Libs\Illuminate;

use Libs\Illuminate\Exception\HandleException;

class Bootstrap {

    public static function _initException(){
        $handleException = new HandleException();
        $handleException->bootstrap(); 
    }

    public static function _initCompileTemplate(){
        echo "sina";
        $templateCPath = PATH_CACHE . 'templates_c/';
        Common::recursiveMkdir($templateCPath);
        define('PATH_APP_TPC', $templateCPath);
    }

    public static function _initPlugin(){
        return;
    }
}
