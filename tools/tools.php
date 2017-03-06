<?php
/**
 * Created by PhpStorm.
 * User: sunhuang
 * Date: 2017/3/2
 * Time: 23:12
 */



function list_files($dir){
    $files=scandir($dir);
    return $files;
}

$files=list_files("./tools");
var_dump($files);