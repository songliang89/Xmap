<?php namespace App\Controllers;

use App\Models\Services\User;

class HomeController extends DefaultController {

    public function view(){
        $user = new User();
        $uid = 2;
        $ret = $user->getUserById($uid);
        header("Content-type: text/html; charset=utf-8"); 
        echo "<pre>";
        print_r($ret);
    }
}
