<?php namespace Libs\Illuminate;

include(PATH_ROOT . 'libs/Illuminate/View/Smarty.class.php');

class BaseView {
    const LEFT_DELIMITER  = '{=';
    const RIGHT_DELIMITER = '=}';
    private static $tpl = NULL;

    public function __construct () {
        if (NULL === self::$tpl) {
            self::$tpl = new \Smarty();
            self::$tpl->setTemplateDir(PATH_ROOT . 'app/Templates');
            self::$tpl->setCompileDir(PATH_APP_TPC);
            self::$tpl->addPluginsDir(PATH_ROOT . 'libs/Illuminate/View/myplugins');
            self::$tpl->left_delimiter  = self::LEFT_DELIMITER;
            self::$tpl->right_delimiter = self::RIGHT_DELIMITER;
            self::$tpl->compile_locking = false;
            

            //自动转义html标签，防止xss，不转义使用{=$data nofilter=}
            function escFilter ($content, $smarty) {
                return htmlspecialchars($content,ENT_QUOTES,'UTF-8');
            }
            self::$tpl->registerFilter('variable', 'Libs\Illuminate\escFilter');
        }
    }

    public function setView($key, $value) {
        self::$tpl->assign($key, $value);
    }

    public function __call ($func, $args) {
        return call_user_func_array(array(&self::$tpl,$func),$args);
    }
}
