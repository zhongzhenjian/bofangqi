<?php

namespace app\admin\model;

use think\Model;


class Leave extends Model
{


    // 表名
    protected $name = 'leaving';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'datetime';

    // 定义时间戳字段名
    protected $updateTime = false;
    protected $deleteTime = false;
    protected $resultSetType = 'collection';

    // 追加属性
    protected $append = [

    ];


    public function user()
    {
        return $this->belongsTo('User', 'userid', 'id', [], 'LEFT')->setEagerlyType(0);
    }

    public function returns()
    {
        return $this->hasMany('Returns', 'leavingid', 'id', [], 'LEFT');
    }
}
