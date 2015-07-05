<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-07-05 08:22:22
         compiled from "D:\WWW\ecshoptk\\Public\\library\page_footer.lbi" */ ?>
<?php /*%%SmartyHeaderCode:17715559878be823374-15198833%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1011ac88899f3b8938f54d98238b1d739ef6c5a4' => 
    array (
      0 => 'D:\\WWW\\ecshoptk\\\\Public\\\\library\\page_footer.lbi',
      1 => 1334114186,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17715559878be823374-15198833',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'navigator_list' => 0,
    'nav' => 0,
    'ecs_images_path' => 0,
    'copyright' => 0,
    'shop_address' => 0,
    'shop_postcode' => 0,
    'service_phone' => 0,
    'service_email' => 0,
    'qq' => 0,
    'im' => 0,
    'shop_name' => 0,
    'ww' => 0,
    'ym' => 0,
    'msn' => 0,
    'skype' => 0,
    'icp_number' => 0,
    'lang' => 0,
    'pv' => 0,
    'licensed' => 0,
    'stats_code' => 0,
    'feed_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_559878bfe26973_51234524',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_559878bfe26973_51234524')) {function content_559878bfe26973_51234524($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include 'D:\\WWW\\ecshoptk\\ThinkPHP\\Library\\Vendor\\Smarty\\plugins\\modifier.escape.php';
?><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--底部导航 start-->
<div id="bottomNav" class="box">
 <div class="box_1">
  <div class="bNavList clearfix">
   <div class="f_l">
   <?php if ($_smarty_tpl->tpl_vars['navigator_list']->value['bottom']) {?>
   <?php  $_smarty_tpl->tpl_vars['nav'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['nav']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['navigator_list']->value['bottom']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['nav']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['nav']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['nav']->key => $_smarty_tpl->tpl_vars['nav']->value) {
$_smarty_tpl->tpl_vars['nav']->_loop = true;
 $_smarty_tpl->tpl_vars['nav']->iteration++;
 $_smarty_tpl->tpl_vars['nav']->last = $_smarty_tpl->tpl_vars['nav']->iteration === $_smarty_tpl->tpl_vars['nav']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['nav_bottom_list']['last'] = $_smarty_tpl->tpl_vars['nav']->last;
?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['nav']->value['url'];?>
" <?php if ($_smarty_tpl->tpl_vars['nav']->value['opennew']==1) {?> target="_blank" <?php }?>><?php echo $_smarty_tpl->tpl_vars['nav']->value['name'];?>
</a>
        <?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['nav_bottom_list']['last']) {?>
           -
        <?php }?>
      <?php } ?>
  <?php }?>
   </div>
   <div class="f_r">
   <a href="#top"><img src="<?php echo $_smarty_tpl->tpl_vars['ecs_images_path']->value;?>
bnt_top.gif" /></a> <a href="../index.php"><img src="<?php echo $_smarty_tpl->tpl_vars['ecs_images_path']->value;?>
bnt_home.gif" /></a>
   </div>
  </div>
 </div>
</div>
<!--底部导航 end-->
<div class="blank"></div>
<!--版权 start-->
<div id="footer">
 <div class="text">
 <?php echo $_smarty_tpl->tpl_vars['copyright']->value;?>
<br />
 <?php echo $_smarty_tpl->tpl_vars['shop_address']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['shop_postcode']->value;?>

 <!-- 客服电话<?php if ($_smarty_tpl->tpl_vars['service_phone']->value) {?>
      Tel: <?php echo $_smarty_tpl->tpl_vars['service_phone']->value;?>

 <!-- 结束客服电话<?php }?>
 <!-- 邮件<?php if ($_smarty_tpl->tpl_vars['service_email']->value) {?>
      E-mail: <?php echo $_smarty_tpl->tpl_vars['service_email']->value;?>
<br />
 <!-- 结束邮件<?php }?>
 <!-- QQ 号码 <?php  $_smarty_tpl->tpl_vars['im'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['im']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['qq']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['im']->key => $_smarty_tpl->tpl_vars['im']->value) {
$_smarty_tpl->tpl_vars['im']->_loop = true;
?>
      <?php if ($_smarty_tpl->tpl_vars['im']->value) {?>
      <a href="http://wpa.qq.com/msgrd?V=1&amp;Uin=<?php echo $_smarty_tpl->tpl_vars['im']->value;?>
&amp;Site=<?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=1:<?php echo $_smarty_tpl->tpl_vars['im']->value;?>
:4" height="16" border="0" alt="QQ" /> <?php echo $_smarty_tpl->tpl_vars['im']->value;?>
</a>
      <?php }?>
      <?php } ?> 结束QQ号码 -->
      <!-- 淘宝旺旺 <?php  $_smarty_tpl->tpl_vars['im'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['im']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ww']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['im']->key => $_smarty_tpl->tpl_vars['im']->value) {
$_smarty_tpl->tpl_vars['im']->_loop = true;
?>
      <?php if ($_smarty_tpl->tpl_vars['im']->value) {?>
      <a href="http://amos1.taobao.com/msg.ww?v=2&uid=<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['im']->value, 'u8_url');?>
&s=2" target="_blank"><img src="http://amos1.taobao.com/online.ww?v=2&uid=<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['im']->value, 'u8_url');?>
&s=2" width="16" height="16" border="0" alt="淘宝旺旺" /><?php echo $_smarty_tpl->tpl_vars['im']->value;?>
</a>
      <?php }?>
      <?php } ?> 结束淘宝旺旺 -->
      <!-- Yahoo Messenger <?php  $_smarty_tpl->tpl_vars['im'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['im']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ym']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['im']->key => $_smarty_tpl->tpl_vars['im']->value) {
$_smarty_tpl->tpl_vars['im']->_loop = true;
?>
      <?php if ($_smarty_tpl->tpl_vars['im']->value) {?>
      <a href="http://edit.yahoo.com/config/send_webmesg?.target=<?php echo $_smarty_tpl->tpl_vars['im']->value;?>
n&.src=pg" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['ecs_images_path']->value;?>
yahoo.gif" width="18" height="17" border="0" alt="Yahoo Messenger" /> <?php echo $_smarty_tpl->tpl_vars['im']->value;?>
</a>
      <?php }?>
      <?php } ?> 结束Yahoo Messenger -->
      <!-- MSN Messenger <?php  $_smarty_tpl->tpl_vars['im'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['im']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['msn']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['im']->key => $_smarty_tpl->tpl_vars['im']->value) {
$_smarty_tpl->tpl_vars['im']->_loop = true;
?>
      <?php if ($_smarty_tpl->tpl_vars['im']->value) {?>
      <img src="<?php echo $_smarty_tpl->tpl_vars['ecs_images_path']->value;?>
msn.gif" width="18" height="17" border="0" alt="MSN" /> <a href="msnim:chat?contact=<?php echo $_smarty_tpl->tpl_vars['im']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['im']->value;?>
</a>
      <?php }?>
      <?php } ?> 结束MSN Messenger -->
      <!-- Skype <?php  $_smarty_tpl->tpl_vars['im'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['im']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['skype']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['im']->key => $_smarty_tpl->tpl_vars['im']->value) {
$_smarty_tpl->tpl_vars['im']->_loop = true;
?>
      <?php if ($_smarty_tpl->tpl_vars['im']->value) {?>
      <img src="http://mystatus.skype.com/smallclassic/<?php echo rawurlencode($_smarty_tpl->tpl_vars['im']->value);?>
" alt="Skype" /><a href="skype:<?php echo rawurlencode($_smarty_tpl->tpl_vars['im']->value);?>
?call"><?php echo $_smarty_tpl->tpl_vars['im']->value;?>
</a>
      <?php }?>
  <?php } ?><br />
  <!-- ICP 证书<?php if ($_smarty_tpl->tpl_vars['icp_number']->value) {?>
  <?php echo $_smarty_tpl->tpl_vars['lang']->value['icp_number'];?>
:<a href="http://www.miibeian.gov.cn/" target="_blank"><?php echo $_smarty_tpl->tpl_vars['icp_number']->value;?>
</a><br />
  <!-- 结束ICP 证书<?php }?>
  <?php echo insert_query_info(array(),$_smarty_tpl);?>
<br />
  <?php  $_smarty_tpl->tpl_vars['pv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lang']->value['p_y']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pv']->key => $_smarty_tpl->tpl_vars['pv']->value) {
$_smarty_tpl->tpl_vars['pv']->_loop = true;
echo $_smarty_tpl->tpl_vars['pv']->value;
}
echo $_smarty_tpl->tpl_vars['licensed']->value;?>
<br />
    <?php if ($_smarty_tpl->tpl_vars['stats_code']->value) {?>
    <div align="left"><?php echo $_smarty_tpl->tpl_vars['stats_code']->value;?>
</div>
    <?php }?>
    <div align="left"  id="rss"><a href="<?php echo $_smarty_tpl->tpl_vars['feed_url']->value;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['ecs_images_path']->value;?>
xml_rss2.gif" alt="rss" /></a></div>
 </div>
</div>

<?php }} ?>
