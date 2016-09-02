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

myPrint ( "start" );
// echo "start";

$html;

// 经过测试，家里的电脑中一切正常，公司机器挂掉怀疑是PHP版本或者是配置的问题

// 正确
// static $mDate = "2016-01-04";
// 异常，怀疑是场数太多导致内存溢出之类的问题，日志每次到指定位置就会停止 83场
// static $mDate = "2014-11-22";
// 异常，但是日志显示正确结束了，应该是结束之后发生的异常 81场
// static $mDate = "2015-11-21";
// TODO 这一天有特殊情况，就是把11月8号的前几场比赛也加入到了这一页，需要再做一个check
// 104场 挂在67
// static $mDate = "2015-11-09";
// 76场 over之后挂 家里的电脑运行正常
// static $mDate = "2015-11-08";

$mDate = $_REQUEST['date'];
$resultCsvPath = "result\\tmp.csv";

$mResArray = array ();

$url = "http://www.okooo.com/jingcai/" . $mDate;
$url_zg = "http://cp.zgzcw.com/lottery/jchtplayvsForJsp.action?lotteryId=47&type=jcmini&issue=" . $mDate;
$url_zg_od_1 = "http://fenxi.zgzcw.com/";
$url_zg_od_2 = "/bjop";

$curl = new rolling_curl ();
$curl->set_gzip ( true );
$curl->callback = function ($response, $info, $request, $error) {
	
	// myPrint($response);
	
	if (empty ( $response )) {
		myPrint ( "empty response" );
	} else {
		global $mResArray;
		
		global $mDate;
		
		global $resultCsvPath;
		
		$last_index = 0;
		
		$html = $response;
		
		// DEBUG response的页面
		// myPrint($html);
		// return;
		
		// myPrint($response);
		$parser = new simple_html_dom ();
		$parser->load ( $html );
		// $res = $parser->find('table');
		$touzhus = $parser->find ( 'div[class=touzhu]' );
		// myPrint("touzhus");
		// myPrint($touzhus);
		
		// $parser->clear();
		
		// 方法1:逐个child取
		foreach ( $touzhus as $key => $touzhu ) {
			
			$p_2 = new simple_html_dom ();
			$p_2->load ( $touzhu );
			$matchs = $p_2->find ( 'div[class=touzhu_1]' );
			
			myPrint ( "count(matchs)" );
			myPrint ( count ( $matchs ) );
			
			// $p_2->clear();
			
			// $parser = new simple_html_dom();
			// $parser->load($touzhu);
			// $matchs = $parser->find('div[class=touzhu_1]');
			
			// myPrint("count(matchs)");
			// myPrint(count($matchs));
			
			// $parser->clear();
			
			foreach ( $matchs as $key => $match ) {
				
				$res = array ();
				// 期数日期
				$res ['date'] = $mDate;
				// 比赛结果是否有效
				$res ['able'] = true;
				// 销售是否正常
				$res ['normal'] = true;
				// 让球销售是否正常
				$res ['normal_concede'] = true;
				// 销售状态
				$res ['status'] = "normal";
				// 让球销售状态
				$res ['status_concede'] = "normal";
				// 其他信息备考
				$res ['info'] = "info";
				
				// for($i = 0; $i < 5; $i ++) {
				// $match = $touzhus[0]->children($i);
				// $match = $matchs[$i];
				// myPrint("match");
				// myPrint($match);
				
				// $parser -> load($day_index_div);
				
				// $day_index = $parser->find('span[class=xulie]');
				$day_index = $match->children ( 0 )->children ( 0 )->plaintext;
				
				// 不知道这里为什么要加入这个跳出的逻辑，因为页面的排序不一定是按顺序排下来的，所以这里先注释掉，否则无法做出完整的数据
				// if ($day_index < $last_index) {
				// 	myPrint ( "break" );
				// 	break;
				// }

				$last_index = $day_index;
				// myPrint("day_index");
				// myPrint($day_index);
				
				// 当日的比赛编号
				$res ['day_index'] = $day_index;
				
				$league_name = $match->children ( 0 )->children ( 1 )->title;
				// myPrint("league_name");
				// myPrint($league_name);
				
				// 赛事名称
				$res ['league_name'] = $league_name;
				
				// $parser -> load($match -> children(0)->children(2));
				$match_time = substr ( $match->children ( 0 )->children ( 2 )->title, 9 );
				// myPrint("match_time");
				// myPrint($match_time);
				
				// 比赛实际开始的时间
				$res ['match_time'] = $match_time;
				
				// $p_2 = new simple_html_dom();
				// $p_2->load($match);
				// $teams = $p_2->find('.zhum');
				
				$p_3 = new simple_html_dom ();
				$p_3->load ( $match );
				$teams = $p_3->find ( '.zhum' );
				
				$home_team = $teams [0]->title;
				$guest_team = $teams [1]->title;
				$home_team_short = $teams [0]->plaintext;
				$guest_team_short = $teams [1]->plaintext;
				
				// myPrint("home_team");
				// myPrint($home_team);
				// myPrint("guest_team");
				// myPrint($guest_team);
				// myPrint("home_team_short");
				// myPrint($home_team_short);
				// myPrint("guest_team_short");
				// myPrint($guest_team_short);
				
				// 主队名称
				$res ['home_team'] = $home_team;
				// 客队名称
				$res ['guest_team'] = $guest_team;
				// 主队名称简写
				$res ['home_team_short'] = $home_team_short;
				// 客队名称简写
				$res ['guest_team_short'] = $guest_team_short;
				
				$normal = $p_3->find ( '.spfweik_1' );
				if ($normal) {
					// myPrint("normal");
					// myPrint($normal);
					$res ['normal'] = false;
					$res ['status'] = $normal [0]->plaintext;
				}
				
				$normal_concede = $p_3->find ( '.rangno' );
				if ($normal_concede) {
					// myPrint("normal_concede");
					// myPrint($normal_concede);
					$res ['normal_concede'] = false;
					$res ['status_concede'] = $normal_concede [0]->children ( 0 )->plaintext;
				}
				
				$odds = $p_3->find ( '.peilv' );
				
				// myPrint("odds");
				// myPrint($odds);
				
				if (count ( $odds ) <= 3) {
					$odd_home_concede_win = "0.00";
					$odd_home_concede_plain = "0.00";
					$odd_home_concede_lose = "0.00";
					$res ['normal'] = false;
				} else {
					$odd_home_concede_win = trim ( $odds [3]->plaintext );
					$odd_home_concede_plain = trim ( $odds [4]->plaintext );
					$odd_home_concede_lose = trim ( $odds [5]->plaintext );
				}
				
				$odd_home_win = trim ( $odds [0]->plaintext );
				$odd_home_plain = trim ( $odds [1]->plaintext );
				$odd_home_lose = trim ( $odds [2]->plaintext );
				
				// myPrint("odd_home_win");
				// myPrint($odd_home_win);
				// myPrint("odd_home_plain");
				// myPrint($odd_home_plain);
				// myPrint("odd_home_lose");
				// myPrint($odd_home_lose);
				// myPrint("odd_home_concede_win");
				// myPrint($odd_home_concede_win);
				// myPrint("odd_home_concede_plain");
				// myPrint($odd_home_concede_plain);
				// myPrint("odd_home_concede_lose");
				// myPrint($odd_home_concede_lose);
				
				// 主胜赔率
				$res ['odd_home_win'] = $odd_home_win;
				// 主平赔率
				$res ['odd_home_plain'] = $odd_home_plain;
				// 主负赔率
				$res ['odd_home_lose'] = $odd_home_lose;
				// 让球主胜赔率
				$res ['odd_home_concede_win'] = $odd_home_concede_win;
				// 让球主平赔率
				$res ['odd_home_concede_plain'] = $odd_home_concede_plain;
				// 让球主负赔率
				$res ['odd_home_concede_lose'] = $odd_home_concede_lose;
				
				$concede_html = $p_3->find ( '.rangqiu' );
				
				if ($p_3->find ( '.rangqiu' )) {
					// myPrint("if");
					$concede_html = $p_3->find ( '.rangqiu' );
					$concede = trim ( $concede_html [0]->plaintext );
				} else if ($p_3->find ( '.rangqiuzhen' )) {
					// myPrint("else if");
					$concede_html = $p_3->find ( '.rangqiuzhen' );
					$concede = trim ( $concede_html [0]->plaintext );
				} else {
					// myPrint("else");
					$concede_html = array ();
					$concede = 0;
				}
				
				// myPrint("concede_html");
				// myPrint($concede_html);
				
				// myPrint("concede");
				// myPrint($concede);
				
				// 让球数
				$res ['concede'] = $concede;
				
				$score_html = $p_3->find ( 'div[class=more_bg]' );
				
				$score = $score_html [0]->children ( 0 )->plaintext;
				
				// myPrint("score");
				// myPrint($score);
				
				$goals = explode ( ":", $score );
				
				// myPrint("goals");
				// myPrint($goals);
				
				$home_goal = $goals [0];
				$guest_goal = $goals [1];
				
				// 比分文本
				$res ['score'] = $score;
				// 主队进球数
				$res ['home_goal'] = $home_goal;
				// 客队进球数
				$res ['guest_goal'] = $guest_goal;
				
				$result = - 1;
				if ($home_goal > $guest_goal) {
					$result = 3;
				} else if ($home_goal < $guest_goal) {
					$result = 0;
				} else if ($home_goal == $guest_goal) {
					$result = 1;
				}
				
				$result_concede = - 1;
				if ($home_goal + $concede > $guest_goal) {
					$result_concede = 3;
				} else if ($home_goal + $concede < $guest_goal) {
					$result_concede = 0;
				} else if ($home_goal + $concede == $guest_goal) {
					$result_concede = 1;
				}
				
				// myPrint("result");
				// myPrint($result);
				// myPrint("result_concede");
				// myPrint($result_concede);
				
				// 赛果310
				$res ['result'] = $result;
				// 让球赛果310
				$res ['result_concede'] = $result_concede;
				
				// 方法2 直接取出所有的数组
				// $day_indexs = $parser->find('span[class=xulie]');
				
				// foreach ($day_indexs as $key => $val ){
				// // $str = "key = ".$key." value = ".$val;
				// // fwrite(fopen( "log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]" . $str . "\n" );
				
				// $day_index = $val->plaintext;
				// fwrite(fopen( "log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]" . $day_index . "\n" );
				// }
				
				// $home_teams = $parser->find('.zhum');
				
				// foreach ($home_teams as $key => $val ){
				// // $str = "key = ".$key." value = ".$val;
				// // fwrite(fopen( "log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]" . $str . "\n" );
				
				// $team = $val->title;
				// fwrite(fopen( "log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]" . $team . "\n" );
				// }
				
				// myPrint("home_team");
				// myPrint($home_team);
				
				// if($key == 4) {
				// myPrint("res");
				// myPrint($res);
				// }
				
				array_push ( $mResArray, $res );
				
				$p_3->clear ();
			}
		}
		
		myPrint ( count ( $mResArray ) );

		//TODO 因故延期，取消，停售的场次很多，手动筛选很复杂，暂定方案是用程序筛选数据后写入另一个CSV中作为原始纯净数据保存
		
		//在这里向csv文件中写入结果
		foreach ( $mResArray as $key => $val ) {
			
			$str_to_write = "";
			foreach ( $val as $key => $val ) {
				$str_to_write = $str_to_write . $val . ",";
			}
			$str_to_write = $str_to_write . "\n";
			fwrite ( fopen ( $resultCsvPath, "a" ), $str_to_write );
		}

		// myPrint ($mResArray);
		// getDetailOdds ();
		myPrint ( "over" );
		// echo "over";
	}
};

$curl->get ( $url );
$data = $curl->execute ();
function getDetailOdds() {
	myPrint ( "getDetailOdds start" );
	$curl_zg = new rolling_curl ();
	$curl_zg->set_gzip ( true );
	
	$curl_zg->callback = function ($response, $info, $request, $error) {
		myPrint ( "getDetailOdds callback start" );
		global $mResArray;
		// myPrint ( $response );
		$parser = new simple_html_dom ();
		$parser->load ( $response );
		$zg_ids_html = $parser->find ( 'td[class=wh-10]' );
		// myPrint ( $zg_ids_html );
		foreach ( $zg_ids_html as $key => $zg_id_html ) {
			$zg_id = $zg_id_html->newplayid;
			// myPrint ( $zg_id );
			$mResArray [$key] ['zg_id'] = $zg_id;
			// $curl_odds = new rolling_curl ();
			// $curl_odds->set_gzip ( true );
			// $curl_odds->callback = function ($response, $info, $request, $error) {
			// myPrint ( "getDetailOdds 2 callback start" );
			
			// global $mResArray;
			// myPrint ( $response );
			// // $parser = new simple_html_dom ();
			// // $parser->load ( $response );
			// myPrint ( "getDetailOdds 2 callback over" );
			// };
			// global $url_zg_od_1;
			// global $url_zg_od_2;
			// $url_odd = $url_zg_od_1 . $zg_id . $url_zg_od_2;
			// $curl_odds->get ( $url_odd );
			// $data_zg_2 = $curl_odds->execute ();
		}
		// myPrint ( $mResArray );
		
		//在这里向csv文件中写入结果
		// foreach ( $mResArray as $key => $val ) {
			
		// 	$str_to_write = "";
		// 	foreach ( $val as $key => $val ) {
		// 		$str_to_write = $str_to_write . $val . ",";
		// 	}
		// 	$str_to_write = $str_to_write . "\n";
		// 	fwrite ( fopen ( "result\\2015-11-29-00653-test.csv", "a" ), $str_to_write );
		// }
		
		myPrint ( "getDetailOdds callback over" );
	};
	
	global $url_zg;
	$curl_zg->get ( $url_zg );
	$data_zg = $curl_zg->execute ();
}

function getPageText($pageUrl){
	$curl = new rolling_curl ();
	$curl->set_gzip ( true );
	$curl->callback = function ($response, $info, $request, $error) {
	};
}

exit ();
function myPrint($arr) {
	if (! is_array ( $arr )) {
		echo $arr . '<br/>';
		fwrite ( fopen ( "log.txt", "a" ), "[" . date ( 'Y-m-d H:i:s', time () + 60 * 60 * 6 ) . "]" . $arr . "\n" );
		
		// return false;
		return;
	}
	
	foreach ( $arr as $key => $val ) {
		if (is_array ( $val )) {
			// $str = "key = " . $key . " value = " . $val;
			myPrint ( $val );
		} else {
			echo $val . '<br/>';
			
			// $str = "[key]".$key."\n[value]".$val."\n";
			fwrite ( fopen ( "log.txt", "a" ), "[" . date ( 'Y-m-d H:i:s', time () + 60 * 60 * 6 ) . "]" . "[key]" . $key . "\n" );
			fwrite ( fopen ( "log.txt", "a" ), "[" . date ( 'Y-m-d H:i:s', time () + 60 * 60 * 6 ) . "]" . "[value]" . $val . "\n" );
		}
	}
}

?>