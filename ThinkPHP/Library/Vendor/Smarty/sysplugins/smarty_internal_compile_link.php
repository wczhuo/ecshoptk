<?php
class Smarty_Internal_Compile_Link extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'type', 'tem_type');
    public $shorttag_order = array('from', 'item', 'key', 'name');
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        $from = $_attr['from'];
        $item = $_attr['item'];
        if (!strncmp("\$_smarty_tpl->tpl_vars[$item]", $from, strlen($item) + 24)) {
            $compiler->trigger_template_error("item variable {$item} may not be the same variable as at 'from'", $compiler->lex->taglineno);
        }
        
        $tem_type=$_attr['tem_type'];
        $type=$_attr['type'];
        $limit=$_attr['limit'];
        
        $OutputStr='global $config;        
		//跨域名使用范围
		$domain=\'\';
		if($_SESSION["cityid"]!="" || $_SESSION["hyclass"]!=""){
			include(PLUS_PATH."/domain_cache.php");
			$host_url=$_SERVER[\'HTTP_HOST\'];
			foreach($site_domain as $v){
				if($v[\'host\']==$host_url){
					$domain=$v[\'id\'];
				}
			}
		}';
		//站内使用范围   1=全站 2=首页使用 3=猎头页使用
        $OutputStr.='$tem_type = '.(is_numeric($tem_type)?$tem_type:1).';
        include PLUS_PATH."/link.cache.php";
		if(is_array($link)){$linkList=array();
			$i=0;
			foreach($link as $key=>$value)
			{
				if($value[\'domain\']!=\'0\' && stripos($value[\'domain\'],$domain)===false)
				{
					continue;
				}elseif(is_numeric(\''.$tem_type.'\') && $value[\'tem_type\']!=\''.$tem_type.'\' && $value[\'tem_type\']!=\'1\'){
					continue;

				}elseif((!is_numeric(\''.$tem_type.'\') || \''.$tem_type.'\'==\'1\') && $value[\'tem_type\']!=\'1\'){

					continue;
				}
				if(is_numeric(\''.$type.'\') && $value[\'link_type\']!=\''.$type.'\')
				{
					continue;
				}
				if(is_numeric(\''.$limit.'\') && intval(\''.$limit.'\')<=$i)
				{
					break;
				}
				$value[picurl] = $config[sy_weburl]."/".$value[pic];
				$linkList[] = $value;
				$i++;
			}
		}';

        return SmartyOutputStr($this,$compiler,$_attr,'link','$linkList',$OutputStr,'$linkList');
    }
}
class Smarty_Internal_Compile_Linkelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('link'));
        $this->openTag($compiler, 'linkelse', array('linkelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Linkclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('link', 'linkelse'));

        return "<?php } ?>";
    }
}
