<?php


namespace app\api\controller;


use app\common\controller\Api;
use think\Request;
use\app\admin\model\Mom as Moms;

class Mom extends Api
{
    protected $noNeedLogin = ['*'];//无需登录的方法,同时也就不需要鉴权了
    protected $noNeedRight = ['add'];//无需鉴权的方法,但需要登录

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
        $date = date('Y-m-d');
        $req['login_date'] = $date;

        //先判断登录用户类型
        $user = $this->auth->getUserinfo();

        // 筛选条件
        $where = [];

        $where['userid'] = $user['id'];
        $where['login_date'] = $date;

        if(!$user['mobile'])
        {//游客
            $find = Moms::where($where)->find();
            //存在
            if ($find) {
                $res = Moms::where($where)->update(['create_time' => date('Y-m-d H:i:s'), 'address' => $req['address'], 'class' => '0']);
                Moms::where(['class' => $req['class'], 'ip' => $req['ip']])->setInc('num', 1);
            } else {
                $moms = new Moms();
                $req['num'] = 1;
                $req['class'] = 0;//游客
                $res = $moms->save($req);
            }
        }
        else
        {//会员
            if(null == $user['vip_time'] || '' == $user['vip_time'] || '0000-00-00 00:00:00' == $user['vip_time'])
            {
                $find = Moms::where($where)->find();
                //存在
                if ($find) {
                    $res = Moms::where($where)->update(['create_time' => date('Y-m-d H:i:s'), 'address' => $req['address'], 'class' => '1']);
                    Moms::where(['class' => $req['class'], 'ip' => $req['ip']])->setInc('num', 1);
                } else {
                    $moms = new Moms();
                    $req['num'] = 2;
                    $req['class'] = 1;//会员
                    $res = $moms->save($req);
                }
            }
            else if($user['vip_time'] > date('Y-m-d H:i:s'))
            {//VIP
                $find = Moms::where($where)->find();
                //存在
                if ($find) {
                    $res = Moms::where($where)->update(['create_time' => date('Y-m-d H:i:s'), 'address' => $req['address'], 'class' => '2']);
                    Moms::where(['class' => $req['class'], 'ip' => $req['ip']])->setInc('num', 1);
                } else {
                    $moms = new Moms();
                    $req['num'] = 2;
                    $req['class'] = 2;//VIP
                    $res = $moms->save($req);
                }
            }
            else
            {//过期VIP
                $find = Moms::where($where)->find();
                //存在
                if ($find) {
                    $res = Moms::where($where)->update(['create_time' => date('Y-m-d H:i:s'), 'address' => $req['address'], 'class' => '3']);
                    Moms::where(['class' => $req['class'], 'ip' => $req['ip']])->setInc('num', 1);
                } else {
                    $moms = new Moms();
                    $req['num'] = 2;
                    $req['class'] = 3;//过期VIP
                    $res = $moms->save($req);
                }
            }
        }

        /*if ( ! $request->isGet()) {
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
        }*/

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
