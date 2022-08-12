<?php

namespace app\api\controller;

use app\admin\model\Report as ReportModel;
use app\admin\model\Admin as AdminModel;
use app\admin\model\AuthGroupAccess as AuthGroupAccessModel;
use app\admin\model\Ext;
use app\admin\model\Relationship;
use app\admin\model\Thumbs;
use app\admin\model\Video;
use app\common\controller\Api;
use app\common\library\Ems;
use app\common\library\Sms;
use app\common\model\Config;
use fast\Random;
use think\Cache;
use think\db\Query;
use think\Request;
use think\Validate;
use app\admin\model\User as Usermodel;
use think\Db;

/**
 * 渠道接口
 */
class Channel extends Api
{
    protected $noNeedLogin = ['login'];//无需登录的方法,同时也就不需要鉴权了
    protected $noNeedRight = '*';//无需鉴权的方法,但需要登录

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 登录
     *
     * @param string $account 账号
     * @param string $password 密码
     */
    public function login()
    {
        $username = $this->request->request('username');
        $password = $this->request->request('password');
        if ( ! $username || ! $password) {
            $this->error(__('Invalid parameters'));
        }
        $ret = $this->auth->ChannelLogin($username, $password);
        if ($ret) {

            $userinfo['id'] = $this->auth->getUserinfo()['id'];
            $userinfo['username'] = $this->auth->getUserinfo()['username'];
            $userinfo['nickname'] = $this->auth->getUserinfo()['nickname'];
            $userinfo['token'] = $this->auth->getUserinfo()['token'];
            $userinfo['type'] = $this->auth->getUserinfo()['type'];

            $data = ['userinfo' => $userinfo];

            //$data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success(__('Logged in successful'), $data, 200);
        } else {
            $this->error($this->auth->getError());
        }
    }

    /**
     * 首页数据
     *
     */
    public function homePage(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        }

        //先判断登录用户类型
        $user = $this->auth->getUserinfo();

        $today = date('Y-m-d');
        $yesterday = date('Y-m-d',strtotime('-1 day'));

        $ret = [];
        $report = new ReportModel();
        if('admin' == $user['type'] )
        {//管理员
            //今天数据
            $result = $report->Query("select type,sum(pay_amt) AS amt from fa_report where time = '$today' group by type" );
            $item = [];
            foreach ($result as $k => $v)
            {
                $item[$v['type']] = $v['amt'];
            }
            $ret['today'] = $item;
            //昨天数据
            $result = $report->Query("select type,sum(pay_amt) AS amt from fa_report where time = '$yesterday' group by type" );
            $item = [];
            foreach ($result as $k => $v)
            {
                $item[$v['type']] = $v['amt'];
            }
            $ret['yesterday'] = $item;
            //历史数据
            $result = $report->Query("select type,sum(pay_amt) AS amt from fa_report group by type" );
            $item = [];
            foreach ($result as $k => $v)
            {
                $item[$v['type']] = $v['amt'];
            }
            $ret['history'] = $item;
            $ret['userId'] = $user['id'];
            $ret['userName'] = $user['username'];
            $ret['type'] = $user['type'];
            $this->result('首页', $ret, 200);

        }
        else if('agent1' == $user['type'] || 'agent2' == $user['type'] || 'agent3' == $user['type'])
        {//1~3级代理
            $userId = '|' . $user['id'] . '|';
            //今天数据
            $sql = "select type,sum(pay_amt) AS amt from fa_report where time = '$today' and locate('$userId',level) group by type";

            $result = $report->Query($sql);
            $item = [];
            foreach ($result as $k => $v)
            {
                $item[$v['type']] = $v['amt'];
            }
            $ret['today'] = $item;
            //昨天数据
            $sql = "select type,sum(pay_amt) AS amt from fa_report where time = '$yesterday' and locate('$userId',level) group by type";

            $result = $report->Query( $sql);
            $item = [];
            foreach ($result as $k => $v)
            {
                $item[$v['type']] = $v['amt'];
            }
            $ret['yesterday'] = $item;
            //历史数据
            $sql = "select type,sum(pay_amt) AS amt from fa_report where locate('$userId',level) group by type";

            $result = $report->Query($sql);
            $item = [];
            foreach ($result as $k => $v)
            {
                $item[$v['type']] = $v['amt'];
            }
            $ret['history'] = $item;
            $ret['userId'] = $user['id'];
            $ret['userName'] = $user['username'];
            $ret['type'] = $user['type'];
            $this->result('首页', $ret, 200);
        }
        else
        {
            $this->error('渠道登录用户类型不正确');
        }
    }

    /**
     * 注销登录
     */
    public function logout()
    {
        //注销本站
        if($this->auth->logout())
            $this->success(__('Logout successful'), null, 200);
        else
            $this->error($this->auth->getError());
    }

    /**
     * 添加一级代理
     */
    public function addAgent1()
    {
        //先判断登录用户类型
        $user = $this->auth->getUserinfo();
        if('admin' != $user['type'])
            $this->error('没有权限添加');

        $username = $this->request->request('username');//账号
        $password = $this->request->request('password');//密码
        $nickname = $this->request->request('nickname');//昵称
        $commission = $this->request->request('commission');//提成比例
        $deductions = $this->request->request('deductions');//没多少笔开始扣除
        $deductions_diff = $this->request->request('deductions_diff');//每次扣除多少笔

        if($commission < 0 || $commission > 100)
            $this->error('提成比例限制:1~100');

        if($deductions < 0 || $deductions_diff < 0 || $deductions > 999999)
            $this->error('订单扣量比例设置有误');

        if($deductions != 0 && ($deductions_diff < 0 || $deductions_diff > $deductions))
            $this->error('订单扣量比例设置有误');

        if ( ! $username || ! $password || ! $nickname || ! $commission) {
            $this->error(__('Invalid parameters'));
        }

        if (!Validate::is($password, '\S{6,16}')) {
            $this->error(__("Please input correct password"));
        }
        $params['salt'] = Random::alnum();
        $params['password'] = md5(md5($password) . $params['salt']);
        $params['avatar'] = '/assets/img/avatar.png'; //设置新管理员默认头像。
        $params['commission'] = $commission;
        $params['username'] = $username;
        $params['nickname'] = $nickname;
        $params['type'] = 'agent1';//一级代理
        $params['deductions'] = $deductions;//
        $params['deductions_diff'] = $deductions_diff;//

        $model = new AdminModel();
        $find = $model::where('username',$username)->find();
        if($find)
            $this->error('用户名已存在，请重新输入');

        $result = $model->save($params);
        if ($result === false) {
            $this->error($model->getError());
        }

        //过滤不允许的组别,避免越权
        $group = array_intersect([], []);
        $dataset = [];
        foreach ($group as $value) {
            $dataset[] = ['uid' => $model, 'group_id' => $value];
        }

        $AuthGroupAccess = new AuthGroupAccessModel();
        $AuthGroupAccess->saveAll($dataset);

        $this->success(__('添加成功'), null, 200);
    }

    /**
     * 添加二级代理
     */
    public function addAgent2()
    {
        //先判断登录用户类型
        $user = $this->auth->getUserinfo();
        if('admin' != $user['type'] && 'agent1' != $user['type'])
            $this->error('没有权限添加');

        $up_agent = $this->request->request('up_agent');//上级id
        if('admin' != $user['type'])
        {//如果是1级代理添加，固定为登录用户id
            $up_agent = $user['id'];
        }

        $model = new AdminModel();
        $agent = $model::get($up_agent);
        if(!$agent)
            $this->error('上级id不存在');

        if($agent['type'] != 'agent1')
            $this->error('上级类型不正确' . $agent['type']);

        $username = $this->request->request('username');//账号
        $password = $this->request->request('password');//密码
        $nickname = $this->request->request('nickname');//昵称
        $commission = $this->request->request('commission');//提成比例
        $deductions_diff = $this->request->request('deductions_diff');//每次扣除多少笔

        $deductions = $agent['deductions'];//从上级获取，每多少笔扣除

        if($commission < 0 || $commission > 100)
            $this->error('提成比例限制:1~100');

        if($deductions < 0 || $deductions_diff < 0 || $deductions > 999999)
            $this->error('订单扣量比例设置有误!');

        if($deductions != 0 && ($deductions_diff < 0 || $deductions_diff > $deductions))
            $this->error('订单扣量比例设置有误!!');

        //提成比例不能超过上级
        if($commission > $agent['commission'])
            $this->error('提成比例超限制');

        //订单扣量比例不能超过上上级
        if($deductions_diff < 0 || $deductions_diff > $agent['deductions_diff'])
            $this->error('订单扣量比例设置有误!!!');

        if ( ! $username || ! $password || ! $nickname || ! $commission) {
            $this->error(__('Invalid parameters'));
        }

        if (!Validate::is($password, '\S{6,16}')) {
            $this->error(__("Please input correct password"));
        }
        $params['salt'] = Random::alnum();
        $params['password'] = md5(md5($password) . $params['salt']);
        $params['avatar'] = '/assets/img/avatar.png'; //设置新管理员默认头像。
        $params['commission'] = $commission;
        $params['username'] = $username;
        $params['nickname'] = $nickname;
        $params['type'] = 'agent2';//二级代理
        $params['deductions'] = $deductions;//
        $params['deductions_diff'] = $deductions_diff;//
        $params['level'] = '|' . $agent['id'] . '|';//层级等于上级|id|
        $params['up_agent'] = $agent['id'];//上级等于上级id

        $find = $model::where('username',$username)->find();
        if($find)
            $this->error('用户名已存在，请重新输入');

        $result = $model->save($params);
        if ($result === false) {
            $this->error($model->getError());
        }

        //过滤不允许的组别,避免越权
        $group = array_intersect([], []);
        $dataset = [];
        foreach ($group as $value) {
            $dataset[] = ['uid' => $model, 'group_id' => $value];
        }

        $AuthGroupAccess = new AuthGroupAccessModel();
        $AuthGroupAccess->saveAll($dataset);

        $this->success(__('添加成功'), null, 200);
    }

    /**
     * 添加三级代理
     */
    public function addAgent3()
    {
        //先判断登录用户类型
        $user = $this->auth->getUserinfo();
        if('admin' != $user['type'] && 'agent2' != $user['type'])
            $this->error('没有权限添加');

        $up_agent = $this->request->request('up_agent');//上级id
        if('admin' != $user['type'])
        {//如果是1级代理添加，固定为登录用户id
            $up_agent = $user['id'];
        }

        $model = new AdminModel();
        $agent = $model::get($up_agent);
        if(!$agent)
            $this->error('上级id不存在');

        if($agent['type'] != 'agent2')
            $this->error('上级类型不正确' . $agent['type']);

        $username = $this->request->request('username');//账号
        $password = $this->request->request('password');//密码
        $nickname = $this->request->request('nickname');//昵称
        $commission = $this->request->request('commission');//提成比例
        $deductions_diff = $this->request->request('deductions_diff');//每次扣除多少笔

        $deductions = $agent['deductions'];//从上级获取，每多少笔扣除

        if($commission < 0 || $commission > 100)
            $this->error('提成比例限制:1~100');

        if($deductions < 0 || $deductions_diff < 0 || $deductions > 999999)
            $this->error('订单扣量比例设置有误!');

        if($deductions != 0 && ($deductions_diff < 0 || $deductions_diff > $deductions))
            $this->error('订单扣量比例设置有误!!');

        //提成比例不能超过上级
        if($commission > $agent['commission'])
            $this->error('提成比例超限制');

        //订单扣量比例不能超过上上级
        if($deductions_diff < 0 || $deductions_diff > $agent['deductions_diff'])
            $this->error('订单扣量比例设置有误!!!');

        if ( ! $username || ! $password || ! $nickname || ! $commission) {
            $this->error(__('Invalid parameters'));
        }

        if (!Validate::is($password, '\S{6,16}')) {
            $this->error(__("Please input correct password"));
        }
        $params['salt'] = Random::alnum();
        $params['password'] = md5(md5($password) . $params['salt']);
        $params['avatar'] = '/assets/img/avatar.png'; //设置新管理员默认头像。
        $params['commission'] = $commission;
        $params['username'] = $username;
        $params['nickname'] = $nickname;
        $params['type'] = 'agent3';//三级代理
        $params['deductions'] = $deductions;//
        $params['deductions_diff'] = $deductions_diff;//
        $params['level'] = $agent['level'] . '|' . $agent['id'] . '|';//层级等于上级层级 + 上级|id|
        $params['up_agent'] = $agent['id'];//上级等于上级id

        $find = $model::where('username',$username)->find();
        if($find)
            $this->error('用户名已存在，请重新输入');

        $result = $model->save($params);
        if ($result === false) {
            $this->error($model->getError());
        }

        //过滤不允许的组别,避免越权
        $group = array_intersect([], []);
        $dataset = [];
        foreach ($group as $value) {
            $dataset[] = ['uid' => $model, 'group_id' => $value];
        }

        $AuthGroupAccess = new AuthGroupAccessModel();
        $AuthGroupAccess->saveAll($dataset);

        $this->success(__('添加成功'), null, 200);
    }

    //用户管理
    public function userList(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        }
        $req = $request->post();

        $id = $req['id'];//ID
        $username = $req['username'];//用户名
        $type = $req['type'];//agent1、agent2、agent3

        // 筛选条件
        $where = [];

        //$where['id'] = ['in', $ids];

        //类型，如果不是管理员
        $user = $this->auth->getUserinfo();
        if('admin' == $user['type'])
        {//管理员
            if(null == $type || '' == $type)
                $this->error(__('请指定查询用户类型'));

            $where['type'] = $type;
        }
        elseif ('agent1' == $user['type'])
        {//一级代理查询二级 并且属于他下级
            $where['type'] = 'agent2';
            $where['up_agent'] = $user['id'];
        }
        elseif ('agent2' == $user['type'])
        {//二级代理查三级 并且属于他下级
            $where['type'] = 'agent3';
            $where['up_agent'] = $user['id'];
        }
        else
        {//
            $this->error(__('违规操作'));
        }

        //用户名
        if(null != $username && '' != $username)
        {
            $where['username'] = $username;
        }
        //用户id
        if(null != $id && '' != $id)
        {
            $where['id'] = $id;
        }

        $res = AdminModel::where($where)
            ->field('id,username,commission,login,logintime,status,type')
            ->page($req['current'], $req['every'])
            ->order('createtime desc')->select();

        $total = AdminModel::where($where)->count();
        $result = ['total' => $total, 'list' => $res];

        $this->result('用户管理', $result, 200);
    }

    //获取用户信息
    public function getUserInfo(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        }
        $req = $request->post();

        $id = $req['id'];//ID
        $find = AdminModel::get($id);
        if(!$find || ($find['type'] != 'agent1' && $find['type'] != 'agent2' && $find['type'] != 'agent3'))
        {
            $this->error('用户id存在');
        }

        //类型，如果不是管理员 上级必须是登录用户id，否则无权查询
        $user = $this->auth->getUserinfo();
        if('admin' != $user['type'] && $find['up_agent'] != $user['id'])
        {
            $this->error('无权限查询改用户信息');
        }

        $data['id'] = $find['id'];
        $data['username'] = $find['username'];

        $data['qq'] = $find['qq'];
        $data['mobile'] = $find['mobile'];
        $data['payee'] = $find['payee'];
        $data['account'] = $find['account'];
        $data['commission'] = $find['commission'];
        $data['deductions'] = $find['deductions'];
        $data['deductions_diff'] = $find['deductions_diff'];

        $result = ['userinfo' => $data];

        $this->result('用户信息', $result, 200);
    }

    //编辑用户信息
    public function upUserInfo(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        }
        $req = $request->post();

        $id = $req['id'];//ID
        $qq = $req['qq'];//QQ
        $mobile = $req['mobile'];//联系电话
        $payee = $req['payee'];//收款人
        $account = $req['account'];//收款账号
        $commission = $req['commission'];//提成比例
        $deductions = $req['deductions'];//订单扣量比例：每
        $deductions_diff = $req['deductions_diff'];//笔减少
        $pwd = $req['pwd'];//密码

        $find = AdminModel::get($id);
        if(!$find || ($find['type'] != 'agent1' && $find['type'] != 'agent2' && $find['type'] != 'agent3'))
        {
            $this->error('用户id存在');
        }

        //类型，如果不是管理员 上级必须是登录用户id，否则无权查询
        $user = $this->auth->getUserinfo();
        if('admin' != $user['type'] && $find['up_agent'] != $user['id'])
        {
            $this->error('无权修改该改用户信息');
        }

        if($commission < 0 || $commission > 100)
            $this->error('提成比例限制:1~100');

        if($deductions < 0 || $deductions_diff < 0 || $deductions > 999999)
            $this->error('订单扣量比例设置有误');

        if($deductions != 0 && ($deductions_diff < 0 || $deductions_diff > $deductions))
            $this->error('订单扣量比例设置有误');

        //获取上级代理信息
        $model = new AdminModel();
        if(null != $find['up_agent'] && '' != $find['up_agent'])
        {
            $agent = $model::get($find['up_agent']);

            //提成比例不能超过上级
            if($commission > $agent['commission'])
                $this->error('提成比例超限制');

            //订单扣量比例不能超过上上级
            if($deductions_diff < 0 || $deductions_diff > $agent['deductions_diff'])
                $this->error('订单扣量比例设置有误,最大值:' . $agent['deductions_diff']);

            $deductions = $agent['deductions'];//等于上级
        }

        $find['qq'] = $qq;
        $find['mobile'] = $mobile;
        $find['payee'] = $payee;
        $find['account'] = $account;
        $find['commission'] = $commission;
        if('agent1' == $find['type'])
        {//只能编辑一级代理总扣量信息
            $find['deductions'] = $deductions;
        }
        $find['deductions_diff'] = $deductions_diff;
        if(null != $pwd && '' != $pwd)
        {
            if (!Validate::is($pwd, '\S{6,16}')) {
                $this->error('请输入正确格式的密码');
            }
            $find['password'] = md5(md5($pwd) . $find['salt']);
        }

        $update =$model->where('id',$id)->update(
            [
                'qq'=>  $find['qq'],
                'mobile'=>  $find['mobile'],
                'payee'=>  $find['payee'],
                'account'=>  $find['account'],
                'commission'=>  $find['commission'],
                'deductions'=>  $find['deductions'],
                'deductions_diff'=>  $find['deductions_diff'],
                'password'=>  $find['password']
            ]);
        if (!$update) {
            $this->error('修改失败，系统错误');
        }

        if('agent1' == $find['type'])
        {//编辑一级代理总扣量信息，其他的也需要变更
            $find['deductions'] = $deductions;
            $agentId = $agent['id'];
            $model->Query("update fa_admin set deductions = '$deductions' where `level` like '%|$agentId|%' " );
        }

        $data['id'] = $find['id'];
        $data['username'] = $find['username'];
        $data['qq'] = $find['qq'];
        $data['mobile'] = $find['mobile'];
        $data['payee'] = $find['payee'];
        $data['account'] = $find['account'];
        $data['commission'] = $find['commission'];
        $data['deductions'] = $find['deductions'];
        $data['deductions_diff'] = $find['deductions_diff'];

        $result = ['userinfo' => $data];

        $this->result('用户信息', $result, 200);
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
        $username = 'Rosetang_' . mt_rand(1000, 9999);
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
        $ret = $this->auth->register($username, $password, '', $mobile, $extends);
        if ($ret) {
            $data = ['userinfo' => $this->auth->getUserinfo()];
            if (null !== $t_number && !empty($t_number)) {
                $this->tg($t_number, $data['userinfo']['id']);
            }
            $this->success(__('Sign up successful'), $data);
        } else {
            $this->error($this->auth->getError());
        }
    }//推广码

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

    //推广返利
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


}
