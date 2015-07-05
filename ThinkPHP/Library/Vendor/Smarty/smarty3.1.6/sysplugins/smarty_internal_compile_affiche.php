<?php
/**
 * Smarty Internal Plugin Compile Affiche
 *
 * Compiles the {affiche} {afficheelse} {/affiche} tags
 *
 * @package Smarty
 * @subpackage Compiler
 * @author Uwe Tews
 */
/**
 * Create By  WangChengZhuo
 * */
/**
 * Smarty Internal Plugin Compile Affiche Class
 *
 * @package Smarty
 * @subpackage Compiler
 */
use Think\Controller;

class Smarty_Internal_Compile_Affiche extends Smarty_Internal_CompileBase {
    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see Smarty_Internal_CompileBase
     */
    public $required_attributes = array('item');
    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see Smarty_Internal_CompileBase
     */
    public $optional_attributes = array('from', 'name', 'key', 'classID', 'createtimeMin', 'createtimeMax', 'updatetimeMin', 'updatetimeMax', 'id', 'keyword', 'ispage', 'pagesize', 'pagename', 'limit', 'orderby', 'source');
    /**
     * Attribute definition: Overwrites base class.
     *
     * @var array
     * @see Smarty_Internal_CompileBase
     */
    public $shorttag_order = array('from','item','key','name');

    /**
     * Compiles code for the {affiche} tag
     *
     * @param array  $args      array with attributes from parser
     * @param object $compiler  compiler object
     * @param array  $parameter array with compilation parameter
     * @return string compiled code
     */
    public function compile($args, $compiler, $parameter)
    {
        $tpl = $compiler->template;
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        
        //1.根据参数获取指定的数据
        //'classID', 'createtimeMin', 'createtimeMax', 'updatetimeMin', 'updatetimeMax', 'id', 'keyword', 'pagename', 'orderby'
        //'ispage', 'pagesize', 'limit', 'source'
        
        $Source=array('cache'=>1,'database'=>2)[str_replace('\'','',$_attr['source'])];
        
        $OutputStr='';
        switch($Source){
            case 2:      
                if(isset($_attr['id'])){  
                    $OutputStr.='$ID='.$_attr['id'].'; if($ID&&is_numeric($ID)){$Where["id"]=$ID;}';
                }          
                if(isset($_attr['classID'])){  
                    $OutputStr.='$ClassID='.$_attr['classID'].'; if($ClassID){$Where[]="`class_id` in ($ClassID)";}';
                }
                if(isset($_attr['createtimeMin'])){  
                    $OutputStr.='$CreatetimeMin='.$_attr['createtimeMin'].'; if($CreatetimeMin&&is_numeric($CreatetimeMin)){$Where[]="`createtime`>=$CreatetimeMin";}';
                }
                if(isset($_attr['createtimeMax'])){  
                    $OutputStr.='$CreatetimeMax='.$_attr['createtimeMax'].'; if($CreatetimeMax&&is_numeric($CreatetimeMax)){$Where[]="`createtime`<=$CreatetimeMax";}';
                }
                if(isset($_attr['updatetimeMin'])){  
                    $OutputStr.='$UpdatetimeMin='.$_attr['createtimeMin'].'; if($UpdatetimeMin&&is_numeric($UpdatetimeMin)){$Where[]="`updatetime`>=$CreatetimeMin";}';
                }
                if(isset($_attr['updatetimeMax'])){  
                    $OutputStr.='$UpdatetimeMax='.$_attr['updatetimeMax'].'; if($UpdatetimeMax&&is_numeric($UpdatetimeMax)){$Where[]="`updatetime`<=$CreatetimeMax";}';
                }
                if(isset($_attr['keyword'])){  
                    $OutputStr.='$Keyword='.$_attr['keyword'].'; if($Keyword){$Where[]="`name` like \'$Keyword%\' or `title` like \'$Keyword%\' or `content` like \'$Keyword%\'";}';
                }
                
                //2.分页
                if($_attr['ispage']=='1'){
                    if(isset($_attr['pagesize'])&&is_numeric($_attr['pagesize'])&&isset($_attr['pagename'])){
                        $PageIndex=(I('p')&&is_numeric(I('p')))?I('p'):'1';
                        $OutputStr.='$count = M("affiche")->where($Where)->count();$Page = new \Think\Page($count,'.$_attr['pagesize'].');$show = $Page->show();$_smarty_tpl->tpl_vars['.$_attr['pagename'].']->value=$show;';
                        if(isset($_attr['orderby'])){      
                            $OutputStr.='$AfficheList=M("affiche")->where($Where)->order('.$_attr['orderby'].')->page(((I(\'p\')&&is_numeric(I(\'p\')))?I(\'p\'):\'1\').",'.$_attr['pagesize'].'")->select();';       
                        }else{
                            $OutputStr.='$AfficheList=M("affiche")->where($Where)->page(((I(\'p\')&&is_numeric(I(\'p\')))?I(\'p\'):\'1\').",'.$_attr['pagesize'].'")->select();';         
                        }
                    }else{
                        if(isset($_attr['orderby'])){   
                            $OutputStr.='$AfficheList=M("affiche")->where($Where)->order('.$_attr['orderby'].')->select();';         
                        }else{
                            $OutputStr.='$AfficheList=M("affiche")->where($Where)->select();';          
                        }
                    }
                }else if(isset($_attr['limit'])&&is_numeric($_attr['limit'])){
                    if(isset($_attr['orderby'])){  
                        $OutputStr.='$AfficheList=M("affiche")->where($Where)->order('.$_attr['orderby'].')->limit('.$_attr['limit'].')->select();';            
                    }else{
                        $OutputStr.='$AfficheList=M("affiche")->where($Where)->limit('.$_attr['limit'].')->select();';            
                    }
                }else{
                    if(isset($_attr['orderby'])){  
                        $OutputStr.='$AfficheList=M("affiche")->where($Where)->order('.$_attr['orderby'].')->select();';           
                    }else{
                        $OutputStr.='$AfficheList=M("affiche")->where($Where)->select();';           
                    }
                }
                break;
            default:                
                $OutputStr.='include(ROOT_PATH.\'CACHE/affiche.cache.php\');';                
                if(isset($_attr['id'])){  
                    $OutputStr.='$ID='.$_attr['id'].'; if($ID&&is_numeric($ID)){$AfficheList=array_filter($AfficheList,function($v ) use ( $ID){return ($v[\'id\']==$ID);} );}';
                }
                if(isset($_attr['classID'])){  
                    $OutputStr.='$ClassID=explode(\',\','.$_attr['classID'].'); if($ClassID){$AfficheList=array_filter($AfficheList,function($v ) use ( $ClassID){return (in_array($v[\'class_id\'],$ClassID));} );}';
                }
                if(isset($_attr['createtimeMin'])){
                    $OutputStr.='$CreatetimeMin='.$_attr['createtimeMin'].'; if(is_numeric($CreatetimeMin)){$AfficheList=array_filter($AfficheList,function($v ) use ( $CreatetimeMin){return ($v[\'createtime\']>=$CreatetimeMin);});}';
                }
                if(isset($_attr['createtimeMax'])){ 
                    $OutputStr.='$CreatetimeMax='.$_attr['createtimeMax'].'; if(is_numeric($CreatetimeMax)){$AfficheList=array_filter($AfficheList,function($v ) use ( $CreatetimeMax){return ($v[\'createtime\']<=$CreatetimeMax);} );}';
                }
                if(isset($_attr['updatetimeMin'])){
                    $OutputStr.='$UpdatetimeMin='.$_attr['updatetimeMin'].'; if(is_numeric($UpdatetimeMin)){$AfficheList=array_filter($AfficheList,function($v ) use ( $UpdatetimeMin){return ($v[\'updatetime\']>=$UpdatetimeMin);});}';
                }
                if(isset($_attr['updatetimeMax'])){ 
                    $OutputStr.='$UpdatetimeMax='.$_attr['updatetimeMax'].'; if(is_numeric($UpdatetimeMax)){$AfficheList=array_filter($AfficheList,function($v ) use ( $UpdatetimeMax){return ($v[\'updatetime\']<=$UpdatetimeMax);} );}';
                }
                if(isset($_attr['keyword'])){  
                    $OutputStr.='$Keyword='.$_attr['keyword'].'; if($Keyword){$AfficheList=array_filter($AfficheList,function($v ) use ( $Keyword){return (strstr($Keyword,$v[\'name\'])||strstr($Keyword,$v[\'title\'])||strstr($Keyword,$v[\'content\']));} );}';
                }
                if(isset($_attr['orderby'])){  
                    $OrderExpArr=explode('',$_attr['orderby']);
                    $OutputStr.='$OrderExpArr=explode(\'\',$_attr[\'orderby\']);';
                    if($OrderExpArr[1]=='desc'){
                        $OutputStr.='asort($AfficheList,$OrderExpArr[0]);';
                    }else{
                        $OutputStr.='arsort($AfficheList,$OrderExpArr[0]);';
                    }
                }
                if($_attr['ispage']=='1'){
                    if(isset($_attr['pagesize'])&&is_numeric($_attr['pagesize'])&&isset($_attr['pagename'])){
                        $OutputStr.='$count = count($AfficheList);$Page = new \Think\Page($count,'.$_attr['pagesize'].');$show = $Page->show();$_smarty_tpl->tpl_vars['.$_attr['pagename'].']->value=$show;';
                        $OutputStr.='$AfficheList=array_slice($AfficheList,(intval((I(\'p\')&&is_numeric(I(\'p\')))?I(\'p\'):\'1\')-1)*'.$_attr['pagesize'].','.$_attr['pagesize'].');';
                    }
                }else if(isset($_attr['limit'])&&is_numeric($_attr['limit'])){
                    $OutputStr.='$AfficheList=array_slice($AfficheList,0,'.$_attr['limit'].');';  
                }
                break;
        }

        $item = $_attr['item'];
        if (!strncmp("\$_smarty_tpl->tpl_vars[$item]", $from, strlen($item) + 24)) {
            $compiler->trigger_template_error("item variable {$item} may not be the same variable as at 'from'", $compiler->lex->taglineno);
        }

        if (isset($_attr['key'])) {
            $key = $_attr['key'];
        } else {
            $key = null;
        }

        $this->openTag($compiler, 'affiche', array('affiche', $compiler->nocache, $item, $key));
        // maybe nocache because of nocache variables
        $compiler->nocache = $compiler->nocache | $compiler->tag_nocache;

        if (isset($_attr['name'])) {
            $name = $_attr['name'];
            $has_name = true;
            $SmartyVarName = '$smarty.affiche.' . trim($name, '\'"') . '.';
        } else {
            $name = null;
            $has_name = false;
        }
        $ItemVarName = '$' . trim($item, '\'"') . '@';
        // evaluates which Smarty variables and properties have to be computed
        if ($has_name) {
            $usesSmartyFirst = strpos($tpl->source->content, $SmartyVarName . 'first') !== false;
            $usesSmartyLast = strpos($tpl->source->content, $SmartyVarName . 'last') !== false;
            $usesSmartyIndex = strpos($tpl->source->content, $SmartyVarName . 'index') !== false;
            $usesSmartyIteration = strpos($tpl->source->content, $SmartyVarName . 'iteration') !== false;
            $usesSmartyShow = strpos($tpl->source->content, $SmartyVarName . 'show') !== false;
            $usesSmartyTotal = strpos($tpl->source->content, $SmartyVarName . 'total') !== false;
        } else {
            $usesSmartyFirst = false;
            $usesSmartyLast = false;
            $usesSmartyTotal = false;
            $usesSmartyShow = false;
        }

        $usesPropFirst = $usesSmartyFirst || strpos($tpl->source->content, $ItemVarName . 'first') !== false;
        $usesPropLast = $usesSmartyLast || strpos($tpl->source->content, $ItemVarName . 'last') !== false;
        $usesPropIndex = $usesPropFirst || strpos($tpl->source->content, $ItemVarName . 'index') !== false;
        $usesPropIteration = $usesPropLast || strpos($tpl->source->content, $ItemVarName . 'iteration') !== false;
        $usesPropShow = strpos($tpl->source->content, $ItemVarName . 'show') !== false;
        $usesPropTotal = $usesSmartyTotal || $usesSmartyShow || $usesPropShow || $usesPropLast || strpos($tpl->source->content, $ItemVarName . 'total') !== false;
        // generate output code
        $output = "<?php ";
        $output .= " \$_smarty_tpl->tpl_vars[$item] = new Smarty_Variable; \$_smarty_tpl->tpl_vars[$item]->_loop = false;\n \$Where=array();";
        if ($key != null) {
            $output .= " \$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable;\n";
        }
        $output .= $OutputStr." \$_from = ".'$AfficheList'."; if (!is_array(\$_from) && !is_object(\$_from)) { settype(\$_from, 'array');}\n";
        if ($usesPropTotal) {
            $output .= " \$_smarty_tpl->tpl_vars[$item]->total= \$_smarty_tpl->_count(\$_from);\n";
        }
        if ($usesPropIteration) {
            $output .= " \$_smarty_tpl->tpl_vars[$item]->iteration=0;\n";
        }
        if ($usesPropIndex) {
            $output .= " \$_smarty_tpl->tpl_vars[$item]->index=-1;\n";
        }
        if ($usesPropShow) {
            $output .= " \$_smarty_tpl->tpl_vars[$item]->show = (\$_smarty_tpl->tpl_vars[$item]->total > 0);\n";
        }
        if ($has_name) {
            if ($usesSmartyTotal) {
                $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['affiche'][$name]['total'] = \$_smarty_tpl->tpl_vars[$item]->total;\n";
            }
            if ($usesSmartyIteration) {
                $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['affiche'][$name]['iteration']=0;\n";
            }
            if ($usesSmartyIndex) {
                $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['affiche'][$name]['index']=-1;\n";
            }
            if ($usesSmartyShow) {
                $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['affiche'][$name]['show']=(\$_smarty_tpl->tpl_vars[$item]->total > 0);\n";
            }
        }
        $output .= "foreach (\$_from as \$_smarty_tpl->tpl_vars[$item]->key => \$_smarty_tpl->tpl_vars[$item]->value){\n\$_smarty_tpl->tpl_vars[$item]->_loop = true;\n";
        if ($key != null) {
            $output .= " \$_smarty_tpl->tpl_vars[$key]->value = \$_smarty_tpl->tpl_vars[$item]->key;\n";
        }
        if ($usesPropIteration) {
            $output .= " \$_smarty_tpl->tpl_vars[$item]->iteration++;\n";
        }
        if ($usesPropIndex) {
            $output .= " \$_smarty_tpl->tpl_vars[$item]->index++;\n";
        }
        if ($usesPropFirst) {
            $output .= " \$_smarty_tpl->tpl_vars[$item]->first = \$_smarty_tpl->tpl_vars[$item]->index === 0;\n";
        }
        if ($usesPropLast) {
            $output .= " \$_smarty_tpl->tpl_vars[$item]->last = \$_smarty_tpl->tpl_vars[$item]->iteration === \$_smarty_tpl->tpl_vars[$item]->total;\n";
        }
        if ($has_name) {
            if ($usesSmartyFirst) {
                $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['affiche'][$name]['first'] = \$_smarty_tpl->tpl_vars[$item]->first;\n";
            }
            if ($usesSmartyIteration) {
                $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['affiche'][$name]['iteration']++;\n";
            }
            if ($usesSmartyIndex) {
                $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['affiche'][$name]['index']++;\n";
            }
            if ($usesSmartyLast) {
                $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['affiche'][$name]['last'] = \$_smarty_tpl->tpl_vars[$item]->last;\n";
            }
        }
        $output .= "?>";

        return $output;
    }
}

/**
 * Smarty Internal Plugin Compile Afficheelse Class
 *
 * @package Smarty
 * @subpackage Compiler
 */
class Smarty_Internal_Compile_Afficheelse extends Smarty_Internal_CompileBase {

    /**
     * Compiles code for the {afficheelse} tag
     *
     * @param array  $args array with attributes from parser
     * @param object $compiler compiler object
     * @param array  $parameter array with compilation parameter
     * @return string compiled code
     */
    public function compile($args, $compiler, $parameter)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('affiche'));
        $this->openTag($compiler, 'afficheelse', array('afficheelse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}

/**
 * Smarty Internal Plugin Compile Afficheclose Class
 *
 * @package Smarty
 * @subpackage Compiler
 */
class Smarty_Internal_Compile_Afficheclose extends Smarty_Internal_CompileBase {

    /**
     * Compiles code for the {/affiche} tag
     *
     * @param array  $args      array with attributes from parser
     * @param object $compiler  compiler object
     * @param array  $parameter array with compilation parameter
     * @return string compiled code
     */
    public function compile($args, $compiler, $parameter)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        // must endblock be nocache?
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('affiche', 'afficheelse'));

        return "<?php } ?>";
    }

}

?>