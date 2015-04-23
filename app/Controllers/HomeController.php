<?php namespace App\Controllers;

use App\Models\Services\User;

class HomeController extends DefaultController {

    public function view(){
        $user = new User();
        $uid = $this->arrInput('uid');
        $ret = $user->getUserById($uid);
        $this->setView('ret', $ret[0]);
        $this->display('index.html');
    }
}
