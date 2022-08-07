<?php


namespace app\api\controller;


use app\admin\model\Dvideo;
use app\admin\model\Video;
use app\common\controller\Api;
use think\Request;

class Sreach extends Api
{
    protected $noNeedLogin = ['*'];

    //社区搜索
    public function community(Request $request)
    {
        if ( ! $request->isGet()) {
            $this->error('ＭＳＴＡ　ＧＥＴ');
        }
        $req = $request->get();
        $res = Video::with('publisher')->where('tong', 1)->where('title', 'like', '%' . $req['title'] . '%')->page($req['current'], $req['every'])->select();
        $res ?$res = $res->toArray():'';
        $this->success('社区搜索结果',$res,200);
    }
    public function video(Request $request)
    {
        if ( ! $request->isGet()) {
            $this->error('ＭＳＴＡ　ＧＥＴ');
        }
        $req = $request->get();
        $res = Dvideo::with('labels')->where('title', 'like', '%' . $req['title'] . '%')->page($req['current'], $req['every'])->select();
        $res ?$res = $res->toArray():'';
        $this->success('视频搜索结果',$res,200);
    }
}
