<?php use Libs\Container;

class Xredis {
    
    const HTTP_TIMEOUT = 2;  
 
    private static $instance;

    public function __construct($config = []) {
        
        $config = isset($config['host']) ? $config : \Config::$redis;
        
        self::$key = $config['host'] . ':' . $config['port'];
        
        if (!(self::$instance[self::$key] instanceof Redis) || (self::$instance[self::$key]->ping() !== '+PONG')) {
            $link = new Redis();
            $link->connect($config['host'], $config['port'], self::HTTP_TIMEOUT);
             self::$instance[self::$key] = $link;
        }
    }
    
    public function hset($key, $field, $value) {
        return self::$instance[self::$key]->hset($key, $field, $value);
    }

    public function hget($key, $field) {
        return self::$instance[self::$key]->hget($key, $field);
    }
    
    public function hIncrBy($key, $field, $step) {
        return self::$instance[self::$key]->hIncrBy($key, $field, $step);
    }
}
