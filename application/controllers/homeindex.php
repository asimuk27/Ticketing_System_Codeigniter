<?php    
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/frontend/Home.php');    
class homeIndex extends home {    
    public function index() {
        $this->action();
    }    
}