<?php


namespace app\api\controller;


use app\common\controller\Api;

class Belong extends Api
{
    protected $noNeedLogin = ['*'];

    //所属
    public function index()
    {
        $res = \app\admin\model\Belong::all()->toArray();
        $this->result('所属', $res, 200);
    }

    public function detail()
    {
        $req = $this->request->post();
        $res = \app\admin\model\Belong::where('id', $req['id'])->find();
        $video = \app\admin\model\Dvideo::where('belong', $req['id'])->page($req['current'], $req['every'])->select()->toArray();
        $video ?? '';
        $res['video'] = $video;
        $res['count'] = \app\admin\model\Dvideo::where('belong', $req['id'])->count();
        $this->result('所属详情', $res, 200);
    }
}
