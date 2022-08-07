<?php


namespace app\api\controller;


use app\common\controller\Api;
use app\common\model\Config;
use think\Request;
use app\admin\model\Withdrawal as Withs;

class Withdrawal extends Api
{
    protected $noNeedLogin = ['*'];

    public function add_drawal(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('请求方式不正确');
        }
        $user = $this->auth->getUser();
        $find = \app\admin\model\Bang::where(['class' => 1, 'fl' => 0, 'userid' => $user->id])->find();
        $find1 = \app\admin\model\Bang::where(['class' => 1, 'fl' => 1, 'userid' => $user->id])->find();
        if ( ! $find || ! $find1) {
            $this->error('支付宝和银行卡必须都绑定才可以提现', '', 100);
        }
        $req = $request->post();
        if($req['money'] ==0){
            $this->error('您的余额不可提现','',100);
        }
        $withs = new Withs();
        $res = $withs->allowField(true)->save(['userId' => $user->id, 'money' => $req['money']]);
        if ($res) {
            \app\admin\model\User::where('id', $user->id)->setDec('money', $req['money']);
            $this->success('审核成功，等待审核', '', 200);

        }

    }
}
