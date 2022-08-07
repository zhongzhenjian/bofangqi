<?php

use think\Route;

//直播关注列表
Route::post('follow', 'api/follow/index');
//关注添加
Route::post('follow/add', 'api/follow/create');
//取消关注
Route::delete('follow/del/:id', 'api/follow/delete');

//直播间详情
Route::get('direct/read/:id', 'api/direct/read');

//主播详情
Route::get('anchor/read/:id', 'api/anchor/read');
//直播间文案
Route::get('direct/copywriting', 'api/direct/copywriting');
//直播的真爱守护
Route::post('direct/vip', 'api/vip/index');
//直播的贵宾
Route::post('direct/guard', 'api/vip/create');
//直播的游戏广告
Route::get('direct/app', 'api/directapp/index');
//直播的顶部广告
Route::get('direct/adv', 'api/directapp/create');
//直播的底部广告
Route::get('direct/dadv', 'api/directapp/save');
//直播礼物列表
Route::get('direct/gifts', 'api/gifts/index');
//直播轮播图
Route::get('direct/banner', 'api/Banner/index');
//直播间计划任务（热度 在线人数）
Route::get('direct/heatonline', 'api/direct/edit');
//充值列表
Route::get('pay/list', 'api/paylist/index');
//购买礼物
Route::post('gift/buy/:price', 'api/gifts/create');
//在线人数加减
Route::put('direct/room/:id','api/direct/update');
//客服连接
Route::get('chat','api/Chat/index');
//