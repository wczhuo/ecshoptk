<?php
function smarty_function_readloginhead($paramer,$template){
	global $config,$seo;
	if($_COOKIE['uid']!=""&&$_COOKIE['username']!=""){
        if($_COOKIE['remind_num']>0){
            $html.='<div class="header_Remind header_Remind_hover"> <em class="header_Remind_em "><i class="header_Remind_msg"></i></em><div class="header_Remind_list" style="display:none;">';
            if($_COOKIE['usertype']==1){
                $html.='<div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/member/index.php?c=msg">邀请面试</a><span class="header_Remind_list_r fr">('.$_COOKIE['userid_msg'].')</span></div><div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/friend/index.php?c=applyfriend">邀请好友</a><span class="header_Remind_list_r fr">('.$_COOKIE['friend1'].')</span></div><div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/member/index.php?c=xin">站内信</a><span class="header_Remind_list_r fr">('.$_COOKIE['friend_message1'].')</span></div><div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/member/index.php?c=sysnews">系统消息</a><span class="header_Remind_list_r fr">('.$_COOKIE['sysmsg1'].')</span></div><div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/member/index.php?c=commsg">企业回复咨询</a><span class="header_Remind_list_r fr">('.$_COOKIE['usermsg'].')</span></div>';
            }elseif($_COOKIE['usertype']==2){
                $html.='<div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/member/index.php?c=hr"class="fl">申请职位</a><span class="header_Remind_list_r fr">('.$_COOKIE['userid_job'].')</span></div><div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/friend/index.php?c=applyfriend"class="fl">邀请好友</a><span class="header_Remind_list_r fr">('.$_COOKIE['friend2'].')</span></div><div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/member/index.php?c=xin"class="fl">站内信</a><span class="header_Remind_list_r fr">('.$_COOKIE['friend_message2'].')</span></div><div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/member/index.php?c=sysnews" class="fl"> 系统消息</a><span class="header_Remind_list_r fr">('.$_COOKIE['sysmsg2'].')</span></div><div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/member/index.php?c=msg"class="fl">求职咨询</a><span class="header_Remind_list_r fr">('.$_COOKIE['commsg'].')</span></div>';
            }elseif($_COOKIE['usertype']==3){
                $html.='<div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/member/index.php?c=yp_resume"class="fl">应聘简历</a><span class="header_Remind_list_r fr">('.$_COOKIE['userid_job3'].')</span></div><div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/member/index.php?c=entrust_resume" class="fl">委托简历</a><span class="header_Remind_list_r fr">('.$_COOKIE['entrust'].')</span></div><div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/friend/index.php?c=applyfriend"class="fl">邀请好友</a><span class="header_Remind_list_r fr">('.$_COOKIE['friend3'].')</span></div><div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/member/index.php?c=xin"class="fl"> 站内信<span class="header_Remind_list_r fr">('.$_COOKIE['friend_message3'].'）</span></a></div><div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/member/index.php?c=sysnews"class="fl"> 系统消息</a><span class="header_Remind_list_r fr">('.$_COOKIE['sysmsg3'].')</span></div><div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/member/index.php?c=zixun"class="fl">求职咨询</a><span class="header_Remind_list_r fr">('.$_COOKIE['commsg3'].')</span></div>';
            }elseif($_COOKIE['usertype']==4){
                $html.='<div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/member/index.php?c=sign_up"class="fl">课程预约</a><span class="header_Remind_list_r fr">('.$_COOKIE['sign_up'].')</span></div><div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/friend/index.php?c=applyfriend"class="fl">邀请好友</a><span class="header_Remind_list_r fr">('.$_COOKIE['friend4'].')</span></div><div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/member/index.php?c=xin"class="fl"> 站内信</a><span class="header_Remind_list_r fr">('.$_COOKIE['friend_message4'].')</span></div><div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/member/index.php?c=sysnews"class="fl"> 系统消息</a><span class="header_Remind_list_r fr">('.$_COOKIE['sysmsg4'].')</span></div><div class="header_Remind_list_a"><a href="'.$config['sy_weburl'].'/member/index.php?c=message"class="fl">咨询留言</a><span class="header_Remind_list_r fr">('.$_COOKIE['message'].')</span></div>';
            }
            $html.='</div> </div>';
        }
        $html2= "您好：<a href=\"".$config['sy_weburl']."/member\" ><font color=\"red\">".$_COOKIE['username']."</font></a>！<a href=\"javascript:void(0)\" onclick=\"logout(\'".$config['sy_weburl']."/index.php?c=logout\');\">[安全退出]</a>";

        $html.='<div class=" fr">'.$html2.'</div>';
    }else{
        $login_url = Url("index","login",array(),"1");
        $login_lt_url = Lurl(array("url"=>"c:login"));
        $login_train_url = turl(array("url"=>"c:login"));
        $reg_url = Url("index","register",array("usertype"=>"1"),"1");
        $reg_com_url = Url("index","register",array("usertype"=>"2"),"1");
        $reg_lt_url = Lurl(array("url"=>"c:register"));			
        $reg_train_url = turl(array("url"=>"c:register"));			
        $style = $config['sy_weburl']."/app/template/".$config['style'];

        $login='<li><a href="'.$login_url.'">会员登录</a></li>';		
        $lt_login='<li><a href="'.$login_lt_url.'">猎头登录</a></li>';			
        $train_login='<li><a href="'.$login_train_url.'">培训登录</a></li>';			
        $user_reg='<li><a href="'.$reg_url.'">个人注册</a></li>';
        $com_reg='<li><a href="'.$reg_com_url.'">企业注册</a></li>';
        $lt_reg='<li><a href="'.$reg_lt_url.'">猎头注册</a></li>';
        $train_reg='<li><a href="'.$reg_train_url.'">培训注册</a></li>'; 
        if($_GET['f']=='l'){
            $html='<div class=" fr"><div class="yun_topLogin_cont"><div class="yun_topLogin"><a href="'.$login_lt_url.'">猎头登录</a></div><div class="yun_topLogin"><a href="'.$reg_lt_url.'">猎头注册</a></div></div></div>';
        }else{
            $html='<div class=" fr"><div class="yun_topLogin_cont"><div class="yun_topLogin"><a class="yun_More" href="javascript:void(0)">用户登录</a><ul class="yun_Moredown" style="display:none">'.$login.$lt_login.$train_login.'</ul></div><div class="yun_topLogin"> <a class="yun_More" href="javascript:void(0)">用户注册</a><ul class="yun_Moredown fn-hide" style="display:none">'.$user_reg.$com_reg.$lt_reg.$train_reg.'</ul></div></div></div>';
            if($config['sy_qqlogin']=='1'||$config['sy_sinalogin']=='1'||$config['sy_wxlogin']=='1'){
                $flogin='<div class="fastlogin fr">';
                if($config['sy_qqlogin']=='1'){
                    $flogin.='<span style="width:70px;"><img src="'.$config['sy_weburl'].'/app/template/'.$config['style'].'/images/yun_qq.png" class="png" > <a href="'.Url("index","qqconnect",array("c"=>"qqlogin"),'1').'">QQ登录</a></span>';
                }
                if($config['sy_sinalogin']=='1'){
                    $flogin.='<span><img src="'.$config['sy_weburl'].'/app/template/'.$config['style'].'/images/yun_sina.png" class="png"> <a href="'.Url("index","sinaconnect",array(),"1").'">新浪</a></span>';
                } 
                if($config['sy_wxlogin']=='1'){
                    $flogin.='<span><img src="'.$config['sy_weburl'].'/app/template/'.$config['style'].'/images/yun_wx.png" class="png"> <a href="'.Url("index","wxconnect",array(),"1").'">微信</a></span>';
                }  
                $flogin.='</div>';
                $html.=$flogin;
            }
        }
    }
	return $html;
}
?>