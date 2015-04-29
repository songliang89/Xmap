<?php namespace Libs\Foundation;

use Libs\Exception\HandleException;

use Libs\Container\Common;

class Bootstrap {

    /**
     * Exception init.
     *
     * @return void
     */
    public static function _initException(){
        $handleException = new HandleException();
        $handleException->bootstrap(); 
    }

    /**
     * Smarty compile env init. 
     *
     * @return void
     */
    public static function _initCompileTemplate(){
        $templateCPath = PATH_CACHE . 'templates_c/';
        Common::recursiveMkdir($templateCPath);
        define('PATH_APP_TPC', $templateCPath);
    }

    /**
     * Plugin init
     *
     * @return void
     */
    public static function _initPlugin(){
        return;
    }
}
