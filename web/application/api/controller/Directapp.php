<?php

namespace app\api\controller;

use app\admin\model\Directadv;
use app\common\controller\Api;
use think\Controller;
use think\Request;

class Directapp extends Api
{
    protected $noNeedLogin = ['*'];

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //列表
        $res = \app\admin\model\Directapp::select();
        $res ? $res->toArray() : '';
//        halt($res);
        $this->result('广告列表', $res, 200);
    }

    /**
     * adv顶部广告.
     *
     * @return \think\Response
     */
    public function create()
    {
        $res = Directadv::where('status', 0)->orderRaw('rand()')->find();
        $res ? $res->toArray() : '';
//        halt($res);
        $this->result('广告列表', $res, 200);
    }

    /**
     * adv底部广告
     *
     * @param \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $res = Directadv::where('status', 1)->orderRaw('rand()')->find();
        $res ? $res->toArray() : '';
//        halt($res);
        $this->result('广告列表', $res, 200);
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
