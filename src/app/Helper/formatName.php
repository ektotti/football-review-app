<?php 
if(! function_exists('formatName')){
    /**
     * 
     * @return '4文字までの文字列';
     * 
     */
    function formatName($namestr){
        $namestrExplodedWithSpace = explode("　",$namestr);
        if(mb_strlen($namestrExplodedWithSpace[0]) <= 4){
            return $namestrExplodedWithSpace[0];
        } else {
            return mb_substr($namestrExplodedWithSpace[0], 0, 4);
        }
    }
}
?>