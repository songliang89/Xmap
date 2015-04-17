<?php namespace Libs\Illuminate;

class Router {

    private function parse(){
        $uri = str_replace('/index.php', '', $_SERVER['REQUEST_URI']);

        $uriArr = explode('/', trim($uri, '/'));
        
        $_GET['s'] = $uriArr[0];
        $_GET['a'] = $uriArr[1];
    }

    public  function route() {
        $this->parse();
        $class = "App\Controllers\\" . ucfirst($_GET['s']); 
        $class .= 'Controller';
        $controller = new $class($_GET['s'], $_GET['a']);
        return $controller;
    }
}
