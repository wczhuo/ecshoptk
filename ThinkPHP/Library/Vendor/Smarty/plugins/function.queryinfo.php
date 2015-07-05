<?php 
function smarty_function_queryinfo($paramer,&$smarty){
	global $db;
    if (PHP_VERSION >= '5.0.0'){
        $query_time = number_format(microtime(true) - $db->queryTime, 6);
    }else{
        list($now_usec, $now_sec)     = explode(' ', microtime());
        list($start_usec, $start_sec) = explode(' ', $db->queryTime);
        $query_time = number_format(($now_sec - $start_sec) + ($now_usec - $start_usec), 6);
    }
    if (function_exists('memory_get_usage')){
        $memory_usage = '，占用内存 '.(memory_get_usage() / 1048576).' MB';
    }else{
        $memory_usage = '';
    }
    /*foreach($db->querySQLList as $k){
        $QuerySQL[]=
    }*/
    $QuerySQL=implode('<br/>',$db->querySQLList);
    //echo '共执行 '.$db->queryCount.' 个查询，用时 '.$query_time.' 秒，在线 1 人，Gzip 已禁用，占用内存 3.269 MB';
    echo '共执行 '.$db->queryCount.' 个查询，用时 '.$query_time.' 秒'.$memory_usage.'<br/>'.$QuerySQL;
}
?>