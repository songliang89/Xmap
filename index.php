<?php define('PATH_ROOT', rtrim(dirname(__FILE__),'/').'/');

include(PATH_ROOT . 'libs/Autoloader.php');

\Libs\Illuminate\Bootstrap::init()->route()->run();

