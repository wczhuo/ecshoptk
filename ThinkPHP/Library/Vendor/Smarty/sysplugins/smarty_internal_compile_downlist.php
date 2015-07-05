<?php
class Smarty_Internal_Compile_Downlist extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'limit');
    public $shorttag_order = array('from', 'item', 'key', 'name');
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        $from = $_attr['from'];
        $item = $_attr['item'];
        if (!strncmp("\$_smarty_tpl->tpl_vars[$item]", $from, strlen($item) + 24)) {
            $compiler->trigger_template_error("item variable {$item} may not be the same variable as at 'from'", $compiler->lex->taglineno);
        }
        
        //自定义标签 START
        //数据库操作       
        $OutputStr='global $db,$db_config,$config;
		$where="1";
		if($paramer[\'order\'])
		{
			$where.=" ORDER BY `".$paramer[\'order\']."`";
		}else{
			$where.=" ORDER BY `id`";
		}
		if($paramer[\'sort\'])
		{
			$where.=" ".$paramer[\'sort\'];
		}else{
			$where.=" DESC";
		}
		if($paramer[\'limit\'])
		{
			$limit=" LIMIT ".$paramer[\'limit\'];
		}else{
			$limit=" LIMIT 10";
		}
		$list=$db->select_all("down_resume",$where.$limit);
		if($list&&is_array($list)){
			$uids=$comids=array();
			foreach($list as $val){
				$uids[]=$val[\'uid\'];
				$comids[]=$val[\'comid\'];
			}
			$resume=$db->select_all("resume","`uid` in(".@implode(\',\',$uids).")","`uid`,`name`");
			$company=$db->select_all("company","`uid` in(".@implode(\',\',$comids).")","`uid`,`name`");
			foreach($list as $key=>$val){
				$time=time()-$val[\'downtime\'];
				if($time>86400 && $time<259300){
					$list[$key][\'time\'] = ceil($time/86400)."天前";
				}elseif($time>3600 && $time<86400){
					$list[$key][\'time\'] = ceil($time/3600)."小时前";
				}elseif($time>60 && $time<3600){
					$list[$key][\'time\'] = ceil($time/60)."分钟前";
				}elseif($time<60){
					$list[$key][\'time\'] = "刚刚";
				}else{
					$list[$key][\'time\'] = date("Y-m-d",$val[\'downtime\']);
				}
				foreach($resume as $v){
					if($v[\'uid\']==$val[\'uid\']){
						$list[$key][\'username\']=$v[\'name\'];
					}
				}
				foreach($company as $value){
					if($val[\'comid\']==$value[\'uid\']){
						$list[$key][\'comname\']=$value[\'name\'];
					}
				}
				if($paramer[\'user_len\']){
					$list[$key][\'username\']=mb_substr($list[$key][\'username\'],0,$paramer[\'user_len\'],"GBK");
				}
				if($paramer[\'com_len\']){
					$list[$key][\'comname\']=mb_substr($list[$key][\'comname\'],0,$paramer[\'com_len\'],"GBK");
				}
				$list[$key][\'curl\']=Curl(array("url"=>"id:".$val[comid]));
				$list[$key][\'url\']=Url("index","resume",array("id"=>$val[\'eid\']),"1");
			}
		}';//TODO:Url的生成函数应当统一在模版中生成，或者此类方法放在一个函数文件中统一引用（王成茁）
        //自定义标签 END

        return SmartyOutputStr($this,$compiler,$_attr,'downlist','$list',$OutputStr,'$list');
    }
}
class Smarty_Internal_Compile_Downlistelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('downlist'));
        $this->openTag($compiler, 'downlistelse', array('downlistelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Downlistclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('downlist', 'downlistelse'));

        return "<?php } ?>";
    }
}
