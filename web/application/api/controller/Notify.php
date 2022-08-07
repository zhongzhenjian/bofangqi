<?php


namespace app\api\controller;


use app\admin\model\Ext;
use app\common\controller\Api;
use app\common\model\Config;
use think\Request;
use think\Db;

use function GuzzleHttp\json_decode;

class Notify extends Api
{
    protected $noNeedLogin = ['*'];

    protected $config = ['domain' => 'http://154.64.2.29:88/', 'pay_memberid' => '220169932','md5Key' => '7310s4b9063zgxm38qnlb5zngsb27fhh', 'tjurl' => 'http://20.187.85.21/Pay_Index.html', 'pay_bankcode' => ['alipay_qr'=>'1037', 'alipay'=>'1034', 'wechat'=>'1035'] ];

    //会员卡回调
    public function card(Request $request)
    {
        $req = $request->post();

        // $temp = '{"memberid":"220169932","orderid":"2022011910250102","transaction_id":"20220119224446101481","amount":"50.0000","datetime":"20220119224707","returncode":"00","sign":"673919E19FB2D094E2F37644580AA1D6","attach":"198"}';
        // $req = json_decode($temp, true);

        $q_sign = $req['sign'] ?? '';
        if(isset($req['sign'])) unset($req['sign']);
        if(isset($req['attach'])) unset($req['attach']);
        $sign = $this->sign($req);
        if($sign != $q_sign){
            exit('sign error');
        }
        
        $find = \app\admin\model\Order::where('code', $req['orderid'])->find();//订单
        $user = \app\admin\model\User::where('id', $find['userid'])->find();//用户
        $card = \app\admin\model\Card::where('id', $find['cardid'])->find();//会员卡
        $arr = Config::where('name', 'like', '%' . 'integral' . '%')->column('value');

        // 启动事务
        Db::startTrans();
        try{

            //订单状态改变
            $res = \app\admin\model\Order::where('code', $req['orderid'])->update(['list' => 1, 'pay_time' => date('Y-m-d H:i:s')]);
            if ($res) {
                //上级代理返利
                $ext = Ext::where('user_id', $user['id'])->find();//推广
                if ($ext) {
                    $t_user = \app\admin\model\User::where('id', $ext['userid'])->find();
                    if ($t_user['agent'] == 1) {
                        //代理
                        $money = 0;
                        if ($t_user['integral'] < $arr[1] && $t_user['integral'] >= $arr[0]) {
                            //等级1
                            $money = $find['price'] * 0.15;
                        }
                        if ($t_user['integral'] < $arr[2] && $t_user['integral'] >= $arr[1]) {
                            //等级二
                            $money = $find['price'] * 0.25;

                        }
                        if ($t_user['integral'] >= $arr[2]) {
                            //等级三
                            $money = $find['price'] * 0.45;
                        }
                    } else {
                        //非代理
                    }
                    \app\admin\model\User::where('id', $ext['userid'])->setInc('money', $money);
                    Ext::where('user_id', $user['id'])->setInc('money', $money);//推广

                }
                //会员时间
                if ($user['vip_time'] > date('Y-m-d H:i:s')) {
                    //没到期时间
                    $time = strtotime($user['vip_time']) + ($card['time'] * 1 * 60 * 60 * 24);
                } else {
                    //到期时间
                    $time = ($card['time'] * 1 * 60 * 60 * 24) + time();
                }
                \app\admin\model\User::where('id', $find['userid'])->update(['vip_time' => date('Y-m-d H:i:s', $time)]);
            }
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            exit('error');
        }
        exit('ok');
        // $this->success('回调成功', '', 200);
    }

    public function agent(Request $request)
    {
        $req = $request->post();
        $find = \app\admin\model\Order::where('code', $req['order_id'])->find();//订单
        $user = \app\admin\model\User::where('id', $find['userid'])->find();//用户
        $arr = Config::where('name', 'like', '%' . 'integral' . '%')->column('value');

        //订单状态改变
        $res = \app\admin\model\Order::where('code', $req['order_id'])->update(['list' => 1, 'pay_time' => date('Y-m-d H:i:s')]);
        if ($res) {
            //上级代理返利
            $ext = Ext::where('user_id', $user['id'])->find();//推广
            if ($ext) {
                $t_user = \app\admin\model\User::where('id', $ext['userid'])->find();
                if ($t_user['agent'] == 1) {
                    //代理
                    $money = 0;
                    if ($t_user['integral'] < $arr[1] && $t_user['integral'] >= $arr[0]) {
                        //等级1
                        $money = $find['price'] * 0.15;
                    }
                    if ($t_user['integral'] < $arr[2] && $t_user['integral'] >= $arr[1]) {
                        //等级二
                        $money = $find['price'] * 0.25;

                    }
                    if ($t_user['integral'] >= $arr[2]) {
                        //等级三
                        $money = $find['price'] * 0.45;
                    }
                } else {
                    //非代理
                }
                \app\admin\model\User::where('id', $ext['userid'])->setInc('money', $money);
                Ext::where('user_id', $user['id'])->setInc('money', $money);//推广
            }
            \app\admin\model\User::where('id', $find['userid'])->update(['agent' => 1]);

        }
        $this->success('回调成功', '', 200);
    }

    public function recharge(Request $request)
    {
        $req = $request->post();

        // $temp = '{"memberid":"220169932","orderid":"2022011910250102","transaction_id":"20220119224446101481","amount":"50.0000","datetime":"20220119224707","returncode":"00","sign":"673919E19FB2D094E2F37644580AA1D6","attach":"198"}';
        // $req = json_decode($temp, true);

        $q_sign = $req['sign'] ?? '';
        if(isset($req['sign'])) unset($req['sign']);
        if(isset($req['attach'])) unset($req['attach']);
        $sign = $this->sign($req);
        if($sign != $q_sign){
            exit('sign error');
        }
        // var_dump($req,$sign,$q_sign);exit;
        // \think\log::write(json_encode($req), 'debug');
        
        $find = \app\admin\model\Order::where('code', $req['orderid'])->find();//订单
        $list = \app\admin\model\Paylist::where('id', $find['cardid'])->value('c_price');

        // 启动事务
        Db::startTrans();
        try{
            \app\admin\model\User::where('id', $find['userid'])->setInc('money', $list);
            \app\admin\model\Order::where('code', $req['orderid'])->update(['list' => 1, 'pay_time' => date('Y-m-d H:i:s')]);
            // 提交事务
            Db::commit();    
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            exit('error');
        }
        exit('ok');
    }

    public function sign($x_data = []){
        ksort($x_data);
        $md5str = "";
        foreach ($x_data as $key => $val) {
            $md5str .= $key . "=" . $val . "&";
        }
        $md5Key = $this->config['md5Key'];
        return strtoupper(md5($md5str . "key=" . $md5Key));
    }
}
