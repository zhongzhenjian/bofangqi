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

        //查询条件
        $where = [];

        //标题
        if(isset($req['title']) && null != $req['title'] && "" != $req['title'])
            $where['title'] = [ 'LIKE', "%{$req['title']}%"];
        //视频分类
        if(isset($req['class']) && null != $req['class'] && "" != $req['class'])
            $where['class'] = ['=', $req['class']];
        //是否有码
        if(isset($req['mosaic']) && null != $req['mosaic'] && "" != $req['mosaic'])
            $where['mosaic'] = ['=', $req['mosaic']];
        //地区
        if(isset($req['area']) && null != $req['area'] && "" != $req['area'])
            $where['area'] = ['=', $req['area']];
        //视频长短
        if(isset($req['duration']) && null != $req['duration'] && "" != $req['duration'])
            $where['duration'] = ['=', $req['duration']];

        //排序
        $order = [];
        if(isset($req['sort']) && null != $req['sort'] && "" != $req['sort'])
            $order[] = $req['sort'] . ' desc';

        //$res = Dvideo::with('labels')->where('title', 'like', '%' . $req['title'] . '%')->page($req['current'], $req['every'])->select();
        $res = Dvideo::with('labels')->where($where)->page($req['current'], $req['every'])->order($order)->select();
        $res ?$res = $res->toArray():'';
        $this->success('视频搜索结果',$res,200);
    }
}
