<?php


namespace app\api\controller;


use app\common\controller\Api;
use think\Request;

class Feedback extends Api
{
    protected $noNeedLogin = ['*'];

    public function add(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＤＯＮ＇Ｔ　ＧＥＴ');
        }
        $req = $request->post();
        $user = $this->auth->getUserinfo();
        $req['userid'] = $user['id'];
        $feedback = new \app\admin\model\Feedback();
        $res = $feedback->save($req);
        if ($res) {
            $this->success('ok', '', 200);
        } else {
            $this->success('error', '', 100);
        }
    }
}
