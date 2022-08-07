<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Config;
use think\Db;

/**
 * 控制台
 *
 * @icon fa fa-dashboard
 * @remark 用于展示当前系统中的统计数据、统计报表及重要实时数据
 */
class Dashboard extends Backend
{

    /**
     * 控制台所有数据全部调用数据表 fa_shuju
     */
    public function index()
    {
        $seventtime = \fast\Date::unixtime('day', -7);
        $paylist = $createlist = [];
        for ($i = 0; $i < 7; $i++) {
            $day = date("Y-m-d", $seventtime + ($i * 86400));
            $createlist[$day] = mt_rand(20, 200);
            $paylist[$day] = mt_rand(1, mt_rand(1, $createlist[$day]));
        }
        $hooks = config('addons.hooks');
        $uploadmode = isset($hooks['upload_config_init']) && $hooks['upload_config_init'] ? implode(',', $hooks['upload_config_init']) : 'local';
        $addonComposerCfg = ROOT_PATH . '/vendor/karsonzhang/fastadmin-addons/composer.json';
        Config::parse($addonComposerCfg, "json", "composer");
        $config = Config::get("composer");
        $addonVersion = isset($config['version']) ? $config['version'] : __('Unknown');
        $res = db::table('fa_shuju')->find(1);      /*调用的数据表*/
        $this->view->assign([
            'totaluser' => $res['users'],           /*总会员数*/
            'totalviews' => $res['fangwens'],       /*总访问数/月*/
            'totalorder' => $res['orders'],         /*总订单数/月*/
            'totalorderamount' => $res['moneys'],   /*总金额/月*/
            'todayuserlogin' => $res['login'],      /*今日登录*/
            'todayusersignup' => $res['reg'],       /*今日注册*/
            'todayorder' => $res['order_j'],
            'unsettleorder' => $res['order_w'],
            'sevendnu' => $res['agent'],
            'sevendau' => $res['jine'],
            'video' => $res['video'],
            'photo' => $res['photo'],
            'dw' => $res['dw'],
            'av' => $res['av'],
            'tvideo' => $res['tvideo'],
            'now' => $res['now'],
            'paylist' => $paylist,
            'createlist' => $createlist,
            'addonversion' => $addonVersion,
            'uploadmode' => $uploadmode
        ]);

        return $this->view->fetch();
    }

}
