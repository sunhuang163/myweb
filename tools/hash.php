<?php
/**
 * Created by PhpStorm.
 * User: sunhuang
 * Date: 2017/3/2
 * Time: 23:29
 */

$words="理解php Hash函数，增强密码安全";
$words2="1理解php Hash函数，增强密码安全";

//echo md5($words)."|".$words."\n";
//
//echo hash("crc32b",base64_encode($words))."\n";
//echo hash("crc32b",$words)."\n";

echo hash("md4",base64_encode($words))."|"."\n";
echo hash("md4",base64_encode($words2))."|"."\n";
//echo md4($words)."|".$words."\n";
//define('testtime', 50000);
//$algos = hash_algos();
//foreach($algos as $algo) {
//    $st = microtime();
//    for($i = 0; $i < testtime; $i++) {
//        hash($algo, microtime().$i);
//    }
//    $et = microtime();
//    list($ss, $si) = explode(' ', $st);
//    list($es, $ei) = explode(' ', $et);
//    $time[$algo] = $ei + $es - $si - $ss;
//}
//asort($time, SORT_NUMERIC);
//print_r($time);