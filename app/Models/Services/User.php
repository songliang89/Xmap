<?php namespace App\Models\Services;

use App\Models\Dao\User as DaoUser;

class User {
    
    public function getUserById(){
        $user = new DaoUser();
        $ret = $user->getUserById();
        return $ret;
    }
}
