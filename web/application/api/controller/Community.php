<?php


namespace app\api\controller;


use app\admin\model\Label;
use app\admin\model\Publisher;
use app\admin\model\Relationship;
use app\admin\model\Thumbs;
use app\admin\model\Topping;
use app\admin\model\Video;
use app\common\controller\Api;
use app\common\model\Config;
use think\Request;
use app\admin\model\Game;

class Community extends Api
{
    protected $noNeedLogin = ['*'];

    //推荐
    public function index(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＤＯＮ＇Ｔ　ＧＥＴ');
        }
        $req = $request->post();
        $res = Video::with('publisher')->where('tong', 1)->orderRaw('rand()')->limit($req['every'])->select();
        if ($request->header('token') !== null) {
            $user = $this->auth->getUserinfo();
            foreach ($res as &$value) {
                $find = Thumbs::where(['userid' => $user['id'], 'thumbsid' => $value['id'], 'class' => 2])->find();
                if ($find) {
                    $value['give'] = 1;
                } else {
                    $value['give'] = 0;
                }
            }
        }
        $this->success('成功', $res, 200);
    }

    //图片
    public function photo(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＤＯＮ＇Ｔ　ＧＥＴ');
        }
        $req = $request->post();
        $res = Video::with('publisher')->where(['tong' => 1, 'class' => 2])->orderRaw('rand()')->limit($req['every'])->select();
        $top = [];
        $communityid = Topping::where(['list' => 2])->column('communityid');
        foreach ($communityid as $item) {
            $top[] = Video::where(['id' => $item])->find();
        }
        if ($request->header('token') !== null) {
            $user = $this->auth->getUserinfo();
            foreach ($res as &$value) {
                $find = Thumbs::where(['userid' => $user['id'], 'thumbsid' => $value['id'], 'class' => 2])->find();
                if ($find) {
                    $value['give'] = 1;
                } else {
                    $value['give'] = 0;
                }
            }
        }
        return json(['msg' => '图片', 'data' => $res, 'top' => $top, 'code' => 200])->header(['Content-Type' => 'application/json']);
    }

    //短文
    public function content(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＤＯＮ＇Ｔ　ＧＥＴ');
        }
        $req = $request->post();
        $res = Video::with('publisher')->where(['tong' => 1, 'class' => 0])->orderRaw('rand()')->limit($req['every'])->select();
        $top = [];
        $communityid = Topping::where(['list' => 0])->column('communityid');
        foreach ($communityid as $item) {
            $top[] = Video::where(['id' => $item])->find();
        }
        if ($request->header('token') !== null) {
            $user = $this->auth->getUserinfo();
            foreach ($res as &$value) {
                $find = Thumbs::where(['userid' => $user['id'], 'thumbsid' => $value['id'], 'class' => 2])->find();
                if ($find) {
                    $value['give'] = 1;
                } else {
                    $value['give'] = 0;
                }
            }
        }
        return json(['msg' => '图片', 'data' => $res, 'top' => $top, 'code' => 200])->header(['Content-Type' => 'application/json']);
    }

    //番号
    public function fanhao(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＤＯＮ＇Ｔ　ＧＥＴ');
        }
        $req = $request->post();
        $res = Video::with('labels')->where(['tong' => 1, 'class' => 3])->page($req['current'], $req['every'])->order('fabulous desc')->select();
        $this->success('成功', $res, 200);
    }

    //问答
    public function wenda(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＤＯＮ＇Ｔ　ＧＥＴ');
        }
        $req = $request->post();
        $res = Video::with('publisher')->where(['tong' => 1, 'class' => 4])->orderRaw('rand()')->limit($req['every'])->select();
        $top = [];
        $communityid = Topping::where(['list' => 2])->column('communityid');
        foreach ($communityid as $item) {
            $top[] = Video::where(['id' => $item])->find();
        }
        if ($request->header('token') !== null) {
            $user = $this->auth->getUserinfo();
            foreach ($res as &$value) {
                $find = Thumbs::where(['userid' => $user['id'], 'thumbsid' => $value['id'], 'class' => 2])->find();
                if ($find) {
                    $value['give'] = 1;
                } else {
                    $value['give'] = 0;
                }
            }
        }
        return json(['msg' => '图片', 'data' => $res, 'top' => $top, 'code' => 200])->header(['Content-Type' => 'application/json']);
    }
    
    //游戏
    public function game(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＤＯＮ＇Ｔ　ＧＥＴ');
        }
        $req = $request->post();
        $res = Game::page($req['current'], $req['every'])->select();
        $this->success('成功', $res, 200);
    }

    //添加短文审核
    public function add_dw(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＤＯＮ＇Ｔ　ＧＥＴ');
        }
        $req = $request->post();
        $user = $this->auth->getUser();
        $req['status'] = 0;//用户
        $req['class'] = 0;
        $req['user_id'] = $user['id'];
        $req['name'] = $user['username'];
        $req['avator_image'] = $user['avatar'];
//        halt($req);
        $add = Video::insert($req);
        if ($add) {
            $this->success('信息已提交，等待审核结果');
        } else {
            $this->error('网络错误或系统错误');
        }
    }

    //添加图片
    public function add_photo(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＤＯＮ＇Ｔ　ＧＥＴ');
        }
        $req = $request->post();
        $user = $this->auth->getUser();
        $req['status'] = 0;//用户
        $req['class'] = 2;
        $req['user_id'] = $user['id'];
        $req['name'] = $user['username'];
        $req['avator_image'] = $user['avatar'];
        $add = Video::insert($req);
        if ($add) {
            $this->success('信息已提交，等待审核结果');
        } else {
            $this->error('网络错误或系统错误');
        }
    }

    //添加视频
    public function add_video(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＤＯＮ＇Ｔ　ＧＥＴ');
        }
        $req = $request->post();
        $user = $this->auth->getUser();
        $req['status'] = 0;//用户
        $req['class'] = 1;
        $req['user_id'] = $user['id'];
        $req['name'] = $user['username'];
        $req['avator_image'] = $user['avatar'];
        $add = Video::insert($req);
        if ($add) {
            $this->success('信息已提交，等待审核结果');
        } else {
            $this->error('网络错误或系统错误');
        }
    }

    //视频列表
    public function videos(Request $request)
    {
        $req = $this->request->post();
        $res = Video::with('publisher')->where(['class' => 1, 'tong' => 1])->orderRaw('rand()')->limit($req['every'])->select()->toArray();
        $top = [];
        $communityid = Topping::where(['list' => 1])->column('communityid');
        foreach ($communityid as $item) {
            $top[] = Video::where(['id' => $item])->find();
        }
        if ($request->header('token') !== null) {
            $user = $this->auth->getUserinfo();
            foreach ($res as &$value) {
                $find = Thumbs::where(['userid' => $user['id'], 'thumbsid' => $value['id'], 'class' => 2])->find();
                if ($find) {
                    $value['give'] = 1;
                } else {
                    $value['give'] = 0;
                }
            }
        }
        return json(['msg' => '图片', 'data' => $res, 'top' => $top, 'code' => 200])->header(['Content-Type' => 'application/json']);
    }

    //点击头像信息
    public function personal(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＤＯＮ＇Ｔ　ＧＥＴ');
        }
        $req = $request->post();
        $community = Video::where('id', $req['id'])->find();
        //用户
        if ($community['status'] == 0) {
            $user = \app\admin\model\User::where('id', $community['user_id'])->find();
            $user['count'] = Video::where(['status' => 0, 'user_id' => $community['user_id']])->count();
            $user['u'] = 0;
        } else {
            //后台
            $data = Publisher::where('id', $community['user_id'])->find()->toArray();
            $user['username'] = $data['name'];
            $user['avatar'] = $data['image'];
            $user['fensi'] = $data['fensi'];
            $user['ganzhu'] = $data['guanzhu'];
            $user['count'] = Video::where(['status' => 1, 'user_id' => $community['user_id']])->count();
            $user['u'] = 1;
            $user['id'] = $data['id'];
            $user['level'] =$data['level'];
        }
        $communitys = Video::with('publisher')->where(['status' => $community['status'], 'user_id' => $community['user_id'], 'tong' => 1])->where('class', 'neq', 0)->page($req['current'], $req['every'])->select();
        $communitys ? $communitys = $communitys->toArray() : '';
        $this->success('信息返回', ['user' => $user, 'community' => $communitys], 200);
    }

    //点击关注列表
    public function click_follow(Request $request)
    {

        if ( ! $request->isPost()) {
            $this->error('ＤＯＮ＇Ｔ　ＧＥＴ');
        }
        $req = $request->post();
        if ($req['class'] == '0') {
            //用户
            $user = \app\admin\model\User::where('id', $req['id'])->find();
            $user['count'] = Video::where(['status' => 0, 'user_id' => $req['id']])->count();
            $user['u'] = 0;
        } else {
            //后台
            $data = Publisher::where('id', $req['id'])->find()->toArray();
            $user['username'] = $data['name'];
            $user['avatar'] = $data['image'];
            $user['fensi'] = $data['fensi'];
            $user['guanzhu'] = $data['guanzhu'];
            $user['count'] = Video::where(['status' => 1, 'user_id' => $req['id']])->count();
            $user['u'] = 1;
            $user['id'] = $data['id'];
            $user['level'] =$data['level'];
        }
        $communitys = Video::with('publisher')->where(['status' => $req['class'], 'user_id' => $req['id'], 'tong' => 1])->page($req['current'], $req['every'])->select();
        $communitys ? $communitys = $communitys->toArray() : '';
        $this->success('信息返回', ['user' => $user, 'community' => $communitys], 200);
    }

    //社区内容详情
    public function xq_community(Request $request)
    {
        if ( ! $request->isGet()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＧＥＴ');
        }
        $req = $request->get();
        $res = Video::get($req['id']);
        if ($request->header('token') !== null) {
            $user = $this->auth->getUserinfo();
            $find = Thumbs::where(['userid' => $user['id'], 'thumbsid' => $res['id'], 'class' => 2])->find();
            if ($find) {
                $res['give'] = 1;
            } else {
                $res['give'] = 0;
            }

        }
        if ($res) {
            $this->success('内容', $res, 200);
        } else {
            $this->error('系统错误', [], 100);
        }
    }

    //关注
    public function follow(Request $request)
    {
        if ( ! $request->isGet()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＧＥＴ');
        }
        $req = $request->get();
        $user = $this->auth->getUserinfo();
        $Relationship = new Relationship();
        $find = $Relationship->where(['user_id' => $user['id'], 'userid' => $req['id'], 'class' => $req['class']])->find();
        if ($find) {
            $this->error('此用户已关注', '', 100);
        }
        $res = $Relationship->save(['user_id' => $user['id'], 'userid' => $req['id'], 'class' => $req['class']]);
        if ($res) {
            \app\admin\model\User::where('id', $user['id'])->setInc('guanzhu', 1);
            \app\admin\model\User::where('id', $req['id'])->setInc('fensi', 1);
            $this->success('关注成功', '', 200);
        } else {
            $this->success('系统错误', '', 100);
        }

    }

    //关注显示
    public function followindex(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　post');
        }
        $req = $request->get();
        $user = $this->auth->getUserinfo();
        $res = [];
        $res = Relationship::where('user_id', $user['id'])->select()->toArray();
        foreach ($res as &$value) {
            //用户
            if ($value['class'] == 0) {
                $value['user'] = \app\admin\model\User::where('id', $value['userid'])->field('id,username name ,avatar')->find()->toArray();
                $value['user']['image'] = $value['user']['avatar_text'];
            }
            //后台
            if ($value['class'] == 1) {
                $value['user'] = Publisher::where('id', $value['userid'])->find()->toArray();

            }
        }
        $this->result('关注列表', $res, 200);


    }

    //上传文件（客户端用户发布图片、视频及用户修改个人头像）     
    public function upload(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＤＯＮ＇Ｔ　ＧＥＴ');
        }
        $files = $_FILES;
        $imageArr = array();
        foreach ($files as $file) {
            $imageName = $file['name'];
            //后缀名
            $ext = strtolower(substr(strrchr($imageName, '.'), 1));
            //保存文件名
            $fileName = uniqid();
            $tmp = $file['tmp_name'];
            //保存 = 路径 + 文件名 + 后缀名
            $imageSavePath = ROOT_PATH . 'public' . DS . 'uploads/images/' . $fileName . '.' . $ext;
            $info = move_uploaded_file($tmp, $imageSavePath);
            if ($info) {
                $path = "/uploads/images/" . $fileName . '.' . $ext;   
                array_push($imageArr, $path);
            }
        }
        //最终生成的字符串路径
        $imagePathStr = implode(',', $imageArr);
        $this->success('路径', $imagePathStr, 200);
    }

    //标签
    public function label()
    {
        $res = Label::all();
        $this->success('标签', $res, 200);
    }

    //观看视频
    public function edit(Request $request)
    {
        //暂时不限制观看视频
        $this->success('ok', '', 200);


        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＰＯＳＴ');
        }
        $allowall = Config::where('name', 'allowfree')->value('value');
        if ($allowall == '1') {
            //次数全部免费
            $this->success('ok', '', 200);
        }
        $user = $this->auth->getUser();
        $req = $request->post();
        //长视频
        if ($req['class'] == 0) {
            if (date('Y-m-d H:i:s') > $user['vip_time']) {
                if ($user->num <= 0) {
                    $this->error('您的长视频观看次数不足', '', 100);
                } else {
                    $res = \app\admin\model\User::where('id', $user->id)->setDec('num', 1);
                    if ($res) {
                        $this->success('ok', '', 200);
                    } else {
                        $this->success('error', '', 100);
                    }
                }

            } else {
                $this->success('ok', '', 200);
            }
        }
        //短视频
        if ($req['class'] == 1) {
            if (date('Y-m-d H:i:s') > $user['vip_time']) {
                if ($user->num_t <= 0) {
                    $this->error('您的长视频观看次数不足', '', 100);
                } else {
                    $res = \app\admin\model\User::where('id', $user->id)->setDec('num_t', 1);
                    if ($res) {
                        $this->success('ok', '', 200);
                    } else {
                        $this->success('error', '', 100);
                    }
                }

            } else {
                $this->success('ok', '', 200);
            }
        }
    }

    //点赞作品(社区)
    public function thumbs(Request $request)
    {
        if ( ! $request->isGet()) {
            $this->error('ＭＵＳＴ　ＢＥ　ＧＥＴ');
        }
        $user = $this->auth->getUser();
        $req = $request->get();
        $find = Thumbs::where(['userid' => $user['id'], 'thumbsid' => $req['id'], 'class' => 2])->find();
        if ($find) {
            $this->result('您已经点过赞啦！', '', 100);
        } else {
            $thumbs = new Thumbs();
            $res = $thumbs->save(['userid' => $user['id'], 'thumbsid' => $req['id'], 'class' => 2]);
        }
        if ($res) {
            $res = Video::where('id', $req['id'])->setInc('fabulous', 1);
            $res = Task::upload($user->id, 4);
            if ($res) {
                $this->success('ok', '', 200);
            }
        } else {
            $this->error('系统错误或网络错误', '', 100);
        }
    }
}
