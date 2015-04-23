<?php define('PATH_ROOT', rtrim(dirname(__FILE__),'/').'/');


include(PATH_ROOT . 'libs/Autoloader.php');

Libs\Foundation\Application::init()->route()->run();
