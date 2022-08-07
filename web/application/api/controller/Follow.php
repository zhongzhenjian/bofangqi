<?php

namespace app\api\controller;

use app\admin\model\Directfollow;
use app\common\controller\Api;
use think\Controller;
use think\Db;
use think\Request;

class Follow extends Api
{
    protected $noNeedLogin = ['*'];

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        //参数
        $params = $request->post();
        //用户
        $user = $this->auth->getUser();
        $res = Directfollow::with('anchor,anchor.direct')->where('userid', $user['id'])->select();
        $res ? $res->toArray() : '';
        $this->success('关注列表', $res, 200);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create(Request $request)
    {
        //参数检测
        $params = $request->post();
        $user = $this->auth->getUser();
        $params['userid'] = $user['id'];
        $validate = $this->validate($params, [
            'userid|用户id' => 'require',
            'anchorid|主播id' => 'require'
        ]);
        if ($validate !== true) {
            $this->error($validate, '', 100);
        }
        //数据检测
        $find = Directfollow::where(['userid' => $user['id'], 'anchorid' => $params['anchorid']])->find();
        if ($find) {
            $this->success('此主播已关注', '', 100);
        }
//        Db::startTrans();
//        try {
//
//            Db::commit();
//        } catch (Exception $e) {
//            Db::rollback();
//            echo $e->getMessage();
//            // die(); // 终止异常
//        }
        //入表
        $res = Directfollow::create($params);
        if ($res) {
            $this->success('关注成功', '', 200);
        } else {
            $this->error('关注失败');
        }
    }

    /**
     * 保存新建的资源
     *
     * @param \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {


    }

    /**
     * 显示指定的资源
     *
     * @param int $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param int $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param \think\Request $request
     * @param int $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
        $find = Directfollow::find($id);
        if ( ! $find) {
            $this->error('未关注，不可求取消', '', 100);
        }
        $res = Directfollow::destroy($id);
        if ($res) {
            $this->success('取消成功', '', 200);
        } else {
            $this->error('系统错误', '', 100);
        }
    }

}
