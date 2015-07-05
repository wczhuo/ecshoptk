<?php
/**
 * 调用会员信息
 */
function smarty_function_member_info($params, $template){
    $need_cache = $template->caching;
    $template->caching = false;

    if ($_SESSION['user_id'] > 0){
        $template->assign('user_info', get_user_info());
    }else{
        if (!empty($_COOKIE['ECS']['username'])){
            $template->assign('ecs_username', stripslashes($_COOKIE['ECS']['username']));
        }
        $captcha = intval($GLOBALS['_CFG']['captcha']);
        if (($captcha & CAPTCHA_LOGIN) && (!($captcha & CAPTCHA_LOGIN_FAIL) || (($captcha & CAPTCHA_LOGIN_FAIL) && $_SESSION['login_fail'] > 2)) && gd_version() > 0){
            $template->assign('enabled_captcha', 1);
            $template->assign('rand', mt_rand());
        }
    }
    $output = $template->fetch('member_info.html');
    $template->caching = $need_cache;
    return $output;
}
?>