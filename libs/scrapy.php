<?php
 function search_word_from() {
    $referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
    if(strstr( $referer, 'baidu.com')){ //百度
        preg_match( "|baidu.+wo?r?d=([^\\&]*)|is", $referer, $tmp );
        $keyword = urldecode( $tmp[1] );
        $from = 'baidu';
    }elseif(strstr( $referer, 'google.com') or strstr( $referer, 'google.cn')){ //谷歌
        preg_match( "|google.+q=([^\\&]*)|is", $referer, $tmp );
        $keyword = urldecode( $tmp[1] );
        $from = 'google';
    }elseif(strstr( $referer, 'so.com')){ //360搜索
        preg_match( "|so.+q=([^\\&]*)|is", $referer, $tmp );
        $keyword = urldecode( $tmp[1] );
        $from = '360'; 
    }elseif(strstr( $referer, 'sogou.com')){ //搜狗
        preg_match( "|sogou.com.+query=([^\\&]*)|is", $referer, $tmp );
        $keyword = urldecode( $tmp[1] );
        $from = 'sogou';   
    }elseif(strstr( $referer, 'soso.com')){ //搜搜
        preg_match( "|soso.com.+w=([^\\&]*)|is", $referer, $tmp );
        $keyword = urldecode( $tmp[1] );
        $from = 'soso';
    }else {
        $keyword ='';
        $from = '';
    }
 
    return array('keyword'=>$keyword,'from'=>$from);
}
 
//以下为测试
//在搜索引擎搜索个关键词，进入网站

//厦门php培训：http://www.xmzxzh.cn/
$word = search_word_from();
if(!empty($word['keyword'])){
    echo '关键字：'.$word['keyword'].' 来自：'.$word['from'];
}
?>