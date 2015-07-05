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
function smarty_function_insert_cart_info($params, $template){
    //$sql = 'SELECT SUM(goods_number) AS number, SUM(goods_price * goods_number) AS amount' .
    //       ' FROM ' . $GLOBALS['ecs']->table('cart') .
    //       " WHERE session_id = '" . SESS_ID . "' AND rec_type = '" . CART_GENERAL_GOODS . "'";
    //$row = $GLOBALS['db']->GetRow($sql);

    //if ($row)
    //{
    //    $number = intval($row['number']);
    //    $amount = floatval($row['amount']);
    //}
    //else
    //{
    //    $number = 0;
    //    $amount = 0;
    //}

    //$str = sprintf($GLOBALS['_LANG']['cart_info'], $number, price_format($amount, false));

    //return '<a href="flow.php" title="' . $GLOBALS['_LANG']['view_cart'] . '">' . $str . '</a>';
    return 'cart_info';
}

?>