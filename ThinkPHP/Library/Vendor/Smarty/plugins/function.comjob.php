<?php
function smarty_function_comjob($paramer,$template){
	global $config,$seo;
	$url  =  get_url($paramer,$config,$seo,'company','',$template);
    global $views, $phpyun,$config;
	$limit=(int)$params['limit'];
	$limit=$limit?$limit:10;
	$order=$order?$order:"id desc";
	$where=$where?$where:1;
	if($params['status']==""){
		$where.=" and `state`='1'";
	}else{
		$where.=" and `state`='".$params['status']."'";
	}
	$where.=" and `uid`='".$_GET['id']."'";
	$rows=$views->obj->DB_select_all("company_job",$where." and `r_status`<>'2' and `status`<>'2' order by $order limit $limit");    
    $template->tpl_vars['job'] = new Smarty_Variable;
    $template->tpl_vars['job']->value=$rows;    
	return;
}
?>