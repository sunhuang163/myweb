
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=GB2312" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=2.0" />
    <meta content="telephone=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
     <title><?php echo $title;?></title>
    <link rel="apple-touch-icon-precomposed" href="/public/img/logo144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/public/img/logo57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/public/img/logo114.png" />
    <link href="/public/css/mcss.v2.0.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/public/js/zepto.min.js"></script>
    <script type="text/javascript" src="/public/js/slide.js"></script>
    <script type="text/javascript" src="/public/js/home.js"></script>
    <script type="text/javascript" src="/public/js/jquery.js"></script>
    <script type="text/javascript">
        jQuery.noConflict();

        jQuery(function(){
            jQuery(".showmore").click(function(){
                jQuery(this).siblings("ul").show();
                jQuery(this).siblings("div").each(function(){
                    jQuery(this).find("ul").show();
                });
                jQuery(this).hide();
                jQuery(this).siblings(".more").show();

            });
        });
        window.onload=function(){
            if(document.documentElement.scrollHeight <= document.documentElement.clientHeight) {
                bodyTag = document.getElementsByTagName('body')[0];
                bodyTag.style.height = document.documentElement.clientWidth / screen.width * screen.height + 'px';
            }
            setTimeout(function() {
                window.scrollTo(0, 1)
            }, 0);
        };
        var browser={
            versions:function(){
                var u = navigator.userAgent, app = navigator.appVersion;
                return {//移动终端浏览器版本信息
                    trident: u.indexOf('Trident') > -1, //IE内核
                    presto: u.indexOf('Presto') > -1, //opera内核
                    webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
                    gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
                    mobile: !!u.match(/AppleWebKit.*Mobile.*/)||!!u.match(/AppleWebKit/), //是否为移动终端
                    ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
                    android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器
                    iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //是否为iPhone或者QQHD浏览器
                    iPad: u.indexOf('iPad') > -1, //是否iPad
                    webApp: u.indexOf('Safari') == -1, //是否web应该程序，没有头部与底部
                    qq:u.indexOf('MQQBrowser') > -1,
                    uc:u.indexOf('UCBrowser') > -1,
                };
            }(),
            language:(navigator.browserLanguage || navigator.language).toLowerCase()
        }

    </script>
</head>
<body isshowtip="false" isloadjs="true">
<div id="warp">
    <div id="top">
        <div id="logo"><a href="/""><?php echo $title;?></a></div>

    </div>
</div>


<div id="ggone" style="margin-bottom:10px;"></div>
<script type="text/javascript">

    var maxwidth = $(document.body).width();
    var maxheight = 200;
    if(maxwidth>640){ maxwidth=640; maxheight=391;}
    else{maxheight=200*(maxwidth/320);}
    maxtop=maxheight-37;
    jQuery(".top_left").width(maxwidth);
    jQuery(".top_left").css({'height':maxheight});

    jQuery('#slide_image_w').width(maxwidth);
    jQuery('#slide_image_w').css({'height':maxheight});

    jQuery('#slide_image').width(maxwidth);
    jQuery('#slide_image').css({'height':maxheight});

    jQuery('#slide_image img').width(maxwidth);
    jQuery('#slide_image img').css({'height':maxheight});

    jQuery('#slide_image li').width(maxwidth);

    jQuery('#slide_image .focus_text').width(maxwidth);
    jQuery('#slide_image .focus_text').css({'top':maxtop});

</script>
<div class="clear"></div>
<!--2015-03-31添加切换选项-->

<div class="clear"></div>

<!--2015-03-31添加切换选项结束-->


<div class="jiaodian_xia">
    <div class="ty_block">
        <h2><p>热点新闻</p></h2>
        <div class="tiandi">
            <ul>
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
</div>
<div class="jiaodian_xia">
    <div class="ty_block">
        <h2><p>相关文章</p></h2>

        <div class="tiandi">
            <ul>
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
</div>


<div class="clear"></div>
<div id="footer">


    <div class="qiehuan">
        <span>Copyright2015-2017 @<?php echo $title;?></span>
        <span>联系方式 webadmin#<?php echo $title?></span>
    </div>
  </div>

<script>

    var myDate = new Date();
    var nowtime = myDate.getTime();     //获取当前时间
    if(nowtime*0.001-pubdate < 3600*48)
        $("#quanqiu").removeAttr("style");
    var tabheight = ($($(".hot_nr")[0]).height())*10;
    //点击加载下十条
    function clicknextten(m){
        var zongheight = $('#sid').height();
        $('#sid').height(tabheight + zongheight);
        var lablearr = $($(".tab")[m]).find("label");
        lasttime = $(lablearr[lablearr.length-1]).html();
        $.getJSON(wapurl+"/do.php?callback=?", {inajax:1,do:'touch', ac:'clicknextten',vtype:'touch',param:m,lasttime:lasttime}, function(data){
            var html = '';
            for(var i=0;i<data.length;i++){
                html += '<div class="hot_nr"><div class="pic_p1"><a href="'+wapurl+'/touch/view/'+data[i].artid+'"><img src="'+data[i].pic+'"></a></div><div class="hots_pic"><a href="'+wapurl+'/touch/view/'+data[i].artid+'">'+data[i].subject+'</a></div><div class="clear"></div><p>'+data[i].gmdate+'</p><label class="lbllast lasttime" style="display:none;">'+data[i].pubdate+'</label><div class="clear"></div></div>';
            }
            $($(".jiazai")[m]).before(html);
        });
    }

    $(document).ready(function(){
        var oSlider = $('#sid'),
            nav = $(".quanqiu_qie"),
            id = 'sid';

        //生成滑动（Swipe）对象
        oslide1 = new Swipe(document.getElementById(id), {
            startSlide: 0,
            speed: 200,
            callback: function(event, index, elem){
                oSlider.height($($(".tab")[index]).height());
                var oA = nav.find('a');
                if (oA.length > 1) {
                    nav.find('a.on_quanqiu').removeClass('on_quanqiu');
                    oA.eq(index).addClass('on_quanqiu');
                }
            }
        });
        nav.find('a').each(function(index){
            $(this).click(function(){
                nav.find('a').removeClass('on_quanqiu');
                $(this).addClass('on_quanqiu');
                oSlider.height($($(".tab")[index]).height());
                oslide1.slide(index, 200);
            });
        });
    });
    var maxwidth = $(document.body).width();
    if(maxwidth>=640){
        picmaxheight = "300";
    }else{
        picmaxheight = "120";
    }
    var length = $(".imgwidth").length;
    for(var i=0;i<length;i++){
        $(".imgwidth")[i].height = picmaxheight;
    }

</script>






</body></html>