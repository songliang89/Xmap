<?php namespace App\Controllers;

use App\Models\Service\User;

class HomeController extends DefaultController {

    public function view(){
        $user = new User();
        $uid = $this->arrInput('uid');
        $ret = $user->getUserById($uid);
        
        $num = $user->getUserCount();

        $row = array(
            'uid' => 5,
            'nickname' => 'qinghong',
            'image_url' => '',
            'token' => '',
            'integral' => '',
            'profile' => '',
            'location' => '',
            'indb_time' => '',
        );

        //print_r($user->addUser($row));

        $this->setView('ret', $ret[0]);
        $this->display('index.html');
    }
}
