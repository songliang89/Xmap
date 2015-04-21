<?php namespace App\Models\Dao;

use Libs\Illuminate\DBFactory;

class User {

    private static $db;    

    public function __construct() {
        self::$db = new DBFactory();
    }

    /**
     * Get userinfo by uid.
     * 
     * @param  int   $uid
     * @return array $user
     */
    public function getUserById($uid){
        
        $table = 'userinfo';
        
        $fields = ['id', 'nickname', 'indb_time'];
        
        $conds = [
            'id=' => $uid,
        ]; 

        $user = self::$db->select($table, $fields, $conds);
        
        return $user; 
    }
}
