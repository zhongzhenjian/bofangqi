<?php


namespace app\api\controller;


use app\common\controller\Api;
use Think\Log;
use think\Request;

use function GuzzleHttp\json_decode;

class Order extends Api
{
    protected $noNeedLogin = ['*'];
    /*protected $config = ['domain' => 'http://154.64.2.29:88/', 'pay_memberid' => '220169932','md5Key' => '7310s4b9063zgxm38qnlb5zngsb27fhh', 'tjurl' => 'http://20.187.85.21/Pay_Index.html', 'pay_bankcode' => ['alipay_qr'=>'1037', 'alipay'=>'1034', 'wechat'=>'1035'] ];

    //购买会员卡
    public function add(Request $request)
    {
        $this->model = new \app\admin\model\Order();
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        }
        $user = $this->auth->getUser();
        $req = $request->post();
        // var_dump($req);exit;
        $req['userid'] = $user['id'];
        $req['code'] = $this->create_orderid();
        $postFields = array(
            "pay_memberid" => $this->config['pay_memberid'],
            "pay_orderid" => $req['code'],
            "pay_amount" => $req['price'],
            "pay_applydate" => date("Y-m-d H:i:s"),
            "pay_bankcode" => $this->config['pay_bankcode'][$req['pay_type']] ?? '1040',
            "pay_notifyurl" => $this->config['domain'] . 'api/notify/card',
            "pay_callbackurl" => $this->config['domain'] . '/h5/#/pages/mine/viphuiyuan?rs=1',
        );
        $postFields['pay_md5sign'] = $this->sign($postFields);
        $postFields['pay_attach'] = $req['userid'];
        $postFields['pay_productname'] = '用户开通会员';
        // var_dump(json_encode($postFields));exit;

        $res = $this->sendRequest($postFields, $this->config['tjurl']);

        // var_dump($res);exit;
        if ($res['status'] == 'success') {
            $req['out_trade_no'] = $res['out_trade_no'];//上游订单
            $order = $this->model->allowField(true)->save($req);
            if ($order) {
                $this->result('下单成功', $res, 200);
            }
        } else {
            $this->result('系统错误或网络错误', '', 100);
        }
    }*/

    //鸽子支付
    protected $config = ['domain' => 'http://154.31.62.15/', 'pay_memberid' => '220841354','md5Key' => 'esvm2yuak5vvc1zjcivc08fbxmevlp28', 'tjurl' => 'http://110.173.54.18/Pay_Index.html', 'pay_bankcode' => ['alipay_qr'=>'1077', 'alipay'=>'1077', 'wechat'=>'1077'] ];

    //购买会员卡
    public function add(Request $request)
    {
        $this->model = new \app\admin\model\Order();
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        }
        $user = $this->auth->getUser();
        $req = $request->post();
        // var_dump($req);exit;
        $req['userid'] = $user['id'];
        $req['code'] = $this->create_orderid();
        $postFields = array(
            "pay_memberid" => $this->config['pay_memberid'],
            "pay_orderid" => $req['code'],
            "pay_amount" => $req['price'],
            "pay_applydate" => date("Y-m-d H:i:s"),
            "pay_bankcode" => $this->config['pay_bankcode'][$req['pay_type']],
            "pay_notifyurl" => $this->config['domain'] . 'api/notify/card',
            "pay_callbackurl" => $this->config['domain'] . '/h5/#/pages/mine/viphuiyuan?rs=1',
        );
        $postFields['pay_md5sign'] = $this->sign($postFields);
        $postFields['pay_attach'] = $req['userid'];
        $postFields['pay_productname'] = '用户开通会员';
        // var_dump(json_encode($postFields));exit;

        Log::record("请求地址：" . $this->config['tjurl'], Log::INFO);
        Log::record("请求参数：" . json_encode($postFields), Log::INFO);
        $res = $this->sendRequest($postFields, $this->config['tjurl']);
        Log::record("返回内容：==========>" . json_encode($res), Log::INFO);

        // var_dump($res);exit;
        if ($res['status'] == 'success') {
            $req['out_trade_no'] = $res['out_trade_no'];//上游订单
            $order = $this->model->allowField(true)->save($req);
            if ($order) {
                $this->result('下单成功', $res, 200);
            }
        } else {
            $this->result($res['msg'], '', 100);
        }
    }


    //成为代理
    public function agent(Request $request)
    {
        $this->model = new \app\admin\model\Order();
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        }
        $user = $this->auth->getUser();
        $req = $request->post();
        $req['userid'] = $user['id'];
        $req['code'] = $this->create_orderid();
        $url = 'https://bufpay.com/api/pay/98112';
        $postFields = [];
        $postFields['name'] = '成为代理';
        $postFields['pay_type'] = $req['pay_type'];
        $postFields['price'] = $req['price'];
        $postFields['order_id'] = $req['code'];
        $postFields['order_uid'] = $req['userid'];
        $postFields['notify_url'] = config('host') . '/api/notify/agent';
        $postFields['return_url'] = '';
        $postFields['feedback_url '] = '';
        $postFields['secret'] = '6a2d15ad90394b4cb6a08b7a7e74aeee';
        $postFields['sign'] = $this->sign($postFields);
        $postFields['format'] = 'json';
        unset($postFields['secret']);
        $res = $this->sendRequest($postFields, $url);
        if ($res['status'] == 'ok') {
            $req['class'] = 1;
            $order = $this->model->allowField(true)->save($req);
            if ($order) {
                $this->result('下单成功', '', 200);
            }
        } else {
            $this->result('系统错误或网络错误', $res, 100);
        }
    }
    public function recharge(Request $request)
    {
        $this->model = new \app\admin\model\Order();
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        }
        $user = $this->auth->getUser();
        $req = $request->post();
        $find = \app\admin\model\Paylist::where('id',$req['list_id'])->find();
        if(!$find){
            $this->error('列表不存在','',100);
        }
        
        $req['userid'] = $user['id'];
        $req['cardid'] = $req['list_id'];
        $req['price'] = $find['price'];
        $req['code'] = $this->create_orderid();

        $postFields = array(
            "pay_memberid" => $this->config['pay_memberid'],
            "pay_orderid" => $req['code'],
            "pay_amount" => $find['price'],
            "pay_applydate" => date("Y-m-d H:i:s"),
            "pay_bankcode" => $this->config['pay_bankcode'][$req['pay_type']],
            "pay_notifyurl" => $this->config['domain'] . 'api/notify/recharge',
            "pay_callbackurl" => $this->config['domain'] . '/h5/#/pages/mine/chongzhi?rs=1',
        );
        $postFields['pay_md5sign'] = $this->sign($postFields);
        $postFields['pay_attach'] = $req['userid'];
        $postFields['pay_productname'] = '用户充值';
        // var_dump(json_encode($postFields));exit;

        $res = $this->sendRequest($postFields, $this->config['tjurl']);
        // $res = json_decode('{"status":"success","orderId":"E20220119195848920226","url":"http:\/\/47.104.66.82:6379\/showPay.html?params=2CC1042EA95D1E5CB7BF76802C320790C086F223A743F92A6AA8EF6EF013D504","out_trade_no":"20220119195906975610"}', true);
        // $res = json_decode('{"status":"error","orderId":"E20220119235621944077","msg":null,"out_trade_no":"20220119235640565510"}', true);

        // var_dump($res);exit;
        if ($res['status'] == 'success') {
            $req['out_trade_no'] = $res['out_trade_no'];//上游订单
            $order = $this->model->allowField(true)->save($req);
            if ($order) {
                $this->result('下单成功', $res, 200);
            }
        } else {
            $this->result('系统错误或网络错误', '', 100);
        }
    }

    //post请求

    protected function sendRequest($data, $url)
    {
        $headers = array('Content-Type: application/x-www-form-urlencoded');
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data)); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno' . curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        $arr = json_decode($result, true);
        return $arr;
    }


    private function sign2($data_arr)
    {
        return md5(join('', $data_arr));
    }

    //订单号
    public function create_orderid()
    {
        return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
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
