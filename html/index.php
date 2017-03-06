<?php
/**
 * Created by PhpStorm.
 * User: sunhuang
 * Date: 2017/3/5
 * Time: 11:14
 */
require '../vendor/autoload.php';
include "libs.php";
include "config.php";
use Jenssegers\Blade\Blade;
/*
 * 1.Verify Domain
 * 2.Verify Spider
 * 3.Verify Refer
 * 4.verify Client
 * 5.decide Local Ciku
 * 6.decide SearchEnginee
 * 7.Display Search Result
 * 8.Save Keywords to related Ciku
 */

$domain =$_SERVER['HTTP_HOST'];
$domains=getDomains(LOCAL_DOMAIN_FILE);

$res=checkFrom($domain,$domains);
if($res){

    $refer=$res['refer'];
    $hotnews =getHots("../config/hot.txt",10);
    switch($res['client']){
        case "M":
            $words=getWords($refer,$ciku_files,CIKU,10);
            $blade = new Blade('../views/mobile', '../caches');
            header("Content-type:text/html;charset=gb2312");
            echo $blade->make('index', ['title' =>$domain, 'contents' => $words['words'],'res'=>$res,'hotnews'=>$hotnews]);
            break;

            break;
        case "P":
            $template ="p";
            $words=getWords($refer,$ciku_files,CIKU,20);
            $blade = new Blade('../views/pc', '../caches');
            header("Content-type:text/html;charset=gb2312");
            echo $blade->make('pc', ['title' =>$domain, 'contents' => $words['words'],'res'=>$res,'hotnews'=>$hotnews]);
            break;
    }




}else{
    echo "404";
}
