<?php


namespace app\api\controller;


use app\common\controller\Api;
use think\Request;
use app\admin\model\Bang as Bangs;

class Bang extends Api
{
    protected $noNeedLogin = ['*'];

    //绑定支付宝
    public function zhb(Request $request)
    {
        $user = $this->auth->getUser();
        $req = $request->post();
        $bang = new Bangs();
        $find = $bang->where(['fl' => 0, 'userid' => $user->id])->find();
        if ($find&&$find['class'] == 0) {
            $this->error('审核中', '', 100);
        }
        if ($find['class'] == 1) {
            $this->error('审核已通过请，勿在申请！', '', 500);
        }
        if ($find['class'] == 2) {
            $res = $bang->where(['fl' => 0, 'userid' => $user->id])->update(['class' => 0, 'zfb' => $req['zfb']]);
        }
        if ( ! $find) {
            $res = $bang->save(['userid' => $user->id, 'zfb' => $req['zfb'], 'fl' => 0, 'class' => 0]);
        }
        if ($res) {
            $this->success('绑定成功等待审核', '', 200);
        } else {
            $this->error('网络错误', '', 100);
        }
    }

    //绑定英航卡
    public function bank(Request $request)
    {
        $user = $this->auth->getUser();
        $req = $request->post();
        $bang = new Bangs();
        $find = $bang->where(['fl' => 1, 'userid' => $user->id])->find();
        if ($find&&$find['class'] == 0) {
            $this->error('审核中', '', 100);
        }
        if ($find['class'] == 1) {
            $this->error('审核已通过请，勿在申请!', '', 500);
        }
        if ($find['class'] == 2) {
            $res = $bang->where(['fl' => 1, 'userid' => $user->id])->update(['class' => 0, 'bandcard' => $req['bandcard'], 'khh' => $req['khh'], 'name' => $req['name']]);
        }
        if ( ! $find) {
            $res = $bang->save(['userid' => $user->id, 'bandcard' => $req['bandcard'], 'khh' => $req['khh'], 'name' => $req['name'], 'fl' => 1, 'class' => 0]);
        }
        if ($res) {
            $this->success('绑定成功等待审核', '', 200);
        } else {
            $this->error('网络错误', '', 100);
        }
    }
}
