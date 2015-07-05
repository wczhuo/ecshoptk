<?php
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller {
    public function index(){
        $this->display("index");
    }
    
    public function save(){        
        /*ob_end_clean();
        header("Content-Type:text/html;charset=utf8;");
        ob_start();
        for($i=0;$i<10;$i++){ 
            echo '<script>parent.PostReturnCallback(\''.'登录成功！'.$i.'\');</script>';  
            ob_flush();
            flush();  
            ob_end_flush();
            sleep(1);
        }*/
        $OutputInfo=json_encode(array('msg'=>'登录成功，操作结束！'.$i,'url'=>U('Admin/Index/Index'),'autoClose'=>'1','type'=>'1'));
        echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
    }
}