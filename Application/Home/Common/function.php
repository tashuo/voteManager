<?php
    /*
    *公共函数目录
    */

    //时间戳转化为中文形式的日期，如2014年08月15日
    function timestamp_to_chinese($time = 0){
    	return date('Y年m月d日',$time);
    }

    //中文形式日期转化为时间戳
    function chinese_to_timestamp($str = "1970年01月01日"){
    	return strtotime(substr($str, 0, 4).'/'.substr($str, 7, 2).'/'.substr($str, 12, 2));
    }

    //对生成投票或报名表单元素排序
    function order_by_range($arr1, $arr2){
        return ($arr1['range'] < $arr2['range']) ? -1 : 1;
    }
