<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {fetch} plugin
 *
 * Type:     function<br>
 * Name:     fetch<br>
 * Purpose:  fetch file, web or ftp data and display results
 *
 * @link http://www.smarty.net/manual/en/language.function.fetch.php {fetch}
 *       (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com>
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 * @return string|null if the assign parameter is passed, Smarty assigns the result to a template variable
 */
function smarty_function_url($params, $template){
    $file_ext=pathinfo($params['file'],PATHINFO_EXTENSION);
    switch($file_ext){
        case 'css':$html='http://localhost/ecshoptk/public/css/'.$params['file'];break;
        case 'js':$html='http://localhost/ecshoptk/public/js/'.$params['file'];break;
        default:$html='http://localhost/ecshoptk/public/images/'.$params['file'];break;
    }
    return $html;
}

?>