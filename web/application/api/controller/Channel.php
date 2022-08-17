<?php

namespace app\api\controller;

use app\admin\model\Report as ReportModel;
use app\admin\model\Admin as AdminModel;
use app\admin\model\Promote as PromoteModel;
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
            //登录次数+1
            $model = new AdminModel();
            $id = $this->auth->getUserinfo()['id'];
            $model->Query("update fa_admin set login = login + 1 where id = '$id'" );

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
            $result = $report->Query("select type,sum(pay_amt) AS amt from fa_report where workDate = '$today' group by type" );
            $item = [];
            foreach ($result as $k => $v)
            {
                $item[$v['type']] = $v['amt'];
            }
            $ret['today'] = $item;
            //昨天数据
            $result = $report->Query("select type,sum(pay_amt) AS amt from fa_report where workDate = '$yesterday' group by type" );
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
            $sql = "select type,sum(pay_amt) AS amt from fa_report where workDate = '$today' and locate('$userId',level) group by type";

            $result = $report->Query($sql);
            $item = [];
            foreach ($result as $k => $v)
            {
                $item[$v['type']] = $v['amt'];
            }
            $ret['today'] = $item;
            //昨天数据
            $sql = "select type,sum(pay_amt) AS amt from fa_report where workDate = '$yesterday' and locate('$userId',level) group by type";

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

        $normal = 'normal';
        $hidden = 'hidden';
        $where['status'] = array("in","$normal,$hidden");

        //类型，如果不是管理员
        $user = $this->auth->getUserinfo();
        if('admin' == $user['type'])
        {//管理员
            if(null == $type || '' == $type)
                $this->error(__('请指定查询用户类型'));

            if('agent1' ==$type || 'agent2' ==$type || 'agent3' ==$type)
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
            ->field('id,username,commission,up_agent,login,logintime,status,type,type')
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
            $this->error('用户id不存在');
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
        $data['status'] = $find['status'];

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
        $status = $req['status'];//状态

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
        $find['status'] = $status;
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
                'password'=>  $find['password'],
                'status' => $find['status']
            ]);
        if (!$update) {
            $this->error('修改失败，信息未变更');
        }

        if('agent1' == $find['type'])
        {//编辑一级代理总扣量信息，其他的也需要变更
            $find['deductions'] = $deductions;
            $agentId = $find['id'];
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

    //编辑用户信息
    public function delUserInfo(Request $request)
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
            $this->error('无权删除该用户');
        }

        $model = new AdminModel();

        $update =$model->where('id',$id)->update(
            [
                'status' => 'delete'
            ]);
        if (!$update) {
            $this->error('删除失败，用户不存在');
        }

        $this->result('删除用户', null, 200);
    }

    /**
     * APP数据 H5数据 PC数据
     *
     */
    public function selReport(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        }

        $req = $request->post();
        $type = $req['type'];//类型 APP H5 PC
        $id = $req['id'];//ID
        $username = $req['username'];//名称

        $beginTime = $req['beginTime'];//开始时间
        $endTime = $req['endTime'];//结束时间

        if('APP' != $type && 'H5' != $type && 'PC' != $type)
        {
            $this->error('类型传参不正确');
        }

        if(null == $beginTime || '' == $beginTime || null == $endTime || '' == $endTime)
        {
            $this->error('时间传参不正确');
        }

        if(null == $beginTime || '' == $beginTime || null == $endTime || '' == $endTime)
        {
            $this->error('时间传参不正确');
        }

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
            ->select();

        $total = $report::where($where)->count();

        $totalRes = $report::where($where)->field('sum(pay_amt) as payAmt,sum(install) as install,sum(arpu) as arpu,sum(diff_amt) as sumDiffAmt,sum(diff_amt_after) as sumDiffAmtAfter')->select();

        $sumPayAmt = 0;
        $sumInstall = 0;
        $sumArpu = 0;
        $sumDiffAmt = 0;
        $sumDiffAmtAfter = 0;

        if(sizeof($totalRes) == 1)
        {
            $sumPayAmt = $totalRes[0]['payAmt'];
            $sumInstall = $totalRes[0]['install'];
            $sumArpu = $totalRes[0]['arpu'];

            if('admin' == $user['type'])
            {
                $sumDiffAmt = $totalRes[0]['sumDiffAmt'];
                $sumDiffAmtAfter = $totalRes[0]['sumDiffAmtAfter'];
            }
        }

        $result = [
            'total' => $total,
            'sumPayAmt' => $sumPayAmt,
            'sumInstall' => $sumInstall,
            'sumArpu' => $sumArpu,
            'sumDiffAmt' => $sumDiffAmt,
            'sumDiffAmtAfter' => $sumDiffAmtAfter,
            'list' => $res];

        $this->result($type . '数据', $result, 200);

    }

    //获取推广链接
    public function getPromoteLink(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        }

        $user = $this->auth->getUserinfo();
        if(!$user || $user['type'] != 'agent3')
        {
            $this->error('当前登录用户无法获取推广链接');
        }

/*        $model = new PromoteModel();

        $find = $model::get($user['id']);
        if(!$find)
            $this->error($user['username'] . '['.$user['id'].']未配置推广链接，请联系客服');*/

        $data['userId'] = $user['id'];
        $data['userName'] = $user['username'];
        $data['appLink'] = '';
        $data['ldyLink'] = '';

        $data['h5Link'] = config('host').'h5?id='. $user['id'];
        $data['jhLink'] = '';
        $data['upCode'] = '';
        $data['downCode'] = '';

        $result = ['promoteLink' => $data];

        $this->result('用户信息', $result, 200);
    }


}
