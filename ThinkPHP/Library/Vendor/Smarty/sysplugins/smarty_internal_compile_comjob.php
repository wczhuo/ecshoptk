<?php
class Smarty_Internal_Compile_Comjob extends Smarty_Internal_CompileBase{
    public $required_attributes = array('item');
    public $optional_attributes = array('name', 'key', 'limit', 'rec', 'comlen', 'joblen', 'jobnum');
    public $shorttag_order = array('from', 'item', 'key', 'name');
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        $from = $_attr['from'];
        $item = $_attr['item'];
        if (!strncmp("\$_smarty_tpl->tpl_vars[$item]", $from, strlen($item) + 24)) {
            $compiler->trigger_template_error("item variable {$item} may not be the same variable as at 'from'", $compiler->lex->taglineno);
        }
        
        //自定义标签START
        $OutputStr='global $db,$db_config,$config;eval(\'$paramer='.str_replace('\'','\\\'',ArrayToString($_attr,true)).';\');
		$ParamerArr = GetSmarty($paramer,$_GET);
		$paramer = $ParamerArr[arr];extract($paramer);
		$Purl =  $ParamerArr[purl];
		if($config[\'sy_web_site\']=="1"){
			if($_SESSION[\'cityid\']>0 && $_SESSION[\'cityid\']!=""){
				$cityid=$_SESSION[\'cityid\'];
			}
			if($_SESSION[\'three_cityid\']>0 && $_SESSION[\'three_cityid\']!=""){
				$three_cityid = $_SESSION[\'three_cityid\'];
			}
			if($_SESSION[\'hyclass\']>0 && $_SESSION[\'hyclass\']!=""){
				$hy=$_SESSION[\'hyclass\'];
			}
		}
		$time = time();
		$where = "`sdate`<$time AND `edate`>$time and  `state`=\'1\' and `r_status`<>\'2\' and `status`<>\'1\'";
		if($urgent){
			$where.=" AND `urgent_time`>$time";
		}
		if($cityid){
			$where.=\' AND `cityid`=\'.$cityid;
		}
		if($three_cityid){
			$where.=" AND `three_cityid`=$cityid";
		}
		if($paramer[pr]){
			$where.=" AND `rec_time`>$time";
		}
		if($limit){
			$limit =  " limit $limit";
		}
		include PLUS_PATH."/city.cache.php";
		$query = $db->query("select count(*) as num,uid,provinceid,cityid,three_cityid,lastupdate from $db_config[def]company_job where  $where GROUP BY uid ORDER BY lastupdate desc $limit");
		$uids=array();$ComList=array();
        while($rs = $db->fetch_array($query)){
			if($citylen){
				$one_city[$rs[\'uid\']]		= mb_substr($city_name[$rs[\'cityid\']],0,$citylen);
				$two_city[$rs[\'uid\']]  = mb_substr($city_name[$rs[\'three_cityid\']],0,$citylen);
			}else{
				$one_city[$rs[\'uid\']]			= $city_name[$rs[\'cityid\']];
				$two_city[$rs[\'uid\']]  = $city_name[$rs[\'three_cityid\']];
			}
			//若市级不存在，则取省一级
			if($one_city[$rs[\'uid\']]==\'\'){
				$one_city[$rs[\'uid\']]=$city_name[$rs[\'provinceid\']];
			}
			$lasttime[$rs[\'uid\']] = date(\'Y-m-d\',$rs[\'lastupdate\']);
			$uids[] = $rs[\'uid\'];
		}
		if(!empty($uids)){
			$comids = @implode(\',\',$uids);
			$joblist = $db->select_all("company_job","$where AND `uid` IN ($comids) ORDER BY lastupdate desc");
			foreach($joblist as $value){
				if(!$jobnum || count($job_list[$value[\'uid\']])<$jobnum){
					if($joblen){
						$value[\'name_n\'] = mb_substr($value[\'name\'],0,$joblen,\'gbk\');
					}
					$value[\'url\'] = Url("index","com",array("c"=>"comapply","id"=>$value[\'id\']),"1");
					$job_list[$value[\'uid\']][] = $value;
				}
				$comname[$value[\'uid\']] = $value[\'com_name\'];
			}
			foreach($uids as $key=>$value){
				$ComList[$key][\'curl\']     = Curl(array("url"=>"id:".$value));
				$ComList[$key][\'uid\']     = $value;
				$ComList[$key][\'name\']	  = $comname[$value];
				$ComList[$key][\'one_city\']	  = $one_city[$value];
				$ComList[$key][\'two_city\']	  = $two_city[$value];
				$ComList[$key][\'lasttime\']     = $lasttime[$value];
				if($comlen){
					$ComList[$key][\'name_n\'] = mb_substr($comname[$value],0,$comlen,\'gbk\');
				}
				$ComList[$key][\'joblist\'] =$job_list[$value];
			}
		}';

        return SmartyOutputStr($this,$compiler,$_attr,'comjob','$ComList',$OutputStr,'$ComList');
    }
}
class Smarty_Internal_Compile_Comjobelse extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('comjob'));
        $this->openTag($compiler, 'comjobelse', array('comjobelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}
class Smarty_Internal_Compile_Comjobclose extends Smarty_Internal_CompileBase{
    public function compile($args, $compiler, $parameter){
        $_attr = $this->getAttributes($compiler, $args);
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('comjob', 'comjobelse'));

        return "<?php } ?>";
    }
}
