<?php namespace Libs\Container;

class Common {
    
    /**
     * Create a directory recursion. 
     * 
     * @param string $pathname
     * @param int $mode
     * @return void
     */
    public static function recursiveMkdir($pathname, $mode = 0755) {
        return is_dir($pathname) ? true : mkdir($pathname, $mode, true);
    }


    /**
     * 转码函数
     * @param Mixed $data 需要转码的数组
     * @param String $dstEncoding 输出编码
     * @param String $srcEncoding 传入编码
     * @param bool $toArray 是否将stdObject转为数组输出
     * @return Mixed
     */
    public static function convertEncoding($data, $dstEncoding, $srcEncoding, $toArray=false) {
        if ($toArray && is_object($data)) {
            $data = (array)$data;
        }
        if (!is_array($data) && !is_object($data)) {
            $data = mb_convert_encoding($data, $dstEncoding, $srcEncoding);
        } else {
            if (is_array($data)) {
                foreach($data as $key=>$value) {
                    if (is_numeric($value)) {
                        continue;
                    }
                    $keyDstEncoding = self::convertEncoding($key, $dstEncoding, $srcEncoding, $toArray);
                    $valueDstEncoding = self::convertEncoding($value, $dstEncoding, $srcEncoding, $toArray);
                    unset($data[$key]);
                    $data[$keyDstEncoding] = $valueDstEncoding;
                }
            } else if(is_object($data)) {
                $dataVars = get_object_vars($data);
                foreach($dataVars as $key=>$value) {
                    if (is_numeric($value)) {
                        continue;
                    }
                    $keyDstEncoding = self::convertEncoding($key, $dstEncoding, $srcEncoding, $toArray);
                    $valueDstEncoding = self::convertEncoding($value, $dstEncoding, $srcEncoding, $toArray);
                    unset($data->$key);
                    $data->$keyDstEncoding = $valueDstEncoding;
                }
            }
        }
        return $data;
    }


    /**
     * 类/函数名构造
     * @param $name String 传入名
     * @param $type String 类型：function | class
     * @return string 类/函数名
     */
    public static function getFormatName($name, $type = 'function') {
        $name = array_map('ucfirst', explode('_', $name));
        if('function' === strtolower($type)) {
            $name[0] = strtolower($name[0]);
        }
        return implode('', $name);
    }
}
