<?php


namespace app\api\controller;


use app\common\controller\Api;
use GatewayClient\Gateway;
use think\Request;

class Webstock extends Api
{
    protected $noNeedLogin = ['*'];

    //进入直播间
    public function group_add(Request $request)
    {
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
        header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding,token");
        //请求方式检测
        if ( ! $request->isPost()) {
            $this->error('请求方式错误', '', 100);
        }
        $token = $request->header('token');
        $params = $request->post();
        //参数检测
        $validate = $this->validate($params, [
            'client_id|页面链接唯一标识' => 'require|length:10,20',
            'room_number|直播间号' => 'require|number'
        ]);
        if ($validate !== true) {
            $this->error($validate, '', 100);
        }
        if (empty($token)) {
            $name = '游客' . mt_rand(10000, 55555);
            $level = '1';
        } else {
            $user = $this->auth->getUser();
            $name = $user['username'];
            $level = $user['level'];
        }
        //加入群组
        Gateway::joinGroup($params['client_id'], $params['room_number']);
            //广播
            $res = array(
                'type' => 'add',
                'level' => $level,
                'name' => $name,
                'message' => '光临直播间',
            );
            $string = json_encode($res, JSON_UNESCAPED_UNICODE);
            Gateway::sendToGroup($params['room_number'], $string, [], false);
    }

    //用户发送弹幕
    public function group_send(Request $request)
    {
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
        header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding,token");
        //请求方式检测
        if ( ! $request->isPost()) {
            $this->error('请求方式错误', '', 100);
        }
        //登陆验证
        $token = $request->header('token');
        if (empty($token)) {
            $this->error('未登录状态', '', 100);
        } else {
            $user = $this->auth->getUser();
        }
        $params = $request->post();
        //参数检测
        $validate = $this->validate($params, [
            'client_id|页面链接唯一标识' => 'require|length:10,20',
            'room_number|直播间号' => 'require|number',
            'message|弹幕' => 'require'
        ]);
        if ($validate !== true) {
            $this->error($validate, '', 100);
        }
        //广播
        $res = array(
            'type' => 'send',
            'msg' => '发送弹幕成功',
            'level' => $user['level'],
            'name' => $user['username'],
            'message' => $params['message']
        );
        $string = json_encode($res, JSON_UNESCAPED_UNICODE);
        Gateway::sendToGroup($params['room_number'], $string);
        $this->success('弹幕', $res, 200);
    }

    //礼物赠送
    public function gifts(Request $request)
    {
        //请求方式检测
        if ( ! $request->isPost()) {
            $this->error('请求方式错误', '', 100);
        }
        //登陆验证
        $token = $request->header('token');
        if (empty($token)) {
            $this->error('未登录状态', '', 100);
        } else {
            $user = $this->auth->getUser();
        }
        $params = $request->post();
        //参数检测
        $validate = $this->validate($params, [
            'client_id|页面链接唯一标识' => 'require|length:10,20',
            'room_number|直播间号' => 'require|number',
            'giftid|礼物id' => 'require'
        ]);
        if ($validate !== true) {
            $this->error($validate, '', 100);
        }
        //广播
        $res = array(
            'type' => 'gift',
            'msg' => '礼物发送成功',
            'level' => $user['level'],
            'name' => $user['username'],
            'image'=>config('host').$user['avatar'],
            'message' => $params['giftid']
        );
        $string = json_encode($res, JSON_UNESCAPED_UNICODE);
        Gateway::sendToGroup($params['room_number'], $string);
        $this->success('礼物', $res, 200);
    }
    //退出直播间
    public function group_quit(Request $request)
    {
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
        header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding,token");
        //请求方式检测
        if ( ! $request->isPost()) {
            $this->error('请求方式错误', '', 100);
        }
        $token = $request->header('token');
        $params = $request->post();
        //参数检测
        $validate = $this->validate($params, [
            'client_id|页面链接唯一标识' => 'require|length:10,20',
            'room_number|直播间号' => 'require|number'
        ]);
        if ($validate !== true) {
            $this->error($validate, '', 100);
        }
        if (empty($token)) {
            $name = '游客' . mt_rand(10000, 55555);
            $level = '1';
        } else {
            $user = $this->auth->getUser();
            $name = $user['username'];
            $level = $user['level'];
        }
            //广播
            $res = array(
                'type' => 'quit',
                'level' => $level,
                'name' => $name,
                'message' => '退出直播间',
            );
            $string = json_encode($res, JSON_UNESCAPED_UNICODE);
            Gateway::sendToGroup($params['room_number'], $string, [], false);
            $this->success('退出直播间', $res, 200);
    }
    //用户发送弹幕
    public function all_send(Request $request)
    {
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
        header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding,token");
        //请求方式检测
        if ( ! $request->isPost()) {
            $this->error('请求方式错误', '', 100);
        }
        //登陆验证
        $token = $request->header('token');
        if (empty($token)) {
            $user['lever'] =1;
            $user['username'] ='游客' . mt_rand(10000, 55555);
        } else {
            $user = $this->auth->getUser();
        }
        $params = $request->post();
        //参数检测
        $validate = $this->validate($params, [
            'client_id|页面链接唯一标识' => 'require|length:10,20',
            'room_number|直播间号' => 'require|number',
            'message|弹幕' => 'require'
        ]);
        if ($validate !== true) {
            $this->error($validate, '', 100);
        }
        //广播
        $res = array(
            'type' => 'send',
            'msg' => '发送弹幕成功',
            'level' => $user['level'],
            'name' => $user['username'],
            'message' => $params['message']
        );
        $string = json_encode($res, JSON_UNESCAPED_UNICODE);
        Gateway::sendToGroup($params['room_number'], $string);
        $this->success('弹幕', $res, 200);
    }
}
