(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-index-seach"],{"228e":function(t,i){t.exports="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABwAAAAcCAYAAAByDd+UAAAD1ElEQVRIS7WWWSi0URjH/2OLEGW9oCTLlS1EWW5EwgUKyVbTXIxIZEmKrBeyZCnmxkSiXChSCCU3sqaRKGuWEMnSGKK8X8/5mrdvvO/M+Abnapr3POd3zrP8n0ei0Wg4iCyO47C3t4f19XXs7+/j/v4eLy8vcHBwgLOzM4KDgxEeHg43Nzcxc73/ScSAKpUKIyMjOD8/5w3t7OxgY2ODx8dHvL298f9HRUUhOzsbTk5OXwLrAD8+PjA0NIS5uTlmHBYWhujoaAQFBcHa2po/8Pb2lr18YWEBV1dX7FtJSQlCQkKMQnkgwdrb27G1tQV3d3cUFhbCz8/P4AFkMzs7i9HRUdBvuVyO2NhYgzY8cHh4GNPT0/D390dFRQXIhV9dFOu2tja8v7+jrq4Ovr6+hmO4u7uLpqYmuLq6oqWl5b9g2pM3NzeZh1xcXNDZ2QkLCwtRKHthbW0tDg8PUV9fz15o6hoYGGBxLSgoQGJiojhQpVJx5AYKeFVVlaksZkelU1paCkdHR3R3d4sDlUolNzk5yTZGRER8C0jGHR0d2NjYYDH18PAQnCeprKzkDg4OoFQqdVLfVDK5lFwrlUoRHx8vBMpkMo4KWaFQmMrQsdvZ2WGJl5qaiqysLCEwMzOTo8wiF/zEOj09RXV1NeLi4iCTyYRAqVTKUdH29fX9BA/aEktJSUFOTo4QWF5ezh0fH2NwcBCWlpbfhi4tLbHw5OXlISkpSQhUKBTczMwMK4mvaKGxG/X29mJ5eZkJiY+PjxC4trbGUZBJ9YuLi42dZ/C7RqNhZ1hZWbEQmZmZCYFqtZoj7by+vkZrays8PT1Nho6NjWFiYgLp6enIyMjQL22rq6vo6uqCt7c3kzdTYknS2NDQAFtbW6ap+sSf7xYkRSsrK0xtyC36xFfs2peXl2hubmbSlpycjNzcXL1e4oFU/PS6k5MTJuAEpVHC2KIu0d/fj+fnZ7ZVIpEY7Is6Hf/19RU9PT2sCdMLExISEBMTAy8vLx0u9b3t7W3WfElZzM3NkZaWhsXFRdzd3TFoUVERS8TPSzDT0PA0Pz+P8fFxPD09sf3awYlmmoeHB9zc3PBzDaV+fn4+a7qUeI2Njcy1lKE0dnxuCKJDFEFoQqOY0uxC4q5Wq3mX0cAUGBiIyMhIBAQE6DyC4klQGrYISl2Ipjvt0gv87ApyI9WZvb29aH39u//i4oIVPnmI3F1WVobQ0NC/F9Y3lxpLFmPfz87OGJQ8Q/lAtU7T368B6UKU8aRilMFU2zU1Nb8LJOjR0RGDUk5QAv3qC7Vup240NTXFyuwPch7khYLOwMAAAAAASUVORK5CYII="},"3e45":function(t,i,e){"use strict";(function(t){var a=e("4ea4");e("99af"),Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;var n=a(e("2d5e")),s=a(e("189a")),o=a(e("5940")),l=a(e("b3f7")),u={data:function(){return{iStatusBarHeight:0,isshow:!0,lishi:[],seachtext:"",page:1,limit:10,url:getApp().globalData.url,header:getApp().globalData.header,lishidata:[],videoid:""}},components:{tuwen:n.default,duanwen:s.default,shipin:o.default,wenda:l.default},onLoad:function(){this.iStatusBarHeight=uni.getSystemInfoSync().statusBarHeight,this.getlishi()},methods:{playvideo:function(t){this.videoid&&this.$refs[this.videoid][0].pausevideo(),this.videoid="video"+t},seachlishi:function(t){this.seachtext=t,this.sousuo()},sousuo:function(){var i=this;if(""==this.seachtext)return uni.showToast({icon:"none",title:"请输入内容"}),!1;this.setlishi(),uni.showLoading({mask:!0,title:"请稍后"}),uni.request({url:this.url+"/api/sreach/community",method:"GET",data:{title:this.seachtext,current:this.page,every:this.limit},success:function(e){uni.hideLoading(),0==e.data.data.length?(uni.showToast({icon:"none",title:"暂无更多内容"}),1!=i.page&&i.page--):(i.lishidata=i.lishidata.concat(e.data.data),i.isshow=!1),t.log(e.data)}})},setlishi:function(){this.lishi.push(this.seachtext),uni.setStorageSync("shequlishi",this.lishi)},getlishi:function(){uni.getStorageSync("shequlishi")&&(this.lishi=uni.getStorageSync("shequlishi"))}},computed:{statusheight:function(){var t=uni.upx2px(88)+this.iStatusBarHeight;return t}}};i.default=u}).call(this,e("5a52")["default"])},"4ee7":function(t,i,e){"use strict";var a;e.d(i,"b",(function(){return n})),e.d(i,"c",(function(){return s})),e.d(i,"a",(function(){return a}));var n=function(){var t=this,i=t.$createElement,a=t._self._c||i;return a("v-uni-view",[a("v-uni-view",{staticClass:"status-bar",style:{height:t.iStatusBarHeight+"px"}}),a("v-uni-view",{staticClass:"stach-head",style:{top:t.iStatusBarHeight+"px"}},[a("v-uni-view",{staticClass:"input"},[a("v-uni-image",{staticClass:"input-img",attrs:{src:e("228e")}}),a("v-uni-input",{staticClass:"input-input",attrs:{type:"text",placeholder:"输入你想要的"},model:{value:t.seachtext,callback:function(i){t.seachtext=i},expression:"seachtext"}})],1),a("v-uni-text",{staticClass:"input-text",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.sousuo.apply(void 0,arguments)}}},[t._v("搜索")])],1),a("v-uni-view",{staticClass:"bg-height",style:{height:t.statusheight+"px"}}),t.isshow?a("v-uni-view",{staticClass:"lishi-list"},[a("v-uni-text",{staticClass:"lishi-list-title"},[t._v("搜索记录")]),a("v-uni-view",{staticClass:"lishi-list-item-list"},t._l(t.lishi,(function(i,e){return a("v-uni-text",{key:e,staticClass:"lishi-list-item-list-item",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.seachlishi(i)}}},[t._v(t._s(i))])})),1)],1):t._e(),t.isshow?t._e():a("v-uni-view",t._l(t.lishidata,(function(i,e){return a("v-uni-view",{key:e},[2==i.class?a("tuwen",{attrs:{items:i}}):0==i.class?a("duanwen",{attrs:{items:i}}):1==i.class?a("shipin",{ref:"video"+e,refInFor:!0,attrs:{items:i,id:"video"+e},on:{playvideo:function(i){arguments[0]=i=t.$handleEvent(i),t.playvideo(e)}}}):t._e()],1)})),1)],1)},s=[]},"5fe4":function(t,i,e){var a=e("708c");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=e("4f06").default;n("1d06c7a7",a,!0,{sourceMap:!1,shadowMode:!1})},"64f7":function(t,i,e){"use strict";var a=e("5fe4"),n=e.n(a);n.a},"708c":function(t,i,e){var a=e("24fb");i=a(!1),i.push([t.i,'@charset "UTF-8";\n/**\n * 这里是uni-app内置的常用样式变量\n *\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\n *\n */\n/**\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\n *\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\n */\n/* 颜色变量 */\n/* 行为相关颜色 */\n/* 文字基本颜色 */\n/* 背景颜色 */\n/* 边框颜色 */\n/* 尺寸变量 */\n/* 文字尺寸 */\n/* 图片尺寸 */\n/* Border Radius */\n/* 水平间距 */\n/* 垂直间距 */\n/* 透明度 */\n/* 文章场景相关 */.remen-list[data-v-32fa67c9]{padding:0 %?32?%}.remen-list-item-list[data-v-32fa67c9]{display:flex;flex-direction:row;align-items:center;flex-wrap:wrap;justify-content:space-between}.remen-list-item-lis-item[data-v-32fa67c9]{width:%?330?%;overflow:hidden;text-overflow:ellipsis;lines:1;font-size:%?24?%;font-weight:400;color:#202000;margin-bottom:%?30?%}.remen-list-title[data-v-32fa67c9]{font-size:%?28?%;font-family:PingFangSC-Regular,PingFang SC;font-weight:400;color:#202000;margin-bottom:%?36?%}.lishi-list[data-v-32fa67c9]{padding:%?16?% %?32?%;margin-bottom:%?32?%}.lishi-list-item-list[data-v-32fa67c9]{display:flex;flex-direction:row;align-items:center;flex-wrap:wrap}.lishi-list-item-list-item[data-v-32fa67c9]{width:%?120?%;height:%?52?%;background-color:#f4f1f7;border-radius:%?8?%;text-align:center;line-height:%?52?%;font-size:%?24?%;font-family:PingFangSC-Regular,PingFang SC;font-weight:400;color:#333;margin-right:%?32?%;margin-bottom:%?24?%}.lishi-list-title[data-v-32fa67c9]{font-size:%?28?%;font-weight:400;color:#202000;margin-bottom:%?16?%}.bg-height[data-v-32fa67c9]{width:%?750?%}.stach-head[data-v-32fa67c9]{background-color:#fff;height:%?88?%;width:%?750?%;position:fixed;z-index:30;left:0;padding:0 %?32?%;display:flex;flex-direction:row;align-items:center;justify-content:space-between}.input[data-v-32fa67c9]{width:%?598?%;height:%?56?%;background-color:#f4f1f7;\n  /*border-radius: 32rpx;*/border-radius:%?10?%;display:flex;flex-direction:row;align-items:center;padding:0 %?36?%}.input-input[data-v-32fa67c9]{width:%?500?%;font-size:%?24?%}.input-img[data-v-32fa67c9]{width:%?28?%;height:%?28?%;margin-right:%?10?%}.input-text[data-v-32fa67c9]{font-size:%?28?%;font-family:PingFangSC-Regular,PingFang SC;font-weight:400;color:#202000}.status-bar[data-v-32fa67c9]{background-color:#fff;position:fixed;top:0;left:0;width:%?750?%;z-index:30}',""]),t.exports=i},"8b42":function(t,i,e){"use strict";e.r(i);var a=e("3e45"),n=e.n(a);for(var s in a)"default"!==s&&function(t){e.d(i,t,(function(){return a[t]}))}(s);i["default"]=n.a},f5a6:function(t,i,e){"use strict";e.r(i);var a=e("4ee7"),n=e("8b42");for(var s in n)"default"!==s&&function(t){e.d(i,t,(function(){return n[t]}))}(s);e("64f7");var o,l=e("f0c5"),u=Object(l["a"])(n["default"],a["b"],a["c"],!1,null,"32fa67c9",null,!1,a["a"],o);i["default"]=u.exports}}]);