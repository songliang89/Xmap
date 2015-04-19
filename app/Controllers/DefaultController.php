<?php  namespace App\Controllers;

use Libs\Illuminate\Controller;

class DefaultController extends Controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
    }
    
}
