(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-start-first"],{"292e":function(t,n,a){var e=a("24fb");n=e(!1),n.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */\n/*\n  .time {\n    position: fixed;\n    top: 30px;\n    right: 20rpx;\n    width: 100rpx;\n    height: 100rpx;\n    border-radius: 100rpx;\n    background-color: #dddadf;\n    text-align: center;\n    line-height: 100rpx;\n    font-size: 50rpx;\n    z-index: 999;\n  }\n*/.time[data-v-c5337e34]{position:fixed;top:45px;right:%?55?%;width:%?100?%;height:%?100?%;border-radius:%?100?%;background-color:#dddadf;text-align:center;line-height:%?100?%;font-size:%?50?%;z-index:999}',""]),t.exports=n},"359a":function(t,n,a){"use strict";a.r(n);var e=a("8ac0"),i=a.n(e);for(var r in e)"default"!==r&&function(t){a.d(n,t,(function(){return e[t]}))}(r);n["default"]=i.a},"35d3":function(t,n,a){"use strict";a.r(n);var e=a("e8ef"),i=a("359a");for(var r in i)"default"!==r&&function(t){a.d(n,t,(function(){return i[t]}))}(r);a("6d64");var o,s=a("f0c5"),u=Object(s["a"])(i["default"],e["b"],e["c"],!1,null,"01c8b901",null,!1,e["a"],o);n["default"]=u.exports},"4e1e":function(t,n,a){var e=a("24fb");n=e(!1),n.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.hide-image[data-v-01c8b901]{transition-duration:.5s;transition-property:opacity;opacity:0!important}.lazy[data-v-01c8b901]{position:relative}.lazy-image[data-v-01c8b901]{position:absolute;top:0;left:0}.lazy-load[data-v-01c8b901]{position:absolute;transition-duration:.5s;transition-property:opacity;top:0;left:0;z-index:10;opacity:1}',""]),t.exports=n},"53bb":function(t,n,a){"use strict";a.r(n);var e=a("c7a8"),i=a.n(e);for(var r in e)"default"!==r&&function(t){a.d(n,t,(function(){return e[t]}))}(r);n["default"]=i.a},"5f72":function(t,n,a){"use strict";a.r(n);var e=a("8d2e"),i=a("53bb");for(var r in i)"default"!==r&&function(t){a.d(n,t,(function(){return i[t]}))}(r);a("ab35");var o,s=a("f0c5"),u=Object(s["a"])(i["default"],e["b"],e["c"],!1,null,"c5337e34",null,!1,e["a"],o);n["default"]=u.exports},"6d64":function(t,n,a){"use strict";var e=a("90a6"),i=a.n(e);i.a},"8ac0":function(t,n,a){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var e={props:{src:{type:String,default:""},image:{type:String,default:"/static/images/51.png"},mode:{type:String,default:"scaleToFill"},borderRadius:{type:String,default:"10rpx"},width:{type:String,default:"100rpx"},height:{type:String,default:"100rpx"}},data:function(){return{is_load:!0}},methods:{showimage:function(){this.is_load=!1}}};n.default=e},"8d2e":function(t,n,a){"use strict";var e;a.d(n,"b",(function(){return i})),a.d(n,"c",(function(){return r})),a.d(n,"a",(function(){return e}));var i=function(){var t=this,n=t.$createElement,a=t._self._c||n;return a("v-uni-view",{on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.openurl.apply(void 0,arguments)}}},[a("lazy",{attrs:{image:"/static/WechatIMG560.png",src:t.guanggao.image_text,width:"750rpx",height:"100vh"}}),a("v-uni-view",{staticClass:"time",on:{click:function(n){n.stopPropagation(),arguments[0]=n=t.$handleEvent(n),t.toindex.apply(void 0,arguments)}}},[t._v(t._s(t.time))])],1)},r=[]},"90a6":function(t,n,a){var e=a("4e1e");"string"===typeof e&&(e=[[t.i,e,""]]),e.locals&&(t.exports=e.locals);var i=a("4f06").default;i("e9474b1a",e,!0,{sourceMap:!1,shadowMode:!1})},ab35:function(t,n,a){"use strict";var e=a("eb26"),i=a.n(e);i.a},c7a8:function(t,n,a){"use strict";(function(t){var e=a("4ea4");Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var i=e(a("35d3")),r={data:function(){return{guanggao:[],time:5,daojishi:""}},onLoad:function(){var t=this;uni.request({url:this.$url+"/api/adv/others",data:{class:2},success:function(n){if(uni.hideLoading(),n.data.data.length>0)if(uni.getStorageSync("firstguanggao")){var a=uni.getStorageSync("firstguanggao");a>=n.data.data.length?(uni.setStorageSync("firstguanggao",1),t.guanggao=n.data.data[0]):(a++,uni.setStorageSync("firstguanggao",a),t.guanggao=n.data.data[a-1])}else uni.setStorageSync("firstguanggao",1),t.guanggao=n.data.data[0];t.start()}})},methods:{openurl:function(){t.log(this.guanggao),this.$openurl(this.guanggao.url)},start:function(){var t=this;this.daojishi=setInterval((function(){t.time--,0==t.time&&(t.time="X",clearInterval(t.daojishi))}),1e3)},toindex:function(){uni.reLaunch({url:"../video/video"})}},components:{lazy:i.default},created:function(){this.toindex()}};n.default=r}).call(this,a("5a52")["default"])},e8ef:function(t,n,a){"use strict";var e;a.d(n,"b",(function(){return i})),a.d(n,"c",(function(){return r})),a.d(n,"a",(function(){return e}));var i=function(){var t=this,n=t.$createElement,a=t._self._c||n;return a("v-uni-view",{staticClass:"lazy",style:{"border-radius":t.borderRadius,width:t.width,height:t.height}},[a("v-uni-image",{staticClass:"lazy-image",style:{"border-radius":t.borderRadius,width:t.width,height:t.height},attrs:{src:t.src,mode:t.mode},on:{load:function(n){arguments[0]=n=t.$handleEvent(n),t.showimage.apply(void 0,arguments)}}}),a("v-uni-image",{staticClass:"lazy-load",class:t.is_load?"":"hide-image",style:{"border-radius":t.borderRadius,width:t.width,height:t.height},attrs:{src:t.image,mode:t.mode}})],1)},r=[]},eb26:function(t,n,a){var e=a("292e");"string"===typeof e&&(e=[[t.i,e,""]]),e.locals&&(t.exports=e.locals);var i=a("4f06").default;i("57e2b906",e,!0,{sourceMap:!1,shadowMode:!1})}}]);