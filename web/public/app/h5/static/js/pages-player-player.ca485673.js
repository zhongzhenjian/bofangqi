(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-player-player"],{"19c1":function(t,e,i){"use strict";i.r(e);var n=i("6611"),a=i.n(n);for(var s in n)"default"!==s&&function(t){i.d(e,t,(function(){return n[t]}))}(s);e["default"]=a.a},"23ef":function(t,e,i){"use strict";i.r(e);var n=i("b29c"),a=i.n(n);for(var s in n)"default"!==s&&function(t){i.d(e,t,(function(){return n[t]}))}(s);e["default"]=a.a},"4ca3":function(t,e,i){"use strict";i.r(e);var n=i("881d"),a=i("19c1");for(var s in a)"default"!==s&&function(t){i.d(e,t,(function(){return a[t]}))}(s);i("c0e1");var o,r=i("f0c5"),l=Object(r["a"])(a["default"],n["b"],n["c"],!1,null,"e7f555c2",null,!1,n["a"],o);e["default"]=l.exports},5311:function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.addplayer[data-v-e7f555c2]{position:fixed;bottom:%?98?%;width:%?136?%;height:%?136?%;right:%?14?%}.swiper[data-v-e7f555c2]{-webkit-box-flex:1;-webkit-flex:1;flex:1}.player[data-v-e7f555c2]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;height:calc(100vh - 50px)}.tab-list[data-v-e7f555c2]{width:%?750?%;height:%?100?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;background-color:#ffe46a}.tab-list .scroll-item[data-v-e7f555c2]{font-size:%?32?%;color:#202020;display:-webkit-inline-box;display:-webkit-inline-flex;display:inline-flex;margin:0 %?24?%;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.tab-list .scroll-item .gaoliang[data-v-e7f555c2]{color:#202020;font-size:%?36?%;font-weight:700}.tab-list .scroll-item .gaoliang1[data-v-e7f555c2]{background-color:#f90!important}.nav-bar[data-v-e7f555c2]{height:0;width:%?750?%;background-color:#ffe46a}',""]),t.exports=e},"5ba6":function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.hide-image[data-v-b03cb5b8]{-webkit-transition-duration:.5s;transition-duration:.5s;-webkit-transition-property:opacity;transition-property:opacity;opacity:0!important}.lazy[data-v-b03cb5b8]{position:relative}.lazy-image[data-v-b03cb5b8]{position:absolute;top:0;left:0}.lazy-load[data-v-b03cb5b8]{position:absolute;-webkit-transition-duration:.5s;transition-duration:.5s;-webkit-transition-property:opacity;transition-property:opacity;top:0;left:0;z-index:10;opacity:1}',""]),t.exports=e},6611:function(t,e,i){"use strict";var n=i("ee27");i("99af"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a=n(i("a4fd")),s={data:function(){return{list:[{title:"关注"}],num:1}},onLoad:function(){this.getdata()},onShow:function(){uni.setTabBarStyle({backgroundColor:"#fff",selectedColor:"#666"})},components:{playerList:a.default},methods:{qiehuan:function(t){this.num=t},getdata:function(){var t=this;this.$loading(),uni.request({url:this.$url+"/api/direct/direct_list",success:function(e){t.list=t.list.concat(e.data.data),t.getlist()}})},getlist:function(){var t=this,e="player"+this.num;0==this.num?this.$nextTick((function(){t.$refs[e][0].getguanzhu(1)})):this.$nextTick((function(){t.$refs[e][0].getlist(1)}))},changeswiper:function(t){this.num=t.detail.current,this.getlist()},addplayer:function(){uni.navigateTo({url:"./addplayer"})},tovideo:function(){uni.navigateTo({url:"./video"})}}};e.default=s},"881d":function(t,e,i){"use strict";var n,a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("v-uni-view",{staticClass:"player"},[n("v-uni-view",{staticClass:"nav-bar"}),n("v-uni-view",{staticClass:"tab-list"},[n("v-uni-scroll-view",{staticStyle:{"white-space":"nowrap"},attrs:{"scroll-x":"true"}},t._l(t.list,(function(e,i){return n("v-uni-view",{key:i,staticClass:"scroll-item"},[n("v-uni-text",{class:t.num==i?"gaoliang":"",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.qiehuan(i)}}},[t._v(t._s(e.title))])],1)})),1)],1),n("v-uni-swiper",{staticClass:"swiper",attrs:{interval:3e3,duration:300,current:t.num},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.changeswiper.apply(void 0,arguments)}}},t._l(t.list,(function(t,e){return n("v-uni-swiper-item",{key:e},[n("player-list",{ref:"player"+e,refInFor:!0,attrs:{ids:t.id,index:e}})],1)})),1),n("v-uni-image",{staticClass:"addplayer",attrs:{src:i("d69f")},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.addplayer.apply(void 0,arguments)}}})],1)},s=[];i.d(e,"b",(function(){return a})),i.d(e,"c",(function(){return s})),i.d(e,"a",(function(){return n}))},"8ba1":function(t,e,i){"use strict";i.r(e);var n=i("d361"),a=i("940e");for(var s in a)"default"!==s&&function(t){i.d(e,t,(function(){return a[t]}))}(s);i("e54a");var o,r=i("f0c5"),l=Object(r["a"])(a["default"],n["b"],n["c"],!1,null,"b03cb5b8",null,!1,n["a"],o);e["default"]=l.exports},"940e":function(t,e,i){"use strict";i.r(e);var n=i("9787"),a=i.n(n);for(var s in n)"default"!==s&&function(t){i.d(e,t,(function(){return n[t]}))}(s);e["default"]=a.a},9787:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n={props:{src:{type:String,default:""},image:{type:String,default:"/static/images/51.png"},mode:{type:String,default:"scaleToFill"},borderRadius:{type:String,default:"10rpx"},width:{type:String,default:"100rpx"},height:{type:String,default:"100rpx"}},data:function(){return{is_load:!0}},methods:{showimage:function(){this.is_load=!1}}};e.default=n},a4fd:function(t,e,i){"use strict";i.r(e);var n=i("cc91"),a=i("23ef");for(var s in a)"default"!==s&&function(t){i.d(e,t,(function(){return a[t]}))}(s);i("c943");var o,r=i("f0c5"),l=Object(r["a"])(a["default"],n["b"],n["c"],!1,null,"0761874e",null,!1,n["a"],o);e["default"]=l.exports},a560:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n={data:function(){return{mescroll:null}},onPullDownRefresh:function(){this.mescroll&&this.mescroll.onPullDownRefresh()},onPageScroll:function(t){this.mescroll&&this.mescroll.onPageScroll(t)},onReachBottom:function(){this.mescroll&&this.mescroll.onReachBottom()},methods:{mescrollInit:function(t){this.mescroll=t,this.mescrollInitByRef()},mescrollInitByRef:function(){if(!this.mescroll||!this.mescroll.resetUpScroll){var t=this.$refs.mescrollRef;t&&(this.mescroll=t.mescroll)}},downCallback:function(){var t=this;this.mescroll.optUp.use?this.mescroll.resetUpScroll():setTimeout((function(){t.mescroll.endSuccess()}),500)},upCallback:function(){var t=this;setTimeout((function(){t.mescroll.endErr()}),500)}},mounted:function(){this.mescrollInitByRef()}},a=n;e.default=a},a698:function(t,e,i){var n=i("5311");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=i("4f06").default;a("1238172f",n,!0,{sourceMap:!1,shadowMode:!1})},b29c:function(t,e,i){"use strict";(function(t){var n=i("ee27");i("99af"),i("a9e3"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a=n(i("a560")),s=n(i("8ba1")),o={props:{ids:{type:Number,default:1},index:{type:Number,default:1}},mixins:[a.default],data:function(){return{page:1,list:[],more:"more",guanggao:[],downOption:{auto:!1},upOption:{auto:!1},isliebiao:!1,isguanzhu:!1}},components:{lazy:s.default},methods:{downCallback:function(){this.page=1,this.list=[],this.isguanzhu?this.getguanzhu(2):this.getlist(2)},openurl:function(e){t("log",e," at pages/player/player-list.vue:81")},todown:function(){0!=this.index&&"noMore"!=this.more&&(this.more="loading",this.page++,this.getlist(2))},getguanzhu:function(t){var e=this;return this.isguanzhu=!0,!!uni.getStorageSync("usertoken")&&((0==this.list.length||1!=t)&&(0==this.list.length&&1==t&&this.$loading(),void uni.request({url:this.$url+"/follow",method:"POST",header:{token:uni.getStorageSync("usertoken")},success:function(t){uni.hideLoading(),e.list=e.list.concat(t.data.data),e.mescroll.endErr(),e.mescroll.endSuccess(t.data.data.length)}})))},getlbt:function(){var t=this;uni.request({url:this.$url+"/direct/banner",success:function(e){t.guanggao=e.data.data}})},getlist:function(t){var e=this;if(this.isliebiao=!0,0!=this.list.length&&1==t)return!1;0==this.list.length&&1==t&&(this.$loading(),this.getlbt()),uni.request({url:this.$url+"/api/direct/index",method:"POST",data:{class:this.ids,every:10,current:this.page},success:function(t){uni.hideLoading(),e.list=e.list.concat(t.data.data),e.list.length<9?e.more="noMore":e.more="more",e.mescroll.endErr(),e.mescroll.endSuccess(t.data.data.length)}})},tovideo:function(t){uni.request({url:this.$url+"/direct/room/"+t.id,method:"PUT",success:function(t){}});var e=0==this.index?t.anchor.direct.direct_image_text:t.direct_image_text,i=0==this.index?t.anchor.direct.id:t.id;uni.navigateTo({url:"./video?id="+i+"&img="+e})}}};e.default=o}).call(this,i("0de9")["log"])},b311:function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.scroll-index[data-v-0761874e]{width:%?750?%;-webkit-box-flex:1;-webkit-flex:1;flex:1}.scroll-index .play-list[data-v-0761874e]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;-webkit-flex-wrap:wrap;flex-wrap:wrap;padding:%?20?% %?10?%}.scroll-index .play-list .play-item[data-v-0761874e]{width:%?345?%;margin:0 %?10?%;border-radius:%?20?%;overflow:hidden;position:relative;margin-bottom:%?20?%}.scroll-index .play-list .play-item .fengmian[data-v-0761874e]{width:%?345?%;height:%?345?%;border-radius:%?20?%}.scroll-index .play-list .play-item .down-detail[data-v-0761874e]{border-radius:%?20?%;position:absolute;bottom:%?0?%;left:0;width:%?285?%;background-color:rgba(0,0,0,.2);padding:0 %?30?%;z-index:999}.scroll-index .play-list .play-item .down-detail .name[data-v-0761874e]{color:#fff;font-size:%?28?%}.scroll-index .play-list .play-item .down-detail .down-tab[data-v-0761874e]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;color:#fff;font-size:%?24?%;border-radius:%?20?%}.scroll-index .play-list .play-item .down-detail .down-tab .left[data-v-0761874e]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.scroll-index .play-list .play-item .down-detail .down-tab .left uni-text[data-v-0761874e]:first-child{width:%?10?%;height:%?10?%;border-radius:%?100?%;display:inline-block;background-color:#ff6d6d;margin-right:%?10?%}.scroll-index .gg-swiper[data-v-0761874e]{width:%?750?%;height:%?228?%;margin:%?20?% 0 0 0}.scroll-index .gg-swiper .gg-img[data-v-0761874e]{width:%?710?%;height:%?228?%}',""]),t.exports=e},bd92:function(t,e,i){var n=i("5ba6");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=i("4f06").default;a("e5745a5e",n,!0,{sourceMap:!1,shadowMode:!1})},c0e1:function(t,e,i){"use strict";var n=i("a698"),a=i.n(n);a.a},c943:function(t,e,i){"use strict";var n=i("eb14"),a=i.n(n);a.a},cc91:function(t,e,i){"use strict";var n={mescrollUni:i("4f2c").default},a=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticStyle:{display:"flex","flex-direction":"column",height:"100%"}},[i("mescroll-uni",{ref:"mescrollRef",staticClass:"scroll-index",attrs:{up:t.upOption,down:t.downOption},on:{down:function(e){arguments[0]=e=t.$handleEvent(e),t.downCallback.apply(void 0,arguments)},up:function(e){arguments[0]=e=t.$handleEvent(e),t.todown.apply(void 0,arguments)}}},[1==t.index?i("v-uni-swiper",{staticClass:"gg-swiper",attrs:{autoplay:!0,interval:3e3,duration:800}},t._l(t.guanggao,(function(e,n){return i("v-uni-swiper-item",{key:n,staticStyle:{display:"flex","justify-content":"center"},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.openurl(e)}}},[i("lazy",{attrs:{src:e.image_text,width:"710rpx",height:"228rpx"}})],1)})),1):t._e(),i("v-uni-view",{staticClass:"play-list"},t._l(t.list,(function(e,n){return i("v-uni-view",{key:n,staticClass:"play-item",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.tovideo(e)}}},[i("lazy",{attrs:{src:0==t.index?e.anchor.direct.direct_image_text:e.direct_image_text,image:"/static/images/162.png",borderRadius:"20rpx",height:"345rpx",width:"345rpx"}}),i("v-uni-view",{staticClass:"down-detail"},[i("v-uni-text",{staticClass:"name"},[t._v(t._s(0==t.index?e.anchor.direct.direct_name:e.direct_name))]),i("v-uni-view",{staticClass:"down-tab"},[i("v-uni-view",{staticClass:"left"},[i("v-uni-text"),i("v-uni-text",[t._v(t._s(e.anchor.name))])],1),i("v-uni-text",{staticClass:"right"},[t._v(t._s(0==t.index?e.anchor.direct.online:e.online))])],1)],1)],1)})),1)],1)],1)},s=[];i.d(e,"b",(function(){return a})),i.d(e,"c",(function(){return s})),i.d(e,"a",(function(){return n}))},d361:function(t,e,i){"use strict";var n,a=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"lazy",style:{"border-radius":t.borderRadius,width:t.width,height:t.height}},[i("v-uni-image",{staticClass:"lazy-image",style:{"border-radius":t.borderRadius,width:t.width,height:t.height},attrs:{src:t.src,mode:t.mode},on:{load:function(e){arguments[0]=e=t.$handleEvent(e),t.showimage.apply(void 0,arguments)}}}),i("v-uni-image",{staticClass:"lazy-load",class:t.is_load?"":"hide-image",style:{"border-radius":t.borderRadius,width:t.width,height:t.height},attrs:{src:t.image,mode:t.mode}})],1)},s=[];i.d(e,"b",(function(){return a})),i.d(e,"c",(function(){return s})),i.d(e,"a",(function(){return n}))},d69f:function(t,e,i){t.exports=i.p+"static/img/150.aea7042f.png"},e54a:function(t,e,i){"use strict";var n=i("bd92"),a=i.n(n);a.a},eb14:function(t,e,i){var n=i("b311");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=i("4f06").default;a("343bc8a2",n,!0,{sourceMap:!1,shadowMode:!1})}}]);