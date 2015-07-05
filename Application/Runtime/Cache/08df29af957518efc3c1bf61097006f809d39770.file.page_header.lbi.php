<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-07-05 08:22:20
         compiled from "D:\WWW\ecshoptk\\Public\\library\page_header.lbi" */ ?>
<?php /*%%SmartyHeaderCode:14791559878bc04ebf8-44949900%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '08df29af957518efc3c1bf61097006f809d39770' => 
    array (
      0 => 'D:\\WWW\\ecshoptk\\\\Public\\\\library\\page_header.lbi',
      1 => 1334114186,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14791559878bc04ebf8-44949900',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
    'ecs_images_path' => 0,
    'navigator_list' => 0,
    'nav' => 0,
    'searchkeywords' => 0,
    'val' => 0,
    'category_list' => 0,
    'search_keywords' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_559878bcbf74b7_58238082',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_559878bcbf74b7_58238082')) {function content_559878bcbf74b7_58238082($_smarty_tpl) {?><?php if (!is_callable('smarty_function_insert_scripts')) include 'D:\\WWW\\ecshoptk\\ThinkPHP\\Library\\Vendor\\Smarty\\plugins\\function.insert_scripts.php';
?><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php echo '<script'; ?>
 type="text/javascript">
var process_request = "<?php echo $_smarty_tpl->tpl_vars['lang']->value['process_request'];?>
";
<?php echo '</script'; ?>
>
<div class="block clearfix">
 <div class="f_l"><a href="../index.php" name="top"><img src="<?php echo $_smarty_tpl->tpl_vars['ecs_images_path']->value;?>
logo.gif" /></a></div>
 <div class="f_r log">
   <ul>
   <li class="userInfo">
   <?php echo smarty_function_insert_scripts(array('files'=>'transport.js,utils.js'),$_smarty_tpl);?>

   <font id="ECS_MEMBERZONE"><?php echo insert_member_info(array(),$_smarty_tpl);?>
 </font>
   </li>
   <?php if ($_smarty_tpl->tpl_vars['navigator_list']->value['top']) {?>
   <li id="topNav" class="clearfix">
    <?php  $_smarty_tpl->tpl_vars['nav'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['nav']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['navigator_list']->value['top']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['nav']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['nav']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['nav']->key => $_smarty_tpl->tpl_vars['nav']->value) {
$_smarty_tpl->tpl_vars['nav']->_loop = true;
 $_smarty_tpl->tpl_vars['nav']->iteration++;
 $_smarty_tpl->tpl_vars['nav']->last = $_smarty_tpl->tpl_vars['nav']->iteration === $_smarty_tpl->tpl_vars['nav']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['nav_top_list']['last'] = $_smarty_tpl->tpl_vars['nav']->last;
?>
            <a href="<?php echo $_smarty_tpl->tpl_vars['nav']->value['url'];?>
" <?php if ($_smarty_tpl->tpl_vars['nav']->value['opennew']==1) {?> target="_blank" <?php }?>><?php echo $_smarty_tpl->tpl_vars['nav']->value['name'];?>
</a>
            <?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['nav_top_list']['last']) {?>
             |
            <?php }?>
    <?php } ?>
    <div class="topNavR"></div>
   </li>
   <?php }?>
   </ul>
 </div>
</div>
<div  class="blank"></div>
<div id="mainNav" class="clearfix">
  <a href="../index.php"<?php if ($_smarty_tpl->tpl_vars['navigator_list']->value['config']['index']==1) {?> class="cur"<?php }?>><?php echo $_smarty_tpl->tpl_vars['lang']->value['home'];?>
<span></span></a>
  <?php  $_smarty_tpl->tpl_vars['nav'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['nav']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['navigator_list']->value['middle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['nav']->key => $_smarty_tpl->tpl_vars['nav']->value) {
$_smarty_tpl->tpl_vars['nav']->_loop = true;
?>
  <a href="<?php echo $_smarty_tpl->tpl_vars['nav']->value['url'];?>
" <?php if ($_smarty_tpl->tpl_vars['nav']->value['opennew']==1) {?>target="_blank" <?php }?> <?php if ($_smarty_tpl->tpl_vars['nav']->value['active']==1) {?> class="cur"<?php }?>><?php echo $_smarty_tpl->tpl_vars['nav']->value['name'];?>
<span></span></a>
 <?php } ?>
</div>
<!--search start-->
<div id="search"  class="clearfix">
  <div class="keys f_l">
   <?php echo '<script'; ?>
 type="text/javascript">
    
    <!--
    function checkSearchForm()
    {
        if(document.getElementById('keyword').value)
        {
            return true;
        }
        else
        {
            alert("{$lang.no_keywords}");
            return false;
        }
    }
    -->
    
    <?php echo '</script'; ?>
>
    <?php if ($_smarty_tpl->tpl_vars['searchkeywords']->value) {?>
   <?php echo $_smarty_tpl->tpl_vars['lang']->value['hot_search'];?>
 ：
   <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['searchkeywords']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
   <a href="search.php?keywords=<?php echo rawurlencode($_smarty_tpl->tpl_vars['val']->value);?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</a>
   <?php } ?>
   <?php }?>
  </div>
  <form id="searchForm" name="searchForm" method="get" action="search.php" onSubmit="return checkSearchForm()" class="f_r"  style="_position:relative; top:5px;">
   <select name="category" id="category" class="B_input">
      <option value="0"><?php echo $_smarty_tpl->tpl_vars['lang']->value['all_category'];?>
</option>
      <?php echo $_smarty_tpl->tpl_vars['category_list']->value;?>

    </select>
   <input name="keywords" type="text" id="keyword" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['search_keywords']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="B_input" style="width:110px;"/>
   <input name="imageField" type="submit" value="" class="go" style="cursor:pointer;" />
   <a href="search.php?act=advanced_search"><?php echo $_smarty_tpl->tpl_vars['lang']->value['advanced_search'];?>
</a>
   </form>
</div>
<!--search end--><?php }} ?>
