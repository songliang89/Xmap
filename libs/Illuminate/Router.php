<?php namespace Libs\Illuminate;

class Router {

    public static $get = []; //url参数

    /**
     * Change uri to params array.
     *
     * @return array
     */
    private function getSecureUriString($uri) {
        $uri = array_shift(explode('?', urldecode($uri)));
        return explode('/', trim($uri, '/'));
    }

    /**
     * Parse uri and match route config. 
     *
     * @return void
     */
    private function parse(){
        $uri = str_replace('/index.php', '', $_SERVER['REQUEST_URI']);
        
        $paramsArr = $this->getSecureUriString($uri);

        $configArr = Config::$route;
        
        if (isset($configArr[$paramsArr[0]])) {
            $_GET['s'] = $paramsArr[0];
            array_shift($paramsArr);  
            
            $configArr = $configArr[$_GET['s']];

            if (isset($paramsArr[0]) && isset($configArr[$paramsArr[0]])) {
                $_GET['a'] = $paramsArr[0];
                array_shift($paramsArr);    
            } 
        } 
   }

    /**
     * Return a instance of controller.
     *
     * @return object
     */
    private function getControllerInstance(){
        $class = "App\Controllers\\" . ucfirst($_GET['s']);
        $class .= 'Controller';
        return new $class($_GET['s'], $_GET['a']);
    }

    /**
     * Framework route , return the instance of current controller.
     *
     * @return object 
     */
    public  function route() {
        $this->parse();
        return $this->getControllerInstance();
    }
}
