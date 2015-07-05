<?php
function smarty_function_includesite($paramer,$template){
	global $config,$seo;
	if($config['sy_web_site']=="1"){
        if($_SESSION['cityname']){
            $cityname = $_SESSION['cityname'];
        }else{
            $cityname = $config['sy_indexcity'];
        }
        $site_url = Url("index","index",array("c"=>"site"),"1");
        $html = "<div class=\"heder_city_line  icon2\"><div class=\"header_city_h1\">".$cityname."</div><div class=\"header_city_more icon2\"><a href=\"".$site_url."\">更多城市</a></div></div>";
    }
	return $html;
}
?>