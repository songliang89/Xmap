<?php namespace App\Models\Services;

use App\Models\Dao\User as DaoUser;

class User {
   
    /**
     * Get usreinfo by uid.
     *
     * @param int $uid
     * @return array
     */
    public function getUserById($uid){
        $user = new DaoUser();
        $ret = $user->getUserById($uid);
        return $ret;
    }

    public function getUserCount(){
        $user = new DaoUser();
        $ret = $user->getUserCount();
        return $ret;
    }

    public function addUser($row){
        $user = new DaoUser();
        $ret = $user->addUser($row);
        return $ret;
    }
}
