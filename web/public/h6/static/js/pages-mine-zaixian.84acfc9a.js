(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-mine-zaixian"],{"3f4f":function(t,n,e){"use strict";e.r(n);var a=e("cbfb"),u=e.n(a);for(var r in a)"default"!==r&&function(t){e.d(n,t,(function(){return a[t]}))}(r);n["default"]=u.a},a20a:function(t,n,e){"use strict";e.r(n);var a=e("f142"),u=e("3f4f");for(var r in u)"default"!==r&&function(t){e.d(n,t,(function(){return u[t]}))}(r);var i,f=e("f0c5"),c=Object(f["a"])(u["default"],a["b"],a["c"],!1,null,"3b4759f2",null,!1,a["a"],i);n["default"]=c.exports},cbfb:function(t,n,e){"use strict";(function(t){Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var e={data:function(){return{url:getApp().globalData.url,webview:""}},onLoad:function(){var n=this;uni.request({url:this.$url+"/chat",success:function(e){n.webview=e.data.data,t.log(e.data.data)}})}};n.default=e}).call(this,e("5a52")["default"])},f142:function(t,n,e){"use strict";var a;e.d(n,"b",(function(){return u})),e.d(n,"c",(function(){return r})),e.d(n,"a",(function(){return a}));var u=function(){var t=this,n=t.$createElement,e=t._self._c||n;return e("v-uni-view",[t.webview?e("v-uni-web-view",{attrs:{src:t.webview}}):t._e()],1)},r=[]}}]);