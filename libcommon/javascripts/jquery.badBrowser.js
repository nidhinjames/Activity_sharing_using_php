/**
 * 1.0 Original article and Script is from: http://think2loud.com/build-an-unsupported-browser-warning-with-jquery/
 * 1.1 Then the script was extended here: http://blog.team-noir.net/2009/06/fight-old-browsers-warning-with-jquery/
 * 1.2 And finally Fleshgrinder had a look at it and also minified it: http://www.nervenhammer.com/
 * 1.3 Google Chrome & new Safari detect added by www.team-noir.net
 * 1.4 Browser Version Update by www.team-noir.net
 */

function badBrowser() {
	var userAgent = navigator.userAgent.toLowerCase();
	
	// Check for Microsoft Internet Explorer 8.0
	if ($.browser.msie && parseInt($.browser.version, 10) < 8) {
		return true;
	}
	// Check for Opera 9.5
	if ($.browser.opera && ($.browser.version *10) <= 95) {
		return true;
	}
	// Check for Mozilla Firefox 3.0
	if (/firefox[\/\s](\d+\.\d+)/.test(userAgent)) {
		var ffversion = Number(RegExp.$1);
		if (ffversion < 3) {
			return true;
		}
	}
	// Check for Safari < Version 3.0
	if (/safari[\/\s](\d+\.\d+)/.test(userAgent) && !/chrome[\/\s](\d+\.\d+)/.test(userAgent)) {
		var safari = userAgent.indexOf('version');
		if (safari > -1) {
			var snip1 = safari+8;
			var version = userAgent.substring(snip1, (snip1+1));
			if (version < 3) {
				return true;
			}
		}
	}
	// Check for Chrome < Version 3.0
	//var chrome = userAgent.indexOf('chrome');
		userAgent = userAgent.substring(userAgent.indexOf('chrome/') +7);
		userAgent = userAgent.substring(0,userAgent.indexOf('.'));	
		version = userAgent;
		if (version < 3) 
		{
			return true;
		}
		return false;
}


function getBadBrowser(c_name) {
	if (document.cookie.length > 0) {
		c_start = document.cookie.indexOf(c_name + "=");
		if (c_start != -1) {
			c_start = c_start + c_name.length + 1;
			c_end   = document.cookie.indexOf(";",c_start);
			if (c_end == -1) {
				c_end = document.cookie.length;
			}
			return unescape(document.cookie.substring(c_start,c_end));
		} 
	}
	return "";
}

function setBadBrowser(c_name,value,expiredays) {
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + expiredays);
	document.cookie = c_name + "=" + escape(value) + ((expiredays === null) ? "" : ";expires=" + exdate.toGMTString());
}

if(badBrowser() && getBadBrowser('browserWarning') != 'seen') {
	$(function() {
		// Here you go with translating the content of the box
		alert("ATTETION!! Your browser is no longer supported by Linways. Please upgrade to a latest version. Preferred browsers FireFox, Safari or Chrome");
               $("<div id='browserWarning'><strong>ATTENTION:</strong> You are using an unsupported browser. Please update your browser: <a href='http://getfirefox.com'>FireFox</a>, <a href='http://www.apple.com/safari/'>Safari</a>, or <a href='http://www.google.com/chrome'>Chrome</a>. Thanks! &nbsp; [<a href='#' id='warningClose'>Close</a>] </div>")
			// Delete the following to get full control over the style
			// of the warning box and style it through your stylesheet
			.css({
				'backgroundColor': '#fcffd1',
				'width': '100%',
				'border-top': 'solid 1px #7F0000',
				'border-bottom': 'solid 1px #7F0000',
				'text-align': 'center',
				'padding':'5px 0px 5px 0px'
			})
			// Last step is to prepend the just created DIV to the
			// opening <body>-Tag
			.prependTo("body");
		// This generates the "close" link
		// You have the possibility to set up the closing speed of the box
		// just enter something different to the slow statement at slideUp
		$('#warningClose').click(function(){
			setBadBrowser('browserWarning','seen');
			$('#browserWarning').slideUp('slow');
			return false;
		});
	});
}
