<?php namespace Libs\Container;

class Common {
    
    /**
     * Create a directory recursion. 
     * 
     * @param string $pathname
     * @param int $mode
     * @return void
     */
    public static function recursiveMkdir($pathname, $mode = 0755) {
        return is_dir($pathname) ? true : mkdir($pathname, $mode, true);
    }

}
