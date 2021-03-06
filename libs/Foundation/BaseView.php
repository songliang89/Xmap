<?php namespace Libs\Foundation;

include(PATH_ROOT . 'libs/Views/Smarty.class.php');

class BaseView {
    const LEFT_DELIMITER  = '{=';
    const RIGHT_DELIMITER = '=}';
    private static $tpl = NULL;

    public function __construct () {
        if (NULL === self::$tpl) {
            self::$tpl = new \Smarty();
            self::$tpl->setTemplateDir(PATH_ROOT . 'static/templates');
            self::$tpl->setCompileDir(PATH_APP_TPC);
            self::$tpl->addPluginsDir(PATH_ROOT . 'libs/Views/myplugins');
            self::$tpl->left_delimiter  = self::LEFT_DELIMITER;
            self::$tpl->right_delimiter = self::RIGHT_DELIMITER;
            self::$tpl->compile_locking = false;
            

            //Automatic escape html tag，avoid xss，unexpected  escape use {=$data nofilter=}
            function escFilter ($content, $smarty) {
                return htmlspecialchars($content,ENT_QUOTES,'UTF-8');
            }
            self::$tpl->registerFilter('variable', 'Libs\Foundation\escFilter');
        }
    }

    public function setView($key, $value) {
        self::$tpl->assign($key, $value);
    }

    public function __call ($func, $args) {
        return call_user_func_array(array(&self::$tpl, $func), $args);
    }
}
