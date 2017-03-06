<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta content="text/html; charset=gb2312" http-equiv="Content-Type">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php  echo $title;?></title>
    <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="/public/js/app.js"></script>


</head>
<body>
<div class="container">
    <div class="header">
        <div class="row">
            <h1>头条新闻</h1>


        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-4">
                <div>
                    <h3>热点</h3>
                    <ul class="list-group">
                        <?php
                        foreach ($contents as $item){
                            $item=str_replace(" ","",trim($item));
                            if(strlen($item)>1){
                                $content=iconv("utf-8","gb2312//IGNORE",$item);
                                $url=base64_encode(urlencode($item));
                                echo "<li><a href='/c/$url.html'>$content</a></li>";
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <h3>Weibo</h3>
                    <ul class="list-group">
                        <?php
                        foreach ($hotnews as $item){
                            $item=str_replace(" ","",trim($item));
                            if(strlen($item)>1){
                                $content=iconv("utf-8","gb2312//IGNORE",$item);
                                $url=base64_encode(urlencode($item));
                                echo "<li><a href='/c/$url.html'>$content</a></li>";
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
    <div class="footer">
        <hr>
    <p>
        <span>Copyright2015-2017 @<?php echo $title;?></span>
        <span>联系方式 webadmin#<?php echo $title?></span>
    </p>

    </div>
</div>





</body>
</html>