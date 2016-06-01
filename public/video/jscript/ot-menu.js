
// var _otmenu_ipad = false;
// var _otmenu_iphone = false;

// var _otmenu_ipad = true;
// var _otmenu_iphone = true;

var _otmenu_ipad = (typeof _otmenu_ipad != 'undefined')?_otmenu_ipad:true;
var _otmenu_iphone = (typeof _otmenu_iphone != 'undefined')?_otmenu_iphone:true;


(function( $ ) {
	"use strict";

	if(_otmenu_ipad) jQuery("body").addClass("ot-menu-ipad-enable");
	if(_otmenu_iphone) jQuery("body").addClass("ot-menu-iphone-enable");

	var _ot_menulist = "";

	jQuery(".ot-menu-add").each(function(){
		var thisel = jQuery(this);
		_ot_menulist = _ot_menulist+"<li><h3>"+thisel.attr('rel')+"<i class='fa fa-bars right'></i></h3></li>"+thisel.html()+"<li><br /></li>";
	});

	jQuery("body").prepend("<a href='#' class='ot-menu-toggle'><i class='fa fa-bars'></i>Toggle Menu</a>").prepend("<ul id='ot-menu-list' class='ot-menu-list'></ul>").find("#ot-menu-list").html(_ot_menulist);

	jQuery(".ot-menu-toggle").click(function(){
		jQuery("body").toggleClass("ot-menu-active");
		return false;
	});

})(jQuery);
