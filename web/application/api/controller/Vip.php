<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Controller;
use think\Request;

class Vip extends Api
{
    protected $noNeedLogin = ['*'];

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //参数
        $params = input();
        $res = \app\admin\model\Vip::where(['direct_id' => $params['directid'], 'class' => 1])->select();
        $res ? $res->toArray() : '';
        $this->result('真爱守护', $res, 200);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //参数
        $params = input();
        $res = \app\admin\model\Vip::where(['direct_id' => $params['directid'], 'class' => 0])->select();
        $res ? $res->toArray() : '';
        $this->result('贵宾', $res, 200);
    }

    /**
     * 保存新建的资源
     *
     * @param \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
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
    }
}
