<?php namespace App\Models\Dao;

use Libs\Illuminate\DBFactory;

class User {

    private static $db;    

    public function getUserById(){
        self::$db = new DBFactory();
        return array(
            'a' => 1,
            'b' => 2,
        );
    }
}
