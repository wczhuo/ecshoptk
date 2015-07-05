<?php
class Smarty_Internal_Compile_Nav extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'hovclass', 'nid');
    public $shorttag_order = array('from', 'item', 'key', 'name');
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        $from = $_attr['from'];
        $item = $_attr['item'];
        if (!strncmp("\$_smarty_tpl->tpl_vars[$item]", $from, strlen($item) + 24)) {
            $compiler->trigger_template_error("item variable {$item} may not be the same variable as at 'from'", $compiler->lex->taglineno);
        }
        
        //自定义标签START
		$OutputStr='global $db,$db_config,$config;include(PLUS_PATH."/menu.cache.php");$Navlist=array();
		if(is_array($menu_name)){
            eval(\'$paramer='.str_replace('\'','\\\'',ArrayToString($_attr,true)).';\');
			$ParamerArr = GetSmarty($paramer,$_GET);
			$paramer = $ParamerArr[arr];
			$Purl =  $ParamerArr[purl];
			foreach($menu_name[12] as $key=>$val){
				if($val[\'type\']==\'2\'){
					if($config[\'sy_seo_rewrite\']=="1" && $val[furl]!=\'\'){
						$menu_name[12][$key][url] = $val[furl];
					}else{
						$menu_name[12][$key][url] = $val[url];
					}
					$menu_name[12][$key][navclass] = navcalss($val,$paramer[hovclass]);
				}
			}
			foreach($menu_name[1] as $key=>$value){
				if($value[\'type\']==\'1\'){
					if($config[\'sy_seo_rewrite\']=="1" && $value[furl]!=\'\'){
						$menu_name[1][$key][url] = $config[sy_weburl]."/".$value[furl];
					}else{
						$menu_name[1][$key][url] = $config[sy_weburl]."/".$value[url];
					}
					$menu_name[1][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
			foreach($menu_name[2] as $key=>$value){
				if($value[\'type\']==\'1\'){
					if($config[\'sy_seo_rewrite\']=="1" && $value[furl]!=\'\'){
						$menu_name[2][$key][url] = $config[sy_weburl]."/".$value[furl];
					}else{
						$menu_name[2][$key][url] = $config[sy_weburl]."/".$value[url];
					}
					$menu_name[2][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
			foreach($menu_name[4] as $key=>$value){
				if($value[\'type\']==\'1\' && $value[furl]!=\'\'){
					if($config[\'sy_seo_rewrite\']=="1"){
						$menu_name[4][$key][url] = $config[sy_weburl]."/".$value[furl];
					}else{
						$menu_name[4][$key][url] = $config[sy_weburl]."/".$value[url];
					}
					$menu_name[4][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
			foreach($menu_name[5] as $key=>$value){
				if($value[\'type\']==\'1\' && $value[furl]!=\'\'){
					if($config[\'sy_seo_rewrite\']=="1"){
						$menu_name[5][$key][url] = $config[sy_weburl]."/".$value[furl];
					}else{
						$menu_name[5][$key][url] = $config[sy_weburl]."/".$value[url];
					}
					$menu_name[5][$key][navclass] = navcalss($value,$paramer[hovclass]);
				}
			}
		}
		//默认调用头部导航
		if($paramer[nid]){
			$Navlist =$menu_name[$paramer[nid]];
		}else{
			$Navlist =$menu_name[1];
		}';

        return SmartyOutputStr($this,$compiler,$_attr,'nav','$Navlist',$OutputStr,'$Navlist');
    }
}
class Smarty_Internal_Compile_Navelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('nav'));
        $this->openTag($compiler, 'navelse', array('navelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Navclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('nav', 'navelse'));

        return "<?php } ?>";
    }
}
