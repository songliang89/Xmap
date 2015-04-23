<?php  namespace App\Controllers;

use Libs\Controller\Controller;
use Libs\Exception\BaseException;

class DefaultController extends Controller {

    protected $input = [];

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        
        $this->input = array_merge($_GET, $_POST);
    }

    public function arrInput($key){
        if (isset($this->input[$key])) {
            return $this->input[$key];
        }
        throw new BaseException('Param missed.', 1026);
    }
}
