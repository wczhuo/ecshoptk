<?php
namespace Admin\Controller;
use Think\Controller;
class DatabaseController extends Controller {

    //单个备份文件的大小
    public $singleFileSizeLimit = 2097152; 
    //单次取出数据的最大记录条数
    public $limit=100000;
    //当前表的当前页码，即去记录的次数
    public $currentPage=1;
    //当前备份文件的名称，前缀
    public $currentFileName='';
    //当前备份文件的名称，序号
    public $currentFileIndex=1;
    //当前备份文件的内容
    public $currentBackupContent='';
    //当前数据库的所有表的名称
    public $tableNameListAll='';
    /**
     * Summary of index
     */
    public function index(){        
        $tableNameList=M()->query("SHOW TABLE STATUS");
        //print_r($tableNameList);
        $this->assign('tableNameList',$tableNameList);
        $this->singleFileSizeLimit=1024*1024;
        
        $this->display();
    }
    public function recovery(){
        $this->display();
    }
    public function optimize(){
        $this->display();
    }
    public function dbcheck(){
        $this->display();
    }
    /**
     * Summary of BackupTableStruct 备份表结构
     * @param mixed $tableNameList 
     * @return mixed
     */
    function BackupTableStruct($tableNameList=null){      
        if(is_array($tableNameList)){
            $this->currentBackupContent.="set sql_mode='';\r\n";
            foreach($tableNameList as $k=>$v){
                /*if(!in_array($v,$this->tableNameListAll)){
                    continue;
                }*/
                $this->currentBackupContent.= "DROP TABLE IF EXISTS $v;\r\n";
                $creatTableList = M()->query("SHOW CREATE TABLE $v");
                $this->currentBackupContent.=$creatTableList[0]['create table'].";\r\n";
                
                if($this->singleFileSizeLimit <= strlen($this->currentBackupContent)){
                    FileMake(ROOT_PATH.'/Backup/Database/'.$this->currentFileName.'/'.$this->currentFileName.'['.$this->currentFileIndex.']'.'.sql',$this->currentBackupContent,'');
                    $this->currentFileIndex++;
                    $this->currentBackupContent='';
                }
            }
        }
        
        return $creatTableStr;
    }
    /**
     * Summary of BackupTableData 备份表数据
     * @param mixed $tableNameList 
     * @return mixed
     */
    function BackupTableData($tableNameList=null){      
        if(is_array($tableNameList)){
            foreach($tableNameList as $k=>$v){ 
                /*if(!in_array($v,$this->tableNameListAll)){
                    continue;
                }*/
                while(($this->limit>$dataCount)&&($this->currentPage==1)){
                    $limitStr="LIMIT ".(($this->currentPage-1)*$this->limit).",".$this->limit;
                    
                    $dataList = M()->query("SELECT * FROM $v $limitStr");
                    $dataCount = count($dataList);
                    
                    $FieldList=array();
                    foreach ($dataList as $ke=>$va){
                        $FieldList[]=$ke;
                    }
                    $FieldsStr=implode(',',$FieldList);
                    foreach ($dataList as $ke=>$va){
                        $ValueList=array();
                        foreach ($va as $key=>$val){
                            $ValueList[]="'".mysql_escape_string($val)."'";
                        }    
                        $ValuesStr=implode(',',$ValueList);
                        $this->currentBackupContent .= "INSERT INTO $v VALUES(".$ValuesStr. ");\r\n";
                        
                        if($this->singleFileSizeLimit <= strlen($this->currentBackupContent)){
                            FileMake(ROOT_PATH.'/Backup/Database/'.$this->currentFileName.'/'.$this->currentFileName.'['.$this->currentFileIndex.']'.'.sql',$this->currentBackupContent,'');
                            $this->currentFileIndex++;
                            $this->currentBackupContent='';
                        }
                    }                    
                    
                    $this->currentPage++;
                }
                $this->currentPage=1;
            }
        }
        
        return $this->currentBackupContent;
    }
	/**
	 * Summary of download 下载已备份完成的SQL文件
	 */
	function download(){
        $fileName=I('fileName');
		$fileUrl = $this->siteConfig['sitedomain'].'/Backup/Database/'.$fileName;
		header('Content-type: application/sql');
		header('Content-Disposition: attachment; filename="'.$fileName.'"');
		readfile($fileUrl);
	}
	function backin_action(){
		$filedb=array();
		$dbbak=$this->get_table();
		$sqlarr=$dbbak->get_hander();
		//print_r($sqlarr);
		$this->yunset("sqlarr",$sqlarr);
		$this->yuntpl(array('admin/admin_database_back'));
	}
	function delete(){
		$this->check_token();
		$delid=@unlink(CONFIG_PATH."backup/".$_GET['sql']);
		$delid?$this->layer_msg('数据库备份删除成功！',9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg('删除失败！',8,0,$_SERVER['HTTP_REFERER']);
	}
	function sql_action(){
		extract($_GET);
		//OPTIMIZE TABLE `zbcms_uploads` 优化表
		//REPAIR TABLE `zbcms_uploads` 修复表
		//$dbbak=$this->get_table();
		//$fw=$dbbak->backup_action($table,10000000000,$db_config);//备份表
		//TRUNCATE `fanwe_weight`;清空表

		if($type==1){
			global $db_config;
			$this->check_token();
			$dbbak=$this->get_table();
			$fw=$dbbak->backup_action(array($name),10000000000,$db_config);//备份表
			$type_name="备份".$name;
		}
		if($type==2){
			$fw=mysql_query("REPAIR TABLE `".$name."`");
			$type_name="修复".$name;
		}
		if($type==3){
			$fw=mysql_query("OPTIMIZE TABLE  `".$name."`");
			$type_name="优表".$name;
		}
        $fw?$this->layer_msg($type_name."成功！",9,0,$_SERVER['HTTP_REFERER']):$this->layer_msg($type_name."失败！",8,0,$_SERVER['HTTP_REFERER']);
	}
	function backincheck_action(){
		$this->check_token();
		global $db_config;
		extract($_GET);
		if($db_config["version"]!=$ver){
			$this->layer_msg("备份版本和当前系统不同，无法导入！",8,0,$_SERVER['HTTP_REFERER']);
		}
		$dbbak=$this->get_table();
		$dbbak=$dbbak->bakindata($sql);
		$dbbak?$this->layer_msg("数据库恢复成功！",9,0,$_SERVER['HTTP_REFERER']):$this->obj->ACT_msg("恢复成功！",8,0,$_SERVER['HTTP_REFERER']);
	}
	function GetTablesName(){
        $tableList=M()->query("SHOW TABLE STATUS");
        foreach($tableList as $k=>$v){
            $this->tableNameListAll[]=$v['name'];
        }
		return $this->tableNameListAll;
	}
	/**
	 * Summary of backup 响应页面请求备份数据库
	 */
	public function backup(){
        $this->currentFileName=date('Y-m-d h-i-s');
        
        M()->execute("SET SQL_QUOTE_SHOW_CREATE = 0");

        $tableList=M()->query("SHOW TABLE STATUS");
        foreach($tableList as $k=>$v){
            $this->tableNameListAll[]=$v['name'];
        }
        
        @mkdir(ROOT_PATH.'/Backup/Database/'.$this->currentFileName.'/');
        
        $this->BackupTableStruct(I('TableNameList'));
        $this->BackupTableData(I('TableNameList'));
        FileMake(ROOT_PATH.'/Backup/Database/'.$this->currentFileName.'/'.$this->currentFileName.'['.$this->currentFileIndex.']'.'.sql',$this->currentBackupContent,'');
	}
	function num_rand($lenth){
		mt_srand((double)microtime() * 1000000);
		for($i=0;$i<$lenth;$i++){
			$randval.= mt_rand(0,9);
		}
		$randval=substr(md5($randval),mt_rand(0,32-$lenth),$lenth);
		return $randval;
	}
	function writeover($filename,$data,$method="rb+",$iflock=1,$check=1,$chmod=1){
		$check && @strpos($filename,'..')!==false && exit('Forbidden');
		@touch($filename);
		$handle=@fopen($filename,$method);
		if($iflock){
			@flock($handle,LOCK_EX);
		}
		$fw=@fwrite($handle,$data);
		if($method=="rb+") ftruncate($handle,strlen($data));
		fclose($handle);
		$chmod && @chmod($filename,0777);
		return $fw;
	}
	function get_hander(){
		$filedb=array();
		$handle=opendir($this->DefaultPath);
		while($file = readdir($handle)){
			if((eregi("^TODO_",$file) || eregi("^$PW",$file)) && eregi("\.sql$",$file)){
				$strlen=eregi("^$PW",$file) ? 16 + strlen($PW) : 19;
				$fp=fopen($this->DefaultPath."/$file",'rb');
				$bakinfo=@fread($fp,200);
				@fclose($fp);
				$detail=@explode("#TODO#",$bakinfo);
				$bk['name']=$file;
				$bk['version']=str_replace("version:","",$detail[1]);

				$bk['time']=str_replace("Time:","",$detail[4]);
				$bk['charset']=str_replace("charset:","",$detail[3]);
				$bk['dbname']=str_replace("#dbname:","",$detail[0]);
				$bk['def']=str_replace("#def:","",$detail[2]);
				$bk['num']=@substr($file,$strlen,strrpos($file,'.')-$strlen);
				$filedb[]=$bk;
			}
		}
		return $filedb;
	}
	function bakindata($filename,$charset="gbk") {
		$sql=file($this->DefaultPath."/".$filename);
		$query='';
		$num=0;
		foreach($sql as $key => $value){
			$value=trim($value);
			if(!$value || $value[0]=='#') continue;
			if(eregi("\;$",$value)){
				$query.=$value;
				if(eregi("^CREATE",$query)){
					$extra = substr(strrchr($query,')'),1);
					$query = str_replace($extra,'',$query);
					if($this->db->mysql_server('8')>'4.1'){
						$extra = $charset ? "ENGINE=MyISAM DEFAULT CHARSET=$charset;" : "ENGINE=MyISAM;";
					}else{
						$extra = "TYPE=MyISAM;";
					}
					$query .=$extra;
				}elseif(eregi("^INSERT",$query)){
					$query='REPLACE '.substr($query,6);
				}
				$sql=M()->query($query);
				$query='';
			} else{
				$query.=$value;
			}
		}
        
		return $sql;
	}
}