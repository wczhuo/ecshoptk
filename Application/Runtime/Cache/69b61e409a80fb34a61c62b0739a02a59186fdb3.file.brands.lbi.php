<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-07-05 08:22:21
         compiled from "D:\WWW\ecshoptk\\Public\\library\brands.lbi" */ ?>
<?php /*%%SmartyHeaderCode:18118559878bdc60fe6-82715972%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '69b61e409a80fb34a61c62b0739a02a59186fdb3' => 
    array (
      0 => 'D:\\WWW\\ecshoptk\\\\Public\\\\library\\brands.lbi',
      1 => 1334114186,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18118559878bdc60fe6-82715972',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'brand_list' => 0,
    'brand' => 0,
    'ecs_data_path' => 0,
    'ecs_images_path' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_559878be3ae869_98387647',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_559878be3ae869_98387647')) {function content_559878be3ae869_98387647($_smarty_tpl) {?><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php if ($_smarty_tpl->tpl_vars['brand_list']->value) {?>
  <?php  $_smarty_tpl->tpl_vars['brand'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['brand']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['brand_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["brand_foreach"]['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['brand']->key => $_smarty_tpl->tpl_vars['brand']->value) {
$_smarty_tpl->tpl_vars['brand']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["brand_foreach"]['index']++;
?>
    <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['brand_foreach']['index']<=11) {?>
      <?php if ($_smarty_tpl->tpl_vars['brand']->value['brand_logo']) {?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['brand']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['ecs_data_path']->value;?>
brandlogo/<?php echo $_smarty_tpl->tpl_vars['brand']->value['brand_logo'];?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['brand']->value['brand_name'], ENT_QUOTES, 'UTF-8', true);?>
 (<?php echo $_smarty_tpl->tpl_vars['brand']->value['goods_num'];?>
)" /></a>
      <?php } else { ?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['brand']->value['url'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['brand']->value['brand_name'], ENT_QUOTES, 'UTF-8', true);?>
 <?php if ($_smarty_tpl->tpl_vars['brand']->value['goods_num']) {?>(<?php echo $_smarty_tpl->tpl_vars['brand']->value['goods_num'];?>
)<?php }?></a>
      <?php }?>
    <?php }?>
  <?php } ?>
<div class="brandsMore"><a href="../brand.php"><img src="<?php echo $_smarty_tpl->tpl_vars['ecs_images_path']->value;?>
moreBrands.gif" /></a></div>
<?php }?><?php }} ?>
