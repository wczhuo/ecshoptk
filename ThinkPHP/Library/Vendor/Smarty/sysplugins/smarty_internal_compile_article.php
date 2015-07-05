<?php
class Smarty_Internal_Compile_Article extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 't_len', 'limit', 'rec', 'limit', 'pic', 'd_len', 'type', 'urlstatic','print','order','ispage','nid');
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
        //数据库操作 
        $OutputStr='global $db,$db_config,$config;include PLUS_PATH.\'/group.cache.php\';'.$name.'=array();eval(\'$paramer='.str_replace('\'','\\\'',ArrayToString($_attr,true)).';\');
		$ParamerArr = GetSmarty($paramer,$_GET);
		$paramer = $ParamerArr[\'arr\'];
		$Purl =  $ParamerArr[\'purl\'];$where=1;
		if($_SESSION[\'did\']){
			$where.=" and (FIND_IN_SET(\'".$_SESSION[\'did\']."\',did) or FIND_IN_SET(\'0\',did))";
		}else{
			$where.=" and `did`=\'0\'";
		}
		include PLUS_PATH."/group.cache.php";
		if(is_array($paramer)){
			if($paramer[\'nid\']!=""){
				$where .=" AND `nid` in ($paramer[nid])";
				$nids = @explode(\',\',$paramer[\'nid\']);$paramer[\'nid\']=$paramer[\'nid\'];
			}else if($paramer[\'rec\']!=""){
				$nids=array();if(is_array($group_rec)){
					foreach($group_rec as $key=>$value){
						if($key<=2){
							$nids[]=$value;
						}
					}
					$paramer[nid]=@implode(\',\',$nids);
				}
			}            
			if($paramer[\'nid\']){
				$nid_s = @explode(\',\',$paramer[nid]);				
				foreach($nid_s as $v){
					if($group_type[$v]){
						$paramer[nid] = $paramer[nid].",".@implode(\',\',$group_type[$v]);
					}
				}
			}			
			if($paramer[\'type\']){
				$type = str_replace("\"","",$paramer[type]);
				$type_arr =	@explode(",",$type);
				if(is_array($type_arr) && !empty($type_arr))
				{
					foreach($type_arr as $key=>$value)
					{
						$where .=" AND FIND_IN_SET(\'".$value."\',`describe`)";
						if(count($nids)>0)
						{
							$picwhere .=" AND FIND_IN_SET(\'".$value."\',`describe`)";
						}
					}
				}
			}
			//拼接补充SQL条件
			if($paramer[\'pic\']!=""){
				$where .=" AND `newsphoto`<>\'\'";
			}
			//拼接字段排序
			if($paramer[\'order\']!=""){
				$order = str_replace("\'","",$paramer[\'order\']);
				$where .=" ORDER BY $order";
			}else{
				$where .=" ORDER BY `datetime`";
			}
			//排序方式默认倒序
			if($paramer[\'sort\']){
				$where.=" ".$paramer[sort];
			}else{
				$where.=" DESC";
			}
			//拼接查询条数
			if(intval($paramer[\'limit\'])>0){
				$limit = intval($paramer[\'limit\']);
				$limit = " limit ".$limit;
			}
			if($paramer[\'ispage\']){
				$limit = PageNav($paramer,$_GET,"news_base",$where,$Purl,"","5",$_smarty_tpl);
			}
		}
		//多类别新闻查找
		if(!intval($paramer[\'ispage\']) && count($nids)>0){
			$where = " and nid IN ($paramer[nid])";
			//查询带图新闻
			if($paramer[\'pic\']){
				if(!$paramer[\'piclimit\']){
					$piclimit = 1;
				}else{
					$piclimit = $paramer[\'piclimit\'];
				}
				$db->query("set @f=0,@n=0");
				$query = $db->query("select * from (select id,title,color,datetime,description,newsphoto,@n:=if(@f=nid,@n:=@n+1,1) as aid,@f:=nid as nid from $db_config[def]news_base  WHERE `nid` IN ($paramer[nid]) AND `newsphoto` <>\'\'  order by nid asc,datetime desc) a where aid <=".$piclimit);
				while($rs = $db->fetch_array($query)){
					//处理标题长度
					if(intval($paramer[t_len])>0){
						$len = intval($paramer[t_len]);
						if($rs[color]){
							$rs[title] = "<font color=\'".$rs[color]."\'>".mb_substr($rs[title],0,$len,"GBK")."</font>";
						}else{
							$rs[title] = mb_substr($rs[title],0,$len,"GBK");
						}
					}
					//处理描述内容长度
					if(intval($paramer[d_len])>0)
					{
						$len = intval($paramer[d_len]);
						$rs[description] = mb_substr($rs[description],0,$len,"GBK");
					}
					$rs[\'name\'] = $group_name[$rs[\'nid\']];

					//构建资讯静态链接
					if($config[sy_news_rewrite]=="2"){
						$rs["url"]=$config[\'sy_weburl\']."/news/".date("Ymd",$rs["datetime"])."/".$rs[id].".html";
					}else{
						$rs["url"] = Url("index","news",array("c"=>"show","id"=>$rs[id]),"1");
					}
					$rs[time]=date("Y-m-d",$rs[datetime]);
					$rs[\'datetime\']=date("m-d",$rs[datetime]);
					'.$name.'[$rs[\'nid\']][\'pic\'][] = $rs;
				}
			}
            $db->query("set @f=0,@n=0");
            $query = $db->query("select * from (select id,title,datetime,color,description,newsphoto,@n:=if(@f=nid,@n:=@n+1,1) as aid,@f:=nid as nid from $db_config[def]news_base  WHERE `nid` IN ($paramer[nid]) order by nid asc,datetime desc) a where aid <='.$paramer['limit'].'");
            while($rs = $db->fetch_array($query)){
                //处理标题长度
                if(intval($paramer[t_len])>0){
                    $len = intval($paramer[t_len]);
                    if($rs[color]){
                        $rs[title] = "<font color=\'".$rs[color]."\'>".mb_substr($rs[title],0,$len,"GBK")."</font>";
                    }else{
                        $rs[title] = mb_substr($rs[title],0,$len,"GBK");
                    }
                }
                //处理描述内容长度
                if(intval($paramer[d_len])>0){
                    $len = intval($paramer[d_len]);
                    $rs[description] = mb_substr($rs[description],0,$len,"GBK");
                }
                //获取所属类别名称
                $rs[\'name\'] = $group_name[$rs[\'nid\']];
                //构建资讯静态链接
                if($config[sy_news_rewrite]=="2"){
                    $rs["url"]=$config[\'sy_weburl\']."/news/".date("Ymd",$rs["datetime"])."/".$rs[id].".html";
                }else{
                    $rs["url"] = Url("index","news",array("c"=>"show","id"=>$rs[id]),"1");
                }
                $rs[time]=date("Y-m-d",$rs[datetime]);
                $rs[datetime]=date("m-d",$rs[datetime]);
                '.$name.'[$rs[\'nid\']][\'arclist\'][] = $rs;
            }
		}else{
			$query = $db->query("SELECT * FROM `$db_config[def]news_base` WHERE ".$where.$limit);
			while($rs = $db->fetch_array($query)){
				//处理标题长度
                if(intval($paramer[t_len])>0)
                {
                    $len = intval($paramer[t_len]);
                    $rs[title] = mb_substr($rs[title],0,$len,"GBK");
                }
                //处理描述内容长度
                if(intval($paramer[d_len])>0)
                {
                    $len = intval($paramer[d_len]);
                    $rs[description] = mb_substr($rs[description],0,$len,"GBK");
                }
                //获取所属类别名称
                $rs[\'name\'] = $group_name[$rs[\'nid\']];
                //构建资讯静态链接
                if($config[sy_news_rewrite]=="2"){
                    $rs["url"]=$config[\'sy_weburl\']."/news/".date("Ymd",$rs["datetime"])."/".$rs[id].".html";
                }else{
                    $rs["url"] = Url("index","news",array("c"=>"show","id"=>$rs[id]),"1");
                }
                $rs[time]=date("Y-m-d",$rs[datetime]);
                $rs[datetime]=date("m-d",$rs[datetime]);
                '.$name.'[] = $rs;
            }
		}';
        //自定义标签 END
        global $DiyTagOutputStr;
        $DiyTagOutputStr[]=$OutputStr;
        return SmartyOutputStr($this,$compiler,$_attr,'article',$name,'',$name);
    }
}
class Smarty_Internal_Compile_Articleelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('article'));
        $this->openTag($compiler, 'articleelse', array('articleelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Articleclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('article', 'articleelse'));

        return "<?php } ?>";
    }
}
