<?php
/**
 * Smarty Internal Plugin Compile AfficheClass
 *
 * Compiles the {afficheclass} {afficheclasselse} {/afficheclass} tags
 *
 * @package Smarty
 * @subpackage Compiler
 * @author Uwe Tews
 */
/**
 * Create By  WangChengZhuo
 * */
/**
 * Smarty Internal Plugin Compile AfficheClass Class
 *
 * @package Smarty
 * @subpackage Compiler
 */
use Think\Controller;

class Smarty_Internal_Compile_AfficheClass extends Smarty_Internal_CompileBase {
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
    public $optional_attributes = array('from', 'name', 'key', 'parentID', 'depthMin', 'depthMax', 'path', 'id', 'ispage', 'pagesize', 'pagename', 'limit', 'orderby', 'source');
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
        //'id', 'parentID', 'depthMin', 'depthMax', 'path', 'pagename', 'orderby'
        //'ispage', 'pagesize', 'limit', 'source'
        
        //从数据库或者缓存文件中取数据
        $Source=array('cache'=>1,'database'=>2)[str_replace('\'','',$_attr['source'])];
        
        $OutputStr='';
        switch($Source){
            case 2:                
                if(isset($_attr['parentID'])){  
                    $OutputStr.='$ParentID='.$_attr['parentID'].'; if($ParentID){$Where[]="`parent_id` in ($ParentID)";}';
                }
                if(isset($_attr['id'])){  
                    $OutputStr.='$ID='.$_attr['id'].'; if($ID&&is_numeric($ID)){$Where["id"]=$ID;}';
                }
                if(isset($_attr['depthMin'])){  
                    $OutputStr.='$DepthMin='.$_attr['depthMin'].'; if(is_numeric($DepthMin)){$Where[]="`depth`>=$DepthMin";}';
                }
                if(isset($_attr['depthMax'])){  
                    $OutputStr.='$DepthMax='.$_attr['depthMax'].'; if(is_numeric($DepthMax)){$Where[]="`depth`<=$DepthMax";}';
                }
                if(isset($_attr['path'])){  
                    $OutputStr.='$Path='.$_attr['path'].'; if($Path){$Where[]="`path` like \'$Path%\'";}';
                }
                
                //2.分页
                if($_attr['ispage']=='1'){
                    if(isset($_attr['pagesize'])&&is_numeric($_attr['pagesize'])&&isset($_attr['pagename'])){
                        $OutputStr.='$count = M("affiche_class")->where($Where)->count();$Page = new \Think\Page($count,'.$_attr['pagesize'].');$show = $Page->show();$_smarty_tpl->tpl_vars['.$_attr['pagename'].']->value=$show;';
                        $OutputStr.='$AfficheClassList=M("affiche_class")->where($Where)->page(((I(\'p\')&&is_numeric(I(\'p\')))?I(\'p\'):\'1\').",'.$_attr['pagesize'].'")->select();';
                        if(isset($_attr['orderby'])){   
                            $OutputStr.='$AfficheClassList=M("affiche_class")->where($Where)->order('.$_attr['orderby'].')->page(((I(\'p\')&&is_numeric(I(\'p\')))?I(\'p\'):\'1\').",'.$_attr['pagesize'].'")->select();';
                        }else{
                            $OutputStr.='$AfficheClassList=M("affiche_class")->where($Where)->page(((I(\'p\')&&is_numeric(I(\'p\')))?I(\'p\'):\'1\').",'.$_attr['pagesize'].'")->select();';
                        }
                    }else{
                        if(isset($_attr['orderby'])){
                            $OutputStr.='$AfficheClassList=M("affiche_class")->order('.$_attr['orderby'].')->where($Where)->select();';   
                        }else{        
                            $OutputStr.='$AfficheClassList=M("affiche_class")->where($Where)->select();';
                        }
                    }
                }else if(isset($_attr['limit'])&&is_numeric($_attr['limit'])){
                    if(isset($_attr['orderby'])){      
                        $OutputStr.='$AfficheClassList=M("affiche_class")->order('.$_attr['orderby'].')->where($Where)->limit('.$_attr['limit'].')->select();';   
                    }else{        
                        $OutputStr.='$AfficheClassList=M("affiche_class")->where($Where)->limit('.$_attr['limit'].')->select();';
                    }
                }else{
                    $OutputStr.='$AfficheClassList=M("affiche_class")->where($Where)->select();';
                }
                break;
            default:
                $OutputStr.='include(ROOT_PATH.\'CACHE/afficheclass.cache.php\');';                
                if(isset($_attr['id'])){  
                    $OutputStr.='$ID='.$_attr['id'].'; if($ID&&is_numeric($ID)){$AfficheClassList=array_filter($AfficheClassList,function($v ) use ( $ID){return ($v[\'id\']==$ID);} );}';
                }
                if(isset($_attr['parentID'])){
                    $OutputStr.='$ParentID=explode(\',\','.$_attr['parentID'].'); if($ParentID){$AfficheClassList=array_filter($AfficheClassList,function($v ) use ( $ParentID){return (in_array($v[\'parent_id\'],$ParentID));} );}';
                }
                if(isset($_attr['depthMin'])){
                    $OutputStr.='$DepthMin='.$_attr['depthMin'].'; if(is_numeric($DepthMin)){$AfficheClassList=array_filter($AfficheClassList,function($v ) use ( $DepthMin){return ($v[\'depth\']>=$DepthMin);});}';
                }
                if(isset($_attr['depthMax'])){ 
                    $OutputStr.='$DepthMax='.$_attr['depthMax'].'; if(is_numeric($DepthMax)){$AfficheClassList=array_filter($AfficheClassList,function($v ) use ( $DepthMax){return ($v[\'depth\']<=$DepthMax);} );}';
                }
                if(isset($_attr['path'])){
                    $OutputStr.='$Path='.$_attr['path'].'; if(is_numeric($Path)){$AfficheClassList=array_filter($AfficheClassList,function($v ) use ( $Path){return (substr($v[\'path\'],0,str_len($Path))==$Path);} );}';
                }
                if(isset($_attr['orderby'])){  
                    $OrderExpArr=explode('',$_attr['orderby']);
                    $OutputStr.='$OrderExpArr=explode(\'\',$_attr[\'orderby\']);';
                    if($OrderExpArr[1]=='desc'){
                        $OutputStr.='asort($AfficheClassList,$OrderExpArr[0]);';
                    }else{
                        $OutputStr.='arsort($AfficheClassList,$OrderExpArr[0]);';
                    }
                }
                if($_attr['ispage']=='1'){
                    if(isset($_attr['pagesize'])&&is_numeric($_attr['pagesize'])&&isset($_attr['pagename'])){
                        $OutputStr.='$count = count($AfficheClassList);$Page = new \Think\Page($count,'.$_attr['pagesize'].');$show = $Page->show();$_smarty_tpl->tpl_vars['.$_attr['pagename'].']->value=$show;';
                        $OutputStr.='$AfficheClassList=array_slice($AfficheClassList,(intval((I(\'p\')&&is_numeric(I(\'p\')))?I(\'p\'):\'1\')-1)*'.$_attr['pagesize'].','.$_attr['pagesize'].');';
                    }
                }else if(isset($_attr['limit'])&&is_numeric($_attr['limit'])){
                    $OutputStr.='$AfficheClassList=array_slice($AfficheClassList,0,'.$_attr['limit'].');';  
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

        $this->openTag($compiler, 'afficheclass', array('afficheclass', $compiler->nocache, $item, $key));
        // maybe nocache because of nocache variables
        $compiler->nocache = $compiler->nocache | $compiler->tag_nocache;

        if (isset($_attr['name'])) {
            $name = $_attr['name'];
            $has_name = true;
            $SmartyVarName = '$smarty.afficheclass.' . trim($name, '\'"') . '.';
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
        $output .= " \$_smarty_tpl->tpl_vars[$item] = new Smarty_Variable; \$_smarty_tpl->tpl_vars[$item]->_loop = false;\n";
        if ($key != null) {
            $output .= " \$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable;\n";
        }
        $output .= $OutputStr." \$_from = ".'$AfficheClassList'."; if (!is_array(\$_from) && !is_object(\$_from)) { settype(\$_from, 'array');}\n";
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
                $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['afficheclass'][$name]['total'] = \$_smarty_tpl->tpl_vars[$item]->total;\n";
            }
            if ($usesSmartyIteration) {
                $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['afficheclass'][$name]['iteration']=0;\n";
            }
            if ($usesSmartyIndex) {
                $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['afficheclass'][$name]['index']=-1;\n";
            }
            if ($usesSmartyShow) {
                $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['afficheclass'][$name]['show']=(\$_smarty_tpl->tpl_vars[$item]->total > 0);\n";
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
                $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['afficheclass'][$name]['first'] = \$_smarty_tpl->tpl_vars[$item]->first;\n";
            }
            if ($usesSmartyIteration) {
                $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['afficheclass'][$name]['iteration']++;\n";
            }
            if ($usesSmartyIndex) {
                $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['afficheclass'][$name]['index']++;\n";
            }
            if ($usesSmartyLast) {
                $output .= " \$_smarty_tpl->tpl_vars['smarty']->value['afficheclass'][$name]['last'] = \$_smarty_tpl->tpl_vars[$item]->last;\n";
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
class Smarty_Internal_Compile_AfficheClasselse extends Smarty_Internal_CompileBase {

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

        list($openTag, $nocache, $item, $key) = $this->closeTag($compiler, array('afficheclass'));
        $this->openTag($compiler, 'afficheclasselse', array('afficheclasselse', $nocache, $item, $key));

        return "<?php }\nif (!\$_smarty_tpl->tpl_vars[$item]->_loop) {\n?>";
    }
}

/**
 * Smarty Internal Plugin Compile AfficheClassclose Class
 *
 * @package Smarty
 * @subpackage Compiler
 */
class Smarty_Internal_Compile_AfficheClassclose extends Smarty_Internal_CompileBase {

    /**
     * Compiles code for the {/affiche} tag
     *
     * @param array  $args      array with attributes from parser
     * @param object $compiler  compiler object
     * @param array  $parameter array with compilation parameter
     * @return string compiled code
     */
    public function compile($args, $compiler, $parameter){
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        // must endblock be nocache?
        if ($compiler->nocache) {
            $compiler->tag_nocache = true;
        }

        list($openTag, $compiler->nocache, $item, $key) = $this->closeTag($compiler, array('afficheclass', 'afficheclasselse'));

        return "<?php } ?>";
    }
}

?>