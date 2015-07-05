<?php
function smarty_function_seacrh_url($paramer,$_smarty_tpl){
	$paramer=formatparamer($paramer,$_smarty_tpl);
	extract($paramer);
    global $config;
	$url=$_GET;
	if($thisdir!=""){
		$return_url=$thisdir."/lietou/index.php?";
	}else{
		$return_url="index.php?";
	}
	/*if($m){
        $return_url_new[]="m=".$m;
	}*/
    //W:二级路径20150418
    $LevelTwoList=array('job','resume','zph','map','tiny','once','firm');
    
    if(in_array($m,$LevelTwoList)){
        $return_url=$config['sy_weburl'].'/'.$m.'/'.$return_url;
        unset($m);
        unset($url['m']);
    }
    //W:二级路径20150418
    
	foreach($paramer as $key=>$va){
		if($key!="m" && $key!="untype" && $key!="thisdir" && $key!="adt"  && $key!="adv"){
			$return_url_new[]=$key."=".$va;
		}
	}
	
	unset($url['m']);
	$untype=@explode(",",$untype);
	foreach($url as $key=>$va){
		if($va!="" && !in_array($key,$untype)){
			$return_url_new[]=$key."=".$va;
		}
	}
	if($paramer['adt']){
		$return_url_new[]=$paramer['adt']."=".$paramer['adv'];
	}
	$return_url=$return_url.@implode('&',$return_url_new);
    
    $return_url=str_replace('/index.php?','/?',$return_url);
    if(substr($return_url,0,10)=='index.php?'){
        $return_url=substr($return_url,9);
    }
    if(substr($return_url,strlen($return_url)-10)=='index.php?'){
        $return_url=substr($return_url,0,strlen($return_url)-10);
    }
    if(substr($return_url,strlen($return_url)-9)=='index.php'){
        $return_url=substr($return_url,0,strlen($return_url)-9);
    } 
    if(substr($return_url,strlen($return_url)-1)=='?'){
        $return_url=substr($return_url,0,strlen($return_url)-1);
    } 
	return $return_url;
}
?>