/*---------------------------------------------------------------

 WP-AutoPagerize.js
 encoding UTF-8

 Copyright (c) 2010 nori (norimania@gmail.com)
 5509 - http://5509.me/
 Licensed under the GPL

 $LastChangedDate: 2010-06-02 21:45:02 -0500 (Wed, 02 Jun 2010) $
 $Date: 2009-01-25 03:30
 
 ----------------------------------------------------------------*/
 
if ( !wpPageRizeCallback || typeof wpPageRizeCallback != 'function' ) {
	var wpPageRizeCallback = function(){};
}
if ( !wpPageRizeBeforeCall || typeof wpPageRizeBeforeCall != 'function' ) {
	var wpPageRizeBeforeCall = function(){};
}
if ( !wpPageRizeCustomInsertPos ) {
	var wpPageRizeCustomInsertPos = false;
}
if ( wpPageRizePageNumberFalse == undefined ) {
	var wpPageRizePageNumberFalse = true;
}

(function() {
	var wpPageRize = getElementsByClassName('div', 'wpPageRize')[0];
	if ( !wpPageRize || wpPageRize==undefined ) return false;
	
	var dE = document.documentElement,
		$d = function(id) { return document.getElementById(id); },
		$c = function(elm) { return document.createElement(elm); },
		defaultPage = 2,
		pageBlockSeperator = $c('div'),
		pageBlockSeperatorText = 'Page: ',
		d = wpPageRizeDefaultCondition == 1 ?
			1 :
			existCookie() ?
				0 : 1,
		autoLoad = d == 0 ? true : false,
		loadingFlg = false,
		loading = $c('span'),
		loadingImg = new Image(),
		loadingIcon = new Image(),
		defaultIcon = new Image(),
		disabledIcon = new Image(),
		parentBlock = wpPageRize.parentNode,
		nextURL = getElementsByClassName('a', 'next', wpPageRize)[0] ? 
			getElementsByClassName('a', 'next', wpPageRize)[0].href
			: false;
	
	if ( !nextURL ) return false;
	pageBlockSeperator.className = 'autopagerize_page_info';
	
	// Loading Icons
	loading.id = 'wpPageRizeLoading';
	loading.appendChild(loadingImg);
	loadingIcon.src = wpPageRizeFullPath + 'icon-loading.gif';
	defaultIcon.src = wpPageRizeFullPath + 'icon-default.gif';
	disabledIcon.src = wpPageRizeFullPath + 'icon-disabled.gif';
	
	// AutoPagerize
	if ( wpPageRizeLoadingMethod == '0' ) {
		if ( d == 0 ) {
			loadingImg.src = defaultIcon.src;
		} else {
			loadingImg.src = disabledIcon.src;
		}
	// ButtonPagerize
	} else {
		autoLoad = true;
		loadingImg.src = defaultIcon.src;
	}
		
	var insertPos = $c('div');
	if ( wpPageRizeCustomInsertPos ) {
		insertPos = $d(wpPageRizeCustomInsertPos);
		parentBlock = insertPos.parentNode;
	} else {
		insertPos.id = 'wpPageRizeInsertPos';
		parentBlock.insertBefore(insertPos, wpPageRize);
	}
	
	addLoadingTrigger();
	if ( wpPageRizeLoadingMethod == '0' ) {
		wpPageRize.insertBefore(loading, wpPageRize.firstChild);
		addEvent(loading, 'click', function(){
			if ( autoLoad ) {
				autoLoad = false;
				setCookieOn(true);
				loadingImg.src = disabledIcon.src;
			} else {
				autoLoad = true;
				setCookieOn();
				loadingImg.src = defaultIcon.src;
			}
		});
	} else {
		var loadingButtonWrapper = $d('wpLoadingButton');
		loadingButtonWrapper.insertBefore(loading, loadingButtonWrapper.firstChild);
	}
	
	pageRizeTarget = wpPageRizeClassName.split('.');
	var posts = getElementsByClassName(pageRizeTarget[0], pageRizeTarget[1]);

	var xhr = false;
	if ( typeof window.ActiveXObject != 'undefined' ) {
		try {
			xhr = new window.ActiveXObject('Microsoft.XMLHTTP');
		} catch (e) {
			xhr = false;
		}
	}
	if ( !xhr && typeof window.XMLHttpRequest != 'undefined' ) {
		xhr = new window.XMLHttpRequest();
	}
	
	function loadingNextPage() {		
		if ( !nextURL ) return false;
		if ( loadingFlg ) return false;
		if ( !autoLoad ) return false;
		
		loadingFlg = true;
		
		loadingImg.src = loadingIcon.src;
		if ( wpPageRizeLoadingMethod != '0' ) {
			$d('wpLoadingButton').className = 'loading';
		}
		xhr.open('GET', nextURL, 'True');
		xhr.onreadystatechange = function() {
			if ( xhr.readyState == 4 && xhr.status == 200 ) {
				var html =  document.createElement('div');
				html.innerHTML = xhr.responseText.replace(/<script(?:[ \t\r\n][^>]*)?>[\S\s]*?<\/script[ \t\r\n]*>|<\/?(?:i?frame|html|script|object)(?:[ \t\r\n][^<>]*)?>/gi, '');
				var appendPosts = getElementsByClassName(pageRizeTarget[0], pageRizeTarget[1], html),
					loadingPageRize = getElementsByClassName('div', 'wpPageRize', html)[0];
					
				pageBlockSeperator.innerHTML = pageBlockSeperatorText + '<a href="' + nextURL + '">' + defaultPage++ + '</a>';
				nextURL = getElementsByClassName('a', 'next', loadingPageRize) ?
					getElementsByClassName('a', 'next', loadingPageRize)[0]
					: false;
					
				// BeforeCall
				wpPageRizeBeforeCall();
					
				// Replace the pager
				if ( wpPageRizeLoadingMethod == '0' ) {
					wpPageRize.removeChild(wpPageRize.lastChild);
					insertAfter(wpPageRize, loadingPageRize.firstChild, loading);
				} else {
					wpPageRize.removeChild(wpPageRize.firstChild);
					wpPageRize.appendChild(loadingPageRize.firstChild);
				}
				
				loadingImg.src = defaultIcon.src;
				if ( wpPageRizeLoadingMethod != '0' ) {
					var postsInsertPos = $d('wpLoadingButton');
					$d('wpLoadingButton').className = '';
				} else {
					var postsInsertPos = insertPos;
				}
				if ( wpPageRizePageNumberFalse ) {
					parentBlock.insertBefore(pageBlockSeperator.cloneNode(true) ,postsInsertPos);
				}
				for ( var i=0; i<appendPosts.length; i++ ) {
					parentBlock.insertBefore(appendPosts[i], postsInsertPos);
				}
				// Callback
				wpPageRizeCallback();
				
				addLoadingTrigger();
				loadingFlg = false;	
			}
		}
		xhr.send(null);
	}
		
	// Get target elms by class
	// * is not able to use for the 'node'
	function getElementsByClassName(node, className, parentNode) {
		var parent = parentNode ? parentNode : document;
		var reg = new RegExp(className),
			elms = parent.getElementsByTagName(node),
			returnElms = [];
		for ( var i=0; i<elms.length; i++ ) {
			if ( reg.test(elms[i].className) ) {
				returnElms.push(elms[i]);
			}
		}
		return returnElms;
	}

	function addLoadingTrigger() {
		if ( wpPageRizeLoadingMethod == '0' ) {
			var pageRizeTop = wpPageRize.offsetTop;
			// Add fn
			addEvent(document, 'mousemove', function(e) {
				pageRizeTop = wpPageRize.offsetTop;
				var pageY = e.pageY ? e.pageY : event.clientY + dE.scrollTop;
				if ( autoLoad && pageY >= ( pageRizeTop + wpPageRize.offsetHeight ) ) {
					removeEvent(document, 'mousemove', arguments.callee);
					loadingNextPage();
				}
			});
		} else {
			if ( !nextURL ) {
				if ( $d('wpLoadingButton') ) {
					$d('wpLoadingButton').parentNode.removeChild($d('wpLoadingButton'));
					return;
				}
			}
			if ( $d('wpLoadingButton') ) return false;
			var loadingButtonWrapper = $c('div'),
				loadingButton = $c('a');
				
			loadingButtonWrapper.id = 'wpLoadingButton';
			loadingButton.innerHTML = wpPageRizeButtonValue;
			loadingButton.href = 'javascript: void(0)';
			addEvent(loadingButtonWrapper, 'click', loadingNextPage);
			loadingButtonWrapper.appendChild(loadingButton);
			parentBlock.insertBefore(loadingButtonWrapper, insertPos);
			//parentBlock.insertBefore(loadingButtonWrapper, wpPageRize);
		}
	}
	
	function setCookieOn(clear) {
		var date = new Date();
		if ( clear ) {
			date.setTime(date.getTime() + (-1));
			document.cookie = 'wpPageRize=;expires=' + date.toUTCString() +';';
		} else {
			date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
			document.cookie = 'wpPageRize=ON;expires=' + date.toUTCString() + ';path=/';
		}
	}
	function existCookie() {
		if ( /wpPageRize\=[^\;]+/.test(document.cookie) )
			return true;
		else
			return false;
	}
		
	// AddEvent
	function addEvent(elm, listener, fn)  {
		if ( elm.attachEvent ) {
			elm['e'+listener+fn] = fn;
			elm[listener+fn] = function(){elm['e'+listener+fn]( window.event );}
			elm.attachEvent( 'on'+listener, elm[listener+fn] );
		} else
			elm.addEventListener( listener, fn, false );
	}
	// RemoveEvent
	function removeEvent(elm, listener, fn) {
		try {
			elm.removeEventListener(listener, fn, false);
		} catch (e) {
			elm.detachEvent('on' + listener, fn);
		}
	}
	
	// InsertAfter
	function insertAfter(parent, node, referenceNode) {
		parent.insertBefore(node, referenceNode.nextSibling);
	}

})();