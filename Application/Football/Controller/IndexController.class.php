<?php
namespace Football\Controller;
use Think\Controller;

class IndexController extends Controller {
    public function index(){        
        $this->display();
    }
    public function convert(){
        ob_end_clean();
        header("Content-Type:text/html;charset=utf8;");
        ob_start();
        set_time_limit(6000);
        $Min=I('min');
        $Max=I('max');
        if(!(is_numeric($Min)&&is_numeric($Max)&&($Min<=$Max)&&($Min<=3000))){ 
            $OutputInfo=json_encode(array('msg'=>'参数不正确！'.$i,'url'=>U('Football/Index/Index'),'autoClose'=>'1','type'=>'1'));
            echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
        }
        $Type=array('all'=>1,'team'=>2,'match'=>3)[I('type')];
        switch($Type){
            case 2:
                $ReturnInfo=$this->ConvertTeam($Min,$Max);
                if($ReturnInfo==1){                    
                    $OutputInfo=json_encode(array('msg'=>'参数不正确！'.$i,'url'=>U('Football/Index/Index'),'autoClose'=>'1','type'=>'1'));
                    echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
                }else{                    
                    $OutputInfo=json_encode(array('msg'=>'添加成功，操作结束！'.$i,'url'=>U('Football/Index/Index'),'autoClose'=>'1','type'=>'1'));
                    echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
                }
                break;
            case 3:
                $ReturnInfo=$this->ConvertMatch($Min,$Max);
                if($ReturnInfo==1){                   
                    $OutputInfo=json_encode(array('msg'=>'参数不正确！'.$i,'url'=>U('Football/Index/Index'),'autoClose'=>'1','type'=>'1'));
                    echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
                }else{  
                    $Header='Location:http://localhost'.U('Football/Index/Convert/?type=match&min='.$Max.'&max='.($Max+50));
                    $Url=U('Football/Index/Convert/?type=match&min='.($Max+1).'&max='.($Max+50));  
                    echo '<script>location.href="'.$Url.'";</script>';die;
                    header($Header);//return;die;
                    $Url=U('Football/Index/Convert/?type=match&min='.($Max+1).'&max='.($Max+50));            
                    $OutputInfo=json_encode(array('msg'=>'添加成功，操作结束！'.$i,'url'=>$Url,'autoClose'=>'1','type'=>'1'));
                    echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
                }
                break;
            default:
                $ReturnInfo=$this->ConvertTeam($Min,$Max);
                $ReturnInfo=$this->ConvertMatch($Min,$Max);
                if($ReturnInfo==1){                    
                    $OutputInfo=json_encode(array('msg'=>'参数不正确！'.$i,'url'=>U('Football/Index/Index'),'autoClose'=>'1','type'=>'1'));
                    echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
                }else{                    
                    $OutputInfo=json_encode(array('msg'=>'添加成功，操作结束！'.$i,'url'=>U('Football/Index/Index'),'autoClose'=>'1','type'=>'1'));
                    echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
                }
                break;
        }
    }
    private function ConvertTeam($Min=null,$Max=null){        
        if(is_numeric($Min)&&is_numeric($Max)&&($Min<=$Max)){            
            for($i=$Min;$i<=$Max;$i++){
                if(file_exists(ROOT_PATH.'/Football/'.$i.'.html')&&(!M('team')->where(array('old_id'=>$i))->select())){ 
                    echo '<script>parent.PostReturnCallback(\''.'正在添加！'.$i.'\');</script>';  
                    ob_flush();
                    flush();  
                    ob_end_flush();
                    $CountData=M('match')->where(array('team_id'=>$i))->count();
                    M('match')->where(array('team_id'=>$i))->delete();
                    if(!$CountData){                        
                        $Content=@file_get_contents(ROOT_PATH.'/Football/'.$i.'.html');
                        $ContentJson=json_decode($Content,true);
                        $TeamID=M('team')->add(array('old_id'=>$ContentJson['tid']));
                    }
                }
            }        
            return 2;
        }else{
            return 1;
        }
    }
    private function ConvertMatch($Min=null,$Max=null){        
        if(is_numeric($Min)&&is_numeric($Max)&&($Min<=$Max)){            
            for($i=$Min;$i<=$Max;$i++){
                if(file_exists(ROOT_PATH.'/Football/'.$i.'.html')){ 
                    echo '<script>parent.PostReturnCallback(\''.'正在添加！'.$i.'\');</script>';  
                    ob_flush();
                    flush();  
                    ob_end_flush();
                    $CountData=M('match')->where(array('team_id'=>$i))->count();
                    M('match')->where(array('team_id'=>$i))->delete();
                    if(!$CountData){                        
                        $Content=@file_get_contents(ROOT_PATH.'/Football/'.$i.'.html');
                        $ContentJson=json_decode($Content,true);  
                        $TeamInfo=M('team')->where(array('team_id_old'=>$ContentJson['tid']))->select();
                        $TeamInfo=$TeamInfo[0];
                        foreach($ContentJson['list'] as $k=>$v){
                            $VNew=$v;
                            $VNew['team_id']=$TeamInfo['id'];
                            $VNew['team_id_old']=$ContentJson['tid'];
                            M('match')->add($VNew);
                        }                        
                        //$TeamID=M('team')->where(array(''))->save(array('old_id'=>$ContentJson['tid']));
                    }
                }
            }
            return 2;
        }else{
            return 1;
        }
    }
    public function check(){
        ob_end_clean();
        header("Content-Type:text/html;charset=utf8;");
        ob_start();
        set_time_limit(600);
        $TeamList=M('team')->where('old_id is null')->select();
        foreach($TeamList as $k=>$v){
            $CountData=M('match')->where(array('team_id'=>$v['id']))->count();
            
            $Content=@file_get_contents(ROOT_PATH.'/Football/'.$v['id'].'.html');
            $ContentJson=json_decode($Content,true);
            $TeamID=M('team')->add(array('old_id'=>$ContentJson['tid']));
            $CountFile=count($ContentJson['list']);
            
            if($CountData!=$CountFile){
                if(file_exists(ROOT_PATH.'/Football/'.$v['id'].'.html')){
                    echo '<script>parent.PostReturnCallback(\''.'正在检查！'.$v['id'].'\');</script>';  
                    ob_flush();
                    flush();  
                    ob_end_flush();
                    $Content=@file_get_contents(ROOT_PATH.'/Football/'.$v['id'].'.html');
                    $ContentJson=json_decode($Content,true);
                    M('team')->where(array('id'=>$v['id']))->save(array('old_id'=>$ContentJson['tid']));
                    M('match')->where(array('team_id'=>$v['id']))->delete();
                    $TeamID=$v['id'];
                    foreach($ContentJson['list'] as $k=>$v){
                        $VNew=$v;
                        $VNew['team_id']=$TeamID;
                        $VNew['team_id_old']=$ContentJson['tid'];
                        M('match')->add($VNew);
                    }
                }
            }
        }

        $OutputInfo=json_encode(array('msg'=>'检查成功，操作结束！'.$i,'url'=>U('Football/Index/Index'),'autoClose'=>'1','type'=>'1'));
        echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
    }
    public function update(){
        /*ob_end_clean();
        header("Content-Type:text/html;charset=utf8;");
        ob_start();*/
        set_time_limit(600);
        $Min=I('min');
        $Max=I('max');
        if(!(is_numeric($Min)&&is_numeric($Max)&&($Min<=$Max)&&($Min<=3000))){ 
            $OutputInfo=json_encode(array('msg'=>'参数不正确！'.$i,'url'=>U('Football/Index/Index'),'autoClose'=>'1','type'=>'1'));
            echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
        }
        M('match')->execute('update ft_team ft set `name`=(SELECT `HOMETEAMSXNAME` from ft_match fm where ft.old_id=fm.HOMETEAMID limit 1) WHERE ft.id>='.$Min.' and ft.id<='.$Max.'');
        
        $Url=U('Football/Index/Update/?type=team&min='.($Max+1).'&max='.($Max+10));  
        echo '<script>location.href="'.$Url.'";</script>';die;
        /*$OutputInfo=json_encode(array('msg'=>'检查成功，操作结束！'.$i,'url'=>U('Football/Index/Index'),'autoClose'=>'1','type'=>'1'));
        echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;*/
    }
    public function delete(){
        ob_end_clean();
        header("Content-Type:text/html;charset=utf8;");
        ob_start();
        set_time_limit(600);
        $Min=I('min');
        $Max=I('max');
        for($i=$Min;$i<=$Max;$i++){  
            echo '<script>parent.PostReturnCallback(\''.'正在检查！'.$i.'\');</script>';  
            ob_flush();
            flush();  
            ob_end_flush();
            $Content=@file_get_contents(ROOT_PATH.'/Football/'.$i.'.html');
            $ContentJson=json_decode($Content,true);
            if(!$ContentJson){
                unlink(ROOT_PATH.'/Football/'.$i.'.html');
            }
        }
        $OutputInfo=json_encode(array('msg'=>'检查成功，操作结束！'.$i,'url'=>U('Football/Index/Index'),'autoClose'=>'1','type'=>'1'));
        echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
    }
    public function get(){
        ob_end_clean();
        header("Content-Type:text/html;charset=utf8;");
        ob_start();
        set_time_limit(500);
        $Min=I('min');
        $Max=I('max');
        if(is_numeric($Min)&&is_numeric($Max)&&($Min<=$Max)){            
            //http://match.sports.sina.com.cn/football/team_iframe.php?id=4418&year=2008
            //http://liansai.500.com/index.php?c=teams&a=ajax_fixture&records=100&tid=864&hoa=0
            for($i=$Min;$i<=$Max;$i++){
                if(!file_exists(ROOT_PATH.'/Football/'.$i.'.html')){
                    echo '<script>parent.PostReturnCallback(\''.'正在获取！'.$i.'\');</script>';  
                    ob_flush();
                    flush();  
                    ob_end_flush();
                    MakeHtml(ROOT_PATH.'/Football/'.$i.'.html','http://liansai.500.com/index.php?c=teams&a=ajax_fixture&records=100&tid='.$i.'&hoa=0','');
                }
            }
            $OutputInfo=json_encode(array('msg'=>'获取成功，操作结束！'.$i,'url'=>U('Football/Index/Index'),'autoClose'=>'1','type'=>'1'));
            echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
            //echo '获取成功！';
        }else{
            $OutputInfo=json_encode(array('msg'=>'参数不正确！'.$i,'url'=>U('Football/Index/Index'),'autoClose'=>'1','type'=>'1'));
            echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
            //echo '参数不正确！';
        }
    }
}