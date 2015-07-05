<?php
class Smarty_Internal_Compile_Mlist extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'limit', 'order');
    public $shorttag_order = array('from', 'item', 'key', 'name');
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        $from = $_attr['from'];
        $item = $_attr['item'];
        $name = $_attr['name'];
        $name=str_replace('\'','',$name);
        $name=$name?$name:'list';$name='$'.$name;
        if (!strncmp("\$_smarty_tpl->tpl_vars[$item]", $from, strlen($item) + 24)) {
            $compiler->trigger_template_error("item variable {$item} may not be the same variable as at 'from'", $compiler->lex->taglineno);
        }
        
        //自定义标签 START
        $OutputStr='global $config;eval(\'$paramer='.str_replace('\'','\\\'',ArrayToString($_attr,true)).';\');$list=array();
		global $db,$db_config;
		$path = dirname(dirname(dirname(__FILE__)));
		$ParamerArr = GetSmarty($paramer,$_GET);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
		$where=\'1\';
		//添加用户类别条件
		if($paramer[usertype])
		{
			$where .= " and `usertype`=\'".$paramer[usertype]."\'";
		}
		//添加状态条件
		if($paramer[status])
		{
			$where .= " and `status`=\'".$paramer[status]."\'";
		}
		if($paramer[ispage])
		{
			$limit = PageNav($paramer,$_GET,"q_class",$where,$Purl,\'\',\'2\');
		}
		if($paramer[order])
		{
			$order = " ORDER BY `".$paramer[order]."`  desc";
		}else{
			$order = " ORDER BY `uid` desc";
		}
		if($paramer[limit])
		{
			$limit=" limit ".$paramer[limit];
		}
		'.$name.' = $db->select_all("member",$where.$order.$limit);
		if(is_array('.$name.'))
		{
			foreach('.$name.' as $m_k=>$m_v)
			{
				'.$name.'[$m_k][\'url\']=Furl(array("c"=>"profile","id"=>$m_v[\'uid\']));

			}
		}';
        //自定义标签 END
        global $DiyTagOutputStr;
        $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'mlist',$name,'',$name);
    }
}
class Smarty_Internal_Compile_Mlistelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('mlist'));
        $this->openTag($compiler, 'mlistelse', array('mlistelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Mlistclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('mlist', 'mlistelse'));

        return "<?php } ?>";
    }
}
