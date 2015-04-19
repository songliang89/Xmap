<?php namespace Libs\Illuminate;

class Router {

    public static $get;

    /**
     * Change uri to params array.
     *
     * @return array
     */
    private function getSecureUriString($uri) {
        $uri = explode('?', urldecode($uri));
        $uri = array_shift($uri);
        return explode('/', trim($uri, '/'));
    }

    /**
     * Params 
     *
     *
     */
    private function parse(){
        $uri = str_replace('/index.php', '', $_SERVER['REQUEST_URI']);
        $paramsArr = $this->getSecureUriString($uri);

        $configArr = RouterConfig::$route;
        
        if (isset($route[$paramsArr[0]])) {
            $_GET['s'] = $paramsArr[0];
            array_shift($paramsArr);  
            
            $configArr = $configArr[$_GET['s']];

            if (isset($paramsArr[0]) && isset($configArr[$paramsArr[0]])) {
                $_GET[ACTION] = $paramsArr[0];
                array_shift($paramsArr);    
            } else {
                
            }
        } 
 
        $_GET['s'] = $uriArr[0];
        $_GET['a'] = $uriArr[1];
    }


    /**
     * Framework route , return the instance of current controller.
     *
     * @return object 
     */
    public  function route() {
        $this->parse();
        $class = "App\Controllers\\" . ucfirst($_GET['s']); 
        $class .= 'Controller';
        return new $class($_GET['s'], $_GET['a']);
    }
}
