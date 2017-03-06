<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta content="text/html; charset=gb2312" http-equiv="Content-Type">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php  echo $title;?></title>
</head>
<body>

<hr>

<?php
    foreach ($contents as $item){
        $item=str_replace(" ","",trim($item));
        if(strlen($item)>1){
            $content=iconv("utf-8","gb2312//IGNORE",$item);
            $url=base64_encode(urlencode($item));
            echo "<li><a href='/b/$url.html'>$content</a></li>";
        }
    }
?>

</body>
</html>