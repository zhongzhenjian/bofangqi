(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-player-addplayer"],{"5bf8":function(t,n,i){"use strict";var e=i("b17a"),a=i.n(e);a.a},"617c":function(t,n,i){"use strict";i.d(n,"b",(function(){return e})),i.d(n,"c",(function(){return a})),i.d(n,"a",(function(){}));var e=function(){var t=this,n=t.$createElement,e=t._self._c||n;return e("v-uni-view",[e("v-uni-view",{staticClass:"bg-image"},[e("v-uni-image",{staticClass:"image",attrs:{src:i("7ab5")}})],1),e("v-uni-view",{staticClass:"input-item"},[e("v-uni-text",{staticClass:"title"},[t._v("真实姓名")]),e("v-uni-input",{attrs:{type:"text",placeholder:"请输入您的真实姓名"},model:{value:t.name,callback:function(n){t.name=n},expression:"name"}}),e("v-uni-view",{staticClass:"right"})],1),e("v-uni-view",{staticClass:"input-item"},[e("v-uni-text",{staticClass:"title"},[t._v("身份证")]),e("v-uni-input",{attrs:{type:"text",placeholder:"请输入您的身份证号"},model:{value:t.shenfen,callback:function(n){t.shenfen=n},expression:"shenfen"}}),e("v-uni-view",{staticClass:"right"})],1),e("v-uni-view",{staticClass:"input-item"},[e("v-uni-text",{staticClass:"title"},[t._v("手机号")]),e("v-uni-input",{attrs:{type:"number",placeholder:"请填写手机号"},model:{value:t.tel,callback:function(n){t.tel=n},expression:"tel"}}),e("v-uni-view",{staticClass:"right"})],1),e("v-uni-view",{staticClass:"shenfenzheng"},[e("v-uni-view",{staticClass:"border",on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.changeimage1.apply(void 0,arguments)}}},[t.image1?t._e():e("v-uni-text",[t._v("+")]),t.image1?t._e():e("v-uni-text",[t._v("身份证正面")]),t.image1?e("v-uni-image",{staticClass:"border",attrs:{src:t.image1}}):t._e()],1),e("v-uni-view",{staticClass:"border",on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.changeimage2.apply(void 0,arguments)}}},[t.image2?t._e():e("v-uni-text",[t._v("+")]),t.image2?t._e():e("v-uni-text",[t._v("身份证反面")]),t.image2?e("v-uni-image",{staticClass:"border",attrs:{src:t.image2}}):t._e()],1)],1),e("v-uni-view",{staticClass:"buttom",on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.tijiao.apply(void 0,arguments)}}},[t._v("提交认证")])],1)},a=[]},"7ab5":function(t,n,i){t.exports=i.p+"static/img/163.bb5f4f3d.png"},"8fa1":function(t,n,i){"use strict";i.r(n);var e=i("a2fa"),a=i.n(e);for(var s in e)["default"].indexOf(s)<0&&function(t){i.d(n,t,(function(){return e[t]}))}(s);n["default"]=a.a},"9a39":function(t,n,i){var e=i("24fb");n=e(!1),n.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.buttom[data-v-0b2813d4]{width:%?686?%;height:%?100?%;background:#bdbdbd;border-radius:%?50?%;text-align:center;line-height:%?100?%;margin:%?50?% auto;font-size:%?36?%;font-family:PingFangSC-Medium,PingFang SC;font-weight:500;color:#fff}.shenfenzheng[data-v-0b2813d4]{display:flex;align-items:center;justify-content:space-between;padding:0 %?32?%;margin-top:%?40?%}.shenfenzheng .border[data-v-0b2813d4]{width:%?326?%;height:%?224?%;border-radius:%?10?%;border:%?2?% dashed #bababa;display:flex;flex-direction:column;align-items:center;justify-content:center}.shenfenzheng .border uni-text[data-v-0b2813d4]{font-size:%?28?%;font-family:PingFangSC-Regular,PingFang SC;font-weight:400;color:#999}.input-item[data-v-0b2813d4]{display:flex;align-items:center;padding:0 %?32?%;justify-content:space-between;height:%?100?%}.input-item .title[data-v-0b2813d4]{font-size:%?28?%;font-family:PingFangSC-Regular,PingFang SC;font-weight:400;color:#202020;width:%?150?%}.input-item uni-input[data-v-0b2813d4]{font-size:%?28?%;font-family:PingFangSC-Regular,PingFang SC;font-weight:400;color:#999;width:%?300?%}.input-item .right[data-v-0b2813d4]{width:%?186?%;height:%?60?%;border-radius:%?30?%;font-size:%?28?%;font-family:PingFangSC-Regular,PingFang SC;font-weight:400;color:#fff}.input-item .yanzheng[data-v-0b2813d4]{background-color:#bdbdbd;text-align:center;line-height:%?60?%}.bg-image[data-v-0b2813d4]{background-color:#f5f6f8;padding:%?34?% 0;width:%?750?%;text-align:center}.bg-image .image[data-v-0b2813d4]{width:%?418?%;height:%?280?%}',""]),t.exports=n},a2fa:function(t,n,i){"use strict";i("7a82"),Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0,i("d401"),i("d3b7"),i("25f0");var e={data:function(){return{name:"",shenfen:"",tel:"",yzm:"aaa",zimage:"",fimage:"",yzm2:"aaa",image1:"",image2:""}},methods:{changeimage1:function(){var t=this;uni.chooseImage({count:1,success:function(n){t.image1=n.tempFilePaths[0]}})},changeimage2:function(){var t=this;uni.chooseImage({count:1,success:function(n){t.image2=n.tempFilePaths[0]}})},sengyzm:function(){var t=this;if(""==this.tel)return uni.showToast({icon:"none",title:"请输入手机号"}),!1;this.$loading(),uni.request({url:this.$url+"/api/user/sendMsm",method:"POST",data:{mobile:this.tel},success:function(n){uni.hideLoading(),uni.showToast({icon:"none",title:"发送成功"}),t.yzm2=n.data}})},tijiao:function(){if(""==this.name)return uni.showToast({icon:"none",title:"请输入姓名"}),!1;var t=this.shenfen.toString();return t.length<18?(uni.showToast({icon:"none",title:"请输入身份证"}),!1):""==this.tel?(uni.showToast({icon:"none",title:"请输入手机号"}),!1):""==this.yzm?(uni.showToast({icon:"none",title:"请输入验证码"}),!1):this.yzm!=this.yzm2?(uni.showToast({icon:"none",title:"验证码不正确"}),!1):""==this.image1?(uni.showToast({icon:"none",title:"请选择身份证正面"}),!1):""==this.image2?(uni.showToast({icon:"none",title:"请选择身份证反面"}),!1):(this.$loading(),void setTimeout((function(){uni.hideLoading(),uni.showToast({icon:"none",title:"提交成功"})}),1e3))}}};n.default=e},b17a:function(t,n,i){var e=i("9a39");e.__esModule&&(e=e.default),"string"===typeof e&&(e=[[t.i,e,""]]),e.locals&&(t.exports=e.locals);var a=i("4f06").default;a("3a78ccde",e,!0,{sourceMap:!1,shadowMode:!1})},eed7:function(t,n,i){"use strict";i.r(n);var e=i("617c"),a=i("8fa1");for(var s in a)["default"].indexOf(s)<0&&function(t){i.d(n,t,(function(){return a[t]}))}(s);i("5bf8");var o=i("f0c5"),u=Object(o["a"])(a["default"],e["b"],e["c"],!1,null,"0b2813d4",null,!1,e["a"],void 0);n["default"]=u.exports}}]);