(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-index-seach~pages-userinfo-userinfo"],{"024d":function(t,e,i){var n=i("f9ef");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=i("4f06").default;a("a3315434",n,!0,{sourceMap:!1,shadowMode:!1})},"07b8":function(t,e,i){"use strict";var n=i("cb4a"),a=i.n(n);a.a},"2af8":function(t,e,i){"use strict";var n=i("024d"),a=i.n(n);a.a},"2edd":function(t,e,i){"use strict";i.r(e);var n=i("b0a1"),a=i.n(n);for(var o in n)"default"!==o&&function(t){i.d(e,t,(function(){return n[t]}))}(o);e["default"]=a.a},"546b":function(t,e,i){"use strict";i.r(e);var n=i("c848"),a=i("2edd");for(var o in a)"default"!==o&&function(t){i.d(e,t,(function(){return a[t]}))}(o);i("07b8");var s,c=i("f0c5"),r=Object(c["a"])(a["default"],n["b"],n["c"],!1,null,"68c1e23e",null,!1,n["a"],s);e["default"]=r.exports},5940:function(t,e,i){"use strict";i.r(e);var n=i("a5a7"),a=i("5c28");for(var o in a)"default"!==o&&function(t){i.d(e,t,(function(){return a[t]}))}(o);i("2af8");var s,c=i("f0c5"),r=Object(c["a"])(a["default"],n["b"],n["c"],!1,null,"6b563cc7",null,!1,n["a"],s);e["default"]=r.exports},"5c28":function(t,e,i){"use strict";i.r(e);var n=i("a910"),a=i.n(n);for(var o in n)"default"!==o&&function(t){i.d(e,t,(function(){return n[t]}))}(o);e["default"]=a.a},"941e":function(t,e,i){t.exports=i.p+"static/img/download.c5f440ca.png"},a0af:function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.back-button[data-v-68c1e23e]{width:30px;height:30px;align-items:center;justify-content:center;opacity:.8;margin-top:25px;margin-left:15px;border-radius:50%;background-color:rgba(0,0,0,.8)}.back-icon[data-v-68c1e23e]{width:20px;height:20px}.download-button[data-v-68c1e23e]{position:absolute;top:90px;right:15px;width:30px;height:30px;align-items:center;justify-content:center;opacity:.8;border-radius:50%;background-color:rgba(0,0,0,.8)}.process-text[data-v-68c1e23e]{color:#fff;font-size:10px}.video-process-bar[data-v-68c1e23e]{height:2px}.download-icon-horizontal[data-v-68c1e23e]{position:absolute;right:30px;width:30px;height:30px;align-items:center;justify-content:center;opacity:.8;border-radius:50%;background-color:rgba(0,0,0,.8)}.process-text-horizontal[data-v-68c1e23e]{color:#fff;font-size:5px}',""]),t.exports=e},a5a7:function(t,e,i){"use strict";i.d(e,"b",(function(){return a})),i.d(e,"c",(function(){return o})),i.d(e,"a",(function(){return n}));var n={uniPopup:i("3651").default},a=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"shequ-photo"},[i("v-uni-view",{staticClass:"shequ-header",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.videoinfo.apply(void 0,arguments)}}},[i("v-uni-view",{staticClass:"shequ-header-left",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.touserinfo.apply(void 0,arguments)}}},[i("v-uni-view",{staticClass:"header-user"},[i("v-uni-image",{staticClass:"header-user-image",attrs:{mode:"aspectFill",autoBitmapRecycle:!1,src:t.items.avatar_text,placeholder:"/static/images/51.png"}}),i("v-uni-image",{staticClass:"user-image-vip",attrs:{src:"/static/images/124.png"}})],1),i("v-uni-view",{staticClass:"header-userinfo"},[i("v-uni-view",{staticClass:"userinfo"},[i("v-uni-text",{staticClass:"user-name"},[t._v(t._s(t.items.name))]),0==t.items.publisher.level?i("v-uni-image",{staticClass:"user-new",attrs:{mode:"aspectFit",src:"/static/images/142.png"}}):t._e(),1==t.items.publisher.level?i("v-uni-image",{staticClass:"user-new",attrs:{mode:"aspectFit",src:"/static/images/143.png"}}):t._e(),2==t.items.publisher.level?i("v-uni-image",{staticClass:"user-new",attrs:{mode:"aspectFit",src:"/static/images/141.png"}}):t._e(),i("v-uni-image",{staticClass:"user-vip",attrs:{src:"/static/images/52.png"}})],1)],1)],1),i("v-uni-view",{staticClass:"shequ-header-right"},[i("v-uni-text",{staticClass:"shequ-header-right1"},[t._v("啪啪学院")]),i("v-uni-text",{staticClass:"shequ-header-right2"},[t._v("@")])],1)],1),i("v-uni-view",{staticClass:"item-text",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.videoinfo.apply(void 0,arguments)}}},[i("v-uni-text",{staticClass:"item-text-content"},[t._v(t._s(t.items.title))])],1),i("v-uni-view",{staticClass:"myvideo"},[i("v-uni-video",{staticClass:"myvideo-item",attrs:{"show-center-play-btn":!1,src:t.items.video,controls:!0,id:"myvideos"},on:{timeupdate:function(e){arguments[0]=e=t.$handleEvent(e),t.timevideo.apply(void 0,arguments)}}}),i("v-uni-image",{staticClass:"shuiyin",attrs:{src:"/static/images/139s.png",mode:"aspectFit"}}),t.isshow?i("v-uni-image",{staticClass:"fengmian",attrs:{src:t.items.video_text,placeholder:"/static/images/51.png",mode:"aspectFill"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.playvideo.apply(void 0,arguments)}}}):t._e(),t.isshow?i("v-uni-image",{staticClass:"play-img",attrs:{src:"/static/images/31.png"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.playvideo.apply(void 0,arguments)}}}):t._e(),t.bofangok?i("v-uni-view",{staticClass:"no-play"},[i("v-uni-text",{staticClass:"no-play-text"},[t._v("今日免费观看次数已用完")]),i("v-uni-text",{staticClass:"no-play-text"},[t._v("分享本软件給1人即送VIP，可无限叠加")]),i("v-uni-text",{staticClass:"no-play-text"},[t._v("开通会员观看更多精彩视频！")]),i("v-uni-view",{staticClass:"no-play-butt"},[i("v-uni-text",{staticClass:"no-play-butt1",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.totuisong.apply(void 0,arguments)}}},[t._v("去分享")]),i("v-uni-text",{staticClass:"no-play-butt1",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.tovip.apply(void 0,arguments)}}},[t._v("开通会员")])],1)],1):t._e()],1),i("v-uni-view",{staticClass:"wenzhang-down"},[i("v-uni-text",{staticClass:"wenzhang-down-left"},[t._v("2小时以前·"+t._s(t.ll)+"次观看")]),i("v-uni-view",{staticClass:"wenzhang-down-right"},[1==t.give?i("v-uni-image",{staticClass:"wenzhang-dianzan",attrs:{src:"/static/images/121.png"},on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.dianzan.apply(void 0,arguments)}}}):i("v-uni-image",{staticClass:"wenzhang-dianzan",attrs:{src:"/static/images/125.png"},on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.dianzan.apply(void 0,arguments)}}}),i("v-uni-text",{staticClass:"wenzhang-dianzan-count"},[t._v(t._s(t.dianzancount))]),i("v-uni-image",{staticClass:"wenzhang-dianzan",attrs:{src:"/static/images/68.png"},on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.videoinfo.apply(void 0,arguments)}}}),i("v-uni-text",{staticClass:"wenzhang-dianzan-count"},[t._v(t._s(t.items.comment))])],1)],1),i("v-uni-view",{staticClass:"fengexian"}),i("uni-popup",{ref:"bofang"},[i("v-uni-view",{staticClass:"tankuang"},[i("v-uni-image",{staticClass:"big-image",attrs:{src:"/static/images/123.png"}}),i("v-uni-image",{staticClass:"close-image",attrs:{src:"/static/images/120.png"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.closetankuang.apply(void 0,arguments)}}})],1)],1)],1)},o=[]},a910:function(t,e,i){"use strict";var n=i("4ea4");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a=n(i("546b")),o=n(i("3651")),s={props:{items:{type:Object,default:function(){return{}}}},data:function(){return{myvideo:null,isshow:!0,srcList:[{name:"高清",url:""}],url:getApp().globalData.url,header:getApp().globalData.header,dianzancount:0,bofangok:!1,give:0,ll:0}},created:function(){this.dianzancount=this.items.fabulous,this.give=this.items.give,this.ll=this.items.browse},methods:{tovip:function(){uni.getStorageSync("usertoken")?uni.navigateTo({url:"/pages/mine/viphuiyuan"}):uni.showToast({icon:"none",title:"请先登录！"})},totuisong:function(){uni.getStorageSync("usertoken")?uni.navigateTo({url:"/pages/mine/fenxiang"}):uni.showToast({icon:"none",title:"请先登录！"})},closetankuang:function(){this.$refs.bofang.close()},dianzan:function(t){var e=this;t.stopPropagation(),uni.getStorageSync("usertoken")?(uni.showLoading({mask:!0,title:"请稍后 "}),uni.request({url:this.url+"/api/community/thumbs",method:"GET",header:{token:uni.getStorageSync("usertoken")},data:{id:this.items.id},success:function(t){uni.hideLoading(),200==t.data.code?(uni.showToast({icon:"none",title:"点赞成功"}),e.dianzancount++,e.give=1):uni.showToast({icon:"none",title:t.data.msg})}})):uni.showToast({icon:"none",title:"请先登录！"})},videoinfo:function(){this.ll++,uni.navigateTo({url:"/pages/index/videoinfo?id="+this.items.id})},pausevideo:function(){this.isshow=!0,this.bofangok=!1,this.myvideo.pause()},timevideo:function(t){t.detail.currentTime<10&&this.myvideo.seek(10)},playvideo:function(){var t=this;uni.showLoading({mask:!0,title:"请稍后"}),uni.getStorageSync("usertoken")?uni.request({url:this.url+"/api/community/edit",method:"POST",data:{class:0},header:{token:uni.getStorageSync("usertoken")},success:function(e){uni.hideLoading(),200==e.data.code?(t.myvideo=uni.createVideoContext("myvideos",t),t.myvideo.play(),t.isshow=!1,t.$emit("playvideo")):(t.bofangok=!0,t.$emit("playvideo"))}}):uni.request({url:this.url+"/api/yk/del",method:"POST",data:{code:uni.getStorageSync("youkedata").code,class:0},success:function(e){uni.hideLoading(),200==e.data.code?(t.myvideo=uni.createVideoContext("myvideos",t),t.myvideo.play(),t.isshow=!1,t.$emit("playvideo")):(t.bofangok=!0,t.$emit("playvideo"))}})},touserinfo:function(t){t.stopPropagation(),uni.navigateTo({url:"/pages/userinfo/userinfo?id="+this.items.id+"&class="+this.items.class+"&isguanzhu=0"})}},components:{uniPopup:o.default,yyVideoPlayer:a.default}};e.default=s},b0a1:function(t,e,i){"use strict";(function(t){Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var i={props:{autoPlay:{type:Boolean,default:!0},url:{type:String,default:""},poster:{type:String,default:""},danmuList:{type:Array,default:[]},showBackBtn:{type:Boolean,default:!1},showDownloadBtn:{type:Boolean,default:!0},processBarColor:{type:String,default:"#39BFFD"}},data:function(){return{screenWidth:750,isFullScreen:!1,isDownloading:!1,downloadTask:null,progressValue:0,processBarWidth:0}},created:function(){this.screenWidth=uni.getSystemInfoSync().windowWidth},methods:{showToast:function(t){uni.showToast({title:t,icon:"none"})},downLoadFile:function(e){var i=this;i.showToast("开始下载"),i.downloadTask=uni.downloadFile({url:e,success:function(e){if(200===e.statusCode){t.log(e.tempFilePath);var n=e.tempFilePath;uni.saveFile({tempFilePath:n,success:function(e){t.log(e.savedFilePath),i.showToast("下载成功,文件已保存到"+e.savedFilePath)},fail:function(){i.showToast("下载失败，请稍后重试")}})}else i.showToast("下载失败")},complete:function(){i.isDownloading=!1}})},download:function(t){var e=this;e.progressValue=0,e.isDownloading?null!=e.downloadTask&&(e.downloadTask.abort(),e.isDownloading=!1,e.showToast("取消下载")):(e.isDownloading=!0,e.downLoadFile(t),e.downloadTask.onProgressUpdate((function(t){e.progressValue=t.progress})))},timeUpdate:function(t){this.processBarWidth=t.detail.currentTime/t.detail.duration*this.screenWidth},setFullScreenStatus:function(t){"horizontal"==t.detail.direction?this.isFullScreen=!0:this.isFullScreen=!1},back:function(){uni.navigateBack()}}};e.default=i}).call(this,i("5a52")["default"])},c4ef:function(t,e,i){t.exports=i.p+"static/img/back-white.309d83b9.png"},c848:function(t,e,i){"use strict";var n;i.d(e,"b",(function(){return a})),i.d(e,"c",(function(){return o})),i.d(e,"a",(function(){return n}));var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("v-uni-video",{style:{width:t.screenWidth},attrs:{id:"video",loop:"true",autoplay:t.autoPlay,src:t.url,"danmu-list":t.danmuList,"enable-danmu":"true","danmu-btn":"true",poster:t.poster},on:{fullscreenchange:function(e){arguments[0]=e=t.$handleEvent(e),t.setFullScreenStatus.apply(void 0,arguments)},timeupdate:function(e){arguments[0]=e=t.$handleEvent(e),t.timeUpdate.apply(void 0,arguments)}}},[!t.isFullScreen&&t.showBackBtn?n("v-uni-cover-view",{staticClass:"back-button",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.back.apply(void 0,arguments)}}},[n("v-uni-image",{staticClass:"back-icon",attrs:{src:i("c4ef")}})],1):t._e(),t.showDownloadBtn&&!t.isFullScreen?n("v-uni-cover-view",{staticClass:"download-button",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.download(t.url)}}},[t.isDownloading?n("v-uni-text",{staticClass:"process-text"},[t._v(t._s(t.progressValue)+"%")]):n("v-uni-image",{staticClass:"back-icon",attrs:{src:i("941e")}})],1):t._e(),t.showDownloadBtn&&t.isFullScreen?n("v-uni-cover-view",{staticClass:"download-icon-horizontal",style:{"margin-top":t.screenWidth/2.3},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.download(t.url)}}},[t.isDownloading?n("v-uni-text",{staticClass:"process-text-horizontal"},[t._v(t._s(t.progressValue)+"%")]):n("v-uni-image",{staticClass:"back-icon",attrs:{src:i("941e")}})],1):t._e()],1),n("div",{staticClass:"video-process-bar",style:{"background-color":t.processBarColor,width:t.processBarWidth}})],1)},o=[]},cb4a:function(t,e,i){var n=i("a0af");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=i("4f06").default;a("165eab92",n,!0,{sourceMap:!1,shadowMode:!1})},f9ef:function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,".shuiyin[data-v-6b563cc7]{position:absolute;top:0;right:%?20?%;width:%?150?%;height:%?100?%}.no-play-butt1[data-v-6b563cc7]{margin:%?20?% %?10?%;color:#fff;border-width:%?1?%;border-style:solid;border-color:#fff;border-radius:%?100?%;font-size:%?26?%;width:%?200?%;height:%?50?%;text-align:center;line-height:%?50?%}.no-play-butt[data-v-6b563cc7]{\ndisplay:flex;\nflex-direction:row;align-items:center;justify-content:center}.no-play-text[data-v-6b563cc7]{color:hsla(0,0%,100%,.8);font-size:%?28?%;margin-bottom:%?10?%}.no-play[data-v-6b563cc7]{width:%?750?%;height:%?500?%;position:absolute;z-index:30;background-color:#303133;\ndisplay:flex;\nflex-direction:column;align-items:center;justify-content:center}.close-image[data-v-6b563cc7]{width:%?100?%;height:%?100?%}.big-image[data-v-6b563cc7]{width:%?602?%;height:%?794?%}.tankuang[data-v-6b563cc7]{width:%?602?%;height:%?958?%;\ndisplay:flex;\nflex-direction:column;align-items:center;justify-content:space-between}.myvideo-item[data-v-6b563cc7]{width:%?750?%;height:%?500?%;position:absolute;top:0;left:0}.myvideo[data-v-6b563cc7]{width:%?750?%;height:%?500?%;position:relative;margin-bottom:%?28?%;\ndisplay:flex;\nalign-items:center;justify-content:center}.play-img[data-v-6b563cc7]{width:%?100?%;height:%?100?%;position:absolute;z-index:20}.fengmian[data-v-6b563cc7]{width:%?750?%;height:%?500?%;position:absolute;top:0;left:0;z-index:10\n    /* background-color: #c8c8c8; */}.fengexian[data-v-6b563cc7]{width:%?750?%;height:%?16?%;background-color:#313642}.wenzhang-dianzan-count[data-v-6b563cc7]{font-size:%?28?%;font-weight:400;color:#999}.wenzhang-dianzan[data-v-6b563cc7]{width:%?36?%;height:%?36?%;margin-left:%?28?%;margin-right:%?16?%}.wenzhang-down-right[data-v-6b563cc7]{flex-direction:row;align-items:center}.wenzhang-down-left[data-v-6b563cc7]{\ndisplay:flex;\nflex-direction:row;align-items:center;font-size:%?28?%;font-weight:400;color:#999}.wenzhang-down[data-v-6b563cc7]{flex-direction:row;align-items:center;justify-content:space-between;padding:0 %?20?%;width:%?750?%;margin:%?2?% 0 %?20?% 0}.item-text-content[data-v-6b563cc7]{width:%?600?%;text-overflow:ellipsis;lines:1;font-size:%?32?%;font-weight:400;color:#202020}.item-text[data-v-6b563cc7]{margin:0 %?32?% %?18?% %?32?%;flex-direction:row;align-items:center}.shequ-header-right[data-v-6b563cc7]{width:%?148?%;height:%?42?%;\ndisplay:flex;\nalign-items:center;flex-direction:row;justify-content:space-around}.shequ-header-right1[data-v-6b563cc7]{width:%?106?%;height:%?42?%;text-align:center;line-height:%?42?%;font-size:%?24?%;background-color:rgba(254,140,54,.23);color:#fe8c36}.shequ-header-right2[data-v-6b563cc7]{width:%?42?%;height:%?42?%;font-size:%?28?%;background-color:#fe8c36;color:#fff;text-align:center;line-height:%?42?%}.user-name[data-v-6b563cc7]{font-size:%?28?%;font-weight:600;color:#202020;margin-bottom:%?4?%;margin-right:%?8?%}.user-old[data-v-6b563cc7]{width:%?78?%;height:%?30?%}.user-vip[data-v-6b563cc7]{width:%?28?%;height:%?28?%}.user-new[data-v-6b563cc7]{width:%?170?%;height:%?50?%;margin-right:%?8?%}.userinfo[data-v-6b563cc7]{flex-direction:row;align-items:center}.header-user-image[data-v-6b563cc7]{width:%?72?%;height:%?72?%;border-radius:%?100?%;margin-top:%?20?%}.header-user[data-v-6b563cc7]{width:%?72?%;height:%?92?%;margin-right:%?16?%;position:relative;\n    /* border-width: 1rpx;\n\t\tborder-color: #000;\n\t\tborder-style: solid; */\n    /* justify-content: flex-end; */margin-bottom:%?5?%}.user-image-vip[data-v-6b563cc7]{width:%?72?%;height:%?30?%;margin-bottom:%?-10?%;position:absolute;top:%?0?%;left:0}.shequ-header-left[data-v-6b563cc7]{flex-direction:row;align-items:center}.shequ-header[data-v-6b563cc7]{flex-direction:row;align-items:center;justify-content:space-between;margin:%?16?% %?20?%}",""]),t.exports=e}}]);