<?php
/**
 * Created by PhpStorm.
 * User: sunhuang
 * Date: 2017/3/5
 * Time: 14:51
 */

require '../vendor/autoload.php';
include "libs.php";
include "config.php";
use Jenssegers\Blade\Blade;
$domain =$_SERVER['HTTP_HOST'];
$domains=getDomains(LOCAL_DOMAIN_FILE);
$foreigndomain=getDomains(FOREIGN_DOMAIN_FILE);
$res=checkFrom($domain,$domains);
if($res){
    $ch=$_GET['id'];
    $word=urldecode(base64_decode($ch));
    $refer=$res['refer'];
    $search=SearchWords($refer,$word);
    $related_words=getWords($refer, $ciku_files,CIKU,rand(2,5));
    $hotnews =getHots("../config/hot.txt",2);
    if (count($search['words']['keywords'])>2){
        $newwords=implode("\n",$search['words']['keywords']);
        $filename =CIKU.$search['spider'].".txt";
        file_put_contents(CIKU.$search['spider'].".txt",$newwords,FILE_APPEND);
    }
    $exclude_domain=removeArray($domains,$domain);
    $exclude_domain=array_merge($exclude_domain,$foreigndomain);

    switch($res['client']){
        case "M":
            $template ="m";
            $blade = new Blade('../views/mobile', '../caches');

            header("Content-type:text/html;charset=gb2312");
            echo $blade->make('mobile', [
                'title' =>$word,
                'domain'=>$domain,
                'refer'=>$refer,
                'words'=>$search,
                'ciku'=>$ciku_files,
                'excludedomain'=>$exclude_domain,
                'hotnews'=>$hotnews,
                'res'=>$res,

            ]);
            break;
        case "P":
            $template ="p";
            $blade = new Blade('../views/pc', '../caches');

            header("Content-type:text/html;charset=gb2312");
            echo $blade->make('show', [
                'title' =>$word,
                'domain'=>$domain,
                'refer'=>$refer,
                'words'=>$search,
                'ciku'=>$ciku_files,
                'excludedomain'=>$exclude_domain,
                'hotnews'=>$hotnews,
                'res'=>$res,

            ]);
            break;
    }


}else{
    echo "404";
}

