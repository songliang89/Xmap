<?php namespace Libs\Container; 

class Message {

    public static function showError() {
        
    }

    public function showSucc($msg, $data=array(), $otherData=array(), $url='', $t=3, $ie='', $oe='UTF-8'){
       self::message($code, $msg, $data, $url, $t, $otherData, $ie='', $oe); 
    }

    protected static function message($code, $msg, $data, $url, $t, $otherData=array(), $ie='', $oe='UTF-8') {
        
        $format = empty($_REQUEST['format']) ? '' : strtolower($_REQUEST['format']);
        
        if (isset($_GET['oe']) && in_array(strtoupper($_GET['oe']), array('GBK', 'UTF-8'), true)) {
            $oe = $_GET['oe'];
        }
       
        $oe = $format === 'json' ? 'UTF-8' : $oe;// standard json only support utf8 chinese.

        $code = intval($code);

        if(!empty($ie) && strcasecmp($ie, $oe) !== 0) {
            $msg = Common::convertEncoding($msg, $oe, $ie);
            $data = Common::convertEncoding($data, $oe, $ie);
            $otherData = Common::convertEncoding($otherData, $oe, $ie);
        }

       switch($format) {

            case 'xml':
                header("Content-Type: text/xml; charset=" . strtoupper($oe));
                $outArr = array();
                if (!is_array($msg)) {
                    $outArr['status']['code'] = $code;
                    $outArr['status']['msg'] = $msg;
                    if (is_array($otherData)) {
                        foreach ($otherData as $k=>$v) {
                            if (!in_array($k, array('status', 'data'), true)) {
                                $outArr[$k] = $v; 
                            }   
                        }   
                    }   
                    $outArr['data'] = $data;
                } else {
                    $outArr = $msg;
                }   
                $xml = new BaseModelXML();
                $xml->setSerializerOption(XML_SERIALIZER_OPTION_ENCODING, $oe);
                echo $xml->encode($outArr);
            break;
            case 'json':
                $outArr = array();
                if (!is_array($msg)) {
                    $outArr['status']['code'] = $code;
                    $outArr['status']['msg'] = $msg;
                    if (is_array($otherData)) {
                        foreach ($otherData as $k=>$v) {
                            if (!in_array($k, array('status', 'data'), true)) {
                                $outArr[$k] = $v;
                            }
                        }
                    }
                    $outArr['data'] = $data;
                } else {
                    $outArr = $msg;
                }
                $json = json_encode($outArr);
                $callback = isset($_GET['callback']) ? $_GET['callback'] : '';
                if (preg_match("/^[a-zA-Z][a-zA-Z0-9_\.]+$/", $callback)) {
                    if(isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') { //POST
                        header("Content-Type: text/html");
                        $refer = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER']) : array();
                        if(!empty($refer) && (substr($refer['host'],-8,8)=='weibo.com')){
                            $result = '<script>document.domain="yence.cn";';
                        }else{
                            $result = '<script>document.domain="sina.com.cn";';
                        }
                        $result .= "parent.{$callback}({$json});</script>";
                        echo $result;
                    } else {
                        if(isset($_SERVER['HTTP_USER_AGENT']) && stripos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
                            header('Content-Type: text/javascript; charset=UTF-8');
                        } else {
                            header('Content-Type: application/javascript; charset=UTF-8');
                        }
                        echo "{$callback}({$json});";
                    }
                } elseif ($callback) {
                    header('Content-Type: text/html; charset=UTF-8');
                    echo 'callback params contain illegal character.';
                } else {
                    if(isset($_SERVER['HTTP_USER_AGENT']) && stripos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
                        header('Content-Type: text/plain; charset=UTF-8');
                    } else {
                        header('Content-Type: application/json; charset=UTF-8');
                    }
                    echo $json;
                }
            break;
            default:
            break; 
        }
    } 
}
