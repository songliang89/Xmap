<?php

class RouterConfig {
    
    private function __construct(){
        return;
    }   

    /**
     * route config
     *
     */ 
    public static $route = [
        'home' => [
            'view' => '<mid?\d+\.html>/<id?\d+>',
        ],
    ]; 
}
