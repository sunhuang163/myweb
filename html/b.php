<?php
/**
 * Created by PhpStorm.
 * User: sunhuang
 * Date: 2017/3/3
 * Time: 0:10
 * Description: 从百度来的搜索或蜘蛛流量
 */
include "common.php";
use Jenssegers\Blade\Blade;
$domains=getDomains("../config/domains.txt");
$domain=$_SERVER['HTTP_HOST'];
include "search.php";
if (in_array($domain,$domains)){
    $ch=$_GET['id'];
    $reffer =$_GET['c'];
    $word=urldecode(base64_decode($ch));
    if (isCrawler()){
        $spider =verySpider();
        switch ($spider){
            case "baidu":
                $cs = getWords('baidu', $ciku_files);
                break;
            case "360":
                $cs = getWords('360', $ciku_files);
                break;
            case "bing":
                $cs = getWords('bing', $ciku_files);
                break;
            case "other";
                $cs = getWords('360', $ciku_files);
                break;
        }
        $related_words=getWords('baidu', $ciku_files);

    }else{
        $refer=verifyRefer();
        if(isMobile()){
            $blade = new Blade('../views', '../caches');
            echo $blade->make('mobile', ['title' =>$domain, 'contents' => $cs]);
        }else{
            $blade = new Blade('../views/p', '../caches');
        }

        $page =rand(5,10);
        $ws=soso($word,$page);

        $ds=$domains;
        $exclude_domain=removeArray($domains,$domain);
        header("Content-type:text/html;charset=gb2312");
        echo $blade->make('show', ['title' =>$word, 'ws' => $ws,'refer'=>$refer,'domain'=>$domain,'excludedomain'=>$exclude_domain,'ciku'=>$ciku_files]);

    }
}else{

}






//include "common.php";
//use Jenssegers\Blade\Blade;
//$blade = new Blade('views', 'caches');
//include "../config/search.php";


//$w=iconv("utf-8","gb2312//IGNORE",$word);
//$str=so360($word,6);
//var_dump($str);
//header("Content-type:text/html;charset=gb2312");
//echo $blade->make('subpage', ['title' =>$w, 'contents' => $str]);