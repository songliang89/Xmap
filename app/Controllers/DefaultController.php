<?php  namespace App\Controllers;

use Libs\Illuminate\Controller;

class DefaultController extends Controller {

    protected $input = [];

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        
        $this->input = array_merge($_GET, $_POST);
    }
}
