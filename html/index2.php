<?php


include "common.php";
use Jenssegers\Blade\Blade;

$domains=getDomains("../config/domains.txt");
$domain=$_SERVER['HTTP_HOST'];


if (in_array($domain,$domains)){
    if (isCrawler()){
        $spider =verySpider();
        switch ($spider){
            case "baidu":
                $cs = getWords('baidu', $ciku_files);
                break;
            case "soso":
                $cs = getWords('soso', $ciku_files);
                break;
            case "bing":
                $cs = getWords('bing', $ciku_files);
                break;
            case "other";
                $cs = getWords('soso', $ciku_files);
                break;
        }

    }else{
        $refer=verifyRefer();
        $cs = getWords($refer, $ciku_files);
        $links =array();
        if(isMobile()){
            $blade = new Blade('../views', '../caches');
            header("Content-type:text/html;charset=gb2312");
            echo $blade->make('mobile', ['title' =>$domain, 'contents' => $cs]);

        }else{
            $blade = new Blade('../views', '../caches');
            header("Content-type:text/html;charset=gb2312");
            echo $blade->make('pc', ['title' =>$domain, 'contents' => $cs]);

        }

    }
}else{

}
