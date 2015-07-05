var BROWSER = {};
/**
* 判断是否null
* @param data
*/
function IsEmpty(data){
	return (data == "" || data == undefined || data == null) ? true : false;
}

/**
* 判断是否空
* @param data
*/
function IsNull(data){
	return (data == "" || data == undefined || data == null) ? true : false;
}

function _attachEvent(obj, evt, func, eventobj) {
	eventobj = !eventobj ? obj : eventobj;
	if(obj.addEventListener) {
		obj.addEventListener(evt, func, false);
	} else if(eventobj.attachEvent) {
		obj.attachEvent('on' + evt, func);
	}
}

function _detachEvent(obj, evt, func, eventobj) {
	eventobj = !eventobj ? obj : eventobj;
	if(obj.removeEventListener) {
		obj.removeEventListener(evt, func, false);
	} else if(eventobj.detachEvent) {
		obj.detachEvent('on' + evt, func);
	}
}

function setcookie(cookieName, cookieValue, seconds, path, domain, secure) {
	if(cookieValue == '' || seconds < 0) {
		cookieValue = '';
		seconds = -2592000;
	}
	if(seconds) {
		var expires = new Date();
		expires.setTime(expires.getTime() + seconds * 1000);
	}
	domain = !domain ? cookiedomain : domain;
	path = !path ? cookiepath : path;
	document.cookie = escape(cookiepre + cookieName) + '=' + escape(cookieValue)
		+ (expires ? '; expires=' + expires.toGMTString() : '')
		+ (path ? '; path=' + path : '/')
		+ (domain ? '; domain=' + domain : '')
		+ (secure ? '; secure' : '');
}

function getcookie(name, nounescape) {
	name = cookiepre + name;
	var cookie_start = document.cookie.indexOf(name);
	var cookie_end = document.cookie.indexOf(";", cookie_start);
	if(cookie_start == -1) {
		return '';
	} else {
		var v = document.cookie.substring(cookie_start + name.length + 1, (cookie_end > cookie_start ? cookie_end : document.cookie.length));
		return !nounescape ? unescape(v) : v;
	}
}

function doane(event, preventDefault, stopPropagation) {
	var preventDefault = isUndefined(preventDefault) ? 1 : preventDefault;
	var stopPropagation = isUndefined(stopPropagation) ? 1 : stopPropagation;
	e = event ? event : window.event;
	if(!e) {
		e = getEvent();
	}
	if(!e) {
		return null;
	}
	if(preventDefault) {
		if(e.preventDefault) {
			e.preventDefault();
		} else {
			e.returnValue = false;
		}
	}
	if(stopPropagation) {
		if(e.stopPropagation) {
			e.stopPropagation();
		} else {
			e.cancelBubble = true;
		}
	}
	return e;
}

function isUndefined(variable) {
	return typeof variable == 'undefined' ? true : false;
}

function altStyle(obj, disabled) {
	function altStyleClear(obj) {
		var input, lis, i;
		lis = obj.parentNode.getElementsByTagName('li');
		for(i=0; i < lis.length; i++){
			lis[i].className = '';
		}
	}
	var disabled = !disabled ? 0 : disabled;
	if(disabled) {
		return;
	}

	var input, lis, i, cc, o;
	cc = 0;
	lis = obj.getElementsByTagName('li');
	for(i=0; i < lis.length; i++){
		lis[i].onclick = function(e) {
			o = BROWSER.ie ? event.srcElement.tagName : e.target.tagName;
			altKey = BROWSER.ie ? window.event.altKey : e.altKey;
			if(cc) {
				return;
			}
			cc = 1;
			input = this.getElementsByTagName('input')[0];
			if(input.getAttribute('type') == 'checkbox' || input.getAttribute('type') == 'radio') {
				if(input.getAttribute('type') == 'radio') {
					altStyleClear(this);
				}

				if(BROWSER.ie || o != 'INPUT' && input.onclick) {
					input.click();
				}
				if(this.className != 'checked') {
					this.className = 'checked';
					input.checked = true;
				} else {
					this.className = '';
					input.checked = false;
				}
				if(altKey && input.name.match(/^multinew\[\d+\]/)) {
					miid = input.id.split('|');
					mi = 0;
					while($(miid[0] + '|' + mi)) {
						$(miid[0] + '|' + mi).checked = input.checked;
						if(input.getAttribute('type') == 'radio') {
							altStyleClear($(miid[0] + '|' + mi).parentNode);
						}
						$(miid[0] + '|' + mi).parentNode.className = input.checked ? 'checked' : '';
						mi++;
					}
				}
			}
		};
		lis[i].onmouseup = function(e) {
			cc = 0;
		}
	}
}

function setfaq(obj, id) {
	if(!$('#'+id)) {
		return;
	}
	$('#'+id)[0].style.display = '';
	if(!obj.onmouseout) {
		obj.onmouseout = function () {
			$('#'+id)[0].style.display = 'none';
		}
	}
}

//AJAX多次返回，最后一次，Iframe的onload函数
function PostReturnIframe(SourceElement){
	for(var i=1;i<=window.PostReturnCallbackTimer.length;i++){
		window.clearTimeout(window.PostReturnCallbackTimer[i]);
	}
	var dataHtml=$.trim($(SourceElement).contents().find("body").html());
	if(!IsEmpty(dataHtml)){
		var data=eval("("+dataHtml+")");
		easyDialog.open({
			container : {
				content : data.msg
			},
			autoClose : 1000*parseInt(data.autoClose),
			callback : function(){PostReturnIframeCalback(data);}
		});
	}
}
//AJAX多次返回，最后一次
function PostReturnIframeCallback(dataHtml){
	for(var i=1;i<=window.PostReturnCallbackTimer.length;i++){
		window.clearTimeout(window.PostReturnCallbackTimer[i]);
	}
	if(!IsEmpty(dataHtml)){
		var data=eval("("+dataHtml+")");
		easyDialog.open({
			container : {
				content : data.msg
			},
			autoClose : 1000*parseInt(data.autoClose),
			callback : function(){PostReturnIframeCalback(data);}
		});
	}
}

//AJAX多次返回，从第一次至倒数第二次
window.PostReturnCallbackDelay=800;
window.PostReturnCallbackDelayCount=0;
window.PostReturnCallbackIndex=0;
window.PostReturnCallbackStarttime=0;
window.PostReturnCallbackTimes=new Array();
window.PostReturnCallbackTimer=new Array();
function PostReturnCallback(dataHtml){	
	window.PostReturnCallbackIndex=window.PostReturnCallbackIndex+1;
	if(window.PostReturnCallbackStarttime==0){
		var Starttime=new Date();
		window.PostReturnCallbackStarttime=Starttime.getTime();
	}
	var Currenttime=new Date();
	var NowTime=Currenttime.getTime();
	window.PostReturnCallbackTimes[window.PostReturnCallbackIndex]=Currenttime.getTime();
	var TimeoutDelay=window.PostReturnCallbackDelay;
	if(window.PostReturnCallbackIndex>1){
		var PrevTime=window.PostReturnCallbackTimes[window.PostReturnCallbackIndex-1];		
		window.PostReturnCallbackDelayCount=window.PostReturnCallbackDelayCount+NowTime-PrevTime;
		TimeoutDelay=window.PostReturnCallbackDelay*(window.PostReturnCallbackIndex-1)-window.PostReturnCallbackDelayCount;
		if(TimeoutDelay<=0){
			window.PostReturnCallbackDelayCount=window.PostReturnCallbackDelayCount+TimeoutDelay;
		}
	}else{
		TimeoutDelay=0;
	}
	window.PostReturnCallbackTimer[window.PostReturnCallbackIndex]=setTimeout(function(){easyDialog.open({container : {content : dataHtml}});},TimeoutDelay);	
}

//AJAX返回提示的回调函数
function PostReturnIframeCalback(ReturnData){
	if($.trim(ReturnData.url)==''){
		return;
	}else if($.trim(ReturnData.url)=='reload'){
		location.reload();
	}else{
		location.href=unescape(ReturnData.url);	
	}	
}