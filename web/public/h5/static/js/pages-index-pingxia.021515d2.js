(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-index-pingxia"],{1058:function(n,t,i){"use strict";var a;i.d(t,"b",(function(){return e})),i.d(t,"c",(function(){return c})),i.d(t,"a",(function(){return a}));var e=function(){var n=this,t=n.$createElement,a=n._self._c||t;return a("v-uni-view",{staticClass:"pingxia"},[a("v-uni-view",{staticClass:"pingxia-gg"},[a("v-uni-image",{staticClass:"pingxia-img",attrs:{src:n.item.image_text,mode:"aspectFit"},on:{click:function(t){arguments[0]=t=n.$handleEvent(t),n.openurl.apply(void 0,arguments)}}}),a("v-uni-image",{staticClass:"gonggao-close",attrs:{src:i("dbf1")},on:{click:function(t){arguments[0]=t=n.$handleEvent(t),n.closepingxia.apply(void 0,arguments)}}})],1)],1)},c=[]},6210:function(n,t,i){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var a={data:function(){return{item:[]}},onLoad:function(){this.item=uni.getStorageSync("kaiping")},methods:{openurl:function(){this.$openurl(this.item.url)},closepingxia:function(){uni.navigateBack()}}};t.default=a},"8abc":function(n,t,i){var a=i("24fb");t=a(!1),t.push([n.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.gonggao-close[data-v-9db84988]{width:%?80?%;height:%?80?%}.pingxia[data-v-9db84988]{width:%?750?%;height:100vh;display:flex;align-items:center;justify-content:center}uni-page-body[data-v-9db84988]{background-color:rgba(0,0,0,.5)}.pingxia-img[data-v-9db84988]{width:%?650?%;height:%?650?%}.pingxia-gg[data-v-9db84988]{width:%?650?%;height:%?750?%;display:flex;flex-direction:column;align-items:center;justify-content:space-between}body.?%PAGE?%[data-v-9db84988]{background-color:rgba(0,0,0,.5)}',""]),n.exports=t},"98bc":function(n,t,i){"use strict";var a=i("acce"),e=i.n(a);e.a},aa77:function(n,t,i){"use strict";i.r(t);var a=i("1058"),e=i("bc76");for(var c in e)"default"!==c&&function(n){i.d(t,n,(function(){return e[n]}))}(c);i("98bc");var o,s=i("f0c5"),r=Object(s["a"])(e["default"],a["b"],a["c"],!1,null,"9db84988",null,!1,a["a"],o);t["default"]=r.exports},acce:function(n,t,i){var a=i("8abc");"string"===typeof a&&(a=[[n.i,a,""]]),a.locals&&(n.exports=a.locals);var e=i("4f06").default;e("2a1a389a",a,!0,{sourceMap:!1,shadowMode:!1})},bc76:function(n,t,i){"use strict";i.r(t);var a=i("6210"),e=i.n(a);for(var c in a)"default"!==c&&function(n){i.d(t,n,(function(){return a[n]}))}(c);t["default"]=e.a},dbf1:function(n,t,i){n.exports=i.p+"static/img/120.79776984.png"}}]);