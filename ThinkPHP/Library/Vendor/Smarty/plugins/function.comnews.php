<?php
function smarty_function_comnews($paramer,$template){
	global $views,$phpyun,$config;
	$rows=$views->obj->DB_select_all("company_news","`status`='1' and `uid`='".$_GET['id']."'");
    $template->tpl_vars['news'] = new Smarty_Variable;
    $template->tpl_vars['news']->value=$rows; 
	return;
}
?>