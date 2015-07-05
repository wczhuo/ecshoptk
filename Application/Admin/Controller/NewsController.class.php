<?php
namespace Admin\Controller;
use Think\Controller;
class NewsController extends Controller {
    public function index(){
        MakeHtml(ROOT_PATH.'/News/264.html','http://localhost/duoyiren/company/index.php?id=2477','');die;
        $this->display("newsList");
    }
    function makeHtml(){
        /*if($_POST['value']==0){
            $where="1";
            if($_POST['group']>0){
                $where.=" and `nid`='".$_POST['group']."'";
            }
            if($_POST['startid']>0){
                $where.=" and `id`>='".$_POST['startid']."'";
            }
            if($_POST['endid']>0){
                $where.=" and `id`<='".$_POST['endid']."'";
            }
            $rows=$this->obj->DB_select_all("news_base",$where,"`id`,`datetime`");
            $allnum=count($rows);
            $allpage=ceil(($allnum)/$pagesize);
            $i=1;
            foreach($rows as $v){
                if(count($val[$i])<=$pagesize){
                    $val[$i][$v['id']]=$v['datetime'];
                }else{
                    $i++;
                    $val[$i][$v['id']]=$v['datetime'];
                }
            }
            include_once(LIB_PATH."public.function.php");
            $this->obj->made_web("../plus/news.cache.php",ArrayToString2($val),"newscache");
            $page=1;
        }else{
            $page=$_POST['value'];
            include_once(PLUS_PATH."news.cache.php");
            if(is_array($newscache)){
                foreach($newscache as $k=>$va){
                    if($k==$page){
                        foreach($va as $key=>$value){$this->makearchive($key,$value);}
                    }elseif($k>$page){
                        $val[$k]=$va;
                    }
                }
            }
            $page=$page+1;
            if(!is_array($val)){$page=0;unlink("../plus/news.cache.php");}
        }
        return $page;*/
    }
}