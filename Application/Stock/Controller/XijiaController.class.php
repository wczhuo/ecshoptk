<?php
namespace Football\Controller;
use Think\Controller;

class XijiaController extends Controller {
    public function index(){  
        //$TeamInfo=M('team')->where(array('id'=>I('id')))->select();
        $HomeTeamIDList=M('match')->field('distinct `HOMETEAMID`')->where(array('MATCHGBNAME'=>'西班牙甲级联赛'))->select();
        //print_r($HomeTeamIDList);die;
        foreach($HomeTeamIDList as $k=>$v){
            $IDList[]=$v['hometeamid'];
        }
        $TeamList=M('team')->where(array('`id` in ('.implode(',',$IDList).')'))->select();
        //print_r($TeamList);die;
        $this->assign('TeamList',$TeamList);
        //$this->assign('MatchList',$MatchList);
        
        $this->display();
    }
}