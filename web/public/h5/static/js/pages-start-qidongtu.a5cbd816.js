(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-start-qidongtu"],{"09a9":function(n,t,i){n.exports=i.p+"static/img/120.79776984.png"},"09b4":function(n,t,i){"use strict";var e=i("8731"),a=i.n(e);a.a},4809:function(n,t,i){"use strict";i.r(t);var e=i("cf5e"),a=i.n(e);for(var o in e)"default"!==o&&function(n){i.d(t,n,(function(){return e[n]}))}(o);t["default"]=a.a},"780c":function(n,t,i){var e=i("24fb");t=e(!1),t.push([n.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.banben-box[data-v-0e82b2ff]{width:%?602?%;height:%?1000?%;display:flex;flex-direction:column;align-items:center;justify-content:space-between;position:relative}.banben-box .banben-bg[data-v-0e82b2ff]{width:%?602?%;height:%?830?%}.banben-box .banben-content[data-v-0e82b2ff]{width:%?602?%;height:%?830?%;position:absolute;top:0;left:0}.banben-box .banben-content .title[data-v-0e82b2ff]{height:%?260?%;line-height:%?400?%;font-size:%?40?%;font-family:PingFangSC-Medium,PingFang SC;font-weight:500;color:#202020;margin-left:%?72?%}.banben-box .banben-content .scroll-content[data-v-0e82b2ff]{height:%?400?%;width:%?458?%;margin:0 auto}.banben-box .banben-content .shengji[data-v-0e82b2ff]{width:%?444?%;height:%?88?%;background:#f46a5c;border-radius:%?12?%;line-height:%?88?%;text-align:center;font-size:%?32?%;font-family:PingFangSC-Medium,PingFang SC;font-weight:500;color:#fafafa;margin:%?40?% auto}.banben-box .banben-content .jindu[data-v-0e82b2ff]{height:%?88?%;display:flex;align-items:center;justify-content:center;margin-top:%?40?%}.banben-box .banben-content .jindutiao[data-v-0e82b2ff]{width:%?444?%}.banben-box .banben-close[data-v-0e82b2ff]{width:%?100?%;height:%?100?%}.qidongtu[data-v-0e82b2ff]{width:%?750?%;height:100vh;position:fixed;top:0;left:0}',""]),n.exports=t},8731:function(n,t,i){var e=i("780c");"string"===typeof e&&(e=[[n.i,e,""]]),e.locals&&(n.exports=e.locals);var a=i("4f06").default;a("ded1fbdc",e,!0,{sourceMap:!1,shadowMode:!1})},"9abb":function(n,t,i){"use strict";i.d(t,"b",(function(){return a})),i.d(t,"c",(function(){return o})),i.d(t,"a",(function(){return e}));var e={uniPopup:i("da1b").default},a=function(){var n=this,t=n.$createElement,e=n._self._c||t;return e("v-uni-view",[e("v-uni-image",{staticClass:"qidongtu",attrs:{src:i("ae37")}}),e("uni-popup",{ref:"banben",attrs:{maskClick:!1}},[e("v-uni-view",{staticClass:"banben-box"},[e("v-uni-image",{staticClass:"banben-bg",attrs:{src:i("e7a9")}}),e("v-uni-view",{staticClass:"banben-content"},[e("v-uni-view",{staticClass:"title"},[n._v("发现新版本！")]),e("v-uni-scroll-view",{staticClass:"scroll-content",attrs:{"scroll-y":"true"}},[e("v-uni-rich-text",{attrs:{nodes:n.version.content}})],1),1==n.jindu?e("v-uni-view",{staticClass:"shengji",on:{click:function(t){arguments[0]=t=n.$handleEvent(t),n.xiazia.apply(void 0,arguments)}}},[n._v("立即升级")]):2==n.jindu?e("v-uni-view",{staticClass:"jindu"},[e("v-uni-progress",{staticClass:"jindutiao",attrs:{"border-radius":"100","stroke-width":"20",activeColor:"#EF4F67",percent:n.xiazaidata.progress,"show-info":!0}})],1):3==n.jindu?e("v-uni-view",{staticClass:"shengji",on:{click:function(t){arguments[0]=t=n.$handleEvent(t),n.anzhuang.apply(void 0,arguments)}}},[n._v("下载完成，去安装")]):n._e()],1),e("v-uni-image",{staticClass:"banben-close",attrs:{src:i("09a9")},on:{click:function(t){arguments[0]=t=n.$handleEvent(t),n.closebanben.apply(void 0,arguments)}}})],1)],1)],1)},o=[]},ae37:function(n,t,i){n.exports=i.p+"static/img/WechatIMG560.46eacff4.png"},ccdb:function(n,t,i){"use strict";i.r(t);var e=i("9abb"),a=i("4809");for(var o in a)"default"!==o&&function(n){i.d(t,n,(function(){return a[n]}))}(o);i("09b4");var s,u=i("f0c5"),c=Object(u["a"])(a["default"],e["b"],e["c"],!1,null,"0e82b2ff",null,!1,e["a"],s);t["default"]=c.exports},cf5e:function(n,t,i){"use strict";var e=i("4ea4");Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var a=e(i("da1b")),o={data:function(){return{version:[],jindu:1,xiazaidata:[],downapk:""}},components:{uniPopup:a.default},onLoad:function(){this.next()},methods:{anzhuang:function(){plus.runtime.install(this.downapk,{},{},(function(n){uni.showToast({icon:"none",title:"安装失败",duration:1500})}))},xiazia:function(){var n=this;this.jindu=2;var t=uni.downloadFile({url:this.version.file_text,success:function(t){100==n.xiazaidata.progress?(n.downapk=t.tempFilePath,n.jindu=3,n.anzhuang()):(uni.showToast({icon:"none",title:"下载失败"}),n.jindu=1)}});t.onProgressUpdate((function(t){n.xiazaidata=t}))},closebanben:function(){this.$refs.banben.close(),this.next()},next:function(){uni.getStorageSync("isfirst")?uni.redirectTo({url:"./first"}):(uni.reLaunch({url:"./first"}),uni.setStorageSync("isfirst",!0))},getdata:function(){var n=this;uni.request({url:this.$url+"/api/edition/index",success:function(t){uni.hideLoading(),200==t.data.code?(n.version=t.data.data,plus.runtime.version!=n.version.version?n.$refs.banben.open():n.next()):uni.showToast({icon:"none",title:"检查版本失败"})}})}}};t.default=o},e7a9:function(n,t,i){n.exports=i.p+"static/img/126_2.7be8603b.png"}}]);