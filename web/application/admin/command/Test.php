<?php


namespace app\admin\command;


use app\admin\model\Ext;
use app\admin\model\Report as ReportModel;
use app\admin\model\Order as OrderModel;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;
use think\Log;

class Test extends Command
{
    // 配置定时器的信息
    protected function configure()
    {
        $this->setName('Test')
            ->setDescription('计算报表');
    }
    protected function execute(Input $input, Output $output)
    {
        Log::record("计算报表开始:" . date('Y-m-d H:i:s'), Log::INFO);
        // 定时器需要执行的内容

        $where['list'] = '1';//已支付
        $where['is_calc'] = '0';//未计算
        $where['agentlevel'] = array("like","%|%");//有上级
        $Order = new OrderModel();
        $data= $Order->where($where)->order('id', 'asc')->limit(50)->select();

        Log::record("订单数:" . count($data), Log::INFO);
        if(count($data) == 0)
        {
            Log::record("计算报表结束[无任务]:" . date('Y-m-d H:i:s'), Log::INFO);
            return;
        }

        foreach ($data as $key => $value) {
            // 启动事务
            Db::startTrans();
            try{
                Log::record("订单详情:" . $value, Log::INFO);

                $condition['id'] = $value['id'];
                $condition['list'] = '1';//已支付
                $condition['is_calc'] = '0';//未计算
                $condition['agentlevel'] = array("like","%|%");//有上级
                //订单状态改变
                $res = \app\admin\model\Order::where($condition)->update(['is_calc' => 1]);
                if ($res) {
                    //上级代理结算
                    $agents = explode('|',$value['agentlevel']);
                    $agents = array_filter($agents);
                    Log::record("代理数组:" . json_encode($agents), Log::INFO);
                    if(count($agents) != 3)
                    {
                        Log::record("代理层级不正确:" .$value['agentlevel'], Log::INFO);
                        // 回滚事务
                        Db::rollback();
                        continue;
                    }
                    //计算分成
                    $agent1 = \app\admin\model\Admin::get(array_shift($agents));
                    $agent2 = \app\admin\model\Admin::get(array_shift($agents));
                    $agent3 = \app\admin\model\Admin::get(array_shift($agents));

                    Log::record("代理1:" .$agent1['id'], Log::INFO);
                    Log::record("代理2:" .$agent2['id'], Log::INFO);
                    Log::record("代理3:" .$agent3['id'], Log::INFO);

                    $commission1 = 0;//一级代理总佣金
                    $commission2 = 0;//二级代理总佣金
                    $commission3 = 0;//三级代理总佣金
                    //提成1
                    if($agent1['commission'] > 0)
                    {
                        //最大提成是100%
                        $rate = $agent1['commission'];
                        if($rate > 100)
                            $rate = 100;

                        //一级代理总佣金
                        $totalAmt1 = $value['price'] * $rate / 100;

                        if($agent2['commission'] > 0)
                        {
                            //最大提成是100%
                            $rate = $agent2['commission'];
                            if($rate > 100)
                                $rate = 100;

                            //二级代理总佣金
                            $totalAmt2 = $totalAmt1  * $rate / 100;
                            //一级代理
                            $commission1 = $totalAmt1 - $totalAmt2;
                            //二级代理
                            $commission2 = $totalAmt2;

                            if($agent3['commission'] > 0)
                            {
                                //最大提成是100%
                                $rate = $agent3['commission'];
                                if($rate > 100)
                                    $rate = 100;

                                //三级代理总佣金
                                $totalAmt3 = $totalAmt2  * $rate / 100;

                                //三级代理
                                $commission3 = $totalAmt3;
                                //二级代理
                                $commission2 = $totalAmt2 - $totalAmt3;
                            }
                        }
                    }


                    Db::rollback();

                    /*$ext = Ext::where('user_id', $user['id'])->find();//推广
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
                    Db::commit();//提交事务
                    Log::record("会员卡回调，成功:" . $req['orderid'] , Log::INFO);
                    exit('ok');*/
                }
                else
                {
                    // 回滚事务
                    Db::rollback();
                    Log::record("支付订单结算失败" . $value['code'] , Log::INFO);
                    exit('订单处理失败');
                }
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                Log::record("支付订单结算报错" . $e , Log::INFO);
                exit('error');
            }

        }



        /*$url="";
        if(count($data)>0){
            $url=$data[0]['url'];
        }
        $this->unlock();

        // 筛选条件
        $where['workdate'] = array("between","$beginTime,$endTime");
        $where['type'] = $type;

        //判断登录用户类型
        $user = $this->auth->getUserinfo();
        if('admin' == $user['type']){

        }
        else
        {//非管理员只能查询自己下级
            $where['up_agent'] = $user['id'];
        }

        //用户名
        if(null != $username && '' != $username)
        {
            $where['username'] = $username;
        }
        //用户id
        if(null != $id && '' != $id)
        {
            $where['userid'] = $id;
        }

        $report = new ReportModel();
        $res = $report::where($where)
            ->field('workdate,userid,username,pay_amt,install,arpu,diff_amt,diff_amt_after,type')
            ->page($req['current'], $req['every'])
            ->order('workdate desc')
            ->select();*/

        // .....
        Log::record("计算报表结束:" . date('Y-m-d H:i:s'), Log::INFO);
    }
}