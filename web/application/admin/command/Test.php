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
        //echo "计算报表开始:" . date('Y-m-d H:i:s') . "\r\n";
        Log::record("计算报表开始:" . date('Y-m-d H:i:s'), Log::INFO);
        // 定时器需要执行的内容

        $where['list'] = '1';//已支付
        $where['is_calc'] = '0';//未计算
        $where['agentlevel'] = array("like","%|%");//有上级
        $Order = new OrderModel();
        $data= $Order->where($where)->order('code', 'asc')->limit(50)->select();

        Log::record("订单数:" . count($data), Log::INFO);
        //echo "待计算支付订单数:" . count($data) . "\r\n";
        if(count($data) == 0)
        {
            Log::record("计算报表结束[无任务]:" . date('Y-m-d H:i:s'), Log::INFO);
            //echo "计算报表结束[无任务]:" . date('Y-m-d H:i:s') . "\r\n";
            return;
        }
        foreach ($data as $key => $value) {
            // 启动事务
            Db::startTrans();
            try{
                Log::record("订单详情:" . $value, Log::INFO);
                //echo "订单详情:" . $value  . "\r\n";

                $condition['code'] = $value['code'];
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

                    Log::record("代理1:" .$agent1['id'].','.$agent1['username'] . ',分成比例:' . $agent1['commission'], Log::INFO);
                    Log::record("代理2:" .$agent2['id'].','.$agent2['username'] . ',分成比例:' . $agent2['commission'] , Log::INFO);
                    Log::record("代理3:" .$agent3['id'].','.$agent3['username'] . ',分成比例:' . $agent3['commission'], Log::INFO);

                    if($agent1['commission'] < $agent2['commission'] || $agent2['commission'] < $agent3['commission']
                        || $agent3['commission'] < 0 || $agent3['commission'] > 100 || $agent2['commission'] > 100 || $agent1['commission'] > 100)
                    {
                        Log::record("代理分成比例不正确" , Log::INFO);
                        Db::rollback();
                        continue;
                    }

                    //一级代理总佣金
                    $rate = $agent1['commission'];
                    $totalAmt1 = $value['price'] * $rate / 100;
                    //echo $agent1['type'] . "代理:" .$agent1['id'] . '(' . $agent1['username'] . ')' . ',分成比例:' . $rate . ',分成:' . $value['price'] . ' * ' . $rate . '/100 = ' . $totalAmt1 . "\r\n";
                    Log::record($agent1['type'] . "代理:" .$agent1['id'] . '(' . $agent1['username'] . ')' . ',分成比例:' . $rate . ',分成:' . $value['price'] . ' * ' . $rate . '/100 = ' . $totalAmt1, Log::INFO);

                    //二级代理总佣金
                    $rate = $agent2['commission'];
                    $totalAmt2 = $value['price']  * $rate / 100;
                    //echo $agent2['type'] . "代理:" .$agent2['id'] . '(' . $agent2['username'] . ')' . ',分成比例:' . $rate . ',分成:' . $value['price'] . ' * ' . $rate . '/100 = ' . $totalAmt2 . "\r\n";
                    Log::record($agent2['type'] . "代理:" .$agent2['id'] . '(' . $agent2['username'] . ')' . ',分成比例:' . $rate . ',分成:' . $value['price'] . ' * ' . $rate . '/100 = ' . $totalAmt2, Log::INFO);

                    //三级代理总佣金
                    $rate = $agent3['commission'];
                    $totalAmt3 = $value['price']  * $rate / 100;
                    //echo $agent3['type'] . "代理:" .$agent3['id'] . '(' . $agent3['username'] . ')' . ',分成比例:' . $rate . ',分成:' . $value['price'] . ' * ' . $rate . '/100 = ' . $totalAmt3 . "\r\n";
                    Log::record($agent3['type'] . "代理:" .$agent3['id'] . '(' . $agent3['username'] . ')' . ',分成比例:' . $rate . ',分成:' . $value['price'] . ' * ' . $rate . '/100 = ' . $totalAmt3, Log::INFO);

                    $commission3 = $totalAmt3;//三级代理总佣金
                    $commission2 = $totalAmt2 - $totalAmt3;//二级代理总佣金
                    $commission1 = $totalAmt1 - $totalAmt2;//一级代理总佣金

                    Log::record("代理1:" .$agent1['id'].','.$agent1['username'] . ',佣金:' . $commission1, Log::INFO);
                    Log::record("代理2:" .$agent2['id'].','.$agent2['username'] . ',佣金:' . $commission2 , Log::INFO);
                    Log::record("代理3:" .$agent3['id'].','.$agent3['username'] . ',佣金:' . $commission3, Log::INFO);

                    $report = new ReportModel();
                    //一级代理
                    $where1 = [];
                    $where1['userid'] = $agent1['id'];
                    $where1['workdate'] = $value['pay_date'];
                    $where1['type'] = 'H5';//暂时固定H5

                    $record1 = $report::where($where1)->find();
                    if(null == $record1)
                    {
                        $write1['userid'] = $agent1['id'];
                        $write1['workdate'] = $value['pay_date'];
                        $write1['type'] = 'H5';//暂时固定H5
                        $write1['username'] = $agent1['username'];
                        $write1['level'] = $agent1['level'];
                        $write1['pay_amt'] = $value['price'];
                        $write1['up_agent'] = $agent1['up_agent'];
                        $write1['user_type'] = $agent1['type'];
                        Log::record("1报表不存在:" . json_encode($where1), Log::INFO);
                        $ret1 = $report->insert($write1);
                    }
                    else
                    {
                        Log::record("1报表存在:" . json_encode($where) , Log::INFO);
                        $ret1 = $record1->setInc('pay_amt', $value['price']);
                    }
                    Log::record("ret1执行结果:" . $ret1 , Log::INFO);

                    //二级代理
                    $where2 = [];
                    $where2['userid'] = $agent2['id'];
                    $where2['workdate'] = $value['pay_date'];
                    $where2['type'] = 'H5';//暂时固定H5

                    $record2 = $report::where($where2)->find();
                    if(null == $record2)
                    {
                        Log::record("2报表不存在:" . json_encode($where2) , Log::INFO);
                        $write2['userid'] = $agent2['id'];
                        $write2['workdate'] = $value['pay_date'];
                        $write2['type'] = 'H5';//暂时固定H5
                        $write2['username'] = $agent2['username'];
                        $write2['level'] = $agent2['level'];
                        $write2['pay_amt'] = $value['price'];
                        $write2['up_agent'] = $agent2['up_agent'];
                        $write2['user_type'] = $agent2['type'];
                        $ret2 = $report->insert($write2);
                    }
                    else
                    {
                        Log::record("2报表存在:" . json_encode($where) , Log::INFO);
                        $ret2 = $record2->setInc('pay_amt', $value['price']);
                    }
                    Log::record("ret2执行结果:" . $ret2, Log::INFO);

                    //三级代理
                    $where3 = [];
                    $where3['userid'] = $agent3['id'];
                    $where3['workdate'] = $value['pay_date'];
                    $where3['type'] = 'H5';//暂时固定H5

                    $record3 = $report::where($where3)->find();
                    if(null == $record3)
                    {
                        Log::record("3报表不存在:" . json_encode($where3) , Log::INFO);
                        $write3['userid'] = $agent3['id'];
                        $write3['workdate'] = $value['pay_date'];
                        $write3['type'] = 'H5';//暂时固定H5
                        $write3['username'] = $agent3['username'];
                        $write3['level'] = $agent3['level'];
                        $write3['pay_amt'] = $value['price'];
                        $write3['up_agent'] = $agent3['up_agent'];
                        $write3['user_type'] = $agent3['type'];
                        $ret3 = $report->insert($write3);
                    }
                    else
                    {
                        Log::record("3报表存在:" . json_encode($where) , Log::INFO);
                        $ret3 = $record3->setInc('pay_amt', $value['price']);
                    }
                    Log::record("ret3执行结果:" . $ret3, Log::INFO);

                    if($ret1 && $ret2 && $ret3)
                    {
                        Db::commit();//提交事务
                        Log::record("支付订单结算成功" . $value['code'] , Log::INFO);
                        continue;
                    }
                    else
                    {
                        Db::rollback();
                        Log::record("支付订单结算失败1:" . $value['code'] , Log::INFO);
                        continue;
                    }
                }
                else
                {
                    // 回滚事务
                    Db::rollback();
                    Log::record("支付订单结算失败" . $value['code'] , Log::INFO);
                    echo "支付订单结算失败2:" . $value['code']  . "\r\n";
                    continue;
                }
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                Log::record("支付订单结算异常" . $e , Log::INFO);
                echo "支付订单结算报错" . $e . "\r\n";
                continue;
            }

        }

        Log::record("计算报表结束:" . date('Y-m-d H:i:s' . "\r\n\r\n"), Log::INFO);
    }
}