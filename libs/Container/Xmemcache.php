<?php use Libs\Container;

class Xmemcache {

    private static $memcache = [];    

    private static $key;

    private $mc;
    
    public function __construct($config = []) {
        
        $config = isset($config['host']) ? $config : \Config::$memcache;
        
        self::$key = $config['host'] . ':' . $config['port'];
        
        if (isset(self::$memcache[self::$key]) && self::$memcache[self::$key] instanceof Memcached) {
            $this->mc = self::$memcache[self::$key];
        } else {
            self::$memcache[self::$key] = new Memcached();
            self::$memcache[self::$key]->addServer($config['host'], $config['port']);
            $this->mc = self::$memcache[self::$key];
        }
    }

    public function get($key) {
        return $this->mc->get($key);
    }

    public function set($key, $value) {
        return $this->mc->set($key, $value);
    }
}
