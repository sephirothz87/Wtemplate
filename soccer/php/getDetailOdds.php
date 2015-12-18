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
// 		logFileAndEcho($otherodds_html);

		preg_match_all('/(\d+)\.(\d+)/is', $otherodds_html[0],$otherodds);
		
// 		logFileAndEcho($otherodds);
		
		//离散度-胜
		$odds_array['dispersion_win'] = $otherodds[0][0];
		//离散度-平
		$odds_array['dispersion_plain'] = $otherodds[0][1];
		//离散度-负
		$odds_array['dispersion_lose'] = $otherodds[0][2];
		//中足网方差-胜
		$odds_array['this_variance_win'] = $otherodds[0][3];
		//中足网方差-平
		$odds_array['this_variance_plain'] = $otherodds[0][4];
		//中足网方差-负
		$odds_array['this_variance_lose'] = $otherodds[0][5];
		
		$variance_html = $parser->find('div[class=var-ps-2]');

// 		logFileAndEcho($variance_html);


		preg_match_all('/(\d+)\.(\d+)/is', $variance_html[0],$ori_variance_win);
		
		// 初始方差-胜-最大
		$odds_array['ori_variance_win_max'] = $ori_variance_win[0][0];
		// 初始方差-胜-最小
		$odds_array['ori_variance_win_min'] = $ori_variance_win[0][1];
		// 初始方差-胜-平均
		$odds_array['ori_variance_win_ave'] = $ori_variance_win[0][2];


		preg_match_all('/(\d+)\.(\d+)/is', $variance_html[1],$ori_variance_plain);
		
		// 初始方差-平-最大
		$odds_array['ori_variance_plain_max'] = $ori_variance_plain[0][0];
		// 初始方差-平-最小
		$odds_array['ori_variance_plain_min'] = $ori_variance_plain[0][1];
		// 初始方差-平-平均
		$odds_array['ori_variance_plain_ave'] = $ori_variance_plain[0][2];


		preg_match_all('/(\d+)\.(\d+)/is', $variance_html[2],$ori_variance_lose);
		
		// 初始方差-负-最大
		$odds_array['ori_variance_lose_max'] = $ori_variance_lose[0][0];
		// 初始方差-负-最小
		$odds_array['ori_variance_lose_min'] = $ori_variance_lose[0][1];
		// 初始方差-负-平均
		$odds_array['ori_variance_lose_ave'] = $ori_variance_lose[0][2];


		preg_match_all('/(\d+)\.(\d+)/is', $variance_html[3],$latest_variance_win);
		
		// 最新方差-胜-最大
		$odds_array['latest_variance_win_max'] = $latest_variance_win[0][0];
		// 最新方差-胜-最小
		$odds_array['latest_variance_win_min'] = $latest_variance_win[0][1];
		// 最新方差-胜-平均
		$odds_array['latest_variance_win_ave'] = $latest_variance_win[0][2];


		preg_match_all('/(\d+)\.(\d+)/is', $variance_html[4],$latest_variance_plain);
		
		// 最新方差-平-最大
		$odds_array['latest_variance_plain_max'] = $latest_variance_plain[0][0];
		// 最新方差-平-最小
		$odds_array['latest_variance_plain_min'] = $latest_variance_plain[0][1];
		// 最新方差-平-平均
		$odds_array['latest_variance_plain_ave'] = $latest_variance_plain[0][2];


		preg_match_all('/(\d+)\.(\d+)/is', $variance_html[5],$latest_variance_lose);
		
		// 最新方差-负-最大
		$odds_array['latest_variance_lose_max'] = $latest_variance_lose[0][0];
		// 最新方差-负-最小
		$odds_array['latest_variance_lose_min'] = $latest_variance_lose[0][1];
		// 最新方差-负-平均
		$odds_array['latest_variance_lose_ave'] = $latest_variance_lose[0][2];
		
		logFileAndEcho($odds_array);
	}
};

$curl->get($url);
$data = $curl->execute();

exit();
?>