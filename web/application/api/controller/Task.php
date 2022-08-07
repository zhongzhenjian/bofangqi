<?php


namespace app\api\controller;


use app\common\controller\Api;
use app\admin\model\Task as Tasks;
use app\common\model\Config;
use think\Request;
use app\admin\model\Complete;

class Task extends Api
{
    protected $noNeedLogin = ['*'];

    //显示
    public function index(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        }
        $user = $this->auth->getUser();
        $req = $request->post();
        $res = Tasks::all()->toArray();
        foreach ($res as $key => &$value) {
            $find = Complete::where(['userid' => $user->id, 'tid' => $value['id']])->find();
            if ($find) {
                $value['tong'] = 1;
            } else {
                $value['tong'] = 0;
            }
        }
        $this->success('任务列表', $res, 200);
    }

    //任务完成
    public static function upload($userid, $id)
    {
        $find = Tasks::find($id);
        $integral = \app\admin\model\User::where('id', $userid)->setInc('integral', $find['agent']);
        if ($find['vip'] != 0) {
            $time = $find['vip'] * (1 * 60 * 60 * 24);
            $find = \app\admin\model\User::where('id', $userid)->find();
            $addtime = strtotime($find['vip_time']);
            if ( ! $find['vip_time'] = '') {
                $shijian = $time + $addtime;
            } else {
                $shijian = $time;
            }
            $shijian = date('Y-m-d H:i:s', $shijian);
            \app\admin\model\User::where('id', $userid)->update(['vip_time' => $shijian]);
        }
        if ($integral) {
            $com = new Complete();
            $com->save(['userid' => $userid, 'tid' => $id]);
            return true;
        }
    }

    //分享作品
    public function share()
    {
        $user = $this->auth->getUser();
        if ($user) {
            $res = $this->upload($user->id, 5);
        } else {
            $res = false;
        }
        if ($res) {
            $this->success('ok', '', 200);
        } else {
            $this->error('errer', '', 100);
        }
    }
    //链接分享
    public function fxlj()
    {
        $res = Config::where('name', 'fxlj')->value('value');
        $this->result('链接内容',$res,200);
    }
}
