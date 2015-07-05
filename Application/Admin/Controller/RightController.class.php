<?php
namespace Admin\Controller;
use Think\Controller;

class IndexController extends Controller {
    public function index(){
        //$this->DBInsertOne();
        $MemberList=M('member')->select();
        
        $this->assign("MemberList",$MemberList);
        $rows=M("admin_link")->where("`link_state`='1'")->select();
        //print_r($rows);die;
		if(is_array($rows)){
			foreach($rows as $key=>$value){
				$row[$key]['id']=$value["id"];
				$row[$key]['link_name']=$value["link_name"];
				$row[$key]['link_url']=$value["link_url"];
				$row[$key]['img_type']=$value["img_type"];
				$row[$key]['pic']=$value["pic"];
				$row[$key]['link_type']=$value["link_type"];
				$row[$key]['domain']=$value["domain"];
				$row[$key]['tem_type']=$value["tem_type"];
			}
		}
		$data['link']=ArrayToString($row);
		CacheMake('link.cache.php',$data,ROOT_PATH.'/Cache/');
        //echo "asdfasdf";
        $this->display("index");
        
    }
}