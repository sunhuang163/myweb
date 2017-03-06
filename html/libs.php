<?php
/**
 * Created by PhpStorm.
 * User: sunhuang
 * Date: 2017/3/5
 * Time: 11:19
 */

require '../vendor/autoload.php';
error_reporting(0);
use duzun\hQuery;

hQuery::$cache_path = "../../cache";
function getDomains($filename)
{
    /*
     * 获取本地/外链域名列表
     */
    $lines = file($filename);
    $domains = array();
    foreach ($lines as $line) {
        $line = strtolower(trim($line));

        array_push($domains, $line);
        array_push($domains, "www.".$line);
        array_push($domains, "m.".$line);
    }
    return $domains;
}
/*
 * 检查有效域名，返回 True or False
 */
function verifyDomain($domain,$domains){
    if (in_array($domain,$domains)){
        return true;
    }else{
        return false;
    }
}

/*
 * 检查是否是网络蜘蛛
 */
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
/*
 * 获取蜘蛛名称
 */
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
/*
 * 非爬虫情况下识别来路
 */

function verifyRefer(){

    $refer=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;
    if($refer!=null){
        if (strpos($refer, 'google.com') !== false) {
            return "soso";
        } else if (strpos($refer, 'baidu.com')!==false) {
            return "baidu";
        } else if (strpos($refer, 'so.com') !== false) {
            return "soso";
        }else{
            return "others";
        }
    }else{
        return "others";
    }


}


function verifyClient(){
    /*
     * 识别是手机还是PC
     */
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
    $mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160&times;160','176&times;220','240&times;240','240&times;320','320&times;240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');

    $found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||
        CheckSubstrs($mobile_token_list,$useragent);

    if ($found_mobile){
        return "M";
    }else{
        return "P";
    }
}


/*
 * 获取词库 ,不读取蜘蛛或来路的词库
 */
function getHots($file,$num=10)
{

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
function getWords($refer, $ciku_files,$ciku_folder,$num=10)
{
    $ciku_exclude = array();
    foreach ($ciku_files as $ciku) {
        if ($ciku != $refer) {
            array_push($ciku_exclude, $ciku);
        }
    }
    $key = array_rand($ciku_exclude);
    $file_name = $ciku_exclude[$key];
    $file = $ciku_folder . $file_name . ".txt";
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
    $res['words']=$cilist;
    $res['spider']=$file_name;
    return $res;
}
//检查来路蜘蛛
function checkFrom($domain,$domains){
    $res=[];
    if(verifyDomain($domain,$domains)){
        /*
         * 有效域名
         */
        if(isCrawler()){
            $refer=verySpider();
            $crawl=true;
        }else{
            $refer=verifyRefer();
            $crawl=false;
        }
        $res['refer']=$refer;
        $res['crawl']=$crawl;
        $res['client']=verifyClient();
        $res['legal']=true;
    }else{
        /*
         * 非法域名
         */
        return false;
    }
    return $res;
}


function SearchWords($refer,$word){

    switch ($refer){
        case 'baidu':
            $words=searchSoSo($word,rand(4,10));
            $spider="soso";
            break;
        case 'soso':
            $spider="baidu";
            $words=searchBaidu($word,rand(4,10));
            break;
        case 'others':
            $spider="baidu";
            $words=searchBaidu($word,rand(4,10));
            break;
        default :
            $spider="soso";
            $words=searchSoSo($word,rand(4,10));
            break;

    }
    $arr['words']=$words;
    $arr['spider']=$spider;
    return $arr;
}


function searchBaidu($word, $page=5)
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

function searchSoSo($word, $page=5)
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


function getHotWords(){

}



function RemoveDuplicatedLines($Filepath, $IgnoreCase=false, $NewLine="\n"){
    if (!file_exists($Filepath)){
        $ErrorMsg = 'RemoveDuplicatedLines error: ';
        $ErrorMsg .= 'The given file ' . $Filepath . ' does not exist!';
        die($ErrorMsg);
    }
    $Content = file_get_contents($Filepath);
    $Content = RemoveDuplicatedLinesByString($Content, $IgnoreCase, $NewLine);
    // Is the file writeable?
    if (!is_writeable($Filepath)){
        $ErrorMsg = 'RemoveDuplicatedLines error: ';
        $ErrorMsg .= 'The given file ' . $Filepath . ' is not writeable!';
        die($ErrorMsg);
    }
    // Write the new file
    $FileResource = fopen($Filepath, 'w+');
    fwrite($FileResource, $Content);
    fclose($FileResource);
}

/**
 * RemoveDuplicatedLinesByString
 * This function removes all duplicated lines of the given string.
 *
 * @param   string
 * @param   bool
 * @return  string
 */
function RemoveDuplicatedLinesByString($Lines, $IgnoreCase=false, $NewLine="\n"){
    if (is_array($Lines))
        $Lines = implode($NewLine, $Lines);
    $Lines = explode($NewLine, $Lines);
    $LineArray = array();
    $Duplicates = 0;
    // Go trough all lines of the given file
    for ($Line=0; $Line < count($Lines); $Line++){
        // Trim whitespace for the current line
        $CurrentLine = trim($Lines[$Line]);
        // Skip empty lines
        if ($CurrentLine == '')
            continue;
        // Use the line contents as array key
        $LineKey = $CurrentLine;
        if ($IgnoreCase)
            $LineKey = strtolower($LineKey);
        // Check if the array key already exists,
        // if not add it otherwise increase the counter
        if (!isset($LineArray[$LineKey]))
            $LineArray[$LineKey] = $CurrentLine;
        else
            $Duplicates++;
    }
    // Sort the array
    asort($LineArray);
    // Return how many lines got removed
    return implode($NewLine, array_values($LineArray));
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
