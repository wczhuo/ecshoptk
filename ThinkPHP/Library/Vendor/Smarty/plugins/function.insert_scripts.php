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
function smarty_function_insert_scripts($params, $template){
    $files_list=explode(',',$params['files']);
    foreach($files_list as $k=>$v){
        $scripts_list[]='<script src="'.'http://localhost/ecshoptk/public/'.'js/'.$v.'" type="text/javascript"></script>';
    }
    return implode('',$scripts_list);
}

?>