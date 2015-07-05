<?php
class Smarty_Internal_Compile_Tiny extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'add_time', 'ispage', 'limit', 'keyword','delid');
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
        $OutputStr='global $db,$db_config,$config;eval(\'$paramer='.str_replace('\'','\\\'',ArrayToString($_attr,true)).';\');'.$name.'=array();
		include PLUS_PATH."/user.cache.php";
		//处理传入参数，并且构造分页参数
		$ParamerArr = GetSmarty($paramer,$_GET);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
		$where = "status=\'1\' ";
		//关键字
		if($paramer[keyword]){
			$where.=" AND `username` LIKE \'%".$paramer[keyword]."%\' or `job` LIKE \'%".$paramer[keyword]."%\'";
		}
		if($paramer[\'add_time\']>0){
			$time=time()-$paramer[\'add_time\']*86400;
			$where.=" and `time`>".$time;
		}
		if($paramer[\'delid\']){
			$where.=" AND `id`<>\'".$paramer[\'delid\']."\'";
		}
		//排序字段默认为更新时间
		if($paramer[\'order\']){
			$order = " ORDER BY `".str_replace("\'","",$paramer[order])."`";
		}else{
			$order = " ORDER BY time ";
		}
		//排序规则 默认为倒序
		if($paramer[\'sort\']){
			$sort = $paramer[\'sort\'];
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
			$limit = PageNav($paramer,$_GET,"resume_tiny",$where,$Purl,\'\',\'0\',$_smarty_tpl);
		}
		$where.=$order.$sort.$limit;
		'.$name.'=$db->select_all("resume_tiny",$where);
		if(is_array('.$name.')){
			foreach('.$name.' as $key=>$value){
				$time=time()-$value[\'time\'];
				if($time>86400 && $time<604800){
					'.$name.'[$key][\'time\'] = ceil($time/86400)."天前";
				}elseif($time>3600 && $time<86400){
					'.$name.'[$key][\'time\'] = ceil($time/3600)."小时前";
				}elseif($time>60 && $time<3600){
					'.$name.'[$key][\'time\'] = ceil($time/60)."分钟前";
				}elseif($time<60){
					'.$name.'[$key][\'time\'] = "刚刚";
				}else{
					'.$name.'[$key][\'time\'] = date("Y-m-d",$value[\'time\']);
				}
				'.$name.'[$key][\'sex_name\'] =$userclass_name[$value[\'sex\']];
				'.$name.'[$key][\'exp_name\'] =$userclass_name[$value[\'exp\']];
			}
		}
		if(is_array('.$name.')){
			if($paramer[keyword]!=""&&!empty('.$name.')){
				addkeywords(\'1\',$paramer[keyword]);
			}
		}';
        //自定义标签 END
        global $DiyTagOutputStr;
        $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'tiny',$name,'',$name);
    }
}
class Smarty_Internal_Compile_Tinyelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('tiny'));
        $this->openTag($compiler, 'tinyelse', array('tinyelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Tinyclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('tiny', 'tinyelse'));

        return "<?php } ?>";
    }
}
