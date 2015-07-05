<?php
function smarty_function_showpage($paramer,$template){
	global $views,$phpyun,$config;
	$limit=(int)$limit;
	$limit=$limit?$limit:10;
	$order=$order?$order:"id desc";
	$where=$where?$where:1;
	$where.=" and `uid`='".$_GET['id']."'";
	$pageurl=$views->curl(array("url"=>"id:".$_GET['id'].",tp:".$_GET['tp'].",page:{{page}}"));
	$rows = $views->get_page("company_show",$where." order by ".$order,$pageurl,$limit);
    $template->tpl_vars['showpage'] = new Smarty_Variable;
    $template->tpl_vars['showpage']->value=$rows; 
    $template->tpl_vars['jobpage'] = new Smarty_Variable;
    $template->tpl_vars['jobpage']->value=$rows; 
	return;
}
?>