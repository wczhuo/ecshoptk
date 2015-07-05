<?php
class Smarty_Internal_Compile_Fast extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'ispage', 'limit', 'keyword','delid');
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
        //自定义标签START
        $OutputStr=''.$name.'=array();global $db,$db_config,$config;eval(\'$paramer='.str_replace('\'','\\\'',ArrayToString($_attr,true)).';\');
		//处理传入参数，并且构造分页参数
		$ParamerArr = GetSmarty($paramer,$_GET);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
		$where = "`status`=\'1\'  and `edate`>".time();
		//关键字
		if($paramer[keyword]){
			$where.=" AND `title` LIKE \'%".$paramer[keyword]."%\' or `companyname` LIKE \'%".$paramer[keyword]."%\'";
		}
		if($paramer[\'delid\']){
			$where.=" AND `id`<>\'".$paramer[\'delid\']."\'";
		}
		//排序字段默认为更新时间
		if($paramer[order]){
			$order = " ORDER BY `".str_replace("\'","",$paramer[order])."`";
		}else{
			$order = " ORDER BY ctime ";
		}
		//排序规则 默认为倒序
		if($paramer[sort]){
			$sort = $paramer[sort];
		}else{
			$sort = " DESC";
		}
		//查询条数
		if($paramer[limit]){
			$limit=" LIMIT ".$paramer[limit];
		}else{
			$limit=" LIMIT 20";
		}
		//自定义查询条件，默认取代上面任何参数直接使用该语句
		if($paramer[where]){
			$where = $paramer[where];
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"once_job",$where,$Purl,\'\',\'0\',$_smarty_tpl);
		}
		$where.=$order.$sort.$limit;
		'.$name.'=$db->select_all("once_job",$where);
		if(is_array('.$name.')){
			foreach('.$name.' as $key=>$value){
				$time=time()-$value[\'ctime\'];
				if($time>86400 && $time<604800){
					'.$name.'[$key][\'ctime\'] = ceil($time/86400)."天前";
				}elseif($time>3600 && $time<86400){
					'.$name.'[$key][\'ctime\'] = ceil($time/3600)."小时前";
				}elseif($time>60 && $time<3600){
					'.$name.'[$key][\'ctime\'] = ceil($time/60)."分钟前";
				}elseif($time<60){
					'.$name.'[$key][\'ctime\'] = "刚刚";
				}else{
					'.$name.'[$key][\'ctime\'] = date("Y-m-d",$value[\'ctime\']);
				}
			}
			if($paramer[keyword]!=""&&!empty('.$name.')){
				addkeywords(\'1\',$paramer[keyword]);
			}
		}';
        //自定义标签 END
        global $DiyTagOutputStr;
        $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'fast',$name,'',$name);
    }
}
class Smarty_Internal_Compile_Fastelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('fast'));
        $this->openTag($compiler, 'fastelse', array('fastelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Fastclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('fast', 'fastelse'));

        return "<?php } ?>";
    }
}
