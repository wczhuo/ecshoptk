<?php
namespace Admin\Controller;
use Think\Controller;

class WebmasterController extends Controller {
    public function index(){        
        print_r($_SESSION['variable']);
        $this->display();
    }
    public function add(){
        $this->display();
    }
    public function edit(){
        $this->display();
    }
    public function save(){
        $this->display();
    }
}