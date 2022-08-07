<?php


namespace app\api\controller;


use app\common\controller\Api;
use think\Request;

class Leave extends Api
{
    protected $noNeedLogin = ['*'];

    //用户留言
    public function add(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＤＯＮ＇Ｔ　ＧＥＴ');
        }
        $req = $request->post();
        $user = $this->auth->getUserinfo();
        $req['userid'] = $user['id'];
        $req['ip'] = $request->ip();
        $leave = new \app\admin\model\Leave();
        $res = $leave->save($req);
        if ($res) {
            $this->success('留言成功', '', 200);
        } else {
            $this->error('系统错误', '', 100);
        }
    }

    //留言显示
    public function index(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＤＯＮ＇Ｔ　ＧＥＴ');
        }
        $req = $request->post();
        $user = $this->auth->getUserinfo();
        $leave = new \app\admin\model\Leave();
        $res = $leave->with('returns')->select();
        $res ? $res->toArray() : '';
        if ($res) {
            $this->success('留言显示', $res, 200);
        } else {
            $this->error('系统错误', '', 100);
        }
    }
}
