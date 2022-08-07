<?php


namespace app\api\controller;


use app\admin\model\Answer;
use app\admin\model\Topping;
use app\admin\model\Video;
use app\common\controller\Api;

class Ask extends Api
{
    protected $noNeedLogin = ['*'];

    //问答
    public function index()
    {
        $req = $this->request->post();
        $res = Video::where(['class' => 4, 'tong' => 1])->page($req['current'], $req['every'])->select()->toArray();
        $res ?? '';
        $top = [];
        $communityid = Topping::where(['list'=>4])->column('communityid');
        foreach ($communityid as $item){
            $top[] = Video::where(['id'=>$item])->find();
        }
        return json(['msg'=>'图片','data'=>$res,'top'=>$top,'code'=>200])->header(['Content-Type'=>'application/json']);
    }

    //回答详情
    public function detail()
    {
        $req = $this->request->post();
        $res = Video::where('id', $req['id'])->page($req['current'], $req['every'])->find();
        $res['answer'] = Answer::where(['cid' => $req['id'], 'tong' => 1])->page($req['current'], $req['every'])->select()->toArray();
        $res ?? '';
        $this->result('回答', $res, 200);
    }

    //添加问答
    public function add()
    {
        $user = $this->auth->getUserinfo();
        $req = $this->request->post();
        $req['name'] = $user['username'];
        $req['avator_image'] = $user['avatar'];
        $req['class'] = 4;
        $req['tong'] = 0;
        $req['status'] = 0;
        $req['user_id'] = $user['id'];
        $res = Video::insert($req);
        if ($res) {
            $this->success('添加成功', '', 200);
        } else {
            $this->success('失败', '', 100);
        }
    }

    //添加回答
    public function huida_add()
    {
        $user = $this->auth->getUserinfo();
        $req = $this->request->post();
        $req['name'] = $user['username'];
        $req['image'] = $user['avatar'];
        $req['tong'] = 0;
        $req['status'] = 1;
        $req['user_id'] = $user['id'];
        $res = Answer::insert($req);
        if ($res) {
            $this->success('回答成功等待审核', '', 200);
        } else {
            $this->success('错误', '', 100);
        }
    }
}
