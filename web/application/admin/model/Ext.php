<?php

namespace app\admin\model;

use think\Model;


class Ext extends Model
{


    // 表名
    protected $name = 'extension';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];


    public function user()
    {
        return $this->belongsTo('User', 'userid', 'id', [], 'LEFT')->setEagerlyType(0);
    }

    public function users()
    {
        return $this->belongsTo('User', 'user_id', 'id', [], 'LEFT')->setEagerlyType(0);

    }
}
