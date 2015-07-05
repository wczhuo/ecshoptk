<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-07-05 08:22:21
         compiled from "D:\WWW\ecshoptk\\Public\\library\new_articles.lbi" */ ?>
<?php /*%%SmartyHeaderCode:4727559878bd373b45-46301492%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5d4d6140e1ae5f6271f9c249c3f62b51b8f92322' => 
    array (
      0 => 'D:\\WWW\\ecshoptk\\\\Public\\\\library\\new_articles.lbi',
      1 => 1436054096,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4727559878bd373b45-46301492',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'new_articles' => 0,
    'article' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_559878bd6698f6_96114937',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_559878bd6698f6_96114937')) {function content_559878bd6698f6_96114937($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include 'D:\\WWW\\ecshoptk\\ThinkPHP\\Library\\Vendor\\Smarty\\plugins\\modifier.truncate.php';
?><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<ul>
<?php  $_smarty_tpl->tpl_vars['article'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['article']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['new_articles']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['article']->key => $_smarty_tpl->tpl_vars['article']->value) {
$_smarty_tpl->tpl_vars['article']->_loop = true;
?>
  <li>
	[<a href="<?php echo $_smarty_tpl->tpl_vars['article']->value['cat_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['article']->value['cat_name'];?>
</a>] <a href="<?php echo $_smarty_tpl->tpl_vars['article']->value['url'];?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['article']->value['title'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['article']->value['short_title'],10,"...",true);?>
</a>
	</li>
<?php } ?>
</ul><?php }} ?>
