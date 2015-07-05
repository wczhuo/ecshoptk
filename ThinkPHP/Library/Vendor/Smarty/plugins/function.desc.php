<?php
function smarty_function_desc($paramer,&$smarty){
	global $db,$db_config,$config;
	/*$class=$db->select_all("desc_class");
	$desc=$db->select_all("description","`is_nav`='1'");*/
    include(PLUS_PATH.'/desc.cache.php');
	/*if(is_array($class)){
		foreach($class as $k=>$v){
			foreach($desc as $val){
				if($v['id']==$val['nid']){
					$class[$k]['list'][]=$val;
				}
			}
		}
	}*/
    foreach($desc_class as $k=>$v){
        foreach($desc_list as $val){
            if($v['id']==$val['nid']){
                $desc_class[$k]['list'][]=$val;
            }
        }
    }
	$smarty->assign("$paramer[assign_name]",$desc_class);
}