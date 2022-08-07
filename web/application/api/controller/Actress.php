<?php


namespace app\api\controller;


use app\admin\model\Dvideo as Videos;
use app\admin\model\Video;
use app\common\controller\Api;

class Actress extends Api
{
    protected $noNeedLogin = ['*'];

    public function index()
    {
        $res = \app\admin\model\Actress::all()->toArray();
        halt($res);
    }
    //详情
    public function datuial()
    {
        $req = $this->request->post();
        $res = \app\admin\model\Actress::find($req['id'])->toArray();
        $res['videocount'] = Videos::where('actress', $res['id'])->count();
        $res['videos'] = Videos::with(['subordinate', 'labels'])->where('actress', $res['id'])->page($req['current'], $req['every'])->select()->toArray();
        $this->result('详情',$res,200);
    }
}
