<?php
function smarty_function_product($paramer,$template){
	global $views,$phpyun,$config;
	$rows=$views->obj->DB_select_all("company_product","`status`='1' and `uid`='".$_GET['id']."'");
    $template->tpl_vars['product'] = new Smarty_Variable;
    $template->tpl_vars['product']->value=$rows; 
	return;
}
?>