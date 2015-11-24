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

$html;

$curl = new rolling_curl();
$curl->set_gzip(true);
$curl->callback = function($response, $info, $request, $error) {

    // myPrint($response);

    if (empty($response)) {
        myPrint("empty response");
    }
    else {
        $html = $response;
        // myPrint($response);
        $parser = new simple_html_dom();
        $parser -> load($html);
        $res = $parser -> find('table');
        $res = $parser -> find('div[class=touzhu]');
        myPrint($res);

    }
};

$url = "http://www.okooo.com/jingcai/2014-11-22";
// $url = "http://cp.zgzcw.com/lottery/jchtplayvsForJsp.action?lotteryId=47&type=jcmini&issue=2014-11-22";

$curl->get($url);
$data = $curl->execute();
exit;


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