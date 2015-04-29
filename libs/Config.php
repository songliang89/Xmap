<?php

defined('PATH_CACHE') || define('PATH_CACHE', '/data1/');

defined('DEBUG')      || define('DEBUG', 1);

class Config {

    /**
     * Mysql config array, master and slave.
     *
     */
    public static $mysql = [
        'default' => [
            'master' => [
                'host'     => 'localhost',
                'port'     => '3306',
                'uname'    => 'root',
                'passwd'   => 'hope',
                'dbname'   => 'yence',
                'charset'  => 'utf8',
            ],
            'slave' => [
                'host'     => 'localhost',
                'port'     => '3306',
                'uname'    => 'root',
                'passwd'   => 'hope',
                'dbname'   => 'yence',
                'charset'  => 'utf8',
            ],
        ],
    ];   

    /**
     * route config
     *
     */ 
    public static $route = [
        'home' => [
            'view'  => '<uid?\d+>',
            'index' => '<uid?\d+>/<id?\d+\.html>',
        ],
        'user' => [
            'index' => '<id?\d+>',
        ],
    ]; 

    public static $redis = array(
        'host' => '127.0.0.1',
        'port' => '6379',
    );

    public static $refer = ['yence.cn', 'test.com'];
}
