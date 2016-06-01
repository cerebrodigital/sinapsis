/*******************************************************/
/* Custom Files */
/*******************************************************/
!function (a, b) { "use strict"; a.module("ng.shims.placeholder", []).service("placeholderSniffer", ["$document", function (a) { this.emptyClassName = "empty", this.hasPlaceholder = function () { var b = a[0].createElement("input"); return void 0 !== b.placeholder } }]).directive("placeholder", ["$timeout", "$document", "placeholderSniffer", function (c, d, e) { if (e.hasPlaceholder()) return {}; var f = !1; return { restrict: "A", require: "?ngModel", priority: 110, link: function (g, h, i, j) { function k() { var a = h.val(); h.hasClass(E) && a === D || l(function () { m(a) }) } function l(a) { b.documentMode <= 11 ? c(a, 0) : a() } function m(a) { a || z === b.activeElement ? (h.removeClass(E), h.val(a)) : (h.addClass(E), C || h.val(D)), C && r() } function n() { return j ? g.$eval(i.ngModel) || "" : o() || "" } function o() { var a = h.val(); return a === i.placeholder && (a = ""), a } function p(a, b) { b ? a.attr("unselectable", "on") : a.removeAttr("unselectable") } function q() { x = a.element('<input type="text" value="' + D + '"/>'), s(), x.addClass(E).addClass(F).bind("focus", v), z.parentNode.insertBefore(x[0], z); for (var b = [i.ngDisabled, i.ngReadonly, i.ngRequired, i.ngShow, i.ngHide], c = 0; c < b.length; c++) b[c] && g.$watch(b[c], r) } function r() { s(), w() ? x.addClass(F) : h.hasClass(E) && z !== b.activeElement ? t() : u() } function s() { x.val(D).attr("class", h.attr("class") || "").attr("style", h.attr("style") || "").prop("disabled", h.prop("disabled")).prop("readOnly", h.prop("readOnly")).prop("required", h.prop("required")), p(x, "on" === h.attr("unselectable")) } function t() { h.addClass(F), x.removeClass(F) } function u() { x.addClass(F), h.removeClass(F) } function v() { u(), z.focus() } function w() { var a = "undefined" != typeof i.ngShow, b = "undefined" != typeof i.ngHide; return a || b ? a && !g.$eval(i.ngShow) || b && g.$eval(i.ngHide) : !1 } var x, y = n(), z = h[0], A = z.nodeName.toLowerCase(), B = "input" === A || "textarea" === A, C = "password" === i.type, D = i.placeholder, E = e.emptyClassName, F = "ng-hide"; D && B && (C && q(), m(y), h.bind("focus", function () { h.hasClass(E) && (h.val(""), h.removeClass(E), z.select()) }), h.bind("blur", k), j || h.bind("change", k), j && (j.$render = function () { m(j.$viewValue), z !== b.activeElement || h.val() || z.select() }), f || (d.on("selectstart", function (b) { var c = a.element(b.target); c.hasClass(E) && c.prop("disabled") && b.preventDefault() }), f = !0)) } } }]) }(window.angular, window.document);

/*******************************************************/
/* JAngular Validator */
/*******************************************************/
(function(window, angular, undefined) {'use strict';
angular.module('jugnoon-validate', [])
.factory('jangularvalidate', [
	  function(){
		var _output = {
			css: "has-success",
			message: "",
			isvalid: false
		};
		
		var _validateionLog = [];
		
		function _validate(obj, value, values) {
			if(typeof obj != "undefined") {
				  if(obj.required != "undefined") {
					  // required check -> highest priority
					  if(obj.required) {
						  if(typeof value != "undefined") {
							if (value == "") {
								_output.css = "has-error";
								if(typeof obj.requiredMessage != "")
								   _output.message = obj.requiredMessage;
								return _output;
							}
						  } else if(typeof values != "undefined") {
							  if(values.length == 0) {
								  _output.css = "has-error";
								  if(typeof obj.requiredMessage != "")
									_output.message = obj.requiredMessage;
								  return _output;
							  }
						  }
					  } 
				  }
				  if (typeof obj.type != 'undefined') {
					  if(typeof value != "undefined") {
						  switch(obj.type) {
							  // numeric case works on text areas
							  case "numeric":
								 var _pattern = /[\d]+/;
								 if(!_pattern.test(value)) {
									 _output.css = "has-error";
									  if(typeof obj.numericMessage != "")
										 _output.message = obj.numericMessage;
									  return _output;
								 } else {
									 // number validated
									 // check for min
									 if(typeof obj.min != "undefined") {
										 if(parseInt(value) < parseInt(obj.min)) {
											 _output.css = "has-error";
											  if(typeof obj.minMessage != "")
												 _output.message = obj.minMessage;
											  return _output;
										 }
									 }
									 // max validation
									 if(typeof obj.max != "undefined") {
										 if(parseInt(value) > parseInt(obj.max)) {
											 _output.css = "has-error";
											  if(typeof obj.maxMessage != "")
												_output.message = obj.maxMessage;
											  return _output;
										 }
									 }
								 } // close numeric else
							  break;
							  case "string":
								 // min string validation
								 if(typeof obj.min != "undefined") {
									 if(value.length < obj.min) {
										 _output.css = "has-error";
										  if(typeof obj.minMessage != "")
											 _output.message = obj.minMessage;
										  return _output;
									 }
								 }
								 // max string validation
								 if(typeof obj.max != "undefined") {
									 if(value.length > obj.max) {
										  _output.css = "has-error";
										  if(typeof obj.maxMessage != "")
											 _output.message = obj.maxMessage;
										  return _output;
									 }
								 }
								 
								 // regular expression
								 if(typeof obj.pattern != "undefined") {
									 var _pattern = obj.pattern;
									 if(!_pattern.test(value)) {
										  _output.css = "has-error";
										  if(typeof obj.patternMessage != "")
											 _output.message = obj.patternMessage;
										  return _output;
									 }
								 }
								 
							  break;
						  } // close switch
					  } // close if
				  } // close obj.type
			  }
			// validated
			return  {
				css: "has-success",
				message: "",
				isvalid: true
			};
		}
				
		return {
			formvalidate: function(obj) {
				_validateionLog = []; // reset
				for(var i=0;i<= obj.length - 1; i++) {
					  var _val = obj[i];
					  var _log = _validate(_val.validate, _val.value, _val.values);
					  if(!_log.isvalid) {
						 _validateionLog.push({
							 message: _log.message
						 });
					  }
				 }
				 return _validateionLog;
			},
			validate: function(obj, value, values) {
				return _validate(obj,value,values);
				// close output
			}
		};
}]);
})(window, window.angular);
/************************************************************************************************
 * jAngular Pagination Service
 * *********************************************************************************************/
 
 /********************************************************/
/* jPajingation */
// jAngular Pagination Service
var jPagination = angular.module('jPagination', []);
jPagination.factory('Paginate', function () {
	
	// scope properties
	var currentPage = 1;
	var totalRecords = 0;
	var pageSize = 20;
	var showFirst = 1;
	var showLast = 1;
	var paginationstyle = 0;
	var totalLinks = 7;
	// internal use only
	var PaginationLinks = new Array();
	var totalPages = 0;
	var firstbound = 0;
	var lastbound = 0;
	var tooltip = "";
	var prevCss = "previous";
	var nextCss = "next";
    var urlpath = "";
	return {
		ProcessPagination: function (Options) {
			currentPage = parseInt(Options.pagenumber);
			totalRecords =  parseInt(Options.totalrecords);
			pageSize = parseInt(Options.pagesize);
			showFirst = parseInt(Options.showfirst);
			showLast = parseInt(Options.showlast)
			paginationstyle = parseInt(Options.paginationstyle);
			totalLinks = parseInt(Options.totallinks);
			urlpath = Options.urlPath;
			PaginationLinks = [];
		
			
			if(totalRecords > pageSize) {
				totalPages  = Math.ceil(totalRecords / pageSize);
			
				if(currentPage > 1) {
				   if (showFirst == 1 && paginationstyle != 2)
				   {
					   firstbound = 1;
					   lastbound = firstbound + pageSize - 1;
					   tooltip = "showing " + firstbound + " - " + lastbound + " records of " + totalRecords + " records";
					   // First Link
					   addLink(1, "#/" + urlpath, "First", tooltip, "first");
					}
					firstbound = ((totalPages - 1) * pageSize);
					lastbound = firstbound + pageSize - 1;
					if (lastbound > totalRecords)
					{
						lastbound = totalRecords;
					}
					tooltip = "showing " + firstbound + " - " + lastbound + " records of " + totalRecords + " records";
					// Previous Link Enabled
					var pid = (currentPage - 1);
					if(pid < 1)  pid = 1;
					
					var prevPageCss = "";
					var prevIcon = "Prev";
					if(paginationstyle == 2)
					{
						if(prevCss != "")
						   prevPageCss = prevCss;
						prevIcon = "&larr; Previous";
					}
					
					var _urlpath = "";
					if(_urlpath != "")
					   _urlpath =  urlpath + "/" + pid;
					   
					addLink(pid, "#/" + _urlpath, prevIcon, tooltip, "previous");
					// Normal Links
					if(paginationstyle != 2)
						gen_links(urlpath);
				   
					if(currentPage < totalPages)
						set_prev_last_links(urlpath);
				 }
				 else {
					  if(paginationstyle != 2)
						  gen_links(urlpath);
					   
					  if(currentPage < totalPages)
						  set_prev_last_links(urlpath);
				  }
			  } 
		  return PaginationLinks;
		}
	}
	// generate dynamic links
	function gen_links(urlpath) {
	   
		  firstbound = 0;
		  lastbound = 0;
		  tooltip = "";
			  
		  var Arr = [];
		  //if($scope.paginationstyle == 1)
		  //  Arr = AdvancePagination();
		  //else
		  Arr = SimplePagination(totalPages, totalLinks, currentPage);
		  if(Arr.length > 0){ 
			Arr.forEach(function(entry) {
				 firstbound = ((entry - 1) * pageSize) + 1;
				 lastbound = firstbound + pageSize - 1;
				 if (lastbound > totalRecords)
				   lastbound = totalRecords;
				 tooltip = "showing " + firstbound + " - " + lastbound + " records  of " + totalRecords + " records";
				 
				 var _urlpath = "";
				 if(urlpath != "")
				   _urlpath =  urlpath + "/" + entry;
				 
				 addLink(entry, "#/" + _urlpath, entry, tooltip, "");
			});
		  }
	 }
	 // generate next, last link
	 function set_prev_last_links(urlpath) {
		  firstbound = ((currentPage) * pageSize) + 1;
		  lastbound = firstbound + pageSize - 1;
		 
		  if (lastbound > totalRecords)
			lastbound = totalRecords;

		  tooltip = "showing " + firstbound + " - " + lastbound + " records of " + totalRecords + " records";
		  // Next Link
		  var pid = (currentPage + 1);
		  if(pid > totalPages)
			 pid = totalPages;
	
		  var nextPageCss = "";
		  var nextPageIcon = "Next";
		  if(paginationstyle == 2)
		  {
			  if(nextCss != "")
				 nextPageCss = nextCss;
			   nextPageIcon = "Next &rarr;"; 
		  }
		  addLink(pid, "#/" + urlpath, nextPageIcon, tooltip, "next");
				  
		  if (showLast==1 && paginationstyle != 2)
		  {
				// Last Link
				firstbound = ((totalPages - 1) * pageSize) + 1;
				lastbound = firstbound + pageSize - 1;
				if (lastbound > totalRecords)
					lastbound = totalRecords;
				tooltip = "showing " + firstbound + " - " + lastbound + " records of " + totalRecords + " records";
				
				var _urlpath = "";
			    if(urlpath != "")
				   _urlpath =  urlpath + "/" + totalPages;
				addLink(lastbound, "#/" + _urlpath, "Last", tooltip, "last");
		 }
	 } 
	 
	 function addLink(id, url, name, tooltip, css) {
		// this line is all I changed
		var linkAttr = {'id' : id, 'url' : url, 'name' : name, 'tooltip' : tooltip, 'css' : css};
					
		PaginationLinks.push(linkAttr);        
	 }
	 
	 function SimplePagination(totalpages, totallinks, selectedpage) {
		 var arr = [];
		 if (totalpages < totallinks)
		 {
			 for(var i=1; i<=totalpages; i++)
			 {
				 arr[i-1] = i;
			 }
		 }
		 else
		 {
			startindex  = selectedpage;
			lowerbound = startindex - Math.floor(totallinks / 2);
			upperbound = startindex + Math.floor(totallinks / 2);
			if (lowerbound < 1)
			{
				 //calculate the difference and increment the upper bound
				upperbound = upperbound + (1 - lowerbound);
				lowerbound = 1;
			}
			//if upperbound is greater than total page is
			if (upperbound > totalpages)
			{
				//calculate the difference and decrement the lower bound
				lowerbound = lowerbound - (upperbound - totalpages);
				upperbound = totalpages;
			}
			var counter = 0;
			for(var i= lowerbound; i<= upperbound; i++)
			{
				 arr[counter] = i;
				 counter++;
			}
		 }
		 return arr;
	  }
	  
	  function AdvancePagination() {
		  
	  }
	 // close functions
});

// $http module
var httpServices = angular.module('httpServices', []);
httpServices.factory('mediasoftHTTP', ['$http',
function ($http) {
    return {
        httpProcess: function (url) {
            return $http.get(url);
        },
        actionProcess: function (url, paramOptions) {
            return $http.post(url, paramOptions);
        }
    };
}]);