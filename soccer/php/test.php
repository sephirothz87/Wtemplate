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

$html;

$date = "2014-11-22";

$curl = new rolling_curl();
$curl->set_gzip(true);
$curl->callback = function($response, $info, $request, $error) {

    // myPrint($response);

    if (empty($response)) {
        myPrint("empty response");
    }
    else {
        $res = array();
        $res_array = array();

        global $date;
        $res['date'] = $date;
        $res['info'] = "info";

        $html = $response;
        // myPrint($response);
        $parser = new simple_html_dom();
        $parser -> load($html);
        // $res = $parser -> find('table');
        $touzhus = $parser -> find('div[class=touzhu]');
        myPrint("touzhus");
        myPrint($touzhus);

        $match = $touzhus[0] -> children(0);
        myPrint("match");
        myPrint($match);    

        // $parser -> load($day_index_div);

        // $day_index = $parser->find('span[class=xulie]');
        $day_index = $match -> children(0)->children(0)->plaintext;
        myPrint("day_index");
        myPrint($day_index);

        $res['day_index'] = $day_index;

        $match_time = $match -> children(0)->children(0)->plaintext;

        myPrint("res");
        myPrint($res);
    }
};

$url = "http://www.okooo.com/jingcai/".$date;
// $url = "http://cp.zgzcw.com/lottery/jchtplayvsForJsp.action?lotteryId=47&type=jcmini&issue=2014-11-22";

$curl->get($url);
$data = $curl->execute();
exit;


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

            $str = "key = ".$key." value = ".$val;
            fwrite(fopen( "log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]"  . $str . "\n" );
        }
    }
}

?>