<?php 
function smarty_function_querytime($paramer,&$smarty){
	global $db,$GlobalStartTime;
    if (PHP_VERSION >= '5.0.0'){
        $query_time = number_format(microtime(true) - $GlobalStartTime, 6);
    }else{
        list($now_usec, $now_sec)     = explode(' ', microtime());
        list($start_usec, $start_sec) = explode(' ', $GlobalStartTime);
        $query_time = number_format(($now_sec - $start_sec) + ($now_usec - $start_usec), 6);
    }die;
    echo '<div style="background-color:red; width:100%; display:block; float:left; height:40px; font-size:18px;">”√ ± '.$query_time.' √Î</div>';
}
?>