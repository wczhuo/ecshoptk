<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-07-05 08:22:14
         compiled from ".\Application\Home\View\Index\index.dwt" */ ?>
<?php /*%%SmartyHeaderCode:29747559878b6d846a9-37891514%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c7fdbaeaec37d99e71d63277e9bd10d7a782518b' => 
    array (
      0 => '.\\Application\\Home\\View\\Index\\index.dwt',
      1 => 1436054070,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29747559878b6d846a9-37891514',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'keywords' => 0,
    'description' => 0,
    'page_title' => 0,
    'ecs_css_path' => 0,
    'feed_url' => 0,
    'lang' => 0,
    'shop_notice' => 0,
    'categories' => 0,
    'cat' => 0,
    'child' => 0,
    'childer' => 0,
    'top_goods' => 0,
    'ecs_images_path' => 0,
    'goods' => 0,
    'promotion_info' => 0,
    'item' => 0,
    'order_query' => 0,
    'invoice_list' => 0,
    'invoice' => 0,
    'best_goods' => 0,
    'cat_rec_sign' => 0,
    'cat_rec' => 0,
    'rec_data' => 0,
    'new_goods' => 0,
    'hot_goods' => 0,
    'auction_list' => 0,
    'auction' => 0,
    'group_buy_goods' => 0,
    'img_links' => 0,
    'txt_links' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_559878bbf3b0e7_68420577',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_559878bbf3b0e7_68420577')) {function content_559878bbf3b0e7_68420577($_smarty_tpl) {?><?php if (!is_callable('smarty_function_insert_scripts')) include 'D:\\WWW\\ecshoptk\\ThinkPHP\\Library\\Vendor\\Smarty\\plugins\\function.insert_scripts.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
" />
<meta name="Description" content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
" />
<!-- TemplateBeginEditable name="doctitle" -->
<title><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $_smarty_tpl->tpl_vars['ecs_css_path']->value;?>
" rel="stylesheet" type="text/css" />
<link rel="alternate" type="application/rss+xml" title="RSS|<?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
" href="<?php echo $_smarty_tpl->tpl_vars['feed_url']->value;?>
" />

<?php echo smarty_function_insert_scripts(array('files'=>'common.js,index.js'),$_smarty_tpl);?>

</head>
<body>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/library/page_header.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="blank"></div>
<div class="block clearfix">
  <!--left start-->
  <div class="AreaL">
    <!--站内公告 start-->
    <div class="box">
     <div class="box_1">
      <h3><span><?php echo $_smarty_tpl->tpl_vars['lang']->value['shop_notice'];?>
</span></h3>
      <div class="boxCenterList RelaArticle">
        <?php echo $_smarty_tpl->tpl_vars['shop_notice']->value;?>

      </div>
     </div>
    </div>
    <div class="blank5"></div>
    <!--站内公告 end-->
  <!-- TemplateBeginEditable name="左边区域" -->
<!-- #BeginLibraryItem "/library/cart.lbi" -->

<?php echo smarty_function_insert_scripts(array('files'=>'transport.js'),$_smarty_tpl);?>

<div class="cart" id="ECS_CARTINFO">
 <?php echo insert_cart_info(array(),$_smarty_tpl);?>

</div>
<div class="blank5"></div>

 <!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/category_tree.lbi" -->

<div class="box">
 <div class="box_1">
  <div id="category_tree">
    <?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value) {
$_smarty_tpl->tpl_vars['cat']->_loop = true;
?>
     <dl>
     <dt><a href="<?php echo $_smarty_tpl->tpl_vars['cat']->value['url'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cat']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</a></dt>
     <?php  $_smarty_tpl->tpl_vars['child'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['child']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat']->value['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['child']->key => $_smarty_tpl->tpl_vars['child']->value) {
$_smarty_tpl->tpl_vars['child']->_loop = true;
?>
     <dd><a href="<?php echo $_smarty_tpl->tpl_vars['child']->value['url'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['child']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</a></dd>
       <?php  $_smarty_tpl->tpl_vars['childer'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['childer']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['child']->value['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['childer']->key => $_smarty_tpl->tpl_vars['childer']->value) {
$_smarty_tpl->tpl_vars['childer']->_loop = true;
?>
       <dd>&nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['childer']->value['url'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['childer']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</a></dd>
       <?php } ?>
     <?php } ?>
       
       </dl>
    <?php } ?> 
  </div>
 </div>
</div>
<div class="blank5"></div>

 <!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/top10.lbi" -->

<div class="box">
 <div class="box_2">
  <div class="top10Tit"></div>
  <div class="top10List clearfix">
  <?php  $_smarty_tpl->tpl_vars['goods'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['goods']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['top_goods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['top_goods']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['goods']->key => $_smarty_tpl->tpl_vars['goods']->value) {
$_smarty_tpl->tpl_vars['goods']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['top_goods']['iteration']++;
?>
  <ul class="clearfix">
	<img src="<?php echo $_smarty_tpl->tpl_vars['ecs_images_path']->value;?>
top_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['top_goods']['iteration'];?>
.gif" class="iteration" />
	<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['top_goods']['iteration']<4) {?>
      <li class="topimg">
      <a href="<?php echo $_smarty_tpl->tpl_vars['goods']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['goods']->value['thumb'];?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['goods']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" class="samllimg" /></a>
      </li>
	<?php }?>		
      <li <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['top_goods']['iteration']<4) {?>class="iteration1"<?php }?>>
      <a href="<?php echo $_smarty_tpl->tpl_vars['goods']->value['url'];?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['goods']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo $_smarty_tpl->tpl_vars['goods']->value['short_name'];?>
</a><br />
      <?php echo $_smarty_tpl->tpl_vars['lang']->value['shop_price'];?>
<font class="f1"><?php echo $_smarty_tpl->tpl_vars['goods']->value['price'];?>
</font><br />
      </li>
    </ul>
  <?php } ?>
  </div>
 </div>
</div>
<div class="blank5"></div>

 <!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/promotion_info.lbi" -->

<?php if ($_smarty_tpl->tpl_vars['promotion_info']->value) {?>
<!-- 促销信息 -->
<div class="box">
 <div class="box_1">
  <h3><span><?php echo $_smarty_tpl->tpl_vars['lang']->value['promotion_info'];?>
</span></h3>
  <div class="boxCenterList RelaArticle">
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['promotion_info']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
    <?php if ($_smarty_tpl->tpl_vars['item']->value['type']=="snatch") {?>
    <a href="snatch.php" title="<?php echo $_smarty_tpl->tpl_vars['lang']->value[$_smarty_tpl->tpl_vars['item']->value]['type'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['snatch_promotion'];?>
</a>
    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['type']=="group_buy") {?>
    <a href="group_buy.php" title="<?php echo $_smarty_tpl->tpl_vars['lang']->value[$_smarty_tpl->tpl_vars['item']->value]['type'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['group_promotion'];?>
</a>
    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['type']=="auction") {?>
    <a href="auction.php" title="<?php echo $_smarty_tpl->tpl_vars['lang']->value[$_smarty_tpl->tpl_vars['item']->value]['type'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['auction_promotion'];?>
</a>
    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['type']=="favourable") {?>
    <a href="activity.php" title="<?php echo $_smarty_tpl->tpl_vars['lang']->value[$_smarty_tpl->tpl_vars['item']->value]['type'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['favourable_promotion'];?>
</a>
    <?php }?>
    <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['lang']->value[$_smarty_tpl->tpl_vars['item']->value]['type'];?>
 <?php echo $_smarty_tpl->tpl_vars['item']->value['act_name'];
echo $_smarty_tpl->tpl_vars['item']->value['time'];?>
" style="background:none; padding-left:0px;"><?php echo $_smarty_tpl->tpl_vars['item']->value['act_name'];?>
</a><br />
    <?php } ?>
  </div>
 </div>
</div>
<div class="blank5"></div>
<?php }?>
 <!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/order_query.lbi" -->

<?php if (empty($_smarty_tpl->tpl_vars['order_query']->value)) {?>
<?php echo '<script'; ?>
>var invalid_order_sn = "<?php echo $_smarty_tpl->tpl_vars['lang']->value['invalid_order_sn'];?>
"<?php echo '</script'; ?>
>
<div class="box">
 <div class="box_1">
  <h3><span><?php echo $_smarty_tpl->tpl_vars['lang']->value['order_query'];?>
</span></h3>
  <div class="boxCenterList">
    <form name="ecsOrderQuery">
    <input type="text" name="order_sn" class="inputBg" /><br />
    <div class="blank5"></div>
    <input type="button" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['query_order'];?>
" class="bnt_blue_2" onclick="orderQuery()" />
    </form>
    <div id="ECS_ORDER_QUERY" style="margin-top:8px;">
      <?php } else { ?>
      <?php if ($_smarty_tpl->tpl_vars['order_query']->value['user_id']) {?>
<b><?php echo $_smarty_tpl->tpl_vars['lang']->value['order_number'];?>
：</b><a href="user.php?act=order_detail&order_id=<?php echo $_smarty_tpl->tpl_vars['order_query']->value['order_id'];?>
" class="f6"><?php echo $_smarty_tpl->tpl_vars['order_query']->value['order_sn'];?>
</a><br>
  <?php } else { ?>
<b><?php echo $_smarty_tpl->tpl_vars['lang']->value['order_number'];?>
：</b><?php echo $_smarty_tpl->tpl_vars['order_query']->value['order_sn'];?>
<br>
  <?php }?>
<b><?php echo $_smarty_tpl->tpl_vars['lang']->value['order_status'];?>
：</b><br><font class="f1"><?php echo $_smarty_tpl->tpl_vars['order_query']->value['order_status'];?>
</font><br>
  <?php if ($_smarty_tpl->tpl_vars['order_query']->value['invoice_no']) {?>
<b><?php echo $_smarty_tpl->tpl_vars['lang']->value['consignment'];?>
：</b><?php echo $_smarty_tpl->tpl_vars['order_query']->value['invoice_no'];?>
<br>
  <?php }?>
      <?php if ($_smarty_tpl->tpl_vars['order_query']->value['shipping_date']) {?>：<?php echo $_smarty_tpl->tpl_vars['lang']->value['shipping_date'];?>
 <?php echo $_smarty_tpl->tpl_vars['order_query']->value['shipping_date'];?>
<br>
  <?php }?>
  <?php }?>
    </div>
  </div>
 </div>
</div>
<div class="blank5"></div>

 <!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/invoice_query.lbi" -->

<?php if ($_smarty_tpl->tpl_vars['invoice_list']->value) {?>
<style type="text/css">
.boxCenterList form{ display:inline; }
.boxCenterList form a{ color:#404040; text-decoration:underline; }
</style>
<div class="box">
 <div class="box_1">
  <h3><span><?php echo $_smarty_tpl->tpl_vars['lang']->value['shipping_query'];?>
</span></h3>
  <div class="boxCenterList">
    <!-- 发货单查询<?php  $_smarty_tpl->tpl_vars['invoice'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['invoice']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['invoice_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['invoice']->key => $_smarty_tpl->tpl_vars['invoice']->value) {
$_smarty_tpl->tpl_vars['invoice']->_loop = true;
?>
   <?php echo $_smarty_tpl->tpl_vars['lang']->value['order_number'];?>
 <?php echo $_smarty_tpl->tpl_vars['invoice']->value['order_sn'];?>
<br />
   <?php echo $_smarty_tpl->tpl_vars['lang']->value['consignment'];?>
 <?php echo $_smarty_tpl->tpl_vars['invoice']->value['invoice_no'];?>

   <div class="blank"></div>
   <!-- 结束发货单查询<?php } ?>
  </div>
 </div>
</div>
<div class="blank5"></div>
<?php }?>
 <!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/vote_list.lbi" -->

<?php echo insert_vote(array(),$_smarty_tpl);?>

 <!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/email_list.lbi" -->

<div class="box">
 <div class="box_1">
  <h3><span><?php echo $_smarty_tpl->tpl_vars['lang']->value['email_subscribe'];?>
</span></h3>
  <div class="boxCenterList RelaArticle">
    <input type="text" id="user_email" class="inputBg" /><br />
    <div class="blank5"></div>
    <input type="button" class="bnt_blue" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['email_list_ok'];?>
" onclick="add_email_list();" />
    <input type="button" class="bnt_bonus"  value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['email_list_cancel'];?>
" onclick="cancel_email_list();" />
  </div>
 </div>
</div>
<div class="blank5"></div>
<?php echo '<script'; ?>
 type="text/javascript">
var email = document.getElementById('user_email');
function add_email_list()
{
  if (check_email())
  {
    Ajax.call('user.php?act=email_list&job=add&email=' + email.value, '', rep_add_email_list, 'GET', 'TEXT');
  }
}
function rep_add_email_list(text)
{
  alert(text);
}
function cancel_email_list()
{
  if (check_email())
  {
    Ajax.call('user.php?act=email_list&job=del&email=' + email.value, '', rep_cancel_email_list, 'GET', 'TEXT');
  }
}
function rep_cancel_email_list(text)
{
  alert(text);
}
function check_email()
{
  if (Utils.isEmail(email.value))
  {
    return true;
  }
  else
  {
    alert('<?php echo $_smarty_tpl->tpl_vars['lang']->value['email_invalid'];?>
');
    return false;
  }
}
<?php echo '</script'; ?>
>

 <!-- #EndLibraryItem -->
<!-- TemplateEndEditable -->

  </div>
  <!--left end-->
  <!--right start-->
  <div class="AreaR">
   <!--焦点图和站内快讯 START-->
    <div class="box clearfix">
     <div class="box_1 clearfix">
       <div class="f_l" id="focus">
       <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/library/index_ad.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

       </div>
       <!--news-->
       <div id="mallNews" class="f_r">
        <div class="NewsTit"></div>
        <div class="NewsList tc">
         <!-- TemplateBeginEditable name="站内快讯上广告位（宽：210px）" -->
<!-- TemplateEndEditable -->
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/library/new_articles.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        </div>
       </div>
       <!--news end-->
     </div>
    </div>
    <div class="blank5"></div>
   <!--焦点图和站内快讯 END-->
   <!--今日特价，品牌 start-->
    <div class="clearfix">
      <!--特价-->
      <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/library/recommend_promotion.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

      <!--品牌-->
      <div class="box f_r brandsIe6">
       <div class="box_1 clearfix" id="brands">
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/library/brands.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

       </div>
      </div>
    </div>
    <div class="blank5"></div>
   <!-- TemplateBeginEditable name="右边主区域" -->
<!-- #BeginLibraryItem "/library/recommend_best.lbi" -->

<?php if ($_smarty_tpl->tpl_vars['best_goods']->value) {?>
<?php if ($_smarty_tpl->tpl_vars['cat_rec_sign']->value!=1) {?>
<div class="box">
<div class="box_2 centerPadd">
  <div class="itemTit" id="itemBest">
      <?php if ($_smarty_tpl->tpl_vars['cat_rec']->value[1]) {?>
      <h2><a href="javascript:void(0)" onclick="change_tab_style('itemBest', 'h2', this);get_cat_recommend(1, 0);"><?php echo $_smarty_tpl->tpl_vars['lang']->value['all_goods'];?>
</a></h2>
      <?php  $_smarty_tpl->tpl_vars['rec_data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['rec_data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat_rec']->value[1]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['rec_data']->key => $_smarty_tpl->tpl_vars['rec_data']->value) {
$_smarty_tpl->tpl_vars['rec_data']->_loop = true;
?>
      <h2 class="h2bg"><a href="javascript:void(0)" onclick="change_tab_style('itemBest', 'h2', this);get_cat_recommend(1, <?php echo $_smarty_tpl->tpl_vars['rec_data']->value['cat_id'];?>
)"><?php echo $_smarty_tpl->tpl_vars['rec_data']->value['cat_name'];?>
</a></h2>
      <?php } ?>
      <?php }?>
  </div>
  <div id="show_best_area" class="clearfix goodsBox">
  <?php }?>
  <?php  $_smarty_tpl->tpl_vars['goods'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['goods']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['best_goods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['goods']->key => $_smarty_tpl->tpl_vars['goods']->value) {
$_smarty_tpl->tpl_vars['goods']->_loop = true;
?>
  <div class="goodsItem">
         <span class="best"></span>
           <a href="<?php echo $_smarty_tpl->tpl_vars['goods']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['goods']->value['thumb'];?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['goods']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" class="goodsimg" /></a><br />
           <p><a href="<?php echo $_smarty_tpl->tpl_vars['goods']->value['url'];?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['goods']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo $_smarty_tpl->tpl_vars['goods']->value['short_style_name'];?>
</a></p>
           <font class="f1">
           <?php if ($_smarty_tpl->tpl_vars['goods']->value['promote_price']!='') {?>
          <?php echo $_smarty_tpl->tpl_vars['goods']->value['promote_price'];?>

          <?php } else { ?>
          <?php echo $_smarty_tpl->tpl_vars['goods']->value['shop_price'];?>

          <?php }?>
           </font>
        </div>
  <?php } ?>
  <div class="more"><a href="../search.php?intro=best"><img src="<?php echo $_smarty_tpl->tpl_vars['ecs_images_path']->value;?>
more.gif" /></a></div>
  <?php if ($_smarty_tpl->tpl_vars['cat_rec_sign']->value!=1) {?>
  </div>
</div>
</div>
<div class="blank5"></div>
  <?php }?>
<?php }?>

 <!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/recommend_new.lbi" -->

<?php if ($_smarty_tpl->tpl_vars['new_goods']->value) {?>
<?php if ($_smarty_tpl->tpl_vars['cat_rec_sign']->value!=1) {?>
<div class="box">
<div class="box_2 centerPadd">
  <div class="itemTit New" id="itemNew">
      <?php if ($_smarty_tpl->tpl_vars['cat_rec']->value[2]) {?>
      <h2><a href="javascript:void(0)" onclick="change_tab_style('itemNew', 'h2', this);get_cat_recommend(2, 0);"><?php echo $_smarty_tpl->tpl_vars['lang']->value['all_goods'];?>
</a></h2>
      <?php  $_smarty_tpl->tpl_vars['rec_data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['rec_data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat_rec']->value[2]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['rec_data']->key => $_smarty_tpl->tpl_vars['rec_data']->value) {
$_smarty_tpl->tpl_vars['rec_data']->_loop = true;
?>
      <h2 class="h2bg"><a href="javascript:void(0)" onclick="change_tab_style('itemNew', 'h2', this);get_cat_recommend(2, <?php echo $_smarty_tpl->tpl_vars['rec_data']->value['cat_id'];?>
)"><?php echo $_smarty_tpl->tpl_vars['rec_data']->value['cat_name'];?>
</a></h2>
      <?php } ?>
      <?php }?>
  </div>
  <div id="show_new_area" class="clearfix goodsBox">
  <?php }?>
  <?php  $_smarty_tpl->tpl_vars['goods'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['goods']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['new_goods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['goods']->key => $_smarty_tpl->tpl_vars['goods']->value) {
$_smarty_tpl->tpl_vars['goods']->_loop = true;
?>
  <div class="goodsItem">
         <span class="news"></span>
           <a href="<?php echo $_smarty_tpl->tpl_vars['goods']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['goods']->value['thumb'];?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['goods']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" class="goodsimg" /></a><br />
           <p><a href="<?php echo $_smarty_tpl->tpl_vars['goods']->value['url'];?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['goods']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo $_smarty_tpl->tpl_vars['goods']->value['short_style_name'];?>
</a></p>
           <font class="f1">
           <?php if ($_smarty_tpl->tpl_vars['goods']->value['promote_price']!='') {?>
          <?php echo $_smarty_tpl->tpl_vars['goods']->value['promote_price'];?>

          <?php } else { ?>
          <?php echo $_smarty_tpl->tpl_vars['goods']->value['shop_price'];?>

          <?php }?>
           </font>
        </div>
  <?php } ?>
  <div class="more"><a href="../search.php?intro=new"><img src="<?php echo $_smarty_tpl->tpl_vars['ecs_images_path']->value;?>
more.gif" /></a></div>
  <?php if ($_smarty_tpl->tpl_vars['cat_rec_sign']->value!=1) {?>
  </div>
</div>
</div>
<div class="blank5"></div>
  <?php }?>
<?php }?>

 <!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/recommend_hot.lbi" -->

<?php if ($_smarty_tpl->tpl_vars['hot_goods']->value) {?>
<?php if ($_smarty_tpl->tpl_vars['cat_rec_sign']->value!=1) {?>
<div class="box">
<div class="box_2 centerPadd">
  <div class="itemTit Hot" id="itemHot">
      <?php if ($_smarty_tpl->tpl_vars['cat_rec']->value[3]) {?>
      <h2><a href="javascript:void(0)" onclick="change_tab_style('itemHot', 'h2', this);get_cat_recommend(3, 0);"><?php echo $_smarty_tpl->tpl_vars['lang']->value['all_goods'];?>
</a></h2>
      <?php  $_smarty_tpl->tpl_vars['rec_data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['rec_data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat_rec']->value[3]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['rec_data']->key => $_smarty_tpl->tpl_vars['rec_data']->value) {
$_smarty_tpl->tpl_vars['rec_data']->_loop = true;
?>
      <h2 class="h2bg"><a href="javascript:void(0)" onclick="change_tab_style('itemHot', 'h2', this);get_cat_recommend(3, <?php echo $_smarty_tpl->tpl_vars['rec_data']->value['cat_id'];?>
)"><?php echo $_smarty_tpl->tpl_vars['rec_data']->value['cat_name'];?>
</a></h2>
      <?php } ?>
      <?php }?>
  </div>
  <div id="show_hot_area" class="clearfix goodsBox">
  <?php }?>
  <?php  $_smarty_tpl->tpl_vars['goods'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['goods']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['hot_goods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['goods']->key => $_smarty_tpl->tpl_vars['goods']->value) {
$_smarty_tpl->tpl_vars['goods']->_loop = true;
?>
  <div class="goodsItem">
         <span class="hot"></span>
           <a href="<?php echo $_smarty_tpl->tpl_vars['goods']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['goods']->value['thumb'];?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['goods']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" class="goodsimg" /></a><br />
           <p><a href="<?php echo $_smarty_tpl->tpl_vars['goods']->value['url'];?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['goods']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo $_smarty_tpl->tpl_vars['goods']->value['short_style_name'];?>
</a></p>
           <font class="f1">
           <?php if ($_smarty_tpl->tpl_vars['goods']->value['promote_price']!='') {?>
          <?php echo $_smarty_tpl->tpl_vars['goods']->value['promote_price'];?>

          <?php } else { ?>
          <?php echo $_smarty_tpl->tpl_vars['goods']->value['shop_price'];?>

          <?php }?>
           </font>
        </div>
  <?php } ?>
  <div class="more"><a href="../search.php?intro=hot"><img src="<?php echo $_smarty_tpl->tpl_vars['ecs_images_path']->value;?>
more.gif" /></a></div>
  <?php if ($_smarty_tpl->tpl_vars['cat_rec_sign']->value!=1) {?>
  </div>
</div>
</div>
<div class="blank5"></div>
  <?php }?>
<?php }?>

 <!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/auction.lbi" -->

<?php if ($_smarty_tpl->tpl_vars['auction_list']->value) {?>
<div class="box">
 <div class="box_1">
  <h3><span><?php echo $_smarty_tpl->tpl_vars['lang']->value['auction_goods'];?>
</span><a href="auction.php"><img src="<?php echo $_smarty_tpl->tpl_vars['ecs_images_path']->value;?>
more.gif"></a></h3>
    <div class="centerPadd">
    <div class="clearfix goodsBox" style="border:none;">
      <?php  $_smarty_tpl->tpl_vars['auction'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['auction']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['auction_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['auction']->key => $_smarty_tpl->tpl_vars['auction']->value) {
$_smarty_tpl->tpl_vars['auction']->_loop = true;
?>
      <div class="goodsItem">
           <a href="<?php echo $_smarty_tpl->tpl_vars['auction']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['auction']->value['thumb'];?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['auction']->value['goods_name'], ENT_QUOTES, 'UTF-8', true);?>
" class="goodsimg" /></a><br />
           <p><a href="<?php echo $_smarty_tpl->tpl_vars['auction']->value['url'];?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['auction']->value['goods_name'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['auction']->value['short_style_name'], ENT_QUOTES, 'UTF-8', true);?>
</a></p>
           <font class="shop_s"><?php echo $_smarty_tpl->tpl_vars['auction']->value['formated_start_price'];?>
</font>
        </div>
      <?php } ?>
    </div>
    </div>
 </div>
</div>
<div class="blank5"></div>
<?php }?>
 <!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/group_buy.lbi" -->

<?php if ($_smarty_tpl->tpl_vars['group_buy_goods']->value) {?>
<div class="box">
 <div class="box_1">
  <h3><span><?php echo $_smarty_tpl->tpl_vars['lang']->value['group_buy_goods'];?>
</span><a href="group_buy.php"><img src="<?php echo $_smarty_tpl->tpl_vars['ecs_images_path']->value;?>
more.gif"></a></h3>
    <div class="centerPadd">
    <div class="clearfix goodsBox" style="border:none;">
      <?php  $_smarty_tpl->tpl_vars['goods'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['goods']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group_buy_goods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['goods']->key => $_smarty_tpl->tpl_vars['goods']->value) {
$_smarty_tpl->tpl_vars['goods']->_loop = true;
?>
      <div class="goodsItem">
           <a href="<?php echo $_smarty_tpl->tpl_vars['goods']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['goods']->value['thumb'];?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['goods']->value['goods_name'], ENT_QUOTES, 'UTF-8', true);?>
" class="goodsimg" /></a><br />
					 <p><a href="<?php echo $_smarty_tpl->tpl_vars['goods']->value['url'];?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['goods']->value['goods_name'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['goods']->value['short_style_name'], ENT_QUOTES, 'UTF-8', true);?>
</a></p>
           <font class="shop_s"><?php echo $_smarty_tpl->tpl_vars['goods']->value['last_price'];?>
</font>
        </div>
      <?php } ?>
    </div>
    </div>
 </div>
</div>
<div class="blank5"></div>
<?php }?>
 <!-- #EndLibraryItem -->
<!-- TemplateEndEditable -->
  </div>
  <!--right end-->
</div>
<div class="blank5"></div>
<!--帮助-->
<div class="block">
  <div class="box">
   <div class="helpTitBg clearfix">
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/library/help.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

   </div>
  </div>
</div>
<div class="blank"></div>
<!--帮助-->
<!--友情链接 start-->
<?php if ($_smarty_tpl->tpl_vars['img_links']->value||$_smarty_tpl->tpl_vars['txt_links']->value) {?>
<div id="bottomNav" class="box">
 <div class="box_1">
  <div class="links clearfix">
    <!--开始图片类型的友情链接<?php  $_smarty_tpl->tpl_vars['link'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['link']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['img_links']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['link']->key => $_smarty_tpl->tpl_vars['link']->value) {
$_smarty_tpl->tpl_vars['link']->_loop = true;
?>
    <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value['url'];?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['link']->value['name'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['link']->value['logo'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['link']->value['name'];?>
" border="0" /></a>
    <!--结束图片类型的友情链接<?php } ?>
    <?php if ($_smarty_tpl->tpl_vars['txt_links']->value) {?>
    <!--开始文字类型的友情链接<?php  $_smarty_tpl->tpl_vars['link'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['link']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['txt_links']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['link']->key => $_smarty_tpl->tpl_vars['link']->value) {
$_smarty_tpl->tpl_vars['link']->_loop = true;
?>
    [<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value['url'];?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['link']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['link']->value['name'];?>
</a>]
    <!--结束文字类型的友情链接<?php } ?>
    <?php }?>
  </div>
 </div>
</div>
<?php }?>
<!--友情链接 end-->
<div class="blank"></div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tplstyle']->value)."/library/page_footer.lbi", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</body>
</html>
<?php }} ?>
