var _wheelDelta;_registerModule("DesktopZoom",{publicMethods:{initDesktopZoom:function(){_oldIE||(_likelyTouchDevice?_listen("mouseUsed",function(){self.setupDesktopZoom()}):self.setupDesktopZoom(!0))},setupDesktopZoom:function(e){_wheelDelta={};var o="wheel mousewheel DOMMouseScroll";_listen("bindEvents",function(){framework.bind(template,o,self.handleMouseWheel)}),_listen("unbindEvents",function(){_wheelDelta&&framework.unbind(template,o,self.handleMouseWheel)}),self.mouseZoomedIn=!1;var l,t=function(){self.mouseZoomedIn&&(framework.removeClass(template,"pswp--zoomed-in"),self.mouseZoomedIn=!1),_currZoomLevel<1?framework.addClass(template,"pswp--zoom-allowed"):framework.removeClass(template,"pswp--zoom-allowed"),a()},a=function(){l&&(framework.removeClass(template,"pswp--dragging"),l=!1)};_listen("resize",t),_listen("afterChange",t),_listen("pointerDown",function(){self.mouseZoomedIn&&(l=!0,framework.addClass(template,"pswp--dragging"))}),_listen("pointerUp",a),e||t()},handleMouseWheel:function(e){if(_currZoomLevel<=self.currItem.fitRatio)return _options.modal&&(!_options.closeOnScroll||_numAnimations||_isDragging?e.preventDefault():_transformKey&&Math.abs(e.deltaY)>2&&(_closedByScroll=!0,self.close())),!0;if(e.stopPropagation(),_wheelDelta.x=0,"deltaX"in e)1===e.deltaMode?(_wheelDelta.x=18*e.deltaX,_wheelDelta.y=18*e.deltaY):(_wheelDelta.x=e.deltaX,_wheelDelta.y=e.deltaY);else if("wheelDelta"in e)e.wheelDeltaX&&(_wheelDelta.x=-.16*e.wheelDeltaX),e.wheelDeltaY?_wheelDelta.y=-.16*e.wheelDeltaY:_wheelDelta.y=-.16*e.wheelDelta;else{if(!("detail"in e))return;_wheelDelta.y=e.detail}_calculatePanBounds(_currZoomLevel,!0);var o=_panOffset.x-_wheelDelta.x,l=_panOffset.y-_wheelDelta.y;(_options.modal||o<=_currPanBounds.min.x&&o>=_currPanBounds.max.x&&l<=_currPanBounds.min.y&&l>=_currPanBounds.max.y)&&e.preventDefault(),self.panTo(o,l)},toggleDesktopZoom:function(e){e=e||{x:_viewportSize.x/2+_offset.x,y:_viewportSize.y/2+_offset.y};var o=_options.getDoubleTapZoom(!0,self.currItem),l=_currZoomLevel===o;self.mouseZoomedIn=!l,self.zoomTo(l?self.currItem.initialZoomLevel:o,e,333),framework[(l?"remove":"add")+"Class"](template,"pswp--zoomed-in")}}});