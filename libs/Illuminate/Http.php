<?php namespace Libs\Illuminate;

class Http {
   
    const HTTP_TIMEOUT = 5; 

    public static function curlReq($url, $params = [], $method = 'get', $format = 'json', $cookie = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
        curl_setopt($ch, CURLOPT_HEADER, 0); //如果设为0，则不使用header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    
        if($method == 'post') {
            curl_setopt($ch, CURLOPT_POST, 1); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }   
    
        if(null !== $cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }   
    
        $response = curl_exec($ch);
        if($format=='json'){
            $response = json_decode($response, true);
        }   
        return $response; 
    } 
}
