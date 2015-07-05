<?php
function smarty_function_htmlentitydecode($paramer,$template){
	extract($params);
	$str=str_replace(array("&amp;nbsp;"," "),array("",""),$str);
	return html_entity_decode($str,ENT_QUOTES,"GB2312");
}
?>