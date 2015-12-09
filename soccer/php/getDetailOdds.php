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
		// logFileAndEcho($response);

		$parser = new simple_html_dom ();
		$parser->load ( $response );
		$tds = $parser->find ('td');
		// logFileAndEcho($tds);

		$odds_avg_win_start = $tds[2]->data;
		$odds_avg_plain_start = $tds[3]->data;
		$odds_avg_lose_start = $tds[4]->data;
		$odds_avg_win_latest = $tds[5]->data;
		logFileAndEcho($tds[5]->plaintext);

		$len = strlen($tds[5]->plaintext);

		logFileAndEcho($len);

		logFileAndEcho(strstr($tds[5]->plaintext,"f",false));

		// if(strstr($tds[5]->plaintext,"f",false)){
		if(strstr($tds[5]->plaintext,"↑",false)){
			logFileAndEcho("if");
		}else{
			logFileAndEcho("else");
		}

		$odds_avg_plain_latest = $tds[6]->data;
		$odds_avg_lose_latest = $tds[7]->data;
		$odds_avg_win_rate = $tds[9]->data;
		$odds_avg_plain_rate = $tds[10]->data;
		$odds_avg_lose_rate = $tds[11]->data;
		$odds_avg_win_kelly = $tds[12]->data;
		$odds_avg_plain_kelly = $tds[13]->data;
		$odds_avg_lose_kelly = $tds[14]->data;
		$odds_avg_ratio = $tds[15]->data;
	}
};

$curl->get ( $url );
$data = $curl->execute ();

exit ();
?>