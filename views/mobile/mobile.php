<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
          name="viewport">
    <meta content="telephone=no" name="format-detection">

    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <title><?php echo iconv("utf-8","gb2312//IGNORE",trim($title));?> - <?php echo $domain;?></title>
    <link rel="apple-touch-icon-precomposed" href="/public/img/logo144.png">
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/public/img/logo57.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/public/img/logo114.png">
    <link href="/public/css/mcss.v3.1.css" rel="stylesheet" type="text/css"/>
    <link href="/public/css/lun.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/public/js/jquery.js"></script>
    <script>

        var browser = {
            versions: function () {
                var u = navigator.userAgent, app = navigator.appVersion;
                return {//移动终端浏览器版本信息
                    trident: u.indexOf('Trident') > -1, //IE内核
                    presto: u.indexOf('Presto') > -1, //opera内核
                    webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
                    gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
                    mobile: !!u.match(/AppleWebKit.*Mobile.*/) || !!u.match(/AppleWebKit/), //是否为移动终端
                    ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
                    android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器
                    iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //是否为iPhone或者QQHD浏览器
                    iPad: u.indexOf('iPad') > -1, //是否iPad
                    webApp: u.indexOf('Safari') == -1, //是否web应该程序，没有头部与底部
                    qq: u.indexOf('MQQBrowser') > -1,
                    uc: u.indexOf('UCBrowser') > -1,
                };
            }(),
            language: (navigator.browserLanguage || navigator.language).toLowerCase()
        }
        window.onscroll = function () {
            var scrollTop = document.body.scrollTop || document.documentElement.scrollTop || 0;
            if (scrollTop > document.getElementById('wai_head_top').offsetTop) {
                $("#head_top02").addClass("head_top01");
            } else {
                $("#head_top02").removeClass("head_top01");
            }

            var vtop = $(document).scrollTop();
            var dheight = $(window).height();
            if (vtop > dheight) {
                $(".fanhui").show();
            } else {
                $(".fanhui").hide();
            }
            var t = document.documentElement.scrollTop || document.body.scrollTop;
            if (t >= $('.list_text_01').offset().top + 44) {
                $('.tuiguang').addClass('fix');
            } else {
                $('.tuiguang').removeClass('fix');
            }
        }

    </script>

    <style type="text/css">
        .infeedAlbum li img {
            height: 85px;
        }

        .fanhui a {
            bottom: 120px;
        }
    </style>


</head>
<body isshowtip="false" isloadjs="true">
<div style="display:none;" class="fanhui"><a href="#"></a></div>

<div id="bg" style="display:none;"></div>
<div class="tankuang" style="display:none;">
    <div class="close"><a href="javascript:void(0);"></a></div>

</div>
<div id="wai_head_top" class="header_h">
    <div class="nav_top" id="head_top02">

        <h2 class="p_dialoghead_tit">
            <?php echo $domain;?>
        </h2>
        <div class="logo_pic"></div>
        <div class="left_fanhui">
            <a href=""></a>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="list_text_01">
    <div id="tuiguang" class="tuiguang"></div>



    <div class="list_text_nr">
        <div class="timu_01">
            <h2><?php echo iconv("utf-8","gb2312//IGNORE",trim($title));?></h2>

        </div>
        <div class="zhengwen">
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

            }?>
        </div>



        <div class="clear"></div>



        <div id="tab_down">

            <div style="width:100%; overflow:hidden;">

            </div>

            <div class="clear"></div>
            <div style="width:100%; overflow:hidden;">



            </div>
            <div class="clear"></div>
            <div style="width:100%; overflow:hidden;">

            </div>
        </div>
        <div class="clear"></div>
        <div style="width:100%; overflow:hidden;">

        </div>
        <div class="clear"></div>
        <div class="fenxiang">

        </div>
        <div class="clear"></div>
    </div>
</div>
<div style="width:100%; overflow:hidden;">


</div>
<div style="width:100%; overflow:hidden;">

</div>


<div style="width:100%; overflow:hidden;">

</div>


<div class="hot_new">
    <div class="block_ty">
        <h2>热点新闻</h2>
        <div class="ty_nr">
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
    </div>
</div>
<div class="hot_new">
    <div class="block_ty">
        <h2>精彩推荐</h2>
        <div class="ty_nr">
            <ul id="tuijian_ad">

            </ul>
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

<div class="hot_new">
    <div class="block_ty">
        <h2>热门组图</h2>
        <div class="ty_hot">
            <div class="hot_pic">
                <ul id="retu">
                    <?php
            if ($res['crawl']==true){
            ?>
                    <a href=""><img src="/images/m<?php echo rand(100,300);?>.jpg" alt="" id="image2" width="320" rel="nofollow"/></a>

                    <?php  } else{ ?>
                    <script src="/public/js/customer.js"></script>
                    <?php } ?>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>


<div style="display:none;" id="div_tuijian">
</div>




<div id="footer">
    <div class="youlian">
        <div id="youlian">
            <span>Copyright2015-2017 @<?php echo $domain;?></span>
            <span>联系方式 webadmin#<?php echo $domain?></span>
        </div>
    </div>

</div>

</body>
</html>