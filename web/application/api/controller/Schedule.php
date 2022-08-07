<?php


namespace app\api\controller;

use app\common\model\Config;
use think\Db;
use app\common\controller\Api;
use app\admin\model\Video;

class Schedule extends Api
{
    protected $noNeedLogin = ['*'];

    //两点
    public function two()
    {
        $res = db::table('fa_community')->where('status', 1)->where('class', '>', 0)->select();
        foreach ($res as &$value) {
            if ($value['class'] == 1) {
                $value['browse'] = mt_rand(2999, 9999);
            }
            if ($value['class'] == 2) {
                $value['browse'] = mt_rand(1999, 4999);
            }
            if ($value['class'] == 4) {
                $value['browse'] = mt_rand(99, 699);
            }
        }
        $video = new Video();
        $video->saveAll($res);
    }

    //9点
    public function nine()
    {
        $res = db::table('fa_community')->where('status', 1)->where('class', '>', 0)->select();
        foreach ($res as &$value) {
            if ($value['class'] == 1) {
                $value['browse'] = mt_rand(9999, 29999);
            }
            if ($value['class'] == 2) {
                $value['browse'] = mt_rand(1999, 9999);
            }
            if ($value['class'] == 4) {
                $value['browse'] = mt_rand(0, 999);
            }
        }
        $video = new Video();
        $video->saveAll($res);

    }

    //19
    public function nineteen()
    {
        $res = db::table('fa_community')->where('status', 1)->where('class', '>', 0)->select();
        foreach ($res as &$value) {
            if ($value['class'] == 1) {
                $value['browse'] = mt_rand(9999, 69999);
            }
            if ($value['class'] == 2) {
                $value['browse'] = mt_rand(1999, 29999);
            }
            if ($value['class'] == 4) {
                $value['browse'] = mt_rand(0, 1499);
            }
        }
        $video = new Video();
        $video->saveAll($res);
    }

    //两点短文
    public function two_dw()
    {
        $res = db::table('fa_community')->where('status', 1)->where('class', 0)->select();
        foreach ($res as &$value) {
            $value['browse'] = mt_rand(199, 599);
        }
        $video = new Video();
        $video->saveAll($res);
    }

    //九点短文
    public function nine_dw()
    {
        $res = db::table('fa_community')->where('status', 1)->where('class', 0)->select();
        foreach ($res as &$value) {
            $value['browse'] = mt_rand(199, 799);
        }
        $video = new Video();
        $video->saveAll($res);
    }

    //十九点短文
    public function nineteen_dw()
    {
        $res = db::table('fa_community')->where('status', 1)->where('class', 0)->select();
        foreach ($res as &$value) {
            $value['browse'] = mt_rand(199, 599);
        }
        $video = new Video();
        $video->saveAll($res);
    }

    //增加 1 - 15
    public function add()
    {
        $res = db::table('fa_community')->where('status', 1)->select();
        foreach ($res as $value) {
            db::table('fa_community')->where('id', $value['id'])->setInc('browse', mt_rand(1, 15));
        }
    }

    //每天次数添加
    public function mt()
    {
        $cs = Config::where('name', 'mrgk')->value('value');
        $xcs = Config::where('name', 'tvideo')->value('value');
        $user = new \app\admin\model\User();
        $res = collection($user->select())->toArray();
        foreach ($res as &$value) {
            db::table('fa_user')->where('id',$value['id'])->update(['num'=>$cs,'num_t'=>$xcs]);
        }
    }
    //数据增加
    public function zz(){
        $res = db::table('fa_shuju')->select();
        $data = [
            "users" => $res[0]["users"]+$res[1]["users"],
            "fangwens" => $res[0]["fangwens"]+$res[1]["fangwens"],
            "orders" => $res[0]["orders"]+$res[1]["orders"],
            "moneys" => $res[0]["moneys"]+$res[1]["moneys"],
            "reg" => $res[0]["reg"]+$res[1]["reg"],
            "login" =>$res[0]["login"]+$res[1]["login"],
            "order_j" => $res[0]["order_j"]+$res[1]["order_j"],
            "order_w" =>  $res[0]["order_w"] +$res[1]["order_w"],
            "agent" => $res[0]["agent"]+$res[1]["agent"],
            "jine" => $res[0]["jine"]+$res[1]["jine"],
            "dw" => $res[0]["dw"]+$res[1]["dw"],
            "video" => $res[0]["video"]+$res[1]["video"],
            "photo" => $res[0]["photo"]+$res[1]["photo"],
            "av" => $res[0]["av"]+$res[1]["av"],
            "tvideo" =>$res[0]["tvideo"]+$res[1]["tvideo"],
            "now" => $res[0]["now"]+$res[1]["now"],
        ];
        db::table('fa_shuju')->where('id',1)->update($data);
    }
}
