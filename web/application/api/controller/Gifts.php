<?php

namespace app\api\controller;

use app\common\controller\Api;
use GatewayClient\Gateway;
use think\Controller;
use think\Request;

class Gifts extends Api
{
    protected $noNeedLogin = ['*'];

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //列表显示
        $res = \app\admin\model\Gifts::select();
        $this->result('礼物列表', $res, 200);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create($price)
    {
        //
        $user = $this->auth->getUser();
        $params = $this->request->post();
        if ($user['money'] < $price) {
            $this->error('余额不足', '', 100);
        }
        $money = bcsub($user['money'], $price, 2);
        $res = $user->save(['id' => $user['id'], 'money' => $money]);
        if ($res) {
            $res = array(
                'type' => 'gift',
                'msg' => '礼物发送成功',
                'level' => $user['level'],
                'name' => $user['username'],
                'image' => config('host') . $user['avatar'],
                'message' => $params['giftid']
            );
            $string = json_encode($res, JSON_UNESCAPED_UNICODE);
            Gateway::sendToGroup($params['room_number'], $string);
            $this->success('礼物', $res, 200);
        } else {
            $this->error('网络错误', '', 100);
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
