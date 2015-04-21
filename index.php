<?php define('PATH_ROOT', rtrim(dirname(__FILE__),'/').'/');

$start = microtime(true);


/**
 * Framework bootstarp
 *
 */
include(PATH_ROOT . 'libs/Autoloader.php');
Libs\Illuminate\Bootstrap::init()->route()->run();


$end = microtime(true);
echo ($end - $start)*1000;
