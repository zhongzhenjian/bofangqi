<?php


namespace app\api\controller;


use app\common\controller\Api;
use think\Request;
use think\Db;
class Exchange extends Api
{
    protected $noNeedLogin = ['*'];

    public function add(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＤＯＮ＇Ｔ　ＧＥＴ');
        }
        $exchange = new \app\admin\model\Exchange();
        $req = $request->post();
        $user = $this->auth->getUserinfo();
        $find = $exchange->where('code', $req['code'])->find();
        if ( ! $find) {
            $this->error('兑换码不存在', '', 100);
        }
        if ($find['list'] == 1) {
            $this->error('兑换码已失效', '', 100);
        }
        $res = $exchange->where('code', $req['code'])->update(['list' => 1, 'userid' => $user['id']]);
        if ($res) {
            if ($find['class'] == 0) {
                //月卡
                $time = 30;
            }
            if ($find['class'] == 1) {
                //季度
                $time = 90;
            }
            if ($find['class'] == 2) {
                //半年
                $time = 180;
            }
            if ($find['class'] == 3) {
                //年卡
                $time = 360;
            }
            if ($user['vip_time'] > date('Y-m-d H:i:s')) {
                //没到期时间
                $time = strtotime($user['vip_time']) + ($time * 1 * 60 * 60 * 24);
            } else {
                //到期时间
                $time = ($time * 1 * 60 * 60 * 24) + time();
            }
            $res = db::table('fa_user')->where('id', $find['userid'])->update(['vip_time' => date('Y-m-d H:i:s', $time)]);
            if ($res) {
                $this->success('兑换失败', '', 300);
            } else {
                $this->success('兑换成功', '', 300);

            }
        }
    }

}
