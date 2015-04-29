<?php define('PATH_ROOT', rtrim(dirname(__FILE__),'/').'/');

use Libs\Foundation\Application;

include(PATH_ROOT . 'libs/Autoloader.php');

new Oauth();

Application::init()->route()->run();
