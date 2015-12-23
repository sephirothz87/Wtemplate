<?php

include "../../php/util.php";

//2015-12-17 16:09:55 测试字符串截取数字
// $str = '<span class="otherodds"> 离散度 28.82&nbsp;12.61&nbsp;9.18  | 中足网方差 8.30&nbsp;1.59&nbsp;0.84</span>';

// logFileAndEcho($str);

// // 方法1 只能找到整数
// // preg_match_all("/\d+/s", $str,$res);

// // 方法2 好用，一为数据即是想要的结果
// preg_match_all('/(\d+)\.(\d+)/is', $str,$res);

// // 方法3 
// // $str=trim($str); 
// // $result=''; 

// // for($i=0;$i<strlen($str);$i++){ 
// //     if(is_numeric($str[$i])){ 
// //         $result.=$str[$i];
// //     } 
// // } 

// logFileAndEcho($res);
//2015-12-17 16:09:55 测试字符串截取数字

//2015-12-23 20:58:38 测试获得URL请求参数
logFileAndEcho($_REQUEST['a']);
logFileAndEcho($_REQUEST['b']);
//2015-12-23 20:58:38 测试获得URL请求参数

?>