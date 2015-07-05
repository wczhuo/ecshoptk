<?php
class Smarty_Internal_Compile_Comlist extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'ispage', 'isjob', 'firm', 'isnews', 'isshow', 'hy', 'pr', 'mun', 'provinceid', 'cityid', 'three_cityid', 'keyword', 'order', 'limit', 'ltjob', 'logo', 'comlen', 'namelen', 'firmpic', 'ismsg', 'rec');
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
        
        //TODO:$this->company_rating,此变量的作用是什么？应该加在什么地方？
        //自定义标签 START
        $OutputStr='global $db,$db_config,$config;eval(\'$paramer='.str_replace('\'','\\\'',ArrayToString($_attr,true)).';\');'.$name.'=array();
		//是否属于分站下
		if($config[\'sy_web_site\']=="1"){
			if($_SESSION[\'cityid\']>0 && $_SESSION[\'cityid\']!=""){
				$paramer[\'cityid\']=$_SESSION[\'cityid\'];
			}
			if($_SESSION[\'hyclass\']>0 && $_SESSION[\'hyclass\']!=""){
				$paramer[\'hy\']=$_SESSION[\'hyclass\'];
			}
		}
		$time = time();
		//处理传入参数，并且构造分页参数
		$ParamerArr = GetSmarty($paramer,$_GET);
		$paramer = $ParamerArr[\'arr\'];
		$Purl =  $ParamerArr[\'purl\'];
		$where=1;
		/*if(!is_array($this->company_rating)){
			$comrat = $db->select_all($db_config[\'def\']."company_rating");
			$this->company_rating=$comrat;
		}else{
			$comrat = $this->company_rating;
		}*/
		//关键字
		if($paramer[\'keyword\']){
			$where.=" AND `name` LIKE \'%".$paramer[\'keyword\']."%\'";
		}
		//公司行业
		if($paramer[\'hy\']){
			$where .= " AND `hy` = \'".$paramer[\'hy\']."\'";
		}
		//公司体制
		if($paramer[\'pr\']){
			$where .= " AND `pr` = \'".$paramer[\'pr\']."\'";
		}
		//公司规模
		if($paramer[\'mun\']){
			$where .= " AND `mun` = \'".$paramer[\'mun\']."\'";
		}
		//公司地点
		if($paramer[\'provinceid\']){
			$where .= " AND `provinceid` = \'".$paramer[\'provinceid\']."\'";
		}
		//所在地 市区
		if($paramer[\'cityid\']){
			$where .= " AND `cityid` = \'".$paramer[\'cityid\']."\'";
		}
		//联系人不为空
		if($paramer[\'linkman\']){
			$where .= " AND `linkman`<>\'\'";
		}
		//联系人电话不为空
		if($paramer[\'linktel\']){
			$where .= " AND `linktel`<>\'\'";
		}
		//联系人邮箱不为空
		if($paramer[\'linkmail\']){
			$where .= " AND `linkmail`<>\'\'";
		}
		//是否有企业LOGO
		if($paramer[\'logo\']){
			$where .= " AND `logo`<>\'\'";
		}
		//是否被锁定
		if($paramer[\'r_status\']){
			$where .= " AND `r_status`=\'".$paramer[\'r_status\']."\'";
		}else{
			$where .= " AND `r_status`<>\'2\'";
		}
		//是否已经验证
		if($paramer[\'cert\']){
			$where .= " AND `yyzz_status`=\'1\'";
		}
		//更新时间区间
		if($paramer[\'uptime\']){
			$uptime = $time-$paramer[\'uptime\']*3600;
			$where.=" AND `lastupdate`>\'".$uptime."\'";
		}
		if($paramer[\'jobtime\']){
			$where.=" AND `jobtime`<>\'\'";
		}
		//推荐，猎头页面展示
		if($paramer[\'rec\']){
			$where.=" AND `rec`=\'1\'";
		}
        //排序字段默认为更新时间
		if($paramer[\'order\']){
			if($paramer[\'order\']=="lastＵpdate"){
				$paramer[\'order\']="lastupdate";
			}
			$order = " ORDER BY `".$paramer[\'order\']."`  ";
		}else{
			$order = " ORDER BY `jobtime` ";
		}
		//排序规则 默认为倒序
		if($paramer[\'sort\']){
			$sort = $paramer[\'sort\'];
		}else{
			$sort = " DESC";
		}
		//查询条数
		if($paramer[\'limit\']){
			$limit.=" limit ".$paramer[\'limit\'];
		}
		$where.=$order.$sort;
		//自定义查询条件，默认取代上面任何参数直接使用该语句
		if($paramer[\'where\']){
			$where = $paramer[\'where\'];
		}
		//处理类别字段
		$cache_array = $db->cacheget();
		if($paramer[\'ispage\']){
			if($paramer[\'rec\']==1){
				$limit = PageNav($paramer,$_GET,"company",$where,$Purl,"","1",$_smarty_tpl);
			}else{
				$limit = PageNav($paramer,$_GET,"company",$where,$Purl,"","0",$_smarty_tpl);
			}
            $_smarty_tpl->tpl_vars[\'firmurl\']=new Smarty_Variable;
			$_smarty_tpl->tpl_vars[\'firmurl\']->value = $ParamerArr[\'firmurl\'];
		}
		$Query = $db->query("SELECT * FROM $db_config[def]company where ".$where.$limit);
		while($rs = $db->fetch_array($Query)){
			'.$name.'[] = $db->array_action($rs,$cache_array);
			$ListId[] = $rs[\'uid\'];
		}
		//对应留言
		if($paramer[\'ismsg\']){
			$Msgid = @implode(",",$ListId);
			$msglist = $db->select_alls("company_msg","resume","a.`cuid` in ($Msgid) and a.`uid`=b.`uid` order by a.`id` desc","a.cuid,a.content,b.name,b.photo,b.def_job");
			if(is_array($ListId) && is_array($msglist)){
				foreach('.$name.' as $key=>$value){
					foreach($msglist as $k=>$v){
						if($value[\'uid\']==$v[\'cuid\']){
							'.$name.'[$key][\'msg\'][$k][\'content\'] = $v[\'content\'];
							'.$name.'[$key][\'msg\'][$k][\'name\'] = $v[\'name\'];
							'.$name.'[$key][\'msg\'][$k][\'photo\'] = $v[\'photo\'];
							'.$name.'[$key][\'msg\'][$k][\'eid\'] = $v[\'def_job\'];
						}
					}
				}
			}
		}
		//是否需要查询对应职位
		if($paramer[\'isjob\']){
			//查询职位
			$JobId = @implode(",",$ListId);
			$JobList=$db->select_only("(select * from `".$db_config[def]."company_job` order by `lastupdate` desc) `temp`","`uid` IN ($JobId) and `edate`>\'".mktime()."\' and r_status<>\'2\' and status<>\'1\' and state=1  order by `lastupdate` desc");
			if(is_array($ListId) && is_array($JobList)){
				foreach('.$name.' as $key=>$value){
					'.$name.'[$key][\'jobnum\'] = 0;
					foreach($JobList as $k=>$v){
						if($value[\'uid\']==$v[\'uid\']){
							$id = $v[\'id\'];
							'.$name.'[$key][\'newsjob\'] = $v[\'name\'];
							'.$name.'[$key][\'newsjob_status\'] = $v[\'status\'];
							'.$name.'[$key][\'r_status\'] = $v[\'r_status\'];

							'.$name.'[$key][\'job_url\'] = Url("index","com",array("c"=>"comapply","id"=>$v[\'id\']),"1");
							$v = $db->array_action($value,$cache_array);
							$v[\'id\']= $id;
							$v[\'name\'] = '.$name.'[$key][\'newsjob\'];
							'.$name.'[$key][\'joblist\'][] = $v;
							'.$name.'[$key][\'jobnum\'] = '.$name.'[$key][\'jobnum\']+1;
						}
					}
					foreach($comrat as $k=>$v){
						if($value[\'rating\']==$v[\'id\']){
							'.$name.'[$key][\'color\'] = $v[\'com_color\'];
							'.$name.'[$key][\'ratlogo\'] = $v[\'com_pic\'];
						}
					}
				}
			}
		}
		//是否需要查询对应资讯
		if($paramer[\'isnews\']){
			//查询资讯
			$JobId = @implode(",",$ListId);
			$NewsList=$db->select_all("company_news","`uid` IN ($JobId) and status=1  order by `id` desc");
			if(is_array($ListId) && is_array($NewsList)){
				foreach('.$name.' as $key=>$value){
					'.$name.'[$key][\'newsnum\'] = 0;
					foreach($NewsList as $k=>$v){
						if($value[\'uid\']==$v[\'uid\']){
							'.$name.'[$key][\'newslist\'][] = $v;
							'.$name.'[$key][\'newsnum\'] = '.$name.'[$key][\'newsnum\']+1;
						}
					}
				}
			}
		}
		//是否需要查询对应环境展示
		if($paramer[\'isshow\']){
			//查询环境展示
			$JobId = @implode(",",$ListId);
			$ShowList=$db->select_all("company_show","`uid` IN ($JobId) order by `id` desc");
			if(is_array($ListId) && is_array($ShowList)){
				foreach('.$name.' as $key=>$value){
					'.$name.'[$key][\'shownum\'] = 0;
					foreach($ShowList as $k=>$v){
						if($value[\'uid\']==$v[\'uid\']){
							'.$name.'[$key][\'showlist\'][] = $v;
							'.$name.'[$key][\'shownum\'] = '.$name.'[$key][\'shownum\']+1;
						}
					}
				}
			}
		}
		if($paramer[\'ltjob\']){//高级职位		
			//查询职位
			$JobId = @implode(",",$ListId);
			$JobList=$db->select_all("lt_job","`uid` IN ($JobId) and `edate`>\'".mktime()."\' and status=1  order by `id` desc");
			if(is_array($ListId) && is_array($JobList)){
				foreach('.$name.' as $key=>$value){
					$jobname="";
					foreach($JobList as $k=>$v){
						if($value[\'uid\']==$v[\'uid\']){
							$url = Lurl(array("c"=>"jobcomshow","id"=>$v[\'id\']));
							$jobname[] = "<a href=\'".$url."\'>".$v[\'job_name\']."</a>";
						}
					}
					'.$name.'[$key][\'ltjob\'] = @implode(",",$jobname);
				}
			}
		}
		//企业黄页 是否关注  201305_gl
		if($paramer[\'firm\']){
			$atnlist = $db->select_all("atn","`uid`=\'$_COOKIE[uid]\'");
			if(is_array($atnlist) && is_array('.$name.')){
				foreach('.$name.' as $key=>$value){
					if(!empty($atnlist)){
						foreach($atnlist as $v){
							if($value[\'uid\'] == $v[\'sc_uid\']){
								'.$name.'[$key][\'atn\'] = "取消关注";
								break;
							}else{
								'.$name.'[$key][\'atn\'] = "关注";
							}
						}
					}else{
						'.$name.'[$key][\'atn\'] = "关注";
					}
				}
			}
		}
		if(is_array('.$name.')){
			foreach('.$name.' as $key=>$value){
				'.$name.'[$key][\'com_url\'] = Curl(array("id"=>$value[\'uid\']));
				'.$name.'[$key][\'joball_url\'] = Curl(array("id"=>$value[\'uid\'],"tp"=>"post"));
				if($value[\'logo\']!=""){
					'.$name.'[$key][\'logo\'] = str_replace("./",$config[\'sy_weburl\']."/",$value[\'logo\']);
				}else{
					'.$name.'[$key][\'logo\'] = $config[\'sy_weburl\']."/".$config[\'sy_unit_icon\'];
				}
			}
			if($paramer[\'keyword\']!=""&&!empty('.$name.')){
				addkeywords(\'4\',$paramer[\'keyword\']);
			}
		}';
        //自定义标签 END
        global $DiyTagOutputStr;
        $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'comlist',$name,'',$name);
    }
}
class Smarty_Internal_Compile_Comlistelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('comlist'));
        $this->openTag($compiler, 'comlistelse', array('comlistelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Comlistclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('comlist', 'comlistelse'));

        return "<?php } ?>";
    }
}
