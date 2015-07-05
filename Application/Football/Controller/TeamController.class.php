<?php
namespace Football\Controller;
use Think\Controller;

class TeamController extends Controller {
    public function index(){   
        $TeamInfo=M('team')->where(array('id'=>I('id')))->select();
        $MatchList=M('match')->where(array('team_id'=>I('id')))->select();
        
        //ss胜胜，sp胜平，sf胜负，ps平胜，pp平平，pf平负，fs负胜，fp负平，ff负负
        //$TongjiList[]=array();
        
        $AwayTeamID=883;
        $HomeTeamID=I('id');
        
        
        
        $MatchList=array_reverse($MatchList);
        $TongjiList=array('胜胜'=>0,'胜平'=>0,'胜负'=>0,'平胜'=>0,'平平'=>0,'平负'=>0,'负胜'=>0,'负平'=>0,'负负'=>0);
        for($i=1;$i<count($MatchList);$i++){
            $Result1=$MatchList[$i-1]['result'];
            $Result2=$MatchList[$i]['result'];
            $Result1=strstr($Result1,'胜')?'胜':$Result1;
            $Result1=strstr($Result1,'负')?'负':$Result1;
            $Result1=strstr($Result1,'平')?'平':$Result1;
            $Result2=strstr($Result2,'胜')?'胜':$Result2;
            $Result2=strstr($Result2,'负')?'负':$Result2;
            $Result2=strstr($Result2,'平')?'平':$Result2;
            $TypeName=$Result1.$Result2;  
            //echo $TypeName.'<br>';
            $TongjiList[$TypeName]++;
        }
        //$MatchList=array_reverse($MatchList);
        //print_r($TongjiList);
        //$TypeKeyList=array_keys($TypeNameList);
        $Total=count($MatchList)-1;
        foreach($TongjiList as $k=>$v){
            $TongjiList[$k]=array();
            $TongjiList[$k]['tongji']=$v/$Total;
            //$TongjiList[$k]['name']=$TypeKeyList[$k-1];
        }
        
        //print_r($TongjiList);
        arsort($TongjiList);
        $this->assign('TeamInfo',$TeamInfo[0]);
        $this->assign('MatchList',$MatchList);
        $this->assign('TongjiList',$TongjiList);
        
        $this->display();
    }
}