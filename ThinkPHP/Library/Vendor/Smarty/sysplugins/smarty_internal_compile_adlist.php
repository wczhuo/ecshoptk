<?php
class Smarty_Internal_Compile_Adlist extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'classid', 'limit');
    public $shorttag_order = array('from', 'item', 'key', 'name');
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        $from = $_attr['from'];
        $item = $_attr['item'];
        if (!strncmp("\$_smarty_tpl->tpl_vars[$item]", $from, strlen($item) + 24)) {
            $compiler->trigger_template_error("item variable {$item} may not be the same variable as at 'from'", $compiler->lex->taglineno);
        }
        
        //自定义标签 START        
        $OutputStr='$AdArr=array();$paramer=array();';        
		$class_id = $_attr['classid'];        
        $adid = $_attr['adid'];        
        $limit = $_attr['limit'];$limit=is_numeric($limit)?$limit:0;        
        $length = $_attr['length'];$length=is_numeric($length)?$length:0;
        
        if(isset($adid)){  
            $OutputStr.='include(PLUS_PATH.\'/pimg_cache.php\');if(!empty($ad_label[$class_id][\'ad_\''.$adid.'])&&($ad_label[$class_id][\'ad_\''.$adid.'][\'did\']==$_SESSION[\'did\']||$ad_label[$class_id][\'ad_\''.$adid.'][\'did\']==\'0\')&&$ad_label[$class_id][\'ad_\''.$adid.'][\'start\']<time()&&$ad_label[$class_id][\'ad_\''.$adid.'][\'end\']>time()){
				$AdArr[] = $ad_label[$class_id][\'ad_\''.$adid.'];
			}';
        }else{
            $OutputStr.='include(PLUS_PATH.\'/pimg_cache.php\');$add_arr = $ad_label['.$class_id.'];if(is_array($add_arr) && !empty($add_arr)){
				$i=0;$limit = '.$limit.';$length = '.$length.';
				foreach($add_arr as $key=>$value){
					if((stripos($value[\'did\'],$_SESSION[\'did\'])!==false ||$value[\'did\']==\'0\')&&$value[\'start\']<time()&&$value[\'end\']>time()){
						if($i>0 && $limit==$i){
							break;
						}
						if($length>0){
							$value[\'name\'] = mb_substr($value[\'name\'],0,$length);
						}
						if($paramer[\'type\']!=""){
							if($paramer[\'type\'] == $value[\'type\']){
								$AdArr[] = $value;
							}
						}else{
							$AdArr[] = $value;
						}
						$i++;
					}
				}
			}';
        }
        //自定义标签 END

        return SmartyOutputStr($this,$compiler,$_attr,'adlist','$AdArr',$OutputStr,'$AdArr');
    }
}
class Smarty_Internal_Compile_Adlistelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('adlist'));
        $this->openTag($compiler, 'adlistelse', array('adlistelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Adlistclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('adlist', 'adlistelse'));

        return "<?php } ?>";
    }
}
