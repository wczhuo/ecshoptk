<?php
function smarty_function_turl($paramer,$template){
	global $config,$seo;
	$url  =  get_url($paramer,$config,$seo,'px','',$template);
	return $url;
}
?>