<?php
class Smarty_Internal_Compile_Announcement extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 't_len', 'limit');
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
        $OutputStr=''.$name.'=array();$time=time();eval(\'$paramer='.str_replace('\'','\\\'',ArrayToString($_attr,true)).';\');
		global $db,$db_config,$config;
		$ParamerArr = GetSmarty($paramer,$_GET);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
		$where = 1;
		//分站
		if($_SESSION[\'did\']){
			$where.=" and (FIND_IN_SET(\'".$_SESSION[\'did\']."\',did) or FIND_IN_SET(\'0\',did))";
		}else{
			$where.=" and `did`=\'0\'";
		}
		//排序字段 默认按照xuanshang排序
		if($paramer[order]){
			$where.="  ORDER BY `".$paramer[order]."`";
		}else{
			$where.="  ORDER BY `datetime`";
		}
		//排序方式默认倒序
		if($paramer[sort]){
			$where.=" ".$paramer[sort];
		}else{
			$where.=" DESC";
		}
		if($paramer[limit]){
			$limit=" LIMIT ".$paramer[limit];
		}else{
			$limit=" LIMIT 20";
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"msg",$where,$Purl);
		}
		'.$name.'=$db->select_all("admin_announcement",$where.$limit);
		if(is_array('.$name.')){
			foreach('.$name.' as $key=>$value){
				//截取标题
				if($paramer[t_len]){
					'.$name.'[$key][title_n] = mb_substr($value[\'title\'],0,$paramer[t_len],"GBK");
				}
				'.$name.'[$key][time]=date("Y-m-d",$value[datetime]);
				'.$name.'[$key][url] = Url("index","announcement",array("id"=>$value[id]),"1");
			}
		}';
        //自定义标签 START
        global $DiyTagOutputStr;
        $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'announcement',$name,'',$name);
    }
}
class Smarty_Internal_Compile_Announcementelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('announcement'));
        $this->openTag($compiler, 'announcementelse', array('announcementelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Announcementclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('announcement', 'announcementelse'));

        return "<?php } ?>";
    }
}
