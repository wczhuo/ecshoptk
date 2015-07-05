<?php
function GenerateSpell($String){
    include_once(ROOT_PATH.'/Cache/'.'spell.cache.php');
    $SpellList=unserialize(bzdecompress(base64_decode($content)));
    arsort($SpellList);
    
    $String=ConvertEncodingToGB2312($String);
    
    $ReturnStr = '';
    
    for($i=0; $i<strlen($String); $i++)
    {
        $AscCode = ord(substr($String, $i, 1));
        if($AscCode>160) { 
            $AscCodeNext = ord(substr($String, ++$i, 1)); 
            $AscCode = $AscCode*256 + $AscCodeNext - 65536; 
        }
        $ReturnStr .= Spell($AscCode, $SpellList);
    }
    return preg_replace("/[^a-z0-9]*/", '', $ReturnStr);
}
function Spell($AscCode, $SpellList){
    if ($AscCode>0 && $AscCode<160 ) {
        return chr($AscCode);
    }elseif(($AscCode>=-20319) && ($AscCode<=-10247)) {
        foreach($SpellList as $k=>$v){ 
            if(intval($v)<=$AscCode){
                return $k;
            }
        }
    }
    return '';
}
?>