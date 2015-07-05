<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-07-05 08:22:21
         compiled from "D:\WWW\ecshoptk\\Public\\library\recommend_promotion.lbi" */ ?>
<?php /*%%SmartyHeaderCode:30875559878bd690a06-20713405%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '10c0cfc849e0072cd2f7b73cdb269afa32fe8d22' => 
    array (
      0 => 'D:\\WWW\\ecshoptk\\\\Public\\\\library\\recommend_promotion.lbi',
      1 => 1334114186,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '30875559878bd690a06-20713405',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'promotion_goods' => 0,
    'ecs_images_path' => 0,
    'goods' => 0,
    'lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_559878bdc2e354_89596024',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_559878bdc2e354_89596024')) {function content_559878bdc2e354_89596024($_smarty_tpl) {?><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php if ($_smarty_tpl->tpl_vars['promotion_goods']->value) {?>
<div id="sales" class="f_l clearfix">
      <h1><a href="../search.php?intro=promotion"><img src="<?php echo $_smarty_tpl->tpl_vars['ecs_images_path']->value;?>
more.gif" /></a></h1>
       <div class="clearfix goodBox">
         <?php  $_smarty_tpl->tpl_vars['goods'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['goods']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['promotion_goods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["promotion_foreach"]['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['goods']->key => $_smarty_tpl->tpl_vars['goods']->value) {
$_smarty_tpl->tpl_vars['goods']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["promotion_foreach"]['index']++;
?>
         <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['promotion_foreach']['index']<=3) {?>
           <div class="goodList">
           <a href="<?php echo $_smarty_tpl->tpl_vars['goods']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['goods']->value['thumb'];?>
" border="0" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['goods']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
"/></a><br />
					 <p><a href="<?php echo $_smarty_tpl->tpl_vars['goods']->value['url'];?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['goods']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['goods']->value['short_name'], ENT_QUOTES, 'UTF-8', true);?>
</a></p>
           <?php echo $_smarty_tpl->tpl_vars['lang']->value['promote_price'];?>
<font class="f1"><?php echo $_smarty_tpl->tpl_vars['goods']->value['promote_price'];?>
</font>
           </div>
         <?php }?>
         <?php } ?>
       </div>
      </div>
<?php }?><?php }} ?>
