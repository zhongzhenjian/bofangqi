(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-player-player"],{"0294":function(t,i,e){"use strict";var n=e("6b17"),a=e.n(n);a.a},"0700":function(t,i,e){"use strict";(function(t){e("7a82");var n=e("4ea4").default;Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0,e("a9e3"),e("99af");var a=n(e("7a42")),s=n(e("977f")),o={props:{ids:{type:Number,default:1},index:{type:Number,default:1}},mixins:[a.default],data:function(){return{page:1,list:[],more:"more",guanggao:[],downOption:{auto:!1},upOption:{auto:!1},isliebiao:!1,isguanzhu:!1}},components:{lazy:s.default},methods:{downCallback:function(){this.page=1,this.list=[],this.isguanzhu?this.getguanzhu(2):this.getlist(2)},openurl:function(i){t.log(i)},todown:function(){0!=this.index&&"noMore"!=this.more&&(this.more="loading",this.page++,this.getlist(2))},getguanzhu:function(t){var i=this;return this.isguanzhu=!0,!!uni.getStorageSync("usertoken")&&((0==this.list.length||1!=t)&&(0==this.list.length&&1==t&&this.$loading(),void uni.request({url:this.$url+"/follow",method:"POST",header:{token:uni.getStorageSync("usertoken")},success:function(t){uni.hideLoading(),i.list=i.list.concat(t.data.data),i.mescroll.endErr(),i.mescroll.endSuccess(t.data.data.length)}})))},getlbt:function(){var t=this;uni.request({url:this.$url+"/direct/banner",success:function(i){t.guanggao=i.data.data}})},getlist:function(t){var i=this;if(this.isliebiao=!0,0!=this.list.length&&1==t)return!1;0==this.list.length&&1==t&&(this.$loading(),this.getlbt()),uni.request({url:this.$url+"/api/direct/index",method:"POST",data:{class:this.ids,every:10,current:this.page},success:function(t){uni.hideLoading(),i.list=i.list.concat(t.data.data),i.list.length<9?i.more="noMore":i.more="more",i.mescroll.endErr(),i.mescroll.endSuccess(t.data.data.length)}})},tovideo:function(t){uni.request({url:this.$url+"/direct/room/"+t.id,method:"PUT",success:function(t){}});var i=0==this.index?t.anchor.direct.direct_image_text:t.direct_image_text,e=0==this.index?t.anchor.direct.id:t.id;uni.navigateTo({url:"./video?id="+e+"&img="+i})}}};i.default=o}).call(this,e("5a52")["default"])},"0fdb":function(t,i,e){"use strict";e.d(i,"b",(function(){return n})),e.d(i,"c",(function(){return a})),e.d(i,"a",(function(){}));var n=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("v-uni-view",{staticClass:"player"},[e("v-uni-view",{staticClass:"nav-bar"}),e("v-uni-view",{staticClass:"tab-list"},[e("v-uni-scroll-view",{staticStyle:{"white-space":"nowrap"},attrs:{"scroll-x":"true"}},t._l(t.list,(function(i,n){return e("v-uni-view",{key:n,staticClass:"scroll-item"},[e("v-uni-text",{class:t.num==n?"gaoliang":"",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.qiehuan(n)}}},[t._v(t._s(i.title))])],1)})),1)],1),e("v-uni-swiper",{staticClass:"swiper",attrs:{interval:3e3,duration:300,current:t.num},on:{change:function(i){arguments[0]=i=t.$handleEvent(i),t.changeswiper.apply(void 0,arguments)}}},t._l(t.list,(function(t,i){return e("v-uni-swiper-item",{key:i},[e("player-list",{ref:"player"+i,refInFor:!0,attrs:{ids:t.id,index:i}})],1)})),1)],1)},a=[]},2537:function(t,i,e){"use strict";e.r(i);var n=e("0fdb"),a=e("e887");for(var s in a)["default"].indexOf(s)<0&&function(t){e.d(i,t,(function(){return a[t]}))}(s);e("8faa");var o=e("f0c5"),r=Object(o["a"])(a["default"],n["b"],n["c"],!1,null,"4100fb42",null,!1,n["a"],void 0);i["default"]=r.exports},"30cb":function(t,i,e){var n=e("24fb");i=n(!1),i.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.addplayer[data-v-4100fb42]{position:fixed;bottom:%?98?%;width:%?136?%;height:%?136?%;right:%?14?%}.swiper[data-v-4100fb42]{flex:1}.player[data-v-4100fb42]{display:flex;flex-direction:column;height:calc(100vh - 50px)}.tab-list[data-v-4100fb42]{width:%?750?%;height:%?100?%;display:flex;align-items:center;background-color:#fff}.tab-list .scroll-item[data-v-4100fb42]{font-size:%?32?%;color:#202020;display:inline-flex;margin:0 %?24?%;flex-direction:column;align-items:center}.tab-list .scroll-item .gaoliang[data-v-4100fb42]{color:#ef4f67;font-size:%?36?%;font-weight:700}.tab-list .scroll-item .gaoliang1[data-v-4100fb42]{background-color:#f90!important}.nav-bar[data-v-4100fb42]{height:0;width:%?750?%;background-color:#fff\n  /*状态栏COLOR*/}',""]),t.exports=i},"34fc":function(t,i,e){var n=e("24fb");i=n(!1),i.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.hide-image[data-v-01c8b901]{transition-duration:.5s;transition-property:opacity;opacity:0!important}.lazy[data-v-01c8b901]{position:relative}.lazy-image[data-v-01c8b901]{position:absolute;top:0;left:0}.lazy-load[data-v-01c8b901]{position:absolute;transition-duration:.5s;transition-property:opacity;top:0;left:0;z-index:10;opacity:1}',""]),t.exports=i},4520:function(t,i,e){"use strict";e.d(i,"b",(function(){return n})),e.d(i,"c",(function(){return a})),e.d(i,"a",(function(){}));var n=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("v-uni-view",{staticClass:"lazy",style:{"border-radius":t.borderRadius,width:t.width,height:t.height}},[e("v-uni-image",{staticClass:"lazy-image",style:{"border-radius":t.borderRadius,width:t.width,height:t.height},attrs:{src:t.src,mode:t.mode},on:{load:function(i){arguments[0]=i=t.$handleEvent(i),t.showimage.apply(void 0,arguments)}}}),e("v-uni-image",{staticClass:"lazy-load",class:t.is_load?"":"hide-image",style:{"border-radius":t.borderRadius,width:t.width,height:t.height},attrs:{src:t.image,mode:t.mode}})],1)},a=[]},"52b8":function(t,i,e){"use strict";e.r(i);var n=e("9d1c"),a=e.n(n);for(var s in n)["default"].indexOf(s)<0&&function(t){e.d(i,t,(function(){return n[t]}))}(s);i["default"]=a.a},"5bb4":function(t,i,e){"use strict";var n=e("b97b"),a=e.n(n);a.a},"5eea":function(t,i,e){"use strict";e.r(i);var n=e("0700"),a=e.n(n);for(var s in n)["default"].indexOf(s)<0&&function(t){e.d(i,t,(function(){return n[t]}))}(s);i["default"]=a.a},"6b17":function(t,i,e){var n=e("34fc");n.__esModule&&(n=n.default),"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=e("4f06").default;a("02b0534c",n,!0,{sourceMap:!1,shadowMode:!1})},"7a42":function(t,i,e){"use strict";e("7a82"),Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;var n={data:function(){return{mescroll:null}},onPullDownRefresh:function(){this.mescroll&&this.mescroll.onPullDownRefresh()},onPageScroll:function(t){this.mescroll&&this.mescroll.onPageScroll(t)},onReachBottom:function(){this.mescroll&&this.mescroll.onReachBottom()},methods:{mescrollInit:function(t){this.mescroll=t,this.mescrollInitByRef()},mescrollInitByRef:function(){if(!this.mescroll||!this.mescroll.resetUpScroll){var t=this.$refs.mescrollRef;t&&(this.mescroll=t.mescroll)}},downCallback:function(){var t=this;this.mescroll.optUp.use?this.mescroll.resetUpScroll():setTimeout((function(){t.mescroll.endSuccess()}),500)},upCallback:function(){var t=this;setTimeout((function(){t.mescroll.endErr()}),500)}},mounted:function(){this.mescrollInitByRef()}},a=n;i.default=a},"86d2":function(t,i,e){"use strict";e.d(i,"b",(function(){return a})),e.d(i,"c",(function(){return s})),e.d(i,"a",(function(){return n}));var n={mescrollUni:e("634b").default},a=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("v-uni-view",{staticStyle:{display:"flex","flex-direction":"column",height:"100%"}},[e("mescroll-uni",{ref:"mescrollRef",staticClass:"scroll-index",attrs:{up:t.upOption,down:t.downOption},on:{down:function(i){arguments[0]=i=t.$handleEvent(i),t.downCallback.apply(void 0,arguments)},up:function(i){arguments[0]=i=t.$handleEvent(i),t.todown.apply(void 0,arguments)}}},[1==t.index?e("v-uni-swiper",{staticClass:"gg-swiper",attrs:{autoplay:!0,interval:3e3,duration:800}},t._l(t.guanggao,(function(i,n){return e("v-uni-swiper-item",{key:n,staticStyle:{display:"flex","justify-content":"center"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.openurl(i)}}},[e("lazy",{attrs:{src:i.image_text,width:"710rpx",height:"228rpx"}})],1)})),1):t._e(),e("v-uni-view",{staticClass:"play-list"},t._l(t.list,(function(i,n){return e("v-uni-view",{key:n,staticClass:"play-item",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.tovideo(i)}}},[e("lazy",{attrs:{src:0==t.index?i.anchor.direct.direct_image_text:i.direct_image_text,image:"/static/images/162.png",borderRadius:"20rpx",height:"345rpx",width:"345rpx"}}),e("v-uni-view",{staticClass:"down-detail"},[e("v-uni-text",{staticClass:"name"},[t._v(t._s(0==t.index?i.anchor.direct.direct_name:i.direct_name))]),e("v-uni-view",{staticClass:"down-tab"},[e("v-uni-view",{staticClass:"left"},[e("v-uni-text"),e("v-uni-text",[t._v(t._s(i.anchor.name))])],1),e("v-uni-text",{staticClass:"right"},[t._v(t._s(0==t.index?i.anchor.direct.online:i.online))])],1)],1)],1)})),1)],1)],1)},s=[]},"8faa":function(t,i,e){"use strict";var n=e("b215"),a=e.n(n);a.a},"977f":function(t,i,e){"use strict";e.r(i);var n=e("4520"),a=e("52b8");for(var s in a)["default"].indexOf(s)<0&&function(t){e.d(i,t,(function(){return a[t]}))}(s);e("0294");var o=e("f0c5"),r=Object(o["a"])(a["default"],n["b"],n["c"],!1,null,"01c8b901",null,!1,n["a"],void 0);i["default"]=r.exports},"9d1c":function(t,i,e){"use strict";e("7a82"),Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;var n={props:{src:{type:String,default:""},image:{type:String,default:"/static/images/51.png"},mode:{type:String,default:"scaleToFill"},borderRadius:{type:String,default:"10rpx"},width:{type:String,default:"100rpx"},height:{type:String,default:"100rpx"}},data:function(){return{is_load:!0}},methods:{showimage:function(){this.is_load=!1}}};i.default=n},b215:function(t,i,e){var n=e("30cb");n.__esModule&&(n=n.default),"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=e("4f06").default;a("b84addd4",n,!0,{sourceMap:!1,shadowMode:!1})},b97b:function(t,i,e){var n=e("bc2d");n.__esModule&&(n=n.default),"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=e("4f06").default;a("127ab986",n,!0,{sourceMap:!1,shadowMode:!1})},b9bc:function(t,i,e){"use strict";e.r(i);var n=e("86d2"),a=e("5eea");for(var s in a)["default"].indexOf(s)<0&&function(t){e.d(i,t,(function(){return a[t]}))}(s);e("5bb4");var o=e("f0c5"),r=Object(o["a"])(a["default"],n["b"],n["c"],!1,null,"7d3adbfc",null,!1,n["a"],void 0);i["default"]=r.exports},bc2d:function(t,i,e){var n=e("24fb");i=n(!1),i.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.scroll-index[data-v-7d3adbfc]{width:%?750?%;flex:1}.scroll-index .play-list[data-v-7d3adbfc]{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;padding:%?20?% %?10?%}.scroll-index .play-list .play-item[data-v-7d3adbfc]{width:%?345?%;margin:0 %?10?%;border-radius:%?20?%;overflow:hidden;position:relative;margin-bottom:%?20?%}.scroll-index .play-list .play-item .fengmian[data-v-7d3adbfc]{width:%?345?%;height:%?345?%;border-radius:%?20?%}.scroll-index .play-list .play-item .down-detail[data-v-7d3adbfc]{border-radius:%?20?%;position:absolute;bottom:%?0?%;left:0;width:%?285?%;background-color:rgba(0,0,0,.2);padding:0 %?30?%;z-index:999}.scroll-index .play-list .play-item .down-detail .name[data-v-7d3adbfc]{color:#fff;font-size:%?28?%}.scroll-index .play-list .play-item .down-detail .down-tab[data-v-7d3adbfc]{display:flex;align-items:center;justify-content:space-between;color:#fff;font-size:%?24?%;border-radius:%?20?%}.scroll-index .play-list .play-item .down-detail .down-tab .left[data-v-7d3adbfc]{display:flex;align-items:center}.scroll-index .play-list .play-item .down-detail .down-tab .left uni-text[data-v-7d3adbfc]:first-child{width:%?10?%;height:%?10?%;border-radius:%?100?%;display:inline-block;background-color:#ff6d6d;margin-right:%?10?%}.scroll-index .gg-swiper[data-v-7d3adbfc]{width:%?750?%;height:%?228?%;margin:%?20?% 0 0 0}.scroll-index .gg-swiper .gg-img[data-v-7d3adbfc]{width:%?710?%;height:%?228?%}',""]),t.exports=i},e405:function(t,i,e){"use strict";e("7a82");var n=e("4ea4").default;Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0,e("99af");var a=n(e("b9bc")),s={data:function(){return{list:[{title:"关注主播"}],num:1}},onLoad:function(){this.getdata()},onShow:function(){uni.setTabBarStyle({backgroundColor:"#fafff0",selectedColor:"#666"})},components:{playerList:a.default},methods:{qiehuan:function(t){this.num=t},getdata:function(){var t=this;this.$loading(),uni.request({url:this.$url+"/api/direct/direct_list",success:function(i){t.list=t.list.concat(i.data.data),t.getlist()}})},getlist:function(){var t=this,i="player"+this.num;0==this.num?this.$nextTick((function(){t.$refs[i][0].getguanzhu(1)})):this.$nextTick((function(){t.$refs[i][0].getlist(1)}))},changeswiper:function(t){this.num=t.detail.current,this.getlist()},addplayer:function(){uni.navigateTo({url:"./addplayer"})},tovideo:function(){uni.navigateTo({url:"./video"})}}};i.default=s},e887:function(t,i,e){"use strict";e.r(i);var n=e("e405"),a=e.n(n);for(var s in n)["default"].indexOf(s)<0&&function(t){e.d(i,t,(function(){return n[t]}))}(s);i["default"]=a.a}}]);