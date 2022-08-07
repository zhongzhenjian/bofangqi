<?php


namespace app\api\controller;


use app\admin\model\Sub;
use app\admin\model\Subordinate;
use app\admin\model\Thumbs;
use app\admin\model\Tvideo as Tvs;
use app\common\controller\Api;
use think\Request;
use app\admin\model\Dvideo as Videos;

class Dvideo extends Api
{
    protected $noNeedLogin = ['*'];

    //视频列表
    public function video_list(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        }
        $req = $request->post();
        $res = Videos::with('labels')->where('class', $req['class'])->page($req['current'], $req['every'])->order('hits desc')->select();
        $res ? $res = $res->toArray() : '';
        if ($request->header('token') !== null) {
            $user = $this->auth->getUserinfo();
            foreach ($res as &$value) {
                $find = Thumbs::where(['userid' => $user['id'], 'thumbsid' => $value['id'], 'class' => 1])->find();
                if ($find) {
                    $value['give'] = 1;
                } else {
                    $value['give'] = 0;
                }
            }
        }
        $this->result('分类', $res, 200);
    }

    //视频分类
    public function fl(Request $request)
    {
        if ( ! $request->isGet()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＧＥＴ');
        }
        $res = Subordinate::all();
        $res ? $res = $res->toArray() : '';
        $this->result('分类', $res, 200);
    }

    //视频详情
    public function xq_video(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        }
        $req = $request->post();
        $res = Videos::with('labels')->where('fa_video.id', $req['id'])->find();
        if ($request->header('token') !== null) {
            $user = $this->auth->getUserinfo();
            $find = Thumbs::where(['userid' => $user['id'], 'thumbsid' => $res['id'], 'class' => 1])->find();
            if ($find) {
                $res['give'] = 1;
            } else {
                $res['give'] = 0;
            }

        }
        $this->result('视频详情', $res, 200);
    }

    //猜你喜欢
    public function like(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        }
        $req = $request->post();
        $res = Videos::where('class', $req['class'])->orderRaw('rand()')->limit($req['limit'])->select();
        $res ? $res = $res->toArray() : '';
        $this->result('猜你喜欢', $res, 200);
    }

    //点赞作品(大视频)
    public function thumbs(Request $request)
    {
        if ( ! $request->isGet()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＧＥＴ');
        }
        $user = $this->auth->getUser();
        $req = $request->get();
        $find = Thumbs::where(['userid' => $user['id'], 'thumbsid' => $req['id'], 'class' => 1])->find();
        if ($find) {
            $this->result('您已经点过赞了', '', 100);
        } else {
            $thumbs = new Thumbs();
            $res = $thumbs->save(['userid' => $user['id'], 'thumbsid' => $req['id'], 'class' => 1]);
        }
        if ($res) {
            $res = Videos::where('id', $req['id'])->setInc('hits', 1);
            $res = Task::upload($user->id, 4);
            if ($res) {
                $this->success('ok', '', 200);
            }
        } else {
            $this->error('系统错误或网络错误', '', 100);
        }
    }

    //精选
    public function selected(Request $request)
    {
        $res = Sub::all()->toArray();
        foreach ($res as &$item) {
            $item['videos'] = Videos::with(['subordinate', 'labels'])->orderRaw('rand()')->where('class', $item['id'])->limit('10')->select()->toArray();
        }
        $this->result('精选视频', $res, 200);
    }

}
