<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/**
 * Think Admin 自定义函数库 Create By  WangChengZhuo
 */

/**
 * 获取和设置配置参数 支持批量定义
 * @param string|array $name 配置变量
 * @param mixed $value 配置值
 * @param mixed $default 默认值
 * @return mixed
 */
function CacheMake($cacheFileName=null, $cacheContent=null,$cacheDirectory=null,$IsCompress=false) {
    $content="<?php \n";
    if(is_array($cacheContent)){
        foreach($cacheContent as $key=>$v){
            if(is_array($v)){
                $content.="\$$key=array(";
                $content.=MakeString($v,'',$IsCompress);
                $content.=");";
            }else{
                //$v = str_replace("'","\\'",$v);
                //$v = str_replace("\"","'",$v);
                //$v = str_replace("\$","",$v);
                if($IsCompress){
                    $content.="\$$key=".str_replace(array("\r\n", "\r", "\n"," "),'',$v).";";
                }else{
                    $content.="\$$key=".$v.";";
                }
            }
            if(!$IsCompress){
                $content.=" \n";
            }
        }
    }
    $content.="?>";
    $fpindex=@fopen($cacheDirectory.$cacheFileName,"w+");
    $fw=@fwrite($fpindex,$content);
    @fclose($fpindex);
    return $fw;
}

function CacheMakeEncode($cacheFileName=null, $cacheContent=null,$cacheDirectory=null) {
    $content=base64_encode(bzcompress(serialize($cacheContent),9));
    $cont="<?php";
    $cont.="\r\n";
    $cont.="\$content='".$content."';";
    $cont.="?>";
    $fpindex=@fopen($cacheDirectory.$cacheFileName,"w+");
    $fw=@fwrite($fpindex,$cont);
    @fclose($fpindex);
    return $fw;
}

/**
 * 获取和设置配置参数 支持批量定义
 * @param string|array $name 配置变量
 * @param mixed $value 配置值
 * @param mixed $default 默认值
 * @return mixed
 */
function FileMake($htmlFileName=null, $htmlContent=null,$htmlDirectory=null) {
    $fpindex=@fopen($htmlDirectory.$htmlFileName,"w+");
    $fw=@fwrite($fpindex,$htmlContent);
    @fclose($fpindex);
    return $fw;
}

function JsonEcho($outputInfo){
    $outputInfp=json_encode($outputInfo);
    echo json_encode($outputInfo);
}
/*function ConvertSpell($String=''){
    include_once(ROOT_PATH.'/Application/Admin/Common/spell.php');
    return GenerateSpell($String);
}
function ConvertPinyin($String=''){
    include_once(ROOT_PATH.'/Application/Admin/Common/pinyin.php');
    $Convert=new CUtf8_PY();
    return $Convert->str2py($String);
}*/
function ConvertSpell($String=''){
    include_once(ROOT_PATH.'/Cache/pinyin.cache.php');
    $Length=mb_strlen($String,'UTF-8');
    $Pinyin='';
    for($i=0;$i<$Length;$i++){
        $Temp=mb_substr($String,$i,1,'UTF-8');
        $Pinyin.=$PinyinList[$Temp];
    }
    return $Pinyin;
}