(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-mine-renwu"],{"19a6":function(t,n,e){"use strict";e.r(n);var i=e("a0a2"),a=e("20a6");for(var o in a)"default"!==o&&function(t){e.d(n,t,(function(){return a[t]}))}(o);e("fe31");var f,u=e("f0c5"),d=Object(u["a"])(a["default"],i["b"],i["c"],!1,null,"cdf6be32",null,!1,i["a"],f);n["default"]=d.exports},"20a6":function(t,n,e){"use strict";e.r(n);var i=e("39f2"),a=e.n(i);for(var o in i)"default"!==o&&function(t){e.d(n,t,(function(){return i[t]}))}(o);n["default"]=a.a},"39f2":function(t,n,e){"use strict";(function(t){Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var e={data:function(){return{renwulist:[],userdata:[]}},onLoad:function(){t.log(this.userdata),this.getdata()},methods:{tomine:function(){uni.switchTab({url:"./mine"})},getdata:function(){var t=this;this.$loading(),uni.request({url:this.$url+"/api/task/index",method:"POST",header:{token:uni.getStorageSync("usertoken")},success:function(n){t.renwulist=n.data.data,t.getuserinfo()}})},getuserinfo:function(){var n=this;uni.request({url:this.$url+"/api/user/personal",method:"GET",header:{token:uni.getStorageSync("usertoken")},success:function(e){uni.hideLoading(),200==e.data.code&&(n.userdata=e.data.data),t.log(e)}})}}};n.default=e}).call(this,e("5a52")["default"])},a0a2:function(t,n,e){"use strict";var i;e.d(n,"b",(function(){return a})),e.d(n,"c",(function(){return o})),e.d(n,"a",(function(){return i}));var a=function(){var t=this,n=t.$createElement,e=t._self._c||n;return e("v-uni-view",[e("v-uni-view",{staticClass:"header"},[e("v-uni-view",{staticClass:"left"},[e("v-uni-text",[t._v("积分")]),e("v-uni-text",[t._v(t._s(t.userdata.integral))])],1),e("v-uni-view",{staticClass:"right"},[t._v("LV."+t._s(t.userdata.vip))])],1),e("v-uni-view",{staticClass:"tuiguang1"},[e("v-uni-view",{staticClass:"title"},[t._v("推广任务")]),t._l(t.renwulist,(function(n,i){return e("v-uni-view",{key:i,staticClass:"item"},[e("v-uni-view",{staticClass:"left"},[e("v-uni-image",{staticClass:"logo",attrs:{src:n.image_text}}),e("v-uni-view",{staticClass:"text"},[e("v-uni-view",{staticClass:"name"},[t._v(t._s(n.name))]),e("v-uni-view",{staticClass:"detail"},[t._v(t._s(n.vip>0?"赠送"+n.vip+"天VIP":""))])],1)],1),0==n.tong?e("v-uni-view",{staticClass:"right",on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.tomine.apply(void 0,arguments)}}},[t._v("做任务")]):e("v-uni-view",{staticClass:"right"},[t._v("已完成")])],1)}))],2)],1)},o=[]},a8ef:function(t,n,e){var i=e("24fb");n=i(!1),n.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.tuiguang1[data-v-cdf6be32]{padding:0 %?32?%;background:#fff}.tuiguang1 .title[data-v-cdf6be32]{padding:%?32?% 0 0 0;font-size:%?32?%;font-family:PingFangSC-Medium,PingFang SC;font-weight:500;color:#202020}.tuiguang1 .item[data-v-cdf6be32]{display:flex;align-items:center;justify-content:space-between;padding:%?32?% 0;border-bottom:%?1?% solid #eceaea}.tuiguang1 .item .left[data-v-cdf6be32]{display:flex;align-items:center}.tuiguang1 .item .left .logo[data-v-cdf6be32]{width:%?88?%;height:%?88?%;margin-right:%?16?%}.tuiguang1 .item .left .name[data-v-cdf6be32]{font-size:%?28?%;font-family:PingFangSC-Regular,PingFang SC;font-weight:400;color:#202020;margin-bottom:%?14?%}.tuiguang1 .item .left .detail[data-v-cdf6be32]{font-size:%?24?%;font-family:PingFangSC-Regular,PingFang SC;font-weight:400;color:#999}.tuiguang1 .item .right[data-v-cdf6be32]{width:%?136?%;height:%?58?%;border-radius:%?29?%;border:%?2?% solid #666;text-align:center;line-height:%?58?%;font-size:%?24?%;font-family:PingFangSC-Medium,PingFang SC;font-weight:500;color:#666}.tuiguang[data-v-cdf6be32]{padding:0 %?32?% %?32?% %?32?%;background:#fff;box-shadow:%?0?% %?-12?% %?16?% %?0?% rgba(0,0,0,.06)}.tuiguang .title[data-v-cdf6be32]{padding:%?32?% 0;font-size:%?32?%;font-family:PingFangSC-Medium,PingFang SC;font-weight:500;color:#202020}.tuiguang .item[data-v-cdf6be32]{display:flex;align-items:center;justify-content:space-between}.tuiguang .item .left[data-v-cdf6be32]{display:flex;align-items:center}.tuiguang .item .left .logo[data-v-cdf6be32]{width:%?88?%;height:%?88?%;margin-right:%?16?%}.tuiguang .item .left .name[data-v-cdf6be32]{font-size:%?28?%;font-family:PingFangSC-Regular,PingFang SC;font-weight:400;color:#202020;margin-bottom:%?14?%}.tuiguang .item .left .detail[data-v-cdf6be32]{font-size:%?24?%;font-family:PingFangSC-Regular,PingFang SC;font-weight:400;color:#999}.tuiguang .item .right[data-v-cdf6be32]{width:%?136?%;height:%?58?%;border-radius:%?29?%;border:%?2?% solid #666;text-align:center;line-height:%?58?%;font-size:%?24?%;font-family:PingFangSC-Medium,PingFang SC;font-weight:500;color:#666}.fengexian[data-v-cdf6be32]{width:%?750?%;height:%?16?%;background:#f5f6f8}.header[data-v-cdf6be32]{width:%?686?%;height:%?154?%;\n  /*background: rgba(255, 215, 32, 1);*/background:#ef4f67;border-radius:%?14?% %?14?% 0 0;margin:0 auto;padding:%?24?% 0;display:flex;align-items:flex-end;justify-content:space-around}.header .left[data-v-cdf6be32]{display:flex;flex-direction:column;align-items:center;justify-content:end}.header .left uni-text[data-v-cdf6be32]:first-child{font-size:%?36?%;font-family:PingFangSC-Medium,PingFang SC;font-weight:500;color:#fff;margin-bottom:%?-30?%}.header .left uni-text[data-v-cdf6be32]:last-child{width:%?60?%;font-size:%?98?%;font-family:Avenir-Heavy,Avenir;font-weight:800;color:#fff;margin-bottom:%?-10?%}.header .right[data-v-cdf6be32]{font-size:%?32?%;font-family:PingFangSC-Medium,PingFang SC;font-weight:500;color:#fff}',""]),t.exports=n},d9c1:function(t,n,e){var i=e("a8ef");"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var a=e("4f06").default;a("fa117c1a",i,!0,{sourceMap:!1,shadowMode:!1})},fe31:function(t,n,e){"use strict";var i=e("d9c1"),a=e.n(i);a.a}}]);