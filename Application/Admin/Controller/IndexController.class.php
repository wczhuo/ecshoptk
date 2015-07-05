<?php
namespace Admin\Controller;
use Think\Controller;

class IndexController extends Controller {
    public function index(){
        //M('debug')->where(array('test'=>'123','id'=>'555'))->save(array('test'=>'123','content'=>'test123'));
        //汉字转拼音全拼
        //echo ConvertSpell('魍魉');
        //echo ConvertPinyin('魍魉');
        //die;
        $NavigationList1=M('navigation')->where(array('type'=>'0','display'=>'1','path'=>'/'))->select();
        $NavigationList2=M('navigation')->where(array('type'=>'0','display'=>'1',"length(`path`)-length(replace(`path`,'/','')) = 2"))->select();
        $NavigationList3=M('navigation')->where(array('type'=>'0','display'=>'1',"length(`path`)-length(replace(`path`,'/','')) = 3"))->select();
        foreach($NavigationList2 as $k=>$v){
            $KeyID=explode('/',$v['path']);
            if(count($KeyID)==3){
                $NavigationList2New[$KeyID[count($KeyID)-2]][]=$v;
            }
        }
        foreach($NavigationList3 as $k=>$v){
            $KeyID=explode('/',$v['path']);
            if(count($KeyID)==4){
                $NavigationList3New[$KeyID[count($KeyID)-2]][]=$v;
            }
        }
        $this->assign('NavigationList1',$NavigationList1);
        $this->assign('NavigationList2',$NavigationList2New);
        $this->assign('NavigationList3',$NavigationList3New);
        $this->display();
    }
    public function logout(){
        header('Location:'.U('Admin/Login/Index'));
    }
    public function pinyin(){
        die;
        set_time_limit(200);
        $PinyinList=I('pinyins');
        $UrlList=I('urls');
        foreach($PinyinList as $k=>$v){
            $Name=trim(str_replace('\n','',$v));
            $IsExist=M('pinyin')->where(array('pinyin'=>$Name))->select();
            if(!$IsExist){                
                M('pinyin')->add(array('name'=>'','pinyin'=>$Name,'code'=>''));
            }
            if(!file_exists(ROOT_PATH.$UrlList[$k])){
                MakeHtml(ROOT_PATH.$UrlList[$k],'http://xh.5156edu.com/'.$UrlList[$k],null);
            }
        }
    }
    public function pinyinsave(){
        die;
        set_time_limit(200);
        $PinyinList=I('names');
        $pinyin=I('pinyin');
        foreach($PinyinList as $k=>$v){
            $Name=trim(str_replace('\n','',$v));
            $IsExist=M('pinyin')->where(array('name'=>$Name))->select();
            if(!$IsExist){                
                M('pinyin')->add(array('name'=>$Name,'pinyin'=>$pinyin,'code'=>''));
            }
        }
    }
    public function convertcode(){
        die;
        set_time_limit(200);
        do{
            $PinyinList=M('pinyin')->where(array('`name`<>\'\'','`code`=\'\''))->limit(1000)->select();
            foreach($PinyinList as $k=>$v){
                $s=preg_replace("/\s/is","_",$v['name']);
                $s=preg_replace("/(|\~|\`|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\+|\=|\{|\}|\[|\]|\||\\|\:|\;|\"|\'|\<|\,|\>|\.|\?|\/)/is","",$s);
                $py="";
                $i=0;
                //加入这一句，自动识别UTF-8
                if(strlen("拼音")>4)$s=iconv('UTF-8', 'GBK', $s);
                for($i=0;$i<strlen($s);$i++){
                    if(ord($s[$i])>128){
                        if($py!="")$py.="_";
                        $Code=ord($s[$i])+ord($s[$i+1])*256;
                        $i++;
                    }
                }
                M('pinyin')->where(array('id'=>$v['id']))->save(array('code'=>$Code));
            }
        }while(count($PinyinList)>0);
    }
    public function convertascii(){
        //die;
        set_time_limit(200);
        do{
            $PinyinList=M('pinyin')->where(array('`name`<>\'\'','locate(\',\',`ascii`)<=0'))->limit(1000)->select();
            foreach($PinyinList as $k=>$v){
                $s=preg_replace("/\s/is","_",$v['name']);
                $s=preg_replace("/(|\~|\`|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\+|\=|\{|\}|\[|\]|\||\\|\:|\;|\"|\'|\<|\,|\>|\.|\?|\/)/is","",$s);
                $py="";
                $i=0;
                //加入这一句，自动识别UTF-8
                if(strlen("拼音")>4)$s=iconv('UTF-8', 'GBK', $s);
                for($i=0;$i<strlen($s);$i++){
                    if(ord($s[$i])>128){
                        $Code=ord($s[$i]).','.ord($s[$i+1]);
                        $i++;
                    }
                }
                M('pinyin')->where(array('id'=>$v['id']))->save(array('ascii'=>$Code));
            }
        }while(count($PinyinList)>0);
    }
    public function checkascii(){
        //die;
        set_time_limit(0);
        for($high=209;$high<246;$high++){
            for($low=64;$low<255;$low++){
                if(!M('pinyin')->where(array('`ascii`=\''.$high.','.$low.'\''))->limit(1)->select()){
                    //echo $height.','.$low;die;
                    M('pinyin')->add(array('name'=>'','pinyin'=>'','code'=>'','ascii'=>$high.','.$low));
                }
            }
        }
    }
    public function convertasciitocn(){
        //die;
        set_time_limit(0);
        do{
            $PinyinList=M('pinyin')->where(array('`name`=\'\'','`ascii` is not null'))->limit(1000)->select();
            foreach($PinyinList as $k=>$v){
                echo dechex($v['high']);
                echo dechex($v['low']);
                echo chr(dechex($v['high']).dechex($v['low']));die;
                echo $this->u2utf8(49127);die;
            }
        }while(count($PinyinList)>0);
    }
    function u2utf8($c) { 
        $str="";
        if ($c < 0x80) $str.=$c; 
        else if ($c < 0x800) { 
            $str.=chr(0xC0 | $c>>6); 
            $str.=chr(0x80 | $c & 0x3F); 
        } else if ($c < 0x10000) { 
            $str.=chr(0xE0 | $c>>12); 
            $str.=chr(0x80 | $c>>6 & 0x3F); 
            $str.=chr(0x80 | $c & 0x3F); 
        } else if ($c < 0x200000) { 
            $str.=chr(0xF0 | $c>>18); 
            $str.=chr(0x80 | $c>>12 & 0x3F); 
            $str.=chr(0x80 | $c>>6 & 0x3F); 
            $str.=chr(0x80 | $c & 0x3F); 
        }

        return $str; 
    }
}