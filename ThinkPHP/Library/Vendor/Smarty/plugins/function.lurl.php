<?php
function smarty_function_lurl($paramer,$template){
	global $config,$seo;
	$url  =  get_url($paramer,$config,$seo,'lt','',$template);
	return $url;
}
?>