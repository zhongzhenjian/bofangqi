<?php


namespace app\api\controller;


use app\common\controller\Api;
use app\admin\model\Coll as Colls;
use think\Request;
use function fast\e;

class Coll extends Api
{
    protected $noNeedLogin = ['*'];

    //添加我的收藏
    public function add(Request $request)
    {
        $user = $this->auth->getUser();
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        }
        $req = $request->post();
        $if = Colls::where(['userid' => $user->id, 'videoid' => $req['videoid']])->find();
        if ($if) {
            $res = Colls::where(['userid' => $user->id, 'videoid' => $req['videoid']])->update(['create_time' => date('Y-m-d H:i:s')]);
        } else {
            $coll = new Colls();
            $res = $coll->save(['userid' => $user->id, 'videoid' => $req['videoid']]);
        }
        if ($res) {
            $this->success('收藏成功', '', 200);
        } else {
            $this->error('收藏错误', '', 100);

        }
    }//显示
    public function index(Request $request)
    {
        $user = $this->auth->getUser();
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        }
        $req = $request->post();
        $res = Colls::with('video')->where('userid', $user->id)->limit($req['limit'])->select()->toArray();
        $res ?? '';
        $this->success('收藏',$res,20);
    }
}
