(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-mine-duihuan"],{"0115":function(n,t,a){"use strict";a.d(t,"b",(function(){return i})),a.d(t,"c",(function(){return e})),a.d(t,"a",(function(){}));var i=function(){var n=this,t=n.$createElement,a=n._self._c||t;return a("v-uni-view",[a("v-uni-view",{staticClass:"header"},[a("v-uni-image",{attrs:{src:n.userdata.avatar_text}}),a("v-uni-text",[n._v(n._s(n.userdata.username)+"欢迎光临！")])],1),a("v-uni-view",{staticClass:"duihuan"},[a("v-uni-input",{attrs:{type:"text",placeholder:"请输入兑换码"},model:{value:n.duihuanma,callback:function(t){n.duihuanma=t},expression:"duihuanma"}}),a("v-uni-view",{on:{click:function(t){arguments[0]=t=n.$handleEvent(t),n.toduihuan.apply(void 0,arguments)}}},[n._v("确认兑换")])],1),a("v-uni-view",{staticClass:"xian"}),a("br"),a("v-uni-view",{staticClass:"title1"},[n._v("1.输入兑换码激活会员")]),a("br"),a("v-uni-view",{staticClass:"title2"},[n._v('2.若无兑换码请转至 "分享得VIP" 推广获得会员')])],1)},e=[]},"16a3":function(n,t,a){"use strict";a.r(t);var i=a("83c6"),e=a.n(i);for(var u in i)["default"].indexOf(u)<0&&function(n){a.d(t,n,(function(){return i[n]}))}(u);t["default"]=e.a},"1f19":function(n,t,a){var i=a("a731");i.__esModule&&(i=i.default),"string"===typeof i&&(i=[[n.i,i,""]]),i.locals&&(n.exports=i.locals);var e=a("4f06").default;e("6917353b",i,!0,{sourceMap:!1,shadowMode:!1})},"83c6":function(n,t,a){"use strict";(function(n){a("7a82"),Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var i={data:function(){return{userdata:[],duihuanma:""}},onLoad:function(){this.userdata=uni.getStorageSync("userinfo"),n.log(this.userdata)},methods:{toduihuan:function(){this.$loading(),uni.request({url:this.$url+"/api/Exchange/add",method:"POST",header:{token:uni.getStorageSync("usertoken")},data:{code:this.duihuanma},success:function(n){uni.hideLoading(),uni.showToast({icon:"none",title:n.data.msg})}})}}};t.default=i}).call(this,a("5a52")["default"])},9651:function(n,t,a){"use strict";a.r(t);var i=a("0115"),e=a("16a3");for(var u in e)["default"].indexOf(u)<0&&function(n){a.d(t,n,(function(){return e[n]}))}(u);a("ceb9");var d=a("f0c5"),r=Object(d["a"])(e["default"],i["b"],i["c"],!1,null,"2071877b",null,!1,i["a"],void 0);t["default"]=r.exports},a731:function(n,t,a){var i=a("24fb");t=i(!1),t.push([n.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.xian[data-v-2071877b]{height:%?10?%;width:%?750?%;background-color:rgba(0,0,0,.1)}.duihuan[data-v-2071877b]{display:flex;align-items:center;justify-content:space-between;padding:%?32?%}.duihuan uni-input[data-v-2071877b]{border:%?2?% solid #c0c4cc;width:%?450?%;height:%?80?%;border-radius:%?10?%;text-indent:%?20?%}.duihuan uni-view[data-v-2071877b]{width:%?200?%;height:%?80?%;line-height:%?80?%;text-align:center;background:#ef4f67;color:#fff;border-radius:%?10?%;font-size:%?30?%}.header[data-v-2071877b]{display:flex;align-items:center}.header uni-image[data-v-2071877b]{width:%?80?%;height:%?80?%;border-radius:%?100?%;margin:%?32?%}.header uni-text[data-v-2071877b]{font-size:%?32?%}.title1[data-v-2071877b]{font-size:%?32?%;font-family:PingFangSC-Medium,PingFang SC;font-weight:500;color:#666;margin:%?2?% 0 0 %?35?%}.title2[data-v-2071877b]{font-size:%?30?%;font-family:PingFangSC-Medium,PingFang SC;font-weight:500;color:#666;margin:%?0?% 0 0 %?35?%}',""]),n.exports=t},ceb9:function(n,t,a){"use strict";var i=a("1f19"),e=a.n(i);e.a}}]);