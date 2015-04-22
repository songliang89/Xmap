<?php namespace Libs\Illuminate;

class Config {

    /**
     * Mysql config array, master and slave.
     *
     */
    public static $mysqlConfig = [
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
}
