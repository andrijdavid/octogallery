var _showOrHideTimeout,_showOrHide=function(t,i,e,o){_showOrHideTimeout&&clearTimeout(_showOrHideTimeout),_initialZoomRunning=!0,_initialContentSet=!0;var a;t.initialLayout?(a=t.initialLayout,t.initialLayout=null):a=_options.getThumbBoundsFn&&_options.getThumbBoundsFn(_currentItemIndex);var n=e?_options.hideAnimationDuration:_options.showAnimationDuration,l=function(){_stopAnimation("initialZoom"),e?(self.template.removeAttribute("style"),self.bg.removeAttribute("style")):(_applyBgOpacity(1),i&&(i.style.display="block"),framework.addClass(template,"pswp--animated-in"),_shout("initialZoom"+(e?"OutEnd":"InEnd"))),o&&o(),_initialZoomRunning=!1};if(!n||!a||void 0===a.x){var r=function(){_shout("initialZoom"+(e?"Out":"In")),_currZoomLevel=t.initialZoomLevel,_equalizePoints(_panOffset,t.initialPosition),_applyCurrentZoomPan(),template.style.opacity=e?0:1,_applyBgOpacity(1),l()};return void r()}var s=function(){var i=_closedByScroll,o=!self.currItem.src||self.currItem.loadError||_options.showHideOpacity;t.miniImg&&(t.miniImg.style.webkitBackfaceVisibility="hidden"),e||(_currZoomLevel=a.w/t.w,_panOffset.x=a.x,_panOffset.y=a.y-_initalWindowScrollY,self[o?"template":"bg"].style.opacity=.001,_applyCurrentZoomPan()),_registerStartAnimation("initialZoom"),e&&!i&&framework.removeClass(template,"pswp--animated-in"),o&&(e?framework[(i?"remove":"add")+"Class"](template,"pswp--animate_opacity"):setTimeout(function(){framework.addClass(template,"pswp--animate_opacity")},30)),_showOrHideTimeout=setTimeout(function(){if(_shout("initialZoom"+(e?"Out":"In")),e){var r=a.w/t.w,s={x:_panOffset.x,y:_panOffset.y},m=_currZoomLevel,p=_bgOpacity,u=function(t){1===t?(_currZoomLevel=r,_panOffset.x=a.x,_panOffset.y=a.y-_currentWindowScrollY):(_currZoomLevel=(r-m)*t+m,_panOffset.x=(a.x-s.x)*t+s.x,_panOffset.y=(a.y-_currentWindowScrollY-s.y)*t+s.y),_applyCurrentZoomPan(),o?template.style.opacity=1-t:_applyBgOpacity(p-t*p)};i?_animateProp("initialZoom",0,1,n,framework.easing.cubic.out,u,l):(u(1),_showOrHideTimeout=setTimeout(l,n+20))}else _currZoomLevel=t.initialZoomLevel,_equalizePoints(_panOffset,t.initialPosition),_applyCurrentZoomPan(),_applyBgOpacity(1),o?template.style.opacity=1:_applyBgOpacity(1),_showOrHideTimeout=setTimeout(l,n+20)},e?25:90)};s()};