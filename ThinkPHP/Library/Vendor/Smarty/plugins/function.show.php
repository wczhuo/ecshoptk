<?php
function smarty_function_show($paramer,$template){
	global $views,$phpyun;
	$rows=$views->obj->DB_select_all("company_show","`uid`='".$_GET['id']."'");
    $template->tpl_vars['show'] = new Smarty_Variable;
    $template->tpl_vars['show']->value=$rows;  
	return;
}
?>