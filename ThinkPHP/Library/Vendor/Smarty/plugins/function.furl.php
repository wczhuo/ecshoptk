<?php
function smarty_function_furl($paramer,$template){
	global $config,$seo;
	$url  =  get_url($paramer,$config,$seo,'friend','',$template);
	return $url;
}
?>