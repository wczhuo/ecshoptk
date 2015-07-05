<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-07-05 08:22:22
         compiled from "D:\WWW\ecshoptk\\Public\\library\help.lbi" */ ?>
<?php /*%%SmartyHeaderCode:32365559878be408605-41462753%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6b2d3e3eac674f892bc7475ed8ac21d31ba4e21c' => 
    array (
      0 => 'D:\\WWW\\ecshoptk\\\\Public\\\\library\\help.lbi',
      1 => 1334114186,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '32365559878be408605-41462753',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'helps' => 0,
    'help_cat' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_559878be7f4563_43002072',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_559878be7f4563_43002072')) {function content_559878be7f4563_43002072($_smarty_tpl) {?><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php if ($_smarty_tpl->tpl_vars['helps']->value) {?>
<?php  $_smarty_tpl->tpl_vars['help_cat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['help_cat']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['helps']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['help_cat']->key => $_smarty_tpl->tpl_vars['help_cat']->value) {
$_smarty_tpl->tpl_vars['help_cat']->_loop = true;
?>
<dl>
  <dt><a href='<?php echo $_smarty_tpl->tpl_vars['help_cat']->value['cat_id'];?>
' title="<?php echo $_smarty_tpl->tpl_vars['help_cat']->value['cat_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['help_cat']->value['cat_name'];?>
</a></dt>
  <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['help_cat']->value['article']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
  <dd><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['title'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['short_title'];?>
</a></dd>
  <?php } ?>
</dl>
<?php } ?>
<?php }?><?php }} ?>
