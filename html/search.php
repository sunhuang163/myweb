<?php

require '../vendor/autoload.php';
error_reporting(0);
use duzun\hQuery;

hQuery::$cache_path = "../../cache";
function baidu($word, $page)
{
    $page = $page * 10;
    $url = "http://www.baidu.com/s?wd=$word&pn=$page";
    $header = array(
        'User-Agent: Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36'
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $content = curl_exec($ch);
    if ($content == FALSE) {
        curl_close($ch);
        return null;
    } else {


        $doc = hQuery::fromHTML($content);
        $cont['charset'] = $doc->charset;
        $cont['keywords'] = [];
        $cont['contents'] = [];
        $keywords = $doc->find('div#rs>table>tr>th>a');
        $contents = $doc->find('div.c-abstract');
        foreach ($keywords as $keyword) {
            array_push($cont['keywords'], $keyword->text());
        }
        foreach ($contents as $c) {
            array_push($cont['contents'], $c->text());
        }
        curl_close($ch);
        return $cont;
    }
}

function soso($word, $page)
{
    $url = "https://www.so.com/s?q=$word&pn=$page";
    $header = array(
        'User-Agent: Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36'
    );
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $content = curl_exec($ch);
    if ($content == FALSE) {
        curl_close($ch);
        return null;
    } else {
        $doc = hQuery::fromHTML($content);
        $keywords = $doc->find('div#rs>table>tr>th');
        $lists = $doc->find("li.res-list>p.res-desc");
        $recommds=$doc->find('div.res-comm-con');
        $cont['charset'] = $doc->charset;
        $cont['keywords'] = [];
        $cont['contents'] = [];
        foreach ($keywords as $keyword) {
            array_push($cont['keywords'], $keyword->text());
        }
        foreach ($lists as $list) {
            $juzi = explode("..", $list->text())[0];
            array_push($cont['contents'], $juzi);
        }
        foreach ($recommds as $res){
            $juzi = explode("..", $res->text())[0];
            array_push($cont['contents'], $juzi);
        }
        curl_close($ch);
        return $cont;
    }
}



function BaiduSuggestion($word, $mode)
{
    //Mode 1，2，3
    //3关联性最强
    //2相关词搜索
    //1.数据库检索
    $url = "http://suggestion.baidu.com/su?sugmode=$mode&action=opensearch&ie=UTF-8&wd=$word";
    $doc = file_get_contents($url);
    $jsonsuggestion = json_decode($doc);
    $str = array();
    for ($i = 0; $i <= count($jsonsuggestion[1]) - 1; $i++) {
        $s = $jsonsuggestion[1][$i] . "\n";
        array_push($str, $s);
    }
    return $str;
}


//$str=BaiduSuggestion($word,3);
//foreach ($str as $s){
//    $url=base64_encode($s);
//    echo "<a href=/b/".$url.".html>".$s."</a>\n";
//}
//file_put_contents("1.txt",$str,FILE_APPEND);


function bing($word, $page)
{
    $page = $page * 10;
    $url = "http://cn.bing.com/search?q=$word&qs=n&sp=-1&pq=%E4%BD%A0%E5%A5%BD&first=$page";


    $doc = hQuery::fromUrl($url, ['Accept' => 'text/html,application/xhtml+xml;q=0.9,*/*;q=0.8']);
    $cont['charset'] = $doc->charset;
//    $doc=file_get_contents($url);
//    echo $doc;
    $cont['keywords'] = [];
    $cont['contents'] = [];
    $replated = $doc->find("div.b_vlist2col>ul");
    var_dump($replated);
    //    foreach ($replated as $rel){
//        echo $rel->find("li>a")->text();
//    }
}

function getSearchResult($site, $str, $page)
{
    $header = array(
        'User-Agent: Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36'
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 执行
    $content = curl_exec($ch);
    if ($content == FALSE) {
        echo "error:" . curl_error($ch);
    }
// 关闭
    curl_close($ch);

}


