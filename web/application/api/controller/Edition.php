<?php


namespace app\api\controller;


use app\common\controller\Api;
use app\common\model\Config;

class Edition extends Api
{
    protected $noNeedLogin = ['*'];

    //版本号
    public function index()
    {
        static $allow_origin = ['http://www.baidu.com','http://www.baidu.com','http://www.baidu.com','http://www.baidu.com','http://www.baidu.com','http://www.baidu.com'];
        if(isset($_SERVER['HTTP_ORIGIN'])){
            $domain = $_SERVER['HTTP_ORIGIN'];
            if(in_array($domain,$allow_origin)){
                header('Access-Control-Allow-Origin:'.$domain);
            }
        }
        $res = \app\admin\model\Edition::order('version desc')->find();
        $res['website'] = Config::where('name', 'website')->value('value');
        $this->result('版本号', $res, 200);
    }

}
