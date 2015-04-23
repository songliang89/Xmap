<?php namespace Libs\Foundation;


class Router {

    public static $get = []; //url参数

    /**
     * Change uri to params array.
     *
     * @return array
     */
    private function getSecureUriString($uri) {
        $uriArr = explode('?', urldecode($uri));
        $uri    = array_shift($uriArr);
        return explode('/', trim($uri, '/'));
    }

    /**
     * Parse uri and match route config, match out controller and action. 
     *
     * @return void
     */
    private function parse(){
        $uri = str_replace('/index.php', '', $_SERVER['REQUEST_URI']);
        
        $paramsArr = $this->getSecureUriString($uri);

        $configArr = \Config::$route;
        
        if (isset($configArr[$paramsArr[0]])) {
            $_GET['s'] = $paramsArr[0];
            array_shift($paramsArr);  
            
            $configArr = $configArr[$_GET['s']];
            
            if (isset($paramsArr[0]) && isset($configArr[$paramsArr[0]])) {
                $_GET['a'] = $paramsArr[0];
                array_shift($paramsArr);    
            } 
            $configArr = explode('/', $configArr[$_GET['a']]);
        } 
      
        while (!empty($paramsArr[0])) {
           
            if (empty($configArr)) {
                throw new BaseException("不识别".implode('/', $paramsArr)."，请配置路由规则");
            }
           if (self::match($configArr[0], $paramsArr[0])) {
               array_shift($paramsArr);
           }
           array_shift($configArr);
        }
    }

    /**
     * Find actions params
     *
     *
     */
    public function match($rule, $param) {
        list($paramKey, $paramVal) = explode('?', rtrim(ltrim($rule, '<'), '>'), 2); 
        $prefix = ''; 
        if(strpos($paramVal, ':') !== false){
            list($regx, $prefix) = explode(':', $paramVal);
        }else{
            $regx = $paramVal;
        }   
        preg_match("/^{$regx}$/", $param, $matches);
        if(!empty($matches[0])){
            $param = substr($param, strlen($prefix));
            $_GET[$paramKey] = $param;
            return true;
        }   
        return false;
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
