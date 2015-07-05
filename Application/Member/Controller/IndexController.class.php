<?php
namespace Member\Controller;
use Think\Controller;

class IndexController extends Controller {
    public function index(){
        //$this->DBInsertOne();
        $MemberList=M('member')->select();
        
        $this->assign("MemberList",$MemberList);
        //echo "asdfasdf";
        $this->display("index");
        
    }
}