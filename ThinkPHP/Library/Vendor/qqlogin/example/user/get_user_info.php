<?php
require_once("../../API/qqConnectAPI.php");
$qc = new QC();
$access_token=$qc->qq_callback();
$openid=$qc->get_openid();
$qc->keysArr = array(
    "oauth_consumer_key" => 101179297,
    "access_token" => $access_token,
    "openid" => $openid
);
/*$token = $qc->qq_callback(); 
print_r($token); 
$open_id = $qc->get_openid(); 
print_r($open_id); die;*/
$arr = $qc->get_user_info();
$arr['openid']=$openid;
$content=base64_encode(serialize($arr));
$keysarr=base64_encode(serialize($qc->keysArr));
$cont="<?php";
$cont.="\r\n";
$cont.="\$userinfo='".$content."';\$keysarr='".$keysarr."';";
$cont.="?>";
$fp=@fopen("../../../userinfo.php","w+");
$fp=@fwrite($fp,$cont);
@fclose($fp);
        
header("Location:../../../index.php");die;

echo '<meta charset="UTF-8">';
echo "<p>";
echo "Gender:".$arr["gender"];
echo "</p>";
echo "<p>";
echo "NickName:".$arr["nickname"];
echo "</p>";
echo "<p>";
echo "<img src=\"".$arr['figureurl']."\">";
echo "<p>";
echo "<p>";
echo "<img src=\"".$arr['figureurl_1']."\">";
echo "<p>";
echo "<p>";
echo "<img src=\"".$arr['figureurl_2']."\">";
echo "<p>";
echo "vip:".$arr["vip"];
echo "</p>";
echo "level:".$arr["level"];
echo "</p>";
echo "is_yellow_year_vip:".$arr["is_yellow_year_vip"];
echo "</p>";
?>