(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-login-zhuce"],{"5ded":function(t,e,i){"use strict";i.r(e);var n=i("703e"),a=i("6e7f");for(var o in a)"default"!==o&&function(t){i.d(e,t,(function(){return a[t]}))}(o);i("aaa9");var s,u=i("f0c5"),c=Object(u["a"])(a["default"],n["b"],n["c"],!1,null,"2ca8f3ff",null,!1,n["a"],s);e["default"]=c.exports},"6e7f":function(t,e,i){"use strict";i.r(e);var n=i("7c08"),a=i.n(n);for(var o in n)"default"!==o&&function(t){i.d(e,t,(function(){return n[t]}))}(o);e["default"]=a.a},"703e":function(t,e,i){"use strict";var n={uniPopup:i("94a6").default},a=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"zhuce"},[i("v-uni-view",{staticClass:"top"},[t._v("帳號注册")]),i("v-uni-view",{staticClass:"input"},[i("v-uni-input",{attrs:{type:"text",placeholder:"手機號碼"},model:{value:t.tel,callback:function(e){t.tel=e},expression:"tel"}})],1),i("v-uni-view",{staticClass:"input"},[i("v-uni-input",{attrs:{type:"text",placeholder:"密碼",password:"true"},model:{value:t.pwd,callback:function(e){t.pwd=e},expression:"pwd"}})],1),i("v-uni-view",{staticClass:"input1"},[i("v-uni-input",{attrs:{type:"number",placeholder:"驗證碼"},model:{value:t.yzm,callback:function(e){t.yzm=e},expression:"yzm"}}),i("v-uni-text",{on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.sendcode.apply(void 0,arguments)}}},[t._v(t._s(t.time))])],1),i("v-uni-view",{staticClass:"input"},[i("v-uni-input",{attrs:{type:"text",placeholder:"邀請碼"},model:{value:t.yqm,callback:function(e){t.yqm=e},expression:"yqm"}})],1),i("v-uni-view",{staticClass:"zhucebut",style:{background:""!=t.tel&&""!=t.pwd&&""!=t.yzm?"rgba(255,209,0,1)":"#CACACA"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.tozhuce.apply(void 0,arguments)}}},[t._v("注册")]),i("uni-popup",{ref:"code",attrs:{type:"bottom"}},[i("v-uni-scroll-view",{staticClass:"codelist",attrs:{"scroll-y":"true"}},t._l(t.codelist,(function(e,n){return i("v-uni-view",{key:n,on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.changecode(e)}}},[i("v-uni-text",[t._v(t._s(e.area))]),i("v-uni-text",[t._v(t._s(e.country))]),i("v-uni-text",[t._v(t._s(e.mobile_prefix))])],1)})),1)],1)],1)},o=[];i.d(e,"b",(function(){return a})),i.d(e,"c",(function(){return o})),i.d(e,"a",(function(){return n}))},"7c08":function(t,e,i){"use strict";(function(t){var n=i("ee27");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a=n(i("94a6")),o={data:function(){return{time:"發送驗證碼",s:60,settime:"",tel:"",pwd:"",yzm:"",yqm:"",yanzhengma:"aaaa",quhao:"电话区号",codelist:[]}},components:{uniPopup:a.default},onLoad:function(){this.getcode()},methods:{changecode:function(t){this.quhao=t.mobile_prefix,this.$refs.code.close()},open:function(){this.$refs.code.open()},getcode:function(){var t=this;this.$loading(),uni.request({url:this.$url+"/api/County/index",method:"GET",success:function(e){uni.hideLoading(),t.codelist=e.data.data}})},tozhuce:function(){return""==this.tel?(uni.showToast({icon:"none",title:"請輸入手機號碼"}),!1):""==this.pwd?(uni.showToast({icon:"none",title:"請輸入密碼"}),!1):this.yzm!=this.yanzhengma?(uni.showToast({icon:"none",title:"驗證碼不正確"}),!1):(uni.showLoading({mask:!0,title:"請稍後"}),void uni.request({url:this.$url+"/api/user/register",method:"POST",header:{"content-type":"application/x-www-form-urlencoded"},data:{mobile:this.tel,password:this.pwd,t_number:this.yqm},success:function(e){uni.hideLoading(),uni.showToast({icon:"none",title:e.data.msg}),200==e.data.code&&(uni.setStorageSync("usertoken",e.data.data.userinfo.token),uni.setStorageSync("userid",e.data.data.userinfo.id),uni.setStorageSync("userinfo",e.data.data.userinfo),setTimeout((function(){uni.switchTab({url:"../mine/mine"})}),1e3)),t("log",e," at pages/login/zhuce.vue:127")}}))},sendcode:function(){var t=this;if("發送驗證碼"==this.time){if(""==this.tel)return uni.showToast({icon:"none",title:"請輸入手機號碼"}),!1;uni.showLoading({mask:!0,title:"請稍後"}),uni.request({url:this.$url+"/api/user/sendMsm",method:"POST",data:{mobile:this.tel},success:function(e){uni.hideLoading(),uni.showToast({icon:"none",title:"發送成功"}),t.yanzhengma=e.data,t.time=t.s+"s",t.settime=setInterval((function(){t.s--,-1==t.s?(t.time="發送驗證碼",t.s=60,clearInterval(t.settime)):t.time=t.s+"s"}),1e3)},fail:function(){uni.hideLoading(),uni.showToast({icon:"none",title:"發送失敗"})}})}}}};e.default=o}).call(this,i("0de9")["log"])},8708:function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.codelist[data-v-2ca8f3ff]{width:%?750?%!important;height:80vh;background-color:#fff}.codelist uni-view[data-v-2ca8f3ff]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;padding:0 %?50?%;width:%?650?%!important}.codelist uni-view uni-text[data-v-2ca8f3ff]{font-size:%?30?%;width:30%;text-align:center;padding:%?10?% 0}.zhuce[data-v-2ca8f3ff]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.zhuce .zhucebut[data-v-2ca8f3ff]{width:%?540?%;height:%?88?%;background:#ffd100;border-radius:%?43?%;text-align:center;line-height:%?88?%;margin-top:%?28?%;font-size:%?32?%;font-family:PingFangSC-Medium,PingFang SC;font-weight:500;color:#fff}.zhuce .input2[data-v-2ca8f3ff]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;margin-bottom:%?42?%;border-bottom:%?2?% solid #e5e5e5;padding:%?32?% 0}.zhuce .input2 uni-input[data-v-2ca8f3ff]{font-size:%?28?%;margin-left:%?20?%}.zhuce .input2 uni-text[data-v-2ca8f3ff]{display:inline-block;width:%?130?%;text-align:center;font-size:%?28?%}.zhuce .input1[data-v-2ca8f3ff]{margin-bottom:%?42?%;border-bottom:%?2?% solid #e5e5e5;padding:%?32?% 0;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}.zhuce .input1 uni-input[data-v-2ca8f3ff]{font-size:%?28?%}.zhuce .input1 uni-text[data-v-2ca8f3ff]{display:inline-block;width:%?130?%;text-align:center;color:#ffd100;font-size:%?24?%}.zhuce .input[data-v-2ca8f3ff]{margin-bottom:%?42?%;border-bottom:%?2?% solid #e5e5e5;padding:%?32?% 0}.zhuce .input uni-input[data-v-2ca8f3ff]{font-size:%?28?%}.zhuce .top[data-v-2ca8f3ff]{margin-top:%?90?%;margin-bottom:%?28?%;font-size:%?44?%;font-family:PingFangSC-Medium,PingFang SC;font-weight:500;color:#202020}.zhuce uni-view[data-v-2ca8f3ff]{width:%?540?%}',""]),t.exports=e},aaa9:function(t,e,i){"use strict";var n=i("d0a5"),a=i.n(n);a.a},d0a5:function(t,e,i){var n=i("8708");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=i("4f06").default;a("ffcf7e88",n,!0,{sourceMap:!1,shadowMode:!1})}}]);