<?php
/**
 * Created by PhpStorm.
 * User: sunhuang
 * Date: 2017/3/5
 * Time: 13:22
 */
require '../vendor/autoload.php';
//error_reporting(0);
use DiDom\Document;
use DiDom\Query;


function WeiBoSearch($word){
    $word=urlencode($word);
    $url = "http://s.weibo.com/weibo/$word&Refer=index";

    $doc = new Document($url,true);
    if($doc->has('div')){
        $posts = $doc->find("li");
        var_dump($posts);

    }else{
        echo "wrong";
    }

}

function hotSo(){
    $url ="https://www.so.com/?src=www&fr=so.com";
    $doc=new DiDom\Document($url,true);

//    $lists = $doc->find("//ul[contains(@class, 'hotdot_list')]", DiDom\Query::TYPE_XPATH);
    $lists = $doc->find("//ul[contains(@class, 'hotdot_list')]", DiDom\Query::TYPE_XPATH);
 var_dump($lists);
}
hotSo();