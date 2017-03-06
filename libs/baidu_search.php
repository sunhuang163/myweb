<?php
$url = "http://m.baidu.com/s?wd=生命动力";
// 构造包头，模拟浏览器请求
$header = array (
        "Host:www.baidu.com",
        "Content-Type:application/x-www-form-urlencoded",//post请求
        "Connection: keep-alive",
        'Referer:http://www.baidu.com',
        'User-Agent: Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; BIDUBrowser 2.6)'
);
$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, $url );
curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
// 执行
$content = curl_exec ( $ch );
if ($content == FALSE) {
    echo "error:" . curl_error ( $ch );
}
// 关闭
curl_close ( $ch );
 
//输出结果
echo $content;
?>