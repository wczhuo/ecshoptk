<?php
namespace Mongo\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $name=I('name');
        $keyname=I('keyname');
        //$name=iconv('UTF-8','GBK',$name);
        //$keyname=iconv('UTF-8','GBK',$keyname);
        //$name=str_replace(array('区','县','省','市'),'',$name);
        $keyname=str_replace(array('区','县','省','市'),'',$keyname);
        //echo $keyname,$name;die;
        $CityInfo=M('city')->where(array('`name` like \'%'.$name.'%\''))->find();
        //echo $name,count($CityInfo);
        $KeyCityInfo=M('city')->where(array('`name` like \'%'.$keyname.'%\''))->find();
        //echo $KeyCityInfo[0]['id'];die;
        if(!$CityInfo&&(intval($KeyCityInfo['id'])>0)){
            M('city')->add(array('name'=>$name,'keyid'=>$KeyCityInfo['id'],'is_display'=>'1','depth'=>'3'));
        }
        $this->display();
    }
}