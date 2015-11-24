<?php

include "simple_html_dom.php";

$html = new simple_html_dom();
$html->load('<html><body>从字符串中加载html文档演示</body><body>从字符串中加载html文档演示2</body></html>');
$a = $html->find('body');

// fwrite(fopen( "F:\\tmp\\log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]" . "a = " . $a . "\n" );

myPrint($a);
            // echo $a[0].'<br/>';

function myPrint ($arr)
{
    if (!is_array ($arr))
    {
            echo $arr.'<br/>';
        // return false;
        return;
    }
     
    foreach ($arr as $key => $val )
    {
        if (is_array ($val))
        {
            myPrint ($val);
        }
        else
       {
            echo $val.'<br/>';
        }
    }
}

?>