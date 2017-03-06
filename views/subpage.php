<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta content="text/html; charset=gb2312" http-equiv="Content-Type">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php  echo $title;?></title>
</head>
<body>


<?php



foreach ($contents['contents'] as $item){
    $con=iconv("utf-8","gb2312//IGNORE",$item);
    echo "<p>$con</p>";
}
?>

</body>
</html>