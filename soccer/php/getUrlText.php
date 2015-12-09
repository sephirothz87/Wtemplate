<?php
include "../../php/util.php";

include "simple_html_dom.php";

include "../phpspider/phpspider/config.php";
include "../phpspider/phpspider/worker.php";
include "../phpspider/phpspider/rolling_curl.php";
include "../phpspider/phpspider/db.php";
include "../phpspider/phpspider/cache.php";
include "../phpspider/phpspider/cls_query.php";
include "../phpspider/user.php";
include "../phpspider/phpspider/cls_curl.php";

		logFileAndEcho("start");

// $url = "http://www.okooo.com/jingcai/2015-11-09";
$url = "http://fenxi.zgzcw.com/1993978/bjop";

$curl = new rolling_curl ();
$curl->set_gzip ( true );
$curl->callback = function ($response, $info, $request, $error) {
	if (empty ( $response )) {
		logFileAndEcho("empty response");
	} else {
		logFileAndEcho($response);
	}
};

$curl->get ( $url );
$data = $curl->execute ();

exit ();
?>