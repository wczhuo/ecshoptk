<?php
namespace Admin\Controller;
use Think\Controller;
class CustomMenuController extends Controller {
    public function index(){
        $this->display();
   }
    public function logout(){
        header('Location:'.U('Admin/Login/Index'));
    }
}