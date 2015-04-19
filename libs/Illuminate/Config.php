<?php namespace Libs\Illuminate;

class Config {

    /**
     * Mysql config array, master and slave.
     *
     */
    public static $mysqlConfig = [
        'default' => [
            'mysql' => [
                'host'     => '127.0.0.1',
                'port'     => '3306',
                'uname'    => 'root',
                'passport' => 'hope',
                'charset'  => 'utf8',
            ],
            'slave' => [
                'host'     => '127.0.0.1',
                'port'     => '3306',
                'uname'    => 'root',
                'passport' => 'hope',
                'charset'  => 'utf8',
            ],
        ],
    ];   

    /**
     * Redis config array
     *
     */
    public static $redisConfig = [
        'host' => '127.0.0.1',
        'port' => '6379',
    ];

    /**
     * Memcache config array
     *
     */
    public static $mcConfig = [
        'host' => '127.0.0.1',
        'port' => '11211',
    ]; 
}
