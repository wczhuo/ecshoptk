<?php
function smarty_function_curl($paramer,$template){
	global $config,$seo;
	$url  =  get_url($paramer,$config,$seo,'company','',$template);
	return $url;
}
?>