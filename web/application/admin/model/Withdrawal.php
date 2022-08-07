<?php

namespace app\admin\model;

use think\Model;


class Withdrawal extends Model
{


    // 表名
    protected $name = 'withdrawal';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'datetime';

    // 定义时间戳字段名
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];


    public function user()
    {
        return $this->belongsTo('User', 'userId', 'id', [], 'LEFT')->setEagerlyType(0);
    }

//    //0支付宝
//    public function zfb()
//    {
//        return $this->belongsTo('Bang', 'userId', 'userid', [], 'Left')->where('fl', 0)->setEagerlyType(0);
//
//    }
//
//    //1-银行卡
//    public function bank()
//    {
//        return $this->belongsTo('Bang', 'userId', 'userid', [], 'Left')->where('fl', 1)->setEagerlyType(0);
//
//    }
}
