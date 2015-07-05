<?php
function smarty_function_sublen($paramer,$template){
	extract($params);
	if($html==""){
        $str=strip_tags(html_entity_decode(str_replace(array("&amp;","&nbsp;"," "),array("&","",""),$str),ENT_QUOTES,"GB2312"));
	}
	$length=$length?$length:20;
	$charset=$charset?$charset:"gbk";
	return iconv_substr($str,0,$length,$charset);
}
?>