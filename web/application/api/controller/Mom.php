<?php


namespace app\api\controller;


use app\common\controller\Api;
use think\Request;
use\app\admin\model\Mom as Moms;

class Mom extends Api
{
    protected $noNeedLogin = ['*'];

    public function add(Request $request)
    {
        if ( ! $request->isGet()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＧＥＴ');
        }
        $req = $request->get();
        $req['ip'] = request()->ip();
        $address = $this->ip_address($req['ip']);
        $country=isset($_POST["country"])?$_POST["country"]:0;
        $req['address'] = $address['country'] . $address['regionName'] . $address['city'];
        //游客
        if ($req['class'] == 0) {
            $find = Moms::where(['class' => $req['class'], 'ip' => $req['ip']])->find();
            //存在
            if ($find) {
                $res = Moms::where(['class' => $req['class'], 'ip' => $req['ip']])->update(['create_time' => date('Y-m-d H:i:s'), 'address' => $req['address']]);
                Moms::where(['class' => $req['class'], 'ip' => $req['ip']])->setInc('num', 1);
            } else {
                $moms = new Moms();
                $req['num'] = 1;
                $res = $moms->save($req);
            }
        } else {
            $find = Moms::where(['class' => $req['class'], 'userid' => $req['userid']])->find();
            //存在
            if ($find) {
                $res = Moms::where(['class' => $req['class'], 'userid' => $req['userid']])->update(['create_time' => date('Y-m-d H:i:s'), 'address' => $req['address']]);
                Moms::where(['class' => $req['class'], 'userid' => $req['userid']])->setInc('num', 1);
            } else {
                $moms = new Moms();
                $req['num'] = 1;
                $res = $moms->save($req);
            }
        }
        if ($res) {
            $this->success('监视成功', '', 200);
        }
    }

    //地址接口
    public function ip_address($ip)
    {
        $durl = 'http://ip-api.com/json/' . $ip . '?lang=zh-CN';
        // 初始化
        $curl = curl_init();
        // 设置url路径
        curl_setopt($curl, CURLOPT_URL, $durl);
        // 将 curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
        // 执行
        $data = curl_exec($curl);
        // 关闭连接
        curl_close($curl);
        // 返回数据
        return json_decode($data, true);
    }

}
