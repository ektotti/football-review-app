<?php

use Carbon\Carbon;

if(! function_exists('fomatDate')){
    /**
     * 
     * @return date;
     * 
     */
    function formatDate($date){
        $week = ['(月)','(火)','(水)','(木)','(金)','(土)','(日)'];
        $newdateWithoutWeek = str_replace($week, '', $date);
        $newdate = str_replace(['年','月','日'], ['-','-',''], $newdateWithoutWeek);
        
        $dt = new Carbon($newdate);
        
        return $dt->format('Y-m-d');
    }
}

if(! function_exists('fomatTame')){
    /**
     * 
     * @return time;
     * 
     */
    function formatTime($time){
        if(preg_match("/[0-9]{2}:{1}[0-9]{2}/",$time, $m)){
            return $m[0].':00';
        }else{
            return '00:00:00';
        };
    }
}

?>