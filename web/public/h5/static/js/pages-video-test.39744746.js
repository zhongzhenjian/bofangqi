(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-video-test"],{"6fef":function(e,t,n){"use strict";n.r(t);var i=n("f619"),r=n.n(i);for(var d in i)"default"!==d&&function(e){n.d(t,e,(function(){return i[e]}))}(d);t["default"]=r.a},ba9d:function(e,t,n){"use strict";var i;n.d(t,"b",(function(){return r})),n.d(t,"c",(function(){return d})),n.d(t,"a",(function(){return i}));var r=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("v-uni-view",{staticClass:"content"},[n("v-uni-view",{ref:"video",staticClass:"video-js"})],1)},d=[]},cc2d:function(e,t,n){"use strict";n.r(t);var i=n("ba9d"),r=n("6fef");for(var d in r)"default"!==d&&function(e){n.d(t,e,(function(){return r[e]}))}(d);var a,u=n("f0c5"),c=Object(u["a"])(r["default"],i["b"],i["c"],!1,null,"00c4f1ad",null,!1,i["a"],a);t["default"]=c.exports},f619:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var i={onReady:function(){var e=document.createElement("video");e.id="video",e.style="width: 100%;height: 220px;",e.setAttribute("poster","http://154.64.2.4:45//uploads/20220109/0fad507b6fc2ebb2edda5fb8336ec6b2.png"),e.controls=!0;var t=document.createElement("source");t.src="http://192.168.0.100/3.mp4",e.appendChild(t),this.$refs.video.$el.appendChild(e),videojs("video")},methods:{}};t.default=i}}]);