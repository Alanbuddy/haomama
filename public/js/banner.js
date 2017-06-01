

$(document).ready(function(){

	$(".img_gallery").hover(function(){
		$("#btn_prev,#btn_next").fadeIn()
	},function(){
		$("#btn_prev,#btn_next").fadeOut()
	});
	
	$dragBln = false;
	
	$(".main_img").touchSlider({
		flexible : true,
		speed : 200,
		btn_prev : $("#btn_prev"),
		btn_next : $("#btn_next"),
		paging : $(".point a"),
		counter : function (e){
			$(".point a").removeClass("on").eq(e.current-1).addClass("on");//图片顺序点切换
			$(".img_font span").hide().eq(e.current-1).show();//图片文字切换
		}
	});
	
	$(".main_img").bind("mousedown", function() {
		$dragBln = false;
	});
	
	$(".main_img").bind("dragstart", function() {
		$dragBln = true;
	});
	
	$(".main_img a").click(function(){
		if($dragBln) {
			return false;
		}
	});
	
	timer = setInterval(function(){
		$("#btn_next").click();
	}, 3000);
	
	$(".img_gallery").hover(function(){
		clearInterval(timer);
	},function(){
		timer = setInterval(function(){
			$("#btn_next").click();
		},3000);
	});
	
	$(".main_img").bind("touchstart",function(){
		clearInterval(timer);
	}).bind("touchend", function(){
		timer = setInterval(function(){
			$("#btn_next").click();
		}, 3000);
	});
	

	(function(){
	    var ul = document.querySelector('.list');
	    var li = document.querySelectorAll('.list .item');
	    var menu = document.querySelectorAll('.nav li');
	    var len = li.length;
	    var support = 'ontouchstart' in window;
	    var start = support ? 'touchstart' : 'mousedown';
	    var move = support ? 'touchmove' : 'mousemove';
	    var end = support ? 'touchend' : 'mouseup';
	    var startX = 0;
	    var now = 0;
	    var last = 0;
	    var width = li[0].clientWidth;
	    var animate = true;
	    var inner = document.querySelector(".inner");
	    var addEvent = function(obj, type, fn){
	        if(document.addEventListener){
	            obj.addEventListener(type, fn, false);
	        }
	   	}
	    var removeEvent = function(obj, type, fn){
	        if(document.removeEventListener){
	           obj.removeEventListener(type, fn, false);
	       }
	   	}
	    var  drag = {
	        start : function(e){
	            if(!e.changedTouches) { return; }
	            startX = e.clientX ? e.clientX : e.changedTouches[0].clientX;
	            var target = e.target.closest("li");
	            if(!target.classList.contains('item')){
	                return;
	            }
	            addEvent(target, move, drag.move);
	            addEvent(target, end, drag.end);
	            return false;
	           },
	        move : function(e){
	            if(!animate){ return; }
	            animate = false;
	            var moveX = e.clientX ? e.clientX : e.changedTouches[0].clientX;
	            if(moveX < startX) { // left
	                if(last < len-1){
	                    last++;
	                    // return;
	                }
	            } else { // right
	                if(last > 0){
	                    last--;
	                    // return;
	                }
	            }
	            ul.style.transform = 'translate(' + (-width / 10 * last + moveX / 100 - startX / 100) + 'rem, 0)';
	            ul.style.transition = '.5s';
	            e.stopPropagation();
	        },
	      	end : function(e){
	          	// var moveX = e.clientX ? e.clientX : e.changedTouches[0].clientX;
	          	ul.style.transform = 'translate(-' + (width * last) / 10 + 'rem, 0)';
	          	ul.style.transition = '.5s';
	          	var target = e.target.closest("li");
	          	if(!target.classList.contains('item')){
	              	return;
	          	}
	          	removeEvent(target, move, drag.move);
	          	removeEvent(target, end, drag.end);
	          	animate = true;
	          	drag.cur();
	      	},
	      	finish : function(e){
	          	animate = true;
	      	},
	      	cur : function(){
	        	for(var i=0; i<li.length; i++){
	              	menu[i].classList.remove('active');
	          	}
	          	menu[last].classList.add('active');
	      	}
	  	}
	  	addEvent(inner, start, drag.start);
	    addEvent(ul, 'webkitTransitionEnd', drag.finish);
	    for(var i = 0; i < li.length; i++){
	        menu[i].index = i;
	        menu[i].onclick = function(){
	            last = this.index;
	            ul.style.transform = 'translate(-' + (width * last) / 10 + 'rem, 0)';
	            ul.style.transition = '.5s';
	            for(i=0; i<li.length; i++){
	                menu[i].classList.remove('active');
	            }
	            this.classList.add('active');
	        }
	    }
    }());
});