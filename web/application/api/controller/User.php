<?php

namespace app\api\controller;

use app\admin\model\Ext;
use app\admin\model\Relationship;
use app\admin\model\Video;
use app\common\controller\Api;
use app\common\library\Ems;
use app\common\library\Sms;
use app\common\model\Config;
use fast\Random;
use think\Cache;
use think\Request;
use think\Validate;
use app\admin\model\User as Usermodel;
use app\admin\model\Admin as AdminModel;
use think\Db;

/**
 * 会员接口
 */
class User extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 会员中心
     */
    public function index()
    {
        $this->success('', ['welcome' => $this->auth->nickname]);
    }

    /**
     * 会员登录
     *
     * @param string $account 账号
     * @param string $password 密码
     */
    public function login()
    {
        $mobile = $this->request->request('mobile');
        $password = $this->request->request('password');
        if ( ! $mobile || ! $password) {
            $this->error(__('Invalid parameters'));
        }
        $ret = $this->auth->login($mobile, $password);
        if ($ret) {
            $data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success(__('Logged in successful'), $data, 200);
        } else {
            $this->error($this->auth->getError());
        }
    }

//    //短信发送
//    public function sendMsm()
//    {
//        $code =mt_rand(10000,99999);
//        $url = "http://intapi.253.com/send/json";
//        //headers数组内的格式
//
//        // 参数
//        $data['msg'] = $code.'is your code to register your account. Don\'t reply to this message with your code.';
//        $data['mobile'] = input('mobile');
//        $data['account'] = 'I2732666';
//        $data['password'] = '0851Xlr7v393f3';
//        $res = $this->curlPost($url,$data);
//        if(json_decode($res,true)['code']=='0'){
//            return $code;
//        };
//    }
//    private function curlPost($url, $postFields)
//    {
//
//        $postFields = json_encode($postFields);
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//                'Content-Type: application/json; charset=utf-8'
//            )
//        );
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
//        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//        $ret = curl_exec($ch);
//        if (false == $ret) {
//            $result = curl_error($ch);
//        } else {
//            $rsp = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//            if (200 !== $rsp) {
//                $result = "请求状态 " . $rsp . " " . curl_error($ch);
//            } else {
//                $result = $ret;
//            }
//        }
//        curl_close($ch);
//        return $result;
//    }
    public function sendMsm()
    {
        $code = mt_rand(1000, 9999);
         $send =send_sms(input('mobile'),  1, ['code'=>$code]);
            if($send['Message'] != 'OK'){
                echo '发送失败';
            }else{
                return $code;
            }
        
        // $code = mt_rand(1000, 9999);
        // $url = 'https://106.ihuyi.com/webservice/sms.php?method=Submit';
        // $data['mobile'] = input('mobile');
        // $data['content'] = '您的验证码是：' . $code . '。请不要把验证码泄露给其他人。';
        // $data['account'] = 'C51625091';
        // $data['password'] = 'f78be9de8659c46756a97f36a22320d3';
        // $data['format'] = 'json';
        // $res = $this->post($url, $data);
        // return $code;

    }

    /**
     * 发送短信
     */
    public function post($url, $data, $proxy = null, $timeout = 20)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); //在HTTP请求中包含一个"User-Agent: "头的字符串。
        curl_setopt($curl, CURLOPT_HEADER, 0); //启用时会将头文件的信息作为数据流输出。
        curl_setopt($curl, CURLOPT_POST, true); //发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);//Post提交的数据包
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); //启用时会将服务器服务器返回的"Location: "放在header中递归的返回给服务器，使用CURLOPT_MAXREDIRS可以限定递归返回的数量。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //文件流形式
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout); //设置cURL允许执行的最长秒数。
        $content = curl_exec($curl);
        curl_close($curl);
        unset($curl);
        return $content;
    }

    /**
     * 注册会员
     *
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $email 邮箱
     * @param string $mobile 手机号
     * @param string $code 验证码
     */
    public function register()
    {
        $chang = Config::where('name', 'zcc')->value('value');
        $duan = Config::where('name', 'tvideo')->value('value');
        $username = 'Rose_' . mt_rand(10000, 99999999);
        $password = $this->request->request('password');
        $mobile = $this->request->request('mobile');
        $t_number = $this->request->request('t_number');
        $avatars = array("1_1588736866.jpg", "2_1588736906.jpg", "3_1588736916.jpg", "4_1588736927.jpg", "5_1588736939.jpg", "7_1588737044.jpg", "8_1588737058.jpg", "10_1588737071.jpg", "11_1588737096.jpg", "12_1588737120.jpg", "13_1588737130.jpg", "14_1588737138.jpg", "15_1588737244.jpg", "16_1588737259.jpg", "17_1588737267.jpg", "18_1588737279.jpg", "19_1588737290.jpg", "20_1588737303.jpg", "21_1588740537.jpg", "22_1588740556.jpg", "23_1588740572.jpg", "24_1588740586.jpg", "26_1588741401.jpg", "27_1588741443.jpg", "28_1588741455.jpg", "29_1588741475.jpg", "31_1588741495.jpg", "32_1588741508.jpg", "33_1588741526.jpg", "34_1588741536.jpg", "35_1588741549.jpg", "36_1588741559.jpg", "37_1588741571.jpg", "38_1588741586.jpg", "39_1588741596.jpg", "40_1588741605.jpg", "41_1588741614.jpg", "42_1588741624.jpg", "43_1588741635.jpg", "44_1588741645.jpg", "45_1588741657.jpg", "46_1588741666.jpg", "47_1588741676.jpg", "48_1588741687.jpg", "49_1588741697.jpg", "50_1588741707.jpg");
        $avatar = $avatars[array_rand($avatars)];
        $numeber = $this->creatInvCode();
        $photo = Code::c_qrcode('http://www.baidu.com', time());
        $extends = [
            'number' => $numeber,
            'avatar' => '/mrtx/' . $avatar,
            'photo' => $photo,
            'num' => $chang,
            'num_t' => $duan
        ];
        if ( ! $username || ! $password) {
            $this->error(__('Invalid parameters'));
        }
        if ($mobile && ! Validate::regex($mobile, "^1\d{10}$")) {
            $this->error(__('Mobile is incorrect'));
        }
        $agentLevel = '';
        if (null !== $t_number && !empty($t_number)) {
            $agent = AdminModel::get($t_number);
            if(!$agent || $agent['type'] != 'agent3')
                $this->error('推广码不存在');

            $agentLevel = $agent['level'] . '|' . $agent['id'] . '|';
        }

        $ret = $this->auth->register($username, $password, '', $mobile, $extends,$agentLevel);
        if ($ret) {
            $data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success(__('Sign up successful'), $data, 200);
        } else {
            $this->error($this->auth->getError());
        }
    }//推广码

    /**
     * 设备码注册
     *
     * @param string $deviceCode 设备码
     */
    public function deviceRegister()
    {
        $chang = Config::where('name', 'zcc')->value('value');
        $duan = Config::where('name', 'tvideo')->value('value');
        $username = 'Rose_' . mt_rand(10000, 99999999);
        $password = '123456';
        $mobile = '';
        $t_number = $this->request->request('t_number');
        $deviceCode = $this->request->request('deviceCode');

        $avatars = array("1_1588736866.jpg", "2_1588736906.jpg", "3_1588736916.jpg", "4_1588736927.jpg", "5_1588736939.jpg", "7_1588737044.jpg", "8_1588737058.jpg", "10_1588737071.jpg", "11_1588737096.jpg", "12_1588737120.jpg", "13_1588737130.jpg", "14_1588737138.jpg", "15_1588737244.jpg", "16_1588737259.jpg", "17_1588737267.jpg", "18_1588737279.jpg", "19_1588737290.jpg", "20_1588737303.jpg", "21_1588740537.jpg", "22_1588740556.jpg", "23_1588740572.jpg", "24_1588740586.jpg", "26_1588741401.jpg", "27_1588741443.jpg", "28_1588741455.jpg", "29_1588741475.jpg", "31_1588741495.jpg", "32_1588741508.jpg", "33_1588741526.jpg", "34_1588741536.jpg", "35_1588741549.jpg", "36_1588741559.jpg", "37_1588741571.jpg", "38_1588741586.jpg", "39_1588741596.jpg", "40_1588741605.jpg", "41_1588741614.jpg", "42_1588741624.jpg", "43_1588741635.jpg", "44_1588741645.jpg", "45_1588741657.jpg", "46_1588741666.jpg", "47_1588741676.jpg", "48_1588741687.jpg", "49_1588741697.jpg", "50_1588741707.jpg");
        $avatar = $avatars[array_rand($avatars)];
        $numeber = $this->creatInvCode();
        $photo = Code::c_qrcode('http://www.baidu.com', time());
        $extends = [
            'number' => $numeber,
            'avatar' => '/mrtx/' . $avatar,
            'photo' => $photo,
            'num' => $chang,
            'num_t' => $duan
        ];
        if ( ! $username || ! $password || !$deviceCode || strlen($deviceCode) < 10 ) {
            $this->error(__('Invalid parameters'));
        }
        /*if ($mobile && ! Validate::regex($mobile, "^1\d{10}$")) {
            $this->error(__('Mobile is incorrect'));
        }*/
        $agentLevel = '';
        if (null !== $t_number && !empty($t_number)) {
            $agent = AdminModel::get($t_number);
            if(!$agent || $agent['type'] != 'agent3')
                $this->error('推广码不存在');

            $agentLevel = $agent['level'] . '|' . $agent['id'] . '|';
        }

        $ret = $this->auth->register($username, $password, '', $mobile, $extends,$agentLevel,$deviceCode);
        if ($ret) {
            $data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success('设备码注册成功', $data, 200);
        } else {
            //如果是设备码已存在，返回用户信息
            if($this->auth->getError() == '设备码已经存在')
            {
                $this->deviceLogin($deviceCode);
            }
            else
            {
                $this->error($this->auth->getError());
            }
        }
    }

    /**
     * 设备码登录
     *
     */
    public function deviceLogin($deviceCode)
    {
        $model = new Usermodel();
        $find = $model->where('devicecode', $deviceCode)->find();

        $this->auth->login($find['id'], '123456', false);

        $data = ['userinfo' => $this->auth->getUserinfo()];
        $this->success(__('设备码登录成功'), $data, 200);
    }

    public function creatInvCode()
    {
        $code = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";     //随机生成邀请码
        $arr = [];
        for ($i = 0; $i < 6; $i++) {
            $arr[$i] = $code[mt_rand(0, 35)];
        }
        $code = implode('', $arr);
        $number = usermodel::where('number', $code)->find();
        if ($number) {
            $code = $this->creatInvCode();
        }
        return $code;
    }

    public function creatInvCode1()
    {
        $code = "1234567890";           
        $arr = [];
        for ($i = 0; $i < 6; $i++) {
            $arr[$i] = $code[mt_rand(0, 9)];
        }
        $code = implode('', $arr);
        $number = usermodel::where('number', $code)->find();
        if ($number) {
            $code = $this->creatInvCode();
        }
        return $code;
    }

    /**
     * 修改会员个人信息
     *
     * @param string $avatar 头像地址
     * @param string $username 用户名
     * @param string $nickname 昵称
     * @param string $bio 个人简介
     */
    public function profile()
    {
        $user = $this->auth->getUser();
        $username = $this->request->request('username');
        $avatar = $this->request->request('avatar', '', 'trim,strip_tags,htmlspecialchars');
        if ($username) {
            $exists = \app\common\model\User::where('username', $username)->where('id', '<>', $this->auth->id)->find();
            if ($exists) {
                $this->error(__('Username already exists'));
            }
            $user->username = $username;
        }
        $user->avatar = $avatar;
        $res = $user->save();
        if ($res) {
            $res = Task::upload($user->id, 3);
            if ($res) {
                $this->success();
            }
        } else {
            $this->error('修改失败或网络错误', '', 100);

        }
    }

    //个人信息
    public function personal()
    {
        $user = $this->auth->getUserinfo();
        $user = Usermodel::where('id', $user['id'])->find();
        $user['photo'] = Video::where(['user_id' => $user['id'], 'tong' => 1, 'class' => '2'])->count();
        $user['video'] = Video::where(['user_id' => $user['id'], 'tong' => 1, 'class' => '1'])->count();
        $user['fabu'] = Video::where(['user_id' => $user['id'], 'tong' => 1, 'status' => 0])->count();
        $arr = Config::where('name', 'like', '%' . 'integral' . '%')->column('value');
        if ($user['integral'] < $arr[1] && $user['integral'] >= $arr[0]) {
            $user['vip'] = 0;
        }
        if ($user['integral'] < $arr[2] && $user['integral'] >= $arr[1]) {
            $user['vip'] = 1;
        }
        if ($user['integral'] >= $arr[2]) {
            $user['vip'] = 2;
        }
        $this->success('个人信息', $user, 200);
    }

    /**
     * 重置密码
     *
     * @param string $mobile 手机号
     * @param string $newpassword 新密码
     * @param string $captcha 验证码
     */
    public function resetpwd()
    {
        $mobile = $this->request->request("mobile");
        $newpassword = $this->request->request("newpassword");
        if ( ! Validate::regex($mobile, "^1\d{10}$")) {
            $this->error(__('Mobile is incorrect'));
        }
        $user = \app\common\model\User::getByMobile($mobile);
        if ( ! $user) {
            $this->error(__('User not found'));
        }//模拟一次登录
        $this->auth->direct($user->id);
        $ret = $this->auth->changepwd($newpassword, '', true);
        if ($ret) {
            $this->success(__('Reset password successful'));
        } else {
            $this->error($this->auth->getError());
        }
    }

    //二维码
    public function qrcode()
    {
        $user = $this->auth->getUserinfo();
        $find = Usermodel::where('id', $user['id'])->field('avatar,photo,number')->find();
        $this->success('推广码', $find, 200);
    }

    //个人信息修改
    public function edit(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＯＰＴＩＯＮ　ＩＳ　ＮＯＴ');
        }
        $user = $this->auth->getUser();
        $find = Usermodel::get($user->id)->toArray();
        if ( ! $find) {
            $this->error('ＮＯ　ＯＮＥ');
        }
        $req = $request->post();
        $users = new Usermodel();
        $res = $users->save($req, ['id' => $user->id]);
        if ($res) {
            $this->success('修改成功', '', 200);
        } else {
            $this->error('系统错误', '', 100);
        }
    }

    //推广返利 暂时不需要，统一走渠道后台
    public function tg($t_number, $userid)
    {
        $t_user = Usermodel::where('number', $t_number)->find();
        if ($t_user) {
            $new = new Ext();
            $find = $new->where(['userid' => $t_user['id'], 'user_id' => $userid])->find();
            if ( ! $find) {
                $arr = Config::where('name', 'like', '%' . 'integral' . '%')->column('value');
                $agent = Config::where('name', 'like', '%' . 'rebate' . '%')->column('value');
                $money = 0;
                if ($t_user['integral'] < $arr[1] && $t_user['integral'] >= $arr[0]) {
                    //等级1
                    if ($t_user['agent'] == 0) {
                        //非代理
                        $money = $agent['0'];
                    } else {
                        //代理
                    }
                }
                if ($t_user['integral'] < $arr[2] && $t_user['integral'] >= $arr[1]) {
                    //等级二
                    if ($t_user['agent'] == 0) {
                        //非代理
                        $money = $agent['1'];
                    } else {
                        //代理
                    }

                }
                if ($t_user['integral'] >= $arr[2]) {
                    //等级三
                    if ($t_user['agent'] == 0) {
                        //非代理
                        $money = $agent['2'];
                    } else {
                        //代理
                    }
                }
                if ($t_user['integral'] < $arr[0]) {
                    //没等级
                    if ($t_user['vip_time'] > date('Y-m-d H:i:s')) {
                        //没到期时间
                        $time = strtotime($t_user['vip_time']) + (3 * 1 * 60 * 60 * 24);
                    } else {
                        //到期时间
                        $time = (3 * 1 * 60 * 60 * 24) + time();
                    }
                    Usermodel::where('number', $t_number)->update(['vip_time' => date('Y-m-d H:i:s', $time)]);
                }
                Usermodel::where('number', $t_number)->setInc('money', $money);
                $new->save(['userid' => $t_user['id'], 'user_id' => $userid, 'cretae_time' => date('Y-m-d H:i:s'), 'money' => $money]);
            } else {
                $this->error('邀请码已用过', '', 100);
            }
        } else {
            $this->error('邀请码不正确', '', 100);
        }
    }

    //我的余额
    public function money()
    {
        $res = $this->auth->getUserinfo();
        $this->result('余额', $res['money'], 200);
    }

    public function blindMobile(Request $request)
    {
        $mobile = $request->post("mobile");

        if ( ! Validate::regex($mobile, "^1\d{10}$")) {
            $this->error(__('Mobile is incorrect') . ':' . $mobile);
        }

        $ret = $this->auth->changeMobile($mobile);
        if ($ret) {
            $this->success('成功绑定号码', null, 200);
        } else {
            $this->error($this->auth->getError());
        }
    }

}
