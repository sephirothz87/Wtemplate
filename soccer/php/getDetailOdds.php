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

$curl = new rolling_curl();
$curl->set_gzip(true);
$curl->callback = function ($response, $info, $request, $error) {
	if(empty($response)) {
		logFileAndEcho("empty response");
	} else {
		// logFileAndEcho($response);
		$parser = new simple_html_dom();
		$parser->load($response);
		$tds = $parser->find('td');
		// logFileAndEcho($tds);
		
		$odds_array = array ();
		
		// 平均欧赔-初始赔率-胜
		$odds_array['odds_avg_win_start'] = $tds[2]->data;
		// 平均欧赔-初始赔率-平
		$odds_array['odds_avg_plain_start'] = $tds[3]->data;
		// 平均欧赔-初始赔率-负
		$odds_array['odds_avg_lose_start'] = $tds[4]->data;
		// 平均欧赔-最新赔率-胜
		$odds_array['odds_avg_win_latest'] = $tds[5]->data;
		// 平均欧赔-最新赔率-平
		$odds_array['odds_avg_plain_latest'] = $tds[6]->data;
		// 平均欧赔-最新赔率-负
		$odds_array['odds_avg_lose_latest'] = $tds[7]->data;
		// 平均欧赔-概率-胜-百分数
		$odds_array['odds_avg_win_rate'] = $tds[9]->data;
		// 平均欧赔-概率-平-百分数
		$odds_array['odds_avg_plain_rate'] = $tds[10]->data;
		// 平均欧赔-概率-负-百分数
		$odds_array['odds_avg_lose_rate'] = $tds[11]->data;
		// 平均欧赔-凯利指数-胜
		$odds_array['odds_avg_win_kelly'] = $tds[12]->data;
		// 平均欧赔-凯利指数-平
		$odds_array['odds_avg_plain_kelly'] = $tds[13]->data;
		// 平均欧赔-凯利指数-负
		$odds_array['odds_avg_lose_kelly'] = $tds[14]->data;
		// 平均欧赔-赔付率
		$odds_array['odds_avg_ratio'] = $tds[15]->data;
		
		// logFileAndEcho($tds[5]->plaintext);
		
		// $len = strlen($tds[5]->plaintext);
		
		// logFileAndEcho($len);
		
		// logFileAndEcho(strstr($tds[5]->plaintext,"f",false));
		
		// 平均欧派-最新赔率-变化趋势 1:赔率上涨 -1:赔率下跌 0:赔率不变
		$odds_array['odds_avg_win_trend'] = 0;
		// 平均欧派-最新赔率-变化趋势 1:赔率上涨 -1:赔率下跌 0:赔率不变
		$odds_array['odds_avg_plain_trend'] = 0;
		// 平均欧派-最新赔率-变化趋势 1:赔率上涨 -1:赔率下跌 0:赔率不变
		$odds_array['odds_avg_lose_trend'] = 0;
		
		// if(strstr($tds[5]->plaintext,"f",false)){
		if(strstr($tds[5]->plaintext, "↑", false)) {
			$odds_array['odds_avg_win_trend'] = 1;
		} else if(strstr($tds[5]->plaintext, "↓", false)) {
			$odds_array['odds_avg_win_trend'] = - 1;
		}
		
		if(strstr($tds[6]->plaintext, "↑", false)) {
			$odds_array['odds_avg_plain_trend'] = 1;
		} else if(strstr($tds[6]->plaintext, "↓", false)) {
			$odds_array['odds_avg_plain_trend'] = - 1;
		}
		
		if(strstr($tds[7]->plaintext, "↑", false)) {
			$odds_array['odds_avg_lose_trend'] = 1;
		} else if(strstr($tds[7]->plaintext, "↓", false)) {
			$odds_array['odds_avg_lose_trend'] = - 1;
		}
		
		// 竞彩官方-初始赔率-胜
		$odds_array['odds_william_win_start'] = $tds[19]->data;
		// 竞彩官方-初始赔率-平
		$odds_array['odds_william_plain_start'] = $tds[20]->data;
		// 竞彩官方-初始赔率-负
		$odds_array['odds_william_lose_start'] = $tds[21]->data;
		// 竞彩官方-最新赔率-胜
		$odds_array['odds_william_win_latest'] = $tds[22]->data;
		// 竞彩官方-最新赔率-平
		$odds_array['odds_william_plain_latest'] = $tds[23]->data;
		// 竞彩官方-最新赔率-负
		$odds_array['odds_william_lose_latest'] = $tds[24]->data;
		// 竞彩官方-概率-胜-百分数
		$odds_array['odds_william_win_rate'] = $tds[26]->data;
		// 竞彩官方-概率-平-百分数
		$odds_array['odds_william_plain_rate'] = $tds[27]->data;
		// 竞彩官方-概率-负-百分数
		$odds_array['odds_william_lose_rate'] = $tds[28]->data;
		// 竞彩官方-凯利指数-胜
		$odds_array['odds_william_win_kelly'] = $tds[29]->data;
		// 竞彩官方-凯利指数-平
		$odds_array['odds_william_plain_kelly'] = $tds[30]->data;
		// 竞彩官方-凯利指数-负
		$odds_array['odds_william_lose_kelly'] = $tds[31]->data;
		// 竞彩官方-赔付率
		$odds_array['odds_william_ratio'] = $tds[32]->data;
		
		// 竞彩官方-最新赔率-变化趋势 1:赔率上涨 -1:赔率下跌 0:赔率不变
		$odds_array['odds_william_win_trend'] = 0;
		// 竞彩官方-最新赔率-变化趋势 1:赔率上涨 -1:赔率下跌 0:赔率不变
		$odds_array['odds_william_plain_trend'] = 0;
		// 竞彩官方-最新赔率-变化趋势 1:赔率上涨 -1:赔率下跌 0:赔率不变
		$odds_array['odds_william_lose_trend'] = 0;
		
		if(strstr($tds[22]->plaintext, "↑", false)) {
			$odds_array['odds_william_win_trend'] = 1;
		} else if(strstr($tds[22]->plaintext, "↓", false)) {
			$odds_array['odds_william_win_trend'] = - 1;
		}
		
		if(strstr($tds[23]->plaintext, "↑", false)) {
			$odds_array['odds_william_plain_trend'] = 1;
		} else if(strstr($tds[23]->plaintext, "↓", false)) {
			$odds_array['odds_william_plain_trend'] = - 1;
		}
		
		if(strstr($tds[24]->plaintext, "↑", false)) {
			$odds_array['odds_william_lose_trend'] = 1;
		} else if(strstr($tds[24]->plaintext, "↓", false)) {
			$odds_array['odds_william_lose_trend'] = - 1;
		}
		
		// 威廉希尔-初始赔率-胜
		$odds_array['odds_william_win_start'] = $tds[36]->data;
		// 威廉希尔-初始赔率-平
		$odds_array['odds_william_plain_start'] = $tds[37]->data;
		// 威廉希尔-初始赔率-负
		$odds_array['odds_william_lose_start'] = $tds[38]->data;
		// 威廉希尔-最新赔率-胜
		$odds_array['odds_william_win_latest'] = $tds[39]->data;
		// 威廉希尔-最新赔率-平
		$odds_array['odds_william_plain_latest'] = $tds[40]->data;
		// 威廉希尔-最新赔率-负
		$odds_array['odds_william_lose_latest'] = $tds[41]->data;
		// 威廉希尔-概率-胜-百分数
		$odds_array['odds_william_win_rate'] = $tds[43]->data;
		// 威廉希尔-概率-平-百分数
		$odds_array['odds_william_plain_rate'] = $tds[44]->data;
		// 威廉希尔-概率-负-百分数
		$odds_array['odds_william_lose_rate'] = $tds[45]->data;
		// 威廉希尔-凯利指数-胜
		$odds_array['odds_william_win_kelly'] = $tds[46]->data;
		// 威廉希尔-凯利指数-平
		$odds_array['odds_william_plain_kelly'] = $tds[47]->data;
		// 威廉希尔-凯利指数-负
		$odds_array['odds_william_lose_kelly'] = $tds[48]->data;
		// 威廉希尔-赔付率
		$odds_array['odds_william_ratio'] = $tds[49]->data;
		
		// 威廉希尔-最新赔率-变化趋势 1:赔率上涨 -1:赔率下跌 0:赔率不变
		$odds_array['odds_william_win_trend'] = 0;
		// 威廉希尔-最新赔率-变化趋势 1:赔率上涨 -1:赔率下跌 0:赔率不变
		$odds_array['odds_william_plain_trend'] = 0;
		// 威廉希尔-最新赔率-变化趋势 1:赔率上涨 -1:赔率下跌 0:赔率不变
		$odds_array['odds_william_lose_trend'] = 0;
		
		if(strstr($tds[39]->plaintext, "↑", false)) {
			$odds_array['odds_william_win_trend'] = 1;
		} else if(strstr($tds[39]->plaintext, "↓", false)) {
			$odds_array['odds_william_win_trend'] = - 1;
		}
		
		if(strstr($tds[40]->plaintext, "↑", false)) {
			$odds_array['odds_william_plain_trend'] = 1;
		} else if(strstr($tds[40]->plaintext, "↓", false)) {
			$odds_array['odds_william_plain_trend'] = - 1;
		}
		
		if(strstr($tds[41]->plaintext, "↑", false)) {
			$odds_array['odds_william_lose_trend'] = 1;
		} else if(strstr($tds[41]->plaintext, "↓", false)) {
			$odds_array['odds_william_lose_trend'] = - 1;
		}
		
		$otherodds_html = $parser->find('span[class=otherodds]');
		logFileAndEcho($otherodds_html);

		preg_match_all('/(\d+)\.(\d+)/is', $otherodds_html,$otherodds);
		
		//离散度-胜
		$odds_array['dispersion_win'] = $otherodds[0];
		//离散度-平
		$odds_array['dispersion_plain'] = $otherodds[1];
		//离散度-负
		$odds_array['dispersion_lose'] = $otherodds[2];
		//中足网方差-胜
		$odds_array['dispersion_win'] = $otherodds[3];
		//中足网方差-平
		$odds_array['dispersion_win'] = $otherodds[4];
		//中足网方差-负
		$odds_array['dispersion_win'] = $otherodds[5];
		
// 		logFileAndEcho($odds_array);
	}
};

$curl->get($url);
$data = $curl->execute();

exit();
?>