<?php


namespace app\api\controller;


use app\admin\model\Thumbs;
use app\common\controller\Api;
use app\admin\model\Tvideo as Tvs;
use think\Request;

class Tvideo extends Api
{
    protected $noNeedLogin = ['*'];

    //小视频
    public function video_list(\think\Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＤＯＮ＇Ｔ　ＧＥＴ');
        }
        $req = $request->post();
        $res = Tvs::where(['tong' => 1])->orderRaw('rand()')->limit($req['every'])->select()->toArray();
        $res ?? '';
        if ($request->header('token') !== null) {
            $user = $this->auth->getUserinfo();
            foreach ($res as &$value) {
                $find = Thumbs::where(['userid' => $user['id'], 'thumbsid' => $value['id'], 'class' => 0])->find();
                if ($find) {
                    $value['give'] = 1;
                } else {
                    $value['give'] = 0;
                }
            }
        }
        $this->result('小视频', $res, 200);
    }

    //点赞作品(小视频)
    public function thumbs(Request $request)
    {
        if ( ! $request->isGet()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＧＥＴ');
        }
        $user = $this->auth->getUser();
        $req = $request->get();
        $find = Thumbs::where(['userid' => $user['id'], 'thumbsid' => $req['id'],'class' => 0])->find();
        if ($find) {
            $this->result('您已经点过赞了', '', 100);
        } else {
            $thumbs = new Thumbs();
            $res = $thumbs->save(['userid' => $user['id'], 'thumbsid' => $req['id'],'class'=>0]);
        }
        if ($res) {
            $res = Tvs::where('id', $req['id'])->setInc('thumbs', 1);
            $res = Task::upload($user->id, 4);
            if ($res) {
                $this->success('ok', '', 200);
            }
        } else {
            $this->error('系统错误或网络错误', '', 100);
        }
    }
}
