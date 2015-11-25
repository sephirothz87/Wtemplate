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
        $res = $parser -> find('table');
        $touzhus = $parser -> find('div[class=touzhu]');
        // myPrint("touzhus");
        // myPrint($touzhus);

        //方法1:逐个child取
        for($i=0;$i<10;$i+=2){
$match = $touzhus[0] -> children($i);
        // myPrint("match");
        // myPrint($match);    

        // $parser -> load($day_index_div);

        // $day_index = $parser->find('span[class=xulie]');
        $day_index = $match -> children(0)->children(0)->plaintext;
        // myPrint("day_index");
        // myPrint($day_index);

        $res['day_index'] = $day_index;

        $league_name = $match -> children(0)->children(1)->title;
        // myPrint("league_name");
        // myPrint($league_name);

        $res['league_name'] = $league_name;

        // $parser -> load($match -> children(0)->children(2));
        $match_time = substr($match -> children(0)->children(2)->title,9);
        // myPrint("match_time");
        // myPrint($match_time);

        $res['match_time'] = $match_time;

        // $p_2 = new simple_html_dom();
        // $p_2->load($match);
        // $teams = $p_2->find('.zhum');

        $parser = new simple_html_dom();
        $parser->load($match);
        $teams = $parser->find('.zhum');

        $home_team = $teams[0]->title;
        $guest_team = $teams[1]->title;
        $home_team_short = $teams[0]->plaintext;
        $guest_team_short = $teams[1]->plaintext;

        // myPrint("home_team");
        // myPrint($home_team);
        // myPrint("guest_team");
        // myPrint($guest_team);
        // myPrint("home_team_short");
        // myPrint($home_team_short);
        // myPrint("guest_team_short");
        // myPrint($guest_team_short);

        $res['home_team'] = $home_team;
        $res['guest_team'] = $guest_team;
        $res['home_team_short'] = $home_team_short;
        $res['guest_team_short'] = $guest_team_short;

        $odds = $parser->find('.peilv');

        // myPrint("odds");
        // myPrint($odds);

        $odd_home_win = trim($odds[0]->plaintext);
        $odd_home_plain = trim($odds[1]->plaintext);
        $odd_home_lose = trim($odds[2]->plaintext);
        $odd_home_concede_win = trim($odds[3]->plaintext);
        $odd_home_concede_plain = trim($odds[4]->plaintext);
        $odd_home_concede_lose = trim($odds[5]->plaintext);

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

        $res['odd_home_win'] = $odd_home_win;
        $res['odd_home_plain'] = $odd_home_plain;
        $res['odd_home_lose'] = $odd_home_lose;
        $res['odd_home_concede_win'] = $odd_home_concede_win;
        $res['odd_home_concede_plain'] = $odd_home_concede_plain;
        $res['odd_home_concede_lose'] = $odd_home_concede_lose;

        $concede_html = $parser->find('.rangqiu');

        if($parser->find('.rangqiu')){
            myPrint("if");
            $concede_html = $parser->find('.rangqiu');
            $concede = trim($concede_html[0]->plaintext);
        }else if($parser->find('.rangqiuzhen')){
            myPrint("else if");
            $concede_html = $parser->find('.rangqiuzhen');
            $concede = trim($concede_html[0]->plaintext);
        }else{
            myPrint("else");
            $concede_html = array();
            $concede = 0;
        }

        // myPrint("concede_html");
        // myPrint($concede_html);

        // myPrint("concede");
        // myPrint($concede);

        $res['concede'] = $concede;

        $score_html = $parser->find('p[class=p1]');

        $score = $score_html[0]->plaintext;

        // myPrint("score");
        // myPrint($score);

        $goals = explode(":",$score);

        // myPrint("goals");
        // myPrint($goals);

        $home_goal = $goals[0];
        $guest_goal = $goals[1];

        $res['score'] = $score;
        $res['home_goal'] = $home_goal;
        $res['guest_goal'] = $guest_goal;

        $result = -1;
        if($home_goal>$guest_goal){
            $result = 3;
        }else if($home_goal<$guest_goal){
            $result = 0;
        }else if($home_goal==$guest_goal){
            $result = 1;
        }

        $result_concede = -1;
        if($home_goal+$concede>$guest_goal){
            $result_concede = 3;
        }else if($home_goal+$concede<$guest_goal){
            $result_concede = 0;
        }else if($home_goal+$concede==$guest_goal){
            $result_concede = 1;
        }

        // myPrint("result");
        // myPrint($result);
        // myPrint("result_concede");
        // myPrint($result_concede);

        $res['result'] = $result;
        $res['result_concede'] = $result_concede;

        //方法2 直接取出所有的数组
        // $day_indexs = $parser->find('span[class=xulie]');

        // foreach ($day_indexs as $key => $val ){
        //     // $str = "key = ".$key." value = ".$val;
        //     // fwrite(fopen( "log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]"  . $str . "\n" );

        //     $day_index = $val->plaintext;
        //     fwrite(fopen( "log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]"  . $day_index . "\n" );
        // }

        // $home_teams = $parser->find('.zhum');

        // foreach ($home_teams as $key => $val ){
        //     // $str = "key = ".$key." value = ".$val;
        //     // fwrite(fopen( "log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]"  . $str . "\n" );

        //     $team = $val->title;
        //     fwrite(fopen( "log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]"  . $team . "\n" );
        // }

        // myPrint("home_team");
        // myPrint($home_team);

        myPrint("res");
        myPrint($res);
        }
        
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

            // $str = "[key]".$key."\n[value]".$val."\n";
            fwrite(fopen( "log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]"  . "[key]".$key . "\n" );
            fwrite(fopen( "log.txt" , "a" ), "[" . date('Y-m-d H:i:s' , time() + 60 * 60 * 6) . "]"  . "[value]".$val . "\n" );
        }
    }
}

?>