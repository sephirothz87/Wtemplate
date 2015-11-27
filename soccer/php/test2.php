<?php

include "simple_html_dom.php";

include "../phpspider/phpspider/config.php";
include "../phpspider/phpspider/worker.php";
include "../phpspider/phpspider/rolling_curl.php";
include "../phpspider/phpspider/db.php";
include "../phpspider/phpspider/cache.php";
include "../phpspider/phpspider/cls_query.php";
include "../phpspider/user.php";
include "../phpspider/phpspider/cls_curl.php";

myPrint("start");


function myPrint ($arr)
{
    if (!is_array ($arr))
    {
            echo $arr.'<br/>';
            fwrite(fopen( "log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]"  . $arr . "\n" );

        // return false;
        return;
    }
     
    foreach ($arr as $key => $val )
    {
        if (is_array ($val))
        {
            $str = "key = ".$key." value = ".$value;
            myPrint ($val);
        }
        else
       {
            echo $val.'<br/>';

            // $str = "[key]".$key."\n[value]".$val."\n";
            fwrite(fopen( "log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]"  . "[key]".$key . "\n" );
            fwrite(fopen( "log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]"  . "[value]".$val . "\n" );
        }
    }
}

?>