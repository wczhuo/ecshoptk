<?php
class Smarty_Internal_Compile_Hotjob extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'limit');
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
        $uptime=$_attr['uptime'];
        $order=$_attr['order'];
        $sort=$_attr['sort'];
        $limit=$_attr['limit'];
        $where=$_attr['where'];
        $ispage=$_attr['ispage'];
        
        $OutputStr='global $db,$db_config,$config;
		$time = time();
		$where = "`time_start`<$time AND `time_end`>$time";';
		//更新时间区间
		if($uptime){
			$OutputStr.='$uptime = $time-'.$uptime.'*3600;
			$where.=" AND `lastupdate`>\'".$uptime."\'";';
		}
        //排序字段默认为更新时间
		$OutputStr.='$order = " ORDER BY `'.($order?$order:'sort').'` ";';
		//排序规则 默认为顺序
		$OutputStr.='$sort = \''.($sort?$sort:'ASC').'\';';
		//查询条数
		if($limit){
			$OutputStr.='$limit=" LIMIT '.$limit.'";';
		}
		$OutputStr.='$where.=$order.$sort;';
		//自定义查询条件，默认取代上面任何参数直接使用该语句
		if($where){
			$OutputStr.='$where = \''.$where.'\';';
		}
		//分页
		if($ispage){
			$OutputStr.='$limit = PageNav($paramer,$_GET,"hotjob",$where,$Purl,\'0\',$_smarty_tpl);';
		}
		$OutputStr.='
        $Query = $db->query("SELECT * FROM $db_config[def]hotjob where ".$where.$limit);
		while($rs = $db->fetch_array($Query)){
			'.$name.'[] = $rs;
			$ListId[] =  $rs[uid];
		}
		//是否属于分站下
		$jobwhere=1;
		if($config[sy_web_site]=="1"){
			if($_SESSION[cityid]>0 && $_SESSION[cityid]!=""){
				$jobwhere.=" and `cityid`=\'$_SESSION[cityid]\'";
			}
			if($_SESSION[three_cityid]>0 && $_SESSION[three_cityid]!=""){
				$jobwhere.=" and `three_cityid`=\'$_SESSION[three_cityid]\'";
			}
			if($_SESSION[hyclass]>0 && $_SESSION[hyclass]!=""){
				$jobwhere.=" and `hy`=\'".$_SESSION[hyclass]."\'";
			}
		}
		//是否需要查询对应职位
		$JobId = @implode(",",$ListId);
		$JobList=$db->select_all("company_job","`uid` IN ($JobId) and `edate`>\'".mktime()."\' and state=1 and r_status<>\'2\' and status<>\'1\' and $jobwhere");
		$statis=$db->select_all("company_statis","`uid` IN ($JobId)","`uid`,`comtpl`");
		if(is_array($ListId)){
			//处理类别字段
			$cache_array = $db->cacheget();
			foreach('.$name.' as $key=>$value){
				$i=0;
				if(is_array($JobList)){
					'.$name.'[$key]["job"].="<div class=\"area_left\"> ";
					foreach($JobList as $k=>$v){
						if($value[uid]==$v[uid] && $i<5){
							$job_url = url("index","com",array("c"=>"comapply","id"=>"$v[id]"),"1");
							$v[name] = mb_substr($v[name],0,10,"GBK");
							'.$name.'[$key]["job"].="<a href=\'".$job_url."\'>".$v[name]."</a>";
							$i++;
						}
					}
					foreach($statis as $v){
						if($value[\'uid\']==$v[\'uid\']){
							if($v[\'comtpl\'] && $v[\'comtpl\']!="default"){
								$jobs_url = Curl(array("url"=>"id:".$value[uid]))."#job";
							}else{
								$jobs_url = Curl(array("url"=>"tp:post,id:".$value[uid]));
							}
						}
					}
					$com_url = Curl(array("url"=>"id:".$value[uid]));
					$beizhu=mb_substr($value[\'beizhu\'],0,50,"GBK")."...";
					'.$name.'[$key]["job"].="</div><div class=\"area_right\"><a href=\'".$com_url."\'>".$value["username"]."</a>".$beizhu."</div><div class=\"area_left_bot\"><a href=\'".$jobs_url."\'>全部职位</a></div><div class=\'area_right_bot\'><a href=\'".$com_url."\'>公司详情</a></div>";
					'.$name.'[$key]["url"]=$com_url;
				}
			}
		}';
        //自定义标签 END
        global $DiyTagOutputStr;
        $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'hotjob',$name,'',$name);
    }
}
class Smarty_Internal_Compile_Hotjobelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('hotjob'));
        $this->openTag($compiler, 'hotjobelse', array('hotjobelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Hotjobclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('hotjob', 'hotjobelse'));

        return "<?php } ?>";
    }
}
