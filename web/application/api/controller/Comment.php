<?php


namespace app\api\controller;


use app\admin\model\Dvideo;
use app\admin\model\Tvideo;
use app\admin\model\Video;
use app\common\controller\Api;
use app\common\model\Config;
use think\Request;
use app\admin\model\Comment as Comments;
use think\Db;

class Comment extends Api
{
    protected $noNeedLogin = ['*'];

    //社区评论查询全部
    public function community(Request $request)
    {
        if ( ! $request->isGet()) {
            $this->error('ＭＵＳＴ　ＢＥ ＧＥＴ', '', 100);
        }
        $req = $request->get();
        $count = Comments::where(['class' => $req['class'], 'community_id' => $req['id']])->count();
        if ($count < $req['num']) {
            $size = $req['num'] - $count;
            for ($i = 0; $i < $size; $i++) {
                $name = file_get_contents('name.txt');//将整个文件内容读入到一个字符串中
                $name = json_decode(mb_convert_encoding($name, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5'));//转换字符集（编码）
                $name = $name[array_rand($name)];
                $photo = file_get_contents('photo.txt');//将整个文件内容读入到一个字符串中
                $photo = json_decode(mb_convert_encoding($photo, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5'));//转换字符集（编码）
                $photo = $photo[array_rand($photo)];
                $comment = db::table('fa_text')->where(['class' => $req['class']])->orderRaw('rand()')->value('text');
                Comments::insert(['name' => $name, 'avator_image' => $photo, 'content' => $comment, 'community_id' => $req['id'], 'class' => $req['class'], 'creat_time' => date('Y-m_d H:i:s'),'level'=>mt_rand(0,2)]);
            }
        }
        $res = Comments::where(['class' => $req['class'], 'community_id' => $req['id'], 'tong' => 1, 'zd' => 0])->page($req['current'], $req['every'])->order('creat_time desc')->select();
        $res ? $res->toArray() : '';
        $top = Comments::where(['class' => $req['class'], 'community_id' => $req['id'], 'tong' => 1, 'zd' => 1])->select();
        $top ? $top->toArray() : '';
        return json(['msg' => '评论', 'data' => $res, 'top' => $top, 'code' => 200])->header(['Content-Type' => 'application/json']);
    }

    //视频评论查询
    public function video(Request $request)
    {
        if ( ! $request->isGet()) {
            $this->error('ＭＵＳＴ　ＢＥ ＧＥＴ', '', 100);
        }
        $req = $request->get();
        $count = Comments::where(['class' => 3, 'community_id' => $req['id']])->count();
        if ($count < $req['num']) {
            $size = $req['num'] - $count;
            for ($i = 0; $i < $size; $i++) {
                $name = file_get_contents('name.txt');//将整个文件内容读入到一个字符串中
                $name = json_decode(mb_convert_encoding($name, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5'));//转换字符集（编码）
                $name = $name[array_rand($name)];
                $photo = file_get_contents('photo.txt');//将整个文件内容读入到一个字符串中
                $photo = json_decode(mb_convert_encoding($photo, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5'));//转换字符集（编码）
                $photo = $photo[array_rand($photo)];
                $comment = db::table('fa_text')->where(['class' => 2])->orderRaw('rand()')->value('text');
                Comments::insert(['name' => $name, 'avator_image' => $photo, 'content' => $comment, 'community_id' => $req['id'], 'class' => 3, 'creat_time' => date('Y-m_d H:i:s'),'level'=>mt_rand(0,2)]);
            }
        }
        $res = Comments::where(['class' => 3, 'community_id' => $req['id'], 'tong' => 1])->page($req['current'], $req['every'])->order('creat_time desc')->select();
        $res ? $res->toArray() : '';
        $this->success('视频评论查询', $res, 200);
    }

    //小视频评论查询
    public function tvideo(Request $request)
    {
        if ( ! $request->isGet()) {
            $this->error('ＭＵＳＴ　ＢＥ ＧＥＴ', '', 100);
        }
        $req = $request->get();
        $count = Comments::where(['class' => 4, 'community_id' => $req['id']])->count();
        if ($count < $req['num']) {
            $size = $req['num'] - $count;
            for ($i = 0; $i < $size; $i++) {
                $name = file_get_contents('name.txt');//将整个文件内容读入到一个字符串中
                $name = json_decode(mb_convert_encoding($name, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5'));//转换字符集（编码）
                $name = $name[array_rand($name)];
                $photo = file_get_contents('photo.txt');//将整个文件内容读入到一个字符串中
                $photo = json_decode(mb_convert_encoding($photo, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5'));//转换字符集（编码）
                $photo = $photo[array_rand($photo)];
                $comment = db::table('fa_text')->where(['class' => 2])->orderRaw('rand()')->value('text');
                Comments::insert(['name' => $name, 'avator_image' => $photo, 'content' => $comment, 'community_id' => $req['id'], 'class' => 4, 'creat_time' => date('Y-m_d H:i:s'),'level'=>mt_rand(0,2)]);
            }
        }
        $res = Comments::where(['class' => 4, 'community_id' => $req['id'], 'tong' => 1])->page($req['current'], $req['every'])->order('creat_time desc')->select();
        $res ? $res->toArray() : '';
        $this->success('小视频评论查询', $res, 200);
    }

    //添加评论
    public function addcomment(Request $request)
    {
        if ( ! $request->isPost()) {
            $this->error('ＭＵＳＴ　ＢＥ ＰＯＳＴ', '', 100);
        }
        $req = $request->post();
        $user = $this->auth->getUserinfo();
        $data = array(
            'name' => $user['username'],
            'avator_image' => $user['avatar'],
            'class' => $req['class'],
            'community_id' => $req['community_id'],
            'content' => $req['content'],
            'tong' => 0,
            'creat_time' => date('Y-m-d H:i:s'),
            'status' => 1
        );
        $comments = new Comments();
        $res = $comments->save($data);
        if ($res) {
/*
        if($req['class']=='0'||$req['class']=='1'||$req['class']=='2'){
                Video::where(['id'=>$req['community_id']])->setInc('comment',1);
            }
            if($req['class']=='4'){
                Tvideo::where(['id'=>$req['community_id']])->setInc('comment',1);
            }
            if($req['class']=='3'){
                Dvideo::where(['id'=>$req['community_id']])->setInc('comments',1);
            }
*/
            $this->success('评论成功等待审核', '', 200);
        } else {
            $this->error('系统错误', '', 100);
        }
    }

    //社区浏览次数
    public function community_ll()
    {
        $req = $this->request->post();
        $res = \app\admin\model\Video::where('id', $req['id'])->setInc('browse', 1);
        if ($res) {
            $this->success('ok', '', 200);
        } else {
            $this->error('error', '', 100);
        }
    }

    //视频浏览
    public function video_ll()
    {
        $req = $this->request->post();
        Dvideo::where('id', $req['id'])->setInc('', 1);
    }

    //小视频浏览
    public function tvideo_ll()
    {

    }

    //公告
    public function gg()
    {
        $res = Config::where('name', 'ggg')->value('value');
        $this->result('公告', $res, 200);
    }

    //滚动条
    public function gdt()
    {
        $res = Config::where('name', 'gdt')->value('value');
        $this->result('滚动条', $res, 200);
    }
}
