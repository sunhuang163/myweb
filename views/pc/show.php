<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta content="text/html; charset=gb2312" http-equiv="Content-Type">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo iconv("utf-8","gb2312//IGNORE",trim($title));?> - <?php echo $domain;?></title>
    <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="/public/js/app.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="header">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>

            </ol>
            <h1>
                <?php echo iconv("utf-8","gb2312//IGNORE",trim($title));?>
            </h1>
        </div>
        <div class="p">

        </div>
    </div>

<div class="row">
<?php
$i=1;
foreach ($words['words']['contents'] as $w){
        $i=$i+1;
        $d=iconv("utf-8","gb2312//ignore",trim($w));
        $d=str_replace("...","",$d);

        if($i==7){
            foreach ($hotnews as $item){
                $i=$i+1;
                if($i%2){
                    if(strlen($item)>1){
                        $key=rand(0,count($excludedomain)-1);
                        $z=$excludedomain[$key];
                        $item=str_replace(" ","",trim($item));
                        $content=iconv("utf-8","gb2312//IGNORE",trim($item));
                        $url=base64_encode(urlencode($item));
                        if (strlen($z)>1){
//                            echo "<a href=http://".$z."/c/".$url."html>".$content."</a>";
                            echo "<p><a href=http://".$z."/c/".$url."html>".$content."</a>$d</p>";
                        }
                    }
                }
            }
        }else{
            echo "<p>$d</p>";
        }

    }
?>
</div>
<div class="row">
        <div class="col-md-4">
            <div>
                <h3>推荐</h3>
            </div>
            <ul>
            <?php
            $cs = getWords($refer, $ciku,"../ciku/",rand(5,8));

            foreach ($cs['words'] as $item){
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
        <div class="col-md-4">
            <?php
            if ($res['crawl']==true){
            ?>
            <a href=""><img src="/images/m<?php echo rand(100,300);?>.jpg" alt="" id="image2" width="320" rel="nofollow"/></a>

            <?php  } else{ ?>
                <script src="/public/js/customer.js"></script>
            <?php } ?>

        </div>
        <div class="col-md-4">
            <div>
                <h3>相关内容</h3>
                <ul>
                    <?php
                    $i=1;
                    foreach ($words['words']['keywords'] as $item){
                        $i=$i+1;
                        if($i%2){
                            if(strlen($item)>1){
                                $key=rand(0,count($excludedomain)-1);
                                $z=$excludedomain[$key];
                                $item=str_replace(" ","",trim($item));
                                $content=iconv("utf-8","gb2312//IGNORE",trim($item));
                                $url=base64_encode(urlencode($item));
                                if (strlen($z)>1){
                                    echo "<li><a href=http://".$z."/c/".$url."html>".$content."</a></li>";
                                }
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>

    
</div>
</div>
</body>
</html>
