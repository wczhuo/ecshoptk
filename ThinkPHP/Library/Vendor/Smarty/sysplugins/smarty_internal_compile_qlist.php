<?php
class Smarty_Internal_Compile_Qlist extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'ispage', 't_len', 'order', 'limit', 'cid', 'recom');
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
        
        $OutputStr='global $db,$db_config,$config;eval(\'$paramer='.str_replace('\'','\\\'',ArrayToString($_attr,true)).';\');'.$name.'=array();
		$ParamerArr = GetSmarty($paramer,$_GET);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];

		$where=1;
		//排序字段默认为更新时间
		if($paramer[order]){
			if($paramer[order]=="addtime"){
				$paramer[order]="add_time";
			}
			if($paramer[order]=="answernum"){
				$paramer[order]="answer_num";
			}
			$order = " ORDER BY `".$paramer[order]."`  desc";
		}else{
			$order = " ORDER BY `add_time` desc";
		}
		if($paramer[cid]){
			$where .=" and `cid`=\'".$paramer[cid]."\'";
		}
		if($paramer[uid]){
			$where .=" and `uid`=\'".$_COOKIE[uid]."\'";
		}
		if($paramer[recom]){//推荐 字段
			$where .=" and `is_recom`=\'1\'";
		}
		if($paramer[limit]){
			$limit=" limit ".$paramer[limit];
		}
		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"question",$where,$Purl,"","2",$_smarty_tpl);
		}
		'.$name.' = $db->select_all("question",$where.$order.$limit);

		foreach('.$name.' as $key=>$val){
			if(intval($paramer[t_len])>0){
				$len = intval($paramer[t_len]);
				$val[title] = mb_substr($val[title],0,$len,"GBK");
			}
			'.$name.'[$key][url] = Aurl(array("c"=>"content","id"=>$val[id]));
			$ListId[] =  $val[uid];
			$Qclass[]=$val[cid];//问题类别
		}
		//获得提问者uid，并根据uid 获得头像、昵称
		$uids=@implode(",",$ListId);
		$friend_info=$db->select_all("friend_info","`uid` in (".$uids.")","`uid`,`nickname`,`pic`,`description`");
		$atn=$db->select_all("atn","`uid`=\'".$_COOKIE[\'uid\']."\'","`sc_uid`");

		foreach('.$name.' as $r_k=>$r_v){
			foreach($friend_info as $f_v){
				if($r_v[\'uid\']==$f_v[\'uid\']){
					if($f_v[\'pic\']){
						'.$name.'[$r_k][\'pic\']=str_replace("..",$config["sy_weburl"],$f_v[\'pic\']);
					}else{
						'.$name.'[$r_k][\'pic\']=$config["sy_weburl"]."/".$config[\'sy_friend_icon\'];
					}
					'.$name.'[$r_k][\'uid\']=$f_v[\'uid\'];
					'.$name.'[$r_k][\'nickname\']=$f_v[\'nickname\'];
					'.$name.'[$r_k][\'description\']=$f_v[\'description\'];
				}
			}
			if($r_v[\'uid\']==$_COOKIE[\'uid\']){
				'.$name.'[$r_k][\'is_atn\']=\'2\';//表示这是本人，不显示关注按钮
			}
			foreach($atn as $a_v){
				if($a_v[\'sc_uid\']==$r_v[\'uid\']){
					'.$name.'[$r_k][\'is_atn\']=\'1\';//表示已经关注用户
				}
			}
		}';
        //自定义标签 END
        global $DiyTagOutputStr;
        $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'qlist',$name,'',$name);
    }
}
class Smarty_Internal_Compile_Qlistelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('qlist'));
        $this->openTag($compiler, 'qlistelse', array('qlistelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Qlistclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('qlist', 'qlistelse'));

        return "<?php } ?>";
    }
}
