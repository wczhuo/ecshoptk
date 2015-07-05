<?php
function smarty_function_jobpage($paramer,$template){
	global $views,$phpyun,$config;

	$limit=(int)$limit;
	$limit=$limit?$limit:10;
	$order=$order?$order:"id desc";
	$where=$where?$where:1;
	$where.=" and `r_status`<>'2' and `status`<>'1'";
	$time=time();
	$where.=" and `edate`>'$time'";
	if($params['status']==""){
		$where.=" and `state`='1'";
	}else{
		$where.=" and `state`='".$params['status']."'";
	}
	$where.=" and `uid`='".$_GET['id']."'";
	if($_GET['m']==""){
		$_GET['m']='index';
	}

	$pageurl=$views->curl(array("url"=>"id:".$_GET['id'].",tp:".$_GET['tp'].",page:{{page}}"));
	$rows = $views->get_page("company_job",$where." order by ".$order,$pageurl,$params['limit']);
	include(PLUS_PATH."city.cache.php");
	include(PLUS_PATH."com.cache.php");
	if(is_array($rows)){
		foreach($rows as $k=>$v){
			$rows[$k]['province']=$city_name[$v['provinceid']];
			$rows[$k]['city']=$city_name[$v['cityid']];
			$rows[$k]['nums']=$comclass_name[$v['number']];
		}
	}
    $template->tpl_vars['jobpage'] = new Smarty_Variable;
    $template->tpl_vars['jobpage']->value=$rows;    
    return;
}
?>