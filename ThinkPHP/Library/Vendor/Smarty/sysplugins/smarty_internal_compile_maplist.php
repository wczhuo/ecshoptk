<?php
class Smarty_Internal_Compile_Maplist extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'ispage', 'notpl', 'isjob', 'keyword', 'hy', 'pr', 'lastupdate', 'job1', 'job1_son', 'job_post', 'provinceid', 'cityid', 'three_cityid', 'limit', 'r', 'x', 'y', 'z'); 
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
		//是否属于分站下
		if($config[sy_web_site]=="1"){
			if($_SESSION[cityid]>0 && $_SESSION[cityid]!=""){
				$paramer[cityid]=$_SESSION[cityid];
			}
			if($_SESSION[three_cityid]>0 && $_SESSION[three_cityid]!=""){
				$paramer[three_cityid] = $_SESSION[three_cityid];
			}
			if($_SESSION[hyclass]>0 && $_SESSION[hyclass]!=""){
				$paramer[hy]=$_SESSION[hyclass];
			}
		}
		$time = time();
		//处理传入参数，并且构造分页参数
		$ParamerArr = GetSmarty($paramer,$_GET);
		$paramer = $ParamerArr[arr];
		$Purl =  $ParamerArr[purl];
		$where=1;
		$xy=getAround($paramer[x],$paramer[y],$paramer[r]);
		if($xy[0]){
			$where.=" AND `x`>=\'".$xy[0]."\' AND `x`<=\'".$xy[1]."\' AND `y`>=\'".$xy[3]."\' AND `y`<=\'".$xy[2]."\'";
		}
		//关键字
		if($paramer[keyword]){
			$where.=" AND `name` LIKE \'%".$paramer[keyword]."%\'";
		}
		//公司行业
		if($paramer[hy]){
			$where .= " AND `hy` = \'".$paramer[hy]."\'";
		}
		//公司体制
		if($paramer[pr]){
			$where .= " AND `pr` = \'".$paramer[pr]."\'";
		}
		//公司规模
		if($paramer[mun]){
			$where .= " AND `mun` = \'".$paramer[mun]."\'";
		}
		//公司地点
		if($paramer[provinceid]){
			$where .= " AND `provinceid` = \'".$paramer[provinceid]."\'";
		}
		//所在地 市区
		if($paramer[cityid]){
			$where .= " AND (`cityid` = \'".$paramer[cityid]."\' or `provinceid` = \'".$paramer[cityid]."\')";
		}
		//所在地 县
		if($paramer[three_cityid]){
			$where .= " AND `three_cityid` = \'".$paramer[three_cityid]."\'";
		}
		//联系人不为空
		if($paramer[linkman]){
			$where .= " AND `linkman`<>\'\'";
		}
		//联系人电话不为空
		if($paramer[linktel]){
			$where .= " AND `linktel`<>\'\'";
		}
		//联系人邮箱不为空
		if($paramer[linkmail]){
			$where .= " AND `linkmail`<>\'\'";
		}
		//是否有企业LOGO
		if($paramer[logo]){
			$where .= " AND `logo`<>\'\'";
		}
		//更新时间区间
		if($paramer[\'lastupdate\']){
			$lastupdate = $time-$paramer[\'lastupdate\']*3600;
			$where.=" AND `lastupdate`>\'".$lastupdate."\'";
		}
		//是否被锁定
		if($paramer[r_status]){
			$where .= " AND `r_status`=\'".$paramer[\'r_status\']."\'";
		}else{
			$where .= " AND `r_status`<>\'2\'";
		}
		//是否已经验证
		if($paramer[\'cert\']){
			$where .= " AND `yyzz_status`=\'1\'";
		}
		if($paramer[jobtime]){
			$where.=" AND `jobtime`<>\'\'";
		}
		///-------职位
		$jobwhere=1;
		if($paramer[job1]){
			$jobwhere.=" AND `job1`=\'$paramer[job1]\'";
		}
		if($paramer[job1_son]){
			$jobwhere.=" AND `job1_son`=\'$paramer[job1_son]\'";
		}
		if($paramer[job_post]){
			$jobwhere.=" AND `job_post`=\'$paramer[job_post]\'";
		}
		$joball=$db->select_all("company_job",$jobwhere,"`uid`");
		if(is_array($joball)){
			foreach($joball as $v){
				$uid[]=$v[uid];
			}
			$uid=@implode(",",$uid);
			$where.=" and `uid` in ($uid)";
		}
		//排序字段默认为更新时间
		if($paramer[order]){
			$order = " ORDER BY `".$paramer[order]."`  ";
		}else{
			$order = " ORDER BY `jobtime` ";
		}
		//排序规则 默认为倒序
		if($paramer[sort]){
			$sort = $paramer[sort];
		}else{
			$sort = " DESC";
		}
		//查询条数
		if($paramer[limit]){
			$limit.=" limit ".$paramer[limit];
		}
		$where.=$order.$sort;
		//自定义查询条件，默认取代上面任何参数直接使用该语句
		if($paramer[where]){
			$where = $paramer[where];
		}
		//处理类别字段
		$cache_array = $db->cacheget();

		if($paramer[ispage]){
			$limit = PageNav($paramer,$_GET,"company","`x`<>\'\' and ".$where,$Purl,"","0",$_smarty_tpl);
		}
		$Query = $db->query("SELECT * FROM $db_config[def]company where x<>\'\' and ".$where.$limit);
		while($rs = $db->fetch_array($Query)){
			'.$name.'[] = $db->array_action($rs,$cache_array);
			$ListId[] =  $rs[uid];
		}
        //$comnum = $db->select_num("company","x!=\'\' and ".$where);

		//是否需要查询对应职位
		if($paramer[isjob]){
			//查询职位
			$JobId = @implode(",",$ListId);
			$JobList=$db->select_only("(select * from `".$db_config[def]."company_job` order by `lastupdate` desc) `temp`","`uid` IN ($JobId) and `edate`>\'".mktime()."\' and r_status<>\'2\' and status<>\'1\' and state=1 order by `lastupdate` desc");
            if(is_array($ListId) && is_array($JobList)){
				foreach('.$name.' as $key=>$value){
					'.$name.'[$key][jobnum] = 0;
					foreach($JobList as $k=>$v){
						if($value[uid]==$v[uid]){
							'.$name.'[$key][newsjob] = $v[name];
							'.$name.'[$key][newsjob_status] = $v[status];
							'.$name.'[$key][r_status] = $v[r_status];
							'.$name.'[$key][job_url] = Url("index","com",array("c"=>"comapply","id"=>$v[id]),"1");
							$jobv = $db->array_action($v,$cache_array);
							$jobv[\'name\'] = '.$name.'[$key][newsjob];
							$jobv[job_url] = Url("index","com",array("c"=>"comapply","id"=>$v[id]),"1");
							'.$name.'[$key][joblist][] = $jobv;
							'.$name.'[$key][jobnum] = '.$name.'[$key][jobnum]+1;
						}
					}
				}
			}
		}
		if(is_array('.$name.')){
			$num=0;
			foreach('.$name.' as $key=>$value){
				'.$name.'[$key][com_url] = Curl(array("url"=>"id:".$value[uid]));
				'.$name.'[$key][joball_url] = Curl(array("url"=>"id:".$value[uid].",tp:post"));
				'.$name.'[$key][\'orderid\']=$num;
				if(!$value[x] && !$value[y]){
					$address=$value[job_city_one].$value[job_city_two].$value[address];
					$xydata=@file_get_contents("http://api.map.baidu.com/geocoder?address=".$address."&output=json&key=37492c0ee6f924cb5e934fa08c6b1676");
					$name=json_decode($xydata);
					'.$name.'[$key][x]=$name->result->location->lng;
					'.$name.'[$key][y]=$name->result->location->lat;
				}
				$num++;
			}
			if($paramer[keyword]!=""&&!empty('.$name.')){
				addkeywords(\'4\',$paramer[keyword]);
			}
		}';
        //自定义标签 END
        global $DiyTagOutputStr;
        $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'maplist',$name,'',$name);
    }
}
class Smarty_Internal_Compile_Maplistelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('maplist'));
        $this->openTag($compiler, 'maplistelse', array('maplistelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Maplistclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('maplist', 'maplistelse'));

        return "<?php } ?>";
    }
}
