
(function ($) {
	"use strict";

	jQuery(window).ready(function() {
		
		// Search on focus - minify menu spaces
		jQuery(".ot-search-field").focus(function(){
			jQuery("#main-menu").addClass("minify-menu");
		}).blur(function(){
			jQuery("#main-menu").removeClass("minify-menu");
		});


		// Video slider settings
		function resizeVideoSlider(onresize){
			var element = jQuery(".video-slides-inner > .item.active"),
				elmsize = parseInt(element.width()+(parseInt(element.css("padding-left"))*2)),
				winsize = parseInt(jQuery(".video-slider").width())/2-((elmsize)/2),
				onresize = (onresize) ? "resizesmooth" : "onresize";
			element.parent().addClass(onresize).css("left", winsize+(-(elmsize*element.index())));
			setTimeout(function(){
				element.parent().removeClass(onresize);
			}, 10);
			return false;
		}


		// Event ot video slider when slide changes "ot-slider-change"
		jQuery(".video-slider").on("ot-slider-change", function(event, elementID, elementHREF, elementREL) {
			// var elementHREF = (elementHREF.indexOf('#') == (-1)) ? elementHREF : elementHREF.split('#')[1];
			// console.log(elementID + " : " + elementHREF + " : " + elementREL);
		});

		jQuery(".video-slides-inner > .item").eq(0).addClass("active").each(function(){
			var element = jQuery(this);
			element.addClass("active").siblings(".active").removeClass("active");
			jQuery(".video-slider").trigger("ot-slider-change", [element.index(), element.attr("href"), element.attr("rel")]);
			resizeVideoSlider("smooth");
			return false;
		});

		jQuery(".video-slides-inner > .item").click(function(){
			var element = jQuery(this);
			element.addClass("active").siblings(".active").removeClass("active");
			jQuery(".video-slider").trigger("ot-slider-change", [element.index(), element.attr("href"), element.attr("rel")]);
			resizeVideoSlider("smooth");
			return false;
		});

		resizeVideoSlider();

		jQuery(window).resize(function(){
			resizeVideoSlider();
		});

		function getAccurateNavi(direction, element){
			var elindex = element.index();
			if(direction == "next"){
				return (element.next().index() == (-1)) ? element.siblings().eq(0) : element.next();
			}else
			if(direction == "prev"){
				return (element.prev().index() == (-1)) ? element.siblings().eq(-1) : element.prev();
			}
			return false;
		}

		jQuery(".video-slider .ot-slider-control-left, .video-slider .ot-slider-control-right").click(function(){
			var element = jQuery(this),
				elementAct = element.parent().parent().siblings(".video-slider-slides").find(".video-slides-inner .item.active");
			if(element.hasClass("ot-slider-control-right")){
				var thefinale = getAccurateNavi("next", elementAct);
			}else{
				var thefinale = getAccurateNavi("prev", elementAct);
			}
			thefinale.addClass("active").siblings(".active").removeClass("active");
			jQuery(".video-slider").trigger("ot-slider-change", [thefinale.index(), thefinale.attr("href"), thefinale.attr("rel")]);
			resizeVideoSlider("smooth");
			return false;
		});


		// Like button Toggle style
		jQuery(".ot-like-button").click(function(){
			jQuery(this).toggleClass("me-like");
			return true;
		});


		// Video set layout
		jQuery("a[href='#v-set-layout']").click(function(){
			var element = jQuery(this);
			element.addClass("active").siblings(".active").removeClass("active");
			element.parent().parent().siblings(".panel-block").attr("class", "panel-block video-list").addClass(element.attr("rel"));
			return false;
		});


		// Orange-Themes HTML5 Video Player

		jQuery("#videofallback").each(function(){
			jwplayer("videofallback").setup({
				file: jQuery(this).siblings("source").attr("src"),
				width: "100%",
				aspectratio: "16:9"
			});
		});

		jQuery(".jwvideo").each(function(){
			jwplayer("jwvideo").setup({
				file: jQuery(this).attr("rel"),
				width: "100%",
				aspectratio: "16:9"
			});
		});

		jQuery(".otplayer").parent().addClass("showcontrols");

		jQuery(".otplayer").each(function(){

			var element = jQuery(this),
				_otVideo = element[0];

			_otVideo.addEventListener('timeupdate', function () {
				var element = jQuery(this);

				jQuery(".otplayer").parent().addClass("showcontrols");

				var currentSeconds = (Math.floor(element[0].currentTime % 60) < 10 ? '0' : '') + Math.floor(element[0].currentTime % 60); 
				var currentMinutes = Math.floor(element[0].currentTime / 60); 

				element.siblings(".otplayer-controls").find('.ot-inline-time').html(currentMinutes + ":" + currentSeconds);

				var percentageOfSong = (element[0].currentTime/element[0].duration);
				var percentageOfSlider = element.siblings(".otplayer-controls").find('.ot-inline-slider')[0].offsetWidth * percentageOfSong;

				element.siblings(".otplayer-controls").find('.ot-inline-slider > div').css("width", Math.round(percentageOfSlider) + "px"); 

			}, false);

			_otVideo.addEventListener('volumechange', function () {
				var element = jQuery(this),
					percentage = element[0].volume;
				element.parent().find(".ot-inline-volume-slider > div").css("height", (percentage * 100)+"%");
				if(percentage <= 0){
					element.parent().find(".ot-inline-volume").addClass("volmute");
				}else{
					element.parent().find(".ot-inline-volume").removeClass("volmute");
				}
			});

			_otVideo.addEventListener('ended', function () {
				element.parent().removeClass("playing");
			}, false);

			_otVideo.addEventListener('pause', function () {
				element.parent().removeClass("playing");
			}, false);

			_otVideo.addEventListener('play', function () {
				element.parent().addClass("playing");
			}, false);

		});

		jQuery(".otplayer").click(function(){
			var element = jQuery(this),
				_otVideo = element[0];
			if(_otVideo.paused){
				_otVideo.play();
			}else{
				_otVideo.pause();
			}
		});

		jQuery(".otplayer-controls .ot-inline-playpause").click(function(){
			var element = jQuery(this),
				_otVideo = element.parent().siblings(".otplayer")[0];
			if(_otVideo.paused){
				_otVideo.play();
			}else{
				_otVideo.pause();
			}
		});

		jQuery(".otplayer").bind('webkitfullscreenchange mozfullscreenchange fullscreenchange', function(e) {
			var state = document.fullScreen || document.mozFullScreen || document.webkitIsFullScreen;
			var event = state ? 'FullscreenOn' : 'FullscreenOff';

			if(event == "FullscreenOff"){
				jQuery(this).controls = true;
			}else
			if(event == "FullscreenOn"){
				jQuery(this).controls = false;
			}
		});

		jQuery(".otplayer-controls .ot-inline-fullscreen").click(function(){
			var element = jQuery(this),
				_otVideo = element.parent().siblings(".otplayer")[0];

			if (_otVideo.requestFullscreen) {
				_otVideo.requestFullscreen();
			} else if (_otVideo.msRequestFullscreen) {
				_otVideo.msRequestFullscreen();
			} else if (_otVideo.mozRequestFullScreen) {
				_otVideo.mozRequestFullScreen();
			} else if (_otVideo.webkitRequestFullscreen) {
				_otVideo.webkitRequestFullscreen();
			}
		});

		jQuery('.ot-inline-slider').bind('mousedown', function(e){
			jQuery(this).bind('mousemove click', function(e){
				var element = jQuery(this),
					x = e.pageX - element.offset().left,
					songSliderWidth = element.width(),
					percentage = (x/songSliderWidth);

				element.parent().siblings(".otplayer")[0].currentTime = element.parent().siblings(".otplayer")[0].duration * percentage;
			});

			jQuery(this).bind('mouseup mouseleave',function(){
				jQuery(this).unbind('mousemove');
			});
		});

		jQuery('.ot-inline-volume').bind('click', function(e){
			var element = jQuery(this);
			if(element.hasClass("volmute")){
				element.removeClass("volmute");
				element.parent().parent().siblings(".otplayer")[0].volume = 1;
			}else{
				element.addClass("volmute");
				element.parent().parent().siblings(".otplayer")[0].volume = 0;
			}
		});

		jQuery('.ot-inline-volume-slider').bind('mousedown', function(e){
			jQuery(this).bind('mousemove click', function(e){
				var element = jQuery(this),
					x = e.pageY - element.offset().top - 20,
					x = (x < 0) ? 0 : x,
					x = (x > 100) ? 100 : x,
					x = 100 - x,
					songSliderHeight = element.height(),
					percentage = (x/songSliderHeight);

				element.parent().parent().siblings(".otplayer")[0].volume = percentage;
			});

			jQuery(this).bind('mouseup mouseleave',function(){
				jQuery(this).unbind('mousemove');
			});
		});


		// Load video thumbs onload
		jQuery(".loadingvideo").each(function(){
			var element = jQuery(this),
				tempimage = new Image(),
				imagesrc = element.children("img").attr("rel");

			tempimage.src = imagesrc;
			jQuery(tempimage).load(function() {
				element.children("img").css("background-image", "url(" + imagesrc + ")").attr("rel", "").parent().removeClass("loadingvideo");
			});
		});


		// Hover icon
		jQuery(".img-hover-effect").each(function() {
			var element = jQuery(this);
			element.append("<span class='hoveringel'><i class='fa fa-play-circle'></i></span>").children(".hoveringel").css("line-height", element.children("img").height()+"px").css("font-size", (element.children("img").height()/3.3)+"px");
		});


		// Accordion
		jQuery(".accordion .item > h5").click(function(){
			jQuery(this).parent().toggleClass("active").siblings(".active").removeClass("active");
			return false;
		});

		// Alert Message
		jQuery(".close-alert").click(function(){
			jQuery(this).parent().fadeOut();
			return false;
		});

		// Tabbed onload
		jQuery(".short-tabs").each(function(){
			var element = jQuery(this);
			if(element.children("ul").find("li.active").size() == 0){
				element.children("ul").children("li").eq(0).addClass("active");
				element.children("div").eq(0).addClass("active");
			}
		});
		jQuery(".short-tabs ul li a").click(function(){
			var element = jQuery(this).parent(),
				elindex = element.index();

			element.addClass("active").siblings(".active").removeClass("active");
			element.parent().siblings("div").eq(elindex).addClass("active").siblings(".active").removeClass("active");
			return false;
		});


	});

})(jQuery);


