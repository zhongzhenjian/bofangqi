(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-login-bindphone"],{"0035":function(t,n,e){"use strict";e.d(n,"b",(function(){return a})),e.d(n,"c",(function(){return o})),e.d(n,"a",(function(){return i}));var i={uniPopup:e("eb2b").default},a=function(){var t=this,n=t.$createElement,e=t._self._c||n;return e("v-uni-view",{staticClass:"zhuce"},[e("v-uni-view",{staticClass:"top"},[t._v("手机号绑定")]),e("v-uni-view",{staticClass:"input"},[e("v-uni-input",{attrs:{type:"text",placeholder:"手机号码"},model:{value:t.tel,callback:function(n){t.tel=n},expression:"tel"}})],1),e("v-uni-view",{staticClass:"zhucebut",style:{background:""!=t.tel?"#EF4F67":"#CACACA"},on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.tozhuce.apply(void 0,arguments)}}},[t._v("绑定")]),e("uni-popup",{ref:"code",attrs:{type:"bottom"}},[e("v-uni-scroll-view",{staticClass:"codelist",attrs:{"scroll-y":"true"}},t._l(t.codelist,(function(n,i){return e("v-uni-view",{key:i,on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.changecode(n)}}},[e("v-uni-text",[t._v(t._s(n.area))]),e("v-uni-text",[t._v(t._s(n.country))]),e("v-uni-text",[t._v(t._s(n.mobile_prefix))])],1)})),1)],1)],1)},o=[]},"2f0f":function(t,n,e){"use strict";var i=e("fff1"),a=e.n(i);a.a},"68aa":function(t,n,e){"use strict";e("7a82");var i=e("4ea4").default;Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var a=i(e("eb2b")),o={data:function(){return{time:"发送驗證碼",s:60,settime:"",tel:"",pwd:"",yzm:"aaaa",yqm:"",yanzhengma:"aaaa",quhao:"电话区号",codelist:[],isshow:!1}},components:{uniPopup:a.default},onLoad:function(){this.getcode(),this.getyzm()},created:function(){},methods:{getyzm:function(){var t=this;uni.getStorage({key:"Invitationcode",success:function(n){t.yqm=n.data.id,t.isshow=!0}})},changecode:function(t){this.quhao=t.mobile_prefix,this.$refs.code.close()},open:function(){this.$refs.code.open()},getcode:function(){var t=this;this.$loading(),uni.request({url:this.$url+"/api/County/index",method:"GET",success:function(n){uni.hideLoading(),t.codelist=n.data.data}})},tozhuce:function(){return""==this.tel?(uni.showToast({icon:"none",title:"请输入手机号码"}),!1):this.yzm!=this.yanzhengma?(uni.showToast({icon:"none",title:"驗證碼不正確"}),!1):(uni.showLoading({mask:!0,title:"请稍后"}),void uni.request({url:this.$url+"/api/user/blindMobile",method:"POST",header:{"content-type":"application/x-www-form-urlencoded",token:uni.getStorageSync("usertoken")},data:{mobile:this.tel},success:function(t){uni.hideLoading(),uni.showToast({icon:"none",title:t.data.msg}),200==t.data.code&&setTimeout((function(){uni.switchTab({url:"../mine/mine"})}),1e3)}}))},sendcode:function(){var t=this;if("发送驗證碼"==this.time){if(""==this.tel)return uni.showToast({icon:"none",title:"請输入手機號碼"}),!1;uni.showLoading({mask:!0,title:"请稍后"}),uni.request({url:this.$url+"/api/user/sendMsm",method:"POST",data:{mobile:this.tel},success:function(n){uni.hideLoading(),uni.showToast({icon:"none",title:"发送成功"}),t.yanzhengma=n.data,t.time=t.s+"s",t.settime=setInterval((function(){t.s--,-1==t.s?(t.time="发送驗證碼",t.s=60,clearInterval(t.settime)):t.time=t.s+"s"}),1e3)},fail:function(){uni.hideLoading(),uni.showToast({icon:"none",title:"发送失敗"})}})}}}};n.default=o},"941a":function(t,n,e){"use strict";e.r(n);var i=e("0035"),a=e("ff03");for(var o in a)["default"].indexOf(o)<0&&function(t){e.d(n,t,(function(){return a[t]}))}(o);e("2f0f");var u=e("f0c5"),s=Object(u["a"])(a["default"],i["b"],i["c"],!1,null,"d08dafbc",null,!1,i["a"],void 0);n["default"]=s.exports},"9df0":function(t,n,e){var i=e("24fb");n=i(!1),n.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.codelist[data-v-d08dafbc]{width:%?750?%!important;height:80vh;background-color:#fff}.codelist uni-view[data-v-d08dafbc]{display:flex;align-items:center;justify-content:space-between;padding:0 %?50?%;width:%?650?%!important}.codelist uni-view uni-text[data-v-d08dafbc]{font-size:%?30?%;width:30%;text-align:center;padding:%?10?% 0}.zhuce[data-v-d08dafbc]{display:flex;flex-direction:column;align-items:center}.zhuce .zhucebut[data-v-d08dafbc]{width:%?540?%;height:%?88?%;background:#ef4f67;border-radius:%?43?%;text-align:center;line-height:%?88?%;margin-top:%?28?%;font-size:%?32?%;font-family:PingFangSC-Medium,PingFang SC;font-weight:500;color:#fff}.zhuce .input2[data-v-d08dafbc]{display:flex;align-items:center;margin-bottom:%?42?%;border-bottom:%?2?% solid #e5e5e5;padding:%?32?% 0}.zhuce .input2 uni-input[data-v-d08dafbc]{font-size:%?28?%;margin-left:%?20?%}.zhuce .input2 uni-text[data-v-d08dafbc]{display:inline-block;width:%?130?%;text-align:center;font-size:%?28?%}.zhuce .input1[data-v-d08dafbc]{margin-bottom:%?42?%;border-bottom:%?2?% solid #e5e5e5;padding:%?32?% 0;display:flex;align-items:center;justify-content:space-between}.zhuce .input1 uni-input[data-v-d08dafbc]{font-size:%?28?%}.zhuce .input1 uni-text[data-v-d08dafbc]{display:inline-block;width:%?130?%;text-align:center;color:#ef4f67;font-size:%?24?%}.zhuce .input[data-v-d08dafbc]{margin-bottom:%?42?%;border-bottom:%?2?% solid #e5e5e5;padding:%?32?% 0}.zhuce .input uni-input[data-v-d08dafbc]{font-size:%?28?%}.zhuce .top[data-v-d08dafbc]{margin-top:%?90?%;margin-bottom:%?28?%;font-size:%?44?%;font-family:PingFangSC-Medium,PingFang SC;font-weight:500;color:#202020}.zhuce uni-view[data-v-d08dafbc]{width:%?540?%}',""]),t.exports=n},ff03:function(t,n,e){"use strict";e.r(n);var i=e("68aa"),a=e.n(i);for(var o in i)["default"].indexOf(o)<0&&function(t){e.d(n,t,(function(){return i[t]}))}(o);n["default"]=a.a},fff1:function(t,n,e){var i=e("9df0");i.__esModule&&(i=i.default),"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var a=e("4f06").default;a("51429f99",i,!0,{sourceMap:!1,shadowMode:!1})}}]);