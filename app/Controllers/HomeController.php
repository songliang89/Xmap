<?php namespace App\Controllers;

use App\Models\Services\User;

class HomeController extends DefaultController {

    public function view(){
        $user = new User();
        $ret = $user->getUserById();
        print_r($ret);
        echo "JLink" . rand(1,100);
    }

}
