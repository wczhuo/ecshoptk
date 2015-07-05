<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-07-05 08:22:20
         compiled from "D:\WWW\ecshoptk\\Public\\library\index_ad.lbi" */ ?>
<?php /*%%SmartyHeaderCode:7126559878bcca32d7-35327489%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c9886e4c7df4c68690f406010f65798daf69df1a' => 
    array (
      0 => 'D:\\WWW\\ecshoptk\\\\Public\\\\library\\index_ad.lbi',
      1 => 1334114186,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7126559878bcca32d7-35327489',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'index_ad' => 0,
    'flash_theme' => 0,
    'ad' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_559878bd348bc4_84871529',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_559878bd348bc4_84871529')) {function content_559878bd348bc4_84871529($_smarty_tpl) {?><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php if ($_smarty_tpl->tpl_vars['index_ad']->value=='sys') {?>
  <?php echo '<script'; ?>
 type="text/javascript">
  var swf_width=484;
  var swf_height=200;
  <?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 type="text/javascript" src="data/flashdata/<?php echo $_smarty_tpl->tpl_vars['flash_theme']->value;?>
/cycle_image.js"><?php echo '</script'; ?>
>
<?php } elseif ($_smarty_tpl->tpl_vars['index_ad']->value=='cus') {?>
  <?php if ($_smarty_tpl->tpl_vars['ad']->value['ad_type']==0) {?>
    <a href="<?php echo $_smarty_tpl->tpl_vars['ad']->value['url'];?>
" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['ad']->value['content'];?>
" width="484" height="200" border="0"></a>
  <?php } elseif ($_smarty_tpl->tpl_vars['ad']->value['ad_type']==1) {?>
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="484" height="200">
      <param name="movie" value="<?php echo $_smarty_tpl->tpl_vars['ad']->value['content'];?>
" />
      <param name="quality" value="high" />
      <embed src="<?php echo $_smarty_tpl->tpl_vars['ad']->value['content'];?>
" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="484" height="200"></embed>
    </object>
  <?php } elseif ($_smarty_tpl->tpl_vars['ad']->value['ad_type']==2) {?>
    <?php echo $_smarty_tpl->tpl_vars['ad']->value['content'];?>

  <?php } elseif ($_smarty_tpl->tpl_vars['ad']->value['ad_type']==3) {?>
    <a href="<?php echo $_smarty_tpl->tpl_vars['ad']->value['url'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['ad']->value['content'];?>
</a>
  <?php }?>
<?php } else { ?>
<?php }?><?php }} ?>
