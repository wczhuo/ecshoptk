<?php
namespace Admin\Controller;
use Think\Controller;
class NavigationController extends Controller {
    public function index(){
        $Type=I('type');
        $NavigationList1=M('navigation')->where(array('type'=>'0','display'=>'1','depth'=>'1'))->select();
        $NavigationList2=M('navigation')->where(array('type'=>'0','display'=>'1','depth'=>'2'))->select();
        $NavigationList3=M('navigation')->where(array('type'=>'0','display'=>'1','depth'=>'3'))->select();
        
        foreach($NavigationList2 as $k=>$v){
            $NavigationList2New[$v['parent_id']][]=$v;
        }
        foreach($NavigationList3 as $k=>$v){
            $NavigationList3New[$v['parent_id']][]=$v;
        }
        $this->assign('NavigationList1',$NavigationList1);
        $this->assign('NavigationList2',$NavigationList2New);
        $this->assign('NavigationList3',$NavigationList3New);
        
        $this->display();
    }
    public function edit(){
        $this->display();
    }
    public function save(){
        $OutputInfo=json_encode(array('msg'=>'保存成功！'.$i,'url'=>U('Admin/Navigation/Index'),'autoClose'=>'1','type'=>'1'));
        echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
    }
}