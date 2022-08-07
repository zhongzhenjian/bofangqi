<?php


namespace app\api\controller;


use app\common\controller\Api;

class Browse extends Api
{
    protected $noNeedLogin = ['*'];

    public function index()
    {
        $user = $this->auth->getUserinfo();
        $res = \app\admin\model\Browse::with('video')->where('userid', $user['id'])->order('create_time desc')->select()->toArray();
        $res ?? '';
        $this->result('历史记录', $res, 200);
    }

    public function add()
    {
        $user = $this->auth->getUserinfo();
        $req = $this->request->post();
        $find = \app\admin\model\Browse::where(['userid' => $user['id'], 'videoid' => $req['videoid']])->find();
        if ($find) {
            $res = \app\admin\model\Browse::where(['userid' => $user['id'], 'videoid' => $req['videoid']])->update(['create_time' => date('Y-m-d H:i:s')]);
        } else {
            $req['userid'] = $user['id'];
            $res = \app\admin\model\Browse::insert($req);
        }
        if($res){
            $this->success('ok','',200);
        }else{
            $this->error('error','',100);
        }

    }
}
