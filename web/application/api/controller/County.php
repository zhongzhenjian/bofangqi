<?php


namespace app\api\controller;


use app\common\controller\Api;
use app\common\model\Config;
use think\Db;

class County extends Api
{
    protected $noNeedLogin = ['*'];

    public function index()
    {
        $res = db::table('country_mobile_prefix')->select();
        $this->result('国际代码', $res, 200);
    }

    //是否全部取消
    public function allowfree()
    {
        $res = Config::where('name', 'allowfree')->value('value');
        $this->result('全部取消', $res, 200);
    }
    //支付
    public function pay()
    {
        $res = Config::where('name', 'pay')->value('value');
        $this->result('全部取消', $res, 200);
    }
    // public function video(){
    //   $res = db::table('fa_video')->where(['class'=>1])->order('create_time')->limit(60)->select();
    //   foreach($res as &$item){
    //         $all = suiji();
    //         $params['name'] = $all['name'];
    //         $params['avator_image'] = $all['image'];
    //         $params['user_id'] = $all['id'];
    //         $params['fabulous'] = mt_rand(101,6798);
    //         $params['browse'] = mt_rand(1087,67985);
    //         $params['tong'] = 1;
    //         $params['status'] =1;
    //         $params['class'] =1;
    //         $params['video'] = $item['url'];
    //         $params['video_image'] = $item['video_image'];
    //         db::table('fa_community')->insert($params);
    //   }
    // }
    public function video(){
        $res = db::table('fa_community')->where('comment',0)->limit(60)->select();
        foreach ($res as $value){
            db::table('fa_community')->where('id',$value['id'])->update(['comment'=>mt_rand(1,5)]);
        }
    echo count($res);
        
    }
}
