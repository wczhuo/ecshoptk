<?php
function smarty_function_aurl($paramer,$template){
	global $config,$seo;
	$url  =  get_url($paramer,$config,$seo,'ask','',$template);
	return $url;
}
?>