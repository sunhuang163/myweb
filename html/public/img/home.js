 
/*
 * 战略网首页相关功能实现
*/
 
$(function(){

	var SSEtimer,
		iNow = 1,
		ua = navigator.userAgent;
	
	
	/**
	图片轮播
	*/
	function imgSlideInit(sId){
	    var oSlider = $(sId),
	            nav = oSlider.next(),
	            id = sId.substr(1),

	    id = new Swipe(document.getElementById(id), {
	        startSlide: 0,
	        auto: 4000,
	        speed: 400,
	        callback: function(event, index, elem){
	            var oImg = oSlider.find('img'),
	                    len = oImg.length,
	                    maxCount = len - 2;     //最大回加载次数

	            nav.find('span').removeClass('current');
	            nav.find('span').eq(index).addClass('current');
	            var dataurl = oImg.eq(index).attr('data-src');
	            var src=oImg.eq(index).attr('src');
	            if( src!=dataurl){
	                oImg.eq(index).attr('src', dataurl);
	            }
	        }
	    });
	}
	
	/**
	tab切换
	*/	
	function tabSlideInit(sId){
		var oSlider = $(sId),
			nav = oSlider.prev(),
			id = sId.substr(1),
			obj = id;
		
		//生成滑动（Swipe）对象
		obj = new Swipe(document.getElementById(id), {
			startSlide: 0,
			speed: 200,
			callback: function(event, index, elem){
				var oLi = nav.find('li');
				if (oLi.length > 1) {
					nav.find('li.on').removeClass('on');
					oLi.eq(index).addClass('on');
				}
			}
		});
		
		//Tab选项卡切换--事件绑定
		var oLi = nav.find('li');
		$(document).on('click', oLi, function(){
			var i = nav.find('li').index(this);
			obj.slide(i, 200);
		});
	}
	
	/**
	Tab事件绑定
	*/	
	function TabBindEvent(index){
		setTimeout(function(){
			var id = '#floor' + index;
			tabSlideInit(id);
			index = parseInt(index, 10) + 1;
			var nextId = '#floor' + index;
			if (index <= 13 && $(nextId).length > 0) {
				TabBindEvent(index);
			}
		}, 200);
	}
	
	imgSlideInit('#slide_image');		//组图
	//TabBindEvent(1);				//Tab切换
})
