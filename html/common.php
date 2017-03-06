<?php
/**
 * Created by PhpStorm.
 * User: sunhuang
 * Date: 2017/3/3
 * Time: 17:39
 */
require '../vendor/autoload.php';
$ciku_files = array(
    'soso',
    'baidu',
    'bing'

);
//获取随机词库的内容
function getWords($agent, $ciku_files,$num=10)
{
    $ciku_exclude = array();
    foreach ($ciku_files as $ciku) {
        if ($ciku != $agent) {
            array_push($ciku_exclude, $ciku);
        }
    }
    $key = array_rand($ciku_exclude);
    $file_name = $ciku_exclude[$key];
    $file = "../ciku/" . $file_name . ".txt";
    $arr = file($file);
    $cilist = array();
    $n = count($arr) - 1;
    for ($i = 1; $i <= $num; $i++) {
        $x = rand(0, $n);

        $w = trim($arr[$x]);
        if(strlen($w)>=3){
            array_push($cilist, $w);
        }

    }
    return $cilist;
}

//读取本地域名列表
function getDomains($filename)
{
    $lines = file($filename);
    $domains = array();
    foreach ($lines as $line) {
        $line = strtolower(trim($line));
        array_push($domains, $line);
    }
    return $domains;
}

//获取本站域名 3个
function getExcludeDomain($domain, $domains)
{
    $key = array_search($domain, $domains);
    array_splice($domains, $key, 1);
    return $domains;
}

//获取外链域名 2个

function getForeigndomain($foreign_domains)
{
    $lines = file($foreign_domains);
    $domains = array();
    foreach ($lines as $line) {
        $line = strtolower(trim($line));
        array_push($domains, $line);
    }
    return $domains;
}



function verySpider()
{
    $tmp = strtolower($_SERVER['HTTP_USER_AGENT']);
//    echo $tmp;
    if (strpos($tmp, 'googlebot') !== false) {
        return "google";
    } else if (strpos($tmp, 'baidu')!==false) {
        return "baidu";
    } else if (strpos($tmp, 'sosospider') !== false) {
        return "soso";
    }else if (strpos($tmp, '360') !== false) {
        return "soso";
    }
    else if (strpos($tmp, 'bingbot') !== false) {
        return "bing";
    }else{
        return "other";
    }
}
function isCrawler() {
    $agent= strtolower($_SERVER['HTTP_USER_AGENT']);
    if (!empty($agent)) {
        $spiderSite= array(
            "TencentTraveler",
            "Baiduspider",
            "BaiduGame",
            "Googlebot",
            "msnbot",
            "Sosospider+",
            "Sogou web spider",
            "ia_archiver",
            "Yahoo! Slurp",
            "YoudaoBot",
            "Yahoo Slurp",
            "MSNBot",
            "Java (Often spam bot)",
            "BaiDuSpider",
            "Voila",
            "Yandex bot",
            "BSpider",
            "twiceler",
            "Sogou Spider",
            "Speedy Spider",
            "Google AdSense",
            "Heritrix",
            "Python-urllib",
            "Alexa (IA Archiver)",
            "Ask",
            "Exabot",
            "Custo",
            "OutfoxBot/YodaoBot",
            "yacy",
            "SurveyBot",
            "legs",
            "lwp-trivial",
            "Nutch",
            "StackRambler",
            "The web archive (IA Archiver)",
            "Perl tool",
            "MJ12bot",
            "Netcraft",
            "MSIECrawler",
            "WGet tools",
            "larbin",
            "Fish search",
            "360",
            "baidu",
            "bingbot",
            "360Spider"
        );
        foreach($spiderSite as $val) {
            $str = strtolower($val);
            if (strpos($agent, $str) !== false) {
                return true;
            }
        }
    } else {
        return false;
    }
}

function verifyRefer(){
    $refer=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;
    if($refer!=null){
        if (strpos($refer, 'google.com') !== false) {
            return "google";
        } else if (strpos($refer, 'baidu.com')!==false) {
            return "baidu";
        } else if (strpos($refer, 'so.com') !== false) {
            return "360";
        }else if (strpos($refer, 'bing.com') !== false) {
            return "bing";
        }else{
            return "others.txt";
        }
    }else{
        return "others.txt";
    }


}

function isMobile(){
    $useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';
    function CheckSubstrs($substrs,$text){
        foreach($substrs as $substr)
            if(false!==strpos($text,$substr)){
                return true;
            }
        return false;
    }
    $mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');
    $mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');

    $found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||
        CheckSubstrs($mobile_token_list,$useragent);

    if ($found_mobile){
        return true;
    }else{
        return false;
    }
}

function GetGB2312String($name)
{
    $tostr = "";
    for($i=0;$i<strlen($name);$i++)
    {
        $curbin = ord(substr($name,$i,1));
        if($curbin < 0x80)
        {
            $tostr .= substr($name,$i,1);
        }elseif($curbin < bindec("11000000")){
            $str = substr($name,$i,1);
            $tostr .= "&#".ord($str).";";
        }elseif($curbin < bindec("11100000")){
            $str = substr($name,$i,2);
            $tostr .= "&#".GetUnicodeChar($str).";";
            $i += 1;
        }elseif($curbin < bindec("11110000")){
            $str = substr($name,$i,3);
            $gstr= iconv("UTF-8","GB2312",$str);
            if(!$gstr)
            {
                $tostr .= "&#".GetUnicodeChar($str).";";
            }else{
                $tostr .= $gstr;
            }
            $i += 2;
        }elseif($curbin < bindec("11111000")){
            $str = substr($name,$i,4);
            $tostr .= "&#".GetUnicodeChar($str).";";

            $i += 3;
        }elseif($curbin < bindec("11111100")){
            $str = substr($name,$i,5);
            $tostr .= "&#".GetUnicodeChar($str).";";

            $i += 4;
        }else{
            $str = substr($name,$i,6);
            $tostr .= "&#".GetUnicodeChar($str).";";

            $i += 5;
        }
    }

    return $tostr;
}//end function
function GetUnicodeChar($str)
{
    $temp = "";
    for($i=0;$i<strlen($str);$i++)
    {
        $x = decbin(ord(substr($str,$i,1)));
        if($i == 0)
        {
            $s = strlen($str)+1;
            $temp .= substr($x,$s,8-$s);
        }else{
            $temp .= substr($x,2,6);
        }
    }
    return bindec($temp);
}

function   get_utf8_to_gb($value){
    $value_1= $value;
    $value_2   =   @iconv( "utf-8", "gb2312//IGNORE",$value_1);//使用@抵制错误，如果转换字符串中，某一个字符在目标字符集里没有对应字符，那么，这个字符之后的部分就被忽略掉了；即结果字符串内容不完整，此时要使用//IGNORE
    $value_3   =   @iconv( "gb2312", "utf-8//IGNORE",$value_2);

    if   (strlen($value_1)   ==   strlen($value_3))
    {
        return   $value_2;
    }else
    {
        return   $value_1;
    }

}

//随机数组
function uni($array,$nums,$unique=true){

    $newarray=array();
    if((bool)$unique){
        $array=array_unique($array);// 移除数组中重复的值，并且返回数组。
    }
    if(shuffle($array)){// return bool
        for ($i=0; $i <count($array) ; $i++) {
            $newarray[]=$array[$i];
        }
    }
    return $newarray;

}

//存取关键字到对应的文件
function saveWord($spier,$arr){

}

//移除数组
function removeArray($array,$words){
    $arr=array();
    foreach ($array as $item) {
        if($item !==$words){
            array_push($arr,$item);
        }
    }
    return $arr;

}

